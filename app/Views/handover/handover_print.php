<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Serah Terima</title>
    <style>
        /* Reset dan Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: "Arial", sans-serif;
            font-size: 10px;
            color: #333;
            background: #fff;
            line-height: 1.3;
            margin: 0;
            padding: 20px;
        }
        
        .container {
            width: 100%;
            margin: 0 auto;
            padding: 12px 15px;
            background: #fff;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 0;
                background: #fff;
            }
            
            .container {
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 15px 20px;
                box-shadow: none;
                border: none;
                page-break-after: avoid;
                page-break-inside: avoid;
            }
            
            .page-break {
                page-break-before: always;
            }
            
            .no-print {
                display: none;
            }
        }
        
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 7px;
            padding-bottom: 3px;
        }
        
        .document-number {
            position: absolute;
            top: 10px;
            left: 10px;
            width: 100px;
            height: auto;
            font-weight: normal;
            font-size: 13px;
        }
        
        .logo {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 120px;
            height: auto;
        }
        
        h1 {
            font-size: 20px;
            text-transform: uppercase;
            text-align: center;
            margin: 5px 0;
        }
        
        .sub-title {
            text-align: center;
            margin: 2px 0 10px;
            font-size: 12px;
            font-weight: bold;
            font-style: italic;
        }
        
        .section-title {
            font-weight: bold;
            font-size: 12px;
            margin: 8px 0 5px;
            padding-bottom: 3px;
            border-bottom: 1px solid #3498db;
        }
        
        .two-column {
            display: flex;
            gap: 10px;
            margin-bottom: 8px;
        }
        
        .two-column > div {
            flex: 1;
        }
        
        .three-column {
            display: flex;
            gap: 8px;
            margin-bottom: 8px;
        }
        
        .three-column > div {
            flex: 1;
        }
        
        .data-item {
            display: flex;
            margin-bottom: 4px;
        }
        
        .data-label {
            font-weight: bold;
            width: 45%;
            padding-right: 5px;
        }
        
        .data-value {
            flex: 1;
            padding: 2px 5px;
            background-color: #f8f9fa;
            border-radius: 2px;
            border-left: 2px solid #3498db;
        }
        
        .photo-box {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: center;
            background: #fafafa;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        .photo-box img {
            height: 160px;
            width: auto;
            object-fit: contain;
        }

        .note-box {
            border: 1px solid #ddd;
            padding: 8px;
            background: #fafafa;
            margin-bottom: 10px;
            border-left: 3px solid #e74c3c;
        }
        
        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            text-align: center;
            gap: 15px;
        }
        
        .signature-box {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100px;
            padding: 5px;
        }
        
        .signature-name {
            font-size: 12px;
            margin-bottom: 10px;
            font-weight: bold;
            height: 15px;
            text-align: center;
            width: 100%;
        }
        
        .signature-info {
            font-size: 12px;
            height: 15px;
            margin-top: 5px;
            text-align: center;
            width: 100%;
        }
        
        .signature-area {
            width: 100%;
            min-height: 60px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            align-items: center;
            margin: 5px 0;
        }

        .signature-image {
            max-width: 100%;
            max-height: 70px;
            object-fit: contain;
            border: 1px solid #ddd;
            background: white;
        }
        
        .wide-signature-line {
            height: 1px;
            background-color: #333;
            width: 70%;
            margin: 0;
        }
        
        .footer {
            font-size: 8px;
            color: #7f8c8d;
            margin-top: 10px;
            text-align: center;
            padding-top: 5px;
            border-top: 1px solid #eee;
        }
        
        .compact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4px;
        }
        
        .mt-1 { margin-top: 5px; }
        .mb-1 { margin-bottom: 5px; }
        .text-center { text-align: center; }
        .text-small { font-size: 9px; }
        
        .paper-size-controls {
            position: fixed;
            top: 10px;
            right: 10px;
            background: rgba(255,255,255,0.9);
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            z-index: 1000;
        }
        
        .paper-size-controls button {
            padding: 5px 10px;
            margin: 0 2px;
            border: 1px solid #3498db;
            background: #fff;
            cursor: pointer;
            border-radius: 3px;
        }
        
        .paper-size-controls button.active {
            background: #3498db;
            color: white;
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="document-number"><?= esc($handoverdetails['ho_code']); ?></div>
        <img src="<?= base_url('assets/uploads/logo_bap.png') ?>" alt="Logo" class="logo">
        <h1>SERAH TERIMA KENDARAAN</h1>
        <div class="sub-title">
            <?= esc($handoverdetails['ho_lokasi']); ?>, 
            <?= date("d/m/Y", strtotime($handoverdetails['ho_tanggal'])); ?>
        </div>
    </div>

    <div id="paper-container">
        <div class="section-title">Data Serah Terima</div>
        <div class="two-column">
            <div class="photo-box">
                <?php if (!empty($handoverdetails['foto'])): ?>
                    <?php
                    	$documentName = $handoverdetails['foto'];
                        $filePath = 'assets/uploads/vehicle_handover/' . $documentName;
                        $fullPath = FCPATH . $filePath;

                        if (!empty($documentName) && file_exists($fullPath)) {
                        	$cacheBuster = '?' . filemtime($fullPath);
                            $imageUrl = base_url($filePath) . $cacheBuster;
                        } else {
                            $imageUrl = base_url('assets/uploads/user.png');
                        }
                    ?>
                    <img src="<?= $imageUrl  ?>" alt="Foto Serah Terima">
                <?php else: ?>
                    <p style="color:#888; margin-top: 40px;">Tidak ada foto</p>
                <?php endif; ?>
            </div>

            <div>
                <div class="data-item">
                    <span class="data-label">Nomor Polisi</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_nopol']); ?></div>
                </div>
                <div class="data-item">
                    <span class="data-label">Tipe Mobil</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_jenis']); ?></div>
                </div>
                <div class="data-item">
                    <span class="data-label">Supir Lama</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_supirlama']); ?></div>
                </div>
                <div class="data-item">
                    <span class="data-label">Supir Baru</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_supirbaru']); ?></div>
                </div>
                <div class="data-item">
                    <span class="data-label">Kilometer</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_km']); ?></div>
                </div>
                <div class="data-item">
                    <span class="data-label">Jumlah Solar</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_solar']); ?></div>
                </div>
            </div>
        </div>

        <div class="section-title">Kondisi Kendaraan</div>
        <div class="two-column">
            <div>
                <div class="data-item">
                    <span class="data-label">Kabin Mobil</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_kabin']); ?></div>
                </div>
                <div class="data-item">
                    <span class="data-label">Kabel Body</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_kabel']); ?></div>
                </div>
                <div class="data-item">
                    <span class="data-label">Lampu Besar Depan</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_lampubesar']); ?></div>
                </div>
                <div class="data-item">
                    <span class="data-label">Lampu Rem R/L</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_lampurem']); ?></div>
                </div>
                <div class="data-item">
                    <span class="data-label">Lampu Sein Depan R/L</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_seindpn']); ?></div>
                </div>
                <div class="data-item">
                    <span class="data-label">Lampu Sein Belakang R/L</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_seinblk']); ?></div>
                </div>
            </div>
            <div>
                <div class="data-item">
                    <span class="data-label">Wiper</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_wiper']); ?></div>
                </div>
                <div class="data-item">
                    <span class="data-label">Spion Bulat R/L</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_spion']); ?></div>
                </div>
                <div class="data-item">
                    <span class="data-label">Tangki Solar 1</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_tangki1']); ?></div>
                </div>
                <div class="data-item">
                    <span class="data-label">Tangki Solar 2</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_tangki2']); ?></div>
                </div>
                <div class="data-item">
                    <span class="data-label">Kondisi Bak</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_bak']); ?></div>
                </div>
                <div class="data-item">
                    <span class="data-label">Pintu Kupu-Kupu</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_pintu']); ?></div>
                </div>
            </div>
        </div>

        <div class="section-title">Kondisi Ban</div>
        <div class="two-column">
            <div class="compact-grid">
                <div class="data-item">
                    <span class="data-label">Ban Depan Kiri</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_bandpnkr']); ?></div>
                </div>
                <div class="data-item">
                    <span class="data-label">Merk Ban Depan Kiri</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_merkbankr']); ?></div>
                </div>
                <div class="data-item">
                    <span class="data-label">Ban Depan Kanan</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_bandpnkn']); ?></div>
                </div>
                <div class="data-item">
                    <span class="data-label">Merk Ban Depan Kanan</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_merkbankn']); ?></div>
                </div>
                <div class="data-item">
                    <span class="data-label">Ban Belakang Kiri Luar</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_banblkkrlr']); ?></div>
                </div>
                <div class="data-item">
                    <span class="data-label">Merk Ban Belakang Kiri Luar</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_merkbankrlr']); ?></div>
                </div>
                <div class="data-item">
                    <span class="data-label">Ban Belakang Kanan Luar</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_banblkknlr']); ?></div>
                </div>
                <div class="data-item">
                    <span class="data-label">Merk Ban Belakang Kanan Luar</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_merkbanknlr']); ?></div>
                </div>
                <div class="data-item">
                    <span class="data-label">Ban Belakang Kiri Dalam</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_banblkkrdlm']); ?></div>
                </div>
                <div class="data-item">
                    <span class="data-label">Merk Ban Belakang Kiri Dalam</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_merkbankrdlm']); ?></div>
                </div>
            </div>
            <div class="compact-grid">
                <div class="data-item">
                    <span class="data-label">Ban Belakang Kanan Dalam</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_banblkkndlm']) ?></div>
                </div>
                <div class="data-item">
                    <span class="data-label">Merk Ban Belakang Kanan Dalam</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_merkbankndlm']) ?></div>
                </div>
                <div class="data-item">
                    <span class="data-label">Ban Tarik Kiri Luar</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_bantrkkrlr']) ?></div>
                </div>
                <div class="data-item">
                    <span class="data-label">Merk Ban Tarik Kiri Luar</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_merkbantrkkrlr']) ?></div>
                </div>
                <div class="data-item">
                    <span class="data-label">Ban Tarik Kanan Luar</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_bantrkknlr']) ?></div>
                </div>
                <div class="data-item">
                    <span class="data-label">Merk Ban Tarik Kanan Luar</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_merkbantrkknlr']) ?></div>
                </div>
                <div class="data-item">
                    <span class="data-label">Ban Tarik Kiri Dalam</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_bantrkkrdlm']) ?></div>
                </div>
                <div class="data-item">
                    <span class="data-label">Merk Ban Tarik Kiri Dalam</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_merkbantrkkrdlm']) ?></div>
                </div>
                <div class="data-item">
                    <span class="data-label">Ban Tarik Kanan Dalam</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_bantrkkndlm']) ?></div>
                </div>
                <div class="data-item">
                    <span class="data-label">Merk Ban Tarik Kanan Dalam</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_merkbantrkkndlm']) ?></div>
                </div>
            </div>
        </div>

        <div class="section-title">Kondisi Velg</div>
        <div class="two-column">
            <div class="compact-grid">
                <div class="data-item">
                    <span class="data-label">Velg Depan Kiri</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_velgdpnkr']) ?></div>
                </div>
                <div class="data-item">
                    <span class="data-label">Merk Velg Depan Kiri</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_merkukuranvelgdpnkr']) ?></div>
                </div>
                <div class="data-item">
                    <span class="data-label">Velg Depan Kanan</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_velgdpnkn']) ?></div>
                </div>
                <div class="data-item">
                    <span class="data-label">Merk Velg Depan Kanan</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_merkukuranvelgdpnkn']) ?></div>
                </div>
                <div class="data-item">
                    <span class="data-label">Velg Belakang Kiri Luar</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_velgblkkrlr']) ?></div>
                </div>
                <div class="data-item">
                    <span class="data-label">Merk Velg Belakang Kiri Luar</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_merkukuranvelgblkkrlr']) ?></div>
                </div>
            </div>
            <div class="compact-grid">
                <div class="data-item">
                    <span class="data-label">Velg Belakang Kanan Luar</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_velgblkknlr']) ?></div>
                </div>
                <div class="data-item">
                    <span class="data-label">Merk Velg Belakang Kanan Luar</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_merkukuranvelgblknlr']) ?></div>
                </div>
                <div class="data-item">
                    <span class="data-label">Velg Belakang Kiri Dalam</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_velgblkkrdlm']) ?></div>
                </div>
                <div class="data-item">
                    <span class="data-label">Merk Velg Belakang Kiri Dalam</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_merkukuranvelgblkkrdlm']) ?></div>
                </div>
                <div class="data-item">
                    <span class="data-label">Velg Belakang Kanan Dalam</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_velgblkkndlm']) ?></div>
                </div>
                <div class="data-item">
                    <span class="data-label">Merk Velg Belakang Kanan Dalam</span>
                    <div class="data-value"><?= esc($handoverdetails['ho_merkukuranvelgblkndlm']) ?></div>
                </div>
            </div>
        </div>

        <div class="section-title">Catatan</div>
        <div class="note-box">
            <?= esc($handoverdetails['ho_keterangan']); ?>
        </div>

        <div class="signature-section">
            <div class="signature-box">
                <div class="signature-name">Supir Lama</div>
                <div class="signature-area">
                    <?php if (!empty($handoverdetails['signature_supir_lama'])): ?>
                        <img src="<?= $handoverdetails['signature_supir_lama'] ?>" 
                             alt="Tanda Tangan Supir Lama" 
                             class="signature-image">
                    <?php else: ?>
                        <div class="wide-signature-line"></div>
                    <?php endif; ?>
                </div>
                <div class="signature-info">( <?= esc($handoverdetails['ho_supirlama']); ?> )</div>
            </div>
            <div class="signature-box">
                <div class="signature-name">Supir Baru</div>
                <div class="signature-area">
                    <?php if (!empty($handoverdetails['signature_supir_baru'])): ?>
                        <img src="<?= $handoverdetails['signature_supir_baru'] ?>" 
                             alt="Tanda Tangan Supir Baru" 
                             class="signature-image">
                    <?php else: ?>
                        <div class="wide-signature-line"></div>
                    <?php endif; ?>
                </div>
                <div class="signature-info">( <?= esc($handoverdetails['ho_supirbaru']); ?> )</div>
            </div>
            <div class="signature-box">
                <div class="signature-name">Petugas Serah Terima</div>
                <div class="signature-area">
                    <?php if (!empty($handoverdetails['signature_petugas'])): ?>
                        <img src="<?= $handoverdetails['signature_petugas'] ?>" 
                             alt="Tanda Tangan Petugas" 
                             class="signature-image">
                    <?php else: ?>
                        <div class="wide-signature-line"></div>
                    <?php endif; ?>
                </div>
                <div class="signature-info">
                    ( <?= !empty($handoverdetails['nama_petugas']) ? esc($handoverdetails['nama_petugas']) : '....................................' ?> )
                </div>
            </div>
        </div>

        <div class="footer">
            Dokumen ini dicetak secara otomatis pada <?= date("d/m/Y H:i:s"); ?>
        </div>
    </div>

<script>
    window.onload = function() {
        setTimeout(() => window.print(), 500);
        setTimeout(() => window.location.href = "<?= base_url('handover/handover_management'); ?>", 2000);
    };
</script>
</body>
</html>