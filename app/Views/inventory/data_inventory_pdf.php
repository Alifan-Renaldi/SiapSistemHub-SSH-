<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PDF Checklist</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 12px;
        }
        .container {
            width: 100%;
            padding: 10px;
        }
        h1 {
            text-align: center;
            font-size: 16px;
            margin: 5px 0 10px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 5px;
            text-align: left;
            border: 1px solid #000;
            font-size: 11px;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .header-table {
            width: 100%;
            border: none;
            margin-bottom: 5px;
        }
        .header-table td {
            border: none;
            padding: 2px;
            vertical-align: top;
        }
        .two-col-wrapper {
            width: 100%;
        }
        .two-col-wrapper td {
            width: 50%;
            vertical-align: top;
            border: none;
            padding: 0 5px 0 0;
        }
        .two-col-wrapper td:last-child {
            padding: 0 0 0 5px;
        }
        .two-col-wrapper table {
            width: 100%;
        }
        .catatan-box {
            border: 2px solid #000;
            border-radius: 5px;
            padding: 10px;
            background-color: #f9f9f9;
            margin: 15px 0;
        }
        .photo-table {
            width: 100%;
            border: none;
            margin-top: 15px;
        }
        .photo-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            border: none;
            padding: 5px;
        }
        .photo-box {
            border: 2px solid #000;
            padding: 10px;
            text-align: center;
            min-height: 150px;
        }
        .photo-box img {
            max-width: 100%;
            height: auto;
            max-height: 180px;
        }
        .photo-label {
            font-weight: bold;
            margin-bottom: 5px;
            text-align: center;
        }
        .warning-text {
            text-align: center;
            color: red;
            font-size: 14px;
            font-weight: bold;
            margin: 15px 0 5px 0;
        }
        .footer-text {
            font-size: 10px;
            color: #555;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header with code and logo -->
        <table class="header-table">
            <tr>
                <td style="width:40%; font-size:12px;"><?= esc($inventorys['iv_code'] ?? ''); ?></td>
                <td style="width:60%; text-align:right;">
                    <?php
                        $logoPath = FCPATH . 'assets/uploads/logo_bap.png';
                        if (file_exists($logoPath)) {
                            echo '<img src="' . $logoPath . '" alt="Logo" style="width:100px; height:auto;">';
                        }
                    ?>
                </td>
            </tr>
        </table>

        <h1>Data Kelengkapan Inventaris</h1>

        <!-- Vehicle info section -->
        <table>
            <tr>
                <th style="width: 50%;">Nomor Polisi</th>
                <td><?= esc($inventorys['iv_nopol'] ?? ''); ?></td>
            </tr>
            <tr>
                <th style="width: 50%;">Tipe Mobil</th>
                <td><?= esc($inventorys['iv_jenis'] ?? ''); ?></td>
            </tr>
            <tr>
                <th style="width: 50%;">Tahun Mobil</th>
                <td><?= esc($inventorys['iv_tahun'] ?? ''); ?></td>
            </tr>
        </table>

        <!-- Two-column layout using table (Dompdf compatible) -->
        <table style="width: 100%; border: none;">
            <tr>
                <td style="width: 50%; vertical-align: top; border: none; padding-right: 5px;">
                    <table class="two-column-table">
                        <tr>
                            <th>STNK</th>
                            <td><?= esc($inventorys['iv_stnk'] ?? ''); ?></td>
                        </tr>
                        <tr>
                            <th>KIR</th>
                            <td><?= esc($inventorys['iv_kir'] ?? ''); ?></td>
                        </tr>
                        <tr>
                            <th>Dongkrak</th>
                            <td><?= esc($inventorys['iv_dongkrak'] ?? ''); ?></td>
                        </tr>
                        <tr>
                            <th>Kunci Roda</th>
                            <td><?= esc($inventorys['iv_kunci'] ?? ''); ?></td>
                        </tr>
                        <tr>
                            <th>Stang/Stick Kunci Roda</th>
                            <td><?= esc($inventorys['iv_stang'] ?? ''); ?></td>
                        </tr>
                        <tr>
                            <th>Spanner</th>
                            <td><?= esc($inventorys['iv_spanner'] ?? ''); ?></td>
                        </tr>
                        <tr>
                            <th>Ban Serep</th>
                            <td><?= esc($inventorys['iv_serep'] ?? ''); ?></td>
                        </tr>
                        <tr>
                            <th>Gantungan Ban Serep</th>
                            <td><?= esc($inventorys['iv_gantungan'] ?? ''); ?></td>
                        </tr>
                        <tr>
                            <th>RAM (Kanan/Kiri)</th>
                            <td><?= esc($inventorys['iv_ramkk'] ?? ''); ?></td>
                        </tr>
                        <tr>
                            <th>RAM (Depan/Belakang)</th>
                            <td><?= esc($inventorys['iv_ramdb'] ?? ''); ?></td>
                        </tr>
                    </table>
                </td>
                <td style="width: 50%; vertical-align: top; border: none; padding-left: 5px;">
                    <table>
                        <tr>
                            <th>Tempat Tidur Kabin</th>
                            <td><?= esc($inventorys['iv_kabin'] ?? ''); ?></td>
                        </tr>
                        <tr>
                            <th>Karpet Depan (R/L)</th>
                            <td><?= esc($inventorys['iv_karpetd'] ?? ''); ?></td>
                        </tr>
                        <tr>
                            <th>Karpet Belakang (R/L)</th>
                            <td><?= esc($inventorys['iv_karpetb'] ?? ''); ?></td>
                        </tr>
                        <tr>
                            <th>Tali Tambang (3 Gulung)</th>
                            <td><?= esc($inventorys['iv_tambang'] ?? ''); ?></td>
                        </tr>
                        <tr>
                            <th>Terpal Tarpolin (1 Lembar)</th>
                            <td><?= esc($inventorys['iv_tarpolin'] ?? ''); ?></td>
                        </tr>
                        <tr>
                            <th>Terpal Plastik (1 Lembar)</th>
                            <td><?= esc($inventorys['iv_plastik'] ?? ''); ?></td>
                        </tr>
                        <tr>
                            <th>Terpal Lidah (2 Lembar)</th>
                            <td><?= esc($inventorys['iv_lidah'] ?? ''); ?></td>
                        </tr>
                        <tr>
                            <th>Badong</th>
                            <td><?= esc($inventorys['iv_badong'] ?? ''); ?></td>
                        </tr>
                        <tr>
                            <th>Pipa Kojong</th>
                            <td><?= esc($inventorys['iv_kojong'] ?? ''); ?></td>
                        </tr>
                        <tr>
                            <th>Jumlah Pipa Kojong</th>
                            <td><?= esc($inventorys['iv_jumlah'] ?? ''); ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Catatan -->
        <div class="catatan-box">
            <strong style="font-size: 12px; color: #333;">CATATAN :</strong>
            <span style="font-size: 12px; color: #555; margin-left: 10px;"><?= esc($inventorys['iv_keterangan'] ?? ''); ?></span>
        </div>

        <!-- Photos section using table layout (Dompdf compatible) -->
        <?php
            $uploadDir = FCPATH . 'assets/uploads/vehicle_invent/';
            
            // Helper to get image path for Dompdf
            $getImagePath = function($filename) use ($uploadDir) {
                if (empty($filename)) return null;
                $filepath = $uploadDir . trim($filename);
                return file_exists($filepath) ? $filepath : null;
            };
            
            $photos = [
                ['field' => 'foto_dpn',   'label' => 'Foto Sisi Depan Mobil'],
                ['field' => 'foto_blk',   'label' => 'Foto Sisi Belakang Mobil'],
                ['field' => 'foto_kiri',  'label' => 'Foto Sisi Kiri Mobil'],
                ['field' => 'foto_kanan', 'label' => 'Foto Sisi Kanan Mobil'],
            ];
        ?>
        <table class="photo-table">
            <?php for ($i = 0; $i < count($photos); $i += 2): ?>
            <tr>
                <?php for ($j = $i; $j < $i + 2 && $j < count($photos); $j++): 
                    $photo = $photos[$j];
                    $filename = $inventorys[$photo['field']] ?? '';
                    $imagePath = $getImagePath($filename);
                ?>
                <td>
                    <div class="photo-label"><?= $photo['label'] ?></div>
                    <div class="photo-box">
                        <?php if ($imagePath): ?>
                            <img src="<?= $imagePath ?>" alt="<?= $photo['label'] ?>">
                        <?php elseif (!empty($filename)): ?>
                            <div style="padding:20px; color:#888;">Foto tidak tersedia</div>
                        <?php else: ?>
                            <div style="padding:20px; color:#888;">Tidak ada foto</div>
                        <?php endif; ?>
                    </div>
                </td>
                <?php endfor; ?>
            </tr>
            <?php endfor; ?>
        </table>

        <div class="warning-text">DILARANG MEMINDAHKAN / MENCABUT KERTAS INI.</div>
        <div class="footer-text">
            Terakhir diperbarui: <?= date("d/m/Y H:i", strtotime($inventorys['iv_modified_date'] ?? 'now')); ?>
        </div>
    </div>
</body>
</html>
