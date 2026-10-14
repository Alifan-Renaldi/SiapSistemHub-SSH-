<?php

use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * Render view jadi PDF dan langsung download/preview
 *
 * @param string $view      Nama view
 * @param array  $data      Data untuk view
 * @param string $filename  Nama file output
 * @param bool   $download  true = download, false = inline (preview)
 */
function renderPdf(string $view, array $data = [], string $filename = 'document.pdf', bool $download = true)
{
    ini_set('memory_limit', '512M');
    ini_set('max_execution_time', 120);
    ini_set('pcre.backtrack_limit', '500000');
    
    $config = config('Pdf');

    $options = new Options();
    $options->set('defaultFont', $config->defaultFont);
    // Remote fetching MUST stay disabled: on a single-worker dev server, Dompdf
    // requesting images over HTTP from this same server deadlocks the download.
    // All views must reference local file paths (see pdf_local_image()).
    $options->set('isRemoteEnabled', false);
    $options->set('chroot', FCPATH);

    $dompdf = new Dompdf($options);
    unset($options);

    $dompdf->setPaper($config->defaultPaperSize, $config->defaultPaperOrientation);

    // Ambil margin dari config
    $style = "<style>@page { margin: {$config->marginTop}mm {$config->marginRight}mm {$config->marginBottom}mm {$config->marginLeft}mm; }</style>";
    unset($config);

    // Render view then free data
    $html = view($view, $data);
    unset($data);

    $dompdf->loadHtml($style . $html);
    unset($html, $style);

    $dompdf->render();

    // Bersihkan semua output buffer agar tidak ada byte stray
    while (ob_get_level() > 0) {
        ob_end_clean();
    }

    $dompdf->stream($filename, [
        "Attachment" => $download
    ]);
    unset($dompdf);
}

/**
 * Generate PDF dan return sebagai CI4 Response object.
 * Kompatibel dengan semua browser termasuk mobile (Chrome Android, Safari iOS).
 *
 * Berbeda dengan renderPdf() yang menggunakan Dompdf::stream() langsung,
 * fungsi ini mengembalikan Response object sehingga header HTTP terkirim
 * dengan benar melalui framework — menghindari masalah "kode hash" di mobile.
 *
 * @param string $view      Nama view
 * @param array  $data      Data untuk view
 * @param string $filename  Nama file output
 * @param bool   $download  true = download (attachment), false = inline (preview)
 * @return \CodeIgniter\HTTP\ResponseInterface
 */
function streamPdf(string $view, array $data = [], string $filename = 'document.pdf', bool $download = true): \CodeIgniter\HTTP\ResponseInterface
{
    ini_set('memory_limit', '512M');
    ini_set('max_execution_time', 120);
    ini_set('pcre.backtrack_limit', '500000');

    $config = config('Pdf');

    $options = new Options();
    $options->set('defaultFont', $config->defaultFont);
    // Remote fetching MUST stay disabled: on a single-worker dev server, Dompdf
    // requesting images over HTTP from this same server deadlocks the download.
    // All views must reference local file paths (see pdf_local_image()).
    $options->set('isRemoteEnabled', false);
    $options->set('chroot', FCPATH);

    $dompdf = new Dompdf($options);
    unset($options);

    $dompdf->setPaper($config->defaultPaperSize, $config->defaultPaperOrientation);

    // Ambil margin dari config
    $style = "<style>@page { margin: {$config->marginTop}mm {$config->marginRight}mm {$config->marginBottom}mm {$config->marginLeft}mm; }</style>";
    unset($config);

    // Render view then free data
    $html = view($view, $data);
    unset($data);

    $dompdf->loadHtml($style . $html);
    unset($html, $style);

    $dompdf->render();

    $pdfOutput = $dompdf->output();
    unset($dompdf);

    // Bersihkan semua output buffer agar tidak ada byte stray
    // yang mencemari binary PDF (penyebab "kode hash" di mobile)
    while (ob_get_level() > 0) {
        ob_end_clean();
    }

    $disposition = $download ? 'attachment' : 'inline';
    $safeFilename = rawurlencode($filename);

    $response = service('response');
    return $response
        ->setStatusCode(200)
        ->setHeader('Content-Type', 'application/pdf')
        ->setHeader('Content-Transfer-Encoding', 'binary')
        ->setHeader('Content-Disposition', $disposition . '; filename="' . $filename . '"; filename*=UTF-8\'\'' . $safeFilename)
        ->setHeader('Content-Length', (string) strlen($pdfOutput))
        ->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
        ->setHeader('Pragma', 'no-cache')
        ->setHeader('Expires', '0')
        ->setHeader('Accept-Ranges', 'none')
        ->setHeader('Accept-Ranges', 'none')
        ->setHeader('X-Content-Type-Options', 'nosniff')
        ->setBody($pdfOutput);
}

/**
 * Resolve a relative path (relative to FCPATH) into an absolute local filesystem
 * path for use in <img src> inside Dompdf-rendered views.
 *
 * Dompdf must never fetch images over HTTP from this server (deadlock risk on
 * single-worker dev setups) — always pass local paths resolved by this helper.
 *
 * @param string $relativePath e.g. 'assets/uploads/survey/foto.jpg'
 * @return string|null Absolute path if the file exists, null otherwise
 */
function pdf_local_image(string $relativePath): ?string
{
    if ($relativePath === '') {
        return null;
    }

    $path = FCPATH . ltrim(str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $relativePath), DIRECTORY_SEPARATOR);
    $real = realpath($path);

    if ($real === false || stripos($real, realpath(FCPATH)) !== 0) {
        return null;
    }

    return is_file($real) ? $real : null;
}
