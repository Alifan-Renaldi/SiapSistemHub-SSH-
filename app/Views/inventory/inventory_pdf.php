<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Inventory Report</title>
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
            font-size: 7pt;
            padding: 2mm; 
            text-align: left;
            border: 0.5mm solid #2c3e50;
        }
        table td { 
            border: 0.2mm solid #ddd; 
            padding: 1.5mm;
            font-size: 8pt;
            line-height: 1.3;
            word-wrap: break-word;
        }
        .status-active {
            color: #27ae60;
            font-weight: bold;
        }
        .status-inactive {
            color: #db2e1d;
            font-weight: bold;
        }
        .footer { 
            margin-top: 5mm; 
            text-align: right; 
            font-size: 7pt;
            color: #555;
            border-top: 0.2mm solid #ddd;
            padding-top: 2mm;
        }
        .col-no { width: 4%; }
        .col-tanggal { width: 10%; }
        .col-nopol { width: 12%; }
        .col-jenis { width: 12%; }
        .col-tahun { width: 6%; }
        .col-status { width: 13%; }
        .col-keterangan { width: 25%; }
        .col-updater { width: 12%; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Inventory Report</h1>
        <div>Generated on: <?= date('j F Y'); ?></div>
    </div>
    
    <div class="report-info">
        <div>Total Inventory: <?= count($inventory) ?></div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th class="col-no">No</th>
                <th class="col-tanggal">Tanggal Cek</th>
                <th class="col-nopol">Nomor Polisi</th>
                <th class="col-jenis">Jenis Mobil</th>
                <th class="col-tahun">Tahun</th>
                <th class="col-status">Status Inventaris</th>
                <th class="col-keterangan">Keterangan</th>
                <th class="col-updater">Diperbarui oleh</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($inventory as $key => $inventorys): ?>
            <tr>
                <td><?= $key + 1 ?></td>
                <td>
                    <?php 
                    if ($inventorys['iv_is_active'] == 0) {
                        echo '-';
                    } else {
                        echo !empty($inventorys['iv_modified_date']) ? date('d-m-Y', strtotime($inventorys['iv_modified_date'])) : '-';
                    }
                    ?>
                </td>
                <td><?= esc($inventorys['iv_nopol'] ?? '') ?></td>
                <td><?= esc($inventorys['iv_jenis'] ?? '') ?></td>
                <td><?= esc($inventorys['iv_tahun'] ?? '') ?></td>
                <td class="status-<?= ($inventorys['iv_is_active'] == 1) ? 'active' : 'inactive' ?>">
                    <?php 
                    if ($inventorys['iv_is_active'] == 1) {
                        echo 'Sudah Pengecekan';
                    } else {
                        echo 'Belum Pengecekan';
                    }
                    ?>
                </td>
                <td>
                    <?php 
                    if ($inventorys['iv_is_active'] == 0) {
                        echo 'Kendaraan belum dilakukan inventory check';
                    } else {
                        echo esc($inventorys['iv_keterangan'] ?? '');
                    }
                    ?>
                </td>
                <td>
                    <?php 
                    if ($inventorys['iv_is_active'] == 0) {
                        echo '-';
                    } else {
                        echo esc($inventorys['creator_name'] ?? $inventorys['iv_created_by'] ?? '');
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