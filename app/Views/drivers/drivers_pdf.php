<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Driver Report</title>
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
        <h1>Driver Report</h1>
        <div>Generated on: <?= date('j F Y') ?></div>
    </div>
    
    <div class="report-info">
        <div>Total Drivers: <?= count($drivers) ?></div>
        <?php if(!empty($filters['date_from']) || !empty($filters['date_to'])): ?>
        <div>Period: 
            <?= !empty($filters['date_from']) ? date('j M Y', strtotime($filters['date_from'])) : 'All' ?> 
            - 
            <?= !empty($filters['date_to']) ? date('j M Y', strtotime($filters['date_to'])) : 'All' ?>
        </div>
        <?php endif; ?>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama Supir</th>
                <th>Umur</th>
                <th>BPJS</th>
                <th>Tanggal Masuk</th>
                <th>Tanggal Keluar</th>
                <th>Masa Kerja</th>
                <th>Referensi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($drivers as $key => $driver): ?>
            <tr>
                <td><?= $key + 1 ?></td>
                <td><?= esc($driver['d_nis']) ?></td>
                <td><strong><?= esc($driver['d_name']) ?></strong></td>
                <td>
                    <?php
                    if (!empty($driver['d_dob'])) {
                        $tanggal_lahir = new \DateTime($driver['d_dob']);
                        $tanggal_sekarang = new \DateTime();
                        $selisih = $tanggal_lahir->diff($tanggal_sekarang);
                        echo $selisih->y . ' Thn';
                    } else {
                        echo '-';
                    }
                    ?>
                </td>
                <td><?= !empty($driver['d_cardbpjs']) ? esc($driver['d_cardbpjs']) : '-' ?></td>
                <td>
                    <?= (!empty($driver['d_doj']) && $driver['d_doj'] != '0000-00-00') ? 
                        date('d-m-Y', strtotime($driver['d_doj'])) : '-' ?>
                </td>
                <td>
                    <?= (!empty($driver['d_resigndate']) && $driver['d_resigndate'] != '0000-00-00') ? 
                        date('d-m-Y', strtotime($driver['d_resigndate'])) : '-' ?>
                </td>
                <td>
                    <?php
                    if (!empty($driver['d_doj']) && $driver['d_doj'] != '0000-00-00') {
                        $tanggal_masuk = new \DateTime($driver['d_doj']);
                        $tanggal_akhir = (!empty($driver['d_resigndate']) && $driver['d_resigndate'] != '0000-00-00') ? 
                                        new \DateTime($driver['d_resigndate']) : new \DateTime();
                        $selisih = $tanggal_masuk->diff($tanggal_akhir);
                        echo $selisih->y . 'Thn ' . $selisih->m . 'Bln ' . $selisih->d . 'Hr';
                    } else {
                        echo '-';
                    }
                    ?>
                </td>
                <td><?= !empty($driver['d_ref']) ? esc($driver['d_ref']) : '-' ?></td>
                <td class="status-<?= 
                    ($driver['d_is_active'] == 1) ? 'active' :
                    (($driver['d_is_active'] == 2) ? 'blacklist' : 
                    (($driver['d_is_active'] == 3) ? 'permission' : 'inactive')) ?>">
                    <?php 
                    if ($driver['d_is_active'] == 1) {
                        echo 'Active';
                    } elseif ($driver['d_is_active'] == 0) {
                        echo 'Inactive';
                    } elseif ($driver['d_is_active'] == 2) {
                        echo 'Blacklist';
                    } elseif ($driver['d_is_active'] == 3) {
                        echo 'Permission';
                    } else {
                        echo 'Unknown';
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