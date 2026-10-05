<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Vehicle Report</title>
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
            font-size: 8pt;
            line-height: 1.3;
            word-wrap: break-word;
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
        .col-no { width: 4%; }
        .col-owner { width: 7%; }
        .col-jenis { width: 6%; }
        .col-rangka { width: 8%; }
        .col-mesin { width: 8%; }
        .col-uji { width: 8%; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Vehicle Report</h1>
        <div>Generated on: <?= date('j F Y'); ?></div>
    </div>
    
    <div class="report-info">
        <div>Total Vehicle: <?= count($vehicle) ?></div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th class="col-no">No</th>
                <th>Nomor Polisi</th>
                <th class="col-owner">Pemilik</th>
                <th class="col-jenis">Jenis Mobil</th>
                <?php if (function_exists('userpermission') && userpermission('lr_vech_detail_num')) : ?>
                <th class="col-rangka">Nomor Rangka</th>
                <th class="col-mesin">Nomor Mesin</th>
                <th class="col-uji">Nomor Uji</th>
                <?php endif; ?>
                <th>JT Pajak</th>
                <th>JT Plat</th>
                <th>JT Kir</th>
                <th>Proses KIR</th>
                <th>Lokasi KIR</th>
                <th>Catatan KIR</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($vehicle as $key => $vehicles): ?>
            <tr>
                <td><?= $key + 1 ?></td>
                <td><?= $vehicles['v_registration_no'] ?></td>
                <td><strong><?= $vehicles['v_legal'] ?></strong></td>
                <td><?= $vehicles['v_name'] ?></td>
                <?php if (function_exists('userpermission') && userpermission('lr_vech_detail_num')) : ?>
                <td><?= $vehicles['v_chassis_no'] ?></td>
                <td><?= $vehicles['v_engine_no'] ?></td>
                <td><?= $vehicles['v_uji_no'] ?></td>
                <?php endif; ?>
                <td><?= date('d-m-Y', strtotime($vehicles['v_stnk_expdate'])) ?></td>
                <td><?= date('d-m-Y', strtotime($vehicles['v_plat_expdate'])) ?></td>
                <td><?= date('d-m-Y', strtotime($vehicles['v_kir_expdate'])) ?></td>
                <td><?= date('d-m-Y', strtotime($vehicles['v_kir_process_date'])) ?></td>
                <td><?= $vehicles['v_lokasi_kir'] ?></td>
                <td><?= $vehicles['v_notes_lokasikir'] ?></td>
                <td class="status-<?= ($vehicles['v_is_active'] == 1) ? 'active' : 'inactive' ?>">
                    <?php 
                    if ($vehicles['v_is_active'] == 1) {
                        echo 'Active';
                    } else {
                        echo 'Inactive';
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