<?php $old_input = session()->getFlashdata('old_input'); ?>

<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><?= (isset($driverdetails)) ? 'Edit driver' : 'Add driver' ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('drivers/drivers_management') ?>">Driver</a></li>
                    <li class="breadcrumb-item active"><?= (isset($driverdetails)) ? 'Edit driver' : 'Add driver' ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <form method="post" id="add_driver" class="card <?= (isset($driverdetails)) ? 'updatedriver' : 'insertdriver' ?>" enctype="multipart/form-data" action="<?= base_url('drivers/' . ((isset($driverdetails)) ? 'updatedriver' : 'insertdriver')) ?>">
            <?= csrf_field() ?>
            <div class="card-body">
                <h3 class="text-center">Data Diri</h3>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="text-center">Upload Dokumen</h4>
                                <hr>
                                <div class="form-group" id="photo-section">
                                    <label class="form-label">Foto (JPG/JPEG/PNG)<span class="form-required" style="color: red;">*</span></label>
                                    <input type="file" name="d_photo" id="d_photo" class="form-control" accept="image/*">
                                     <input type="hidden" name="existing_photo" value="<?= esc($driverdetails[0]['d_photo'] ?? '') ?>">
                                    <?php $photo = !empty($driverdetails[0]['d_photo']) ? $driverdetails[0]['d_photo'] : 'user.png'; ?>
                                        <img id="photo_preview" src="<?= base_url('assets/uploads/drivers/' . esc($photo)) ?>" 
                                             alt="Preview Foto Driver" 
                                             style="margin-left: 37px; margin-top:15px; max-width:200px; max-height:200px; object-fit:cover;" />
                                    <?php if (!empty($driverdetails[0]['d_photo'])): ?>
                                        <p>Nama Foto: <?= esc($driverdetails[0]['d_photo']) ?></p>
                                    <?php endif; ?>
                                    <div id="photo_error" class="text-danger" style="margin-left: 60px; display: none;">Harap unggah foto supir</div>
                                    <div id="format_error" class="text-danger" style="display: none;">Hanya format JPG/JPEG/PNG yang diperbolehkan</div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label class="form-label">Berkas Persyaratan <span class="text-muted">/PDF</span> <small class="text-muted">(Optional)</small></label>
                                    <input type="file" name="d_pdf_document" id="d_pdf_document" class="form-control">
                                    <input type="hidden" name="existing_pdf_document" value="<?= esc($driverdetails[0]['d_pdf_document'] ?? '') ?>">

                                    <?php if (!empty($driverdetails[0]['d_pdf_document'])): ?>
                                        <a href="<?= base_url('assets/uploads/document/' . esc($driverdetails[0]['d_pdf_document'])) ?>" 
                                           target="_blank">Lihat Dokumen PDF</a>
                                        <p>Nama Dokumen: <?= esc($driverdetails[0]['d_pdf_document']) ?></p>
                                    <?php else: ?>
                                        <p>Tidak ada dokumen PDF yang diunggah.</p>
                                    <?php endif; ?>
                                </div>
                                <hr>
                                <div class="form-group mt-3 radio-group">
                                    <label class="form-label">Status Dokumen<span class="form-required" style="color: red;">*</span></label>
                                    <div class="border p-3 rounded d-flex flex-column">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="d_docstatus" id="document_complete" 
                                                   value="complete" <?= (isset($driverdetails) && $driverdetails[0]['d_docstatus'] == 'complete') || ($old_input['d_docstatus'] ?? '') == 'complete' ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="document_complete">
                                                Dokumen Lengkap
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="d_docstatus" id="document_incomplete" 
                                                   value="incomplete" <?= (isset($driverdetails) && $driverdetails[0]['d_docstatus'] == 'incomplete') || ($old_input['d_docstatus'] ?? '') == 'incomplete' ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="document_incomplete">
                                                Dokumen Tidak Lengkap
                                            </label>
                                        </div>
                                    </div>
                                    <div id="document_remarks_container" style="display: none;" class="mt-2">
                                        <label for="d_docremarks" class="form-label">Sebutkan Dokumen yang Kurang<span class="form-required" style="color: red;">*</span></label>
                                        <textarea class="form-control" id="document_remarks" name="d_docremarks" rows="2" 
                                                  placeholder="Jenis dokumen apa yang tidak lengkap?"><?= esc($driverdetails[0]['d_docremarks'] ?? esc($old_input['d_docremarks'] ?? '')) ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <input type="hidden" name="d_id" id="d_id" value="<?= (isset($driverdetails)) ? esc($driverdetails[0]['d_id']) : '' ?>" >

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Nomor Induk Supir (NIS)</label>
                                            <input type="text" name="d_nis" id="d_nis" class="form-control" value="<?= (isset($driverdetails) && !empty($driverdetails[0]['d_nis'])) ? esc($driverdetails[0]['d_nis']) : esc($new_driver_nis) ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <label class="form-label">Nama Lengkap KTP<span class="form-required" style="color: red;">*</span></label>
                                        <div class="form-group">
                                            <input type="text" name="d_name" id="d_name" class="form-control" placeholder="Nama Sesuai KTP" value="<?= isset($driverdetails) ? esc($driverdetails[0]['d_name']) : esc($old_input['d_name'] ?? '') ?>" oninput="this.value = capitalizeEachWord(this.value)" autofocus>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Nama Panggilan<span class="form-required" style="color: red;">*</span></label>
                                            <input type="text" name="d_nickname" id="d_nickname" class="form-control" placeholder="Nama Panggilan" value="<?= isset($driverdetails) ? esc($driverdetails[0]['d_nickname']) : esc($old_input['d_nickname'] ?? '') ?>" oninput="this.value = capitalizeEachWord(this.value)">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Tempat Lahir<span class="form-required" style="color: red;">*</span></label>
                                            <input type="text" name="d_pob" id="d_pob" class="form-control" placeholder="Tempat Lahir" value="<?= (isset($driverdetails)) ? esc($driverdetails[0]['d_pob']) : esc($old_input['d_pob'] ?? '') ?>" oninput="this.value = capitalizeEachWord(this.value)">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Tanggal Lahir<span class="form-required" style="color: red;">*</span></label>
                                            <input type="text" name="d_dob" id="d_dob" value="<?= isset($driverdetails[0]['d_dob']) && $driverdetails[0]['d_dob'] !== '0000-00-00' ? date('d-m-Y', strtotime($driverdetails[0]['d_dob'])) : '' ?>" class="form-control datepicker" placeholder="Tanggal Lahir">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Umur</label>
                                            <input type="text" name="d_age" id="d_age" class="form-control" readonly placeholder="auto">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Status Sipil<span class="form-required" style="color: red;">*</span></label>
                                            <select id="d_married" name="d_married" class="form-control">
                                                <option value="">-- Pilih Status --</option> 
                                                <option value="Menikah" <?= (isset($old_input['d_married']) && $old_input['d_married'] == 'Menikah') || (isset($driverdetails) && $driverdetails[0]['d_married'] == 'Menikah') ? 'selected' : '' ?>>
                                                    Menikah
                                                </option> 
                                                <option value="Lajang" <?= (isset($old_input['d_married']) && $old_input['d_married'] == 'Lajang') || (isset($driverdetails) && $driverdetails[0]['d_married'] == 'Lajang') ? 'selected' : '' ?>>
                                                    Lajang
                                                </option>
                                                <option value="Lainnya" <?= (isset($old_input['d_married']) && $old_input['d_married'] == 'Lainnya') || (isset($driverdetails) && $driverdetails[0]['d_married'] == 'Lainnya') ? 'selected' : '' ?>>
                                                    Lainnya
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Pendidikan<span class="form-required" style="color: red;">*</span></label>
                                            <select id="d_education" name="d_education" class="form-control">
                                                <option value="">-- Pilih Pendidikan --</option>
                                                <option value="SD" <?= (isset($old_input['d_education']) && $old_input['d_education'] == 'SD') || (isset($driverdetails) && $driverdetails[0]['d_education'] == 'SD') ? 'selected' : '' ?>>SD
                                                </option>
                                                <option value="SMP" <?= (isset($old_input['d_education']) && $old_input['d_education'] == 'SMP') || (isset($driverdetails) && $driverdetails[0]['d_education'] == 'SMP') ? 'selected' : '' ?>>SMP
                                                </option>
                                                <option value="SMA/SMK" <?= (isset($old_input['d_education']) && $old_input['d_education'] == 'SMA/SMK') || (isset($driverdetails) && $driverdetails[0]['d_education'] == 'SMA/SMK') ? 'selected' : '' ?>>SMA/SMK
                                                </option>
                                                <option value="Diploma" <?= (isset($old_input['d_education']) && $old_input['d_education'] == 'Diploma') || (isset($driverdetails) && $driverdetails[0]['d_education'] == 'Diploma') ? 'selected' : '' ?>>Diploma
                                                </option>
                                                <option value="Sarjana" <?= (isset($old_input['d_education']) && $old_input['d_education'] == 'Sarjana') || (isset($driverdetails) && $driverdetails[0]['d_education'] == 'Sarjana') ? 'selected' : '' ?>>Sarjana
                                                </option>
                                                <option value="Lainnya" <?= (isset($old_input['d_education']) && $old_input['d_education'] == 'Lainnya') || (isset($driverdetails) && $driverdetails[0]['d_education'] == 'Lainnya') ? 'selected' : '' ?>>Lainnya
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">Nomor Handphone<span class="form-required" style="color: red;">*</span></label>
                                            <input type="text" name="d_mobile" value="<?= (isset($driverdetails)) ? esc($driverdetails[0]['d_mobile']) : esc($old_input['d_mobile'] ?? '') ?>" class="form-control" placeholder="Nomor Handphone Aktif" >
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Alamat Tempat Tinggal<span class="form-required" style="color: red;">*</span></label>
                                            <textarea class="form-control" autocomplete="off" placeholder="Alamat Lengkap Sesuai KTP" name="d_address" oninput="this.value = capitalizeEachWord(this.value)"><?= (isset($driverdetails)) ? esc($driverdetails[0]['d_address']) : esc($old_input['d_address'] ?? '') ?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-6"> 
                                        <div class="form-group">
                                            <label class="form-label">Provinsi<span class="form-required" style="color: red;">*</span></label>
                                            <select id="d_province" name="d_province" class="form-control select2 form-equal-height">
                                                <option value="">--Pilih Provinsi--</option>
                                                <?php foreach ($provinces as $province): ?>
                                                    <?php 
                                                    $selected = false;
                                                    if (isset($old_input['d_province']) && $old_input['d_province'] == $province['name'] || (isset($driverdetails) && $driverdetails[0]['d_province'] == $province['id'])) {
                                                        $selected = true;
                                                    } elseif (isset($old_input['d_province']) && $old_input['d_province'] == $province['id']) {
                                                        $selected = true;
                                                    }
                                                    ?>
                                                    <option value="<?= esc($province['id']) ?>" <?= $selected ? 'selected' : ''; ?>>
                                                        <?= esc($province['name']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="d_city" class="form-label">Kabupaten/Kota<span class="form-required" style="color: red;">*</span></label>
                                            <select id="d_city" name="d_city" class="form-control select2-city form-equal-height">
                                                <option value="">--Pilih Kab/Kota--</option>
                                                <?php if (!empty($old_input['d_city']) || (isset($driverdetails) && !empty($driverdetails[0]['d_city']))): ?>
                                                    <?php 
                                                    $selectedCityId = $old_input['d_city'] ?? ($driverdetails[0]['d_city'] ?? '');
                                                    $selectedCityName = $old_input['d_city_name'] ?? ($driverdetails[0]['d_city_name'] ?? '');
                                                    ?>
                                                    <option value="<?= esc($selectedCityId) ?>" selected>
                                                        <?= esc($selectedCityName) ?>
                                                    </option>
                                                <?php endif; ?>
                                            </select>
                                            <input type="hidden" id="d_city_name" name="d_city_name" value="<?= esc($old_input['d_city_name'] ?? ($driverdetails[0]['d_city_name'] ?? '')) ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="d_subdistrict" class="form-label">Kecamatan<span class="form-required" style="color: red;">*</span></label>
                                            <select id="d_subdistrict" name="d_subdistrict" class="form-control select2-subdistrict form-equal-height">
                                                <option value="">--Pilih Kecamatan--</option>
                                                <?php if (!empty($old_input['d_subdistrict']) || (isset($driverdetails) && !empty($driverdetails[0]['d_subdistrict']))): ?>
                                                    <?php 
                                                    $selectedSubdistrictId = $old_input['d_subdistrict'] ?? ($driverdetails[0]['d_subdistrict'] ?? '');
                                                    $selectedSubdistrictName = $old_input['d_subdistrict_name'] ?? ($driverdetails[0]['d_subdistrict_name'] ?? '');
                                                    ?>
                                                    <option value="<?= esc($selectedSubdistrictId) ?>" selected>
                                                        <?= esc($selectedSubdistrictName) ?>
                                                    </option>
                                                <?php endif; ?>
                                            </select>
                                            <input type="hidden" id="d_subdistrict_name" name="d_subdistrict_name" value="<?= esc($old_input['d_subdistrict_name'] ?? ($driverdetails[0]['d_subdistrict_name'] ?? '')) ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="d_village" class="form-label">Kelurahan<span class="form-required" style="color: red;">*</span></label>
                                            <select id="d_village" name="d_village" class="form-control select2-village form-equal-height">
                                                <option value="">--Pilih Kelurahan--</option>
                                                <?php if (!empty($old_input['d_village']) || (isset($driverdetails) && !empty($driverdetails[0]['d_village']))): ?>
                                                    <?php 
                                                    $selectedVillageId = $old_input['d_village'] ?? ($driverdetails[0]['d_village'] ?? '');
                                                    $selectedVillageName = $old_input['d_village_name'] ?? ($driverdetails[0]['d_village_name'] ?? '');
                                                    ?>
                                                    <option value="<?= esc($selectedVillageId) ?>" selected>
                                                        <?= esc($selectedVillageName) ?>
                                                    </option>
                                                <?php endif; ?>
                                            </select>
                                             <input type="hidden" id="d_village_name" name="d_village_name" value="<?= esc($old_input['d_village_name'] ?? ($driverdetails[0]['d_village_name'] ?? '')) ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>
                <h3 class="text-center">Identitas Pendukung</h3>
                <hr>
                <div class="row">
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">NIK<span class="form-required" style="color: red;">*</span></label>
                            <input type="text" id="d_identityno" name="d_identityno" value="<?= (isset($driverdetails)) ? esc($driverdetails[0]['d_identityno']) : esc($old_input['d_identityno'] ?? '') ?>" class="form-control" placeholder="Nomor Induk KTP" >
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Masa Berlaku KTP</label>
                            <input type="text" name="d_identity_expdate" value="SEUMUR HIDUP" class="form-control" readonly >
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Nomor SIM<span class="form-required" style="color: red;">*</span></label>
                            <input type="text" name="d_licenseno" value="<?= (isset($driverdetails)) ? esc($driverdetails[0]['d_licenseno']) : esc($old_input['d_licenseno'] ?? '') ?>" class="form-control" placeholder="Nomor SIM" >
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Masa Berlaku SIM<span class="form-required" style="color: red;">*</span></label>
                            <input type="text" name="d_license_expdate" id="d_license_expdate" value="<?= old('d_license_expdate', isset($driverdetails[0]['d_license_expdate']) && $driverdetails[0]['d_license_expdate'] !== '0000-00-00' ? date('d/m/Y', strtotime($driverdetails[0]['d_license_expdate'])) : '') ?>" class="form-control datepickerpastdisable" placeholder="Masa Berlaku Sim">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">BPJS<span class="form-required" style="color: red;">*</span></label>
                            <select id="d_cardbpjs" name="d_cardbpjs" class="form-control ">
                                <option value="">-- Pilih Status BPJS --</option> 
                                <option value="ADA" <?= (isset($old_input['d_cardbpjs']) && $old_input['d_cardbpjs'] == 'ADA') || (isset($driverdetails) && $driverdetails[0]['d_cardbpjs'] == 'ADA') ? 'selected' : '' ?>>ADA
                                </option> 
                                <option value="TIDAK ADA" <?= (isset($old_input['d_cardbpjs']) && $old_input['d_cardbpjs'] == 'TIDAK ADA') || (isset($driverdetails) && $driverdetails[0]['d_cardbpjs'] == 'TIDAK ADA') ? 'selected' : '' ?>>TIDAK ADA
                                </option> 
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Nomor Rekening</label>
                            <input type="text" name="d_accountno" value="<?= isset($driverdetails) ? esc($driverdetails[0]['d_accountno']) : esc($old_input['d_accountno'] ?? '') ?>" class="form-control" placeholder="Rekening" >
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Bank</label>
                            <select id="d_bank" name="d_bank" class="form-control ">
                                <option value="">-- Pilih Bank --</option> 
                                <option value="BCA" <?= (isset($old_input['d_bank']) && $old_input['d_bank'] == 'BCA') || (isset($driverdetails) && $driverdetails[0]['d_bank'] == 'BCA') ? 'selected' : '' ?>>BCA
                                </option> 
                                <option value="Mandiri" <?= (isset($old_input['d_bank']) && $old_input['d_bank'] == 'Mandiri') || (isset($driverdetails) && $driverdetails[0]['d_bank'] == 'Mandiri') ? 'selected' : '' ?>>Mandiri
                                </option>
                                <option value="BRI" <?= (isset($old_input['d_bank']) && $old_input['d_bank'] == 'BRI') || (isset($driverdetails) && $driverdetails[0]['d_bank'] == 'BRI') ? 'selected' : '' ?>>BRI
                                </option>
                                <option value="BTN" <?= (isset($old_input['d_bank']) && $old_input['d_bank'] == 'BTN') || (isset($driverdetails) && $driverdetails[0]['d_bank'] == 'BTN') ? 'selected' : '' ?>>BTN
                                </option>
                                <option value="BNI" <?= (isset($old_input['d_bank']) && $old_input['d_bank'] == 'BNI') || (isset($driverdetails) && $driverdetails[0]['d_bank'] == 'BNI') ? 'selected' : '' ?>>BNI
                                </option>
                                <option value="BSI" <?= (isset($old_input['d_bank']) && $old_input['d_bank'] == 'BSI') || (isset($driverdetails) && $driverdetails[0]['d_bank'] == 'BSI') ? 'selected' : '' ?>>BSI
                                </option>
                                <option value="Lainnya" <?= (isset($old_input['d_bank']) && $old_input['d_bank'] == 'Lainnya') || (isset($driverdetails) && $driverdetails[0]['d_bank'] == 'Lainnya') ? 'selected' : '' ?>>Lainnya
                                </option> 
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Pemilik Rekening</label>
                            <input type="text" name="d_accountname" value="<?= isset($driverdetails) ? esc($driverdetails[0]['d_accountname']) : esc($old_input['d_accountname'] ?? '') ?>" class="form-control" placeholder="Atas Nama" oninput="this.value = capitalizeEachWord(this.value)">
                        </div>
                    </div>
                </div>

                <hr>
                <h3 class="text-center">Riwayat Pengalaman Kerja</h3>
                <hr>
                <div class="row">
                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label class="form-label">Perusahaan</label>
                            <input type="text" name="d_experience" value="<?= (isset($driverdetails)) ? esc($driverdetails[0]['d_experience']) : esc($old_input['d_experience'] ?? '') ?>" class="form-control" placeholder="Nama Perusahaan Sebelumnya" oninput="this.value = capitalizeEachWord(this.value)">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label class="form-label">Total Pengalaman Kerja<span class="form-required" style="color: red;">*</span></label>
                            <input type="text" name="d_total_exp" value="<?= (isset($driverdetails)) ? esc($driverdetails[0]['d_total_exp']) : esc($old_input['d_total_exp'] ?? '') ?>" class="form-control" placeholder="Durasi Pengalaman Kerja" oninput="this.value = capitalizeEachWord(this.value)">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label class="form-label">Alamat Perusahaan Sebelumnya</label>
                            <textarea class="form-control" autocomplete="off" placeholder="Alamat/Nomor Telepon"  name="d_infoexp" oninput="this.value = capitalizeEachWord(this.value)"><?= (isset($driverdetails)) ? esc($driverdetails[0]['d_infoexp']) : esc($old_input['d_infoexp'] ?? '') ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="d_expstatus[]"
                                   value="Tidak Bisa Dihubungi" <?= (isset($driverdetails) && $driverdetails[0]['d_expstatus'] == 'Tidak Bisa Dihubungi') ? 'checked' : (old('d_expstatus') && in_array('Tidak Bisa Dihubungi', old('d_expstatus')) ? 'checked' : '') ?>>
                            <label class="form-check-label">
                                Perusahaan Sebelumnya Tidak Bisa Dihubungi
                            </label>
                        </div>
                    </div>
                </div>

                <hr>
                <hr>
                <div class="row">
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Referensi<span class="form-required" style="color: red;">*</span></label>
                            <input type="text" name="d_ref" value="<?= (isset($driverdetails)) ? esc($driverdetails[0]['d_ref']) : esc($old_input['d_ref'] ?? '') ?>" class="form-control" placeholder="Referensi" oninput="this.value = capitalizeEachWord(this.value)">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Tanggal Masuk<span class="form-required" style="color: red;">*</span></label>
                            <input type="text" name="d_doj" id="d_doj" value="<?= old('d_doj', isset($driverdetails[0]['d_doj']) && $driverdetails[0]['d_doj'] !== '0000-00-00' ? date('d/m/Y', strtotime($driverdetails[0]['d_doj'])) : '') ?>" class="form-control datepicker" placeholder="Tanggal Masuk">
                        </div>
                    </div>

                    <?php if(isset($driverdetails[0]['d_is_active'])): ?>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label for="d_is_active" class="form-label" style="color: red;">Driver Status*</label>
                            <select id="d_is_active" name="d_is_active" class="form-control">
                                <option value="">Select Driver Status</option> 
                                <option value="1" <?= (isset($driverdetails) && $driverdetails[0]['d_is_active'] == 1) ? 'selected' : '' ?>>Active</option>
                                <option value="0" <?= (isset($driverdetails) && $driverdetails[0]['d_is_active'] == 0) ? 'selected' : '' ?>>Inactive</option>
                                <option value="2" <?= (isset($driverdetails) && $driverdetails[0]['d_is_active'] == 2) ? 'selected' : '' ?>>Blacklist</option>
                                <option value="3" <?= (isset($driverdetails) && $driverdetails[0]['d_is_active'] == 3) ? 'selected' : '' ?>>Permission</option>
                            </select>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if (isset($driverdetails[0]['d_is_active']) && $driverdetails[0]['d_is_active'] == '0'): ?>
                    <div class="col-sm-6 col-md-3" id="resign-date-container">
                        <div class="form-group">
                            <label class="form-label">Tanggal Keluar/Izin<span class="form-required" style="color: red;">*</span></label>
                            <input type="text" 
                                 name="d_resigndate" 
                                 id="d_resigndate" 
                                 value="<?= (isset($driverdetails)) ? esc($driverdetails[0]['d_resigndate']) : esc($old_input['d_resigndate'] ?? '') ?>" 
                                 class="form-control datepickerfuturedisable" 
                                 placeholder="Tanggal Selesai Kontrak">
                            <small id="resign-date-error" class="text-danger" style="display: none;">Tanggal Keluar/Izin harus diisi jika Driver Status Inactive/Blacklist/Permission.</small>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="col-sm-6 col-md-12">
                        <div class="form-group">
                            <label class="form-label">Keterangan</label>
                            <textarea class="form-control" autocomplete="off" placeholder="Catatan"  name="d_notes"><?= (isset($driverdetails)) ? esc($driverdetails[0]['d_notes']) : esc($old_input['d_notes'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>
            
                <input type="hidden" id="d_modified_date" name="d_modified_date" value="<?= date('Y-m-d H:i:s') ?>">

                <div class="card-footer d-flex">
                    <a href="<?= base_url('drivers/drivers_management') ?>" class="btn btn-warning" onclick="return confirmCancel()">
                        <i class="fa fa-left"></i> CANCEL
                    </a>
                    <button type="submit" class="btn btn-primary ml-auto" onclick="return confirmSave()"> 
                        <?= (isset($driverdetails)) ? 'UPDATE' : 'SAVE' ?>
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>
<?= view('layout/footer') ?>

<?= $this->section('scripts') ?>

<script src="<?= base_url('assets/autoLogout.js') ?>"></script>

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
    .radio-group.is-invalid .border {
        border: 1px solid #dc3545 !important;
    }
    @keyframes highlight {
        0% { background-color: rgba(255, 255, 0, 0.3); }
        100% { background-color: transparent; }
    }
</style>

<script>
$(document).ready(function() {
    var baseUrl = "<?= base_url() ?>";

    // Initialize Select2 on all region dropdowns
    $('#d_province').select2({ placeholder: '--Pilih Provinsi--', allowClear: true });
    $('#d_city').select2({ placeholder: '--Pilih Kab/Kota--', allowClear: true });
    $('#d_subdistrict').select2({ placeholder: '--Pilih Kecamatan--', allowClear: true });
    $('#d_village').select2({ placeholder: '--Pilih Kelurahan--', allowClear: true });

    // Saved values for edit mode
    var savedCityId = '<?= esc($old_input['d_city'] ?? (isset($driverdetails) ? $driverdetails[0]['d_city'] : '')) ?>';
    var savedSubdistrictId = '<?= esc($old_input['d_subdistrict'] ?? (isset($driverdetails) ? $driverdetails[0]['d_subdistrict'] : '')) ?>';
    var savedVillageId = '<?= esc($old_input['d_village'] ?? (isset($driverdetails) ? $driverdetails[0]['d_village'] : '')) ?>';

    // Province change → load Kabupaten/Kota
    $('#d_province').on('change', function() {
        var provinceId = $(this).val();

        // Reset child dropdowns
        $('#d_city').html('<option value="">--Pilih Kab/Kota--</option>').trigger('change.select2');
        $('#d_subdistrict').html('<option value="">--Pilih Kecamatan--</option>').trigger('change.select2');
        $('#d_village').html('<option value="">--Pilih Kelurahan--</option>').trigger('change.select2');
        $('#d_city_name').val('');
        $('#d_subdistrict_name').val('');
        $('#d_village_name').val('');

        if (provinceId) {
            loadRegencies(provinceId);
        }
    });

    // City change → load Kecamatan
    $('#d_city').on('change', function() {
        var cityId = $(this).val();
        var selectedText = $(this).find('option:selected').text().trim();

        // Update hidden city name
        $('#d_city_name').val(selectedText);

        // Reset child dropdowns
        $('#d_subdistrict').html('<option value="">--Pilih Kecamatan--</option>').trigger('change.select2');
        $('#d_village').html('<option value="">--Pilih Kelurahan--</option>').trigger('change.select2');
        $('#d_subdistrict_name').val('');
        $('#d_village_name').val('');

        if (cityId) {
            loadDistricts(cityId);
        }
    });

    // District change → load Kelurahan
    $('#d_subdistrict').on('change', function() {
        var districtId = $(this).val();
        var selectedText = $(this).find('option:selected').text().trim();

        // Update hidden district name
        $('#d_subdistrict_name').val(selectedText);

        // Reset child dropdown
        $('#d_village').html('<option value="">--Pilih Kelurahan--</option>').trigger('change.select2');
        $('#d_village_name').val('');

        if (districtId) {
            loadVillages(districtId);
        }
    });

    // Village change → update hidden name
    $('#d_village').on('change', function() {
        var selectedText = $(this).find('option:selected').text().trim();
        $('#d_village_name').val(selectedText);
    });

    // AJAX: Load Regencies (Kabupaten/Kota)
    function loadRegencies(provinceId, selectId) {
        $.ajax({
            url: baseUrl + 'drivers/getRegencies/' + provinceId,
            type: 'GET',
            dataType: 'json',
            beforeSend: function() {
                $('#d_city').html('<option value="">Loading...</option>').trigger('change.select2');
            },
            success: function(data) {
                var $city = $('#d_city');
                $city.html('<option value="">--Pilih Kab/Kota--</option>');
                if (data && !data.error && Array.isArray(data)) {
                    $.each(data, function(index, regency) {
                        var selected = (selectId && regency.id == selectId) ? 'selected' : '';
                        $city.append('<option value="' + regency.id + '" ' + selected + '>' + regency.name + '</option>');
                    });
                }
                $city.trigger('change.select2');
                // If a value was pre-selected, update hidden name and trigger cascade
                if (selectId && $city.val()) {
                    var selectedName = $city.find('option:selected').text().trim();
                    $('#d_city_name').val(selectedName);
                    if (savedSubdistrictId) {
                        loadDistricts(selectId, savedSubdistrictId);
                    }
                }
            },
            error: function() {
                $('#d_city').html('<option value="">--Gagal memuat data--</option>').trigger('change.select2');
            }
        });
    }

    // AJAX: Load Districts (Kecamatan)
    function loadDistricts(cityId, selectId) {
        $.ajax({
            url: baseUrl + 'drivers/getDistricts/' + cityId,
            type: 'GET',
            dataType: 'json',
            beforeSend: function() {
                $('#d_subdistrict').html('<option value="">Loading...</option>').trigger('change.select2');
            },
            success: function(data) {
                var $subdistrict = $('#d_subdistrict');
                $subdistrict.html('<option value="">--Pilih Kecamatan--</option>');
                if (data && !data.error && Array.isArray(data)) {
                    $.each(data, function(index, district) {
                        var selected = (selectId && district.id == selectId) ? 'selected' : '';
                        $subdistrict.append('<option value="' + district.id + '" ' + selected + '>' + district.name + '</option>');
                    });
                }
                $subdistrict.trigger('change.select2');
                if (selectId && $subdistrict.val()) {
                    var selectedName = $subdistrict.find('option:selected').text().trim();
                    $('#d_subdistrict_name').val(selectedName);
                    if (savedVillageId) {
                        loadVillages(selectId, savedVillageId);
                    }
                }
            },
            error: function() {
                $('#d_subdistrict').html('<option value="">--Gagal memuat data--</option>').trigger('change.select2');
            }
        });
    }

    // AJAX: Load Villages (Kelurahan)
    function loadVillages(districtId, selectId) {
        $.ajax({
            url: baseUrl + 'drivers/getVillages/' + districtId,
            type: 'GET',
            dataType: 'json',
            beforeSend: function() {
                $('#d_village').html('<option value="">Loading...</option>').trigger('change.select2');
            },
            success: function(data) {
                var $village = $('#d_village');
                $village.html('<option value="">--Pilih Kelurahan--</option>');
                if (data && !data.error && Array.isArray(data)) {
                    $.each(data, function(index, village) {
                        var selected = (selectId && village.id == selectId) ? 'selected' : '';
                        $village.append('<option value="' + village.id + '" ' + selected + '>' + village.name + '</option>');
                    });
                }
                $village.trigger('change.select2');
                if (selectId && $village.val()) {
                    var selectedName = $village.find('option:selected').text().trim();
                    $('#d_village_name').val(selectedName);
                }
            },
            error: function() {
                $('#d_village').html('<option value="">--Gagal memuat data--</option>').trigger('change.select2');
            }
        });
    }

    // On page load: if province is already selected (edit mode), load the cascade
    var currentProvinceId = $('#d_province').val();
    if (currentProvinceId && savedCityId) {
        loadRegencies(currentProvinceId, savedCityId);
    }

    // Fungsi hitung umur spesifik (tahun, bulan, hari)
    function hitungUmur(tanggalLahir) {
        if (!tanggalLahir) {
            $('#d_age').val('');
            return;
        }
        
        var parsing = tanggalLahir.split('-')
        if(parsing.length !== 3 ){
            $('#d_age').val('');
            return;
        }

        var day = parseInt(parsing[0], 10);
        var month = parseInt(parsing[1], 10) -1;
        var year = parseInt(parsing[2], 10);

        var dob = new Date(year, month, day);
        var today = new Date();

        // Validasi tanggal lahir tidak di masa depan
        if (dob > today) {
            $('#d_age').val('Tanggal lahir tidak valid');
            return;
        }

        var tahun = today.getFullYear() - dob.getFullYear();
        var bulan = today.getMonth() - dob.getMonth();
        var hari = today.getDate() - dob.getDate();

        // Jika hari negatif, pinjam dari bulan sebelumnya
        if (hari < 0) {
            bulan--;
            // Hitung jumlah hari di bulan sebelumnya
            var bulanSebelumnya = new Date(today.getFullYear(), today.getMonth(), 0);
            hari += bulanSebelumnya.getDate();
        }

        // Jika bulan negatif, pinjam dari tahun
        if (bulan < 0) {
            tahun--;
            bulan += 12;
        }

        // Output hanya tahun saja
        $('#d_age').val(tahun);
    }

    // Hitung umur saat user mengubah tanggal lahir
    $('#d_dob').on('change', function() {
        hitungUmur($(this).val());
    });

    // Hitung umur saat halaman dimuat (untuk mode edit)
    var dobValue = $('#d_dob').val();
    if (dobValue) {
        hitungUmur(dobValue);
    }

    // Preview foto driver saat user memilih file baru (hanya untuk halaman Add Driver)
    $('#d_photo').on('change', function(foto) {
        var file = foto.target.files[0];
        if (file) {
            var allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (allowedTypes.indexOf(file.type) === -1) {
                $('#format_error').show();
                $('#photo_preview').attr('src', '<?= base_url("assets/uploads/drivers/user.png") ?>');
                return;
            }
            $('#format_error').hide();
            $('#photo_error').hide();

            var reader = new FileReader();
            reader.onload = function(event) {
                $('#photo_preview').attr('src', event.target.result);
            };
            reader.readAsDataURL(file);
        }
    });
});

$('#d_pdf_document').on('change', function(e) {
        var file = e.target.files[0];
        if (file) {
            var allowedTypes = ['application/pdf'];
            if (allowedTypes.indexOf(file.type) === -1) {
                $('#format_error').show();
                $('#pdf_preview').attr('src', '<?= base_url("assets/uploads/document/user.pdf") ?>');
                return;
            }
            $('#format_error').hide();
            $('#pdf_error').hide();

            var reader = new FileReader();
            reader.onload = function(event) {
                $('#pdf_preview').attr('src', event.target.result);
            };
            reader.readAsDataURL(file);
        }
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