<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Loan Report</title>
    <style>
        body { 
            font-family: 'helvetica', Arial, sans-serif; 
            font-size: 10pt; 
            color: #333;
            margin: 0;
            padding: 0;
            line-height: 1.2;
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
            margin-bottom: 1mm;
            font-size: 8pt;
            color: #555;
        }
        table { 
            width: 100%; 
            border-collapse: collapse;
            margin-bottom: 3mm;
            font-size: 8pt;
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
            border: 0.3mm solid #2c3e50;
            word-wrap: break-word;
            padding: 1.5mm;
        }
        table td { 
            border: 0.2mm solid #ddd; 
            padding: 1mm;
            font-size: 9pt;
            line-height: 1.3;
            word-wrap: break-word;
            vertical-align: top;
        }
        .badge {
            padding: 1px 4px;
            border-radius: 2px;
            font-size: 7pt;
            font-weight: bold;
        }
        .badge-success { background: #d4edda; color: #155724; }
        .badge-warning { background: #fff3cd; color: #856404; }
        .badge-danger { background: #f8d7da; color: #721c24; }
        .badge-dark { background: #d6d8d9; color: #1b1e21; }
        .badge-secondary { background: #e2e3e5; color: #383d41; }
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
        <h1>Loan Report</h1>
        <div>Generated on: <?= date('j F Y'); ?></div>
    </div>
    
    <div class="report-info">
        <div>Total Loan: <?= count($loans) ?></div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th>Tanggal</th>
                <th>Mobil</th>
                <th>Nama Supir</th>
                <th>Jenis Hutang</th>
                <th>Keterangan</th>
                <th>Cara Potong</th>
                <th>Nominal</th>
                <th>Disetujui oleh</th>
                <th>Status Hutang</th>
                <th>Status Supir</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($loans as $key => $loan): ?>
            <tr>
                <td><?= $key + 1 ?></td>
                <td><?= (!empty($loan['l_tanggal']) && $loan['l_tanggal'] != '0000-00-00') ? date('d-m-Y', strtotime($loan['l_tanggal'])) : '-' ?>
                </td>
                <td><?= esc($loan['l_nopol']) ?></td>
                <td><?= esc($loan['d_name'] ?? $loan['l_supir'] ?? ''); ?></td>
                <td>
                            <span>
                                <?php 
                                $jenisHutang = '';
                                
                                if (isset($loan['l_is_status'])) {
                                    $status = $loan['l_is_status'];
                                    
                                    if (in_array($status, [0, 1])) {
                                        $jenisHutang = 'Pribadi';
                                    } elseif (in_array($status, [4, 5])) {
                                        $jenisHutang = 'Sparepart';
                                    }
                                }
                                
                                if (empty($jenisHutang) && isset($loan['b_is_status'])) {
                                    $status = $loan['b_is_status'];
                                    if (in_array($status, [0, 2])) {
                                        $jenisKasus = !empty($loan['b_jenis_kasus']) ? " ({$loan['b_jenis_kasus']})" : '';
                                        $jenisHutang = 'Klaim' . $jenisKasus;
                                    }
                                }
                                
                                if (empty($jenisHutang)) {
                                    $jenisHutang = '-';
                                }
                                echo esc($jenisHutang);
                                ?>
                            </span>
                        </td>
                <td><?php 
                        $keterangan = '';
                        if (isset($loan['kondisi_barang']) && !empty($loan['kondisi_barang'])) {
                        $keterangan = esc($loan['kondisi_barang']);
                        } elseif (isset($loan['l_keterangan']) && !empty($loan['l_keterangan'])) {
                        $keterangan = esc($loan['l_keterangan']);
                        } else {
                        $keterangan = '-';
                        }
                        echo $keterangan;
                    ?>
                </td>
                <td><?= esc($loan['l_potong']); ?></td>
                <td><?= esc($loan['l_nominal']); ?></td>
                <td>
                    <?php
                    $creatorName = $loan['creator_name'] ?? '-';
                    $approveDate = '';
                    
                    if (isset($loan['l_tanggal_approve']) && !empty($loan['l_tanggal_approve']) && $loan['l_tanggal_approve'] != '0000-00-00') {
                        $approveDate = date('d-m-Y', strtotime($loan['l_tanggal_approve']));
                    }
                    
                    echo esc($creatorName);
                    if (!empty($approveDate)) {
                        echo '<div class="approve-info">' . $approveDate . '</div>';
                    }
                    ?>
                </td>
                <td>
                    <?php 
                        $loanStatus = $loan['l_is_status'] ?? null;
                        $bapStatus  = $loan['b_is_status'] ?? null;

                        $status = 'Unknown';

                        if ($loanStatus !== null) {
                                    if (in_array($loanStatus, [0, 5])) {
                                        $status = 'Paid';
                                    } elseif (in_array($loanStatus, [1, 4])) {
                                        $status = 'Unpaid';
                                    }
                                }

                        if ($bapStatus !== null) {
                            if ($bapStatus == 2) {
                                $status = 'Paid';
                            } elseif (in_array($bapStatus, [0,1])) {
                                $status = 'Unpaid';
                            }
                        }

                        if ($status == 'Paid') {
                            echo '<span class="badge badge-success">Paid</span>';
                        } elseif ($status == 'Unpaid') {
                            echo '<span class="badge badge-warning">Unpaid</span>';
                        } else {
                            echo '<span class="badge badge-secondary">Unknown</span>';
                        }
                    ?>
                </td>
                <td>
                    <?php
                        $driverStatus = $loan['d_is_active'] ?? ''; 
                        $statusMap = [
                        1 => ['class' => 'badge-success', 'text' => 'Active'],
                        0 => ['class' => 'badge-danger', 'text' => 'Inactive'],
                        2 => ['class' => 'badge-dark', 'text' => 'Blacklist'],
                        3 => ['class' => 'badge-warning', 'text' => 'Permission']
                    ];
                    $statusInfo = $statusMap[$driverStatus] ?? ['class' => 'badge-secondary', 'text' => 'Unknown'];
                    echo '<span class="badge ' . $statusInfo['class'] . '">' . $statusInfo['text'] . '</span>';
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