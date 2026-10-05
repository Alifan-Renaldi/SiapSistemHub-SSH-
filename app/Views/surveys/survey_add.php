<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><?= (isset($surveydetails)) ? 'Edit Survey' : 'Add Survey' ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('surveys/survey_management'); ?>">Survey</a></li>
                    <li class="breadcrumb-item active"><?= (isset($surveydetails)) ? 'Edit Survey' : 'Add Survey' ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <form method="post" id="add_survey" class="card <?= (isset($surveydetails)) ? 'updatesurvey' : 'insertsurvey'; ?>" enctype="multipart/form-data" action="<?= base_url('drivers/'.(isset($surveydetails) ? 'updatesurvey' : 'insertsurvey')); ?>">
            <!--<?= csrf_field() ?>-->
            <div class="card-body">
                <h3 class="text-center">Formulir Survei</h3>
                <hr>
                <div class="row">
                    <!-- Photo Upload Section -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Nomor Survey<span class="form-required"></span></label>
                            <input type="text" id="s_code" class="form-control" name="s_code" value="<?= (isset($surveydetails) && !empty($surveydetails[0]['s_code'])) ? esc($surveydetails[0]['s_code']) : esc($new_survey_code) ?>" readonly>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h4 class="text-center">Upload Dokumen</h4>
                                <hr>
                                <div class="form-group">
                                    <label class="form-label">Lampiran Foto (JPG/JPEG/PNG)<span class="form-required" style="color: red;">*</span></label>
                                    <input type="file" name="s_fotorumah[]" id="s_fotorumah" class="form-control" accept="image/jpeg, image/jpg, image/png" multiple>
                                    <input type="hidden" name="existing_fotorumah_1" value="<?= isset($surveydetails) ? esc($surveydetails[0]['s_fotorumah_1'] ?? '') : '' ?>">
                                    <input type="hidden" name="existing_fotorumah_2" value="<?= isset($surveydetails) ? esc($surveydetails[0]['s_fotorumah_2'] ?? '') : '' ?>">
                                    <input type="hidden" name="existing_fotorumah_3" value="<?= isset($surveydetails) ? esc($surveydetails[0]['s_fotorumah_3'] ?? '') : '' ?>">
                                    <input type="hidden" name="deleted_existing_fotorumah" id="deleted_existing_fotorumah" value="">
                                    <small class="text-muted">Unggah Maksimal 3 foto.</small>
                                    <div id="preview-container" style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 10px;">
                                        <?php if (isset($surveydetails)): ?>
                                            <?php for ($i = 1; $i <= 3; $i++): ?>
                                                <?php $fotoKey = 's_fotorumah_' . $i; ?>
                                                <?php if (!empty($surveydetails[0][$fotoKey])): ?>
                                                    <div class="existing-preview-item" data-filename="<?= esc($surveydetails[0][$fotoKey]) ?>" data-slot="<?= $i ?>" style="position: relative; border: 2px solid #ddd; border-radius: 8px; padding: 5px;">
                                                        <img src="<?= base_url('assets/uploads/survey/' . esc($surveydetails[0][$fotoKey])) ?>"
                                                        alt="Foto Rumah <?= $i ?>"
                                                        style="width: 120px; height: 120px; object-fit: cover; border-radius: 6px;"/>
                                                        <button type="button" class="btn-remove-photo" data-filename="<?= esc($surveydetails[0][$fotoKey]) ?>" data-slot="<?= $i ?>" title="Hapus Foto" style="position: absolute; top: 2px; right: 2px; background: red; color: white; border: none; border-radius: 50%; width: 24px; height: 24px; font-size: 14px; cursor: pointer; display: flex; align-items: center; justify-content: center; line-height: 1;">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                        <div style="text-align: center; margin-top: 4px;">
                                                            <small class="text-muted" style="font-size: 10px; word-break: break-all;"><?= esc($surveydetails[0][$fotoKey]) ?></small>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                        <?php endif; ?>
                                    </div>
                                    <div id="photo_error" class="text-danger" style="margin-top: 5px; display: none;">Harap unggah foto survey</div>
                                    <div id="format_error" class="text-danger" style="margin-top: 5px; display: none;">Hanya format JPG/JPEG/PNG yang diperbolehkan</div>
                                    <div id="max_files_error" class="text-danger" style="margin-top: 5px; display: none;">Maksimal 3 foto yang diperbolehkan</div>
                                </div>
                                <hr>
                            </div>
                        </div>
                    </div>

                    <!-- Personal Information Section -->
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <input type="hidden" name="s_id" id="s_id" value="<?= (isset($surveydetails)) ? esc($surveydetails[0]['s_id']) : ''; ?>">
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Petugas Survei<span class="form-required" style="color: red;">*</span></label>
                                            <input type="text" name="s_petugas" id="s_petugas" class="form-control" value="<?= (isset($surveydetails)) ? esc($surveydetails[0]['s_petugas']) : ''; ?>" oninput="this.value = capitalizeEachWord(this.value)">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Tanggal Survei<span class="form-required" style="color: red;">*</span></label>
                                            <input type="text" name="s_tanggal" id="s_tanggal" value="<?= old('s_tanggal', isset($surveydetails[0]['s_tanggal']) && $surveydetails[0]['s_tanggal'] !== '0000-00-00' ? date('d-m-Y', strtotime($surveydetails[0]['s_tanggal'])) : '') ?>" class="form-control datepicker">
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Nama Supir<span class="form-required" style="color: red;">*</span></label>
                                            <select id="s_supir" class="form-control form-control-sm select2 form-equal-height" name="s_supir" onchange="updateNIS()">
                                                <option value="">-- Pilih Supir --</option>
                                                <?php 
                                                $selectedValue = old('s_nis', isset($surveydetails) ? ($surveydetails[0]['s_nis'] ?? '') : '');
                                                foreach ($driverlist as $driver) {
                                                    $combinedValue = $driver['d_name'];
                                                    $selected = ($selectedValue == $driver['d_nis'] && $driver['d_is_active'] == 1) ? 'selected' : '';
                                                    if ($driver['d_is_active'] == 1) {
                                                        echo '<option value="' . esc($combinedValue) . '" 
                                                              data-nis="' . esc($driver['d_nis']) . '" 
                                                              data-tanggal-masuk="' . esc(date('d-m-Y', strtotime($driver['d_doj']))) . '" 
                                                              data-referensi="' . esc($driver['d_ref']) . '" 
                                                              data-nikah="' . esc($driver['d_married']) . '"' . $selected . '>' 
                                                              . esc($driver['d_name']) . ' ' . '(' . esc($driver['d_nickname']) . ')' . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">NIS<span class="form-required"></span></label>
                                            <input type="text" id="s_nis" class="form-control" name="s_nis" value="<?= old('s_nis', isset($surveydetails) ? ($surveydetails[0]['s_nis'] ?? '') : '') ?>" placeholder="[auto]" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Tanggal Masuk<span class="form-required"></span></label>
                                            <input type="text" id="s_tanggal_masuk" class="form-control" name="s_tanggal_masuk" 
                                                   value="<?= old('s_tanggal_masuk', isset($surveydetails[0]['s_tanggal_masuk']) && $surveydetails[0]['s_tanggal_masuk'] !== '0000-00-00' ? date('d-m-Y', strtotime($surveydetails[0]['s_tanggal_masuk'])) : '') ?>" 
                                                   placeholder="[auto]" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Referensi<span class="form-required"></span></label>
                                            <input type="text" id="s_referensi" class="form-control" name="s_referensi" 
                                                   value="<?= old('s_referensi', isset($surveydetails) ? ($surveydetails[0]['s_referensi'] ?? '') : '') ?>" 
                                                   placeholder="[auto]" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Status Pernikahan<span class="form-required"></span></label>
                                            <input type="text" id="s_nikah" class="form-control" name="s_nikah" 
                                                   value="<?= old('s_nikah', isset($surveydetails) ? ($surveydetails[0]['s_nikah'] ?? '') : '') ?>" 
                                                   placeholder="[auto]" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Nama Ayah<span class="form-required"></span></label>
                                            <input type="text" name="s_bapak" value="<?= (isset($surveydetails)) ? esc($surveydetails[0]['s_bapak']) : ''; ?>" class="form-control" oninput="this.value = capitalizeEachWord(this.value)">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Nama Ibu<span class="form-required"></span></label>
                                            <input type="text" name="s_ibu" value="<?= (isset($surveydetails)) ? esc($surveydetails[0]['s_ibu']) : ''; ?>" class="form-control" oninput="this.value = capitalizeEachWord(this.value)">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Nama Istri<span class="form-required" style="color: red;">*</span></label>
                                            <input type="text" name="s_istri" value="<?= (isset($surveydetails)) ? esc($surveydetails[0]['s_istri']) : ''; ?>" class="form-control" oninput="this.value = capitalizeEachWord(this.value)">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Pekerjaan Istri<span class="form-required" style="color: red;">*</span></label>
                                            <input type="text" name="s_pekerjaan_istri" value="<?= (isset($surveydetails)) ? esc($surveydetails[0]['s_pekerjaan_istri']) : ''; ?>" class="form-control" oninput="this.value = capitalizeEachWord(this.value)">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Nomor Telepon Istri<span class="form-required" style="color: red;">*</span></label>
                                            <input type="text" name="s_telepon_istri" value="<?= (isset($surveydetails)) ? esc($surveydetails[0]['s_telepon_istri']) : ''; ?>" class="form-control" placeholder="">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Nomor Telepon Keluarga <small class="text-muted">(SELAIN ISTRI)</small></label>
                                            <input type="text" name="s_telepon_keluarga" value="<?= (isset($surveydetails)) ? esc($surveydetails[0]['s_telepon_keluarga']) : ''; ?>" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Alamat Rumah Saat Ini<span class="form-required" style="color: red;">*</span></label>
                                            <textarea class="form-control" autocomplete="off" placeholder="Alamat Domisili" name="s_alamat" oninput="this.value = capitalizeEachWord(this.value)"><?= (isset($surveydetails)) ? esc($surveydetails[0]['s_alamat']) : ''; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-6"> 
                                        <div class="form-group">
                                            <label class="form-label">Provinsi<span class="form-required" style="color: red;">*</span></label>
                                            <select id="s_prov" name="s_prov" class="form-control select2-prov form-equal-height">
                                                <option value="">--Pilih Provinsi--</option>
                                               <?php foreach ($provinces as $province): ?>
                                                    <?php 
                                                    $selected = false;
                                                    if (isset($old_input['s_prov']) && $old_input['s_prov'] == $province['name'] || (isset($surveydetails) && $surveydetails[0]['s_prov'] == $province['id'])) {
                                                        $selected = true;
                                                    } elseif (isset($old_input['s_prov']) && $old_input['s_prov'] == $province['id']) {
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
                                            <label for="s_kab" class="form-label">Kabupaten/Kota<span class="form-required" style="color: red;">*</span></label>
                                            <select id="s_kab" name="s_kab" class="form-control select2-city form-equal-height">
                                                <option value="">--Pilih Kab/Kota--</option>
                                                <?php if (!empty($old_input['s_kab']) || (isset($surveydetails) && !empty($surveydetails[0]['s_kab']))): ?>
                                                    <?php 
                                                    $selectedCityId = $old_input['s_kab'] ?? ($surveydetails[0]['s_kab'] ?? '');
                                                    $selectedCityName = $old_input['s_kab'] ?? ($surveydetails[0]['s_kab_name'] ?? '');
                                                    ?>
                                                    <option value="<?= esc($selectedCityId) ?>" selected>
                                                        <?= esc($selectedCityName) ?>
                                                    </option>
                                                <?php endif; ?>
                                            </select>
                                            <input type="hidden" id="s_kab_name" name="s_kab_name" value="<?= esc($old_input['s_kab_name'] ?? ($surveydetails[0]['s_kab_name'] ?? '')) ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="s_kec" class="form-label">Kecamatan<span class="form-required" style="color: red;">*</span></label>
                                            <select id="s_kec" name="s_kec" class="form-control select2-subdistrict form-equal-height">
                                                <option value="">--Pilih Kecamatan--</option>
                                               <?php if (!empty($old_input['s_kec']) || (isset($surveydetails) && !empty($surveydetails[0]['s_kec']))): ?>
                                                    <?php 
                                                    $selectedSubdistrictId = $old_input['s_kec'] ?? ($surveydetails[0]['s_kec'] ?? '');
                                                    $selectedSubdistrictName = $old_input['s_kec_name'] ?? ($surveydetails[0]['s_kec_name'] ?? '');
                                                    ?>
                                                    <option value="<?= esc($selectedSubdistrictId) ?>" selected>
                                                        <?= esc($selectedSubdistrictName) ?>
                                                    </option>
                                                <?php endif; ?>
                                            </select>
                                            <input type="hidden" id="s_kec_name" name="s_kec_name" value="<?= esc($old_input['s_kec_name'] ?? ($surveydetails[0]['s_kec_name'] ?? '')) ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="s_kel" class="form-label">Kelurahan<span class="form-required" style="color: red;">*</span></label>
                                            <select id="s_kel" name="s_kel" class="form-control select2-village form-equal-height">
                                                <option value="">--Pilih Kelurahan--</option>
                                                <?php if (!empty($old_input['s_kel']) || (isset($surveydetails) && !empty($surveydetails[0]['s_kel']))): ?>
                                                    <?php 
                                                    $selectedVillageId = $old_input['s_kel'] ?? ($surveydetails[0]['s_kel'] ?? '');
                                                    $selectedVillageName = $old_input['s_kel_name'] ?? ($surveydetails[0]['s_kel_name'] ?? '');
                                                    ?>
                                                    <option value="<?= esc($selectedVillageId) ?>" selected>
                                                        <?= esc($selectedVillageName) ?>
                                                    </option>
                                                <?php endif; ?>
                                            </select>
                                            <input type="hidden" id="s_kel_name" name="s_kel_name" value="<?= esc($old_input['s_kel_name'] ?? ($surveydetails[0]['s_kel_name'] ?? '')) ?>">
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-12">
                                        <hr>
                                        <h3 class="text-center">Hasil Survei</h3>
                                        <hr>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group checkbox-group">
                                            <label class="form-label">Kondisi Rumah<span class="form-required" style="color: red;">*</span></label><br>
                                            <div class="border p-3 rounded d-flex flex-column">
                                            <div class="form-check">
                                                <input type="checkbox" id="kondisi_permanen" name="s_kondisi_rumah" class="form-check-input" value="Permanen"
                                                    <?= (isset($surveydetails) && $surveydetails[0]['s_kondisi_rumah'] == 'Permanen') ? 'checked' : ''; ?>
                                                    onclick="handleSingleCheckbox(this)">
                                                <label class="form-check-label" for="kondisi_permanen">Permanen</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" id="kondisi_semi_permanen" name="s_kondisi_rumah" class="form-check-input" value="Semi Permanen"
                                                    <?= (isset($surveydetails) && $surveydetails[0]['s_kondisi_rumah'] == 'Semi Permanen') ? 'checked' : ''; ?>
                                                    onclick="handleSingleCheckbox(this)">
                                                <label class="form-check-label" for="kondisi_semi_permanen">Semi Permanen</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" id="kondisi_non_permanen" name="s_kondisi_rumah" class="form-check-input" value="Non Permanen"
                                                    <?= (isset($surveydetails) && $surveydetails[0]['s_kondisi_rumah'] == 'Non Permanen') ? 'checked' : ''; ?>
                                                    onclick="handleSingleCheckbox(this)">
                                                <label class="form-check-label" for="kondisi_non_permanen">Non Permanen</label>
                                            </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Status Rumah<span class="form-required" style="color: red;">*</span></label>
                                            <select id="s_status_rumah" name="s_status_rumah" class="form-control">
                                                <option value="">-- Pilih Status Rumah --</option> 
                                                <option <?= (isset($surveydetails) && $surveydetails[0]['s_status_rumah']=='Milik Pribadi') ? 'selected' : '' ?> value="Milik Pribadi">Milik Pribadi</option> 
                                                <option <?= (isset($surveydetails) && $surveydetails[0]['s_status_rumah']=='Sewa') ? 'selected' : '' ?> value="Sewa">Sewa</option>
                                                <option <?= (isset($surveydetails) && $surveydetails[0]['s_status_rumah']=='Milik Orang Tua') ? 'selected' : '' ?> value="Milik Orang Tua">Milik Orang Tua</option>
                                                <option <?= (isset($surveydetails) && $surveydetails[0]['s_status_rumah']=='Milik Saudara') ? 'selected' : '' ?> value="Milik Saudara">Milik Saudara</option>
                                                <option <?= (isset($surveydetails) && $surveydetails[0]['s_status_rumah']=='Lainnya') ? 'selected' : '' ?> value="Lainnya">Lainnya</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Jumlah Penghuni Rumah<span class="form-required" style="color: red;">*</span></label>
                                            <input type="text" name="s_penghuni" value="<?= (isset($surveydetails)) ? esc($surveydetails[0]['s_penghuni']) : ''; ?>" class="form-control" oninput="this.value = capitalizeEachWord(this.value)">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Lama Menetap di Alamat Ini<span class="form-required" style="color: red;">*</span></label>
                                            <input type="text" name="s_menetap" value="<?= (isset($surveydetails)) ? esc($surveydetails[0]['s_menetap']) : ''; ?>" class="form-control" oninput="this.value = capitalizeEachWord(this.value)">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Jumlah Tanggungan<span class="form-required" style="color: red;">*</span></label>
                                            <input type="text" name="s_tanggungan" value="<?= (isset($surveydetails)) ? esc($surveydetails[0]['s_tanggungan']) : ''; ?>" class="form-control" oninput="this.value = capitalizeEachWord(this.value)">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Kendaraan yang Dimiliki<span class="form-required" style="color: red;">*</span></label>
                                            <input type="text" name="s_kendaraan" value="<?= (isset($surveydetails)) ? esc($surveydetails[0]['s_kendaraan']) : ''; ?>" class="form-control" oninput="this.value = capitalizeEachWord(this.value)">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Nama Tetangga<span class="form-required"></span></label>
                                            <input type="text" name="s_tetangga" value="<?= (isset($surveydetails)) ? esc($surveydetails[0]['s_tetangga']) : ''; ?>" class="form-control" oninput="this.value = capitalizeEachWord(this.value)">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Nama Saudara/Kerabat Tidak Serumah<span class="form-required" style="color: red;">*</span></label>
                                            <input type="text" name="s_saudara" value="<?= (isset($surveydetails)) ? esc($surveydetails[0]['s_saudara']) : ''; ?>" class="form-control" oninput="this.value = capitalizeEachWord(this.value)">
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Alamat Saudara/Kerabat</label>
                                            <textarea class="form-control" autocomplete="off" placeholder="" name="s_alamat_saudara" oninput="this.value = capitalizeEachWord(this.value)"><?= (isset($surveydetails)) ? esc($surveydetails[0]['s_alamat_saudara']) : ''; ?></textarea>
                                        </div>
                                    </div>      

                                    <div class="col-sm-6 col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Keterangan</label>
                                            <textarea class="form-control" autocomplete="off" placeholder="" name="s_keterangan"><?= (isset($surveydetails)) ? esc($surveydetails[0]['s_keterangan']) : ''; ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" id="s_modified_date" name="s_modified_date" value="<?= date('Y-m-d H:i:s'); ?>">
                                
                                <div class="card-footer d-flex">
                                    <a href="<?= base_url('surveys/survey_management'); ?>" class="btn btn-warning" onclick="return confirmCancel()">
                                        <i class="fa fa-left"></i> CANCEL
                                    </a>
                                    <button type="submit" class="btn btn-primary ml-auto" onclick="return confirmSave()"> 
                                        <?= (isset($surveydetails)) ? 'UPDATE' : 'SAVE'; ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<?= view('layout/footer') ?>

<script src="<?= base_url('assets/autoLogout.js') ?>"></script>
<script>
$(document).ready(function() {
    var baseUrl = "<?= base_url() ?>";

    // Initialize Select2 on all region dropdowns
    $('#s_prov').select2({ placeholder: '--Pilih Provinsi--', allowClear: true });
    $('#s_kab').select2({ placeholder: '--Pilih Kab/Kota--', allowClear: true });
    $('#s_kec').select2({ placeholder: '--Pilih Kecamatan--', allowClear: true });
    $('#s_kel').select2({ placeholder: '--Pilih Kelurahan--', allowClear: true });

    // Saved values for edit mode
    var savedCityId = '<?= esc($old_input['s_kab'] ?? ($surveydetails[0]['s_kab'] ?? '')) ?>';
    var savedSubdistrictId = '<?= esc($old_input['s_kec'] ?? ($surveydetails[0]['s_kec'] ?? '')) ?>';
    var savedVillageId = '<?= esc($old_input['s_kel'] ?? ($surveydetails[0]['s_kel'] ?? '')) ?>';

    // Province change → load Kabupaten/Kota
    $('#s_prov').on('change', function() {
        var provinceId = $(this).val();

        // Reset child dropdowns
        $('#s_kab').html('<option value="">--Pilih Kab/Kota--</option>').trigger('change.select2');
        $('#s_kec').html('<option value="">--Pilih Kecamatan--</option>').trigger('change.select2');
        $('#s_kel').html('<option value="">--Pilih Kelurahan--</option>').trigger('change.select2');
        $('#s_kab_name').val('');
        $('#s_kec_name').val('');
        $('#s_kel_name').val('');

        if (provinceId) {
            loadRegencies(provinceId);
        }
    });

    // City change → load Kecamatan
    $('#s_kab').on('change', function() {
        var cityId = $(this).val();
        var selectedText = $(this).find('option:selected').text().trim();

        // Update hidden city name
        $('#s_kab_name').val(selectedText);

        // Reset child dropdowns
        $('#s_kec').html('<option value="">--Pilih Kecamatan--</option>').trigger('change.select2');
        $('#s_kel').html('<option value="">--Pilih Kelurahan--</option>').trigger('change.select2');
        $('#s_kec_name').val('');
        $('#s_kel_name').val('');

        if (cityId) {
            loadDistricts(cityId);
        }
    });

    // District change → load Kelurahan
    $('#s_kec').on('change', function() {
        var districtId = $(this).val();
        var selectedText = $(this).find('option:selected').text().trim();

        // Update hidden district name
        $('#s_kec_name').val(selectedText);

        // Reset child dropdown
        $('#s_kel').html('<option value="">--Pilih Kelurahan--</option>').trigger('change.select2');
        $('#s_kel_name').val('');

        if (districtId) {
            loadVillages(districtId);
        }
    });

    // Village change → update hidden name
    $('#s_kel').on('change', function() {
        var selectedText = $(this).find('option:selected').text().trim();
        $('#s_kel_name').val(selectedText);
    });

    // AJAX: Load Regencies (Kabupaten/Kota)
    function loadRegencies(provinceId, selectId) {
        $.ajax({
            url: baseUrl + 'drivers/getRegencies/' + provinceId,
            type: 'GET',
            dataType: 'json',
            beforeSend: function() {
                $('#s_kab').html('<option value="">Loading...</option>').trigger('change.select2');
            },
            success: function(data) {
                var $city = $('#s_kab');
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
                    $('#s_kab_name').val(selectedName);
                    if (savedSubdistrictId) {
                        loadDistricts(selectId, savedSubdistrictId);
                    }
                }
            },
            error: function() {
                $('#s_kab').html('<option value="">--Gagal memuat data--</option>').trigger('change.select2');
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
                $('#s_kec').html('<option value="">Loading...</option>').trigger('change.select2');
            },
            success: function(data) {
                var $subdistrict = $('#s_kec');
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
                    $('#s_kec_name').val(selectedName);
                    if (savedVillageId) {
                        loadVillages(selectId, savedVillageId);
                    }
                }
            },
            error: function() {
                $('#s_kec').html('<option value="">--Gagal memuat data--</option>').trigger('change.select2');
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
                $('#s_kel').html('<option value="">Loading...</option>').trigger('change.select2');
            },
            success: function(data) {
                var $village = $('#s_kel');
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
                    $('#s_kel_name').val(selectedName);
                }
            },
            error: function() {
                $('#s_kel').html('<option value="">--Gagal memuat data--</option>').trigger('change.select2');
            }
        });
    }

    // On page load: if province is already selected (edit mode), load the cascade
    var currentProvinceId = $('#s_prov').val();
    if (currentProvinceId && savedCityId) {
        loadRegencies(currentProvinceId, savedCityId);
    }
});


    $('.select2').on('change', function() {
        $(this).valid();
        updateNIS();
    });
    
    $('input[type="checkbox"]').on('change', function() {
        $(this).valid();
    });
    
    $('.select2').select2({
        placeholder: "-- Pilih Supir --",
        allowClear: true
    });

    var deletedExistingPhotos = [];

    $('#s_fotorumah').on('change', function(e) {
        var files = e.target.files;
        var allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        var maxFiles = 3;

        // Reset error messages
        $('#format_error').hide();
        $('#photo_error').hide();
        $('#max_files_error').hide();

        // Validasi jumlah file existing yang masih aktif + file baru
        var existingCount = $('#preview-container .existing-preview-item').length;
        if (existingCount + files.length > maxFiles) {
            $('#max_files_error').show();
            $(this).val('');
            return;
        }

        // Validasi format setiap file
        for (var i = 0; i < files.length; i++) {
            if (allowedTypes.indexOf(files[i].type) === -1) {
                $('#format_error').show();
                $(this).val('');
                return;
            }
        }

        // Generate preview untuk setiap file baru (tambahkan, jangan hapus existing)
        for (var j = 0; j < files.length; j++) {
            (function(file, index) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    var previewItem =
                        '<div class="new-preview-item" data-new-index="' + index + '" style="position: relative; border: 2px solid #28a745; border-radius: 8px; padding: 5px;">' +
                            '<img src="' + event.target.result + '" ' +
                                'alt="Preview Foto ' + (index + 1) + '" ' +
                                'style="width: 120px; height: 120px; object-fit: cover; border-radius: 6px;" />' +
                            '<button type="button" class="btn-remove-photo" data-type="new" title="Hapus Foto" style="position: absolute; top: 2px; right: 2px; background: red; color: white; border: none; border-radius: 50%; width: 24px; height: 24px; font-size: 14px; cursor: pointer; display: flex; align-items: center; justify-content: center; line-height: 1;">' +
                                '<i class="fa fa-times"></i>' +
                            '</button>' +
                            '<div style="text-align: center; margin-top: 4px;">' +
                                '<small class="text-success" style="font-size: 10px; word-break: break-all;">Foto ' + (index + 1) + ': ' + file.name + '</small>' +
                            '</div>' +
                        '</div>';
                    $('#preview-container').append(previewItem);
                };
                reader.readAsDataURL(file);
            })(files[j], j);
        }

        // Update validasi jumlah foto
        updatePhotoValidation();
    });

    // Delegated click handler untuk tombol remove foto
    $('#preview-container').on('click', '.btn-remove-photo', function(e) {
        e.preventDefault();
        var $btn = $(this);
        var $item = $btn.closest('.existing-preview-item, .new-preview-item');

        if ($item.hasClass('existing-preview-item')) {
            var filename = $btn.data('filename');
            var slot = $btn.data('slot');
            deletedExistingPhotos.push(filename);
            // Clear hidden input
            $('input[name="existing_fotorumah_' + slot + '"]').val('');
        }

        $item.remove();
        updatePhotoValidation();
    });

    function updatePhotoValidation() {
        var totalPhotos = $('#preview-container #existing_fotorumah_1, #preview-container #existing_fotorumah_2, #preview-container #existing_fotorumah_3').length;
        var totalNewPhotos = $('#preview-container #').length;
        if (totalPhotos === 0) {
            $('#photo_error').show();
        } else {
            $('#photo_error').hide();
        }
    }

    // Sebelum form submit, isi hidden input deleted_existing_fotorumah
    $('#add_survey').on('submit', function() {
        $('#deleted_existing_fotorumah').val(deletedExistingPhotos.join(','));
    });
    
    
function updateNIS() {
    const inventorySelect = document.getElementById('s_supir');
    const selectedOption = inventorySelect.options[inventorySelect.selectedIndex];
    const nis = selectedOption.getAttribute('data-nis');
    const tanggalMasuk = selectedOption.getAttribute('data-tanggal-masuk');
    const referensi = selectedOption.getAttribute('data-referensi');
    const nikah = selectedOption.getAttribute('data-nikah');
    document.getElementById('s_nis').value = nis || '';
    document.getElementById('s_tanggal_masuk').value = tanggalMasuk || '';
    document.getElementById('s_referensi').value = referensi || '';
    document.getElementById('s_nikah').value = nikah || '';
}

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
        height: 36px !important;
        border: 1px solid #ced4da !important;
        border-radius: 4px !important;
        padding: 5px 12px !important;
        display: flex !important;
        align-items: center !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: normal !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
        width: 100% !important;
        color: #495057 !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 100% !important;
        top: 0 !important;
     }
     .select2-container .select2-selection.is-invalid {
         border: 1px solid #dc3545 !important;
     }
</style>