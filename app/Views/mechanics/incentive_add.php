<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><?= (isset($incentivedetails)) ? 'Edit Incentive' : 'Add Incentive' ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('vehicles/vehicles_management') ?>">Vehicle</a></li>
                    <li class="breadcrumb-item active"><?= (isset($vehicledetails)) ? 'Edit Vehicle' : 'Add Vehicle' ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <form method="post" id="vehicle_add" class="card <?= (isset($driverdetails)) ? 'updatevehicle' : 'insertvehicle' ?>" enctype="multipart/form-data" action="<?= base_url('vehicles/' . ((isset($vehicledetails)) ? 'updatevehicle' : 'insertvehicle')) ?>">
            <?= csrf_field() ?>
            <div class="card-body">
                <div class="row">
                    <input type="hidden" name="v_id" id="v_id" value="<?= (isset($vehicledetails)) ? esc($vehicledetails[0]['v_id']) : '' ?>">

                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label for="v_legal" class="form-label">Pemilik<span class="form-required" style="color: red;">*</span></label>
                            <select id="v_legal" name="v_legal" class="form-control" required>
                                <option value="">--Pilih Pemilik--</option> 
                                <?php if (!empty($v_owner)) : ?>
                                    <?php foreach ($v_owner as $v_ownerdata) : ?>
                                        <?php $selected = old('v_legal', $vehicledetails[0]['v_legal'] ?? ($vehicledetails['v_legal'] ?? '')) == $v_ownerdata['ow_name'];?>
                                        <option <?= $selected ? 'selected' : '' ?> value="<?= esc($v_ownerdata['ow_name']) ?>">
                                            <?= esc($v_ownerdata['ow_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-4">
                        <label class="form-label">Nomor Polisi<span class="form-required" style="color: red;">*</span></label>
                        <div class="form-group">
                            <input type="text" name="v_registration_no" id="v_registration_no" value="<?= old('v_registration_no', $vehicledetails[0]['v_registration_no'] ?? '') ?>" class="form-control" placeholder="Nopol">
                        </div>
                    </div>
                    
                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label class="form-label">Merk<span class="form-required" style="color: red;">*</span></label>
                            <select id="v_type" name="v_type" class="form-control" required>
                                <option value="">--Pilih Merk--</option> 
                                <option value="HINO" <?= (old('v_type', $vehicledetails[0]['v_type'] ?? '') == 'HINO') ? 'selected' : '' ?>>HINO</option>
                                <option value="NISSAN" <?= (old('v_type', $vehicledetails[0]['v_type'] ?? '') == 'NISSAN') ? 'selected' : '' ?>>NISSAN</option>
                                <option value="MITSUBISHI" <?= (old('v_type', $vehicledetails[0]['v_type'] ?? '') == 'MITSUBISHI') ? 'selected' : '' ?>>MITSUBISHI</option> 
                                <option value="ISUZU" <?= (old('v_type', $vehicledetails[0]['v_type'] ?? '') == 'ISUZU') ? 'selected' : '' ?>>ISUZU</option> 
                                <option value="DAIHATSU" <?= (old('v_type', $vehicledetails[0]['v_type'] ?? '') == 'DAIHATSU') ? 'selected' : '' ?>>DAIHATSU</option>
                                <option value="TOYOTA" <?= (old('v_type', $vehicledetails[0]['v_type'] ?? '') == 'TOYOTA') ? 'selected' : '' ?>>TOYOTA</option>
                                <option value="UD TRUCK" <?= (old('v_type', $vehicledetails[0]['v_type'] ?? '') == 'UD TRUCK') ? 'selected' : '' ?>>UD TRUCK</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label for="v_name" class="form-label">Jenis Mobil/Bak<span class="form-required" style="color: red;">*</span></label>
                            <select id="v_name" name="v_name" class="form-control" required>
                                <option value="">--Pilih Jenis--</option> 
                                <?php if (!empty($v_group)) : ?>
                                    <?php foreach ($v_group as $v_groupdata) : ?>
                                        <?php 
                                        $selected = old('v_name', $vehicledetails[0]['v_name'] ?? ($vehicledetails['v_name'] ?? '')) == $v_groupdata['gr_name'];
                                        ?>
                                        <option <?= $selected ? 'selected' : '' ?> value="<?= esc($v_groupdata['gr_name']) ?>">
                                            <?= esc($v_groupdata['gr_name']) ?>
                                        </option> 
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label class="form-label">Tahun Kendaraan<span class="form-required" style="color: red;">*</span></label>
                            <input type="text" name="v_reg_exp_date" value="<?= old('v_reg_exp_date', $vehicledetails[0]['v_reg_exp_date'] ?? ($vehicledetails['v_reg_exp_date'] ?? '')) ?>" class="form-control yearpicker" placeholder="Pilih tahun" required>
                        </div>
                    </div>
                    
                    <?php if (isset($vehicledetails[0]['v_is_active'])) : ?>
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="v_is_active" class="form-label">Status Kendaraan<span class="form-required" style="color: red;">*</span></label>
                                <select id="v_is_active" name="v_is_active" class="form-control" required>
                                    <option value="">Select Vehicle Status</option> 
                                    <option <?= (isset($vehicledetails) && $vehicledetails[0]['v_is_active'] == 1) ? 'selected' : '' ?> value="1">Active</option> 
                                    <option <?= (isset($vehicledetails) && $vehicledetails[0]['v_is_active'] == 0) ? 'selected' : '' ?> value="0">Inactive</option> 
                                </select>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="card p-3 border" style="background-color: #f8f9fa;">
                <div class="row">
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Nomor Rangka<span class="form-required" style="color: red;">*</span></label>
                            <input type="text" name="v_chassis_no" value="<?= old('v_chassis_no', $vehicledetails[0]['v_chassis_no'] ?? '') ?>" class="form-control" placeholder="No. Rangka">
                        </div>
                    </div>
                    
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Nomor Mesin<span class="form-required" style="color: red;">*</span></label>
                            <input type="text" name="v_engine_no" value="<?= old('v_engine_no', $vehicledetails[0]['v_engine_no'] ?? '') ?>" class="form-control" placeholder="No. Mesin">
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Masa Berlaku Pajak STNK<span class="form-required" style="color: red;">*</span></label>
                            <input type="text" name="v_stnk_expdate" id="v_stnk_expdate" value="<?= old('v_stnk_expdate', isset($vehicledetails[0]['v_stnk_expdate']) && $vehicledetails[0]['v_stnk_expdate'] !== '0000-00-00' ? date('d-m-Y', strtotime($vehicledetails[0]['v_stnk_expdate'])) : '') ?>" class="form-control datepickerpastdisable" placeholder="Tanggal Berlaku STNK">
                        </div>
                    </div>
                    
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Masa Berlaku Plat<span class="form-required" style="color: red;">*</span></label>
                            <input type="text" name="v_plat_expdate" id="v_plat_expdate" value="<?= old('v_plat_expdate', isset($vehicledetails[0]['v_plat_expdate']) && $vehicledetails[0]['v_plat_expdate'] !== '0000-00-00' ? date('d-m-Y', strtotime($vehicledetails[0]['v_plat_expdate'])) : '') ?>" class="form-control datepickerpastdisable" placeholder="Tanggal Berlaku Plat">
                        </div>
                    </div>
                    
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Nomor Uji<span class="form-required" style="color: red;">*</span></label>
                            <input type="text" name="v_uji_no" value="<?= old('v_uji_no', $vehicledetails[0]['v_uji_no'] ?? '') ?>" class="form-control" placeholder="No. KIR">
                        </div>
                    </div>
                    
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Masa Berlaku KIR<span class="form-required" style="color: red;">*</span></label>
                            <input type="text" name="v_kir_expdate" id="v_kir_expdate" value="<?= old('v_kir_expdate', isset($vehicledetails[0]['v_kir_expdate']) && $vehicledetails[0]['v_kir_expdate'] !== '0000-00-00' ? date('d-m-Y', strtotime($vehicledetails[0]['v_kir_expdate'])) : '') ?>" class="form-control datepickerpastdisable" placeholder="Tanggal Berlaku KIR">
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Tanggal Proses KIR</label>
                            <input type="text" name="v_kir_process_date" id="v_kir_process_date" 
                                   value="<?= old('v_kir_process_date', isset($vehicledetails[0]['v_kir_process_date']) && $vehicledetails[0]['v_kir_process_date'] !== '0000-00-00' ? date('d-m-Y', strtotime($vehicledetails[0]['v_kir_process_date'])) : '') ?>" 
                                   class="form-control datepicker" 
                                   placeholder="Tanggal Proses KIR" 
                                   readonly>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-required">
                            <label class="form-label">Lokasi Dishub<span style="color: red;">*</span></label>
                            <div class="card p-3 border" style="background-color: #ffffff;">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="v_lokasi_kir" id="bdl" value="BANDAR LAMPUNG" 
                                           onclick="handleCheckbox(this, 'luar_bdl')"
                                           <?= (old('v_lokasi_kir', $vehicledetails[0]['v_lokasi_kir'] ?? '') == 'BANDAR LAMPUNG') ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="bdl">BANDAR LAMPUNG</label>
                                </div>
                                <div class="form-check mb-0">
                                    <input class="form-check-input" type="checkbox" name="v_lokasi_kir" id="luar_bdl" value="LUAR BANDAR LAMPUNG" 
                                           onclick="handleCheckbox(this, 'bdl')"
                                           <?= (old('v_lokasi_kir', $vehicledetails[0]['v_lokasi_kir'] ?? '') == 'LUAR BANDAR LAMPUNG') ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="luar_bdl">LUAR BANDAR LAMPUNG</label>
                                </div>
                                <div id="lokasi_kir_error_container" style="margin-top: 10px;"></div>
                                <div id="container_lokasi_dishub" style="margin-top: 10px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                    
                <div class="row">
                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label class="form-label">Asuransi</label>
                            <input type="text" name="v_insurance" value="<?= old('v_insurance', $vehicledetails[0]['v_insurance'] ?? '') ?>" class="form-control">
                        </div>
                    </div>
                    
                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label class="form-label">No. Polis</label>
                            <input type="text" name="v_polis_no" value="<?= old('v_polis_no', $vehicledetails[0]['v_polis_no'] ?? '') ?>" class="form-control">
                        </div>
                    </div>
                    
                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label class="form-label">Masa Berlaku Asuransi</label>
                            <input type="text" name="v_exp_insurance" id="v_exp_insurance" value="<?= old('v_exp_insurance', isset($vehicledetails[0]['v_exp_insurance']) && $vehicledetails[0]['v_exp_insurance'] !== '0000-00-00' ? 
                            date('d/m/Y', strtotime($vehicledetails[0]['v_exp_insurance'])) : '') ?>" class="form-control datepickerpastdisable" placeholder="Tanggal Berlaku Asuransi">
                        </div>
                    </div>
                    
                    <div class="col-sm-6 col-md-12">
                        <div class="form-group">
                            <label class="form-label">Keterangan</label>
                            <textarea class="form-control" autocomplete="off" placeholder="Catatan" name="v_notes"><?= old('v_notes', $vehicledetails[0]['v_notes'] ?? ($vehicledetails['v_notes'] ?? '')) ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label class="form-label">QR Code</label>
                            <div id="qrcode-preview-container" style="text-align: center; border: 1px solid #ddd; padding: 10px; min-height: 180px; display: none;">
                                <img id="qrcode-preview" src="" alt="QR Code Preview" style="max-width: 150px; max-height: 150px;">
                                <p id="qrcode-text" style="margin-top: 10px; font-size: 12px;"></p>
                            </div>
                            <div id="qrcode-loading" style="display: none; text-align: center;">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="sr-only">Generating QR Code...</span>
                                </div>
                                <p>Generating QR Code...</p>
                            </div>
                            <div id="qrcode-error" style="display: none; color: red; text-align: center;">
                                Failed to generate QR Code
                            </div>
                        </div>
                    </div>
                    
                    <?php if (isset($vehicledetails) && !empty($vehicledetails[0]['v_qr_code_path'])): ?>
                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label class="form-label">Current QR Code</label>
                            <div style="text-align: center; border: 1px solid #ddd; padding: 10px;">
                                <img src="<?= base_url('vehicles/view_qrcode/' . $vehicledetails[0]['v_id']) ?>" 
                                     alt="Current QR Code" 
                                     style="display: block; margin: 0 auto 10px; max-width: 150px; max-height: 150px;">
                                <p style="font-size: 12px;">
                                    <a href="<?= base_url('vehicles/download_qrcode/' . $vehicledetails[0]['v_id']) ?>" 
                                       download="QRCode_<?= esc($vehicledetails[0]['v_registration_no']) ?>.png"
                                       class="btn btn-sm btn-primary">
                                        <i class="fa fa-download"></i> Download
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <input type="hidden" name="v_qr_code_path" id="v_qr_code_path" value="<?= isset($vehicledetails) ? esc($vehicledetails[0]['v_qr_code_path'] ?? '') : '' ?>">
                <input type="hidden" name="v_qr_code_filename" id="v_qr_code_filename" value="<?= isset($vehicledetails) ? esc($vehicledetails[0]['v_qr_code_filename'] ?? '') : '' ?>">

                <input type="hidden" name="v_kir_process_date_auto" id="v_kir_process_date_auto" value="">
                
                <input type="hidden" id="v_modified_date" name="v_modified_date" value="<?= date('Y-m-d H:i:s') ?>">
                
                <div class="mb-3 card-footer d-flex">
                    <a href="<?= base_url('vehicles/vehicles_management') ?>" class="btn btn-warning" onclick="return confirmCancel()">
                        <i class="fa fa-left"></i> CANCEL
                    </a>
                    <button type="submit" class="btn btn-primary ml-auto" onclick="return confirmSave()"><?= (isset($vehicledetails)) ? 'UPDATE' : 'SAVE' ?></button>
                </div>
            </div>
        </form>
    </div>
</section>
<?= view('layout/footer') ?>

<script src="<?= base_url('assets/autoLogout.js') ?>"></script>
<script>
// Auto-fill KIR Process Date (30 days AFTER KIR Expiry Date)
document.addEventListener('DOMContentLoaded', function() {
    var kirExpInput = document.getElementById('v_kir_expdate');
    var kirProcessInput = document.getElementById('v_kir_process_date');

    function calculateProcessDate() {
        var kirExpValue = kirExpInput.value;
        if (!kirExpValue) {
            kirProcessInput.value = '';
            return;
        }

        // If bootstrap datepicker is used, fetch the safe Date object directly
        var expDate = null;
        if (typeof jQuery !== 'undefined' && jQuery(kirExpInput).data('datepicker')) {
            expDate = jQuery(kirExpInput).datepicker('getDate');
        }

        if (!expDate) {
            // Fallback string parsing
            var parts;
            if (kirExpValue.indexOf('-') !== -1) {
                parts = kirExpValue.split('-');
                if (parts[0].length === 4) {
                    expDate = new Date(parts[0], parts[1] - 1, parts[2]); // YYYY-MM-DD
                } else {
                    expDate = new Date(parts[2], parts[1] - 1, parts[0]); // DD-MM-YYYY
                }
            } else if (kirExpValue.indexOf('-') !== -1) {
                parts = kirExpValue.split('-');
                expDate = new Date(parts[2], parts[1] - 1, parts[0]); // DD-MM-YYYY
            } else {
                expDate = new Date(kirExpValue);
            }
        }

        if (!expDate || isNaN(expDate.getTime())) return;

        // Gap must be MORE THAN 30 days, so we add 31 days.
        expDate.setDate(expDate.getDate() + 31);

        // Format as dd-mm-yyyy for display
        var year = expDate.getFullYear();
        var month = String(expDate.getMonth() + 1).padStart(2, '0');
        var day = String(expDate.getDate()).padStart(2, '0');
        kirProcessInput.value = day + '-' + month + '-' + year;
    }

    // Override datepicker format for this page specifically to dd-mm-yyyy
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

    kirExpInput.addEventListener('change', calculateProcessDate);
    kirExpInput.addEventListener('input', calculateProcessDate);

    // Bootstrap datepicker specifically triggers 'changeDate', not standard 'change'!
    if (typeof jQuery !== 'undefined') {
        jQuery('#v_kir_expdate').on('change changeDate', calculateProcessDate);
    }

    if (kirExpInput.value && !kirProcessInput.value) {
        calculateProcessDate();
    }
    });

    document.getElementById("luar_bdl").addEventListener("change", function(){
        const container = document.getElementById("container_lokasi_dishub");
            if(this.checked){
                container.innerHTML = 
               ` <div id="v_notes_lokasikir" class="form-group">
                            <div class="flex">
                                <label" for="v_notes_lokasikir" style="font-size: 12px;font-weight: bold;">Sebutkan Lokasi Dishub KIR</label>
                                <span class="form-required" style="color: red;">*</span>
                            </div>
                            <input style="height: 4rem;" type="text" id="v_notes_lokasikir" name="v_notes_lokasikir" placeholder="Lokasi KIR" required>
                        </div>
                `;
                function handleCheckboxChecked(){
                    if (document.getElementById('luar_bdl').checked) {
                        document.getElementById('bdl').checked = false;
                    }
                }
                handleCheckboxChecked();
            }
            else {
                document.getElementById("v_notes_lokasikir").remove();
            }
        })
</script>
