<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><?= (isset($inventorydetails)) ? 'Edit Inventory' : 'Add Inventory' ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('inventory/inventory_management') ?>">Inventory</a></li>
                    <li class="breadcrumb-item active"><?= (isset($inventorydetails)) ? 'Edit Inventory' : 'Add Inventory' ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <form method="post" id="inventory_add" class="card <?= (isset($inventorydetails)) ? 'updateinventory' : 'insertinventory' ?>" enctype="multipart/form-data" action="<?= base_url('vehicles/' . ((isset($inventorydetails)) ? 'updateinventory' : 'insertinventory')) ?>">
            <div class="card-body">
                <div class="row">
                    <input type="hidden" name="iv_id" id="iv_id" value="<?= (isset($inventorydetails)) ? esc($inventorydetails[0]['iv_id']) : '' ?>">

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Nomor Inventaris<span class="form-required"></span></label>
                            <input type="text" id="iv_code" class="form-control" name="iv_code" value="<?= (isset($inventorydetails) && !empty($inventorydetails[0]['iv_code'])) ? esc($inventorydetails[0]['iv_code']) : esc($new_inv_code) ?>" readonly>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label for="v_legal" class="form-label">Nomor Polisi<span class="form-required" style="color: red;">*</span></label>
                            <select id="iv_nopol" name="iv_nopol" class="form-control form-control-sm select2-vehicle form-equal-height" onchange="updateNOPOL()">
                                <option value="">-- Pilih Mobil --</option>
                                <?php 
                                $selectedValue = old('iv_nopol', $inventorydetails[0]['iv_nopol'] ?? '');
                                    foreach ($vechiclelist as $vehicle) {
                                        $combinedValue = $vehicle['v_registration_no'];
                                        $selected = ($selectedValue == $combinedValue && $vehicle['v_is_active'] == 1) ? 'selected' : '';

                                        if ($vehicle['v_is_active'] == 1) {
                                            echo '<option value="' . esc($combinedValue) . '" 
                                                    data-jenis="' . esc($vehicle['v_name'] ?? '') . '" 
                                                    data-tahun="' . esc($vehicle['v_reg_exp_date'] ?? '') . '" 
                                                    ' . $selected . '>'
                                                . esc($vehicle['v_registration_no'])
                                                . '</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-4">
                        <label class="form-label">Jenis Mobil</label>
                        <div class="form-group">
                            <input type="text" name="iv_jenis" id="iv_jenis" value="<?= old('iv_jenis', $inventorydetails[0]['iv_jenis'] ?? '') ?>" class="form-control" placeholder="[auto]" readonly>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-4">
                        <label class="form-label">Tahun</label>
                        <div class="form-group">
                            <input type="text" name="iv_tahun" id="iv_tahun" value="<?= old('iv_tahun', $inventorydetails[0]['iv_tahun'] ?? '') ?>" class="form-control" placeholder="[auto]" readonly>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3 checkbox-group">
                        <label class="control-label">STNK<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_stnk" id="stnk_ada" value="Ada"
                                            onclick="handleCheckbox(this, ['stnk_ada', 'stnk_tidak'])"
                                                   <?= (old('iv_stnk', $inventorydetails[0]['iv_stnk'] ?? '') == 'Ada') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="stnk_ada">Ada</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_stnk" id="stnk_tidak" value="Tidak Ada" 
                                            onclick="handleCheckbox(this, ['stnk_ada', 'stnk_tidak'])"
                                                   <?= (old('iv_stnk', $inventorydetails[0]['iv_stnk'] ?? '') == 'Tidak Ada') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="stnk_tidak">Tidak Ada</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3 checkbox-group">
                        <label class="control-label">Buku KIR<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_kir" id="kir_ada" value="Ada"
                                            onclick="handleCheckbox(this, ['kir_ada', 'kir_tidak'])"
                                                   <?= (old('iv_kir', $inventorydetails[0]['iv_kir'] ?? '') == 'Ada') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="kir_ada">Ada</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_kir" id="kir_tidak" value="Tidak Ada" 
                                            onclick="handleCheckbox(this, ['kir_ada', 'kir_tidak'])"
                                                   <?= (old('iv_kir', $inventorydetails[0]['iv_kir'] ?? '') == 'Tidak Ada') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="kir_tidak">Tidak Ada</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3 checkbox-group">
                        <label class="control-label">Tempat Tidur Kabin<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_kabin" id="kabin_ada" value="Ada"
                                            onclick="handleCheckbox(this, ['kabin_ada', 'kabin_tidak'])"
                                                   <?= (old('iv_kabin', $inventorydetails[0]['iv_kabin'] ?? '') == 'Ada') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="kabin_ada">Ada</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_kabin" id="kabin_tidak" value="Tidak Ada" 
                                            onclick="handleCheckbox(this, ['kabin_ada', 'kabin_tidak'])"
                                                   <?= (old('iv_kabin', $inventorydetails[0]['iv_kabin'] ?? '') == 'Tidak Ada') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="kabin_tidak">Tidak Ada</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3 checkbox-group">
                            <label class="control-label">Dongkrak<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                 <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_dongkrak" id="dongkrak_baik" value="Ada/Baik"
                                            onclick="handleCheckbox(this, ['dongkrak_baik', 'dongkrak_rusak', 'dongkrak_tidak'])"
                                                   <?= (old('iv_dongkrak', $inventorydetails[0]['iv_dongkrak'] ?? '') == 'Ada/Baik') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="dongkrak_baik">Ada/Baik</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="iv_dongkrak" id="dongkrak_rusak" value="Ada/Rusak" 
                                            onclick="handleCheckbox(this, ['dongkrak_baik', 'dongkrak_rusak', 'dongkrak_tidak'])"
                                                   <?= (old('iv_dongkrak', $inventorydetails[0]['iv_dongkrak'] ?? '') == 'Ada/Rusak') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="dongkrak_rusak">Ada/Rusak</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_dongkrak" id="dongkrak_tidak" value="Tidak Ada" 
                                            onclick="handleCheckbox(this, ['dongkrak_baik', 'dongkrak_rusak', 'dongkrak_tidak'])"
                                                   <?= (old('iv_dongkrak', $inventorydetails[0]['iv_dongkrak'] ?? '') == 'Tidak Ada') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="dongkrak_tidak">Tidak Ada</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3 checkbox-group">
                            <label class="control-label">Kunci Roda<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                 <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_kunci" id="kuncirod_baik" value="Ada/Baik"
                                            onclick="handleCheckbox(this, ['kuncirod_baik', 'kuncirod_rusak', 'kuncirod_tidak'])"
                                                   <?= (old('iv_kunci', $inventorydetails[0]['iv_kunci'] ?? '') == 'Ada/Baik') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="kuncirod_baik">Ada/Baik</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="iv_kunci" id="kuncirod_rusak" value="Ada/Rusak" 
                                            onclick="handleCheckbox(this, ['kuncirod_baik', 'kuncirod_rusak', 'kuncirod_tidak'])"
                                                   <?= (old('iv_kunci', $inventorydetails[0]['iv_kunci'] ?? '') == 'Ada/Rusak') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="kuncirod_rusak">Ada/Rusak</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_kunci" id="kuncirod_tidak" value="Tidak Ada" 
                                            onclick="handleCheckbox(this, ['kuncirod_baik', 'kuncirod_rusak', 'kuncirod_tidak'])"
                                                   <?= (old('iv_kunci', $inventorydetails[0]['iv_kunci'] ?? '') == 'Tidak Ada') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="kuncirod_tidak">Tidak Ada</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3 checkbox-group">
                            <label class="control-label">Stang/Stick Kunci Roda<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                 <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_stang" id="stangrod_baik" value="Ada/Baik"
                                            onclick="handleCheckbox(this, ['stangrod_baik', 'stangrod_rusak', 'stangrod_tidak'])"
                                                   <?= (old('iv_stang', $inventorydetails[0]['iv_stang'] ?? '') == 'Ada/Baik') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="stangrod_baik">Ada/Baik</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="iv_stang" id="stangrod_rusak" value="Ada/Rusak" 
                                            onclick="handleCheckbox(this, ['stangrod_baik', 'stangrod_rusak', 'stangrod_tidak'])"
                                                   <?= (old('iv_stang', $inventorydetails[0]['iv_stang'] ?? '') == 'Ada/Rusak') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="stangrod_rusak">Ada/Rusak</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_stang" id="stangrod_tidak" value="Tidak Ada" 
                                            onclick="handleCheckbox(this, ['stangrod_baik', 'stangrod_rusak', 'stangrod_tidak'])"
                                                   <?= (old('iv_stang', $inventorydetails[0]['iv_stang'] ?? '') == 'Tidak Ada') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="stangrod_tidak">Tidak Ada</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3 checkbox-group">
                            <label class="control-label">Spanner<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                 <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_spanner" id="spanner_baik" value="Ada/Baik"
                                            onclick="handleCheckbox(this, ['spanner_baik', 'spanner_rusak', 'spanner_tidak'])"
                                                   <?= (old('iv_spanner', $inventorydetails[0]['iv_spanner'] ?? '') == 'Ada/Baik') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="spanner_baik">Ada/Baik</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="iv_spanner" id="spanner_rusak" value="Ada/Rusak" 
                                            onclick="handleCheckbox(this, ['spanner_baik', 'spanner_rusak', 'spanner_tidak'])"
                                                   <?= (old('iv_spanner', $inventorydetails[0]['iv_spanner'] ?? '') == 'Ada/Rusak') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="spanner_rusak">Ada/Rusak</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_spanner" id="spanner_tidak" value="Tidak Ada" 
                                            onclick="handleCheckbox(this, ['spanner_baik', 'spanner_rusak', 'spanner_tidak'])"
                                                   <?= (old('iv_spanner', $inventorydetails[0]['iv_spanner'] ?? '') == 'Tidak Ada') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="spanner_tidak">Tidak Ada</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-6 checkbox-group">
                        <label class="control-label">Ban Serep<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_serep" id="banser_ada" value="Ada/Baik"
                                            onclick="handleCheckbox(this, ['banser_ada', 'banser_tidak', 'banser_rusak'])"
                                                   <?= (old('iv_serep', $inventorydetails[0]['iv_serep'] ?? '') == 'Ada/Baik') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="banser_ada">Ada/Baik</label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_serep" id="banser_rusak" value="Ada/Rusak"
                                            onclick="handleCheckbox(this, ['banser_rusak', 'banser_tidak', 'banser_ada'])"
                                                   <?= (old('iv_serep', $inventorydetails[0]['iv_serep'] ?? '') == 'Ada/Rusak') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="banser_rusak">Ada/Rusak</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_serep" id="banser_tidak" value="Tidak Ada" 
                                            onclick="handleCheckbox(this, ['banser_ada', 'banser_tidak', 'banser_rusak'])"
                                                   <?= (old('iv_serep', $inventorydetails[0]['iv_serep'] ?? '') == 'Tidak Ada') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="banser_tidak">Tidak Ada</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-6 checkbox-group">
                        <label class="control-label">Gantungan Ban Serep<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_gantungan" id="bangan_ada" value="Ada/Baik"
                                            onclick="handleCheckbox(this, ['bangan_ada', 'bangan_tidak', 'bangan_rusak'])"
                                                   <?= (old('iv_gantungan', $inventorydetails[0]['iv_gantungan'] ?? '') == 'Ada/Baik') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="bangan_ada">Ada/Baik</label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_gantungan" id="bangan_rusak" value="Ada/Rusak"
                                            onclick="handleCheckbox(this, ['bangan_rusak', 'bangan_tidak', 'bangan_ada'])"
                                                   <?= (old('iv_gantungan', $inventorydetails[0]['iv_gantungan'] ?? '') == 'Ada/Rusak') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="bangan_rusak">Ada/Rusak</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_gantungan" id="bangan_tidak" value="Tidak Ada" 
                                            onclick="handleCheckbox(this, ['bangan_ada', 'bangan_tidak', 'bangan_rusak'])"
                                                   <?= (old('iv_gantungan', $inventorydetails[0]['iv_gantungan'] ?? '') == 'Tidak Ada') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="bangan_tidak">Tidak Ada</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3 mt-3 checkbox-group">
                        <label class="control-label">Ram (Kanan Kiri)<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_ramkk" id="ramkk_ada" value="Ada/Baik"
                                            onclick="handleCheckbox(this, ['ramkk_ada', 'ramkk_tidak', 'ramkk_rusak'])"
                                                   <?= (old('iv_ramkk', $inventorydetails[0]['iv_ramkk'] ?? '') == 'Ada/Baik') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="ramkk_ada">Ada/Baik</label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_ramkk" id="ramkk_rusak" value="Ada/Rusak"
                                            onclick="handleCheckbox(this, ['ramkk_ada', 'ramkk_tidak', 'ramkk_rusak'])"
                                                   <?= (old('iv_ramkk', $inventorydetails[0]['iv_ramkk'] ?? '') == 'Ada/Rusak') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="ramkk_rusak">Ada/Rusak</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_ramkk" id="ramkk_tidak" value="Tidak Ada" 
                                            onclick="handleCheckbox(this, ['ramkk_ada', 'ramkk_tidak', 'ramkk_rusak'])"
                                                   <?= (old('iv_ramkk', $inventorydetails[0]['iv_ramkk'] ?? '') == 'Tidak Ada') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="ramkk_tidak">Tidak Ada/Kurang</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3 mt-3 checkbox-group">
                        <label class="control-label">Ram (Depang Belakang)<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_ramdb" id="ramdb_ada" value="Ada/Baik"
                                            onclick="handleCheckbox(this, ['ramdb_ada', 'ramdb_tidak', 'ramdb_rusak'])"
                                                   <?= (old('iv_ramdb', $inventorydetails[0]['iv_ramdb'] ?? '') == 'Ada/Baik') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="ramdb_ada">Ada/Baik</label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_ramdb" id="ramdb_rusak" value="Ada/Rusak"
                                            onclick="handleCheckbox(this, ['ramdb_ada', 'ramdb_tidak', 'ramdb_rusak'])"
                                                   <?= (old('iv_ramdb', $inventorydetails[0]['iv_ramdb'] ?? '') == 'Ada/Rusak') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="ramdb_rusak">Ada/Rusak</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_ramdb" id="ramdb_tidak" value="Tidak Ada/Kurang" 
                                            onclick="handleCheckbox(this, ['ramdb_ada', 'ramdb_tidak', 'ramdb_rusak'])"
                                                   <?= (old('iv_ramdb', $inventorydetails[0]['iv_ramdb'] ?? '') == 'Tidak Ada/Kurang') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="ramdb_tidak">Tidak Ada/Kurang</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3 mt-3 checkbox-group">
                        <label class="control-label">Karpet Depan (R/L)<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_karpetd" id="karpetd_ada" value="Ada/Baik"
                                            onclick="handleCheckbox(this, ['karpetd_ada', 'karpetd_tidak', 'karpetd_rusak'])"
                                                   <?= (old('iv_karpetd', $inventorydetails[0]['iv_karpetd'] ?? '') == 'Ada/Baik') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="karpetd_ada">Ada/Baik</label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_karpetd" id="karpetd_rusak" value="Ada/Rusak"
                                            onclick="handleCheckbox(this, ['karpetd_ada', 'karpetd_tidak', 'karpetd_rusak'])"
                                                   <?= (old('iv_karpetd', $inventorydetails[0]['iv_karpetd'] ?? '') == 'Ada/Rusak') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="karpetd_rusak">Ada/Rusak</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_karpetd" id="karpetd_tidak" value="Tidak Ada/Kurang" 
                                            onclick="handleCheckbox(this, ['karpetd_ada', 'karpetd_tidak', 'karpetd_rusak'])"
                                                   <?= (old('iv_karpetd', $inventorydetails[0]['iv_karpetd'] ?? '') == 'Tidak Ada/Kurang') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="karpetd_tidak">Tidak Ada/Kurang</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3 mt-3 checkbox-group">
                        <label class="control-label">Karpet Belakang (R/L)<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_karpetb" id="karpetb_ada" value="Ada/Baik"
                                            onclick="handleCheckbox(this, ['karpetb_ada', 'karpetb_tidak', 'karpetb_rusak'])"
                                                   <?= (old('iv_karpetb', $inventorydetails[0]['iv_karpetb'] ?? '') == 'Ada/Baik') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="karpetb_ada">Ada/Baik</label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_karpetb" id="karpetb_rusak" value="Ada/Rusak"
                                            onclick="handleCheckbox(this, ['karpetb_ada', 'karpetb_tidak', 'karpetb_rusak'])"
                                                   <?= (old('iv_karpetb', $inventorydetails[0]['iv_karpetb'] ?? '') == 'Ada/Rusak') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="karpetb_rusak">Ada/Rusak</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_karpetb" id="karpetb_tidak" value="Tidak Ada/Kurang" 
                                            onclick="handleCheckbox(this, ['karpetb_ada', 'karpetb_tidak', 'karpetb_rusak'])"
                                                   <?= (old('iv_karpetb', $inventorydetails[0]['iv_karpetb'] ?? '') == 'Tidak Ada/Kurang') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="karpetb_tidak">Tidak Ada/Kurang</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3 checkbox-group">
                        <label class="control-label">Tali Tambang (3 Gulung)<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_tambang" id="tambang_ada" value="Ada/Baik"
                                            onclick="handleCheckbox(this, ['tambang_ada', 'tambang_tidak', 'tambang_rusak'])"
                                                   <?= (old('iv_tambang', $inventorydetails[0]['iv_tambang'] ?? '') == 'Ada/Baik') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="tambang_ada">Ada/Baik</label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_tambang" id="tambang_rusak" value="Ada/Rusak"
                                            onclick="handleCheckbox(this, ['tambang_ada', 'tambang_tidak', 'tambang_rusak'])"
                                                   <?= (old('iv_tambang', $inventorydetails[0]['iv_tambang'] ?? '') == 'Ada/Rusak') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="tambang_rusak">Ada/Rusak</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_tambang" id="tambang_tidak" value="Tidak Ada/Kurang" 
                                            onclick="handleCheckbox(this, ['tambang_ada', 'tambang_tidak', 'tambang_rusak'])"
                                                   <?= (old('iv_tambang', $inventorydetails[0]['iv_tambang'] ?? '') == 'Tidak Ada/Kurang') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="tambang_tidak">Tidak Ada/Kurang</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3 checkbox-group">
                        <label class="control-label">Terpal Tarpolin (1 lembar)<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_tarpolin" id="tarpolin_ada" value="Ada/Baik"
                                            onclick="handleCheckbox(this, ['tarpolin_ada', 'tarpolin_tidak', 'tarpolin_rusak'])"
                                                   <?= (old('iv_tarpolin', $inventorydetails[0]['iv_tarpolin'] ?? '') == 'Ada/Baik') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="tarpolin_ada">Ada/Baik</label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_tarpolin" id="tarpolin_rusak" value="Ada/Rusak"
                                            onclick="handleCheckbox(this, ['tarpolin_ada', 'tarpolin_tidak', 'tarpolin_rusak'])"
                                                   <?= (old('iv_tarpolin', $inventorydetails[0]['iv_tarpolin'] ?? '') == 'Ada/Rusak') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="tarpolin_rusak">Ada/Rusak</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_tarpolin" id="tarpolin_tidak" value="Tidak Ada" 
                                            onclick="handleCheckbox(this, ['tarpolin_ada', 'tarpolin_tidak', 'tarpolin_rusak'])"
                                                   <?= (old('iv_tarpolin', $inventorydetails[0]['iv_tarpolin'] ?? '') == 'Tidak Ada') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="tarpolin_tidak">Tidak Ada</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3 checkbox-group">
                        <label class="control-label">Terpal Plastik (1 lembar)<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_plastik" id="plastik_ada" value="Ada/Baik"
                                            onclick="handleCheckbox(this, ['plastik_ada', 'plastik_tidak', 'plastik_rusak'])"
                                                   <?= (old('iv_plastik', $inventorydetails[0]['iv_plastik'] ?? '') == 'Ada/Baik') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="plastik_ada">Ada/Baik</label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_plastik" id="plastik_rusak" value="Ada/Rusak"
                                            onclick="handleCheckbox(this, ['plastik_ada', 'plastik_tidak', 'plastik_rusak'])"
                                                   <?= (old('iv_plastik', $inventorydetails[0]['iv_plastik'] ?? '') == 'Ada/Rusak') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="plastik_rusak">Ada/Rusak</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_plastik" id="plastik_tidak" value="Tidak Ada" 
                                            onclick="handleCheckbox(this, ['plastik_ada', 'plastik_tidak', 'plastik_rusak'])"
                                                   <?= (old('iv_plastik', $inventorydetails[0]['iv_plastik'] ?? '') == 'Tidak Ada') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="plastik_tidak">Tidak Ada</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3 checkbox-group">
                        <label class="control-label">Terpal Lidah (2 lembar)<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_lidah" id="lidah_ada" value="Ada/Baik"
                                            onclick="handleCheckbox(this, ['lidah_ada', 'lidah_tidak', 'lidah_rusak'])"
                                                   <?= (old('iv_lidah', $inventorydetails[0]['iv_lidah'] ?? '') == 'Ada/Baik') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="lidah_ada">Ada/Baik</label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_lidah" id="lidah_rusak" value="Ada/Rusak"
                                            onclick="handleCheckbox(this, ['lidah_ada', 'lidah_tidak', 'lidah_rusak'])"
                                                   <?= (old('iv_lidah', $inventorydetails[0]['iv_lidah'] ?? '') == 'Ada/Rusak') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="lidah_rusak">Ada/Rusak</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_lidah" id="lidah_tidak" value="Tidak Ada" 
                                            onclick="handleCheckbox(this, ['lidah_ada', 'lidah_tidak', 'lidah_rusak'])"
                                                   <?= (old('iv_lidah', $inventorydetails[0]['iv_lidah'] ?? '') == 'Tidak Ada') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="lidah_tidak">Tidak Ada</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3 checkbox-group">
                        <label class="control-label">Badong<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_badong" id="badong_ada" value="Ada/Baik"
                                            onclick="handleCheckbox(this, ['badong_ada', 'badong_tidak', 'badong_rusak'])"
                                                   <?= (old('iv_badong', $inventorydetails[0]['iv_badong'] ?? '') == 'Ada/Baik') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="badong_ada">Ada/Baik</label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_badong" id="badong_rusak" value="Ada/Rusak"
                                            onclick="handleCheckbox(this, ['badong_ada', 'badong_tidak', 'badong_rusak'])"
                                                   <?= (old('iv_badong', $inventorydetails[0]['iv_badong'] ?? '') == 'Ada/Rusak') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="badong_rusak">Ada/Rusak</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_badong" id="badong_tidak" value="Tidak Ada" 
                                            onclick="handleCheckbox(this, ['badong_ada', 'badong_tidak', 'badong_rusak'])"
                                                   <?= (old('iv_badong', $inventorydetails[0]['iv_badong'] ?? '') == 'Tidak Ada') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="badong_tidak">Tidak Ada</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                         <div class="col-md-4 mb-3 checkbox-group">
                            <label class="control-label">Pipa Kojong<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                 <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_kojong" id="kojong_ada" value="Ada/Baik"
                                            onclick="handleCheckbox(this, ['kojong_ada', 'kojong_rusak', 'kojong_hilang'])"
                                                   <?= (old('iv_kojong', $inventorydetails[0]['iv_kojong'] ?? '') == 'Ada/Baik') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="kojong_ada">Ada/Baik</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="iv_kojong" id="kojong_rusak" value="Ada/Rusak" 
                                            onclick="handleCheckbox(this, ['kojong_ada', 'kojong_rusak', 'kojong_hilang'])"
                                                   <?= (old('iv_kojong', $inventorydetails[0]['iv_kojong'] ?? '') == 'Ada/Rusak') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="kojong_rusak">Ada/Rusak</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_kojong" id="kojong_hilang" value="Tidak Ada/Kurang" 
                                            onclick="handleCheckbox(this, ['kojong_ada', 'kojong_rusak', 'kojong_hilang'])"
                                                   <?= (old('iv_kojong', $inventorydetails[0]['iv_kojong'] ?? '') == 'Tidak Ada/Kurang') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="kojong_hilang">Tidak Ada/Kurang</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label class="form-label">Jumlah Pipa Kojong<span class="form-required" style="color: red;">*</span></label>
                                <textarea class="form-control" autocomplete="off" name="iv_jumlah"><?= old('iv_jumlah', $inventorydetails[0]['iv_jumlah'] ?? ($inventorydetails['iv_jumlah'] ?? '')) ?></textarea>
                            </div>
                        </div>
                    </div>
                    <?php if (isset($inventorydetails[0]['iv_is_active'])) : ?>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label for="iv_is_active" class="form-label">Status Inventory<span class="form-required" style="color: red;">*</span></label>
                                <select id="iv_is_active" name="iv_is_active" class="form-control" required>
                                    <option value="">Select Inventory Status</option> 
                                    <option <?= (isset($inventorydetails) && $inventorydetails[0]['iv_is_active'] == 1) ? 'selected' : '' ?> value="1">Sudah Pengecekan</option> 
                                    <option <?= (isset($inventorydetails) && $inventorydetails[0]['iv_is_active'] == 0) ? 'selected' : '' ?> value="0">Belum Pengecekan</option> 
                                </select>
                            </div>
                        </div>
                    <?php endif; ?>
                    </div>
                    
                    <div class="col-sm-6 col-md-12">
                        <div class="form-group">
                            <label class="form-label">Keterangan</label>
                            <textarea class="form-control" autocomplete="off" placeholder="Catatan" name="iv_keterangan"><?= old('iv_keterangan', $inventorydetails[0]['iv_keterangan'] ?? ($inventorydetails['iv_keterangan'] ?? '')) ?></textarea>
                        </div>
                    </div>

                    <?php if (isset($inventorydetails)) : ?>
                        <div class="border p-3 rounded">
                            <div class="form-group">
                                <div class="text-center">
                                    <label>Foto Sebelumnya</label>
                                </div>
                                <br>
                                <div class="row">
                                    <!-- Display Photo Front -->
                                    <div class="col-md-3 text-center">
                                        <label>Depan</label>
                                        <?php
                                                $foto_dpn = isset($inventorydetails[0]['foto_dpn']) ? $inventorydetails[0]['foto_dpn'] : '';
                                                $foto_dpn_path = !empty($foto_dpn) ? 'assets/uploads/vehicle_invent/' . $foto_dpn : 'assets/uploads/user.png';
                                                if (!empty($foto_dpn) && file_exists($foto_dpn_path)) {
                                                    $foto_dpn_url = base_url($foto_dpn_path) . '?' . time();
                                                } else {
                                                    $foto_dpn_url = base_url('assets/uploads/user.png');
                                                }
                                                echo '<img src="' . $foto_dpn_url . '" class="img-fluid img-thumbnail" id="front_previous" data-foto="' . $foto_dpn . '" style="width: 100%; height: 150px;">';
                                            ?>
                                    </div>

                                    <!-- Display Photo Left -->
                                    <div class="col-md-3 text-center">
                                        <label>Kiri</label>
                                        <?php
                                                $foto_kiri = isset($inventorydetails[0]['foto_kiri']) ? $inventorydetails[0]['foto_kiri'] : '';
                                                $foto_kiri_path = !empty($foto_kiri) ? 'assets/uploads/vehicle_invent/' . $foto_kiri : 'assets/uploads/user.png';
                                                if (!empty($foto_kiri) && file_exists($foto_kiri_path)) {
                                                    $foto_kiri_url = base_url($foto_kiri_path) . '?' . time();
                                                } else {
                                                    $foto_kiri_url = base_url('assets/uploads/user.png');
                                                }
                                                echo '<img src="' . $foto_kiri_url . '" class="img-fluid img-thumbnail" id="left_previous" data-foto="' . $foto_kiri . '" style="width: 100%; height: 150px;">';
                                            ?>
                                    </div>

                                    <!-- Display Photo Right -->
                                    <div class="col-md-3 text-center">
                                        <label>Kanan</label>
                                        <?php
                                                $foto_kanan = isset($inventorydetails[0]['foto_kanan']) ? $inventorydetails[0]['foto_kanan'] : '';
                                                $foto_kanan_path = !empty($foto_kanan) ? 'assets/uploads/vehicle_invent/' . $foto_kanan : 'assets/uploads/user.png';
                                                if (!empty($foto_kanan) && file_exists($foto_kanan_path)) {
                                                    $foto_kanan_url = base_url($foto_kanan_path) . '?' . time();
                                                } else {
                                                    $foto_kanan_url = base_url('assets/uploads/user.png');
                                                }
                                                echo '<img src="' . $foto_kanan_url . '" class="img-fluid img-thumbnail" id="right_previous" data-foto="' . $foto_kanan . '" style="width: 100%; height: 150px;">';
                                            ?>
                                    </div>

                                    <!-- Display Photo Back -->
                                    <div class="col-md-3 text-center">
                                        <label>Belakang</label>
                                        <?php
                                                $foto_blk = isset($inventorydetails[0]['foto_blk']) ? $inventorydetails[0]['foto_blk'] : '';
                                                $foto_blk_path = !empty($foto_blk) ? 'assets/uploads/vehicle_invent/' . $foto_blk : 'assets/uploads/user.png';
                                                if (!empty($foto_blk) && file_exists($foto_blk_path)) {
                                                    $foto_blk_url = base_url($foto_blk_path) . '?' . time();
                                                } else {
                                                    $foto_blk_url = base_url('assets/uploads/user.png');
                                                }
                                                echo '<img src="' . $foto_blk_url . '" class="img-fluid img-thumbnail" id="back_previous" data-foto="' . $foto_blk . '" style="width: 100%; height: 150px;">';
                                            ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <hr style="border: 0; height: 1px; background-color: black;">

                    <div class="form-group">
                        <div class="text-center">
                        <label>Tambah Foto Mobil (4 sisi)</label>
                            <div class="text-center">
                            <button id="global_switch_camera" class="btn btn-success" type="button">Switch Camera</button>
                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <!-- Front -->
                         <div class="col-md-3 text-center">
                            <button type="button" id="front_take_photo" class="btn btn-primary">Ambil Foto Depan</button>
                            <button type="button" id="front_retake_photo" class="btn btn-secondary" style="display:none;">Foto Ulang</button>
                            <canvas id="front_canvas" style="display:none;"></canvas>
                            <video id="front_video" style="width:100%;" autoplay></video>
                            <div>Preview Depan</div>
                            <img id="front_preview" style="width: 100%; height: 170px; margin-bottom: 30px;" /></img>
                        </div>

                        <!-- Left -->
                        <div class="col-md-3 text-center">
                            <button type="button" id="left_take_photo" class="btn btn-primary">Ambil Foto Kiri</button>
                            <button type="button" id="left_retake_photo" class="btn btn-secondary" style="display:none;">Foto Ulang</button>
                            <canvas id="left_canvas" style="display:none;"></canvas>
                            <video id="left_video" style="width:100%;" autoplay></video>
                            <div>Preview Kiri</div>
                            <img id="left_preview" style="width: 100%; height: 170px; margin-bottom: 30px;" /></img>
                        </div>

                        <!-- Right -->
                        <div class="col-md-3 text-center">
                            <button type="button" id="right_take_photo" class="btn btn-primary">Ambil Foto Kanan</button>
                            <button type="button" id="right_retake_photo" class="btn btn-secondary" style="display:none;">Foto Ulang</button>
                            <canvas id="right_canvas" style="display:none;"></canvas>
                            <video id="right_video" style="width:100%;" autoplay></video>
                            <div>Preview Kanan</div>
                            <img id="right_preview" style="width: 100%; height: 170px; margin-bottom: 30px;" /></img>
                        </div>

                        <!-- Back -->
                        <div class="col-md-3 text-center">
                            <button type="button" id="back_take_photo" class="btn btn-primary">Ambil Foto Belakang</button>
                            <button type="button" id="back_retake_photo" class="btn btn-secondary" style="display:none;">Foto Ulang</button>
                            <canvas id="back_canvas" style="display:none;"></canvas>
                            <video id="back_video" style="width:100%;" autoplay></video>
                            <div>Preview Belakang</div>
                            <img id="back_preview" style="width: 100%; height: 170px; margin-bottom: 30px;" /></img>
                        </div>
                    </div>
                </div>
                
                <input type="hidden" id="iv_modified_date" name="iv_modified_date" value="<?= date('Y-m-d H:i:s') ?>">
                
                <div class="mb-3 card-footer d-flex">
                    <a href="<?= base_url('inventory/inventory_management') ?>" class="btn btn-warning" onclick="return confirmCancel()">
                        <i class="fa fa-left"></i> CANCEL
                    </a>
                    <button type="submit" class="btn btn-primary ml-auto" id="submitBtn"><?= (isset($inventorydetails)) ? 'UPDATE' : 'SAVE' ?></button>
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

    $(document).ready(function() {
        let videoStreams = {};
        let facingMode = "environment"; // Default kamera belakang

    function stopStream(stream) {
        if (stream) {
            let tracks = stream.getTracks();
            tracks.forEach((track) => track.stop());
        }
    }

    function startCamera(videoElement, side) {
        const constraints = {
            video: { facingMode: facingMode }
        };

        navigator.mediaDevices
            .getUserMedia(constraints)
            .then(function (stream) {
                videoStreams[side] = stream;
                videoElement.srcObject = stream;
                videoElement.play();
            })
            .catch(function (error) {
                console.error(`Tidak dapat mengakses kamera untuk ${side}:`, error);
            });
    }

    function initializeSide(side) {
        const videoElement = document.getElementById(`${side}_video`);
        const canvasElement = document.getElementById(`${side}_canvas`);

        // Mulai kamera dengan default (environment)
        startCamera(videoElement, side);

        // Tombol Take Photo
        $(`#${side}_take_photo`).click(function () {
            const context = canvasElement.getContext("2d");
            context.drawImage(videoElement, 0, 0, canvasElement.width, canvasElement.height);
            const photoData = canvasElement.toDataURL("image/png");

            $(`#${side}_preview`).attr("src", photoData);
            $(`#${side}_retake_photo`).show();
            $(`#${side}_take_photo`).hide();
            $(`#${side}_take_photo`).data("photoData", photoData);
            $(`#${side}_photo_data`).val(photoData);
        });

        // Tombol Retake Photo
        $(`#${side}_retake_photo`).click(function () {
            $(`#${side}_take_photo`).show();
            $(`#${side}_retake_photo`).hide();

            // Reset preview
            $(`#${side}_preview`).attr("src", "");
            $(`#${side}_take_photo`).data("photoData", null);
            $(`#${side}_photo_data`).val('');

            startCamera(videoElement, side); // Restart kamera setelah retake
        });
    }

    const sides = ['front', 'left', 'right', 'back'];
        sides.forEach(side => {
            $('<input>').attr({
                type: 'hidden',
                id: `${side}_photo_data`,
                name: `${side}_photo_data`
            }).appendTo('form');
        });

    ["front", "left", "right", "back"].forEach(initializeSide);

    // Tombol Global untuk Switch Camera
    $("#global_switch_camera").click(function () {
        facingMode = facingMode === "environment" ? "user" : "environment";

        const videoElements = {
            front: document.getElementById("front_video"),
            left: document.getElementById("left_video"),
            right: document.getElementById("right_video"),
            back: document.getElementById("back_video")
        };

        Object.keys(videoElements).forEach(function (side) {
            const videoElement = videoElements[side];
            stopStream(videoStreams[side]);

            setTimeout(function () {
                startCamera(videoElement, side);
            }, 100); // Jeda 100ms untuk mencegah black screen
        });
    });

        document.addEventListener('DOMContentLoaded', function () {

            function updateDateTime() {
                const now = new Date();
                const year = now.getFullYear();
                const month = String(now.getMonth() + 1).padStart(2, '0');
                const day = String(now.getDate()).padStart(2, '0');
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const seconds = String(now.getSeconds()).padStart(2, '0');
                
                document.getElementById('iv_modified_date').value = 
                    `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
            }

            setInterval(updateDateTime, 1000);
        });

        $('.select2-vehicle').on('change', function() {
            // Trigger validation
            $(this).valid();
            // Update fields terkait
            updateNOPOL();
        });

        // Event handler untuk checkbox change
        $('input[type="checkbox"]').on('change', function() {
            // Trigger validation untuk checkbox ini
            $(this).valid();
        });

        $('.select2-vehicle').select2({
                placeholder: "-- Pilih Mobil --",
                allowClear: true
            });
        });

        function confirmCancel() {
            return confirm("Apakah anda yakin ingin membatalkan proses ini?");
        }

        function handleCheckbox(clickedCheckbox, allIds) {
            allIds.forEach(id => {
                const checkbox = document.getElementById(id);
                if (checkbox !== clickedCheckbox) {
                    checkbox.checked = false;
                }
            });
            clickedCheckbox.checked = true;
        }

        function updateNOPOL() {
            const inventorySelect = document.getElementById('iv_nopol');
            const selectedOption = inventorySelect.options[inventorySelect.selectedIndex];
            const jenisMobil = selectedOption.getAttribute('data-jenis');
            const tahunMobil = selectedOption.getAttribute('data-tahun');
            document.getElementById('iv_jenis').value = jenisMobil || '';
            document.getElementById('iv_tahun').value = tahunMobil || '';
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
    .checkbox-group.is-invalid .border {
        border: 1px solid #dc3545 !important;
    }
    @keyframes highlight {
        0% { background-color: rgba(255, 255, 0, 0.3); }
        100% { background-color: transparent; }
    }
</style>