<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print BAP</title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/uploads/Icon SSH.png') ?>">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 10px;
            line-height: 1.4;
            color: #333;
        }
        .header, .footer {
            text-align: center;
            margin-bottom: 10px;
        }
        .header h1 {
            font-size: 20px;
            text-transform: uppercase;
        }
        .header h3 {
            font-size: 14px;
        }
        .logo {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 150px;
            height: auto;
        }
        .number {
            position: absolute;
            top: 10px;
            left: 10px;
            width: 100px;
            height: auto;
            font-weight: normal;
        }
        .section {
            margin-bottom: 15px;
        }
        .section h2 {
            font-size: 16px;
            margin-bottom: 10px;
        }
        .section h4 {
            font-size: 14px;
            margin-bottom: 5px;
        }
        .form-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        .form-table th, .form-table td {
            padding: 3px;
            border: 1px solid #ccc;
        }
        .form-table th {
            background-color: #f9f9f9;
            font-weight: bold;
        }
        .checkbox-group {
            display: flex;
            gap: 10px;
        }
        .signatures {
            text-align: center;
        }
        .signature-box {
            display: inline-block;
            width: 30%;
            text-align: center;
            margin: 0 1%;
        }
        .signature-box.large {
            display: block;
            margin: 10px auto 0;
            width: 50%;
        }
        .signature-box .name {
            margin-top: 50px;
            border-top: 1px solid #000;
            display: inline-block;
            width: 50%;
        }
        .signature-box .position {
            margin: 0;
            font-size: 14px;
            line-height: 1.2;
        }
        .footer p {
            font-size: 12px;
        }
        .lakalantas-section {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 4px;
            padding: 6px;
            margin-bottom: 8px;
        }
        .lakalantas-section h4 {
            color: #856404;
            background-color: #fff3cd;
            padding: 3px;
            margin: -6px -6px 4px -6px;
            border-bottom: 1px solid #ffeaa7;
        }
        .lakalantas-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }
        .lakalantas-table th, .lakalantas-table td {
            padding: 2px;
            border: 1px solid #ffeaa7;
            vertical-align: top;
        }
        .lakalantas-table th {
            background-color: #fff3cd;
            font-weight: bold;
            width: 25%;
        }
        .lakalantas-table td {
            background-color: #fffdf6;
        }
        @media print {
            body {
                margin: 0;
            }
            .footer {
                bottom: 1px;
                width: 100%;
                text-align: center;
            }
            .lakalantas-section {
                background-color: #fff3cd !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .lakalantas-table th {
                background-color: #fff3cd !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .lakalantas-table td {
                background-color: #fffdf6 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);

            setTimeout(function() {
                window.location.href = "<?= base_url('baps/bap_management'); ?>";
            }, 2000);
        };
    </script>
</head>
<body>
    <div class="header">
        <h4 class="number"><?= esc($bapdetails[0]['b_code']); ?></h4>
        <img src="<?= base_url('assets/uploads/logo_bap.png') ?>" alt="Logo" class="logo">
        <h1>Berita Acara Pemeriksaan</h1>
        <h3>Lampung, <?= date('d', strtotime($bapdetails[0]['b_tanggal_kejadian'])); ?>/<?= date('m', strtotime($bapdetails[0]['b_tanggal_kejadian'])); ?>/<?= date('Y', strtotime($bapdetails[0]['b_tanggal_kejadian'])); ?></h3>
    </div>

    <div class="content">
        <div class="section">
            <div class="info-header" style="display: flex; justify-content: space-between; align-items: center;">
                <h4 style="margin: 5px 0;">Informasi Muatan</h4>
                <div class="keberangkatan" style="font-weight: normal; font-size: 14px;">
                    Keberangkatan: <?= esc($bapdetails[0]['b_keberangkatan']); ?>
                </div>
            </div>
            <table class="form-table">
                <tr>
                    <th>NIS</th>
                    <td><?= esc($bapdetails[0]['b_nis']); ?></td>
                    <th>Jenis Muatan</th>
                    <td><?= esc($bapdetails[0]['b_muatan']); ?></td>
                </tr>
                <tr>
                    <th>Nama Supir</th>
                    <td><?= esc($bapdetails[0]['b_supir']); ?></td>
                    <th>Lokasi Muat</th>
                    <td><?= esc($bapdetails[0]['b_lokasi_muat']); ?></td>
                </tr>
                <tr>
                    <th>Mobil</th>
                    <td><?= esc($bapdetails[0]['b_nopol']); ?></td>
                    <th>Lokasi Bongkar</th>
                    <td><?= esc($bapdetails[0]['b_lokasi_bongkar']); ?></td>
                </tr>
            </table>
        </div>

        <div class="section">
            <h4 style="margin: 5px 0;">Identitas Kejadian</h4>
            <table class="form-table">
                <tr>
                    <th>Tanggal Kejadian</th>
                    <td><?= esc(date('d-m-Y', strtotime($bapdetails[0]['b_tanggal_kejadian']))); ?></td>
                    <th>Jenis Kasus</th>
                    <td><?= esc($bapdetails[0]['b_jenis_kasus']); ?></td>
                </tr>
                <tr>
                    <th>Lokasi Kejadian</th>
                    <td><?= esc($bapdetails[0]['b_lokasi_kejadian']); ?></td>
                    <th>Estimasi Klaim</th>
                    <td><?= esc($bapdetails[0]['b_estimasi_klaim']); ?></td>
                </tr>
            </table>
        </div>

        <?php if (isset($bapdetails[0]['b_jenis_kasus']) && $bapdetails[0]['b_jenis_kasus'] == 'Lakalantas' && (!empty($bapdetails[0]['b_daftar_kerusakan']) || !empty($bapdetails[0]['b_lokasi_perbaikan']) || !empty($bapdetails[0]['b_biaya_perbaikan']) || !empty($bapdetails[0]['b_biaya_lain']))): ?>
        <div class="lakalantas-section">
            <h4>Detail Lakalantas</h4>
            <table class="lakalantas-table">
                <tr>
                    <th>Daftar Kerusakan</th>
                    <td><?= !empty($bapdetails[0]['b_daftar_kerusakan']) ? esc($bapdetails[0]['b_daftar_kerusakan']) : '-' ?></td>
                </tr>
                <tr>
                    <th>Lokasi Perbaikan</th>
                    <td><?= !empty($bapdetails[0]['b_lokasi_perbaikan']) ? esc($bapdetails[0]['b_lokasi_perbaikan']) : '-' ?></td>
                </tr>
                <tr>
                    <th>Biaya Perbaikan</th>
                    <td>
                        <?php 
                        if (!empty($bapdetails[0]['b_biaya_perbaikan'])) {
                            $biaya_perbaikan = preg_replace('/[^0-9]/', '', $bapdetails[0]['b_biaya_perbaikan']);
                            if (is_numeric($biaya_perbaikan) && $biaya_perbaikan > 0) {
                                echo 'Rp ' . number_format((float)$biaya_perbaikan, 0, ',', '.');
                            } else {
                                echo esc($bapdetails[0]['b_biaya_perbaikan']);
                            }
                        } else {
                            echo '-';
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>Biaya Lain-Lain</th>
                    <td>
                        <?php 
                        if (!empty($bapdetails[0]['b_biaya_lain'])) {
                            $biaya_lain = preg_replace('/[^0-9]/', '', $bapdetails[0]['b_biaya_lain']);
                            if (is_numeric($biaya_lain) && $biaya_lain > 0) {
                                echo 'Rp ' . number_format((float)$biaya_lain, 0, ',', '.');
                            } else {
                                echo esc($bapdetails[0]['b_biaya_lain']);
                            }
                        } else {
                            echo '-';
                        }
                        ?>
                    </td>
                </tr>
            </table>
        </div>
        <?php endif; ?>

        <div class="section">
            <h4>Kronologi Singkat / Kondisi Barang : <?= esc($bapdetails[0]['b_kondisi_barang']); ?></h4>
        </div>

        <div class="header">
            <hr style="margin: 5px 0;">
            <h2 style="margin: 5px 0;">Penyelesaian Kasus</h2>
        </div>

        <div class="section">
            <h4 style="margin: 5px 0;">Kronologi Detail Kejadian : <?= esc($bapdetails[0]['b_kronologi_kejadian']); ?></h4>
            <p style="margin: 5px 0;">Dengan ini saya menerangkan sehubungan dengan, ..............................................................................</p>
            <p style="margin: 1px 0;">.............................................................................................................................................................................</p>
            <p style="margin: 1px 0;">.............................................................................................................................................................................</p>
            <p style="margin: 1px 0;">.............................................................................................................................................................................</p>
            <p style="margin: 1px 0;">.............................................................................................................................................................................</p>
            <p style="margin: 1px 0;">.............................................................................................................................................................................</p>
            <p style="margin: 1px 0;">.............................................................................................................................................................................</p>
            <p style="margin: 1px 0;">Saya bertanggung jawab atas terjadinya kasus ini. Demikian berita acara ini saya buat dengan sebenar-benarnya.</p>
        </div>

        <div class="section">
            <h4 style="margin: 2px 0;">Realisasi Klaim : <?= esc($bapdetails[0]['b_realisasi_klaim']); ?></h4>
            <table class="form-table">
                <tr>
                    <th>Jenis Potong Tagihan</th>
                    <td><?= esc($bapdetails[0]['b_potong_tagihan']); ?></td>
                </tr>
                <tr>
                    <th>Cash</th>
                    <td>Rp. <?= esc($bapdetails[0]['b_cash']); ?></td>
                </tr>
                <tr>
                    <th>Transfer</th>
                    <td style="display: flex; justify-content: space-between; align-items: center;">
                        <span>Rp. <?= esc($bapdetails[0]['b_transfer']); ?></span>
                        <span style="margin-left: auto;">Nomor Rekening :...................................A.n :...................................</span>
                    </td>
                </tr>
            </table>
        </div>

        <div class="section">
            <div style="display: flex; align-items: center; gap: 10px;">
                <h4 style="margin: 0; white-space: nowrap;">Posisi Barang :</h4>
                <div class="checkbox-group" style="display: flex; gap: 20px;">
                    <label style="display: flex; align-items: center; gap: 5px;">
                        <input type="checkbox" name="posisi_barang" value="Supir"> Supir
                    </label>
                    <label style="display: flex; align-items: center; gap: 5px;">
                        <input type="checkbox" name="posisi_barang" value="Pool YOS"> Pool YOS
                    </label>
                    <label style="display: flex; align-items: center; gap: 5px;">
                        <input type="checkbox" name="posisi_barang" value="Tempat Bongkar"> Tempat Bongkar
                    </label>
                </div>
            </div>
        </div>

        <div class="section">
            <h2>Catatan : .................................................................................................................................................</h2>
        </div>
    </div>

    <div class="signatures">
        <div class="signature-box">
            <p>Petugas BAP</p>
            <div class="name">Nama:.............</div>
        </div>
        <div class="signature-box">
            <p>Supir</p>
            <div class="name">Nama:.............</div>
        </div>
        <div class="signature-box">
            <p>Finance</p>
            <div class="name">Nama:.............</div>
        </div>
        <div class="signature-box large">
            <p>Mengetahui,</p>
            <div class="name">Nama:.............</div>
            <div class="position">Manager Operasional</div>
        </div>
    </div>
    <br>
    <div class="footer">
        <p style="margin: 1px 0;">Terima kasih atas perhatian Anda. Form ini disusun untuk keperluan BAP.</p>
    </div>
</body>
</html>