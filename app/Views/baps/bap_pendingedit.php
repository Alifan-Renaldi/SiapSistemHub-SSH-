<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><?= (isset($bapdetails)) ? 'Update Penyelesaian Kasus' : '' ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('baps/bap_management'); ?>">BAP</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('baps/bap_pending'); ?>">Pending</a></li>
                    <li class="breadcrumb-item active"><?= (isset($bapdetails)) ? 'Update Pending' : '' ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <form method="post" id="editpending_bap" class="card <?= (isset($bapdetails)) ? 'updatebap_pending' : ''; ?>" enctype="multipart/form-data" action="<?= base_url('drivers/' . ((isset($bapdetails)) ? 'updatebap_pending' : '')); ?>">
            <!--<?= csrf_field() ?>-->
            <div class="card-body">
                <h3 class="text-center">Berita Acara Pemeriksaan</h3>
                <hr>
                <div class="row">
                    <!-- Photo Upload Section -->
                    <div class="col-md-4">
                        <div class="card" style="min-height: 430px;">
                            <div class="card-body">
                                <h4 class="text-center">Upload Dokumen BAP</h4>
                                <hr>
                                <div class="form-group">
                                    <label class="form-label">Lampiran 1 (JPG/JPEG/PNG/PDF)</label>
                                    <input type="file" name="b_document" id="b_document" class="form-control" accept="image/*,application/pdf">
                                    <input type="hidden" name="existing_document" value="<?= esc($bapdetails[0]['b_document'] ?? ''); ?>">
                                    <?php $photo = !empty($bapdetails[0]['b_document']) ? $bapdetails[0]['b_document'] : 'Dokumen BAP.png'; $isPdf = strtolower(pathinfo($photo, PATHINFO_EXTENSION)) === 'pdf';?>
                                        <div id="document_preview_container">
                                             <?php if (!empty($bapdetails[0]['b_document'])): ?>
                                             <?php if ($isPdf): ?>
                                                <a href="<?= base_url('assets/uploads/bap/' . esc($photo)) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-file-pdf"></i> Lihat Dokumen PDF
                                                </a>
                                            <?php else: ?>
                                        <img id="document_preview" src="<?= base_url('assets/uploads/bap/' . esc($photo)) ?>" 
                                             alt="Preview Document BAP" 
                                             style="margin-left: 3px; margin-top: 7px; max-width:300px; max-height:300px; object-fit:cover;" />
                                                <?php endif; ?>
                                            <?php else: ?>
                                            <p class="text-muted">Tidak ada dokumen yang diunggah.</p>
                                        <?php endif; ?>
                                        </div>
                                </div> 
                                <hr>
                                <div class="form-group">
                                    <label class="form-label">Lampiran 2 (PDF)
                                    <?php if (userpermission('lr_drivers_edit_bapsolution')): ?>
                                        <span class="form-required" style="color: red;">*</span></label>
                                    <input type="file" name="b_pdf" id="b_pdf" class="form-control">
                                    <input type="hidden" name="existing_pdf" value="<?= esc($bapdetails[0]['b_pdf'] ?? ''); ?>">
                                    <?php if (!empty($bapdetails[0]['b_pdf'])): ?>
                                        <a href="<?= base_url('assets/uploads/bap/pdf/' . esc($bapdetails['b_pdf'])) ?>" 
                                           target="_blank">Lihat Dokumen PDF</a>
                                    <?php else: ?>
                                        <p>Tidak ada dokumen PDF yang diunggah.</p>
                                    <?php endif; ?>

                                    <?php else: ?>
                                        <input type="hidden" name="existing_pdf" value="<?= esc($bapdetails[0]['b_pdf'] ?? ''); ?>">
                                        <?php if (!empty($bapdetails[0]['b_pdf'])): ?>
                                            <div class="d-flex align-items-center">
                                                <a href="<?= base_url('assets/uploads/bap/pdf/' . esc($bapdetails[0]['b_pdf'])) ?>" 
                                                   target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-file-pdf"></i> Lihat Dokumen PDF
                                                </a>
                                                <span class="ml-2"><?= esc($bapdetails[0]['b_pdf']) ?></span>
                                            </div>
                                        <?php else: ?>
                                            <p class="text-muted">Tidak ada dokumen PDF yang diunggah.</p>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Personal Information Section -->
                    <div class="col-md-8">
                        <div class="card" style="min-height: 300px;">
                            <div class="card-body">
                                <div class="row">
                                    <input type="hidden" name="b_id" id="b_id" value="<?= (isset($bapdetails)) ? esc($bapdetails[0]['b_id']) : '' ?>" >

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Nomor BAP<span class="form-required"></span></label>
                                            <input type="text" id="b_code" class="form-control" name="b_code" value="<?= (isset($bapdetails) && !empty($bapdetails[0]['b_code'])) ? esc($bapdetails[0]['b_code']) : esc($new_bap_code) ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Nomor Induk Supir<span class="form-required"></span></label>
                                            <input type="text" id="b_nis" class="form-control" name="b_nis" value="<?= (isset($bapdetails)) ? esc($bapdetails[0]['b_nis']) : ''; ?>" placeholder="" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Lokasi Muat (Asal)</label>
                                            <?php if (userpermission('lr_drivers_edit_bappending')): ?>
                                                <span class="form-required" style="color: red; font-size: 20px;">*</span>
                                                <input type="text" name="b_lokasi_muat" value="<?= (isset($bapdetails)) ? esc($bapdetails[0]['b_lokasi_muat']) : ''; ?>" class="form-control">
                                            <?php else: ?>
                                                <input type="text" name="b_lokasi_muat" value="<?= (isset($bapdetails)) ? esc($bapdetails[0]['b_lokasi_muat']) : ''; ?>" class="form-control" readonly>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Tanggal Kejadian</label>
                                            <?php if (userpermission('lr_drivers_edit_bappending')): ?>
                                                <span class="form-required" style="color: red; font-size: 20px;">*</span>
                                                <input type="text" name="b_tanggal_kejadian" id="b_tanggal_kejadian" value="<?= (isset($bapdetails)) ? esc($bapdetails[0]['b_tanggal_kejadian']) : ''; ?>" class="form-control datepicker form-equal-height">
                                            <?php else: ?>
                                                <input type="text" name="b_tanggal_kejadian" id="b_tanggal_kejadian" value="<?= (isset($bapdetails)) ? esc($bapdetails[0]['b_tanggal_kejadian']) : ''; ?>" class="form-control" readonly>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Lokasi Bongkar (Tujuan)</label>
                                            <?php if (userpermission('lr_drivers_edit_bappending')): ?>
                                                <span class="form-required" style="color: red; font-size: 20px;">*</span>
                                                <input type="text" name="b_lokasi_bongkar" value="<?= (isset($bapdetails)) ? esc($bapdetails[0]['b_lokasi_bongkar']) : ''; ?>" class="form-control">
                                            <?php else: ?>
                                                <input type="text" name="b_lokasi_bongkar" value="<?= (isset($bapdetails)) ? esc($bapdetails[0]['b_lokasi_bongkar']) : ''; ?>" class="form-control" readonly>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Nama Supir</label>
                                            <?php if (userpermission('lr_drivers_edit_bappending')): ?>
                                                <span class="form-required" style="color: red; font-size: 20px;">*</span>
                                                <select id="b_supir" class="form-control form-control-sm select2 form-equal-height" name="b_supir" onchange="updateNIS()">
                                                <option value="">-- Pilih Supir --</option>
                                                <?php 
                                                    usort($driverlist, function($a, $b) {
                                                        return strcmp($a['d_name'], $b['d_name']);
                                                    });
                                                    
                                                    foreach ($driverlist as $driver) {
                                                        $selected = '';
                                                        if (isset($bapdetails[0]['b_supir']) && $bapdetails[0]['b_supir'] == $driver['d_name'] && $driver['d_is_active'] == 1) {
                                                            $selected = 'selected';
                                                        }
                                                        if ($driver['d_is_active'] == 1) {
                                                            echo '<option value="' . esc($driver['d_name']) . '" data-nis="' . esc($driver['d_nis']) . '" ' . $selected . '>' . esc($driver['d_name']) . '</option>';
                                                        }
                                                    }
                                                    ?>
                                            </select>
                                            <?php else: ?>
                                                <input type="text" value="<?= (isset($bapdetails)) ? esc($bapdetails[0]['b_supir']) : ''; ?>" class="form-control" readonly>
                                                <input type="hidden" name="b_supir" value="<?= (isset($bapdetails)) ? esc($bapdetails[0]['b_supir']) : ''; ?>">
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Lokasi Kejadian</label>
                                            <?php if (userpermission('lr_drivers_edit_bappending')): ?>
                                                <span class="form-required" style="color: red; font-size: 20px;">*</span>
                                                <input type="text" name="b_lokasi_kejadian" value="<?= (isset($bapdetails)) ? esc($bapdetails[0]['b_lokasi_kejadian']) : ''; ?>" class="form-control">
                                            <?php else: ?>
                                                <input type="text" name="b_lokasi_kejadian" value="<?= (isset($bapdetails)) ? esc($bapdetails[0]['b_lokasi_kejadian']) : ''; ?>" class="form-control" readonly>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Mobil</label>
                                            <?php if (userpermission('lr_drivers_edit_bappending')): ?>
                                                <span class="form-required" style="color: red; font-size: 20px;">*</span>
                                                <select id="b_nopol" class="form-control form-control-sm select2-vehicle form-equal-height" name="b_nopol">
                                                <option value="">-- Pilih Mobil --</option>
                                                <?php 
                                                foreach ($vechiclelist as $vehicle) {
                                                    $combinedValue = $vehicle['v_registration_no'] . ' - ' . $vehicle['v_name'];
                                                    $selected = '';
                                                    if (isset($bapdetails[0]['b_nopol']) && $bapdetails[0]['b_nopol'] == $combinedValue && $vehicle['v_is_active'] == 1) {
                                                        $selected = 'selected';
                                                    }
                                                    if ($vehicle['v_is_active'] == 1) {
                                                    echo '<option value="' . esc($combinedValue) . '" ' . $selected . '>'
                                                        . esc($vehicle['v_registration_no'] . ' - ' . $vehicle['v_name'])
                                                        . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <?php else: ?>
                                                <input type="text" name="b_nopol" value="<?= (isset($bapdetails)) ? esc($bapdetails[0]['b_nopol']) : ''; ?>" class="form-control" readonly>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Jenis Kasus</label>
                                            <?php if (userpermission('lr_drivers_edit_bappending')): ?>
                                                <span class="form-required" style="color: red; font-size: 20px;">*</span>
                                                <select id="b_jenis_kasus" name="b_jenis_kasus" class="form-control">
                                                <option value="">-- Pilih Kasus --</option>
                                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_jenis_kasus'] == 'Barang Rusak') ? 'selected' : '' ?> value="Barang Rusak">Barang Rusak</option>
                                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_jenis_kasus'] == 'Barang Kurang/Hilang') ? 'selected' : '' ?> value="Barang Kurang/Hilang">Barang Kurang/Hilang</option>
                                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_jenis_kasus'] == 'Inventaris Mobil Hilang/Rusak') ? 'selected' : '' ?> value="Inventaris Mobil Hilang/Rusak">Inventaris Mobil Hilang/Rusak</option>
                                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_jenis_kasus'] == 'Lakalantas') ? 'selected' : '' ?> value="Lakalantas">Lakalantas</option>
                                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_jenis_kasus'] == 'Mobil Rusak') ? 'selected' : '' ?> value="Mobil Rusak">Mobil Rusak</option>
                                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_jenis_kasus'] == 'Supir Bermasalah') ? 'selected' : '' ?> value="Supir Bermasalah">Supir Bermasalah</option>
                                            </select>
                                            <?php else: ?>
                                                <input type="text" name="b_jenis_kasus" value="<?= (isset($bapdetails)) ? esc($bapdetails[0]['b_jenis_kasus']) : ''; ?>" class="form-control" readonly>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Jenis Muatan</label>
                                            <?php if (userpermission('lr_drivers_edit_bappending')): ?>
                                                <span class="form-required" style="color: red; font-size: 20px;">*</span>
                                                <input type="text" name="b_muatan" value="<?= (isset($bapdetails)) ? esc($bapdetails[0]['b_muatan']) : ''; ?>" class="form-control">
                                            <?php else: ?>
                                                <input type="text" name="b_muatan" value="<?= (isset($bapdetails)) ? esc($bapdetails[0]['b_muatan']) : ''; ?>" class="form-control" readonly>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Kronologi Singkat/Kondisi Barang</label>
                                            <?php if (userpermission('lr_drivers_edit_bappending')): ?>
                                                <span class="form-required" style="color: red; font-size: 20px;">*</span>
                                                <textarea class="form-control" name="b_kondisi_barang" rows="3"><?= (isset($bapdetails)) ? esc($bapdetails[0]['b_kondisi_barang']) : '' ?></textarea>
                                            <?php else: ?>
                                                <textarea class="form-control" name="b_kondisi_barang" rows="3" readonly><?= (isset($bapdetails)) ? esc($bapdetails[0]['b_kondisi_barang']) : '' ?></textarea>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Keberangkatan</label>
                                            <?php if (userpermission('lr_drivers_edit_bappending')): ?>
                                                <span class="form-required" style="color: red; font-size: 20px;">*</span>
                                                <select id="b_keberangkatan" name="b_keberangkatan" class="form-control">
                                                <option value="">-- Pilih Keberangkatan --</option>
                                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_keberangkatan'] == 'Jakarta') ? 'selected' : '' ?> value="Jakarta">Jakarta</option>
                                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_keberangkatan'] == 'Lampung') ? 'selected' : '' ?> value="Lampung">Lampung</option>
                                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_keberangkatan'] == 'Utara') ? 'selected' : '' ?> value="Utara">Utara</option>
                                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_keberangkatan'] == 'Langsir') ? 'selected' : '' ?> value="Langsir">Langsir</option>
                                            </select>
                                            <?php else: ?>
                                                <input type="text" name="b_keberangkatan" value="<?= (isset($bapdetails)) ? esc($bapdetails[0]['b_keberangkatan']) : ''; ?>" class="form-control" readonly>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Estimasi Klaim</label>
                                            <?php if (userpermission('lr_drivers_edit_bappending')): ?>
                                                <span class="form-required" style="color: red; font-size: 20px;">*</span>
                                                <select id="b_estimasi_klaim" name="b_estimasi_klaim" class="form-control">
                                                <option value="">-- Pilih Estimasi --</option>
                                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_estimasi_klaim'] == 'Rp.0 - Rp.1.000.000') ? 'selected' : '' ?> value="Rp.0 - Rp.1.000.000">Rp.0 - Rp.1.000.000</option>
                                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_estimasi_klaim'] == 'Rp.1.000.000 - Rp.9.999.999') ? 'selected' : '' ?> value="Rp.1.000.000 - Rp.9.999.999">Rp.1.000.000 - Rp.9.999.999</option>
                                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_estimasi_klaim'] == 'Rp.10.000.000 - Rp.50.000.000') ? 'selected' : '' ?> value="Rp.10.000.000 - Rp.50.000.000">Rp.10.000.000 - Rp.50.000.000</option>
                                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_estimasi_klaim'] == '>Rp.50.000.000') ? 'selected' : '' ?> value=">Rp.50.000.000">>Rp.50.000.000</option>
                                            </select>
                                            <?php else: ?>
                                                <input type="text" name="b_estimasi_klaim" value="<?= (isset($bapdetails)) ? esc($bapdetails[0]['b_estimasi_klaim']) : ''; ?>" class="form-control" readonly>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row lakalantas-fields" style="display: none;">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Detail Lakalantas</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Daftar Kerusakan</label>
                                            <textarea class="form-control" name="b_daftar_kerusakan" rows="3" oninput="this.value = capitalizeEachWord(this.value)"><?= isset($bapdetails) ? esc($bapdetails[0]['b_daftar_kerusakan'] ?? '') : '' ?></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Lokasi Perbaikan</label>
                                            <input type="text" name="b_lokasi_perbaikan" value="<?= isset($bapdetails) ? esc($bapdetails[0]['b_lokasi_perbaikan'] ?? '') : '' ?>" oninput="this.value = capitalizeEachWord(this.value)" class="form-control">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Biaya Perbaikan</label>
                                            <input type="text" name="b_biaya_perbaikan" value="<?= isset($bapdetails) ? esc($bapdetails[0]['b_biaya_perbaikan'] ?? '') : '' ?>" class="form-control lakalantas-number-input">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Biaya Lain-Lain</label>
                                            <input type="text" name="b_biaya_lain" value="<?= isset($bapdetails) ? esc($bapdetails[0]['b_biaya_lain'] ?? '') : '' ?>" class="form-control lakalantas-number-input">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>
                <h3 class="text-center">Penyelesaian Kasus</h3>
                <hr>
                <div class="row">
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Tanggal BAP
                                <?php if (userpermission('lr_drivers_edit_bapsolution')): ?>
                                    <span class="form-required" style="color: red;">*</span></label>
                                    <input type="text" name="b_tanggal" id="b_tanggal"
                                        value="<?= (isset($bapdetails) && $bapdetails[0]['b_tanggal'] !== '0000-00-00') ? esc($bapdetails[0]['b_tanggal']) : ''; ?>" class="form-control datepicker">
                                        <!-- <div id="b_tanggal_error" class="text-danger" style="display:none; font-size: 12px;">Tanggal BAP harus diisi dengan tanggal yang valid.
                                        </div> -->
                                    <?php else: ?>
                                    <input type="text" name="b_tanggal" id="b_tanggal" value="<?= (isset($bapdetails)) ? esc($bapdetails[0]['b_tanggal']) : ''; ?>" class="form-control" readonly>
                                <?php endif; ?>
                            </div>
                        </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Korelasi Kasus
                                <?php if (userpermission('lr_drivers_edit_bapsolution')): ?>
                                <span class="form-required" style="color: red;">*</span></label>
                                    <select id="b_korelasi_kasus" name="b_korelasi_kasus" class="form-control">
                                    <option value="">-- Pilih Korelasi --</option>
                                    <option <?= (isset($bapdetails) && $bapdetails[0]['b_korelasi_kasus'] == 'Muatan') ? 'selected' : ''; ?> value="Muatan">Muatan</option>
                                    <option <?= (isset($bapdetails) && $bapdetails[0]['b_korelasi_kasus'] == 'Mobil') ? 'selected' : ''; ?> value="Mobil">Mobil</option>
                                    <option <?= (isset($bapdetails) && $bapdetails[0]['b_korelasi_kasus'] == 'Supir') ? 'selected' : ''; ?> value="Supir">Supir</option>
                                    </select>
                                <?php else: ?>
                                <input type="text" name="b_korelasi_kasus" value="<?= (isset($bapdetails)) ? esc($bapdetails[0]['b_korelasi_kasus']) : ''; ?>" class="form-control" readonly>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Realisasi Klaim
                            <?php if (userpermission('lr_drivers_edit_bapsolution')): ?>
                                <span class="form-required" style="color: red;">*</span></label>
                                <input type="text" name="b_realisasi_klaim" value="<?= (isset($bapdetails)) ? esc($bapdetails[0]['b_realisasi_klaim']) : ''; ?>" class="form-control" id="realisasiKlaimInput">
                                        <?php else: ?>
                                <input type="text" name="b_realisasi_klaim" value="<?= (isset($bapdetails)) ? esc($bapdetails[0]['b_realisasi_klaim']) : ''; ?>" class="form-control" readonly>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Posisi Barang
                                <?php if (userpermission('lr_drivers_edit_bapsolution')): ?>
                                <span class="form-required" style="color: red;">*</span></label>
                                <select id="b_posisi_barang" name="b_posisi_barang" class="form-control">
                                <option value="">-- Pilih Posisi --</option>
                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_posisi_barang'] == 'Yos') ? 'selected' : ''; ?> value="Yos">Yos</option>
                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_posisi_barang'] == 'Supir') ? 'selected' : ''; ?> value="Supir">Supir</option>
                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_posisi_barang'] == 'Tempat Bongkar') ? 'selected' : ''; ?> value="Tempat Bongkar">Tempat Bongkar</option>
                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_posisi_barang'] == 'Lainnya') ? 'selected' : ''; ?> value="Lainnya">Lainnya</option>
                                </select>
                                <?php else: ?>
                                <input type="text" name="b_posisi_barang" value="<?= (isset($bapdetails)) ? esc($bapdetails[0]['b_posisi_barang']) : ''; ?>" class="form-control" readonly>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Potong Tagihan
                                <?php if (userpermission('lr_drivers_edit_bapsolution')): ?>
                                <span class="form-required" style="color: red;">*</span></label>
                                <select id="b_potong_tagihan" name="b_potong_tagihan" class="form-control">
                                <option value="">-- Pilih Carpot --</option>
                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_potong_tagihan'] == 'POT. SUJ 30%') ? 'selected' : ''; ?> value="POT. SUJ 30%">POT. SUJ 30%</option>
                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_potong_tagihan'] == 'POT. SUJ Langsung') ? 'selected' : ''; ?> value="POT. SUJ Langsung">POT. SUJ Langsung</option>
                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_potong_tagihan'] == 'POT. SUJ Bertahap') ? 'selected' : ''; ?> value="POT. SUJ Bertahap">POT. SUJ Bertahap</option>
                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_potong_tagihan'] == 'CASH') ? 'selected' : ''; ?> value="CASH">CASH</option>
                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_potong_tagihan'] == 'CASH + SUJ 30%') ? 'selected' : ''; ?> value="CASH + SUJ 30%">CASH + SUJ 30%</option>
                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_potong_tagihan'] == 'Tunggu Nilai Klaim') ? 'selected' : ''; ?> value="Tunggu Nilai Klaim">Tunggu Nilai Klaim</option>
                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_potong_tagihan'] == 'Tidak Klaim') ? 'selected' : ''; ?> value="Tidak Klaim">Tidak Klaim</option>
                                </select>
                                <?php else: ?>
                                <input type="text" name="b_potong_tagihan" value="<?= (isset($bapdetails)) ? esc($bapdetails[0]['b_potong_tagihan']) : ''; ?>" class="form-control" readonly>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Cash</label>
                            <input type="text" name="b_cash" value="<?= (isset($bapdetails)) ? esc($bapdetails[0]['b_cash']) : ''; ?>" class="form-control">
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Transfer</label>
                            <input type="text" name="b_transfer" value="<?= (isset($bapdetails)) ? esc($bapdetails[0]['b_transfer']) : ''; ?>" class="form-control" id="transferInput">
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Klasifikasi</label>
                            <input type="text" id="b_klasifikasi" name="b_klasifikasi" class="form-control" readonly 
                                   value="<?= isset($bapdetails['b_klasifikasi']) ? esc($bapdetails[0]['b_klasifikasi']) : ''; ?>">
            
                            <div class="d-flex align-items-center mt-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="b_status_korban" id="meninggal" value="MENINGGAL" 
                                           onclick="handleCheckbox(this, 'tidak_meninggal')"
                                           <?= (isset($bapdetails) && $bapdetails[0]['b_status_korban'] == 'MENINGGAL') ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="meninggal">MENINGGAL</label>
                                </div>
                                <div class="form-check form-check-inline ml-2">
                                    <input class="form-check-input" type="checkbox" name="b_status_korban" id="tidak_meninggal" value="TIDAK MENINGGAL" 
                                           onclick="handleCheckbox(this, 'meninggal')"
                                           <?= (isset($bapdetails) && $bapdetails[0]['b_status_korban'] == 'TIDAK MENINGGAL') ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="tidak_meninggal">TIDAK MENINGGAL</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Kronologi Detail Kejadian</label>
                            <?php if (userpermission('lr_drivers_edit_bapsolution')): ?>
                                <span class="form-required" style="color: red; font-size: 20px;">*</span>
                                <textarea class="form-control" <?= (strpos(current_url(), 'addbap') !== false) ? 'disabled' : ''; ?> name="b_kronologi_kejadian" rows="3"><?= (isset($bapdetails)) ? esc($bapdetails[0]['b_kronologi_kejadian']) : '' ?></textarea>
                                    <?php else: ?>
                                <textarea class="form-control" name="b_kronologi_kejadian" rows="3" readonly><?= (isset($bapdetails)) ? esc($bapdetails[0]['b_kronologi_kejadian']) : '' ?></textarea>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-12">
                    <div class="form-group">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" autocomplete="off" placeholder="Catatan" name="b_keterangan"><?= (isset($bapdetails)) ? esc($bapdetails[0]['b_keterangan']) : '' ?></textarea>
                    </div>
                </div>

                <input type="hidden" id="b_modified_date" name="b_modified_date" value="<?= date('Y-m-d H:i:s'); ?>">

                <div class="card-footer d-flex">
                    <a href="<?= base_url('baps/bap_pending'); ?>" class="btn btn-warning" onclick="return confirmCancel()">
                        <i class="fa fa-left"></i> CANCEL
                    </a>
                    <button id="btn-submit" type="button" class="btn btn-primary ml-auto" onclick="return confirmSave()"> 
                        <?= (isset($bapdetails)) ? 'UPDATE' : ''; ?>
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>
<?= view('layout/footer') ?>

<script src="<?= base_url('assets/autoLogout.js') ?>"></script>
<script>
    const baseUrl = "<?= base_url() ?>"; 
    enableAutoLogout(7200, baseUrl + "login");

    $('.select2').on('change', function() {
            $(this).valid();
        });

    $('.select2-vehicle').on('change', function() {
            $(this).valid();
        });

    $('.select2').select2({
        placeholder: "-- Pilih Supir --",
        allowClear: true
    });

    $('.select2-vehicle').select2({
        placeholder: "-- Pilih Mobil --",
        allowClear: true
    });
    
    function capitalizeEachWord(str) {
        return str.toLowerCase().replace(/\b\w/g, function(letter) {
            return letter.toUpperCase();
        });
    }

    function confirmSave() {
         Swal.fire({
            title: "Apakah anda yakin ingin mengupdate data BAPS tersebut?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#28a745",
            cancelButtonColor: "#dc3545",
            confirmButtonText: "Update",
            cancelButtonText: "Batalkan"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('btn-submit').form.submit();
            }
        })
        const lakalantasValidation = validateLakalantasFields();
        if (!lakalantasValidation.isValid) {
            lakalantasValidation.errorElement.scrollIntoView({ 
                behavior: 'smooth', 
                block: 'center' 
            });
            lakalantasValidation.errorElement.focus();
            return false;
        }
    }

    function confirmCancel() {
        Swal.fire({
            title: "Apakah anda yakin ingin membatalkan proses ini?",
            icon: "warning",
            confirmButtonColor: "#28a745",
            confirmButtonText: "Batalkan",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?= base_url('baps/bap_pending') ?>";
            }
        })
    }

    function updateNIS() {
        const driverSelect = document.getElementById('b_supir');
        const selectedOption = driverSelect.options[driverSelect.selectedIndex];
        const nis = selectedOption.getAttribute('data-nis');
        document.getElementById('b_nis').value = nis || '';
    }

    $('#b_document').change(function(e) {
        const reader = new FileReader();
        reader.onload = function(event) {
            $('#document_preview').attr('src', event.target.result).show();
        }
        reader.readAsDataURL(e.target.files[0]);
    });

    function clearLakalantasFields() {
        const fields = [
            'b_daftar_kerusakan',
            'b_lokasi_perbaikan', 
            'b_biaya_perbaikan',
            'b_biaya_lain'
        ];
        
        fields.forEach(fieldName => {
            const input = document.querySelector(`[name="${fieldName}"]`);
            if (input) {
                input.value = '';
                console.log(`Cleared field: ${fieldName}`);
            }
        });
        
        console.log('All Lakalantas fields cleared');
    }

    function toggleLakalantasFields() {
        const jenisKasusSelect = document.getElementById('b_jenis_kasus');
        const lakalantasFields = document.querySelector('.lakalantas-fields');
        const isLakalantas = jenisKasusSelect.value === 'Lakalantas';
        
        if (lakalantasFields) {
            if (isLakalantas) {
                lakalantasFields.style.display = 'block';
            } else {
                lakalantasFields.style.display = 'none';
                // Reset error states ketika fields disembunyikan
                resetLakalantasErrors();
            }
        }
    }

    function resetLakalantasErrors() {
        const errors = document.querySelectorAll('.lakalantas-error');
        const inputs = document.querySelectorAll('.lakalantas-fields input, .lakalantas-fields textarea');
        
        errors.forEach(error => {
            error.style.display = 'none';
        });
        
        inputs.forEach(input => {
            input.classList.remove('is-invalid');
            input.style.border = '';
        });
    }

    function validateLakalantasFields() {
        const jenisKasusSelect = document.getElementById('b_jenis_kasus');
        const isLakalantas = jenisKasusSelect.value === 'Lakalantas';
        
        console.log('Validating Lakalantas fields. Is Lakalantas:', isLakalantas);
        
        if (!isLakalantas) {
            return { isValid: true, errorElement: null };
        }
        
        let firstErrorElement = null;
        let allValid = true;
        
        fields.forEach(field => {
            const input = document.querySelector(`[name="${field.name}"]`);
            const errorDiv = input?.parentNode?.querySelector('.lakalantas-error');
            
            console.log('Checking field:', field.name, 'Value:', input?.value);
            
            // Reset error state
            if (errorDiv) {
                errorDiv.style.display = 'none';
            }
            if (input) {
                input.classList.remove('is-invalid');
                input.style.border = '';
            }
            
            // Check if field is empty
            if (input && (!input.value || input.value.trim() === '')) {
                console.log('Field is empty:', field.name);
                allValid = false;
                
                // Show error
                if (errorDiv) {
                    errorDiv.style.display = 'block';
                }
                if (input) {
                    input.classList.add('is-invalid');
                    input.style.border = '1px solid #dc3545';
                }
                
                // Set first error element for scrolling
                if (!firstErrorElement) {
                    firstErrorElement = input;
                }
            }
        });
        
        console.log('Validation result:', allValid);
        
        return {
            isValid: allValid,
            errorElement: firstErrorElement
        };
    }

    function formatLakalantasNumberInputs() {
        document.querySelectorAll('.lakalantas-number-input').forEach(input => {
            input.addEventListener('input', function() {
                let value = this.value.replace(/[^0-9]/g, '');
                if (value) {
                    value = parseInt(value).toLocaleString('id-ID');
                }
                this.value = value;
            });
        });
    }

    $(document).ready(function() {
        const bapForm = $('#editpending_bap.updatebap_pending');
    
    if (bapForm.length > 0) {
        console.log('Initializing BAP pending edit validation...');
        
        if ($.data(bapForm[0], 'validator')) {
            bapForm.validate().destroy();
        }
        
        // Define rules based on permission
        const validationRules = {};
        const validationMessages = {};
        
        <?php if (userpermission('lr_drivers_edit_bapsolution')): ?>
            validationRules.b_tanggal = { required: true };
            validationRules.b_korelasi_kasus = { required: true };
            validationRules.b_realisasi_klaim = { required: true };
            validationRules.b_posisi_barang = { required: true };
            validationRules.b_potong_tagihan = { required: true };
            validationRules.b_kronologi_kejadian = { required: true };
            
            validationMessages.b_tanggal = { required: "Tanggal BAP belum terisi" };
            validationMessages.b_korelasi_kasus = { required: "Korelasi Kasus belum terisi" };
            validationMessages.b_realisasi_klaim = { required: "Realisasi Klaim belum terisi" };
            validationMessages.b_posisi_barang = { required: "Posisi Barang belum terisi" };
            validationMessages.b_potong_tagihan = { required: "Potong Tagihan belum terisi" };
            validationMessages.b_kronologi_kejadian = { required: "Harap Melengkapi Kronologi Detail Kejadian" };
        <?php endif; ?>

        <?php if (userpermission('lr_drivers_edit_bappending')): ?>
            validationRules.b_tanggal_kejadian = { required: true };
            validationRules.b_lokasi_muat = { required: true };
            validationRules.b_lokasi_bongkar = { required: true };
            validationRules.b_supir = { required: true };
            validationRules.b_lokasi_kejadian = { required: true };
            validationRules.b_nopol = { required: true };
            validationRules.b_jenis_kasus = { required: true };
            validationRules.b_muatan = { required: true };
            validationRules.b_kondisi_barang = { required: true };
            validationRules.b_keberangkatan = { required: true };
            validationRules.b_estimasi_klaim = { required: true };
            
            validationMessages.b_tanggal_kejadian = { required: "Tanggal Kejadian belum terisi" };
            validationMessages.b_lokasi_muat = { required: "Lokasi Muat belum terisi" };
            validationMessages.b_lokasi_bongkar = { required: "Lokasi Bongkar belum terisi" };
            validationMessages.b_supir = { required: "Nama Supir belum terisi" };
            validationMessages.b_lokasi_kejadian = { required: "Lokasi Kejadian belum terisi" };
            validationMessages.b_nopol = { required: "Mobil belum terisi" };
            validationMessages.b_jenis_kasus = { required: "Jenis Kasus belum terisi" };
            validationMessages.b_muatan = { required: "Jenis Muatan belum terisi" };
            validationMessages.b_kondisi_barang = { required: "Kronologi Singkat belum terisi" };
            validationMessages.b_keberangkatan = { required: "Keberangkatan belum terisi" };
            validationMessages.b_estimasi_klaim = { required: "Estimasi Klaim belum terisi" };
        <?php endif; ?>
        
        // Re-initialize validation conditional rules
        bapForm.validate({
            errorClass: "invalid-feedback",
            rules: validationRules,
            messages: validationMessages,
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            errorPlacement: function(error, element) {
                if (element.hasClass('select2-vehicle') || element.hasClass('select2')) {
                    error.insertAfter(element.next('.select2-container'));
                } else {
                    error.insertAfter(element);
                }
            },
            highlight: function(element, errorClass, validClass) {
                if ($(element).hasClass('select2-vehicle') || $(element).hasClass('select2')) {
                    const select2Container = $(element).next('.select2-container');
                    const select2Selection = select2Container.find('.select2-selection');
                    select2Selection.addClass('is-invalid');
                    select2Selection.removeClass('is-valid');
                } else {
                    $(element).addClass('is-invalid');
                    $(element).removeClass('is-valid');
                }
            },
            unhighlight: function(element, errorClass, validClass) {
                if ($(element).hasClass('select2-vehicle') || $(element).hasClass('select2')) {
                    const select2Container = $(element).next('.select2-container');
                    const select2Selection = select2Container.find('.select2-selection');
                    select2Selection.removeClass('is-invalid');
                    select2Selection.addClass('is-valid');
                } else {
                    $(element).removeClass('is-invalid');
                    $(element).addClass('is-valid');
                }
            },
            submitHandler: function(form) {
                const lakalantasValidation = validateLakalantasFields();
                if (!lakalantasValidation.isValid) {
                    lakalantasValidation.errorElement.scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'center' 
                    });
                    lakalantasValidation.errorElement.focus();
                    return false;
                }

                const cashValidationResult = validateCashField();
                if (!cashValidationResult.isValid) {
                    cashValidationResult.errorElement.scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'center' 
                    });
                    cashValidationResult.errorElement.focus();
                    return false;
                }
                if (confirmSave()) {
                    return validateBapPendingForm(form);
                } else {
                    return false;
                }
            }
        });
        
        console.log('BAP pending edit validation initialized with rules:', validationRules);
    }
    const jenisKasusSelect = document.getElementById('b_jenis_kasus');
    if (jenisKasusSelect) {
        // Initial check
        toggleLakalantasFields();

        jenisKasusSelect.setAttribute('data-previous-value', jenisKasusSelect.value);
        
        // Add event listener
        jenisKasusSelect.addEventListener('change', function() {
            console.log('Jenis kasus changed to:', this.value);
            const previousValue = this.getAttribute('data-previous-value');
    const isChangingFromLakalantas = previousValue === 'Lakalantas' && this.value !== 'Lakalantas';

    this.setAttribute('data-previous-value', this.value);
    
    if (isChangingFromLakalantas) {
        console.log('Changing from Lakalantas to another type, clearing fields...');
        clearLakalantasFields();
    }

            toggleLakalantasFields();
        });
    }
    
    formatLakalantasNumberInputs();
    });

