<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Checklist</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: auto;
            padding: 20px;
            padding-right: 10px;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 5px;
            text-align: left;
            border: 2px solid #000;
            font-size: 12px;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        /* Flexbox layout for two columns */
        .two-column-table {
            display: flex;
            justify-content: space-between;
            gap: 20px; /* Space between the two tables */
        }
        .two-column-table div {
            flex: 1;
            min-width: 0; /* Prevents overflow */
        }
        .two-column-table th, .two-column-table td {
            padding: 5px;
            border: 2px solid #000;
            font-size: 12px;
        }
        .two-column-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        /* Adjust photo grid for print */
        .photo-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-top: 20px;
        }
        .photo-box {
            border: 2px solid #000;
            padding: 10px;
            text-align: center;
        }
        .photo-box img {
            max-width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .text-photo {
            text-align: center;
        }
        .text-photo strong {
            display: block;
            margin-bottom: 10px;
        }
        .logo {
            position: absolute;
            top: 20px;
            right: 16px;
            width: 130px;
            height: auto;
        }
        .number {
            position: absolute;
            top: 15px;
            left: 15px;
            width: 100px;
            height: auto;
            font-weight: normal;
        }

        /* Print-specific styles */
        @media print {
            body {
                font-size: 12px;
            }
            .container {
                width: 100%;
                margin: 0;
                padding: 10px;
                padding-right: 20px;
            }
            .two-column-table {
                display: flex;
                justify-content: space-between;
                gap: 20px;
                margin-bottom: 20px;
            }
            .photo-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }
            th, td {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h4 class="number"><?= esc($invdetails[0]['iv_code']); ?></h4>
        <img src="<?= base_url('assets/uploads/logo_bap.png') ?>" alt="Logo" class="logo">
        <h1>Data Kelengkapan Inventaris</h1>
        <!-- First section of the table -->
        <div style="margin-right: 10px;">
            <table>
                <tr>
                    <th style="width: 50%;">Nomor Polisi</th>
                    <td><?= esc($invdetails[0]['iv_nopol']); ?></td>
                </tr>
                <tr>
                    <th style="width: 50%;">Tipe Mobil</th>
                    <td><?= esc($invdetails[0]['iv_jenis']); ?></td>
                </tr>
                <tr>
                    <th style="width: 50%;">Tahun Mobil</th>
                    <td><?= esc($invdetails[0]['iv_tahun']); ?></td>
                </tr>
            </table>
        </div>

        <!-- Two-column layout for the second section -->
        <div class="two-column-table" style="margin-right: 10px;">
            <div>
                <table>
                    <tr>
                        <th>STNK</th>
                        <td><?= esc($invdetails[0]['iv_stnk']); ?></td>
                    </tr>
                    <tr>
                        <th>KIR</th>
                        <td><?= esc($invdetails[0]['iv_kir']); ?></td>
                    </tr>
                    <tr>
                        <th>Dongkrak</th>
                        <td><?= esc($invdetails[0]['iv_dongkrak']); ?></td>
                    </tr>
                    <tr>
                        <th>Kunci Roda</th>
                        <td><?= esc($invdetails[0]['iv_kunci']); ?></td>
                    </tr>
                    <tr>
                        <th>Stang/Stick Kunci Roda</th>
                        <td><?= esc($invdetails[0]['iv_stang']); ?></td>
                    </tr>
                    <tr>
                        <th>Spanner</th>
                        <td><?= esc($invdetails[0]['iv_spanner']); ?></td>
                    </tr>
                    <tr>
                        <th>Ban Serep</th>
                        <td><?= esc($invdetails[0]['iv_serep']); ?></td>
                    </tr>
                    <tr>
                        <th>Gantungan Ban Serep</th>
                        <td><?= esc($invdetails[0]['iv_gantungan']); ?></td>
                    </tr>
                    <tr>
                        <th>RAM (Kanan/Kiri)</th>
                        <td><?= esc($invdetails[0]['iv_ramkk']); ?></td>
                    </tr>
                    <tr>
                        <th>RAM (Depan/Belakang)</th>
                        <td><?= esc($invdetails[0]['iv_ramdb']); ?></td>
                    </tr>
                </table>
            </div>
            <div>
                <table>
                    <tr>
                        <th>Tempat Tidur Kabin</th>
                        <td><?= esc($invdetails[0]['iv_kabin']); ?></td>
                    </tr>
                    <tr>
                        <th>Karpet Depan (R/L)</th>
                        <td><?= esc($invdetails[0]['iv_karpetd']); ?></td>
                    </tr>
                    <tr>
                        <th>Karpet Belakang (R/L)</th>
                        <td><?= esc($invdetails[0]['iv_karpetb']); ?></td>
                    </tr>
                    <tr>
                        <th>Tali Tambang (3 Gulung)</th>
                        <td><?= esc($invdetails[0]['iv_tambang']); ?></td>
                    </tr>
                    <tr>
                        <th>Terpal Tarpolin (1 Lembar)</th>
                        <td><?= esc($invdetails[0]['iv_tarpolin']); ?></td>
                    </tr>
                    <tr>
                        <th>Terpal Plastik (1 Lembar)</th>
                        <td><?= esc($invdetails[0]['iv_plastik']); ?></td>
                    </tr>
                    <tr>
                        <th>Terpal Lidah (2 Lembar)</th>
                        <td><?= esc($invdetails[0]['iv_lidah']); ?></td>
                    </tr>
                    <tr>
                        <th>Badong</th>
                        <td><?= esc($invdetails[0]['iv_badong']); ?></td>
                    </tr>
                    <tr>
                        <th>Pipa Kojong</th>
                        <td><?= esc($invdetails[0]['iv_kojong']); ?></td>
                    </tr>
                    <tr>
                        <th>Jumlah Pipa Kojong</th>
                         <td><?= esc($invdetails[0]['iv_jumlah']); ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div style="margin: 20px 0; border: 2px solid #000; border-radius: 5px; padding: 15px; background-color: #f9f9f9;margin-right: 10px;">
            <th style="text-align: left; padding: 10px; width: 30%; font-weight: bold; font-size: 12px; color: #333; border-bottom: 1px solid #ddd;">CATATAN :</th>
            <td style="padding: 10px; font-size: 12px; color: #555; border-bottom: 1px solid #ddd;"><?= esc($invdetails[0]['iv_keterangan']); ?></td>
        </div>

        <!-- Display photos section as a puzzle (4 boxes) -->
        <div class="photo-grid">
            <?php
                $relativeUploadPath = 'assets/uploads/vehicle_invent/';
                $baseUrl = rtrim(base_url(), '/');
                $fullUploadUrl = $baseUrl . '/' . $relativeUploadPath;
                $baseUrlPath = parse_url($baseUrl, PHP_URL_PATH);
                $serverBasePath = $_SERVER['DOCUMENT_ROOT'] . $baseUrlPath;

                function getImageWithCacheBusting($filename, $fullUploadUrl, $serverBasePath, $baseUrl) {
                    if (empty($filename)) return null;
                    $webUrl = $fullUploadUrl . $filename;
                    $serverPath = str_replace($baseUrl, $serverBasePath, $webUrl);

                    clearstatcache();

                    if (file_exists($serverPath)) {
                        $mod_time = filemtime($serverPath);
                        return $webUrl . '?' . $mod_time;
                    }
                    return null;
                }
            ?>

            <!-- Foto Depan -->
            <div class="text-photo">
                <strong>Foto Sisi Depan Mobil</strong>
                <div class="photo-box">
                <?php
                    $foto_dpn = trim($invdetails[0]['foto_dpn'] ?? '');
                    $imageUrl_dpn = getImageWithCacheBusting($foto_dpn, $fullUploadUrl, $serverBasePath, $baseUrl);

                    if ($imageUrl_dpn) { ?>
                        <img src="<?= $imageUrl_dpn ?>" alt="Foto Depan" class="print-image">
                    <?php } else if (!empty($foto_dpn)) { ?>
                        <div class="no-photo">
                            Foto tidak tersedia (<?= htmlspecialchars($foto_dpn) ?>)
                            <div style="font-size:10px; color:#888; margin-top:5px;">
                                Server Path: <?= htmlspecialchars(str_replace($baseUrl, $serverBasePath, $fullUploadUrl . $foto_dpn)) ?><br>
                                Web URL: <?= htmlspecialchars($fullUploadUrl . $foto_dpn) ?>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="no-photo">Tidak ada nama file foto.</div>
                    <?php } ?>
                </div>
            </div>

            <!-- Foto Belakang -->
            <div class="text-photo" style="margin-right: 10px;">
                <strong>Foto Sisi Belakang Mobil</strong>
                <div class="photo-box">
                <?php
                    $foto_blk = trim($invdetails[0]['foto_blk'] ?? '');
                    $imageUrl_blk = getImageWithCacheBusting($foto_blk, $fullUploadUrl, $serverBasePath, $baseUrl);

                    if ($imageUrl_blk) { ?>
                        <img src="<?= $imageUrl_blk ?>" alt="Foto Belakang" class="print-image">
                    <?php } else if (!empty($foto_blk)) { ?>
                        <div class="no-photo">
                            Foto tidak tersedia (<?= htmlspecialchars($foto_blk) ?>)
                            <div style="font-size:10px; color:#888; margin-top:5px;">
                                Server Path: <?= htmlspecialchars(str_replace($baseUrl, $serverBasePath, $fullUploadUrl . $foto_blk)) ?><br>
                                Web URL: <?= htmlspecialchars($fullUploadUrl . $foto_blk) ?>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="no-photo">Tidak ada nama file foto.</div>
                    <?php } ?>
                </div>
            </div>

            <!-- Foto Kiri -->
            <div class="text-photo" style="margin-top: 20px;">
                <strong>Foto Sisi Kiri Mobil</strong>
                <div class="photo-box">
                <?php
                    $foto_kiri = trim($invdetails[0]['foto_kiri'] ?? '');
                    $imageUrl_kiri = getImageWithCacheBusting($foto_kiri, $fullUploadUrl, $serverBasePath, $baseUrl);

                    if ($imageUrl_kiri) { ?>
                        <img src="<?= $imageUrl_kiri ?>" alt="Foto Kiri" class="print-image">
                    <?php } else if (!empty($foto_kiri)) { ?>
                        <div class="no-photo">
                            Foto tidak tersedia (<?= htmlspecialchars($foto_kiri) ?>)
                            <div style="font-size:10px; color:#888; margin-top:5px;">
                                Server Path: <?= htmlspecialchars(str_replace($baseUrl, $serverBasePath, $fullUploadUrl . $foto_kiri)) ?><br>
                                Web URL: <?= htmlspecialchars($fullUploadUrl . $foto_kiri) ?>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="no-photo">Tidak ada nama file foto.</div>
                    <?php } ?>
                </div>
            </div>

            <!-- Foto Kanan -->
            <div class="text-photo" style="margin-right: 10px; margin-top: 212px;">
                <strong>Foto Sisi Kanan Mobil</strong>
                <div class="photo-box">
                <?php
                    $foto_kanan = trim($invdetails[0]['foto_kanan'] ?? '');
                    $imageUrl_kanan = getImageWithCacheBusting($foto_kanan, $fullUploadUrl, $serverBasePath, $baseUrl);

                    if ($imageUrl_kanan) { ?>
                        <img src="<?= $imageUrl_kanan ?>" alt="Foto Kanan" class="print-image">
                    <?php } else if (!empty($foto_kanan)) { ?>
                        <div class="no-photo">
                            Foto tidak tersedia (<?= htmlspecialchars($foto_kanan) ?>)
                            <div style="font-size:10px; color:#888; margin-top:5px;">
                                Server Path: <?= htmlspecialchars(str_replace($baseUrl, $serverBasePath, $fullUploadUrl . $foto_kanan)) ?><br>
                                Web URL: <?= htmlspecialchars($fullUploadUrl . $foto_kanan) ?>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="no-photo">Tidak ada nama file foto.</div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <h1 style="color: red;">DILARANG MEMINDAHKAN / MENCABUT KERTAS INI.</h1>
                <div style="position: absolute; bottom: 30px; left: 15px; font-size: 12px; color: #555;">
                    Terakhir diperbarui: <?php echo date("d/m/Y H:i", strtotime($invdetails[0]['iv_modified_date'])); ?>
        </div>
    </div>
    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);

            setTimeout(function() {
                window.location.href = "<?= base_url('inventory/inventory_management'); ?>";
            }, 2000);
        };
    </script>
</body>
</html>
