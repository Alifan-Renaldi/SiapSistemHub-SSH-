<?php

namespace Config;

use CodeIgniter\Config\BaseService;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends BaseService
{
    /*
     * public static function example($getShared = true)
     * {
     *     if ($getShared) {
     *         return static::getSharedInstance('example');
     *     }
     *
     *     return new \CodeIgniter\Example();
     * }
     */
    public static function dompdf(?Pdf $config = null, bool $getShared = true): Dompdf
    {
        if ($getShared) {
            return static::getSharedInstance('dompdf', $config);
        }

        $config = $config ?? config('Pdf');

        $options = new Options();
        $options->set('defaultFont', $config->defaultFont);

        $dompdf = new Dompdf($options);

        // Atur ukuran kertas + orientasi dari config
        $dompdf->setPaper($config->defaultPaperSize, $config->defaultPaperOrientation);

        // Set margin default lewat CSS @page
        $margin = "margin: {$config->marginTop}mm {$config->marginRight}mm {$config->marginBottom}mm {$config->marginLeft}mm;";
        $dompdf->loadHtml('<style>@page {' . $margin . '}</style>');

        return $dompdf;
    }
}
