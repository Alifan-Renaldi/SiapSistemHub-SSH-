<?php

use CodeIgniter\Database\Database;

/**
 * Bersihkan input dari potensi XSS
 */
function xssclean($post)
{
    $rtn = true;
    if ($post) {
        foreach ($post as $key => $data) {
            if (is_array($data)) {
                $rtn = xssclean($data);
                if (!$rtn) {
                    break;
                }
            } else {
                if (preg_match("/</i", $data)) {
                    $rtn = false;
                }
            }
        }
    }
    return $rtn;
}

/**
 * Escape output HTML
 */
function output($data)
{
    return isset($data) ? esc($data) : '';
}

/**
 * Konversi string titik ke koordinat array
 */
function pointStringToCoordinates($pointString)
{
    $coordinates = explode(" ", $pointString);
    return ["x" => $coordinates[0], "y" => $coordinates[1]];
}

/**
 * Cek apakah titik berada tepat di vertex
 */
function pointOnVertex($point, $vertices)
{
    foreach ($vertices as $vertex) {
        if ($point == $vertex) {
            return true;
        }
    }
    return false;
}

/**
 * Cek apakah titik berada di dalam polygon
 */
function pointInPolygon($point, $polygon, $pointOnVertex = true)
{
    $point = pointStringToCoordinates($point);
    $vertices = [];

    foreach ($polygon as $vertex) {
        $vertices[] = pointStringToCoordinates($vertex);
    }

    if ($pointOnVertex && pointOnVertex($point, $vertices)) {
        return "vertex";
    }

    $intersections = 0;
    $vertices_count = count($vertices);
    for ($i = 1; $i < $vertices_count; $i++) {
        $vertex1 = $vertices[$i - 1];
        $vertex2 = $vertices[$i];

        if (
            $vertex1['y'] == $vertex2['y'] &&
            $vertex1['y'] == $point['y'] &&
            $point['x'] > min($vertex1['x'], $vertex2['x']) &&
            $point['x'] < max($vertex1['x'], $vertex2['x'])
        ) {
            return "boundary";
        }

        if (
            $point['y'] > min($vertex1['y'], $vertex2['y']) &&
            $point['y'] <= max($vertex1['y'], $vertex2['y']) &&
            $point['x'] <= max($vertex1['x'], $vertex2['x']) &&
            $vertex1['y'] != $vertex2['y']
        ) {
            $xinters = ($point['y'] - $vertex1['y']) * ($vertex2['x'] - $vertex1['x']) /
                ($vertex2['y'] - $vertex1['y']) + $vertex1['x'];

            if ($xinters == $point['x']) {
                return "boundary";
            }

            if ($vertex1['x'] == $vertex2['x'] || $point['x'] <= $xinters) {
                $intersections++;
            }
        }
    }

    return ($intersections % 2 != 0) ? "inside" : "outside";
}

/**
 * Ambil data konfigurasi dari tabel settings
 */
function sitedata()
{
    $db = \Config\Database::connect();
    $builder = $db->table('settings');
    $query = $builder->get();
    $siteinfo = $query->getResultArray();

    return count($siteinfo) >= 1 ? $siteinfo[0] : [];
}

/**
 * Cek hak akses user terhadap suatu link
 */
function userpermission($link)
{
    $permissions = session()->get('permissions');
    return is_array($permissions) && in_array($link, $permissions);
}

if (!function_exists('dateToString')) {
    function dateToString($date, $format = 'Y-m-d') {
        if (empty($date)) {
            return '-';
        }

        return date($format, strtotime($date));
    }
}

if (!function_exists('capitalEachWord')) {
    /**
     * Title Case per kata: huruf pertama tiap kata KAPITAL, sisa huruf menjadi kecil.
     * Contoh: "JAWA BARAT" => "Jawa Barat", "KABUPATEN LAMPUNG SELATAN" => "Kabupaten Lampung Selatan"
     *
     * @param  string|null $value
     * @return string|null
     */
    function capitalEachWord($value)
    {
        if ($value === null || $value === '') {
            return $value;
        }

        $value = (string) $value;

        // Placeholder dibiarkan apa adanya
        if (trim($value) === '-' || strtoupper(trim($value)) === 'N/A') {
            return $value;
        }

        return mb_convert_case(mb_strtolower($value, 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
    }
}

// Alias: nama yang sama dengan fungsi JS capitalizeEachWord() di form BAP/Loan/User/Survey
if (!function_exists('capitalizeEachWord')) {
    function capitalizeEachWord($value)
    {
        return capitalEachWord($value);
    }
}

if (!function_exists('dateTimeFormat')) {
    /**
     * Ubah format timestamp database (Y-m-d H:i:s) menjadi format tampilan
     * (default: d-m-Y H:i:s). Hanya susunan tanggal yang diubah,
     * jam:menit:detik tetap sama persis.
     *
     * Contoh: '2026-09-29 14:30:45' => '29-09-2026 14:30:45'
     *
     * @param string|null $dateTime Nilai timestamp dari database
     * @param string      $format   Format keluaran
     * @return string '-' bila kosong/zero-date, nilai asli bila tidak bisa diparse
     */
    function dateTimeFormat($dateTime, string $format = 'd-m-Y (H:i:s)'): string
    {
        $dateTime = trim((string) $dateTime);

        if ($dateTime === '' || $dateTime === '0000-00-00 00:00:00' || $dateTime === '0000-00-00') {
            return '-';
        }

        // Jalur utama: hanya untuk yang persis format DB (Y-m-d H:i:s).
        // Tanda "!" mencegah PHP mengisi bagian waktu yang tidak ada dengan
        // waktu sekarang, sehingga hasilnya selalu konsisten.
        $dt = \DateTime::createFromFormat('!Y-m-d H:i:s', $dateTime);

        if ($dt === false || \DateTime::getLastErrors() !== false) {
            // Fallback untuk format lain (Y-m-d, d-m-Y, ISO 8601, dsb)
            $timestamp = strtotime($dateTime);

            if ($timestamp === false) {
                return $dateTime; // bukan tanggal valid -> kembalikan apa adanya
            }

            $dt = (new \DateTime())->setTimestamp($timestamp);
        }

        return $dt->format($format);
    }
}
