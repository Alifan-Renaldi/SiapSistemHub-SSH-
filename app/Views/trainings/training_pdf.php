<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Training Report</title>
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
        }
        table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .status-active {
            color: #27ae60;
            font-weight: bold;
            width: 10%;
        }
        .status-inactive {
            color: #db2e1d;
            font-weight: bold;
            width: 10%;
        }
        .status-blacklist {
            color: #0a0a0a;
            font-weight: bold;
            width: 10%;
        }
        .status-permission {
            color: #FFC107;
            font-weight: bold;
            width: 10%;
        }
        .footer { 
            margin-top: 5mm; 
            text-align: right; 
            font-size: 7pt;
            color: #555;
            border-top: 0.2mm solid #ddd;
            padding-top: 2mm;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Training Report</h1>
        <div>Generated on: <?= date('j F Y'); ?></div>
    </div>
    
    <div class="report-info">
        <div>Total Data: <?= count($trainings) ?></div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Training</th>
                <th>Nama Supir</th>
                <th>Kategori</th>
                <th>Pemateri</th>
                <th>Tema</th>
                <th>Status Supir</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($trainings as $key => $training): ?>
            <tr>
                <td><?= $key + 1 ?></td>
                <td><?= !empty($training['tr_tanggal']) ? date('d-m-Y', strtotime($training['tr_tanggal'])) : '-' ?></td>
                <td><strong><?= $training['tr_supir'] ?></strong></td>
                <td><?= $training['tr_kategori'] ?></td>
                <td><?= $training['tr_pemateri'] ?></td>
                <td><?= $training['tr_tema'] ?></td>
                <td class="status-<?= 
                    ($training['d_is_active'] == 1) ? 'active' :
                    (($training['d_is_active'] == 2) ? 'blacklist' : 
                    (($training['d_is_active'] == 3) ? 'permission' :'inactive')) ?>">
                    <?php 
                    if ($training['d_is_active'] == 1) {
                        echo 'Active';
                    } elseif ($training['d_is_active'] == 0) {
                        echo 'Inactive';
                    } elseif ($training['d_is_active'] == 2) {
                        echo 'Blacklist';
                    } elseif ($training['d_is_active'] == 3) {
                        echo 'Permission';
                    }
                    ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <div class="footer">
        <div>Copyright - <?= date('Y') ?> &copy; SSH Group</div>
    </div>
</body>
</html>