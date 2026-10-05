<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><?= (isset($loandetails)) ? 'Edit Loan' : 'Add Loan' ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('loans/loan_management') ?>">Loan</a></li>
                    <li class="breadcrumb-item active"><?= (isset($loandetails)) ? 'Edit Loan' : 'Add Loan' ?></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <form method="post" id="add_loan" class="card <?= (isset($loandetails)) ? 'updateloan' : 'insertloan' ?>" enctype="multipart/form-data" action="<?= base_url('drivers/' . ((isset($loandetails)) ? 'updateloan' : 'insertloan')) ?>">
            <!--<?= csrf_field() ?>-->
            <div class="card-body">
                <h3 class="text-center">Pengajuan Kasbon Supir</h3>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card" style="min-height: 300px;">
                            <div class="card-body">
                                <div class="row">
                                    <input type="hidden" name="l_id" id="l_id" value="<?= (isset($loandetails)) ? $loandetails[0]['l_id'] : '' ?>">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Nomor Hutang<span class="form-required"></span></label>
                                            <input type="text" id="l_code" class="form-control" name="l_code" value="<?= (isset($loandetails) && !empty($loandetails[0]['l_code'])) ? esc($loandetails[0]['l_code']) : esc($new_loan_code) ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Tanggal<span class="form-required" style="color: red;">*</span></label>
                                            <input type="text" name="l_tanggal" id="l_tanggal" value="<?= (isset($loandetails)) ? $loandetails[0]['l_tanggal'] : '' ?>" class="form-control datepicker">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">NIS<span class="form-required"></span></label>
                                            <input type="text" id="l_nis" class="form-control" name="l_nis" value="<?= isset($loandetails) ? $loandetails[0]['l_nis'] : '' ?>" placeholder="[auto]" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Jenis Hutang</label><span class="form-required" style="color: red;">*</span>
                                            <?php
                                            $is_edit_mode = isset($loandetails);
                                            $current_status = $is_edit_mode ? $loandetails[0]['l_is_status'] : '';
                                            $jenis_hutang_text = '';
                                            
                                            if ($current_status) {
                                                $jenis_hutang_text = in_array($current_status, ['1', '2', '3']) ? 'PRIBADI' : 
                                                    ($current_status == '4' ? 'SPAREPART' : '');
                                            }
                                            ?>
                                             <?php if ($is_edit_mode): ?>
                                            <input type="text" id="jenis_hutang_display" class="form-control" 
                                                   value="<?= $jenis_hutang_text ?>" 
                                                   readonly
                                                   style="background-color: #e9ecef; cursor: not-allowed;">
                                            <input type="hidden" id="l_is_status" name="l_is_status" 
                                                   value="<?= htmlspecialchars($current_status) ?>">
                                            <input type="hidden" id="original_l_is_status" 
                                                   value="<?= htmlspecialchars($current_status) ?>">
                   
                                            <?php else: ?>
                                                <select id="l_is_status" name="l_is_status" class="form-control" required>
                                                    <option value="">-- Pilih Hutang --</option>
                                                    <option value="2" <?= ($current_status == '2') ? 'selected' : '' ?>>PRIBADI</option>
                                                    <option value="4" <?= ($current_status == '4') ? 'selected' : '' ?>>SPAREPART</option>
                                                </select>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Nama Supir<span class="form-required" style="color: red;">*</span></label>
                                            <select id="l_supir" class="form-control form-control-sm select2 form-equal-height" name="l_supir" onchange="updateNIS()">
                                                <option value="">-- Pilih Supir --</option>
                                                <?php 
                                                usort($driverlist, function($a, $b) {
                                                    return strcmp($a['d_name'], $b['d_name']);
                                                });
                                                
                                                foreach ($driverlist as $driver) {
                                                    $selected = '';
                                                    if (isset($loandetails[0]['l_nis']) && $loandetails[0]['l_nis'] == $driver['d_nis'] && $driver['d_is_active'] == 1) {
                                                        $selected = 'selected';
                                                    }
                                                    if ($driver['d_is_active'] == 1) {
                                                        echo '<option value="' . htmlspecialchars($driver['d_name']) . '" data-nis="' . htmlspecialchars($driver['d_nis']) . '" ' . $selected . '>' . htmlspecialchars($driver['d_name']) . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Potong Tagihan</label><span class="form-required" style="color: red;">*</span>
                                            <select id="l_potong" name="l_potong" class="form-control">
                                                <option value="">-- Pilih Carpot --</option>
                                                <option <?= (isset($loandetails) && $loandetails[0]['l_potong'] == 'POT. SUJ 30%') ? 'selected' : '' ?> value="POT. SUJ 30%">POT. SUJ 30%</option>
                                                <option <?= (isset($loandetails) && $loandetails[0]['l_potong'] == 'POT. SUJ Langsung') ? 'selected' : '' ?> value="POT. SUJ Langsung">POT. SUJ Langsung</option>
                                                <option <?= (isset($loandetails) && $loandetails[0]['l_potong'] == 'POT. SUJ Bertahap') ? 'selected' : '' ?> value="POT. SUJ Bertahap">POT. SUJ Bertahap</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Mobil<span class="form-required" style="color: red;">*</span></label>
                                            <select id="l_nopol" class="form-control form-control-sm select2-vehicle form-equal-height" name="l_nopol">
                                                <option value="">-- Pilih Mobil --</option>
                                                <?php 
                                                foreach ($vechiclelist as $vehicle) {
                                                    $combinedValue = $vehicle['v_registration_no'] . ' - ' . $vehicle['v_name'];
                                                    $selected = '';
                                                    if (isset($loandetails[0]['l_nopol']) && $loandetails[0]['l_nopol'] == $combinedValue) {
                                                        $selected = 'selected';
                                                    }
                                                    echo '<option value="' . htmlspecialchars($combinedValue) . '" ' . $selected . '>'
                                                        . htmlspecialchars($vehicle['v_registration_no'] . ' - ' . $vehicle['v_name'])
                                                        . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">Nominal<span class="form-required" style="color: red;">*</span></label>
                                            <input type="text" name="l_nominal" value="<?= (isset($loandetails)) ? $loandetails[0]['l_nominal'] : '' ?>" class="form-control" id="realisasiKlaimInput">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Keterangan<span class="form-required" style="color: red;">*</span></label>
                                            <textarea class="form-control" name="l_keterangan" rows="3" oninput="this.value = capitalizeEachWord(this.value)"><?= (isset($loandetails)) ? $loandetails[0]['l_keterangan'] : '' ?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group" id="photo-section">
                                            <label class="form-label">Lampiran<span class="form-required" style="color: red;">*</span></label>

                                            <input type="file" name="l_lampiran" id="l_lampiran" class="form-control" accept="image/*,application/pdf">
                                            <input type="hidden" name="existing_document" value="<?= esc($loandetails[0]['l_lampiran'] ?? '') ?>">
                                            <?php $photo = !empty($loandetails[0]['l_lampiran']) ? $loandetails[0]['l_lampiran'] : 'Dokumen Lampiran.png'; $isPdf = strtolower(pathinfo($photo, PATHINFO_EXTENSION)) === 'pdf';?>
                                                <div id="document_preview_container">
                                                     <?php if (!empty($loandetails[0]['l_lampiran'])): ?>
                                                     <?php if ($isPdf): ?>
                                                        <a href="<?= base_url('assets/uploads/loan/' . esc($photo)) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-file-pdf"></i> Lihat Dokumen PDF
                                                        </a>
                                                    <?php else: ?>
                                                <img id="document_preview" src="<?= base_url('assets/uploads/loan/' . esc($photo)) ?>" 
                                                     alt="Preview Document Loan" 
                                                     style="margin-left: 3px; margin-top: 7px; max-width:300px; max-height:300px; object-fit:cover;" />
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                    <p class="text-muted">Tidak ada dokumen yang diunggah.</p>
                                                <?php endif; ?>
                                                </div>
                                            <div id="photo_error" class="text-danger" style="color: red; margin-left: 23px; display: none;">Harap unggah berkas lampiran</div>
                                            <div id="format_error" class="text-danger" style="color: red; display: none;">Hanya format JPG, JPEG, PNG, atau PDF yang diperbolehkan</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <input type="hidden" id="l_modified_date" name="l_modified_date" value="<?= date('Y-m-d H:i:s') ?>">

                <div class="card-footer d-flex">
                    <a href="<?= base_url('loans/loan_management') ?>" class="btn btn-warning" onclick="return confirmCancel()">
                        <i class="fa fa-left"></i> CANCEL
                    </a>
                    <button type="submit" class="btn btn-primary ml-auto" onclick="return confirmSave()"> 
                        <?= (isset($loandetails)) ? 'UPDATE' : 'SAVE' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
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
        const photoInput = document.getElementById('l_lampiran');
        const photoSection = document.getElementById('photo-section');
        const existingPhoto = document.querySelector('input[name="existing_document"]').value;
        const photoError = document.getElementById('photo_error');
        const formatError = document.getElementById('format_error');
        const allowedExtensions = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];

        form.addEventListener('submit', function(e) {
            photoError.style.display = 'none';
            formatError.style.display = 'none';

            if (photoInput.files.length > 0) {
                const file = photoInput.files[0];
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
    
    document.addEventListener('DOMContentLoaded', function() {
        const loanStatusSelect = document.getElementById('l_is_status');
        const resignDateContainer = document.getElementById('resign-date-container');
        const resignDateInput = document.getElementById('l_paid');
        const resignDateError = document.getElementById('resign-date-error');

        const toggleResignDate = () => {
            const loanStatus = loanStatusSelect.value;

            if (loanStatus === "1") {
                resignDateContainer.style.display = 'block';
                resignDateInput.setAttribute('required', 'required');
            } else {
                resignDateContainer.style.display = 'none';
                resignDateInput.removeAttribute('required');
                resignDateInput.value = '';
                resignDateError.style.display = 'none';
            }
        };
        
        const form = document.querySelector('form');
        form.addEventListener('submit', (event) => {
            if (loanStatusSelect.value === "0" && !resignDateInput.value) {
                event.preventDefault();
                resignDateError.style.display = 'block';
                resignDateInput.focus();
            }
        });
        
        loanStatusSelect.addEventListener('change', toggleResignDate);
        toggleResignDate();
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
        return confirm("Lanjutkan Proses Menyimpan Data?");
    }

    function confirmCancel() {
        return confirm("Apakah anda yakin ingin membatalkan proses ini?");
    }

    function updateNIS() {
        // Get the selected option from the dropdown
        const driverSelect = document.getElementById('l_supir');
        const selectedOption = driverSelect.options[driverSelect.selectedIndex];

        // Get the NIS from the selected option's data attribute
        const nis = selectedOption.getAttribute('data-nis');

        // Update the NIS input field
        document.getElementById('l_nis').value = nis || '';
    }

    $('#l_lampiran').change(function(e) {
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
                        'alt': 'Preview Document Loan',
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

    document.addEventListener('DOMContentLoaded', function() {
        const realisasiKlaimInput = document.getElementById('realisasiKlaimInput');
        
        // Fungsi untuk memformat angka dan menghapus karakter non-digit
        function formatNumberInput(input) {
            let value = input.value.replace(/[^0-9]/g, '');
            if(value) {
                value = parseInt(value).toLocaleString('id-ID');
            }
            input.value = value;
            return parseInt(value.replace(/[^0-9]/g, '') || 0);
        }
        
        // Fungsi untuk menentukan klasifikasi
        function setKlasifikasi() {
            const nominal = parseInt(realisasiKlaimInput.value.replace(/[^0-9]/g, '') || 0);
        }
        
        // Event listeners
        realisasiKlaimInput.addEventListener('input', function() {
            formatNumberInput(this);
            setKlasifikasi();
        });
    });

    function updateDateTime() {
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        
        document.getElementById('l_modified_date').value = 
            `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
    }

    // Update every second
    setInterval(updateDateTime, 1000);

    document.addEventListener('DOMContentLoaded', function() {
    const documentInput = document.getElementById('l_lampiran');
    
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
                    showNotification('Ukuran file lampiran melebihi batas maksimum 5MB. Silakan pilih file lain.');
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
</style>