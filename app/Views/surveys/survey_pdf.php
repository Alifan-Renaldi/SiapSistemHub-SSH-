<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Survey Report</title>
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
            width: 7%;
        }
        .status-inactive {
            color: #db2e1d;
            font-weight: bold;
            width: 7%;
        }
        .status-blacklist {
            color: #0a0a0a;
            font-weight: bold;
            width: 7%;
        }
        .status-permission {
            color: #FFC107;
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
    </style>
</head>
<body>
    <div class="header">
        <h1>Survey Report</h1>
        <div>Generated on: <?= date('j F Y'); ?></div>
    </div>
    
    <div class="report-info">
        <div>Total Survey:
            <?php
                if (isset($surveys) && is_array($surveys)) {
                $count = count($surveys);
                    }
                echo $count;
            ?>
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Survei</th>
                <th>Petugas Survei</th>
                <th>Nama Supir</th>
                <th>Alamat</th>
                <th>Kabupaten/Kota</th>
                <th>Provinsi</th>
                <th>Status Rumah</th>
                <th>Kondisi Rumah</th>
                <th>Jumlah Tanggungan</th>
                <th>Status Supir</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($surveys as $key => $survey): ?>
            <tr>
                <td><?= $key + 1 ?></td>
                <td><?= !empty($survey['s_tanggal']) ? date('d-m-Y', strtotime($survey['s_tanggal'])) : '-' ?></td>
                <td><?= esc($survey['s_petugas']) ?></td>
                <td><strong><?= esc($survey['s_supir']) ?></strong></td>
                <td><?= esc($survey['s_alamat']) ?></td>
                <td><?php
                        echo !empty($survey['s_city_name']) ? esc($survey['s_city_name']) :
                        (!empty($survey['s_kab']) ? esc($survey['s_kab']) : '-');
                    ?>
                </td>
                <td><?php
                        echo !empty($survey['s_province_name']) ? esc($survey['s_province_name']) :
                        (!empty($survey['s_prov']) ? esc($survey['s_prov_']) : '-');
                    ?>
                </td>
                <td><?= esc($survey['s_status_rumah']) ?></td>
                <td><?= esc($survey['s_kondisi_rumah']) ?></td>
                <td><?= esc($survey['s_tanggungan']) ?></td>
                <td class="status-<?= 
                    ($survey['d_is_active'] == 1) ? 'active' :
                    (($survey['d_is_active'] == 2) ? 'blacklist' : 
                    (($survey['d_is_active'] == 3) ? 'permission' :'inactive')) ?>">
                    <?php 
                    if ($survey['d_is_active'] == 1) {
                        echo 'Active';
                    } elseif ($survey['d_is_active'] == 0) {
                        echo 'Inactive';
                    } elseif ($survey['d_is_active'] == 2) {
                        echo 'Blacklist';
                    } elseif ($survey['d_is_active'] == 3) {
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