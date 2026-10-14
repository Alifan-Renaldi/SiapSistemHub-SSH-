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
            background-color: #ffffff;
        }
        .container {
            width: 800px;
            margin: 0 auto;
            padding: 20px;
            padding-right: 10px;
            background-color: #ffffff;
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
            padding: 10px;
            padding-bottom: 20px;
            text-align: left;
            border: 2px solid #000;
            font-size: 16px;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        /* Two-column section: table wrapper (html2canvas-friendly) */
        .layout-table {
            width: 100%;
            border-collapse: collapse;
        }
        .layout-table > tr > td,
        .layout-table td.col {
            border: none;
            padding: 0;
            vertical-align: top;
        }
        .layout-table td.col-left {
            width: 50%;
            padding-right: 10px;
        }
        .layout-table td.col-right {
            width: 50%;
            padding-left: 10px;
        }
        .layout-table table {
            margin-top: 0;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-table td {
            border: none;
            padding: 0;
        }
        .photo-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: separate;
            border-spacing: 10px 0;
        }
        .photo-table td {
            width: 50%;
            border: none;
            padding: 0;
            text-align: center;
            vertical-align: top;
        }
        .photo-box {
            border: 2px solid #000;
            padding: 5px;
            text-align: center;
            width: 90%;
            margin: 0 auto;
        }
        .photo-box img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }
        .text-photo {
            text-align: center;
        }
        .text-photo strong {
            display: block;
            margin-bottom: 10px;
        }
        .logo {
            width: 100px;
            height: auto;
            vertical-align: middle;
        }
        .number {
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container" id="survey-capture-area">
        <table class="header-table">
            <tr>
                <td style="width:40%; font-size:12px;"><?= esc($surveys['s_code'] ?? ''); ?></td>
                <td style="width:60%; text-align:right;">
                    <?php
                        $logoWebUrl = base_url('assets/uploads/logo_bap.png');
                    ?>
                    <img src="<?= $logoWebUrl ?>" alt="Logo" class="logo">
                </td>
            </tr>
        </table>
        <h1>Data Kelengkapan Survey Supir</h1>
        <!-- First section: 2-column layout (table wrapper) -->
        <table class="layout-table">
            <tr>
                <td class="col col-left">
                    <table>
                        <tr>
                            <th style="width: 40%;">Nama Petugas Survey</th>
                            <td><?= esc($surveys['s_petugas'] ?? ''); ?></td>
                        </tr>
                        <tr>
                            <th>Tanggal Survey</th>
                            <td><?= esc(date('d-m-Y', strtotime($surveys['s_tanggal']))); ?></td>
                        </tr>
                        <tr>
                            <th>NIS</th>
                            <td><?= esc($surveys['s_nis'] ?? ''); ?></td>
                        </tr>
                        <tr>
                            <th>Nama Supir</th>
                            <td><?= esc($surveys['s_supir'] ?? ''); ?></td>
                        </tr>
                        <tr>
                            <th>Referensi</th>
                            <td><?= esc($surveys['s_referensi'] ?? ''); ?></td>
                        </tr>
                        <tr>
                            <th>Status Pernikahan</th>
                            <td><?= esc($surveys['s_nikah'] ?? ''); ?></td>
                        </tr>
                        <tr>
                            <th>Alamat Lengkap</th>
                            <td><?= esc($surveys['s_alamat'] ?? ''); ?></td>
                        </tr>
                        <tr>
                            <th>Kelurahan</th>
                            <td><?php echo capitalEachWord(!empty($surveys['s_village_name']) ? esc($surveys['s_village_name']) :
                                    (!empty($surveys['s_kel']) ? esc($surveys['s_kel']) : '-')); ?></td>
                        </tr>
                        <tr>
                            <th>Kecamatan</th>
                            <td><?php echo capitalEachWord(!empty($surveys['s_district_name']) ? esc($surveys['s_district_name']) :
                                    (!empty($surveys['s_kec']) ? esc($surveys['s_kec']) : '-')); ?></td>
                        </tr>
                        <tr>
                            <th>Kabupaten</th>
                            <td><?php echo capitalEachWord(!empty($surveys['s_city_name']) ? esc($surveys['s_city_name']) :
                                    (!empty($surveys['s_kab']) ? esc($surveys['s_kab']) : '-')); ?></td>
                        </tr>
                        <tr>
                            <th>Provinsi</th>
                            <td><?php echo capitalEachWord(!empty($surveys['s_province_name']) ? esc($surveys['s_province_name']) :
                                    (!empty($surveys['s_prov']) ? esc($surveys['s_prov']) : '-')); ?></td>
                        </tr>
                    </table>
                </td>
                <td class="col col-right">
                    <table>
                        <tr>
                            <th style="width: 40%;">Nama Istri</th>
                            <td><?= esc($surveys['s_istri'] ?? ''); ?></td>
                        </tr>
                        <tr>
                            <th>No Telepon Istri</th>
                            <td><?= esc($surveys['s_telepon_istri'] ?? ''); ?></td>
                        </tr>
                        <tr>
                            <th>Nama Bapak</th>
                            <td><?= esc($surveys['s_bapak'] ?? ''); ?></td>
                        </tr>
                        <tr>
                            <th>Nama Ibu</th>
                            <td><?= esc($surveys['s_ibu'] ?? ''); ?></td>
                        </tr>
                        <tr>
                            <th>Nama Tetangga</th>
                            <td><?= esc($surveys['s_tetangga'] ?? ''); ?></td>
                        </tr>
                        <tr>
                            <th>Nama Saudara/Kerabat</th>
                            <td><?= esc($surveys['s_saudara'] ?? ''); ?></td>
                        </tr>
                        <tr>
                            <th>Alamat Saudara</th>
                            <td><?= esc($surveys['s_alamat_saudara'] ?? ''); ?></td>
                        </tr>
                        <tr>
                            <th>No Telepon Saudara/Kerabat</th>
                            <td><?= esc($surveys['s_telepon_keluarga'] ?? ''); ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Second section: single column, full width -->
        <div style="margin-right: 10px;">
            <div>
                <table>
                    <tr>
                        <th style="width: 40%;">Kondisi Rumah</th>
                        <td><?= esc($surveys['s_kondisi_rumah'] ?? ''); ?></td>
                    </tr>
                    <tr>
                        <th>Status Rumah</th>
                        <td><?= esc($surveys['s_status_rumah'] ?? ''); ?></td>
                    </tr>
                    <tr>
                        <th>Lama Menetap Rumah</th>
                        <td><?= esc($surveys['s_menetap'] ?? ''); ?></td>
                    </tr>
                    <tr>
                        <th>Jumlah Penghuni</th>
                        <td><?= esc($surveys['s_penghuni'] ?? ''); ?></td>
                    </tr>
                    <tr>
                        <th>Pekerjaan Istri</th>
                        <td><?= esc($surveys['s_pekerjaan_istri'] ?? ''); ?></td>
                    </tr>
                    <tr>
                        <th>Kendaraan yang Dimiliki</th>
                        <td><?= esc($surveys['s_kendaraan'] ?? ''); ?></td>
                    </tr>
                    <tr>
                        <th>Jumlah Tanggungan</th>
                        <td><?= esc($surveys['s_tanggungan'] ?? ''); ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <table class="catatan-table" style="margin: 20px 0; border-collapse: collapse; margin-right: 10px;">
            <tr>
                <td style="border: 2px solid #000; border-radius: 5px; padding: 10px; background-color: #f9f9f9;">
                    <strong style="display: block; font-size: 12px; color: #333; border-bottom: 1px solid #ddd; padding-bottom: 5px; margin-bottom: 5px;">CATATAN :</strong>
                    <span style="font-size: 12px; color: #555;"><?= esc($surveys['s_keterangan'] ?? ''); ?></span>
                </td>
            </tr>
        </table>

        <!-- Display photos section: 2-column table layout -->
        <table class="photo-table">
            <?php
                $relativeUploadPath = 'assets/uploads/survey/';
                $baseUrlFull = rtrim(base_url(), '/');
                $fullUploadUrl = $baseUrlFull . '/' . $relativeUploadPath;
                $baseUrlPath = parse_url($baseUrlFull, PHP_URL_PATH);
                $serverBasePath = $_SERVER['DOCUMENT_ROOT'] . $baseUrlPath;

                function getImageWithCacheBustingImage($filename, $fullUploadUrl, $serverBasePath, $baseUrl) {
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
            <tr>
                <td>
                    <div class="text-photo">
                        <strong>Foto Rumah Pertama</strong>
                        <div class="photo-box">
                            <?php
                                $foto_pertama = trim($surveys['s_fotorumah_1'] ?? '');
                                $imageUrl_pertama = getImageWithCacheBustingImage($foto_pertama, $fullUploadUrl, $serverBasePath, $baseUrlFull);
                            ?>
                            <?php if ($imageUrl_pertama): ?>
                                <img src="<?= $imageUrl_pertama ?>" alt="Foto Rumah Pertama">
                            <?php else: ?>
                                <p style="color:#888; margin-top: 40px;">Tidak ada foto</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="text-photo">
                        <strong>Foto Rumah Kedua</strong>
                        <div class="photo-box">
                            <?php
                                $foto_kedua = trim($surveys['s_fotorumah_2'] ?? '');
                                $imageUrl_kedua = getImageWithCacheBustingImage($foto_kedua, $fullUploadUrl, $serverBasePath, $baseUrlFull);
                            ?>
                            <?php if ($imageUrl_kedua): ?>
                                <img src="<?= $imageUrl_kedua ?>" alt="Foto Rumah Kedua">
                            <?php else: ?>
                                <p style="color:#888; margin-top: 40px;">Tidak ada foto</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="text-photo">
                        <strong>Foto Rumah Ketiga</strong>
                        <div class="photo-box">
                            <?php
                                $foto_ketiga = trim($surveys['s_fotorumah_3'] ?? '');
                                $imageUrl_ketiga = getImageWithCacheBustingImage($foto_ketiga, $fullUploadUrl, $serverBasePath, $baseUrlFull);
                            ?>
                            <?php if ($imageUrl_ketiga): ?>
                                <img src="<?= $imageUrl_ketiga ?>" alt="Foto Rumah Ketiga">
                            <?php else: ?>
                                <p style="color:#888; margin-top: 40px;">Tidak ada foto</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </td>
                <td style="vertical-align: bottom; text-align: right;">
                    <div style="font-size: 12px; color: #555; padding: 5px 10px;">
                        Terakhir diperbarui: <?= esc(!empty($surveys['s_modified_date']) ? date("d-m-Y H:i", strtotime($surveys['s_modified_date'])) : '-'); ?>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
