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
                    <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="">Handover</a></li>
                    <li class="breadcrumb-item active"><?= (isset($inventorydetails)) ? 'Edit Inventory' : 'Add Inventory' ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <form method="post" id="inventory_add" class="card <?= (isset($inventorydetails)) ? 'updateinventory' : 'insertinventory' ?>" enctype="multipart/form-data" action="<?= base_url('handover/updateinventoryandproceed') ?>">
            <input type="hidden" name="nopol" value="<?= $nopol ?>">
            <input type="hidden" name="hand_id" value="<?= $hand_id ?>">
            <div class="card-body">
                <div class="row">
                    <input type="hidden" name="iv_id" id="iv_id" value="<?= (isset($inventorydetails)) ? esc($inventorydetails['iv_id']) : '' ?>">

                    <div class="col-md-12">
                        <label class="form-label">Nomor Inventaris</label>
                        <div class="form-group">
                            <input type="text" name="iv_code" id="iv_code" value="<?= (isset($inventorydetails) && !empty($inventorydetails['iv_code'])) ? esc($inventorydetails['iv_code']) : esc($last_inv_code) ?>" class="form-control"readonly>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-4">
                        <label class="form-label">Nomor Polisi<span class="form-required" style="color: red;">*</span></label>
                        <div class="form-group">
                            <input type="text" name="iv_nopol" id="iv_nopol" value="<?= isset($inventorydetails) && !empty($inventorydetails['iv_nopol']) ? esc($inventorydetails['iv_nopol']) : esc($nopol) ?>" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-4">
                        <label class="form-label">Jenis Mobil<span class="form-required" style="color: red;">*</span></label>
                        <div class="form-group">
                            <input type="text" name="iv_jenis" id="iv_jenis" value="<?= isset($inventorydetails) && !empty($inventorydetails['iv_jenis']) ? esc($inventorydetails['iv_jenis']) : esc($inventory['iv_jenis']) ?>" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-4">
                        <label class="form-label">Tahun<span class="form-required" style="color: red;">*</span></label>
                        <div class="form-group">
                            <input type="text" name="iv_tahun" id="iv_tahun" value="<?= isset($inventorydetails) ? esc($inventorydetails['iv_tahun']) : esc($inventory['iv_tahun']) ?>" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="control-label">STNK<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_stnk" id="stnk_ada" value="Ada"
                                            onclick="handleCheckbox(this, ['stnk_ada', 'stnk_tidak'])"
                                                   <?= (old('iv_stnk', $inventorydetails['iv_stnk'] ?? '') == 'Ada') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="stnk_ada">Ada</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_stnk" id="stnk_tidak" value="Tidak Ada" 
                                            onclick="handleCheckbox(this, ['stnk_ada', 'stnk_tidak'])"
                                                   <?= (old('iv_stnk', $inventorydetails['iv_stnk'] ?? '') == 'Tidak Ada') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="stnk_tidak">Tidak Ada</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                        <label class="control-label">Buku KIR<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_kir" id="kir_ada" value="Ada"
                                            onclick="handleCheckbox(this, ['kir_ada', 'kir_tidak'])"
                                                   <?= (old('iv_kir', $inventorydetails['iv_kir'] ?? '') == 'Ada') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="kir_ada">Ada</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_kir" id="kir_tidak" value="Tidak Ada" 
                                            onclick="handleCheckbox(this, ['kir_ada', 'kir_tidak'])"
                                                   <?= (old('iv_kir', $inventorydetails['iv_kir'] ?? '') == 'Tidak Ada') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="kir_tidak">Tidak Ada</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                        <label class="control-label">Tempat Tidur Kabin<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_kabin" id="kabin_ada" value="Ada"
                                            onclick="handleCheckbox(this, ['kabin_ada', 'kabin_tidak'])"
                                                   <?= (old('iv_kabin', $inventorydetails['iv_kabin'] ?? '') == 'Ada') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="kabin_ada">Ada</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_kabin" id="kabin_tidak" value="Tidak Ada" 
                                            onclick="handleCheckbox(this, ['kabin_ada', 'kabin_tidak'])"
                                                   <?= (old('iv_kabin', $inventorydetails['iv_kabin'] ?? '') == 'Tidak Ada') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="kabin_tidak">Tidak Ada</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="control-label">Dongkrak<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                 <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_dongkrak" id="dongkrak_baik" value="Ada/Baik"
                                            onclick="handleCheckbox(this, ['dongkrak_baik', 'dongkrak_rusak', 'dongkrak_tidak'])"
                                                   <?= (old('iv_dongkrak', $inventorydetails['iv_dongkrak'] ?? '') == 'Ada/Baik') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="dongkrak_baik">Ada/Baik</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="iv_dongkrak" id="dongkrak_rusak" value="Ada/Rusak" 
                                            onclick="handleCheckbox(this, ['dongkrak_baik', 'dongkrak_rusak', 'dongkrak_tidak'])"
                                                   <?= (old('iv_dongkrak', $inventorydetails['iv_dongkrak'] ?? '') == 'Ada/Rusak') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="dongkrak_rusak">Ada/Rusak</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_dongkrak" id="dongkrak_tidak" value="Tidak Ada" 
                                            onclick="handleCheckbox(this, ['dongkrak_baik', 'dongkrak_rusak', 'dongkrak_tidak'])"
                                                   <?= (old('iv_dongkrak', $inventorydetails['iv_dongkrak'] ?? '') == 'Tidak Ada') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="dongkrak_tidak">Tidak Ada</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="control-label">Kunci Roda<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                 <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_kunci" id="kuncirod_baik" value="Ada/Baik"
                                            onclick="handleCheckbox(this, ['kuncirod_baik', 'kuncirod_rusak', 'kuncirod_tidak'])"
                                                   <?= (old('iv_kunci', $inventorydetails['iv_kunci'] ?? '') == 'Ada/Baik') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="kuncirod_baik">Ada/Baik</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="iv_kunci" id="kuncirod_rusak" value="Ada/Rusak" 
                                            onclick="handleCheckbox(this, ['kuncirod_baik', 'kuncirod_rusak', 'kuncirod_tidak'])"
                                                   <?= (old('iv_kunci', $inventorydetails['iv_kunci'] ?? '') == 'Ada/Rusak') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="kuncirod_rusak">Ada/Rusak</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_kunci" id="kuncirod_tidak" value="Tidak Ada" 
                                            onclick="handleCheckbox(this, ['kuncirod_baik', 'kuncirod_rusak', 'kuncirod_tidak'])"
                                                   <?= (old('iv_kunci', $inventorydetails['iv_kunci'] ?? '') == 'Tidak Ada') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="kuncirod_tidak">Tidak Ada</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="control-label">Stang/Stick Kunci Roda<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                 <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_stang" id="stangrod_baik" value="Ada/Baik"
                                            onclick="handleCheckbox(this, ['stangrod_baik', 'stangrod_rusak', 'stangrod_tidak'])"
                                                   <?= (old('iv_stang', $inventorydetails['iv_stang'] ?? '') == 'Ada/Baik') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="stangrod_baik">Ada/Baik</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="iv_stang" id="stangrod_rusak" value="Ada/Rusak" 
                                            onclick="handleCheckbox(this, ['stangrod_baik', 'stangrod_rusak', 'stangrod_tidak'])"
                                                   <?= (old('iv_stang', $inventorydetails['iv_stang'] ?? '') == 'Ada/Rusak') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="stangrod_rusak">Ada/Rusak</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_stang" id="stangrod_tidak" value="Tidak Ada" 
                                            onclick="handleCheckbox(this, ['stangrod_baik', 'stangrod_rusak', 'stangrod_tidak'])"
                                                   <?= (old('iv_stang', $inventorydetails['iv_stang'] ?? '') == 'Tidak Ada') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="stangrod_tidak">Tidak Ada</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="control-label">Spanner<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                 <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_spanner" id="spanner_baik" value="Ada/Baik"
                                            onclick="handleCheckbox(this, ['spanner_baik', 'spanner_rusak', 'spanner_tidak'])"
                                                   <?= (old('iv_spanner', $inventorydetails['iv_spanner'] ?? '') == 'Ada/Baik') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="spanner_baik">Ada/Baik</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="iv_spanner" id="spanner_rusak" value="Ada/Rusak" 
                                            onclick="handleCheckbox(this, ['spanner_baik', 'spanner_rusak', 'spanner_tidak'])"
                                                   <?= (old('iv_spanner', $inventorydetails['iv_spanner'] ?? '') == 'Ada/Rusak') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="spanner_rusak">Ada/Rusak</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_spanner" id="spanner_tidak" value="Tidak Ada" 
                                            onclick="handleCheckbox(this, ['spanner_baik', 'spanner_rusak', 'spanner_tidak'])"
                                                   <?= (old('iv_spanner', $inventorydetails['iv_spanner'] ?? '') == 'Tidak Ada') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="spanner_tidak">Tidak Ada</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-6">
                        <label class="control-label">Ban Serep<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_serep" id="banser_ada" value="Ada/Baik"
                                            onclick="handleCheckbox(this, ['banser_ada', 'banser_tidak', 'banser_rusak'])"
                                                   <?= (old('iv_serep', $inventorydetails['iv_serep'] ?? '') == 'Ada/Baik') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="banser_ada">Ada/Baik</label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_serep" id="banser_rusak" value="Ada/Rusak"
                                            onclick="handleCheckbox(this, ['banser_rusak', 'banser_tidak', 'banser_ada'])"
                                                   <?= (old('iv_serep', $inventorydetails['iv_serep'] ?? '') == 'Ada/Rusak') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="banser_rusak">Ada/Rusak</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_serep" id="banser_tidak" value="Tidak Ada" 
                                            onclick="handleCheckbox(this, ['banser_ada', 'banser_tidak', 'banser_rusak'])"
                                                   <?= (old('iv_serep', $inventorydetails['iv_serep'] ?? '') == 'Tidak Ada') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="banser_tidak">Tidak Ada</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-6">
                        <label class="control-label">Gantungan Ban Serep<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_gantungan" id="bangan_ada" value="Ada/Baik"
                                            onclick="handleCheckbox(this, ['bangan_ada', 'bangan_tidak', 'bangan_rusak'])"
                                                   <?= (old('iv_gantungan', $inventorydetails['iv_gantungan'] ?? '') == 'Ada/Baik') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="bangan_ada">Ada/Baik</label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_gantungan" id="bangan_rusak" value="Ada/Rusak"
                                            onclick="handleCheckbox(this, ['bangan_rusak', 'bangan_tidak', 'bangan_ada'])"
                                                   <?= (old('iv_gantungan', $inventorydetails['iv_gantungan'] ?? '') == 'Ada/Rusak') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="bangan_rusak">Ada/Rusak</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_gantungan" id="bangan_tidak" value="Tidak Ada" 
                                            onclick="handleCheckbox(this, ['bangan_ada', 'bangan_tidak', 'bangan_rusak'])"
                                                   <?= (old('iv_gantungan', $inventorydetails['iv_gantungan'] ?? '') == 'Tidak Ada') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="bangan_tidak">Tidak Ada</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3 mt-3">
                        <label class="control-label">Ram (Kanan Kiri)<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_ramkk" id="ramkk_ada" value="Ada/Baik"
                                            onclick="handleCheckbox(this, ['ramkk_ada', 'ramkk_tidak', 'ramkk_rusak'])"
                                                   <?= (old('iv_ramkk', $inventorydetails['iv_ramkk'] ?? '') == 'Ada/Baik') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="ramkk_ada">Ada/Baik</label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_ramkk" id="ramkk_rusak" value="Ada/Rusak"
                                            onclick="handleCheckbox(this, ['ramkk_ada', 'ramkk_tidak', 'ramkk_rusak'])"
                                                   <?= (old('iv_ramkk', $inventorydetails['iv_ramkk'] ?? '') == 'Ada/Rusak') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="ramkk_rusak">Ada/Rusak</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_ramkk" id="ramkk_tidak" value="Tidak Ada" 
                                            onclick="handleCheckbox(this, ['ramkk_ada', 'ramkk_tidak', 'ramkk_rusak'])"
                                                   <?= (old('iv_ramkk', $inventorydetails['iv_ramkk'] ?? '') == 'Tidak Ada') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="ramkk_tidak">Tidak Ada/Kurang</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3 mt-3">
                        <label class="control-label">Ram (Depang Belakang)<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_ramdb" id="ramdb_ada" value="Ada/Baik"
                                            onclick="handleCheckbox(this, ['ramdb_ada', 'ramdb_tidak', 'ramdb_rusak'])"
                                                   <?= (old('iv_ramdb', $inventorydetails['iv_ramdb'] ?? '') == 'Ada/Baik') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="ramdb_ada">Ada/Baik</label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_ramdb" id="ramdb_rusak" value="Ada/Rusak"
                                            onclick="handleCheckbox(this, ['ramdb_ada', 'ramdb_tidak', 'ramdb_rusak'])"
                                                   <?= (old('iv_ramdb', $inventorydetails['iv_ramdb'] ?? '') == 'Ada/Rusak') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="ramdb_rusak">Ada/Rusak</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_ramdb" id="ramdb_tidak" value="Tidak Ada/Kurang" 
                                            onclick="handleCheckbox(this, ['ramdb_ada', 'ramdb_tidak', 'ramdb_rusak'])"
                                                   <?= (old('iv_ramdb', $inventorydetails['iv_ramdb'] ?? '') == 'Tidak Ada/Kurang') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="ramdb_tidak">Tidak Ada/Kurang</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3 mt-3">
                        <label class="control-label">Karpet Depan (R/L)<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_karpetd" id="karpetd_ada" value="Ada/Baik"
                                            onclick="handleCheckbox(this, ['karpetd_ada', 'karpetd_tidak', 'karpetd_rusak'])"
                                                   <?= (old('iv_karpetd', $inventorydetails['iv_karpetd'] ?? '') == 'Ada/Baik') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="karpetd_ada">Ada/Baik</label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_karpetd" id="karpetd_rusak" value="Ada/Rusak"
                                            onclick="handleCheckbox(this, ['karpetd_ada', 'karpetd_tidak', 'karpetd_rusak'])"
                                                   <?= (old('iv_karpetd', $inventorydetails['iv_karpetd'] ?? '') == 'Ada/Rusak') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="karpetd_rusak">Ada/Rusak</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_karpetd" id="karpetd_tidak" value="Tidak Ada/Kurang" 
                                            onclick="handleCheckbox(this, ['karpetd_ada', 'karpetd_tidak', 'karpetd_rusak'])"
                                                   <?= (old('iv_karpetd', $inventorydetails['iv_karpetd'] ?? '') == 'Tidak Ada/Kurang') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="karpetd_tidak">Tidak Ada/Kurang</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3 mt-3">
                        <label class="control-label">Karpet Belakang (R/L)<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_karpetb" id="karpetb_ada" value="Ada/Baik"
                                            onclick="handleCheckbox(this, ['karpetb_ada', 'karpetb_tidak', 'karpetb_rusak'])"
                                                   <?= (old('iv_karpetb', $inventorydetails['iv_karpetb'] ?? '') == 'Ada/Baik') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="karpetb_ada">Ada/Baik</label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_karpetb" id="karpetb_rusak" value="Ada/Rusak"
                                            onclick="handleCheckbox(this, ['karpetb_ada', 'karpetb_tidak', 'karpetb_rusak'])"
                                                   <?= (old('iv_karpetb', $inventorydetails['iv_karpetb'] ?? '') == 'Ada/Rusak') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="karpetb_rusak">Ada/Rusak</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_karpetb" id="karpetb_tidak" value="Tidak Ada/Kurang" 
                                            onclick="handleCheckbox(this, ['karpetb_ada', 'karpetb_tidak', 'karpetb_rusak'])"
                                                   <?= (old('iv_karpetb', $inventorydetails['iv_karpetb'] ?? '') == 'Tidak Ada/Kurang') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="karpetb_tidak">Tidak Ada/Kurang</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                        <label class="control-label">Tali Tambang (3 Gulung)<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_tambang" id="tambang_ada" value="Ada/Baik"
                                            onclick="handleCheckbox(this, ['tambang_ada', 'tambang_tidak', 'tambang_rusak'])"
                                                   <?= (old('iv_tambang', $inventorydetails['iv_tambang'] ?? '') == 'Ada/Baik') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="tambang_ada">Ada/Baik</label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_tambang" id="tambang_rusak" value="Ada/Rusak"
                                            onclick="handleCheckbox(this, ['tambang_ada', 'tambang_tidak', 'tambang_rusak'])"
                                                   <?= (old('iv_tambang', $inventorydetails['iv_tambang'] ?? '') == 'Ada/Rusak') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="tambang_rusak">Ada/Rusak</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_tambang" id="tambang_tidak" value="Tidak Ada/Kurang" 
                                            onclick="handleCheckbox(this, ['tambang_ada', 'tambang_tidak', 'tambang_rusak'])"
                                                   <?= (old('iv_tambang', $inventorydetails['iv_tambang'] ?? '') == 'Tidak Ada/Kurang') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="tambang_tidak">Tidak Ada/Kurang</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                        <label class="control-label">Terpal Tarpolin (1 lembar)<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_tarpolin" id="tarpolin_ada" value="Ada/Baik"
                                            onclick="handleCheckbox(this, ['tarpolin_ada', 'tarpolin_tidak', 'tarpolin_rusak'])"
                                                   <?= (old('iv_tarpolin', $inventorydetails['iv_tarpolin'] ?? '') == 'Ada/Baik') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="tarpolin_ada">Ada/Baik</label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_tarpolin" id="tarpolin_rusak" value="Ada/Rusak"
                                            onclick="handleCheckbox(this, ['tarpolin_ada', 'tarpolin_tidak', 'tarpolin_rusak'])"
                                                   <?= (old('iv_tarpolin', $inventorydetails['iv_tarpolin'] ?? '') == 'Ada/Rusak') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="tarpolin_rusak">Ada/Rusak</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_tarpolin" id="tarpolin_tidak" value="Tidak Ada" 
                                            onclick="handleCheckbox(this, ['tarpolin_ada', 'tarpolin_tidak', 'tarpolin_rusak'])"
                                                   <?= (old('iv_tarpolin', $inventorydetails['iv_tarpolin'] ?? '') == 'Tidak Ada') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="tarpolin_tidak">Tidak Ada</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                        <label class="control-label">Terpal Plastik (1 lembar)<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_plastik" id="plastik_ada" value="Ada/Baik"
                                            onclick="handleCheckbox(this, ['plastik_ada', 'plastik_tidak', 'plastik_rusak'])"
                                                   <?= (old('iv_plastik', $inventorydetails['iv_plastik'] ?? '') == 'Ada/Baik') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="plastik_ada">Ada/Baik</label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_plastik" id="plastik_rusak" value="Ada/Rusak"
                                            onclick="handleCheckbox(this, ['plastik_ada', 'plastik_tidak', 'plastik_rusak'])"
                                                   <?= (old('iv_plastik', $inventorydetails['iv_plastik'] ?? '') == 'Ada/Rusak') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="plastik_rusak">Ada/Rusak</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_plastik" id="plastik_tidak" value="Tidak Ada" 
                                            onclick="handleCheckbox(this, ['plastik_ada', 'plastik_tidak', 'plastik_rusak'])"
                                                   <?= (old('iv_plastik', $inventorydetails['iv_plastik'] ?? '') == 'Tidak Ada') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="plastik_tidak">Tidak Ada</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                        <label class="control-label">Terpal Lidah (2 lembar)<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_lidah" id="lidah_ada" value="Ada/Baik"
                                            onclick="handleCheckbox(this, ['lidah_ada', 'lidah_tidak', 'lidah_rusak'])"
                                                   <?= (old('iv_lidah', $inventorydetails['iv_lidah'] ?? '') == 'Ada/Baik') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="lidah_ada">Ada/Baik</label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_lidah" id="lidah_rusak" value="Ada/Rusak"
                                            onclick="handleCheckbox(this, ['lidah_ada', 'lidah_tidak', 'lidah_rusak'])"
                                                   <?= (old('iv_lidah', $inventorydetails['iv_lidah'] ?? '') == 'Ada/Rusak') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="lidah_rusak">Ada/Rusak</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_lidah" id="lidah_tidak" value="Tidak Ada" 
                                            onclick="handleCheckbox(this, ['lidah_ada', 'lidah_tidak', 'lidah_rusak'])"
                                                   <?= (old('iv_lidah', $inventorydetails['iv_lidah'] ?? '') == 'Tidak Ada') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="lidah_tidak">Tidak Ada</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                        <label class="control-label">Badong<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_badong" id="badong_ada" value="Ada/Baik"
                                            onclick="handleCheckbox(this, ['badong_ada', 'badong_tidak', 'badong_rusak'])"
                                                   <?= (old('iv_badong', $inventorydetails['iv_badong'] ?? '') == 'Ada/Baik') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="badong_ada">Ada/Baik</label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_badong" id="badong_rusak" value="Ada/Rusak"
                                            onclick="handleCheckbox(this, ['badong_ada', 'badong_tidak', 'badong_rusak'])"
                                                   <?= (old('iv_badong', $inventorydetails['iv_badong'] ?? '') == 'Ada/Rusak') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="badong_rusak">Ada/Rusak</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_badong" id="badong_tidak" value="Tidak Ada" 
                                            onclick="handleCheckbox(this, ['badong_ada', 'badong_tidak', 'badong_rusak'])"
                                                   <?= (old('iv_badong', $inventorydetails['iv_badong'] ?? '') == 'Tidak Ada') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="badong_tidak">Tidak Ada</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                         <div class="col-md-4 mb-3">
                            <label class="control-label">Pipa Kojong<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                 <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_kojong" id="kojong_ada" value="Ada/Baik"
                                            onclick="handleCheckbox(this, ['kojong_ada', 'kojong_rusak', 'kojong_hilang'])"
                                                   <?= (old('iv_kojong', $inventorydetails['iv_kojong'] ?? '') == 'Ada/Baik') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="kojong_ada">Ada/Baik</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="iv_kojong" id="kojong_rusak" value="Ada/Rusak" 
                                            onclick="handleCheckbox(this, ['kojong_ada', 'kojong_rusak', 'kojong_hilang'])"
                                                   <?= (old('iv_kojong', $inventorydetails['iv_kojong'] ?? '') == 'Ada/Rusak') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="kojong_rusak">Ada/Rusak</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="iv_kojong" id="kojong_hilang" value="Tidak Ada/Kurang" 
                                            onclick="handleCheckbox(this, ['kojong_ada', 'kojong_rusak', 'kojong_hilang'])"
                                                   <?= (old('iv_kojong', $inventorydetails['iv_kojong'] ?? '') == 'Tidak Ada/Kurang') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="kojong_hilang">Tidak Ada/Kurang</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label class="form-label">Jumlah Pipa Kojong</label>
                                <textarea class="form-control" autocomplete="off" name="iv_jumlah"><?= old('iv_jumlah', $inventorydetails['iv_jumlah'] ?? ($inventorydetails['iv_jumlah'] ?? '')) ?></textarea>
                            </div>
                        </div>
                    </div>
                    <?php if(isset($inventorydetails['iv_is_active'])) : ?>
                        <div class="col-md-4 mb-3">
                            <label for="iv_is_active" class="form-label"><span  class="form-required" style="color: red;">*</span> Status Inventory </label>
                            <div class="form-group">
                                <span name="iv_is_active" id="iv_is_active" style="font-size: 18px;"><?= isset($inventorydetails) && !empty($inventorydetails['iv_is_active'] == 1) ? '<span class="right badge badge-success">Sudah Pengecekan</span>' : '<span class="right badge badge-danger">Belum Pengecekan</span>' ?></span>
                            </div>
                        </div>
                    <?php endif; ?>
                    </div>
                    
                    <div class="col-sm-6 col-md-12">
                        <div class="form-group">
                            <label class="form-label">Keterangan</label>
                            <textarea class="form-control" autocomplete="off" placeholder="Catatan" name="iv_keterangan"><?= old('iv_keterangan', $inventorydetails['iv_keterangan'] ?? ($inventorydetails['iv_keterangan'] ?? '')) ?></textarea>
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
                                                $foto_dpn = isset($inventorydetails['foto_dpn']) ? $inventorydetails['foto_dpn'] : '';
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
                                                $foto_kiri = isset($inventorydetails['foto_kiri']) ? $inventorydetails['foto_kiri'] : '';
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
                                                $foto_kanan = isset($inventorydetails['foto_kanan']) ? $inventorydetails['foto_kanan'] : '';
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
                                                $foto_blk = isset($inventorydetails['foto_blk']) ? $inventorydetails['foto_blk'] : '';
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
                    <button type="submit" class="btn btn-primary ml-auto" id="submitBtn"><?= (isset($inventorydetails)) ? 'UPDATE / NEXT' : 'SAVE' ?></button>
                </div>
            </div>
        </form>
    </div>
