<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laka Report</title>
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
            font-size: 14pt;
            font-weight: bold;
        }
        .report-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1mm;
            font-size: 7pt;
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
            font-size: 7pt;
            padding: 1mm; 
            text-align: left;
            border: 0.3mm solid #2c3e50;
        }
        table td { 
            border: 0.2mm solid #ddd; 
            padding: 0.8mm;
            font-size: 7pt;
            line-height: 1.3;
        }
        table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .status-active {
            color: #27ae60;
            font-weight: bold;
            width: 5%;
        }
        .status-inactive {
            color: #db2e1d;
            font-weight: bold;
            width: 5%;
        }
        .status-blacklist {
            color: #0a0a0a;
            font-weight: bold;
            width: 5%;
        }
        .status-permission {
            color: #FFC107;
            font-weight: bold;
            width: 5%;
        }
        .footer { 
            margin-top: 5mm; 
            text-align: right; 
            font-size: 5pt;
            color: #555;
            border-top: 0.2mm solid #ddd;
            padding-top: 2mm;
        }
        table th:nth-child(7), table td:nth-child(7) { max-width: 13mm; }
        table th:nth-child(8), table td:nth-child(8) { max-width: 13mm; }
        table th:nth-child(9), table td:nth-child(9) { max-width: 13mm; }
        table th:nth-child(10), table td:nth-child(10) { max-width: 15mm; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laka Report</h1>
        <div>Generated on: <?= date('j F Y'); ?></div>
    </div>
    
    <div class="report-info">
        <div>Total Laka: <?= count($lakas) ?></div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th class="w-1">No</th>
                          <th>Tanggal Kejadian</th>
                          <th>Lokasi Kejadian</th>
                          <th>Nama Supir</th>
                          <th>Nomor Polisi</th>
                          <th>Tahun Mobil</th>
                          <th>Klasifikasi Kasus</th>
                          <th>Riwayat Kejadian</th>
                          <th>Daftar Kerusakan</th>
                          <th>Lokasi Perbaikan</th>
                          <th>Biaya Perbaikan</th>
                          <th>Biaya Lain-lain</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($lakas as $key => $laka): ?>
            <tr>
                <td><?= $key + 1 ?></td>
                <td><?= date('d-m-Y', strtotime($laka['b_tanggal_kejadian'])) ?>
                </td>
                        <td><?= esc($laka['b_lokasi_kejadian']); ?></td>
                        <td><?= esc($laka['b_supir']); ?></td>
                        <td><?= esc($laka['b_nopol']); ?></td>
                        <td><?= !empty($laka['v_reg_exp_date']) ? esc($laka['v_reg_exp_date']) : 'N/A'; ?></td>
                        <td><?= esc($laka['b_klasifikasi']); ?></td>
                        <td><?= esc($laka['b_kondisi_barang']); ?></td>
                        <td><?= esc($laka['b_daftar_kerusakan']); ?></td>
                        <td><?= esc($laka['b_lokasi_perbaikan']); ?></td>
                        <td><?= esc($laka['b_biaya_perbaikan']); ?></td>
                        <td><?= esc($laka['b_biaya_lain']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <div class="footer">
        <div>Copyright - <?= date('Y') ?> &copy; SSH Group</div>
    </div>
</body>
</html>