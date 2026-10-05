<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Pdf extends BaseConfig
{
    public $defaultFont = 'Arial';
    public $defaultPaperSize = 'A4';
    public $defaultPaperOrientation = 'portrait';
    public $dpi = 96;
    public $tempDir = WRITEPATH . 'cache/';

    // Default margin (mm)
    public $marginTop = 5;
    public $marginRight = 3;
    public $marginBottom = 2;
    public $marginLeft = 2;
}
