<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey Ceklist</title>
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
            gap: 50px;
            margin-top: 10px;
        }
        .photo-box {
            border: 2px solid #000;
            padding: 5px;
            text-align: center;
            width: 90%;
        }
        .photo-box img {
            max-width: 100%;
            width: 90%;
            height: 120px;
            object-fit: cover;
        }
        .text-photo {
            text-align: center;
        }
        .text-photo strong {
            display: block;
            margin-bottom: 5px;
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
                gap: 10px;
            }
            th, td {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h4 class="number"><?= esc($surveydetails[0]['s_code']); ?></h4>
        <img src="<?= base_url('assets/uploads/logo_bap.png') ?>" alt="Logo" class="logo">
        <h1>Data Kelengkapan Survey Supir</h1>
        <!-- First section of the table -->
    <div class="two-column-table" style="margin-right: 10px;">
        <div>
            <table>
                <tr>
                    <th style="width: 40%;">Nama Petugas Survey</th>
                    <td><?= esc($surveydetails[0]['s_petugas']); ?></td>
                </tr>
                <tr>
                    <th>Tanggal Survey</th>
                    <td><?= esc(date('d-m-Y', strtotime($surveydetails[0]['s_tanggal']))); ?></td>
                </tr>
                <tr>
                    <th>NIS</th>
                    <td><?= esc($surveydetails[0]['s_nis']); ?></td>
                </tr>
                <tr>
                    <th>Nama Supir</th>
                    <td><?= esc($surveydetails[0]['s_supir']); ?></td>
                </tr>
                <tr>
                    <th>Referensi</th>
                    <td><?= esc($surveydetails[0]['s_referensi']); ?></td>
                </tr>
                <tr>
                    <th>Status Pernikahan</th>
                    <td><?= esc($surveydetails[0]['s_nikah']); ?></td>
                </tr>
                <tr>
                    <th>Alamat Lengkap</th>
                    <td><?= esc($surveydetails[0]['s_alamat']); ?></td>
                </tr>
                <tr>
                    <th>Kelurahan</th>
                    <td><?php echo capitalEachWord(!empty($surveydetails[0]['s_village_name']) ? esc($surveydetails[0]['s_village_name']) :
                            (!empty($surveydetails[0]['s_kel']) ? esc($surveydetails[0]['s_kel']) : '-')); ?></td>
                </tr>
                <tr>
                    <th>Kecamatan</th>
                    <td><?php echo capitalEachWord(!empty($surveydetails[0]['s_district_name']) ? esc($surveydetails[0]['s_district_name']) :
                            (!empty($surveydetails[0]['s_kec']) ? esc($surveydetails[0]['s_kec']) : '-')); ?></td>
                </tr>
                <tr>
                    <th>Kabupaten</th>
                    <td><?php echo capitalEachWord(!empty($surveydetails[0]['s_city_name']) ? esc($surveydetails[0]['s_city_name']) :
                            (!empty($surveydetails[0]['s_kab']) ? esc($surveydetails[0]['s_kab']) : '-')); ?></td>
                </tr>
                <tr>
                    <th>Provinsi</th>
                    <td><?php echo capitalEachWord(!empty($surveydetails[0]['s_province_name']) ? esc($surveydetails[0]['s_province_name']) :
                            (!empty($surveydetails[0]['s_prov']) ? esc($surveydetails[0]['s_prov']) : '-')); ?></td>
                </tr>
                
            </table>
        </div>
        <div>
            <table>
                <tr>
                    <th style="width: 40%;">Nama Istri</th>
                    <td><?= esc($surveydetails[0]['s_istri']); ?></td>
                </tr>
                <tr>
                    <th>No Telepon Istri</th>
                    <td><?= esc($surveydetails[0]['s_telepon_istri']); ?></td>
                </tr>
                <tr>
                    <th>Nama Bapak</th>
                    <td><?= esc($surveydetails[0]['s_bapak']); ?></td>
                </tr>
                <tr>
                    <th>Nama Ibu</th>
                    <td><?= esc($surveydetails[0]['s_ibu']); ?></td>
                </tr>
                <tr>
                    <th>Nama Tetangga</th>
                    <td><?= esc($surveydetails[0]['s_tetangga']); ?></td>
                </tr>
                <tr>
                    <th>Nama Saudara/Kerabat</th>
                    <td><?= esc($surveydetails[0]['s_saudara']); ?></td>
                </tr>
                <tr>
                    <th>Alamat Saudara</th>
                    <td><?= esc($surveydetails[0]['s_alamat_saudara']); ?></td>
                </tr>
                <tr>
                    <th>No Telepon Saudara/Kerabat</th>
                    <td><?= esc($surveydetails[0]['s_telepon_keluarga']); ?></td>
                </tr>
            </table>
        </div>
    </div>

    <!-- <div style="margin-top: 10px;">
        <h2>Hasil Survey</h2>
    </div> -->
        <!-- Two-column layout for the second section -->
        <div style="margin-right: 10px;">
            <div>
                <table>
                    <tr>
                        <th style="width: 40%;">Kondisi Rumah</th>
                        <td><?= esc($surveydetails[0]['s_kondisi_rumah']); ?></td>
                    </tr>
                    <tr>
                        <th>Status Rumah</th>
                        <td><?= esc($surveydetails[0]['s_status_rumah']); ?></td>
                    </tr>
                    <tr>
                        <th>Lama Menetap Rumah</th>
                        <td><?= esc($surveydetails[0]['s_menetap']); ?></td>
                    </tr>
                    <tr>
                        <th>Jumlah Penghuni</th>
                        <td><?= esc($surveydetails[0]['s_penghuni']); ?></td>
                    </tr>
                    <tr>
                        <th>Pekerjaan Istri</th>
                        <td><?= esc($surveydetails[0]['s_pekerjaan_istri']); ?></td>
                    </tr>
                    <tr>
                        <th>Kendaraan yang Dimiliki</th>
                        <td><?= esc($surveydetails[0]['s_kendaraan']); ?></td>
                    </tr>
                    <tr>
                        <th>Jumlah Tanggungan</th>
                        <td><?= esc($surveydetails[0]['s_tanggungan']); ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div style="margin: 20px 0; border: 2px solid #000; border-radius: 5px; padding: 15px; background-color: #f9f9f9;margin-right: 10px;">
            <th style="text-align: left; padding: 10px; width: 30%; font-weight: bold; font-size: 12px; color: #333; border-bottom: 1px solid #ddd;">CATATAN :</th>
            <td style="padding: 10px; font-size: 12px; color: #555; border-bottom: 1px solid #ddd;"><?= esc($surveydetails[0]['s_keterangan']); ?></td>
        </div>

        <!-- Display photos section as a puzzle (4 boxes) -->
        <div class="photo-grid">
            <?php
                $relativeUploadPath = 'assets/uploads/survey/';
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

            <!-- Foto Pertama -->
            <div class="text-photo">
                <strong>Foto rumah Pertama</strong>
                <div class="photo-box">
                <?php
                    $foto_pertama = trim($surveydetails[0]['s_fotorumah_1'] ?? '');
                    $imageUrl_pertama = getImageWithCacheBusting($foto_pertama, $fullUploadUrl, $serverBasePath, $baseUrl);

                    if ($imageUrl_pertama) { ?>
                        <img src="<?= $imageUrl_pertama ?>" alt="Foto Rumah Pertama" class="print-image">
                    <?php } else if (!empty($foto_pertama)) { ?>
                        <div class="no-photo">
                            Foto tidak tersedia (<?= htmlspecialchars($foto_pertama) ?>)
                            <div style="font-size:10px; color:#888; margin-top:5px;">
                                Server Path: <?= htmlspecialchars(str_replace($baseUrl, $serverBasePath, $fullUploadUrl . $foto_pertama)) ?><br>
                                Web URL: <?= htmlspecialchars($fullUploadUrl . $foto_pertama) ?>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="no-photo">Tidak ada nama file foto.</div>
                    <?php } ?>
                </div>
            </div>

            <!-- Foto Kedua -->
            <div class="text-photo" style="margin-right: 10px;">
                <strong>Foto Rumah Kedua</strong>
                <div class="photo-box">
                <?php
                    $foto_kedua = trim($surveydetails[0]['s_fotorumah_2'] ?? '');
                    $imageUrl_kedua = getImageWithCacheBusting($foto_kedua, $fullUploadUrl, $serverBasePath, $baseUrl);

                    if ($imageUrl_kedua) { ?>
                        <img src="<?= $imageUrl_kedua ?>" alt="Foto Rumah kedua" class="print-image">
                    <?php } else if (!empty($foto_kedua)) { ?>
                        <div class="no-photo">
                            Foto tidak tersedia (<?= htmlspecialchars($foto_kedua) ?>)
                            <div style="font-size:10px; color:#888; margin-top:5px;">
                                Server Path: <?= htmlspecialchars(str_replace($baseUrl, $serverBasePath, $fullUploadUrl . $foto_kedua)) ?><br>
                                Web URL: <?= htmlspecialchars($fullUploadUrl . $foto_kedua) ?>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="no-photo">Tidak ada nama file foto.</div>
                    <?php } ?>
                </div>
            </div>

            <!-- Foto Ketiga -->
            <div class="text-photo" style="margin-top: 10px;">
                <strong>Foto Rumah Ketiga</strong>
                <div class="photo-box">
                <?php
                    $foto_ketiga = trim($surveydetails[0]['s_fotorumah_3'] ?? '');
                    $imageUrl_ketiga = getImageWithCacheBusting($foto_ketiga, $fullUploadUrl, $serverBasePath, $baseUrl);

                    if ($imageUrl_ketiga) { ?>
                        <img src="<?= $imageUrl_ketiga ?>" alt="Foto Rumah Ketiga" class="print-image">
                    <?php } else if (!empty($foto_ketiga)) { ?>
                        <div class="no-photo">
                            Foto tidak tersedia (<?= htmlspecialchars($foto_ketiga) ?>)
                            <div style="font-size:10px; color:#888; margin-top:5px;">
                                Server Path: <?= htmlspecialchars(str_replace($baseUrl, $serverBasePath, $fullUploadUrl . $foto_ketiga)) ?><br>
                                Web URL: <?= htmlspecialchars($fullUploadUrl . $foto_ketiga) ?>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="no-photo">Tidak ada nama file foto.</div>
                    <?php } ?>
                </div>
            </div>

            <!-- Terakhir diperbarui (di bawah Foto Rumah Kedua) -->
            <div style="align-self: end; text-align: right; font-size: 12px; color: #555; padding: 5px 10px;">
                Terakhir diperbarui: <?php echo date("d/m/Y H:i", strtotime($surveydetails[0]['s_modified_date'])); ?>
            </div>
        </div>

        <!-- <h1 style="color: red;">DILARANG MEMINDAHKAN / MENCABUT KERTAS INI.</h1> -->
    </div>
    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);

            setTimeout(function() {
                window.location.href = "<?= base_url('surveys/survey_management'); ?>";
            }, 2000);
        };
    </script>
</body>
</html>
