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
            margin: 2mm;
            padding: 0;
            line-height: 1.1;
            -webkit-print-color-adjust: exact;
        }
        .header { 
            text-align: center; 
            margin-bottom: 2mm;
            border-bottom: 0.5pt solid #2c3e50;
            padding-bottom: 1mm;
        }
        .header h1 { 
            margin: 0 0 0.5mm 0; 
            padding: 0;
            color: #2c3e50;
            font-size: 12pt;
            font-weight: bold;
        }
        .report-info {
            margin-bottom: 1mm;
            font-size: 6pt;
            color: #555;
            text-align: center;
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
        .col-date { width: 6% !important; }
        .col-driver { width: 8% !important; }
        .col-vehicle { width: 6% !important; }
        .col-cargo { width: 7% !important; }
        .col-location { width: 8% !important; }
        .col-incident { width: 12% !important; }
        .col-case { width: 7% !important; }
        .col-claim { width: 6% !important; }
        .col-deduction { width: 6% !important; }
        .col-classification { width: 8% !important; }
        
        .badge {
            padding: 0.5px 2px;
            border-radius: 1px;
            font-size: 5pt;
            font-weight: bold;
            display: inline-block;
        }
        .badge-success { background: #d4edda; color: #155724; }
        .badge-warning { background: #fff3cd; color: #856404; }
        
        .footer { 
            margin-top: 3mm; 
            text-align: right; 
            font-size: 5pt;
            color: #555;
            border-top: 0.1mm solid #ddd;
            padding-top: 1mm;
        }
        
        @page {
            size: landscape;
            margin: 5mm;
        }
        
        tr { page-break-inside: avoid; }
        thead { display: table-header-group; }
        tfoot { display: table-footer-group; }
    </style>
</head>
<body>
    <div class="header">
        <h1>BAP Report</h1>
        <div style="font-size: 7pt;">Generated on: <?= date('j F Y'); ?></div>
    </div>
    
    <div class="report-info">
        Total BAP: <?= number_format(count($baps)) ?> records
    </div>
    
    <table>
        <thead>
            <tr>
                <th class="col-no">No</th>
                <th class="col-date">Tgl Dibuat</th>
                <th class="col-date">Tgl BAP</th>
                <th class="col-date">Tgl Kejadian</th>
                <th class="col-driver">Nama Supir</th>
                <th class="col-vehicle">Mobil</th>
                <th class="col-cargo">Jenis Muatan</th>
                <th class="col-location">Keberangkatan</th>
                <th class="col-location">Lokasi Kejadian</th>
                <th class="col-incident">Kronologi Kasus</th>
                <th class="col-case">Jenis Kasus</th>
                <th class="col-claim">Realisasi Klaim</th>
                <th class="col-deduction">Potong Tagihan</th>
                <th class="col-deduction">Cash</th>
                <th class="col-deduction">Transfer</th>
                <th class="col-classification">Klasifikasi Kasus</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            // $displayBaps = array_slice($baps, 0, 300);
            foreach($baps as $key => $bap): 
            ?>
            <tr>
                <td class="col-no"><?= $key + 1 ?></td>
                <td class="col-date"><?= date('d-m-Y', strtotime($bap['b_created_date'])) ?></td>
                <td class="col-date">
                     
                </td>
                <td class="col-date"><?= date('d-m-Y', strtotime($bap['b_tanggal_kejadian'])) ?></td>
                <td class="col-driver"><strong><?= esc(substr($bap['b_supir'] ?? '', 0, 20)) ?></strong></td>
                <td class="col-vehicle"><?= esc($bap['b_nopol'] ?? '') ?></td>
                <td class="col-cargo"><?= !empty($bap['b_muatan']) ? esc(substr($bap['b_muatan'], 0, 15)) : '-' ?></td>
                <td class="col-location"><?= esc(substr($bap['b_keberangkatan'] ?? '', 0, 15)) ?></td>
                <td class="col-location"><?= esc(substr($bap['b_lokasi_kejadian'] ?? '', 0, 20)) ?></td>
                <td class="col-incident"><?= esc(substr($bap['b_kondisi_barang'] ?? '', 0, 50)) ?></td>
                <td class="col-case"><?= !empty($bap['b_jenis_kasus']) ? esc(substr($bap['b_jenis_kasus'], 0, 15)) : '-' ?></td>
                <td class="col-claim"><?= esc($bap['b_realisasi_klaim'] ?? '') ?></td>
                <td class="col-deduction"><?= esc($bap['b_potong_tagihan'] ?? '') ?></td>
                <td class="col-deduction"><?= esc($bap['b_cash'] ?? '') ?></td>
                <td class="col-deduction"><?= esc($bap['b_transfer'] ?? '') ?></td>
                <td class="col-classification"><?= esc(substr($bap['b_klasifikasi'] ?? '', 0, 20)) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <?php if (count($baps) > 300): ?>
    <div style="text-align: center; font-size: 6pt; color: #666; margin-top: 2mm;">
        Note: Showing first 300 records of <?= number_format(count($baps)) ?> total records
    </div>
    <?php endif; ?>
    
    <div class="footer">
        <div>Copyright - <?= date('Y') ?> &copy; SSH Group</div>
    </div>
</body>
</html>