<?php if (userpermission('lr_drivers_edit_bapsolution')): ?>
    document.addEventListener('DOMContentLoaded', function() {
        const pdfInput = document.getElementById('b_pdf');
        const pdfSection = pdfInput.closest('.form-group');
        const existingPdf = document.querySelector('input[name="existing_pdf"]').value;
        const pdfError = document.createElement('div');
        pdfError.id = 'pdf_error';
        pdfError.style.color = 'red';
        pdfError.style.display = 'none';
        pdfError.textContent = 'Harap unggah dokumen PDF';
        pdfSection.appendChild(pdfError);

        const pdfFormatError = document.createElement('div');
        pdfFormatError.id = 'pdf_format_error';
        pdfFormatError.style.color = 'red';
        pdfFormatError.style.display = 'none';
        pdfFormatError.textContent = 'Hanya format PDF yang diperbolehkan';
        pdfSection.appendChild(pdfFormatError);

        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            pdfError.style.display = 'none';
            pdfFormatError.style.display = 'none';
            
            if (pdfInput.files.length > 0) {
                const file = pdfInput.files[0];
                if (file.type !== 'application/pdf') {
                    e.preventDefault();
                    pdfFormatError.style.display = 'block';
                    highlightInput(pdfInput);
                    scrollToPdfSection();
                    return;
                }
            }
            else if (!existingPdf) {
                e.preventDefault();
                pdfError.style.display = 'block';
                highlightInput(pdfInput);
                scrollToPdfSection();
            }
        });

        pdfInput.addEventListener('change', function() {
            pdfError.style.display = 'none';
            pdfFormatError.style.display = 'none';
            
            if (this.files.length > 0) {
                const file = this.files[0];
                
                if (file.type !== 'application/pdf') {
                    pdfFormatError.style.display = 'block';
                    highlightInput(this);
                    this.value = '';
                    scrollToPdfSection();
                    return;
                }
                
                this.style.border = '';
                this.style.boxShadow = '';
                
                const pdfInfo = this.nextElementSibling.nextElementSibling;
                if (pdfInfo) {
                    if (pdfInfo.tagName === 'P') {
                        pdfInfo.textContent = 'Nama Dokumen: ' + file.name;
                    } else if (pdfInfo.tagName === 'A') {
                        pdfInfo.textContent = 'Lihat Dokumen PDF: ' + file.name;
                    }
                }
            }
        });

        function highlightInput(input) {
            input.style.border = '1px solid red';
            input.style.boxShadow = '0 0 5px rgba(255, 0, 0, 0.5)';
        }

        function scrollToPdfSection() {
            pdfSection.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
            
            pdfSection.style.animation = 'highlight 1s';
            setTimeout(() => {
                pdfSection.style.animation = '';
            }, 1000);
        }

        if (existingPdf) {
            const pdfLink = pdfSection.querySelector('a');
            if (pdfLink) {
                pdfLink.textContent = 'Lihat Dokumen PDF: ' + existingPdf;
            } else {
                const pdfInfo = pdfSection.querySelector('p');
                if (pdfInfo) {
                    pdfInfo.textContent = 'Nama Dokumen: ' + existingPdf;
                }
            }
        }
    });
    <?php endif; ?>

    const style = document.createElement('style');
    style.textContent = `
        @keyframes highlight {
            0% { background-color: rgba(255, 255, 0, 0.3); }
            100% { background-color: transparent; }
        }

        input[name="b_cash"][readonly] {
            background-color: #e9ecef !important;
            cursor: not-allowed;
            color: #6c757d;
        }
        
        input[name="b_cash"]:not([readonly]) {
            background-color: #ffffff;
            color: #495057;
            cursor: text;
        }
        
        .cash-required-star {
            color: red;
            font-weight: bold;
        }
        
        .cash-error-message {
            display: block !important;
            font-size: 0.875em;
            color: #dc3545;
        }

        .lakalantas-fields {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #ff0000;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .lakalantas-fields .form-group {
            margin-bottom: 1rem;
        }

        .is-invalid {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
        }

        .lakalantas-error {
            font-size: 0.875em;
            margin-top: 0.25rem;
        }
    `;
    document.head.appendChild(style);

    document.addEventListener('DOMContentLoaded', function() {
        const realisasiKlaimInput = document.getElementById('realisasiKlaimInput');
        const transferInput = document.getElementById('transferInput');
        const bKlasifikasi = document.getElementById('b_klasifikasi');
        const cashInput = document.querySelector('input[name="b_cash"]');
        const potongTagihanSelect = document.getElementById('b_potong_tagihan');
        const form = document.getElementById('editpending_bap');

        cashInput.setAttribute('readonly', 'readonly');
        cashInput.style.backgroundColor = '#e9ecef';
        
        function formatNumberInput(input) {
            let value = input.value.replace(/[^0-9]/g, '');
            if(value) {
                value = parseInt(value).toLocaleString('id-ID');
            }
            input.value = value;
            return parseInt(value.replace(/[^0-9]/g, '') || 0);
        }

        function getNumericValue(input) {
        return parseInt(input.value.replace(/[^0-9]/g, '')) || 0;
    }

        function updateCashFieldStatus() {
        const selectedValue = potongTagihanSelect.value;
        const isCashRelated = selectedValue === 'CASH' || selectedValue === 'CASH + SUJ 30%';
        
            if (isCashRelated) {
                cashInput.removeAttribute('readonly');
                cashInput.style.backgroundColor = '';
                cashInput.focus();

                const cashLabel = cashInput.closest('.form-group').querySelector('label');
                if (cashLabel && !cashLabel.querySelector('.cash-required-star')) {
                    const requiredStar = document.createElement('span');
                    requiredStar.className = 'cash-required-star';
                    requiredStar.textContent = ' *';
                    cashLabel.appendChild(requiredStar);
                }

            } else {
                cashInput.setAttribute('readonly', 'readonly');
                cashInput.style.backgroundColor = '#e9ecef';
                cashInput.value = '';

                const cashLabel = cashInput.closest('.form-group').querySelector('label');
                if (cashLabel) {
                    const requiredStar = cashLabel.querySelector('.cash-required-star');
                    if (requiredStar) {
                        requiredStar.remove();
                    }
                }
                
                const existingError = cashInput.parentNode.querySelector('.cash-error-message');
                if (existingError) {
                    existingError.remove();
                }
                cashInput.classList.remove('is-invalid');
            }
        }

         function validateCashField() {
            const selectedValue = potongTagihanSelect.value;
            const isCashRelated = selectedValue === 'CASH' || selectedValue === 'CASH + SUJ 30%';
            const cashValue = getNumericValue(cashInput);
            
            const existingError = cashInput.parentNode.querySelector('.cash-error-message');
            if (existingError) {
                existingError.remove();
            }
            cashInput.classList.remove('is-invalid');
            
            // Validasi hanya jika field Cash aktif dan wajib diisi
            if (isCashRelated && cashValue === 0) {
                const errorDiv = document.createElement('div');
                errorDiv.className = 'cash-error-message invalid-feedback';
                errorDiv.style.display = 'block';
                errorDiv.textContent = 'Nominal Cash belum terisi';
                cashInput.parentNode.appendChild(errorDiv);
                cashInput.classList.add('is-invalid');
                return {
                    isValid: false,
                    errorElement: cashInput
                };
            }
            
            return {
                isValid: true,
                errorElement: null
            };
        }

        form.addEventListener('submit', function(e) {
            const lakalantasValidation = validateLakalantasFields();
            if (!lakalantasValidation.isValid) {
                e.preventDefault();
                lakalantasValidation.errorElement.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'center' 
                });
                lakalantasValidation.errorElement.focus();
                return;
            }

            const cashValidation = validateCashField();
            if (!cashValidation.isValid) {
                e.preventDefault();
                cashValidation.errorElement.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'center' 
                });
                cashValidation.errorElement.focus();
            }
        });
        
        potongTagihanSelect.addEventListener('change', function() {
            updateCashFieldStatus();
            validateCashField();
        });
        
        cashInput.addEventListener('input', function() {
            if (!cashInput.hasAttribute('readonly')) {
                formatNumberInput(this);
                validateCashField();
            }
        });

        cashInput.addEventListener('blur', function() {
            if (!cashInput.hasAttribute('readonly')) {
                validateCashField();
            }
        });
        
        function setKlasifikasi() {
            const nominal = parseInt(realisasiKlaimInput.value.replace(/[^0-9]/g, '') || 0);
            const statusKorban = document.querySelector('input[name="b_status_korban"]:checked')?.value;
            
            if (nominal > 0) {
                if (nominal < 10000000) {
                    if (statusKorban === 'MENINGGAL') {
                        bKlasifikasi.value = 'Kasus Laka Besar';
                    } else if (statusKorban === 'TIDAK MENINGGAL') {
                        bKlasifikasi.value = 'Kasus Laka Kecil';
                    } else {
                        bKlasifikasi.value = 'Kasus Muatan Rugi Kecil';
                    }
                } else {
                    if (statusKorban === 'MENINGGAL' || statusKorban === 'TIDAK MENINGGAL') {
                        bKlasifikasi.value = 'Kasus Laka Besar';
                    } else {
                        bKlasifikasi.value = 'Kasus Muatan Rugi Besar';
                    }
                }
            } else {
                bKlasifikasi.value = '';
            }
        }
        
        realisasiKlaimInput.addEventListener('input', function() {
            formatNumberInput(this);
            setKlasifikasi();
        });

        transferInput.addEventListener('input', function() {
            formatNumberInput(this);
            setKlasifikasi();
        });
        
        document.querySelectorAll('input[name="b_status_korban"]').forEach(radio => {
            radio.addEventListener('change', setKlasifikasi);
        });

         updateCashFieldStatus();
        
        if (realisasiKlaimInput.value) {
            formatNumberInput(realisasiKlaimInput);
            setKlasifikasi();
        }

        else if (transferInput.value) {
            formatNumberInput(transferInput);
            setKlasifikasi();
        }

        else if (cashInput.value && !cashInput.hasAttribute('readonly')) {
            formatNumberInput(cashInput);
        }

        validateCashField();
    });

    function handleCheckbox(checkbox, otherCheckboxId) {
        const otherCheckbox = document.getElementById(otherCheckboxId);
        if (checkbox.checked) {
            otherCheckbox.checked = false;
        }
    }

    function updateDateTime() {
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        
        document.getElementById('b_modified_date').value = 
            `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
    }

    setInterval(updateDateTime, 1000);

    document.addEventListener('DOMContentLoaded', function() {
    const documentInput = document.getElementById('b_document');
    const pdfInput = document.getElementById('b_pdf');
    
    function showNotification(message, type = 'error') {
        const existingNotification = document.querySelector('.custom-notification');
        if (existingNotification) {
            existingNotification.remove();
        }
        const notification = document.createElement('div');
        notification.className = `custom-notification alert alert-${type === 'error' ? 'danger' : 'success'} alert-dismissible fade show`;
        notification.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        notification.innerHTML = `
            ${message}`;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 5000);
    }
    
    if (documentInput) {
        documentInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const fileSizeMB = file.size / (1024 * 1024);
                if (fileSizeMB > 5) {
                    showNotification('Ukuran file lampiran 1 melebihi batas maksimum 5MB. Silakan pilih file lain.');
                    this.value = '';
                }
            }
        });
    }
    
    if (pdfInput) {
        pdfInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const fileSizeMB = file.size / (1024 * 1024);
                const isPdf = file.type === 'application/pdf';
                
                if (!isPdf) {
                    showNotification('Format file lampiran 2 tidak didukung. Hanya PDF yang diperbolehkan.');
                    this.value = '';
                } else if (fileSizeMB > 5) {
                    showNotification('Ukuran file lampiran 2 melebihi batas maksimum 5MB. Silakan pilih file lain.');
                    this.value = '';
                }
            }
        });
    }
    
    <?php if (session()->getFlashdata('warningmessage')): ?>
        showNotification('<?= session()->getFlashdata('warningmessage') ?>', 'error');
    <?php endif; ?>
    
    <?php if (session()->getFlashdata('successmessage')): ?>
        showNotification('<?= session()->getFlashdata('successmessage') ?>', 'success');
    <?php endif; ?>
});
</script>

<style>
    .form-equal-height {
        height: 36px;
    }
    .select2-container--default .select2-selection--single {
        height: 36px;
        padding: 5px 12px;
    }
    .select2-container .select2-selection.is-invalid {
    border: 1px solid #dc3545 !important;
    }
    @keyframes highlight {
        0% { background-color: rgba(255, 255, 0, 0.3); }
        100% { background-color: transparent; }
    }
</style>