</section>
<?= view('layout/footer') ?>

<script>
    $(document).ready(function() {
        let videoStreams = {};
        let facingMode = "environment";

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

        startCamera(videoElement, side);

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

        $(`#${side}_retake_photo`).click(function () {
            $(`#${side}_take_photo`).show();
            $(`#${side}_retake_photo`).hide();

            // Reset preview
            $(`#${side}_preview`).attr("src", "");
            $(`#${side}_take_photo`).data("photoData", null);
            $(`#${side}_photo_data`).val('');

            startCamera(videoElement, side);
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
            }, 100);
        });
    });

    function validateAndSubmit() {
            var existingFrontPhoto = $('#front_previous').attr('data-foto') || "";
            var existingLeftPhoto = $('#left_previous').attr('data-foto') || "";
            var existingRightPhoto = $('#right_previous').attr('data-foto') || "";
            var existingBackPhoto = $('#back_previous').attr('data-foto') || "";

            var hasNewFrontPhoto = $('#front_take_photo').data('photoData') || $('#front_preview').attr('src');
            var hasNewLeftPhoto = $('#left_take_photo').data('photoData') || $('#left_preview').attr('src');
            var hasNewRightPhoto = $('#right_take_photo').data('photoData') || $('#right_preview').attr('src');
            var hasNewBackPhoto = $('#back_take_photo').data('photoData') || $('#back_preview').attr('src');

            if (!hasNewFrontPhoto && !existingFrontPhoto) {
                alert_toast("Harap ambil foto kendaraan sisi depan", 'error');
                return false;
            }

            if (!hasNewLeftPhoto && !existingLeftPhoto) {
                alert_toast("Harap ambil foto kendaraan sisi kiri", 'error');
                return false;
            }

            if (!hasNewRightPhoto && !existingRightPhoto) {
                alert_toast("Harap ambil foto kendaraan sisi kanan", 'error');
                return false;
            }

            if (!hasNewBackPhoto && !existingBackPhoto) {
                alert_toast("Harap ambil foto kendaraan sisi belakang", 'error');
                return false;
            }

            if (!confirm("Lanjutkan Proses Menyimpan Data?")) {
                return false;
            }

            $('#submitBtn').prop('disabled', true)
                          .html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');

            return true;
        }

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

    @keyframes highlight {
        0% { background-color: rgba(255, 255, 0, 0.3); }
        100% { background-color: transparent; }
    }
</style>