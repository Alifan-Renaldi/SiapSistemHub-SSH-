<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Print Serah Terima</title>
    <style>
        /* Reset dan Base Styles - Dompdf Compatible */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Arial", sans-serif;
            font-size: 10px;
            color: #333;
            background: #fff;
            line-height: 1.3;
            margin: 0;
            padding: 10px;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 10px 15px;
            background: #fff;
        }

        h1 {
            font-size: 20px;
            text-transform: uppercase;
            text-align: center;
            margin: 5px 0;
        }

        .sub-title {
            text-align: center;
            margin: 2px 0 10px;
            font-size: 12px;
            font-weight: bold;
            font-style: italic;
        }

        /* Header table */
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

        /* Section title */
        .section-title {
            font-weight: bold;
            font-size: 12px;
            margin: 8px 0 5px;
            padding-bottom: 3px;
            border-bottom: 1px solid #3498db;
        }

        /* Data tables */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }
        .data-table th {
            text-align: left;
            font-weight: bold;
            padding: 3px 5px;
            width: 45%;
            font-size: 10px;
            border: none;
        }
        .data-table td {
            padding: 3px 5px;
            background-color: #f8f9fa;
            border-left: 2px solid #3498db;
            font-size: 10px;
            border-top: none;
            border-right: none;
            border-bottom: none;
        }

        /* Two-column wrapper */
        .two-col-wrapper {
            width: 100%;
            border: none;
        }
        .two-col-wrapper > tbody > tr > td {
            width: 50%;
            vertical-align: top;
            border: none;
            padding: 0 5px;
        }

        /* Photo box */
        .photo-box {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: center;
            background: #fafafa;
            min-height: 150px;
        }
        .photo-box img {
            max-height: 160px;
            max-width: 100%;
            height: auto;
        }

        /* Note box */
        .note-box {
            border: 1px solid #ddd;
            padding: 8px;
            background: #fafafa;
            margin-bottom: 10px;
            border-left: 3px solid #e74c3c;
        }

        /* Signature section */
        .signature-table {
            width: 100%;
            border: none;
            margin-top: 30px;
        }
        .signature-table td {
            width: 33%;
            text-align: center;
            vertical-align: top;
            border: none;
            padding: 5px 10px;
        }
        .signature-name {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .signature-area {
            min-height: 60px;
            text-align: center;
            padding: 5px 0;
        }
        .signature-image {
            max-width: 100%;
            max-height: 70px;
            border: 1px solid #ddd;
            background: white;
        }
        .signature-line {
            height: 1px;
            background-color: #333;
            width: 70%;
            margin: 0 auto;
        }
        .signature-info {
            font-size: 12px;
            margin-top: 5px;
        }

        /* Footer */
        .footer {
            font-size: 8px;
            color: #7f8c8d;
            margin-top: 10px;
            text-align: center;
            padding-top: 5px;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header: Document number + Logo -->
        <table class="header-table">
            <tr>
                <td style="width: 40%; font-size: 13px;"><?= esc($handovers['ho_code']); ?></td>
                <td style="width: 60%; text-align: right;">
                    <?php
                        $logoPath = FCPATH . 'assets/uploads/logo_bap.png';
                        if (file_exists($logoPath)) {
                            echo '<img src="' . $logoPath . '" alt="Logo" style="width: 120px; height: auto;">';
                        }
                    ?>
                </td>
            </tr>
        </table>

        <h1>SERAH TERIMA KENDARAAN</h1>
        <div class="sub-title">
            <?= esc($handovers['ho_lokasi']); ?>,
            <?= date("d/m/Y", strtotime($handovers['ho_tanggal'])); ?>
        </div>

        <!-- Data Serah Terima -->
        <div class="section-title">Data Serah Terima</div>
        <table class="two-col-wrapper">
            <tr>
                <td style="width: 40%; vertical-align: top; padding: 0 5px 0 0;">
                    <div class="photo-box">
                        <?php
                            $uploadDir = FCPATH . 'assets/uploads/vehicle_handover/';

                            // Helper to get image path for Dompdf
                            $getImagePath = function($filename) use ($uploadDir) {
                                if (empty($filename)) return null;
                                $filepath = $uploadDir . trim($filename);
                                return file_exists($filepath) ? $filepath : null;
                            };

                            $imagePath = null;

                            if (!empty($handovers['foto'])) {
                                $imagePath = $getImagePath($handovers['foto']);
                            }
                        ?>

                        <?php if ($imagePath): ?>
                            <img src="<?= $imagePath ?>" alt="Foto Serah Terima">
                        <?php else: ?>
                            <p style="color:#888; margin-top: 40px;">Tidak ada foto</p>
                        <?php endif; ?>
                    </div>
                </td>
                <td style="width: 60%; vertical-align: top; padding: 0 0 0 5px;">
                    <table class="data-table">
                        <tr>
                            <th>Nomor Polisi</th>
                            <td><?= esc($handovers['ho_nopol']); ?></td>
                        </tr>
                        <tr>
                            <th>Tipe Mobil</th>
                            <td><?= esc($handovers['ho_jenis']); ?></td>
                        </tr>
                        <tr>
                            <th>Supir Lama</th>
                            <td><?= esc($handovers['ho_supirlama']); ?></td>
                        </tr>
                        <tr>
                            <th>Supir Baru</th>
                            <td><?= esc($handovers['ho_supirbaru']); ?></td>
                        </tr>
                        <tr>
                            <th>Kilometer</th>
                            <td><?= esc($handovers['ho_km']); ?></td>
                        </tr>
                        <tr>
                            <th>Jumlah Solar</th>
                            <td><?= esc($handovers['ho_solar']); ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Kondisi Kendaraan -->
        <div class="section-title">Kondisi Kendaraan</div>
        <table class="two-col-wrapper">
            <tr>
                <td style="vertical-align: top; padding: 0 5px 0 0;">
                    <table class="data-table">
                        <tr>
                            <th>Kabin Mobil</th>
                            <td><?= esc($handovers['ho_kabin']); ?></td>
                        </tr>
                        <tr>
                            <th>Kabel Body</th>
                            <td><?= esc($handovers['ho_kabel']); ?></td>
                        </tr>
                        <tr>
                            <th>Lampu Besar Depan</th>
                            <td><?= esc($handovers['ho_lampubesar']); ?></td>
                        </tr>
                        <tr>
                            <th>Lampu Rem R/L</th>
                            <td><?= esc($handovers['ho_lampurem']); ?></td>
                        </tr>
                        <tr>
                            <th>Lampu Sein Depan R/L</th>
                            <td><?= esc($handovers['ho_seindpn']); ?></td>
                        </tr>
                        <tr>
                            <th>Lampu Sein Belakang R/L</th>
                            <td><?= esc($handovers['ho_seinblk']); ?></td>
                        </tr>
                    </table>
                </td>
                <td style="vertical-align: top; padding: 0 0 0 5px;">
                    <table class="data-table">
                        <tr>
                            <th>Wiper</th>
                            <td><?= esc($handovers['ho_wiper']); ?></td>
                        </tr>
                        <tr>
                            <th>Spion Bulat R/L</th>
                            <td><?= esc($handovers['ho_spion']); ?></td>
                        </tr>
                        <tr>
                            <th>Tangki Solar 1</th>
                            <td><?= esc($handovers['ho_tangki1']); ?></td>
                        </tr>
                        <tr>
                            <th>Tangki Solar 2</th>
                            <td><?= esc($handovers['ho_tangki2']); ?></td>
                        </tr>
                        <tr>
                            <th>Kondisi Bak</th>
                            <td><?= esc($handovers['ho_bak']); ?></td>
                        </tr>
                        <tr>
                            <th>Pintu Kupu-Kupu</th>
                            <td><?= esc($handovers['ho_pintu']); ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Kondisi Ban -->
        <div class="section-title">Kondisi Ban</div>
        <table class="two-col-wrapper">
            <tr>
                <td style="vertical-align: top; padding: 0 5px 0 0;">
                    <table class="data-table">
                        <tr>
                            <th>Ban Depan Kiri</th>
                            <td><?= esc($handovers['ho_bandpnkr']); ?></td>
                        </tr>
                        <tr>
                            <th>Merk Ban Depan Kiri</th>
                            <td><?= esc($handovers['ho_merkbankr']); ?></td>
                        </tr>
                        <tr>
                            <th>Ban Depan Kanan</th>
                            <td><?= esc($handovers['ho_bandpnkn']); ?></td>
                        </tr>
                        <tr>
                            <th>Merk Ban Depan Kanan</th>
                            <td><?= esc($handovers['ho_merkbankn']); ?></td>
                        </tr>
                        <tr>
                            <th>Ban Belakang Kiri Luar</th>
                            <td><?= esc($handovers['ho_banblkkrlr']); ?></td>
                        </tr>
                        <tr>
                            <th>Merk Ban Belakang Kiri Luar</th>
                            <td><?= esc($handovers['ho_merkbankrlr']); ?></td>
                        </tr>
                        <tr>
                            <th>Ban Belakang Kanan Luar</th>
                            <td><?= esc($handovers['ho_banblkknlr']); ?></td>
                        </tr>
                        <tr>
                            <th>Merk Ban Belakang Kanan Luar</th>
                            <td><?= esc($handovers['ho_merkbanknlr']); ?></td>
                        </tr>
                        <tr>
                            <th>Ban Belakang Kiri Dalam</th>
                            <td><?= esc($handovers['ho_banblkkrdlm']); ?></td>
                        </tr>
                        <tr>
                            <th>Merk Ban Belakang Kiri Dalam</th>
                            <td><?= esc($handovers['ho_merkbankrdlm']); ?></td>
                        </tr>
                    </table>
                </td>
                <td style="vertical-align: top; padding: 0 0 0 5px;">
                    <table class="data-table">
                        <tr>
                            <th>Ban Belakang Kanan Dalam</th>
                            <td><?= esc($handovers['ho_banblkkndlm']) ?></td>
                        </tr>
                        <tr>
                            <th>Merk Ban Belakang Kanan Dalam</th>
                            <td><?= esc($handovers['ho_merkbankndlm']) ?></td>
                        </tr>
                        <tr>
                            <th>Ban Tarik Kiri Luar</th>
                            <td><?= esc($handovers['ho_bantrkkrlr']) ?></td>
                        </tr>
                        <tr>
                            <th>Merk Ban Tarik Kiri Luar</th>
                            <td><?= esc($handovers['ho_merkbantrkkrlr']) ?></td>
                        </tr>
                        <tr>
                            <th>Ban Tarik Kanan Luar</th>
                            <td><?= esc($handovers['ho_bantrkknlr']) ?></td>
                        </tr>
                        <tr>
                            <th>Merk Ban Tarik Kanan Luar</th>
                            <td><?= esc($handovers['ho_merkbantrkknlr']) ?></td>
                        </tr>
                        <tr>
                            <th>Ban Tarik Kiri Dalam</th>
                            <td><?= esc($handovers['ho_bantrkkrdlm']) ?></td>
                        </tr>
                        <tr>
                            <th>Merk Ban Tarik Kiri Dalam</th>
                            <td><?= esc($handovers['ho_merkbantrkkrdlm']) ?></td>
                        </tr>
                        <tr>
                            <th>Ban Tarik Kanan Dalam</th>
                            <td><?= esc($handovers['ho_bantrkkndlm']) ?></td>
                        </tr>
                        <tr>
                            <th>Merk Ban Tarik Kanan Dalam</th>
                            <td><?= esc($handovers['ho_merkbantrkkndlm']) ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Kondisi Velg -->
        <div class="section-title">Kondisi Velg</div>
        <table class="two-col-wrapper">
            <tr>
                <td style="vertical-align: top; padding: 0 5px 0 0;">
                    <table class="data-table">
                        <tr>
                            <th>Velg Depan Kiri</th>
                            <td><?= esc($handovers['ho_velgdpnkr']) ?></td>
                        </tr>
                        <tr>
                            <th>Merk Velg Depan Kiri</th>
                            <td><?= esc($handovers['ho_merkukuranvelgdpnkr']) ?></td>
                        </tr>
                        <tr>
                            <th>Velg Depan Kanan</th>
                            <td><?= esc($handovers['ho_velgdpnkn']) ?></td>
                        </tr>
                        <tr>
                            <th>Merk Velg Depan Kanan</th>
                            <td><?= esc($handovers['ho_merkukuranvelgdpnkn']) ?></td>
                        </tr>
                        <tr>
                            <th>Velg Belakang Kiri Luar</th>
                            <td><?= esc($handovers['ho_velgblkkrlr']) ?></td>
                        </tr>
                        <tr>
                            <th>Merk Velg Belakang Kiri Luar</th>
                            <td><?= esc($handovers['ho_merkukuranvelgblkkrlr']) ?></td>
                        </tr>
                    </table>
                </td>
                <td style="vertical-align: top; padding: 0 0 0 5px;">
                    <table class="data-table">
                        <tr>
                            <th>Velg Belakang Kanan Luar</th>
                            <td><?= esc($handovers['ho_velgblkknlr']) ?></td>
                        </tr>
                        <tr>
                            <th>Merk Velg Belakang Kanan Luar</th>
                            <td><?= esc($handovers['ho_merkukuranvelgblknlr']) ?></td>
                        </tr>
                        <tr>
                            <th>Velg Belakang Kiri Dalam</th>
                            <td><?= esc($handovers['ho_velgblkkrdlm']) ?></td>
                        </tr>
                        <tr>
                            <th>Merk Velg Belakang Kiri Dalam</th>
                            <td><?= esc($handovers['ho_merkukuranvelgblkkrdlm']) ?></td>
                        </tr>
                        <tr>
                            <th>Velg Belakang Kanan Dalam</th>
                            <td><?= esc($handovers['ho_velgblkkndlm']) ?></td>
                        </tr>
                        <tr>
                            <th>Merk Velg Belakang Kanan Dalam</th>
                            <td><?= esc($handovers['ho_merkukuranvelgblkndlm']) ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Catatan -->
        <div class="section-title">Catatan</div>
        <div class="note-box">
            <?= esc($handovers['ho_keterangan']); ?>
        </div>

        <!-- Tanda Tangan -->
        <table class="signature-table">
            <tr>
                <td>
                    <div class="signature-name">Supir Lama</div>
                    <div class="signature-area">
                        <?php if (!empty($handovers['signature_supir_lama'])): ?>
                            <img src="<?= $handovers['signature_supir_lama'] ?>"
                                 alt="Tanda Tangan Supir Lama"
                                 class="signature-image">
                        <?php else: ?>
                            <div class="signature-line"></div>
                        <?php endif; ?>
                    </div>
                    <div class="signature-info">( <?= esc($handovers['ho_supirlama']); ?> )</div>
                </td>
                <td>
                    <div class="signature-name">Supir Baru</div>
                    <div class="signature-area">
                        <?php if (!empty($handovers['signature_supir_baru'])): ?>
                            <img src="<?= $handovers['signature_supir_baru'] ?>"
                                 alt="Tanda Tangan Supir Baru"
                                 class="signature-image">
                        <?php else: ?>
                            <div class="signature-line"></div>
                        <?php endif; ?>
                    </div>
                    <div class="signature-info">( <?= esc($handovers['ho_supirbaru']); ?> )</div>
                </td>
                <td>
                    <div class="signature-name">Petugas Serah Terima</div>
                    <div class="signature-area">
                        <?php if (!empty($handovers['signature_petugas'])): ?>
                            <img src="<?= $handovers['signature_petugas'] ?>"
                                 alt="Tanda Tangan Petugas"
                                 class="signature-image">
                        <?php else: ?>
                            <div class="signature-line"></div>
                        <?php endif; ?>
                    </div>
                    <div class="signature-info">
                        ( <?= !empty($handovers['nama_petugas']) ? esc($handovers['nama_petugas']) : '....................................' ?> )
                    </div>
                </td>
            </tr>
        </table>

        <div class="footer">
            Dokumen ini dicetak secara otomatis pada <?= date("d/m/Y H:i:s"); ?>
        </div>
    </div>
</body>
</html>