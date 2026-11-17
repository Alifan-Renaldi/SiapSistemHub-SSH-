<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>BAP Report</title>
    <style>
        body { 
            font-family: helvetica, Arial, sans-serif; 
            font-size: 8pt; 
            color: #333;
            margin: 0;
            padding: 0;
            line-height: 1.1;
            -webkit-print-color-adjust: exact;
        }

        /* Header tetap: tampil di setiap halaman */
        .header { 
            position: fixed;
            top: -15mm;
            left: 0;
            right: 0;
            text-align: center; 
            margin: 0;
            border-bottom: 0.5pt solid #2c3e50;
            padding-bottom: 1mm;
        }
        .header h1 { 
            margin: 0 0 0.3mm 0; 
            padding: 0;
            color: #2c3e50;
            font-size: 12pt;
            font-weight: bold;
            line-height: 1.1;
        }
        .header .generated {
            font-size: 7pt;
            line-height: 1.1;
        }
        .report-info {
            margin: 0.5mm 0 0 0;
            font-size: 6pt;
            color: #555;
            text-align: center;
            line-height: 1.1;
        }

        /* Nomor halaman kanan atas, ikut di dalam header fixed
           agar tidak menjadi root fixed tambahan per halaman */
        .page-number {
            position: absolute;
            top: 0;
            right: 0;
            font-size: 7pt;
            color: #555;
            line-height: 1.1;
        }
        .page-number::after {
            content: "Halaman " counter(page);
        }
        
        table { 
            width: 100%; 
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 2mm;
            font-size: 6pt;
            table-layout: fixed;
            word-wrap: break-word;
            page-break-inside: auto;
        }
        table th { 
            background-color: #2c3e50 !important; 
            color: white;
            font-weight: bold;
            padding: 1mm; 
            text-align: left;
            border: 0.2mm solid #1a2530;
            word-wrap: break-word;
            font-size: 6pt;
            line-height: 1.1;
        }
        table td { 
            border: 0.1mm solid #ddd; 
            padding: 0.6mm;
            word-wrap: break-word;
            vertical-align: top;
            line-height: 1.1;
            font-size: 6pt;
        }
        
        .col-no { width: 3% !important; }
        .col-date { width: 6% !important; text-align: center; vertical-align: middle;}
        .col-driver { width: 8% !important; text-align: center; vertical-align: middle; font-weight: bold; }
        .col-vehicle { width: 6% !important; }
        .col-cargo { width: 7% !important; }
        .col-location { width: 8% !important; }
        .col-incident { width: 12% !important; }
        .col-case { width: 7% !important; text-align: center; vertical-align: middle;}
        .col-claim { width: 6% !important; }
        .col-deduction { width: 6% !important; }
        .col-classification { width: 8% !important; }
        .col-status { width: 5% !important; text-align: center; vertical-align: middle;}
        
        .status-done { background: #d4edda; color: #155724; font-weight: bold; }
        .status-pending { background: #fff3cd; color: #856404; font-weight: bold; }

        /* Signature + copyright tetap di bawah setiap halaman */
        .pdf-footer {
            position: fixed;
            bottom: -25mm;
            left: 0;
            right: 0;
            margin: 0;
            padding: 0;
        }
        .signatures {
            width: 100%;
            margin: 0;
            padding: 0;
            border-collapse: collapse;
            table-layout: auto;
        }
        .signatures td {
            width: 33.33%;
            text-align: center;
            vertical-align: bottom;
            border: none;
            padding: 0 4mm;
            font-size: 6pt;
            line-height: 1.1;
        }
        .signature-title {
            font-size: 6pt;
            margin: 0;
            line-height: 1.1;
        }
        .signature-name {
            border-top: 0.5pt solid #000;
            margin: 12mm auto 0;
            padding-top: 0.5mm;
            width: 70%;
            font-size: 6pt;
            font-weight: bold;
            line-height: 1.1;
        }
        
        .footer { 
            margin-top: 2mm; 
            text-align: right; 
            font-size: 5pt;
            color: #555;
            border-top: 0.1mm solid #ddd;
            padding-top: 0.5mm;
            line-height: 1.1;
        }
        
        @page {
            size: landscape;
            margin: 18mm 5mm 30mm 5mm;
        }
        
        tr { page-break-inside: avoid; }
        thead { display: table-header-group; }
        tfoot { display: table-footer-group; }
    </style>
</head>
<body>
    <div class="header">
        <div class="page-number"></div>
        <h1>BAP Report</h1>
        <div class="generated">Generated on: <?= date('j F Y'); ?></div>
        <div class="report-info">
            Total BAP: <?= number_format(count($baps)) ?> records
        </div>
    </div>

    
    <table>
        <thead>
            <tr>
                <th class="col-no">No</th>
                <th class="col-date">Tgl Muat</th>
                <th class="col-date">Tgl Kejadian</th>
                <th class="col-date">Tgl Dibuat BAP</th>
                <th class="col-date">Tgl Selesai BAP</th>
                <th class="col-driver">Nama Supir</th>
                <th class="col-vehicle">Mobil</th>
                <th class="col-cargo">Jenis Muatan</th>
                <th class="col-location">Keberangkatan</th>
                <th class="col-location">Lokasi Kejadian</th>
                <th class="col-incident">Kronologi Kasus</th>
                <th class="col-case">Jenis Kasus</th>
                <th class="col-claim">Realisasi Klaim</th>
                <th class="col-deduction">Potong Tagihan</th>
                <th class="col-classification">Status BAP</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            // $displayBaps = array_slice($baps, 0, 300);
            foreach($baps as $key => $bap): 
            ?>
            <tr>
                <td class="col-no"><?= $key + 1 ?></td>
                <td class="col-date"><?= date('d-m-Y', strtotime($bap['b_tanggal_muat'])) ?></td>
                <td class="col-date"><?= date('d-m-Y', strtotime($bap['b_tanggal_kejadian'])) ?></td>
                <td class="col-date"><?= date('d-m-Y', strtotime($bap['b_created_date'])) ?></td>
                <td class="col-date"><?= date('d-m-Y', strtotime($bap['b_tanggal'])) ?></td>
                <td class="col-driver"><?= esc(substr($bap['b_supir'] ?? '', 0, 20)) ?></td>
                <td class="col-vehicle"><?= esc($bap['b_nopol'] ?? '') ?></td>
                <td class="col-cargo"><?= !empty($bap['b_muatan']) ? esc(substr($bap['b_muatan'], 0, 15)) : '-' ?></td>
                <td class="col-location"><?= esc(substr($bap['b_keberangkatan'] ?? '', 0, 15)) ?></td>
                <td class="col-location"><?= esc(substr($bap['b_lokasi_kejadian'] ?? '', 0, 20)) ?></td>
                <td class="col-incident"><?= esc(substr($bap['b_kondisi_barang'] ?? '', 0, 50)) ?></td>
                <td class="col-case"><?= !empty($bap['b_jenis_kasus']) ? esc(substr($bap['b_jenis_kasus'], 0, 15)) : '-' ?></td>
                <td class="col-claim"><?= esc($bap['b_realisasi_klaim'] ?? '') ?></td>
                <td class="col-deduction"><?= esc($bap['b_potong_tagihan'] ?? '') ?></td>
                <td class="col-status <?= $bap['b_is_status'] == 1 ? 'status-pending' : ($bap['b_is_status'] == 0 ? 'status-done' : '') ?>">
                    <?php if($bap['b_is_status'] == 1): ?>
                        Pending
                    <?php elseif($bap['b_is_status'] == 0): ?>
                        Done
                    <?php endif; ?>
                </td>
            </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="pdf-footer">
            <table class="signatures">
                <tr>
                    <td>
                        <div class="signature-title">Diperiksa Oleh</div>
                        <div class="signature-name">Nicky Wangsa</div>
                    </td>
                    <td>
                        <div class="signature-title">Mengetahui Pertama</div>
                        <div class="signature-name">Ibu Waryanti</div>
                    </td>
                    <td>
                        <div class="signature-title">Mengetahui Kedua</div>
                        <div class="signature-name">Pak Hendri</div>
                    </td>
                </tr>
            </table>
            <div class="footer">Copyright - <?= date('Y') ?> &copy; SSH Group</div>
        </div>
    </body>
    </html>
