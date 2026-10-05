<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Handover Report</title>
    <style>
        body { 
            font-family: 'helvetica', Arial, sans-serif; 
            font-size: 10pt; 
            color: #333;
            margin: 0;
        }
        .header { 
            text-align: center; 
            margin-bottom: 3mm;
            border-bottom: 1px solid #2c3e50;
            padding-bottom: 1mm;
        }
        .header h1 { 
            margin: 0 0 1mm 0; 
            padding: 0;
            color: #2c3e50;
            font-size: 17pt;
            font-weight: bold;
        }
        .report-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1mm;
            font-size: 8pt;
            color: #555;
        }
        table { 
            width: 100%; 
            border-collapse: collapse;
            margin-bottom: 5mm;
            table-layout: fixed;
        }
        table th { 
            background-color: #2c3e50; 
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 8pt;
            padding: 2mm; 
            text-align: left;
            border: 0.5mm solid #2c3e50;
        }
        table td { 
            border: 0.2mm solid #ddd; 
            padding: 1.5mm;
            font-size: 9pt;
            line-height: 1.3;
            word-wrap: break-word;
        }
        table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .status-active {
            color: #27ae60;
            font-weight: bold;
            width: 7%;
        }
        .status-inactive {
            color: #db2e1d;
            font-weight: bold;
            width: 7%;
        }
        .footer { 
            margin-top: 5mm; 
            text-align: right; 
            font-size: 7pt;
            color: #555;
            border-top: 0.2mm solid #ddd;
            padding-top: 2mm;
        }
        .col-no { width: 6%; }
        .col-jenis { width: 8%; }
        .col-owner { width: 7%; }
        .col-rangka { width: 11%; }
        .col-mesin { width: 10%; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Handover Report</h1>
        <div>Generated on: <?= date('j F Y'); ?></div>
    </div>
    
    <div class="report-info">
        <div>Total Handover: <?= count($handover) ?></div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th class="col-no">No</th>
                <th>Tanggal</th>
                <th>Lokasi</th>
                <th>Nomor Polisi</th>
                <th>Supir Lama</th>
                <th>Supir Baru</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($handover as $key => $handovers): ?>
            <tr>
                <td><?= $key + 1 ?></td>
                <td> 
<?= (!empty($handovers['ho_tanggal']) && $handovers['ho_tanggal'] != '0000-00-00') ?
                        date('d-m-Y', strtotime($handovers['ho_tanggal'])) : '-' ?>
                </td>
                <td> <?php 
                    if (isset($postData['check_status']) && $postData['check_status'] === '1' && empty($handovers['ho_lokasi'])) {echo '-';
                    } else {
                        echo esc($handovers['ho_lokasi'] ?? '');
                    }
                    ?>
                </td>
                <td><?= $handovers['ho_nopol'] ?></td>
                <td> <?php 
                    if (isset($postData['check_status']) && $postData['check_status'] === '1' && empty($handovers['ho_supirlama'])) {echo '-';
                    } else {
                            echo esc($handovers['ho_supirlama'] ?? '');
                        }
                    ?> 
                </td>
                <td> <?php 
                        if (isset($postData['check_status']) && $postData['check_status'] === '1' && empty($handovers['ho_supirbaru'])) {echo '-';
                        } else {
                            echo esc($handovers['ho_supirbaru'] ?? '');
                        }
                    ?> 
                </td>
                <td>
                    <?php 
                    if (isset($postData['check_status']) && $postData['check_status'] === '1') {echo esc($handovers['ho_keterangan'] ?? 'Vehicle belum dilakukan handover');
                    } else {
                        echo esc($handovers['ho_keterangan'] ?? '');
                        }
                    ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <div class="footer">
        <div>Document - <?= date('Y') ?> &copy; SSH Group</div>
    </div>
</body>
</html>