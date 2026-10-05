<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('drivers/drivers_inactive'); ?>">Inactive-Blacklist</a></li>
                    <li class="breadcrumb-item active"><?= (isset($driverdetails)) ? 'Edit blacklist' : 'Driver blacklist' ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <form method="post" id="add_driversblacklist" class="card <?= (isset($driverdetails)) ? 'updatedriverblacklist' : 'insertdriverblacklist' ?>" enctype="multipart/form-data" action="<?= base_url('drivers/' . ((isset($driverdetails)) ? 'updatedriverblacklist' : 'insertdriverblacklist')) ?>">
            <?= csrf_field() ?>
            <div class="card-body">
                <h3 class="text-center">Supir baru masuk daftar hitam</h3>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
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
                                <div class="col-sm-12">
                                    <label class="form-label">Nama Supir (Lengkap KTP)<span class="form-required" style="color: red;">*</span></label>
                                    <div class="form-group">
                                        <input type="text" name="d_name" id="d_name" class="form-control" placeholder="Nama Sesuai KTP" value="<?= isset($driverdetails) ? esc($driverdetails[0]['d_name']) : esc($old_input['d_name'] ?? '') ?>" oninput="this.value = capitalizeEachWord(this.value)">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <input type="hidden" name="d_id" id="d_id" value="<?= (isset($driverdetails)) ? esc($driverdetails[0]['d_id']) : '' ?>">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Tempat Lahir<span class="form-required" style="color: red;">*</span></label>
                                            <input type="text" id="d_pob" name="d_pob" class="form-control" placeholder="Tempat Lahir" value="<?= (isset($driverdetails)) ? esc($driverdetails[0]['d_pob']) : esc($old_input['d_pob'] ?? '') ?>" oninput="this.value = capitalizeEachWord(this.value)">
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
                                            <label class="form-label">Referensi</label>
                                            <input type="text" name="d_ref" class="form-control" value="<?= (isset($driverdetails)) ? esc($driverdetails[0]['d_ref']) : esc($old_input['d_ref'] ?? '') ?>" oninput="this.value = capitalizeEachWord(this.value)">
                                        </div>
                                    </div>
                                    <?php if (isset($driverdetails[0]['d_is_active']) && $driverdetails[0]['d_is_active'] == '0'): ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Tanggal Resign</label>
                                            <input type="text" name="d_resigndate" id="d_resigndate" value="<?= isset($driverdetails[0]['d_resigndate']) && $driverdetails[0]['d_resigndate'] !== '0000-00-00' ? date('d-m-Y', strtotime($driverdetails[0]['d_resigndate'])) : '' ?>" class="form-control datepicker" placeholder="Tanggal Resign">
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Alamat Tempat Tinggal<span class="form-required" style="color: red;">*</span></label>
                                            <textarea class="form-control" autocomplete="off" name="d_address" placeholder="Alamat Lengkap" oninput="this.value = capitalizeEachWord(this.value)"><?= (isset($driverdetails)) ? esc($driverdetails[0]['d_address']) : esc($old_input['d_address'] ?? '') ?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Kasus<span class="form-required" style="color: red;">*</span></label>
                                            <input type="text" name="d_notes_blacklist" class="form-control" value="<?= (isset($driverdetails)) ? esc($driverdetails[0]['d_notes_blacklist']) : esc($old_input['d_notes_blacklist'] ?? '') ?>" oninput="this.value = capitalizeEachWord(this.value)">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="d_is_active" class="form-label" style="color: red;">Driver Inactive/Blacklist Status*</label>
                                            <select id="d_is_active" name="d_is_active" class="form-control">
                                                <option value="">Select Driver Status</option> 
                                                <option value="1" <?= (isset($driverdetails) && $driverdetails[0]['d_is_active'] == 1) ? 'selected' : '' ?>>Active</option>
                                                <option value="0" <?= (isset($driverdetails) && $driverdetails[0]['d_is_active'] == 0) ? 'selected' : '' ?>>Inactive</option>
                                                <option value="2" <?= (isset($driverdetails) && $driverdetails[0]['d_is_active'] == 2) ? 'selected' : '' ?>>Blacklist</option>
                                            </select>
                                        </div>
                                    </div>
    
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Keterangan</label>
                                            <textarea class="form-control" autocomplete="off" placeholder="Alasan blacklist/kasus" name="d_notes"><?= (isset($driverdetails)) ? esc($driverdetails[0]['d_notes']) : esc($old_input['d_notes'] ?? '') ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <input type="hidden" id="d_modified_date" name="d_modified_date" value="<?= date('Y-m-d H:i:s'); ?>">

            <div class="card-footer d-flex">
                <a href="<?= base_url('drivers/drivers_inactive'); ?>" class="btn btn-warning" onclick="return confirmCancel()">
                    <i class="fa fa-left"></i> CANCEL
                </a>
                <button type="submit" class="btn btn-primary ml-auto" onclick="return confirmSave()"> 
                    <?= (isset($driverdetails)) ? 'UPDATE' : 'SAVE'; ?>
                </button>
            </div>
        </form>
    </div>
    <br>
</section>
<?= view('layout/footer') ?>

<?= $this->section('scripts'); ?>

<script src="<?= base_url('assets/autoLogout.js') ?>"></script>
<script>
    $(document).ready(function() {
        $('#d_photo').on('change', function(e) {
            var file = e.target.files[0];
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

        // Auto-fill tanggal resign dengan hari ini jika kosong saat diklik
        $('#d_resigndate').on('focus click', function() {
            if ($(this).val() === '') {
                var today = new Date();
                var yyyy = today.getFullYear();
                var mm = String(today.getMonth() + 1).padStart(2, '0');
                var dd = String(today.getDate()).padStart(2, '0');
                var formattedDate = yyyy + '/' + mm + '/' + dd;
                $(this).val(formattedDate);
                $(this).datepicker('update', formattedDate);
            }
        });
    });

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
    @keyframes highlight {
        0% { background-color: rgba(255, 255, 0, 0.3); }
        100% { background-color: transparent; }
    }
</style>