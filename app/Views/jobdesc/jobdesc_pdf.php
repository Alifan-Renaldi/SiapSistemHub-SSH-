<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Jobdesc Report</title>
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
        .jobdesc-card {
            border: 0.4mm solid #ddd;
            border-radius: 1mm;
            margin-bottom: 4mm;
            page-break-inside: avoid;
        }
        .card-header {
            background-color: #f2f4f7;
            padding: 2mm;
            border-bottom: 0.4mm solid #ddd;
            font-size: 10pt;
        }
        .card-header .field {
            margin-bottom: 0.5mm;
        }
        .card-header b {
            color: #2c3e50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        table th {
            background-color: #2c3e50;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 8pt;
            padding: 1.5mm;
            text-align: left;
            border: 0.3mm solid #2c3e50;
        }
        table td {
            border: 0.2mm solid #ddd;
            padding: 1.5mm;
            font-size: 9pt;
            line-height: 1.3;
            word-wrap: break-word;
        }
        .col-no { width: 12%; }
        .col-desc { width: 38%; }
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
        <h1>Jobdesc Report</h1>
        <div>Generated on: <?= date('j F Y'); ?></div>
    </div>

    <div class="report-info">
        <div>Total Karyawan: <?= count($jobdesc) ?></div>
    </div>

    <?php foreach($jobdesc as $item): ?>
    <div class="jobdesc-card">
        <div class="card-header">
            <div class="field"><b>Nama Karyawan:</b> <?= esc($item['jk_nama_karyawan'] ?? '-'); ?></div>
            <div class="field"><b>Nama Divisi:</b> <?= esc($item['jk_divisi'] ?? '-'); ?></div>
        </div>
        <table>
            <thead>
                <tr>
                    <th class="col-no">No</th>
                    <th class="col-desc">Indikator Pekerjaan</th>
                    <th class="col-no">No</th>
                    <th class="col-desc">Indikator Pekerjaan</th>
                </tr>
            </thead>
            <tbody>
                <?php for($i = 1; $i <= 6; $i++): ?>
                <tr>
                    <td><b>Indikator <?= $i; ?></b></td>
                    <td><?= esc((!empty($item['jk_indikator_' . $i])) ? $item['jk_indikator_' . $i] : '-'); ?></td>
                    <td><b>Indikator <?= $i + 6; ?></b></td>
                    <td><?= esc((!empty($item['jk_indikator_' . ($i + 6)])) ? $item['jk_indikator_' . ($i + 6)] : '-'); ?></td>
                </tr>
                <?php endfor; ?>
            </tbody>
        </table>
    </div>
    <?php endforeach; ?>

    <div class="footer">
        <div>Document - <?= date('Y') ?> &copy; SSH Group</div>
    </div>
</body>
</html>
