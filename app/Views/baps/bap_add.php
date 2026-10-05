<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><?= (isset($bapdetails)) ? 'Edit BAP' : 'Add BAP' ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('baps/bap_management') ?>">BAP</a></li>
                    <li class="breadcrumb-item active"><?= (isset($bapdetails)) ? 'Edit BAP' : 'Add BAP' ?></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <form method="post" id="add_bap" class="card <?= (isset($bapdetails)) ? 'updatebap' : 'insertbap' ?>" enctype="multipart/form-data" action="<?= base_url('drivers/' . ((isset($bapdetails)) ? 'updatebap' : 'insertbap')) ?>">
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
                                <div class="form-group" id="photo-section">
                                    <label class="form-label">Lampiran 1 (JPG/JPEG/PNG/PDF)<span class="form-required" style="color: red;">*</span></label>
                                    <input type="file" name="b_document" id="b_document" class="form-control" accept="image/*,application/pdf">
                                    <input type="hidden" name="existing_document" value="<?= esc($bapdetails[0]['b_document'] ?? '') ?>">
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
                                    <div id="photo_error" class="text-danger" style="color: red; margin-left: 23px; display: none;">Harap unggah lampiran bukti BAP</div>
                                    <div id="format_error" class="text-danger" style="color: red; display: none;">Hanya format JPG, JPEG, PNG, atau PDF yang diperbolehkan</div>
                                </div> 
                                <hr>
                                <div class="form-group" <?= (strpos(current_url(), 'addbap') !== false) ? 'hidden' : '' ?>>
                                    <label class="form-label">Lampiran 2 (PDF)<span class="form-required" style="color: red;">*</span></label>
                                    <input type="file" name="b_pdf" id="b_pdf" class="form-control">
                                    <input type="hidden" name="existing_pdf" value="<?= esc($bapdetails[0]['b_pdf'] ?? '') ?>">
                                    <div id="pdf_preview_container">
                                        <?php if (!empty($bapdetails[0]['b_pdf'])): ?>
                                            <a href="<?= base_url('assets/uploads/bap/pdf/' . esc($bapdetails[0]['b_pdf'])) ?>" 
                                               target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-file-pdf"></i> Lihat Dokumen PDF</a>
                                        <?php else: ?>
                                            <p>Tidak ada dokumen PDF yang diunggah.</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Personal Information Section -->
                    <div class="col-md-8">
                        <div class="card" style="min-height: 300px;">
                            <div class="card-body">
                                <div class="row">
                                    <input type="hidden" name="b_id" id="b_id" value="<?= isset($bapdetails) ? esc($bapdetails[0]['b_id']) : '' ?>" >

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Nomor BAP<span class="form-required"></span></label>
                                            <input type="text" id="b_code" class="form-control" name="b_code" value="<?= (isset($bapdetails) && !empty($bapdetails[0]['b_code'])) ? esc($bapdetails[0]['b_code']) : esc($new_bap_code) ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Nomor Induk Supir<span class="form-required"></span></label>
                                            <input type="text" id="b_nis" class="form-control" name="b_nis" value="<?= isset($bapdetails) ? esc($bapdetails[0]['b_nis']) : '' ?>" placeholder="[auto]" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Lokasi Muat (Asal)<span class="form-required" style="color: red;">*</span></label>
                                            <input type="text" name="b_lokasi_muat" value="<?= isset($bapdetails) ? esc($bapdetails[0]['b_lokasi_muat']) : '' ?>" oninput="this.value = capitalizeEachWord(this.value)" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Tanggal Kejadian<span class="form-required" style="color: red;">*</span></label>
                                            <input type="text" name="b_tanggal_kejadian" id="b_tanggal_kejadian" value="<?= old('b_tanggal_kejadian', isset($bapdetails[0]['b_tanggal_kejadian']) && $bapdetails[0]['b_tanggal_kejadian'] !== '0000-00-00' ? date('d/m/Y', strtotime($bapdetails[0]['b_tanggal_kejadian'])) : '') ?>" class="form-control datepicker form-equal-height" placeholder="Tanggal Kejadian">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Lokasi Bongkar (Tujuan)<span class="form-required" style="color: red;">*</span></label>
                                            <input type="text" name="b_lokasi_bongkar" value="<?= isset($bapdetails) ? esc($bapdetails[0]['b_lokasi_bongkar']) : '' ?>" oninput="this.value = capitalizeEachWord(this.value)" class="form-control">
                                        </div>
                                    </div>

                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Nama Supir<span class="form-required" style="color: red;">*</span></label>
                                            <select id="b_supir" class="form-control form-control-sm select2 form-equal-height" name="b_supir" onchange="updateNIS()">
                                                <option value="">-- Pilih Supir --</option>
                                                <?php 
                                                usort($driverlist, function($a, $b) {
                                                    return strcmp($a['d_name'], $b['d_name']);
                                                });
                                                
                                                foreach ($driverlist as $driver) {
                                                    $selected = '';
                                                    if (isset($bapdetails[0]['b_nis']) && $bapdetails[0]['b_nis'] == $driver['d_nis'] && $driver['d_is_active'] == 1) {
                                                        $selected = 'selected';
                                                    }
                                                    if ($driver['d_is_active'] == 1) {
                                                        echo '<option value="' . esc($driver['d_name']) . '" data-nis="' . esc($driver['d_nis']) . '" ' . $selected . '>' . esc($driver['d_name']) . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Lokasi Kejadian<span class="form-required" style="color: red;">*</span></label>
                                            <input type="text" name="b_lokasi_kejadian" value="<?= isset($bapdetails) ? esc($bapdetails[0]['b_lokasi_kejadian']) : '' ?>" oninput="this.value = capitalizeEachWord(this.value)" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Mobil<span class="form-required" style="color: red;">*</span></label>
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
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Jenis Kasus<span class="form-required" style="color: red;">*</span></label>
                                            <select id="b_jenis_kasus" name="b_jenis_kasus" class="form-control">
                                                <option value="">-- Pilih Kasus --</option>
                                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_jenis_kasus'] == 'Barang Rusak') ? 'selected' : '' ?> value="Barang Rusak">Barang Rusak</option>
                                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_jenis_kasus'] == 'Barang Kurang/Hilang') ? 'selected' : '' ?> value="Barang Kurang/Hilang">Barang Kurang/Hilang</option>
                                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_jenis_kasus'] == 'Inventaris Mobil Hilang/Rusak') ? 'selected' : '' ?> value="Inventaris Mobil Hilang/Rusak">Inventaris Mobil Hilang/Rusak</option>
                                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_jenis_kasus'] == 'Lakalantas') ? 'selected' : '' ?> value="Lakalantas">Lakalantas</option>
                                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_jenis_kasus'] == 'Mobil Rusak') ? 'selected' : '' ?> value="Mobil Rusak">Mobil Rusak</option>
                                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_jenis_kasus'] == 'Supir Bermasalah') ? 'selected' : '' ?> value="Supir Bermasalah">Supir Bermasalah</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Jenis Muatan<span class="form-required" style="color: red;">*</span></label>
                                            <input type="text" id="b_muatan" name="b_muatan" value="<?= isset($bapdetails) ? esc($bapdetails[0]['b_muatan']) : '' ?>" oninput="this.value = capitalizeEachWord(this.value)" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Kronologi Singkat / Kondisi Barang / Riwayat Kejadian<span class="form-required" style="color: red;">*</span></label>
                                            <textarea class="form-control" name="b_kondisi_barang" rows="3" oninput="this.value = capitalizeEachWord(this.value)"><?= isset($bapdetails) ? esc($bapdetails[0]['b_kondisi_barang']) : '' ?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Keberangkatan<span class="form-required" style="color: red;">*</span></label>
                                            <select id="b_keberangkatan" name="b_keberangkatan" class="form-control">
                                                <option value="">-- Pilih Keberangkatan --</option>
                                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_keberangkatan'] == 'Jakarta') ? 'selected' : '' ?> value="Jakarta">Jakarta</option>
                                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_keberangkatan'] == 'Lampung') ? 'selected' : '' ?> value="Lampung">Lampung</option>
                                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_keberangkatan'] == 'Utara') ? 'selected' : '' ?> value="Utara">Utara</option>
                                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_keberangkatan'] == 'Langsir') ? 'selected' : '' ?> value="Langsir">Langsir</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Estimasi Klaim<span class="form-required" style="color: red;">*</span></label>
                                            <select id="b_estimasi_klaim" name="b_estimasi_klaim" class="form-control">
                                                <option value="">-- Pilih Estimasi --</option>
                                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_estimasi_klaim'] == 'Rp.0 - Rp.1.000.000') ? 'selected' : '' ?> value="Rp.0 - Rp.1.000.000">Rp.0 - Rp.1.000.000</option>
                                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_estimasi_klaim'] == 'Rp.1.000.000 - Rp.9.999.999') ? 'selected' : '' ?> value="Rp.1.000.000 - Rp.9.999.999">Rp.1.000.000 - Rp.9.999.999</option>
                                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_estimasi_klaim'] == 'Rp.10.000.000 - Rp.50.000.000') ? 'selected' : '' ?> value="Rp.10.000.000 - Rp.50.000.000">Rp.10.000.000 - Rp.50.000.000</option>
                                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_estimasi_klaim'] == '>Rp.50.000.000') ? 'selected' : '' ?> value=">Rp.50.000.000">>Rp.50.000.000</option>
                                            </select>
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
                <h3 class="text-center" <?= (strpos(current_url(), 'addbap') !== false) ? 'hidden' : '' ?>>Penyelesaian Kasus</h3>
                <hr>
                <div class="row" <?= (strpos(current_url(), 'addbap') !== false) ? 'hidden' : '' ?>>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Tanggal BAP<span class="form-required" style="color: red;">*</span></label>
                            <input type="text" name="b_tanggal" id="b_tanggal"
                            value="<?= isset($bapdetails) ? esc($bapdetails[0]['b_tanggal']) : '' ?>"
                            class="form-control datepicker">
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Korelasi Kasus<span class="form-required" style="color: red;">*</span></label>
                            <select id="b_korelasi_kasus" name="b_korelasi_kasus" class="form-control">
                                <option value="">-- Pilih Korelasi --</option>
                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_korelasi_kasus'] == 'Muatan') ? 'selected' : '' ?> value="Muatan">Muatan</option>
                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_korelasi_kasus'] == 'Mobil') ? 'selected' : '' ?> value="Mobil">Mobil</option>
                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_korelasi_kasus'] == 'Supir') ? 'selected' : '' ?> value="Supir">Supir</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Realisasi Klaim<span class="form-required" style="color: red;">*</span></label>
                            <input type="text" name="b_realisasi_klaim" value="<?= isset($bapdetails) ? esc($bapdetails[0]['b_realisasi_klaim']) : '' ?>" class="form-control" id="realisasiKlaimInput">
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Posisi Barang<span class="form-required" style="color: red;">*</span></label>
                            <select id="b_posisi_barang" name="b_posisi_barang" class="form-control">
                                <option value="">-- Pilih Posisi --</option>
                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_posisi_barang'] == 'Yos') ? 'selected' : ''; ?> value="Yos">Yos</option>
                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_posisi_barang'] == 'Supir') ? 'selected' : ''; ?> value="Supir">Supir</option>
                                <option <?= (isset($bapdetails) && $bapdetails[0]['b_posisi_barang'] == 'Tempat Bongkar') ? 'selected' : ''; ?> value="Tempat Bongkar">Tempat Bongkar</option>
                                 <option <?= (isset($bapdetails) && $bapdetails[0]['b_posisi_barang'] == 'Lainnya') ? 'selected' : ''; ?> value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Potong Tagihan<span class="form-required" style="color: red;">*</span></label>
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
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Cash</label>
                            <input type="text" name="b_cash" value="<?= isset($bapdetails) ? esc($bapdetails[0]['b_cash']) : '' ?>" class="form-control">
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Transfer</label>
                            <input type="text" name="b_transfer" value="<?= isset($bapdetails) ? esc($bapdetails[0]['b_transfer']) : '' ?>" class="form-control" id="transferInput">
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Klasifikasi</label>
                            <input type="text" id="b_klasifikasi" name="b_klasifikasi" class="form-control" readonly 
                                   value="<?= isset($bapdetails['b_klasifikasi']) ? esc($bapdetails[0]['b_klasifikasi']) : '' ?>">
                            
                            <div class="d-flex align-items-center mt-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="b_status_korban" id="meninggal" value="MENINGGAL" 
                                           onclick="handleCheckbox(this, 'tidak_meninggal')"
                                           <?= (isset($bapdetails) && $bapdetails[0]['b_status_korban'] == 'MENINGGAL') ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="meninggal">MENINGGAL</label>
                                </div>
                                <div class="form-check form-check-inline ml-2">
                                    <input class="form-check-input" type="checkbox" name="b_status_korban" id="tidak_meninggal" value="TIDAK MENINGGAL" 
                                           onclick="handleCheckbox(this, 'meninggal')"
                                           <?= (isset($bapdetails) && $bapdetails[0]['b_status_korban'] == 'TIDAK MENINGGAL') ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="tidak_meninggal">TIDAK MENINGGAL</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Kronologi Detail Kejadian<span class="form-required" style="color: red;">*</span></label>
                            <textarea class="form-control" name="b_kronologi_kejadian" rows="3"><?= isset($bapdetails) ? esc($bapdetails[0]['b_kronologi_kejadian']) : '' ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-12">
                    <div class="form-group">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" autocomplete="off" placeholder="Catatan" name="b_keterangan"><?= isset($bapdetails) ? esc($bapdetails[0]['b_keterangan']) : '' ?></textarea>
                    </div>
                </div>

                <input type="hidden" id="b_created_date" name="b_created_date" value="<?= date('Y-m-d H:i:s') ?>">
                <input type="hidden" id="b_modified_date" name="b_modified_date" value="<?= date('Y-m-d H:i:s') ?>">

                <div class="card-footer d-flex">
                    <button type="button" href="<?= base_url('baps/bap_management') ?>" class="btn btn-warning" onclick="return confirmCancel()">
                        <i class="fa fa-left"></i> CANCEL
                    </button>
                    <button id="btn-submit" type="button" class="btn btn-primary ml-auto" onclick="return confirmSave()">
                        <?= (isset($bapdetails)) ? 'UPDATE' : 'SAVE' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- /.content -->
<?= view('layout/footer') ?>

<script src="<?= base_url('assets/autoLogout.js') ?>"></script>
<script>
    const baseUrl = "<?= base_url() ?>"; 
    enableAutoLogout(7200, baseUrl + "login");

    $('input[type="text"]').on('change', function() {
            $(this).valid();
        });

    $('.select2').on('change', function() {
            $(this).valid();
        });

    $('.select2-vehicle').on('change', function() {
            $(this).valid();
        });

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const photoInput = document.getElementById('b_document');
        const photoSection = document.getElementById('photo-section');
        const existingPhoto = document.querySelector('input[name="existing_document"]').value;
        const photoError = document.getElementById('photo_error');
        const formatError = document.getElementById('format_error');
        const allowedExtensions = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];

        form.addEventListener('submit', function(e) {
            let shouldPreventDefault = false;
            // Reset error messages
            photoError.style.display = 'none';
            formatError.style.display = 'none';

            if (photoInput.files.length > 0) {
                const file = photoInput.files[0];
                // Validasi format file
                if (!allowedExtensions.includes(file.type)) {
                    e.preventDefault();
                    formatError.style.display = 'block';
                    highlightInput(photoInput);
                    scrollToPhotoSection();
                    return;
                }
            }
            else if (!existingPhoto) {
                e.preventDefault();
                photoError.style.display = 'block';
                highlightInput(photoInput);
                scrollToPhotoSection();
            }
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
        });

    function highlightInput(input) {
        input.style.border = '1px solid red';
    }
    function scrollToPhotoSection() {
        photoSection.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });
        photoSection.style.animation = 'highlight 1s';
        setTimeout(() => {
            photoSection.style.animation = '';
        }, 1000);
    }
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
            <?php if (isset($bapdetails)) : ?>
                title: "Apakah anda yakin ingin mengupdate data BAPS tersebut?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#28a745",
                cancelButtonColor: "#dc3545",
                confirmButtonText: "Update",
                cancelButtonText: "Batalkan"
                <?php else : ?>
                    title: "Apakah anda yakin ingin menyimpan data BAPS tersebut?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#28a745",
                    cancelButtonColor: "#dc3545",
                    confirmButtonText: "Simpan",
                    cancelButtonText: "Batalkan"
                    <?php endif; ?>
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
                window.location.href = "<?= base_url('baps/bap_management') ?>";
            }
        })
    }

    function updateNIS() {
        // Get the selected option from the dropdown
        const driverSelect = document.getElementById('b_supir');
        const selectedOption = driverSelect.options[driverSelect.selectedIndex];

        const nis = selectedOption.getAttribute('data-nis');
        document.getElementById('b_nis').value = nis || '';
    }

    $('#b_document').change(function(e) {
        const file = e.target.files[0];
        const previewContainer = $('#document_preview_container');
        const photoError = $('#photo_error');
        const formatError = $('#format_error');

        photoError.hide();
        formatError.hide();
        previewContainer.empty();

        if (file) {
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
            if (!allowedTypes.includes(file.type)) {
                formatError.show();
                $(this).val('');
                return;
            }

            $(this).css({
                'border': '',
                'box-shadow': ''
            });

            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const img = $('<img>').attr({
                        'src': event.target.result,
                        'alt': 'Preview Document BAP',
                        'style': 'margin-left: 3px; margin-top: 7px; max-width:300px; max-height:300px; object-fit:cover;'
                    });
                    previewContainer.append(img);
                    previewContainer.append(`<p class="mt-2">Nama Dokumen: ${file.name}</p>`);
                };
                reader.readAsDataURL(file);
            } else if (file.type === 'application/pdf') {
                previewContainer.append(`
                    <a href="#" class="btn btn-sm btn-outline-primary pdf-preview-link" data-filename="${file.name}">
                        <i class="fas fa-file-pdf"></i> Lihat Dokumen PDF
                    </a>
                    <p class="mt-2">Nama Dokumen: ${file.name}</p>
                `);
            }
        } else {
            previewContainer.html('<p class="text-muted">Tidak ada dokumen yang diunggah.</p>');
        }
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
                resetLakalantasErrors();
                clearLakalantasFields();
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
        
        if (!isLakalantas) {
            return { isValid: true, errorElement: null };
        }
        
        let firstErrorElement = null;
        let allValid = true;
        
        fields.forEach(field => {
            const input = document.querySelector(`[name="${field.name}"]`);
            const errorDiv = input?.parentNode?.querySelector('.lakalantas-error');
            
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
        
        return {
            isValid: allValid,
            errorElement: firstErrorElement
        };
    }

    // Format number inputs untuk field biaya
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

    document.addEventListener('DOMContentLoaded', function() {
        const realisasiKlaimInput = document.getElementById('realisasiKlaimInput');
        // const transferInput = document.getElementById('transferInput');
        const bKlasifikasi = document.getElementById('b_klasifikasi');
        const cashInput = document.querySelector('input[name="b_cash"]');
        const potongTagihanSelect = document.getElementById('b_potong_tagihan');
        const form = document.getElementById('add_bap');
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

            // Simpan nilai sebelumnya untuk deteksi perubahan
            this.setAttribute('data-previous-value', this.value);
            
            if (isChangingFromLakalantas) {
                console.log('Changing from Lakalantas to another type, clearing fields...');
                clearLakalantasFields();
            }
                toggleLakalantasFields();
            });
        }
        
        formatLakalantasNumberInputs();

         if (cashInput) {
            cashInput.setAttribute('readonly', 'readonly');
            cashInput.style.backgroundColor = '#e9ecef';
        }
        
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
            if (!cashInput || !potongTagihanSelect) return;
            
            const selectedValue = potongTagihanSelect.value;
            const isCashRelated = selectedValue === 'CASH' || selectedValue === 'CASH + SUJ 30%';
            
            if (isCashRelated) {
                cashInput.removeAttribute('readonly');
                cashInput.style.backgroundColor = '';

                const cashLabel = cashInput.closest('.form-group').querySelector('label');
                if (cashLabel && !cashLabel.querySelector('.cash-required-star')) {
                    const requiredStar = document.createElement('span');
                    requiredStar.className = 'cash-required-star';
                    requiredStar.style.color = 'red';
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
            if (!cashInput || !potongTagihanSelect) {
                return { isValid: true, errorElement: null };
            }
            
            const selectedValue = potongTagihanSelect.value;
            const isCashRelated = selectedValue === 'CASH' || selectedValue === 'CASH + SUJ 30%';
            const cashValue = getNumericValue(cashInput);
            
            const existingError = cashInput.parentNode.querySelector('.cash-error-message');
            if (existingError) {
                existingError.remove();
            }
            cashInput.classList.remove('is-invalid');
            
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

        if (form) {
            form.addEventListener('submit', function(e) {
                const cashValidation = validateCashField();
                if (!cashValidation.isValid) {
                    e.preventDefault(); // Hentikan submit
                    cashValidation.errorElement.scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'center' 
                    });
                    cashValidation.errorElement.focus();
                }
            });
        }
        
        if (potongTagihanSelect) {
            potongTagihanSelect.addEventListener('change', function() {
                updateCashFieldStatus();
                validateCashField();
            });
        }
        
        if (cashInput) {
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
        }
        
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
                        // Default case when status is not selected
                        bKlasifikasi.value = 'Kasus Muatan Rugi Kecil';
                    }
                } else {
                    // Nominal >= 10000000
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
        
        // Event listeners
        realisasiKlaimInput.addEventListener('input', function() {
            formatNumberInput(this);
            setKlasifikasi();
        });
        transferInput.addEventListener('input', function() {
            formatNumberInput(this);
            setKlasifikasi();
        })
        
        document.querySelectorAll('input[name="b_status_korban"]').forEach(radio => {
            radio.addEventListener('change', setKlasifikasi);
        });

        updateCashFieldStatus();
        
        if (realisasiKlaimInput.value) {
            formatNumberInput(realisasiKlaimInput);
            setKlasifikasi();
        }

        // else if (transferInput.value) {
        //     formatNumberInput(transferInput);
        //     setKlasifikasi();
        // }

        else if (cashInput && cashInput.value && !cashInput.hasAttribute('readonly')) {
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

    // Update every second
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

    if (typeof jQuery !== 'undefined' && jQuery.fn.datepicker) {
        $('.datepicker').datepicker('destroy').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true
        });

        $('.datepickerpastdisable').datepicker('destroy').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            startDate: new Date(),
            todayHighlight: true
        });
    }
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
</style>