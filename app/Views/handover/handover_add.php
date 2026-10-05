<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<?php
// Custom loading logo check (developer can replace loading_logo.png in assets/uploads)
$loading_logo = 'assets/uploads/loading_logo.png';
if (!file_exists(FCPATH . $loading_logo)) {
    $loading_logo = 'assets/uploads/Icon SSH.png'; // Fallback to default icon
}
?>

<style>
        /* Premium Loading Screen Overlay CSS */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.671);
            z-index: 999999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 1;
            visibility: visible;
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }
        .loading-overlay.fade-out {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }
        .loader-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #ffffff;
            padding: 20px;
        }
        .loading-logo {
            max-width: 75px;
            height: auto;
            margin-top: 28px;
            margin-left: 11px;
            animation: pulse-glow 2.5s infinite ease-in-out;
            filter: drop-shadow(0 0 15px rgba(239, 28, 37, 0.3));
        }
        .loader-spinner {
            position: relative;
            width: 100px;
            height: 100px;
            margin-bottom: 30px;
        }
        .loader-spinner::before,
        .loader-spinner::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            border: 4px solid transparent;
        }
        .loader-spinner::before {
            top: 0; left: 0; right: 0; bottom: 0;
            border-top-color: #ef1c25; /* SSH Red */
            animation: spin-clockwise 1.5s linear infinite;
        }
        .loader-spinner::after {
            top: 6px; left: 6px; right: 6px; bottom: 6px;
            border-bottom-color: #3b82f6; /* Premium Blue */
            animation: spin-counter 1.2s linear infinite;
        }
        .loading-text {
            font-size: 18px;
            font-weight: 600;
            letter-spacing: 0.03em;
            color: #ffffff;
            margin-top: 10px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            font-family: 'Source Sans Pro', 'Inter', sans-serif;
        }
        .loading-subtext {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.55);
            margin-top: 6px;
            letter-spacing: 0.02em;
            font-family: 'Source Sans Pro', 'Inter', sans-serif;
        }
        @keyframes spin-clockwise {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        @keyframes spin-counter {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(-360deg); }
        }
        @keyframes pulse-glow {
            0%, 100% {
                transform: scale(1);
                filter: drop-shadow(0 0 12px rgba(255, 255, 255, 0.15)) drop-shadow(0 0 6px rgba(239, 28, 37, 0.25));
            }
            50% {
                transform: scale(1.05);
                filter: drop-shadow(0 0 22px rgba(255, 255, 255, 0.35)) drop-shadow(0 0 14px rgba(239, 28, 37, 0.5));
            }
        }
</style>
<!-- Premium Loading Screen Overlay for Dashboard -->
<div id="loading-screen" class="loading-overlay">
  <div class="loader-container">
    <div class="loader-spinner">
      <img src="<?= base_url($loading_logo) ?>" alt="Logo" class="loading-logo">
    </div>
    <!-- <div class="loading-text">Memuat Dashboard</div>
    <div class="loading-subtext">Menyiapkan data overview Anda, mohon tunggu...</div> -->
  </div>
</div>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><?= (isset($handoverdetails)) ? 'Edit Handover' : 'Add Handover' ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('handover/handover_management') ?>">Handover</a></li>
                    <li class="breadcrumb-item active"><?= (isset($handoverdetails)) ? 'Edit Handover' : 'Add Handover' ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <form method="post" id="handover_add" class="card <?= (isset($handoverdetails)) ? 'updatehandover' : 'inserthandover' ?>" enctype="multipart/form-data" action="<?= base_url('vehicles/' . ((isset($handoverdetails)) ? 'updatehandover' : 'inserthandover')) ?>" onsubmit="return validateAndShowModal(event)">
            <div class="card-body">
                <h3 class="text-center">Form Serah Terima Kendaraan</h3>
                <hr>
                <div class="row">
                    <input type="hidden" name="ho_id" id="ho_id" value="<?= (isset($handoverdetails)) ? esc($handoverdetails[0]['ho_id']) : '' ?>">

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Nomor Serah Terima<span class="form-required"></span></label>
                            <input type="text" id="ho_code" class="form-control" name="ho_code" value="<?= (isset($handoverdetails) && !empty($handoverdetails[0]['ho_code'])) ? esc($handoverdetails[0]['ho_code']) : esc($new_hdo_code) ?>" readonly>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label class="form-label">Tanggal Serah Terima<span class="form-required" style="color: red;">*</span></label>
                            <input type="text" name="ho_tanggal" id="ho_tanggal" value="<?= old('ho_tanggal', isset($handoverdetails[0]['ho_tanggal']) && $handoverdetails[0]['ho_tanggal'] !== '0000-00-00' ? date('d-m-Y', strtotime($handoverdetails[0]['ho_tanggal'])) : '') ?>" class="form-control datepicker" placeholder="Tanggal Serah Terima">
                        </div>
                    </div>

                    <div class="col-md-6 mb-3 checkbox-group">
                        <label class="control-label">Lokasi<span class="form-required" style="color: red;">*</span></label>
                        <div class="border p-2 rounded d-flex flex-column">
                            <div class="d-flex">
                                <div class="form-check" style="margin-right: 20px;">
                                    <input class="form-check-input" type="checkbox" name="ho_lokasi" id="lokasi_yos" value="POOL YOS"
                                            onclick="handleCheckbox(this, ['lokasi_yos', 'lokasi_pjr', 'lokasi_wl', 'lokasi_ktp'])"
                                                   <?= (old('ho_lokasi', $handoverdetails[0]['ho_lokasi'] ?? '') == 'POOL YOS') ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="lokasi_yos">POOL YOS</label>
                                </div>
                                <div class="form-check" style="margin-right: 20px;">
                                    <input class="form-check-input" type="checkbox" name="ho_lokasi" id="lokasi_pjr" value="POOL PJR" 
                                            onclick="handleCheckbox(this, ['lokasi_yos', 'lokasi_pjr', 'lokasi_wl', 'lokasi_ktp'])"
                                                   <?= (old('ho_lokasi', $handoverdetails[0]['ho_lokasi'] ?? '') == 'POOL PJR') ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="lokasi_pjr">POOL PJR</label>
                                </div>
                                <div class="form-check" style="margin-right: 20px;">
                                    <input class="form-check-input" type="checkbox" name="ho_lokasi" id="lokasi_wl" value="POOL WL" 
                                            onclick="handleCheckbox(this, ['lokasi_yos', 'lokasi_pjr', 'lokasi_wl', 'lokasi_ktp'])"
                                                   <?= (old('ho_lokasi', $handoverdetails[0]['ho_lokasi'] ?? '') == 'POOL WL') ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="lokasi_wl">POOL WL</label>
                                </div>
                                <div class="form-check" style="margin-right: 20px;">
                                    <input class="form-check-input" type="checkbox" name="ho_lokasi" id="lokasi_ktp" value="POOL KTP" 
                                            onclick="handleCheckbox(this, ['lokasi_yos', 'lokasi_pjr', 'lokasi_wl', 'lokasi_ktp'])"
                                                   <?= (old('ho_lokasi', $handoverdetails[0]['ho_lokasi'] ?? '') == 'POOL KTP') ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="lokasi_ktp">POOL KTP</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="ho_nopol" class="form-label">Nomor Polisi<span class="form-required" style="color: red;">*</span></label>
                            <select id="ho_nopol" name="ho_nopol" class="form-control form-control-sm select2-vehicle form-equal-height" onchange="updateNOPOL()">
                                <option value="">-- Pilih Mobil --</option>
                                <?php 
                                    foreach ($inventorylist as $inventory) {
                                        $combinedValue = $inventory['iv_nopol'];
                                        $selected = '';
                                        if (isset($handoverdetails[0]['ho_nopol']) && $handoverdetails[0]['ho_nopol'] == $combinedValue && $inventory['iv_is_active'] == 1) {
                                            $selected = 'selected';
                                        }
                                        if ($inventory['iv_is_active'] == 1) {
                                            echo '<option value="' . esc($combinedValue) . '" 
                                                    data-jenis="' . esc($inventory['iv_jenis'] ?? '') . '" 
                                                    ' . $selected . '>'
                                                . esc($inventory['iv_nopol'])
                                                . '</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <label class="form-label">Jenis Mobil</label>
                        <div class="form-group">
                            <input type="text" name="ho_jenis" id="ho_jenis" value="<?= isset($handoverdetails) ? esc($handoverdetails[0]['ho_jenis']) : '' ?>" class="form-control" placeholder="[auto]" readonly>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label class="form-label">Kilometer Saat Ini<span class="form-required" style="color: red;">*</span></label>
                            <input type="text" name="ho_km" value="<?= isset($handoverdetails) ? esc($handoverdetails[0]['ho_km']) : '' ?>" class="form-control">
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label class="form-label">Jumlah Solar Saat Ini<span class="form-required" style="color: red;">*</span></label>
                            <input type="text" name="ho_solar" value="<?= isset($handoverdetails) ? esc($handoverdetails[0]['ho_solar']) : '' ?>" class="form-control">
                        </div>
                    </div>

                    <input type="hidden" id="ho_nislama" class="form-control" name="ho_nislama" value="<?= isset($handoverdetails) ? esc($handoverdetails[0]['ho_nislama']) : '' ?>" placeholder="[auto]" readonly>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label class="form-label">Supir Lama/Sebelumnya<span class="form-required" style="color: red;">*</span></label>
                            <select id="ho_supirlama" class="form-control form-control-sm select2-driver1 form-equal-height" name="ho_supirlama" onchange="updateNIS()">
                                <option value="">-- Pilih Supir --</option>
                                <!-- <option value="No Driver">-- No Driver --</option> -->
                                    <?php 
                                        usort($driverlist, function($a, $b) {
                                        return strcmp($a['d_name'], $b['d_name']);
                                        });
                                                
                                        foreach ($driverlist as $driver) {
                                        $selected = '';
                                        if (isset($handoverdetails[0]['ho_nislama']) && $handoverdetails[0]['ho_nislama'] == $driver['d_nis'] && $driver['d_is_active'] == 1) {
                                                        $selected = 'selected';
                                                    }
                                        if ($driver['d_is_active'] == 1) {
                                            echo '<option value="' . esc($driver['d_name']) . '" data-nis="' . esc($driver['d_nis']) . '" ' . $selected . '>' . esc($driver['d_name']) . ' ' . '(' . esc($driver['d_nickname']) . ')' . '</option>';
                                            }
                                        }
                                    ?>
                            </select>
                        </div>
                    </div>

                    <input type="hidden" id="ho_nisbaru" class="form-control" name="ho_nisbaru" value="<?= isset($handoverdetails) ? esc($handoverdetails[0]['ho_nisbaru']) : '' ?>" placeholder="[auto]" readonly>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label class="form-label">Supir Baru/Pengganti<span class="form" style="color: red;">*</span></label>
                            <select id="ho_supirbaru" class="form-control form-control-sm select2-driver2 form-equal-height" name="ho_supirbaru" onchange="updateNIS()">
                                <option value="">-- Pilih Supir --</option>
                                <option value="No Driver">-- No Driver --</option>
                                    <?php 
                                        usort($driverlist, function($a, $b) {
                                        return strcmp($a['d_name'], $b['d_name']);
                                        });
                                                
                                        foreach ($driverlist as $driver) {
                                        $selected = '';
                                        if (isset($handoverdetails[0]['ho_nisbaru']) && $handoverdetails[0]['ho_nisbaru'] == $driver['d_nis'] && $driver['d_is_active'] == 1) {
                                                        $selected = 'selected';
                                                    }
                                        if ($driver['d_is_active'] == 1) {
                                            echo '<option value="' . esc($driver['d_name']) . '" data-nis="' . esc($driver['d_nis']) . '" ' . $selected . '>' . esc($driver['d_name']) . ' ' . '(' . esc($driver['d_nickname']) . ')' . '</option>';
                                            }
                                        }
                                    ?>
                            </select>
                        </div>
                    </div>
                </div>

                <hr>
                    <h3 class="text-center">Kondisi Mobil<span class="form-required" style="color: red;">*</span></h3>
                <hr>
                <div class="row">
                    <div class="col-md-3 mb-4 checkbox-group">
                        <label class="control-label">Kabin Mobil<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_kabin" id="kabin_baik" value="Baik"
                                            onclick="handleCheckbox(this, ['kabin_baik', 'kabin_rusak'])"
                                                   <?= (old('ho_kabin', $handoverdetails[0]['ho_kabin'] ?? '') == 'Baik') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="kabin_baik">Baik</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_kabin" id="kabin_rusak" value="Rusak/Keropos/Penyok" 
                                            onclick="handleCheckbox(this, ['kabin_baik', 'kabin_rusak'])"
                                                   <?= (old('ho_kabin', $handoverdetails[0]['ho_kabin'] ?? '') == 'Rusak/Keropos/Penyok') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="kabin_rusak">Rusak/Keropos/Penyok</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4 checkbox-group">
                        <label class="control-label">Kabel Body<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_kabel" id="kabel_baik" value="Baik"
                                            onclick="handleCheckbox(this, ['kabel_baik', 'kabel_rusak'])"
                                                   <?= (old('ho_kabel', $handoverdetails[0]['ho_kabel'] ?? '') == 'Baik') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="kabel_baik">Baik</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_kabel" id="kabel_rusak" value="Rusak" 
                                            onclick="handleCheckbox(this, ['kabel_baik', 'kabel_rusak'])"
                                                   <?= (old('ho_kabel', $handoverdetails[0]['ho_kabel'] ?? '') == 'Rusak') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="kabel_rusak">Rusak</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4 checkbox-group">
                            <label class="control-label">Lampu Besar Depan<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                 <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_lampubesar" id="lampu_hidup" value="Hidup"
                                            onclick="handleCheckbox(this, ['lampu_hidup', 'lampu_mati', 'lampu_redup'])"
                                                   <?= (old('ho_lampubesar', $handoverdetails[0]['ho_lampubesar'] ?? '') == 'Hidup') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="lampu_hidup">Hidup</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="ho_lampubesar" id="lampu_mati" value="Mati"
                                            onclick="handleCheckbox(this, ['lampu_hidup', 'lampu_mati', 'lampu_redup'])"
                                                   <?= (old('ho_lampubesar', $handoverdetails[0]['ho_lampubesar'] ?? '') == 'Mati') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="lampu_mati">Mati</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_lampubesar" id="lampu_redup" value="Redup" 
                                            onclick="handleCheckbox(this, ['lampu_hidup', 'lampu_mati', 'lampu_redup'])"
                                                   <?= (old('ho_lampubesar', $handoverdetails[0]['ho_lampubesar'] ?? '') == 'Redup') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="lampu_redup">Redup</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4 checkbox-group">
                            <label class="control-label">Lampu Rem R/L<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                 <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_lampurem" id="rem_hidup" value="Hidup"
                                            onclick="handleCheckbox(this, ['rem_hidup', 'rem_mati', 'rem_redup'])"
                                                   <?= (old('ho_lampurem', $handoverdetails[0]['ho_lampurem'] ?? '') == 'Hidup') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="rem_hidup">Hidup</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="ho_lampurem" id="rem_mati" value="Mati" 
                                            onclick="handleCheckbox(this, ['rem_hidup', 'rem_mati', 'rem_redup'])"
                                                   <?= (old('ho_lampurem', $handoverdetails[0]['ho_lampurem'] ?? '') == 'Mati') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="rem_mati">Mati</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_lampurem" id="rem_redup" value="Redup" 
                                            onclick="handleCheckbox(this, ['rem_hidup', 'rem_mati', 'rem_redup'])"
                                                   <?= (old('ho_lampurem', $handoverdetails[0]['ho_lampurem'] ?? '') == 'Redup') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="rem_redup">Redup</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4 checkbox-group">
                            <label class="control-label">Lampu Sein Depan R/L<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                 <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_seindpn" id="seindpn_hidup" value="Hidup"
                                            onclick="handleCheckbox(this, ['seindpn_hidup', 'seindpn_mati', 'seindpn_redup'])"
                                                   <?= (old('ho_seindpn', $handoverdetails[0]['ho_seindpn'] ?? '') == 'Hidup') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="seindpn_hidup">Hidup</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="ho_seindpn" id="seindpn_mati" value="Mati" 
                                            onclick="handleCheckbox(this, ['seindpn_hidup', 'seindpn_mati', 'seindpn_redup'])"
                                                   <?= (old('ho_seindpn', $handoverdetails[0]['ho_seindpn'] ?? '') == 'Mati') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="seindpn_mati">Mati</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_seindpn" id="seindpn_redup" value="Redup" 
                                            onclick="handleCheckbox(this, ['seindpn_hidup', 'seindpn_mati', 'seindpn_redup'])"
                                                   <?= (old('ho_seindpn', $handoverdetails[0]['ho_seindpn'] ?? '') == 'Redup') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="seindpn_redup">Redup</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4 checkbox-group">
                            <label class="control-label">Lampu Sein Belakang R/L<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                 <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_seinblk" id="seinblk_hidup" value="Hidup"
                                            onclick="handleCheckbox(this, ['seinblk_hidup', 'seinblk_mati', 'seinblk_redup'])"
                                                   <?= (old('ho_seinblk', $handoverdetails[0]['ho_seinblk'] ?? '') == 'Hidup') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="seinblk_hidup">Hidup</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="ho_seinblk" id="seinblk_mati" value="Mati" 
                                            onclick="handleCheckbox(this, ['seinblk_hidup', 'seinblk_mati', 'seinblk_redup'])"
                                                   <?= (old('ho_seinblk', $handoverdetails[0]['ho_seinblk'] ?? '') == 'Mati') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="seinblk_mati">Mati</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_seinblk" id="seinblk_redup" value="Redup" 
                                            onclick="handleCheckbox(this, ['seinblk_hidup', 'seinblk_mati', 'seinblk_redup'])"
                                                   <?= (old('ho_seinblk', $handoverdetails[0]['ho_seinblk'] ?? '') == 'Redup') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="seinblk_redup">Redup</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4 checkbox-group">
                        <label class="control-label">Wiper<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_wiper" id="wiper_hidup" value="Hidup"
                                            onclick="handleCheckbox(this, ['wiper_hidup', 'wiper_rusak'])"
                                                   <?= (old('ho_wiper', $handoverdetails[0]['ho_wiper'] ?? '') == 'Hidup') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="wiper_hidup">Hidup</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_wiper" id="wiper_rusak" value="Rusak/Hilang" 
                                            onclick="handleCheckbox(this, ['wiper_hidup', 'wiper_rusak'])"
                                                   <?= (old('ho_wiper', $handoverdetails[0]['ho_wiper'] ?? '') == 'Rusak/Hilang') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="wiper_rusak">Rusak/Hilang</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4 checkbox-group">
                        <label class="control-label">Spion Bulat R/L<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_spion" id="spion_baik" value="Baik/Lengkap"
                                            onclick="handleCheckbox(this, ['spion_baik', 'spion_rusak'])"
                                                   <?= (old('ho_spion', $handoverdetails[0]['ho_spion'] ?? '') == 'Baik/Lengkap') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="spion_baik">Baik/Lengkap</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_spion" id="spion_rusak" value="Rusak/Pecah/Hilang" 
                                            onclick="handleCheckbox(this, ['spion_baik', 'spion_rusak'])"
                                                   <?= (old('ho_spion', $handoverdetails[0]['ho_spion'] ?? '') == 'Rusak/Pecah/Hilang') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="spion_rusak">Rusak/Pecah/Hilang</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4 checkbox-group">
                        <label class="control-label">Tangki Solar 1<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_tangki1" id="tangki1_baik" value="Ada/Baik"
                                            onclick="handleCheckbox(this, ['tangki1_baik', 'tangki1_rusak'])"
                                                   <?= (old('ho_tangki1', $handoverdetails[0]['ho_tangki1'] ?? '') == 'Ada/Baik') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="tangki1_baik">Ada/Baik</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_tangki1" id="tangki1_rusak" value="Rusak/Bocor" 
                                            onclick="handleCheckbox(this, ['tangki1_baik', 'tangki1_rusak'])"
                                                   <?= (old('ho_tangki1', $handoverdetails[0]['ho_tangki1'] ?? '') == 'Rusak/Bocor') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="tangki1_rusak">Rusak/Bocor</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4 checkbox-group">
                        <label class="control-label">Tangki Solar 2<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_tangki2" id="tangki2_baik" value="Ada/Baik"
                                            onclick="handleCheckbox(this, ['tangki2_baik', 'tangki2_rusak'])"
                                                   <?= (old('ho_tangki2', $handoverdetails[0]['ho_tangki2'] ?? '') == 'Ada/Baik') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="tangki2_baik">Ada/Baik</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_tangki2" id="tangki2_rusak" value="Rusak/Bocor" 
                                            onclick="handleCheckbox(this, ['tangki2_baik', 'tangki2_rusak'])"
                                                   <?= (old('ho_tangki2', $handoverdetails[0]['ho_tangki2'] ?? '') == 'Rusak/Bocor') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="tangki2_rusak">Rusak/Bocor</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4 checkbox-group">
                        <label class="control-label">Kondisi Bak<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_bak" id="bak_baik" value="Baik"
                                            onclick="handleCheckbox(this, ['bak_baik', 'bak_rusak'])"
                                                   <?= (old('ho_bak', $handoverdetails[0]['ho_bak'] ?? '') == 'Baik') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="bak_baik">Baik</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_bak" id="bak_rusak" value="Rusak/Keropos/Berkarat" 
                                            onclick="handleCheckbox(this, ['bak_baik', 'bak_rusak'])"
                                                   <?= (old('ho_bak', $handoverdetails[0]['ho_bak'] ?? '') == 'Rusak/Keropos/Berkarat') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="bak_rusak">Rusak/Keropos/Berkarat</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4 checkbox-group">
                        <label class="control-label">Pintu Kupu-Kupu<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_pintu" id="pintu_baik" value="Baik"
                                            onclick="handleCheckbox(this, ['pintu_baik', 'pintu_rusak'])"
                                                   <?= (old('ho_pintu', $handoverdetails[0]['ho_pintu'] ?? '') == 'Baik') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="pintu_baik">Baik</label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_pintu" id="pintu_rusak" value="Rusak/Keropos/Berkarat" 
                                            onclick="handleCheckbox(this, ['pintu_baik', 'pintu_rusak'])"
                                                   <?= (old('ho_pintu', $handoverdetails[0]['ho_pintu'] ?? '') == 'Rusak/Keropos/Berkarat') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="pintu_rusak">Rusak/Keropos/Berkarat</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>

                        <hr>
                            <h3 class="text-center">Kondisi Ban Depan<span class="form-required" style="color: red;">*</span></h3>
                        <hr>
                        <div class="row">
                        <div class="col-md-6 mb-6 checkbox-group">
                            <label class="control-label">Ban Depan Kiri<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                 <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_bandpnkr" id="bandpnkr_bcap" value="Baik (Cap SSH)"
                                            onclick="handleCheckbox(this, ['bandpnkr_bcap', 'banddpnkr_rcap', 'banddpnkr_btanpa', 'banddpnkr_rtanpa'])"
                                                   <?= (old('ho_bandpnkr', $handoverdetails[0]['ho_bandpnkr'] ?? '') == 'Baik (Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="bandpnkr_bcap">Baik <strong>(Ada Cap SSH)</strong></label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="ho_bandpnkr" id="banddpnkr_rcap" value="Rusak (Cap SSH)" 
                                            onclick="handleCheckbox(this, ['bandpnkr_bcap', 'banddpnkr_rcap', 'banddpnkr_btanpa', 'banddpnkr_rtanpa'])"
                                                   <?= (old('ho_bandpnkr', $handoverdetails[0]['ho_bandpnkr'] ?? '') == 'Rusak (Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="banddpnkr_rcap">Rusak <strong>(Ada Cap SSH)</strong></label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_bandpnkr" id="banddpnkr_btanpa" value="Baik (Tanpa Cap SSH)" 
                                            onclick="handleCheckbox(this, ['bandpnkr_bcap', 'banddpnkr_rcap', 'banddpnkr_btanpa', 'banddpnkr_rtanpa'])"
                                                   <?= (old('ho_bandpnkr', $handoverdetails[0]['ho_bandpnkr'] ?? '') == 'Baik (Tanpa Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="banddpnkr_btanpa">Baik <strong>(Tanpa Cap SSH)</strong></label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="ho_bandpnkr" id="banddpnkr_rtanpa" value="Rusak (Tanpa Cap SSH)" 
                                            onclick="handleCheckbox(this, ['bandpnkr_bcap', 'banddpnkr_rcap', 'banddpnkr_btanpa' , 'banddpnkr_rtanpa'])"
                                                   <?= (old('ho_bandpnkr', $handoverdetails[0]['ho_bandpnkr'] ?? '') == 'Rusak (Tanpa Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="banddpnkr_rtanpa">Rusak <strong>(Tanpa Cap SSH)</strong></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-6">
                            <div class="form-group">
                                <label class="form-label">Merk Ban Depan Kiri<span class="form-required" style="color: red;">*</span></label>
                                <select id="ho_merkbankr" name="ho_merkbankr" for="ho_merkbankr" class="form-control form-control-sm select2-merkban form-equal-height">
                                    <option value="" disabled selected>--Pilih Merk Ban Depan Kiri--</option>
                                    <?php if(!empty($ho_merk_ban)) : ?>
                                        <?php foreach ($ho_merk_ban as $merkban) : ?>
                                            <?php $selected = old('ho_merkbankr', $handoverdetails[0]['ho_merkbankr'] ?? ($handoverdetails['ho_merkbankr'] ?? '' )) == $merkban['mb_name'];?>
                                            <option <?= $selected ? 'selected' : '' ?> value="<?= esc($merkban['mb_name'])?>">
                                                <?= esc($merkban['mb_name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 mb-6 mt-3 checkbox-group">
                            <label class="control-label">Ban Depan Kanan<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                 <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_bandpnkn" id="bandpnkn_bcap" value="Baik (Cap SSH)"
                                            onclick="handleCheckbox(this, ['bandpnkn_bcap', 'banddpnkn_rcap', 'banddpnkn_btanpa', 'banddpnkn_rtanpa'])"
                                                   <?= (old('ho_bandpnkn', $handoverdetails[0]['ho_bandpnkn'] ?? '') == 'Baik (Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="bandpnkn_bcap">Baik <strong>(Ada Cap SSH)</strong></label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="ho_bandpnkn" id="banddpnkn_rcap" value="Rusak (Cap SSH)" 
                                            onclick="handleCheckbox(this, ['bandpnkn_bcap', 'banddpnkn_rcap', 'banddpnkn_btanpa', 'banddpnkn_rtanpa'])"
                                                   <?= (old('ho_bandpnkn', $handoverdetails[0]['ho_bandpnkn'] ?? '') == 'Rusak (Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="banddpnkn_rcap">Rusak <strong>(Ada Cap SSH)</strong></label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_bandpnkn" id="banddpnkn_btanpa" value="Baik (Tanpa Cap SSH)" 
                                            onclick="handleCheckbox(this, ['bandpnkn_bcap', 'banddpnkn_rcap', 'banddpnkn_btanpa', 'banddpnkn_rtanpa'])"
                                                   <?= (old('ho_bandpnkn', $handoverdetails[0]['ho_bandpnkn'] ?? '') == 'Baik (Tanpa Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="banddpnkn_btanpa">Baik <strong>(Tanpa Cap SSH)</strong></label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="ho_bandpnkn" id="banddpnkn_rtanpa" value="Rusak (Tanpa Cap SSH)" 
                                            onclick="handleCheckbox(this, ['bandpnkn_bcap', 'banddpnkn_rcap', 'banddpnkn_btanpa' , 'banddpnkn_rtanpa'])"
                                                   <?= (old('ho_bandpnkn', $handoverdetails[0]['ho_bandpnkn'] ?? '') == 'Rusak (Tanpa Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="banddpnkn_rtanpa">Rusak <strong>(Tanpa Cap SSH)</strong></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-6 mt-3">
                            <div class="form-group">
                                <label class="form-label">Merk Ban Depan Kanan<span class="form-required" style="color: red;">*</span></label>
                                <select id="ho_merkbankn" name="ho_merkbankn" for="ho_merkbankn" class="form-control form-control-sm select2-merkban form-equal-height">
                                    <option value="" disabled selected>--Pilih Merk Ban Depan Kanan--</option>
                                    <?php if(!empty($ho_merk_ban)) : ?>
                                        <?php foreach ($ho_merk_ban as $merkban) : ?>
                                            <?php $selected = old('ho_merkbankn', $handoverdetails[0]['ho_merkbankn'] ?? ($handoverdetails['ho_merkbankn'] ?? '' )) == $merkban['mb_name'];?>
                                            <option <?= $selected ? 'selected' : '' ?> value="<?= esc($merkban['mb_name'])?>">
                                                <?= esc($merkban['mb_name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr>
                        <h3 class="text-center">Kondisi Ban Belakang<span class="form-required" style="color: red;">*</span></h3>
                    <hr>
                    <div class="row">
                        <div class="col-md-3 mb-4 checkbox-group">
                        <label class="control-label">Ban Belakang Kiri Luar<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_banblkkrlr" id="bandblkkrlr_bcap" value="Baik (Ada Cap SSH)"
                                            onclick="handleCheckbox(this, ['bandblkkrlr_bcap', 'bandblkkrlr_rcap', 'bandblkkrlr_btanpa', 'bandblkkrlr_rtanpa'])"
                                                   <?= (old('ho_banblkkrlr', $handoverdetails[0]['ho_banblkkrlr'] ?? '') == 'Baik (Ada Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="bandblkkrlr_bcap">Baik <strong>(Ada Cap SSH)</strong></label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_banblkkrlr" id="bandblkkrlr_rcap" value="Rusak (Ada Cap SSH)"
                                            onclick="handleCheckbox(this, ['bandblkkrlr_bcap', 'bandblkkrlr_rcap', 'bandblkkrlr_btanpa', 'bandblkkrlr_rtanpa'])"
                                                   <?= (old('ho_banblkkrlr', $handoverdetails[0]['ho_banblkkrlr'] ?? '') == 'Rusak (Ada Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="bandblkkrlr_rcap">Rusak <strong>(Ada Cap SSH)</strong></label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_banblkkrlr" id="bandblkkrlr_btanpa" value="Baik (Tanpa Cap SSH)" 
                                            onclick="handleCheckbox(this, ['bandblkkrlr_bcap', 'bandblkkrlr_rcap', 'bandblkkrlr_btanpa', 'bandblkkrlr_rtanpa'])"
                                                   <?= (old('ho_banblkkrlr', $handoverdetails[0]['ho_banblkkrlr'] ?? '') == 'Baik (Tanpa Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="bandblkkrlr_btanpa">Baik <strong>(Tanpa Cap SSH)</strong></label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_banblkkrlr" id="bandblkkrlr_rtanpa" value="Rusak (Tanpa Cap SSH)" 
                                            onclick="handleCheckbox(this, ['bandblkkrlr_bcap', 'bandblkkrlr_rcap', 'bandblkkrlr_btanpa', 'bandblkkrlr_rtanpa'])"
                                                   <?= (old('ho_banblkkrlr', $handoverdetails[0]['ho_banblkkrlr'] ?? '') == 'Rusak (Tanpa Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="bandblkkrlr_rtanpa">Rusak <strong>(Tanpa Cap SSH)</strong></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4">
                            <div class="form-group">
                                <label class="form-label">Merk Ban Belakang Kiri Luar<span class="form-required" style="color: red;">*</span></label>
                                <select id="ho_merkbankrlr" name="ho_merkbankrlr" for="ho_merkbankrlr" class="form-control form-control-sm select2-merkban form-equal-height">
                                    <option value="" disabled selected>--Pilih Merk Ban Depan Kiri--</option>
                                    <?php if(!empty($ho_merk_ban)) : ?>
                                        <?php foreach ($ho_merk_ban as $merkban) : ?>
                                            <?php $selected = old('ho_merkbankrlr', $handoverdetails[0]['ho_merkbankrlr'] ?? ($handoverdetails['ho_merkbankrlr'] ?? '' )) == $merkban['mb_name'];?>
                                            <option <?= $selected ? 'selected' : '' ?> value="<?= esc($merkban['mb_name'])?>">
                                                <?= esc($merkban['mb_name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4 checkbox-group">
                        <label class="control-label">Ban Belakang Kanan Luar<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_banblkknlr" id="bandblkknlr_bcap" value="Baik (Ada Cap SSH)"
                                            onclick="handleCheckbox(this, ['bandblkknlr_bcap', 'bandblkknlr_rcap', 'bandblkknlr_btanpa', 'bandblkknlr_rtanpa'])"
                                                   <?= (old('ho_banblkknlr', $handoverdetails[0]['ho_banblkknlr'] ?? '') == 'Baik (Ada Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="bandblkknlr_bcap">Baik <strong>(Ada Cap SSH)</strong></label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_banblkknlr" id="bandblkknlr_rcap" value="Rusak (Ada Cap SSH)"
                                            onclick="handleCheckbox(this, ['bandblkknlr_bcap', 'bandblkknlr_rcap', 'bandblkknlr_btanpa', 'bandblkknlr_rtanpa'])"
                                                   <?= (old('ho_banblkknlr', $handoverdetails[0]['ho_banblkknlr'] ?? '') == 'Rusak (Ada Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="bandblkknlr_rcap">Rusak <strong>(Ada Cap SSH)</strong></label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_banblkknlr" id="bandblkknlr_btanpa" value="Baik (Tanpa Cap SSH)" 
                                            onclick="handleCheckbox(this, ['bandblkknlr_bcap', 'bandblkknlr_rcap', 'bandblkknlr_btanpa', 'bandblkknlr_rtanpa'])"
                                                   <?= (old('ho_banblkknlr', $handoverdetails[0]['ho_banblkknlr'] ?? '') == 'Baik (Tanpa Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="bandblkknlr_btanpa">Baik <strong>(Tanpa Cap SSH)</strong></label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_banblkknlr" id="bandblkknlr_rtanpa" value="Rusak (Tanpa Cap SSH)" 
                                            onclick="handleCheckbox(this, ['bandblkknlr_bcap', 'bandblkknlr_rcap', 'bandblkknlr_btanpa', 'bandblkknlr_rtanpa'])"
                                                   <?= (old('ho_banblkknlr', $handoverdetails[0]['ho_banblkknlr'] ?? '') == 'Rusak (Tanpa Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="bandblkknlr_rtanpa">Rusak <strong>(Tanpa Cap SSH)</strong></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4">
                            <div class="form-group">
                                <label class="form-label">Merk Ban Belakang Kanan Luar<span class="form-required" style="color: red;">*</span></label>
                                <select id="ho_merkbanknlr" name="ho_merkbanknlr" for="ho_merkbanknlr" class="form-control form-control-sm select2-merkban form-equal-height">
                                    <option value="" disabled selected>--Pilih Merk Ban Depan Kiri--</option>
                                    <?php if(!empty($ho_merk_ban)) : ?>
                                        <?php foreach ($ho_merk_ban as $merkban) : ?>
                                            <?php $selected = old('ho_merkbanknlr', $handoverdetails[0]['ho_merkbanknlr'] ?? ($handoverdetails['ho_merkbanknlr'] ?? '' )) == $merkban['mb_name'];?>
                                            <option <?= $selected ? 'selected' : '' ?> value="<?= esc($merkban['mb_name'])?>">
                                                <?= esc($merkban['mb_name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4 checkbox-group">
                        <label class="control-label">Ban Belakang Kiri Dalam<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_banblkkrdlm" id="bandblkkrdlm_bcap" value="Baik (Ada Cap SSH)"
                                            onclick="handleCheckbox(this, ['bandblkkrdlm_bcap', 'bandblkkrdlm_rcap', 'bandblkkrdlm_btanpa', 'bandblkkrdlm_rtanpa'])"
                                                   <?= (old('ho_banblkkrdlm', $handoverdetails[0]['ho_banblkkrdlm'] ?? '') == 'Baik (Ada Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="bandblkkrdlm_bcap">Baik <strong>(Ada Cap SSH)</strong></label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_banblkkrdlm" id="bandblkkrdlm_rcap" value="Rusak (Ada Cap SSH)"
                                            onclick="handleCheckbox(this, ['bandblkkrdlm_bcap', 'bandblkkrdlm_rcap', 'bandblkkrdlm_btanpa', 'bandblkkrdlm_rtanpa'])"
                                                   <?= (old('ho_banblkkrdlm', $handoverdetails[0]['ho_banblkkrdlm'] ?? '') == 'Rusak (Ada Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="bandblkkrdlm_rcap">Rusak <strong>(Ada Cap SSH)</strong></label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_banblkkrdlm" id="bandblkkrdlm_btanpa" value="Baik (Tanpa Cap SSH)" 
                                            onclick="handleCheckbox(this, ['bandblkkrdlm_bcap', 'bandblkkrdlm_rcap', 'bandblkkrdlm_btanpa', 'bandblkkrdlm_rtanpa'])"
                                                   <?= (old('ho_banblkkrdlm', $handoverdetails[0]['ho_banblkkrdlm'] ?? '') == 'Baik (Tanpa Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="bandblkkrdlm_btanpa">Baik <strong>(Tanpa Cap SSH)</strong></label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_banblkkrdlm" id="bandblkkrdlm_rtanpa" value="Rusak (Tanpa Cap SSH)" 
                                            onclick="handleCheckbox(this, ['bandblkkrdlm_bcap', 'bandblkkrdlm_rcap', 'bandblkkrdlm_btanpa', 'bandblkkrdlm_rtanpa'])"
                                                   <?= (old('ho_banblkkrdlm', $handoverdetails[0]['ho_banblkkrdlm'] ?? '') == 'Rusak (Tanpa Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="bandblkkrdlm_rtanpa">Rusak <strong>(Tanpa Cap SSH)</strong></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4">
                            <div class="form-group">
                                <label class="form-label">Merk Ban Belakang Kiri Dalam<span class="form-required" style="color: red;">*</span></label>
                                <select id="ho_merkbankrdlm" name="ho_merkbankrdlm" for="ho_merkbankrdlm" class="form-control form-control-sm select2-merkban form-equal-height">
                                    <option value="" disabled selected>--Pilih Merk Ban Depan Kiri--</option>
                                    <?php if(!empty($ho_merk_ban)) : ?>
                                        <?php foreach ($ho_merk_ban as $merkban) : ?>
                                            <?php $selected = old('ho_merkbankrdlm', $handoverdetails[0]['ho_merkbankrdlm'] ?? ($handoverdetails['ho_merkbankrdlm'] ?? '' )) == $merkban['mb_name'];?>
                                            <option <?= $selected ? 'selected' : '' ?> value="<?= esc($merkban['mb_name'])?>">
                                                <?= esc($merkban['mb_name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4 checkbox-group">
                        <label class="control-label">Ban Belakang Kanan Dalam<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_banblkkndlm" id="bandblkkndlm_bcap" value="Baik (Ada Cap SSH)"
                                            onclick="handleCheckbox(this, ['bandblkkndlm_bcap', 'bandblkkndalm_rcap', 'bandblkkndlm_btanpa', 'bandblkkndlm_rtanpa'])"
                                                   <?= (old('ho_banblkkndlm', $handoverdetails[0]['ho_banblkkndlm'] ?? '') == 'Baik (Ada Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="bandblkkndlm_bcap">Baik <strong>(Ada Cap SSH)</strong></label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_banblkkndlm" id="bandblkkndalm_rcap" value="Rusak (Ada Cap SSH)"
                                            onclick="handleCheckbox(this, ['bandblkkndlm_bcap', 'bandblkkndalm_rcap', 'bandblkkndlm_btanpa', 'bandblkkndlm_rtanpa'])"
                                                   <?= (old('ho_banblkkndlm', $handoverdetails[0]['ho_banblkkndlm'] ?? '') == 'Rusak (Ada Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="bandblkkndalm_rcap">Rusak <strong>(Ada Cap SSH)</strong></label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_banblkkndlm" id="bandblkkndlm_btanpa" value="Baik (Tanpa Cap SSH)" 
                                            onclick="handleCheckbox(this, ['bandblkkndlm_bcap', 'bandblkkndalm_rcap', 'bandblkkndlm_btanpa', 'bandblkkndlm_rtanpa'])"
                                                   <?= (old('ho_banblkkndlm', $handoverdetails[0]['ho_banblkkndlm'] ?? '') == 'Baik (Tanpa Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="bandblkkndlm_btanpa">Baik <strong>(Tanpa Cap SSH)</strong></label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_banblkkndlm" id="bandblkkndlm_rtanpa" value="Rusak (Tanpa Cap SSH)" 
                                            onclick="handleCheckbox(this, ['bandblkkndlm_bcap', 'bandblkkndalm_rcap', 'bandblkkndlm_btanpa', 'bandblkkndlm_rtanpa'])"
                                                   <?= (old('ho_banblkkndlm', $handoverdetails[0]['ho_banblkkndlm'] ?? '') == 'Rusak (Tanpa Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="bandblkkndlm_rtanpa">Rusak <strong>(Tanpa Cap SSH)</strong></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4">
                            <div class="form-group">
                                <label class="form-label">Merk Ban Belakang Kanan Dalam<span class="form-required" style="color: red;">*</span></label>
                                <select id="ho_merkbankndlm" name="ho_merkbankndlm" for="ho_merkbankndlm" class="form-control form-control-sm select2-merkban form-equal-height">
                                    <option value="" disabled selected>--Pilih Merk Ban Depan Kiri--</option>
                                    <?php if(!empty($ho_merk_ban)) : ?>
                                        <?php foreach ($ho_merk_ban as $merkban) : ?>
                                            <?php $selected = old('ho_merkbankndlm', $handoverdetails[0]['ho_merkbankndlm'] ?? ($handoverdetails['ho_merkbankndlm'] ?? '' )) == $merkban['mb_name'];?>
                                            <option <?= $selected ? 'selected' : '' ?> value="<?= esc($merkban['mb_name'])?>">
                                                <?= esc($merkban['mb_name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                        <hr>
                            <h3 class="text-center">Kondisi Ban Tarik</h3>
                        <hr>
                        <div class="row">
                        <div class="col-md-3 mb-4">
                        <label class="control-label">Ban Tarik Kiri Luar</label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_bantrkkrlr" id="bandtrkkrlr_bcap" value="Baik (Ada Cap SSH)"
                                            onclick="handleCheckbox(this, ['bandtrkkrlr_bcap', 'bandtrkkrlr_rcap', 'bandtrkkrlr_btanpa', 'bandtrkkrlr_rtanpa'])"
                                                   <?= (old('ho_bantrkkrlr', $handoverdetails[0]['ho_bantrkkrlr'] ?? '') == 'Baik (Ada Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="bandtrkkrlr_bcap">Baik <strong>(Ada Cap SSH)</strong></label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_bantrkkrlr" id="bandtrkkrlr_rcap" value="Rusak (Ada Cap SSH)"
                                            onclick="handleCheckbox(this, ['bandtrkkrlr_bcap', 'bandtrkkrlr_rcap', 'bandtrkkrlr_btanpa', 'bandtrkkrlr_rtanpa'])"
                                                   <?= (old('ho_bantrkkrlr', $handoverdetails[0]['ho_bantrkkrlr'] ?? '') == 'Rusak (Ada Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="bandtrkkrlr_rcap">Rusak <strong>(Ada Cap SSH)</strong></label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_bantrkkrlr" id="bandtrkkrlr_btanpa" value="Baik (Tanpa Cap SSH)" 
                                            onclick="handleCheckbox(this, ['bandtrkkrlr_bcap', 'bandtrkkrlr_rcap', 'bandtrkkrlr_btanpa', 'bandtrkkrlr_rtanpa'])"
                                                   <?= (old('ho_bantrkkrlr', $handoverdetails[0]['ho_bantrkkrlr'] ?? '') == 'Baik (Tanpa Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="bandtrkkrlr_btanpa">Baik <strong>(Tanpa Cap SSH)</strong></label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_bantrkkrlr" id="bandtrkkrlr_rtanpa" value="Rusak (Tanpa Cap SSH)" 
                                            onclick="handleCheckbox(this, ['bandtrkkrlr_bcap', 'bandtrkkrlr_rcap', 'bandtrkkrlr_btanpa', 'bandtrkkrlr_rtanpa'])"
                                                   <?= (old('ho_bantrkkrlr', $handoverdetails[0]['ho_bantrkkrlr'] ?? '') == 'Rusak (Tanpa Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="bandtrkkrlr_rtanpa">Rusak <strong>(Tanpa Cap SSH)</strong></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4">
                            <div class="form-group">
                                <label class="form-label">Merk Ban Tarik Kiri Luar</label>
                                <select id="ho_merkbantrkkrlr" name="ho_merkbantrkkrlr" for="ho_merkbantrkkrlr" class="form-control form-control-sm select2-merkban form-equal-height">
                                    <option value="" disabled selected>--Pilih Merk Ban Depan Kiri--</option>
                                    <?php if(!empty($ho_merk_ban)) : ?>
                                        <?php foreach ($ho_merk_ban as $merkban) : ?>
                                            <?php $selected = old('ho_merkbantrkkrlr', $handoverdetails[0]['ho_merkbantrkkrlr'] ?? ($handoverdetails['ho_merkbantrkkrlr'] ?? '' )) == $merkban['mb_name'];?>
                                            <option <?= $selected ? 'selected' : '' ?> value="<?= esc($merkban['mb_name'])?>">
                                                <?= esc($merkban['mb_name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4">
                        <label class="control-label">Ban Tarik Kanan Luar</label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_bantrkknlr" id="bandtrkknlr_bcap" value="Baik (Ada Cap SSH)"
                                            onclick="handleCheckbox(this, ['bandtrkknlr_bcap', 'bandtrkknlr_rcap', 'bandtrkknlr_btanpa', 'bandtrkknlr_rtanpa'])"
                                                   <?= (old('ho_bantrkknlr', $handoverdetails[0]['ho_bantrkknlr'] ?? '') == 'Baik (Ada Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="bandtrkknlr_bcap">Baik <strong>(Ada Cap SSH)</strong></label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_bantrkknlr" id="bandtrkknlr_rcap" value="Rusak (Ada Cap SSH)"
                                            onclick="handleCheckbox(this, ['bandtrkknlr_bcap', 'bandtrkknlr_rcap', 'bandtrkknlr_btanpa', 'bandtrkknlr_rtanpa'])"
                                                   <?= (old('ho_bantrkknlr', $handoverdetails[0]['ho_bantrkknlr'] ?? '') == 'Rusak (Ada Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="bandtrkknlr_rcap">Rusak <strong>(Ada Cap SSH)</strong></label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_bantrkknlr" id="bandtrkknlr_btanpa" value="Baik (Tanpa Cap SSH)" 
                                            onclick="handleCheckbox(this, ['bandtrkknlr_bcap', 'bandtrkknlr_rcap', 'bandtrkknlr_btanpa', 'bandtrkknlr_rtanpa'])"
                                                   <?= (old('ho_bantrkknlr', $handoverdetails[0]['ho_bantrkknlr'] ?? '') == 'Baik (Tanpa Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="bandtrkknlr_btanpa">Baik <strong>(Tanpa Cap SSH)</strong></label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_bantrkknlr" id="bandtrkknlr_rtanpa" value="Rusak (Tanpa Cap SSH)" 
                                            onclick="handleCheckbox(this, ['bandtrkknlr_bcap', 'bandtrkknlr_rcap', 'bandtrkknlr_btanpa', 'bandtrkknlr_rtanpa'])"
                                                   <?= (old('ho_bantrkknlr', $handoverdetails[0]['ho_bantrkknlr'] ?? '') == 'Rusak (Tanpa Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="bandtrkknlr_rtanpa">Rusak <strong>(Tanpa Cap SSH)</strong></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4">
                            <div class="form-group">
                                <label class="form-label">Merk Ban Tarik Kanan Luar</label>
                                <select id="ho_merkbantrkknlr" name="ho_merkbantrkknlr" for="ho_merkbantrkknlr" class="form-control form-control-sm select2-merkban form-equal-height">
                                    <option value="" disabled selected>--Pilih Merk Ban Depan Kiri--</option>
                                    <?php if(!empty($ho_merk_ban)) : ?>
                                        <?php foreach ($ho_merk_ban as $merkban) : ?>
                                            <?php $selected = old('ho_merkbantrkknlr', $handoverdetails[0]['ho_merkbantrkknlr'] ?? ($handoverdetails['ho_merkbantrkknlr'] ?? '' )) == $merkban['mb_name'];?>
                                            <option <?= $selected ? 'selected' : '' ?> value="<?= esc($merkban['mb_name'])?>">
                                                <?= esc($merkban['mb_name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4">
                        <label class="control-label">Ban Tarik Kiri Dalam</label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_bantrkkrdlm" id="bandtrkkrdlm_bcap" value="Baik (Ada Cap SSH)"
                                            onclick="handleCheckbox(this, ['bandtrkkrdlm_bcap', 'bandtrkkrdlm_rcap', 'bandtrkkrdlm_btanpa', 'bandtrkkrdlm_rtanpa'])"
                                                   <?= (old('ho_bantrkkrdlm', $handoverdetails[0]['ho_bantrkkrdlm'] ?? '') == 'Baik (Ada Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="bandtrkkrdlm_bcap">Baik <strong>(Ada Cap SSH)</strong></label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_bantrkkrdlm" id="bandtrkkrdlm_rcap" value="Rusak (Ada Cap SSH)"
                                            onclick="handleCheckbox(this, ['bandtrkkrdlm_bcap', 'bandtrkkrdlm_rcap', 'bandtrkkrdlm_btanpa', 'bandtrkkrdlm_rtanpa'])"
                                                   <?= (old('ho_bantrkkrdlm', $handoverdetails[0]['ho_bantrkkrdlm'] ?? '') == 'Rusak (Ada Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="bandtrkkrdlm_rcap">Rusak <strong>(Ada Cap SSH)</strong></label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_bantrkkrdlm" id="bandtrkkrdlm_btanpa" value="Baik (Tanpa Cap SSH)" 
                                            onclick="handleCheckbox(this, ['bandtrkkrdlm_bcap', 'bandtrkkrdlm_rcap', 'bandtrkkrdlm_btanpa', 'bandtrkkrdlm_rtanpa'])"
                                                   <?= (old('ho_bantrkkrdlm', $handoverdetails[0]['ho_bantrkkrdlm'] ?? '') == 'Baik (Tanpa Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="bandtrkkrdlm_btanpa">Baik <strong>(Tanpa Cap SSH)</strong></label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_bantrkkrdlm" id="bandtrkkrdlm_rtanpa" value="Rusak (Tanpa Cap SSH)" 
                                            onclick="handleCheckbox(this, ['bandtrkkrdlm_bcap', 'bandtrkkrdlm_rcap', 'bandtrkkrdlm_btanpa', 'bandtrkkrdlm_rtanpa'])"
                                                   <?= (old('ho_bantrkkrdlm', $handoverdetails[0]['ho_bantrkkrdlm'] ?? '') == 'Rusak (Tanpa Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="bandtrkkrdlm_rtanpa">Rusak <strong>(Tanpa Cap SSH)</strong></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4">
                            <div class="form-group">
                                <label class="form-label">Merk Ban Tarik Kiri Dalam</label>
                                <select id="ho_merkbantrkkrdlm" name="ho_merkbantrkkrdlm" for="ho_merkbantrkkrdlm" class="form-control form-control-sm select2-merkban form-equal-height">
                                    <option value="" disabled selected>--Pilih Merk Ban Depan Kiri--</option>
                                    <?php if(!empty($ho_merk_ban)) : ?>
                                        <?php foreach ($ho_merk_ban as $merkban) : ?>
                                            <?php $selected = old('ho_merkbantrkkrdlm', $handoverdetails[0]['ho_merkbantrkkrdlm'] ?? ($handoverdetails['ho_merkbantrkkrdlm'] ?? '' )) == $merkban['mb_name'];?>
                                            <option <?= $selected ? 'selected' : '' ?> value="<?= esc($merkban['mb_name'])?>">
                                                <?= esc($merkban['mb_name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4">
                        <label class="control-label">Ban Tarik Kanan Dalam</label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_bantrkkndlm" id="bantrkkndlm_bcap" value="Baik (Ada Cap SSH)"
                                            onclick="handleCheckbox(this, ['bantrkkndlm_bcap', 'bantrkkndalm_rcap', 'bantrkkndlm_btanpa', 'bantrkkndlm_rtanpa'])"
                                                   <?= (old('ho_bantrkkndlm', $handoverdetails[0]['ho_bantrkkndlm'] ?? '') == 'Baik (Ada Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="bantrkkndlm_bcap">Baik <strong>(Ada Cap SSH)</strong></label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_bantrkkndlm" id="bantrkkndalm_rcap" value="Rusak (Ada Cap SSH)"
                                            onclick="handleCheckbox(this, ['bantrkkndlm_bcap', 'bantrkkndalm_rcap', 'bantrkkndlm_btanpa', 'bantrkkndlm_rtanpa'])"
                                                   <?= (old('ho_bantrkkndlm', $handoverdetails[0]['ho_bantrkkndlm'] ?? '') == 'Rusak (Ada Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="bantrkkndalm_rcap">Rusak <strong>(Ada Cap SSH)</strong></label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_bantrkkndlm" id="bantrkkndlm_btanpa" value="Baik (Tanpa Cap SSH)" 
                                            onclick="handleCheckbox(this, ['bantrkkndlm_bcap', 'bantrkkndalm_rcap', 'bantrkkndlm_btanpa', 'bantrkkndlm_rtanpa'])"
                                                   <?= (old('ho_bantrkkndlm', $handoverdetails[0]['ho_bantrkkndlm'] ?? '') == 'Baik (Tanpa Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="bantrkkndlm_btanpa">Baik <strong>(Tanpa Cap SSH)</strong></label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_bantrkkndlm" id="bantrkkndlm_rtanpa" value="Rusak (Tanpa Cap SSH)" 
                                            onclick="handleCheckbox(this, ['bantrkkndlm_bcap', 'bantrkkndalm_rcap', 'bantrkkndlm_btanpa', 'bantrkkndlm_rtanpa'])"
                                                   <?= (old('ho_bantrkkndlm', $handoverdetails[0]['ho_bantrkkndlm'] ?? '') == 'Rusak (Tanpa Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="bantrkkndlm_rtanpa">Rusak <strong>(Tanpa Cap SSH)</strong></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4">
                            <div class="form-group">
                                <label class="form-label">Merk Ban Tarik Kanan Dalam</label>
                                <select id="ho_merkbantrkkndlm" name="ho_merkbantrkkndlm" for="ho_merkbantrkkndlm" class="form-control form-control-sm select2-merkban form-equal-height">
                                    <option value="" disabled selected>--Pilih Merk Ban Depan Kiri--</option>
                                    <?php if(!empty($ho_merk_ban)) : ?>
                                        <?php foreach ($ho_merk_ban as $merkban) : ?>
                                            <?php $selected = old('ho_merkbantrkkndlm', $handoverdetails[0]['ho_merkbantrkkndlm'] ?? ($handoverdetails['ho_merkbantrkkndlm'] ?? '' )) == $merkban['mb_name'];?>
                                            <option <?= $selected ? 'selected' : '' ?> value="<?= esc($merkban['mb_name'])?>">
                                                <?= esc($merkban['mb_name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                        <hr>
                            <h3 class="text-center">Kondisi Velg Depan<span class="form-required" style="color: red;">*</span></h3>
                        <hr>
                        <div class="row">
                        <div class="col-md-6 mb-6 checkbox-group">
                            <label class="control-label">Velg Depan Kiri<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                 <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_velgdpnkr" id="velgdpnkr_bcap" value="Baik (Cap SSH)"
                                            onclick="handleCheckbox(this, ['velgdpnkr_bcap', 'velgdpnkr_rcap', 'velgdpnkr_btanpa', 'velgdpnkr_rtanpa'])"
                                                   <?= (old('ho_velgdpnkr', $handoverdetails[0]['ho_velgdpnkr'] ?? '') == 'Baik (Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="velgdpnkr_bcap">Baik <strong>(Ada Cap SSH)</strong></label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="ho_velgdpnkr" id="velgdpnkr_rcap" value="Rusak (Cap SSH)" 
                                            onclick="handleCheckbox(this, ['velgdpnkr_bcap', 'velgdpnkr_rcap', 'velgdpnkr_btanpa', 'velgdpnkr_rtanpa'])"
                                                   <?= (old('ho_velgdpnkr', $handoverdetails[0]['ho_velgdpnkr'] ?? '') == 'Rusak (Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="velgdpnkr_rcap">Rusak <strong>(Ada Cap SSH)</strong></label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_velgdpnkr" id="velgdpnkr_btanpa" value="Baik (Tanpa Cap SSH)" 
                                            onclick="handleCheckbox(this, ['velgdpnkr_bcap', 'velgdpnkr_rcap', 'velgdpnkr_btanpa', 'velgdpnkr_rtanpa'])"
                                                   <?= (old('ho_velgdpnkr', $handoverdetails[0]['ho_velgdpnkr'] ?? '') == 'Baik (Tanpa Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="velgdpnkr_btanpa">Baik <strong>(Tanpa Cap SSH)</strong></label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="ho_velgdpnkr" id="velgdpnkr_rtanpa" value="Rusak (Tanpa Cap SSH)" 
                                            onclick="handleCheckbox(this, ['velgdpnkr_bcap', 'velgdpnkr_rcap', 'velgdpnkr_btanpa' , 'velgdpnkr_rtanpa'])"
                                                   <?= (old('ho_velgdpnkr', $handoverdetails[0]['ho_velgdpnkr'] ?? '') == 'Rusak (Tanpa Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="velgdpnkr_rtanpa">Rusak <strong>(Tanpa Cap SSH)</strong></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-6">
                            <div class="form-group">
                                <label class="form-label">Merk/Ukuran Velg Depan Kiri<span class="form-required" style="color: red;">*</span></label>
                                <select id="ho_merkukuranvelgdpnkr" name="ho_merkukuranvelgdpnkr" for="ho_merkukuranvelgdpnkr" class="form-control form-control-sm select2-merkban form-equal-height">
                                    <option value="" disabled selected>--Pilih Merk Ukuran Velg Depan Kiri--</option>
                                    <?php if(!empty($ho_merk_velg)) : ?>
                                        <?php foreach ($ho_merk_velg as $merkvelg) : ?>
                                            <?php $selected = old('ho_merkukuranvelgdpnkr', $handoverdetails[0]['ho_merkukuranvelgdpnkr'] ?? ($handoverdetails['ho_merkukuranvelgdpnkr'] ?? '' )) == $merkvelg['mv_name'];?>
                                            <option <?= $selected ? 'selected' : '' ?> value="<?= esc($merkvelg['mv_name'])?>">
                                                <?= esc($merkvelg['mv_name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 mb-6 mt-3 checkbox-group">
                            <label class="control-label">Velg Depan Kanan<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                 <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_velgdpnkn" id="velgdpnkn_bcap" value="Baik (Cap SSH)"
                                            onclick="handleCheckbox(this, ['velgdpnkn_bcap', 'velgdpnkn_rcap', 'velgdpnkn_btanpa', 'velgdpnkn_rtanpa'])"
                                                   <?= (old('ho_velgdpnkn', $handoverdetails[0]['ho_velgdpnkn'] ?? '') == 'Baik (Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="velgdpnkn_bcap">Baik <strong>(Ada Cap SSH)</strong></label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="ho_velgdpnkn" id="velgdpnkn_rcap" value="Rusak (Cap SSH)" 
                                            onclick="handleCheckbox(this, ['velgdpnkn_bcap', 'velgdpnkn_rcap', 'velgdpnkn_btanpa', 'velgdpnkn_rtanpa'])"
                                                   <?= (old('ho_velgdpnkn', $handoverdetails[0]['ho_velgdpnkn'] ?? '') == 'Rusak (Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="velgdpnkn_rcap">Rusak <strong>(Ada Cap SSH)</strong></label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_velgdpnkn" id="velgdpnkn_btanpa" value="Baik (Tanpa Cap SSH)" 
                                            onclick="handleCheckbox(this, ['velgdpnkn_bcap', 'velgdpnkn_rcap', 'velgdpnkn_btanpa', 'velgdpnkn_rtanpa'])"
                                                   <?= (old('ho_velgdpnkn', $handoverdetails[0]['ho_velgdpnkn'] ?? '') == 'Baik (Tanpa Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="velgdpnkn_btanpa">Baik <strong>(Tanpa Cap SSH)</strong></label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="ho_velgdpnkn" id="velgdpnkn_rtanpa" value="Rusak (Tanpa Cap SSH)" 
                                            onclick="handleCheckbox(this, ['velgdpnkn_bcap', 'velgdpnkn_rcap', 'velgdpnkn_btanpa' , 'velgdpnkn_rtanpa'])"
                                                   <?= (old('ho_velgdpnkn', $handoverdetails[0]['ho_velgdpnkn'] ?? '') == 'Rusak (Tanpa Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="velgdpnkn_rtanpa">Rusak <strong>(Tanpa Cap SSH)</strong></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-6 mt-3">
                            <div class="form-group">
                                <label class="form-label">Merk/Ukuran Velg Depan Kanan<span class="form-required" style="color: red;">*</span></label>
                                <select id="ho_merkukuranvelgdpnkn" name="ho_merkukuranvelgdpnkn" for="ho_merkukuranvelgdpnkn" class="form-control form-control-sm select2-merkban form-equal-height">
                                    <option value="" disabled selected>--Pilih Merk Ukuran Velg Depan Kanan--</option>
                                    <?php if(!empty($ho_merk_velg)) : ?>
                                        <?php foreach ($ho_merk_velg as $merkvelg) : ?>
                                            <?php $selected = old('ho_merkukuranvelgdpnkn', $handoverdetails[0]['ho_merkukuranvelgdpnkn'] ?? ($handoverdetails['ho_merkukuranvelgdpnkn'] ?? '' )) == $merkvelg['mv_name'];?>
                                            <option <?= $selected ? 'selected' : '' ?> value="<?= esc($merkvelg['mv_name'])?>">
                                                <?= esc($merkvelg['mv_name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                        <hr>
                            <h3 class="text-center">Kondisi Velg Belakang<span class="form-required" style="color: red;">*</span></h3>
                        <hr>
                        <div class="row">
                         <div class="col-md-3 mb-4 checkbox-group">
                        <label class="control-label">Velg Belakang Kiri Luar<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_velgblkkrlr" id="velgblkkrlr_bcap" value="Baik (Ada Cap SSH)"
                                            onclick="handleCheckbox(this, ['velgblkkrlr_bcap', 'velgblkkrlr_rcap', 'velgblkkrlr_btanpa', 'velgblkkrlr_rtanpa'])"
                                                   <?= (old('ho_velgblkkrlr', $handoverdetails[0]['ho_velgblkkrlr'] ?? '') == 'Baik (Ada Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="velgblkkrlr_bcap">Baik <strong>(Ada Cap SSH)</strong></label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_velgblkkrlr" id="velgblkkrlr_rcap" value="Rusak (Ada Cap SSH)"
                                            onclick="handleCheckbox(this, ['velgblkkrlr_bcap', 'velgblkkrlr_rcap', 'velgblkkrlr_btanpa', 'velgblkkrlr_rtanpa'])"
                                                   <?= (old('ho_velgblkkrlr', $handoverdetails[0]['ho_velgblkkrlr'] ?? '') == 'Rusak (Ada Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="velgblkkrlr_rcap">Rusak <strong>(Ada Cap SSH)</strong></label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_velgblkkrlr" id="velgblkkrlr_btanpa" value="Baik (Tanpa Cap SSH)" 
                                            onclick="handleCheckbox(this, ['velgblkkrlr_bcap', 'velgblkkrlr_rcap', 'velgblkkrlr_btanpa', 'velgblkkrlr_rtanpa'])"
                                                   <?= (old('ho_velgblkkrlr', $handoverdetails[0]['ho_velgblkkrlr'] ?? '') == 'Baik (Tanpa Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="velgblkkrlr_btanpa">Baik <strong>(Tanpa Cap SSH)</strong></label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_velgblkkrlr" id="velgblkkrlr_rtanpa" value="Rusak (Tanpa Cap SSH)" 
                                            onclick="handleCheckbox(this, ['velgblkkrlr_bcap', 'velgblkkrlr_rcap', 'velgblkkrlr_btanpa', 'velgblkkrlr_rtanpa'])"
                                                   <?= (old('ho_velgblkkrlr', $handoverdetails[0]['ho_velgblkkrlr'] ?? '') == 'Rusak (Tanpa Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="velgblkkrlr_rtanpa">Rusak <strong>(Tanpa Cap SSH)</strong></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4">
                            <div class="form-group">
                                <label class="form-label">Merk/Ukuran Velg Belakang Kiri Luar<span class="form-required" style="color: red;">*</span></label>
                                <select id="ho_merkukuranvelgblkkrlr" name="ho_merkukuranvelgblkkrlr" for="ho_merkukuranvelgblkkrlr" class="form-control form-control-sm select2-merkban form-equal-height">
                                    <option value="" disabled selected>--Pilih Merk Ukuran Velg Belakang Kiri Luar--</option>
                                    <?php if(!empty($ho_merk_velg)) : ?>
                                        <?php foreach ($ho_merk_velg as $merkvelg) : ?>
                                            <?php $selected = old('ho_merkukuranvelgblkkrlr', $handoverdetails[0]['ho_merkukuranvelgblkkrlr'] ?? ($handoverdetails['ho_merkukuranvelgblkkrlr'] ?? '' )) == $merkvelg['mv_name'];?>
                                            <option <?= $selected ? 'selected' : '' ?> value="<?= esc($merkvelg['mv_name'])?>">
                                                <?= esc($merkvelg['mv_name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4 checkbox-group">
                        <label class="control-label">Velg Belakang Kanan Luar<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_velgblkknlr" id="velgblkknlr_bcap" value="Baik (Ada Cap SSH)"
                                            onclick="handleCheckbox(this, ['velgblkknlr_bcap', 'velgblkknlr_rcap', 'velgblkknlr_btanpa', 'velgblkknlr_rtanpa'])"
                                                   <?= (old('ho_velgblkknlr', $handoverdetails[0]['ho_velgblkknlr'] ?? '') == 'Baik (Ada Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="velgblkknlr_bcap">Baik <strong>(Ada Cap SSH)</strong></label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_velgblkknlr" id="velgblkknlr_rcap" value="Rusak (Ada Cap SSH)"
                                            onclick="handleCheckbox(this, ['velgblkknlr_bcap', 'velgblkknlr_rcap', 'velgblkknlr_btanpa', 'velgblkknlr_rtanpa'])"
                                                   <?= (old('ho_velgblkknlr', $handoverdetails[0]['ho_velgblkknlr'] ?? '') == 'Rusak (Ada Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="velgblkknlr_rcap">Rusak <strong>(Ada Cap SSH)</strong></label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_velgblkknlr" id="velgblkknlr_btanpa" value="Baik (Tanpa Cap SSH)" 
                                            onclick="handleCheckbox(this, ['velgblkknlr_bcap', 'velgblkknlr_rcap', 'velgblkknlr_btanpa', 'velgblkknlr_rtanpa'])"
                                                   <?= (old('ho_velgblkknlr', $handoverdetails[0]['ho_velgblkknlr'] ?? '') == 'Baik (Tanpa Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="velgblkknlr_btanpa">Baik <strong>(Tanpa Cap SSH)</strong></label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_velgblkknlr" id="velgblkknlr_rtanpa" value="Rusak (Tanpa Cap SSH)" 
                                            onclick="handleCheckbox(this, ['velgblkknlr_bcap', 'velgblkknlr_rcap', 'velgblkknlr_btanpa', 'velgblkknlr_rtanpa'])"
                                                   <?= (old('ho_velgblkknlr', $handoverdetails[0]['ho_velgblkknlr'] ?? '') == 'Rusak (Tanpa Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="velgblkknlr_rtanpa">Rusak <strong>(Tanpa Cap SSH)</strong></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4">
                            <div class="form-group">
                                <label class="form-label">Merk/Ukuran Velg Belakang Kanan Luar<span class="form-required" style="color: red;">*</span></label>
                                <select id="ho_merkukuranvelgblknlr" name="ho_merkukuranvelgblknlr" for="ho_merkukuranvelgblknlr" class="form-control form-control-sm select2-merkban form-equal-height">
                                    <option value="" disabled selected>--Pilih Merk Ukuran Velg Belakang Kanan Luar--</option>
                                    <?php if(!empty($ho_merk_velg)) : ?>
                                        <?php foreach ($ho_merk_velg as $merkvelg) : ?>
                                            <?php $selected = old('ho_merkukuranvelgblknlr', $handoverdetails[0]['ho_merkukuranvelgblknlr'] ?? ($handoverdetails['ho_merkukuranvelgblknlr'] ?? '' )) == $merkvelg['mv_name'];?>
                                            <option <?= $selected ? 'selected' : '' ?> value="<?= esc($merkvelg['mv_name'])?>">
                                                <?= esc($merkvelg['mv_name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4 checkbox-group">
                        <label class="control-label">Velg Belakang Kiri Dalam<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_velgblkkrdlm" id="velgblkkrdlm_bcap" value="Baik (Ada Cap SSH)"
                                            onclick="handleCheckbox(this, ['velgblkkrdlm_bcap', 'velgblkkrdlm_rcap', 'velgblkkrdlm_btanpa', 'velgblkkrdlm_rtanpa'])"
                                                   <?= (old('ho_velgblkkrdlm', $handoverdetails[0]['ho_velgblkkrdlm'] ?? '') == 'Baik (Ada Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="velgblkkrdlm_bcap">Baik <strong>(Ada Cap SSH)</strong></label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_velgblkkrdlm" id="velgblkkrdlm_rcap" value="Rusak (Ada Cap SSH)"
                                            onclick="handleCheckbox(this, ['velgblkkrdlm_bcap', 'velgblkkrdlm_rcap', 'velgblkkrdlm_btanpa', 'velgblkkrdlm_rtanpa'])"
                                                   <?= (old('ho_velgblkkrdlm', $handoverdetails[0]['ho_velgblkkrdlm'] ?? '') == 'Rusak (Ada Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="velgblkkrdlm_rcap">Rusak <strong>(Ada Cap SSH)</strong></label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_velgblkkrdlm" id="velgblkkrdlm_btanpa" value="Baik (Tanpa Cap SSH)" 
                                            onclick="handleCheckbox(this, ['velgblkkrdlm_bcap', 'velgblkkrdlm_rcap', 'velgblkkrdlm_btanpa', 'velgblkkrdlm_rtanpa'])"
                                                   <?= (old('ho_velgblkkrdlm', $handoverdetails[0]['ho_velgblkkrdlm'] ?? '') == 'Baik (Tanpa Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="velgblkkrdlm_btanpa">Baik <strong>(Tanpa Cap SSH)</strong></label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_velgblkkrdlm" id="velgblkkrdlm_rtanpa" value="Rusak (Tanpa Cap SSH)" 
                                            onclick="handleCheckbox(this, ['velgblkkrdlm_bcap', 'velgblkkrdlm_rcap', 'velgblkkrdlm_btanpa', 'velgblkkrdlm_rtanpa'])"
                                                   <?= (old('ho_velgblkkrdlm', $handoverdetails[0]['ho_velgblkkrdlm'] ?? '') == 'Rusak (Tanpa Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="velgblkkrdlm_rtanpa">Rusak <strong>(Tanpa Cap SSH)</strong></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4">
                            <div class="form-group">
                                <label class="form-label">Merk/Ukuran Velg Belakang Kiri Dalam<span class="form-required" style="color: red;">*</span></label>
                                <select id="ho_merkukuranvelgblkkrdlm" name="ho_merkukuranvelgblkkrdlm" for="ho_merkukuranvelgblkkrdlm" class="form-control form-control-sm select2-merkban form-equal-height">
                                    <option value="" disabled selected>--Pilih Merk Ukuran Velg Belakang Kiri Dalam--</option>
                                    <?php if(!empty($ho_merk_velg)) : ?>
                                        <?php foreach ($ho_merk_velg as $merkvelg) : ?>
                                            <?php $selected = old('ho_merkukuranvelgblkkrdlm', $handoverdetails[0]['ho_merkukuranvelgblkkrdlm'] ?? ($handoverdetails['ho_merkukuranvelgblkkrdlm'] ?? '' )) == $merkvelg['mv_name'];?>
                                            <option <?= $selected ? 'selected' : '' ?> value="<?= esc($merkvelg['mv_name'])?>">
                                                <?= esc($merkvelg['mv_name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4 checkbox-group">
                        <label class="control-label">Velg Belakang Kanan Dalam<span class="form-required" style="color: red;">*</span></label>
                            <div class="border p-3 rounded d-flex flex-column">
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_velgblkkndlm" id="velgblkkndlm_bcap" value="Baik (Ada Cap SSH)"
                                            onclick="handleCheckbox(this, ['velgblkkndlm_bcap', 'velgblkkndalm_rcap', 'velgblkkndlm_btanpa', 'velgblkkndlm_rtanpa'])"
                                                   <?= (old('ho_velgblkkndlm', $handoverdetails[0]['ho_velgblkkndlm'] ?? '') == 'Baik (Ada Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="velgblkkndlm_bcap">Baik <strong>(Ada Cap SSH)</strong></label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_velgblkkndlm" id="velgblkkndalm_rcap" value="Rusak (Ada Cap SSH)"
                                            onclick="handleCheckbox(this, ['velgblkkndlm_bcap', 'velgblkkndalm_rcap', 'velgblkkndlm_btanpa', 'velgblkkndlm_rtanpa'])"
                                                   <?= (old('ho_velgblkkndlm', $handoverdetails[0]['ho_velgblkkndlm'] ?? '') == 'Rusak (Ada Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="velgblkkndalm_rcap">Rusak <strong>(Ada Cap SSH)</strong></label>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_velgblkkndlm" id="velgblkkndlm_btanpa" value="Baik (Tanpa Cap SSH)" 
                                            onclick="handleCheckbox(this, ['velgblkkndlm_bcap', 'velgblkkndalm_rcap', 'velgblkkndlm_btanpa', 'velgblkkndlm_rtanpa'])"
                                                   <?= (old('ho_velgblkkndlm', $handoverdetails[0]['ho_velgblkkndlm'] ?? '') == 'Baik (Tanpa Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="velgblkkndlm_btanpa">Baik <strong>(Tanpa Cap SSH)</strong></label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px;">
                                        <input class="form-check-input" type="checkbox" name="ho_velgblkkndlm" id="velgblkkndlm_rtanpa" value="Rusak (Tanpa Cap SSH)" 
                                            onclick="handleCheckbox(this, ['velgblkkndlm_bcap', 'velgblkkndalm_rcap', 'velgblkkndlm_btanpa', 'velgblkkndlm_rtanpa'])"
                                                   <?= (old('ho_velgblkkndlm', $handoverdetails[0]['ho_velgblkkndlm'] ?? '') == 'Rusak (Tanpa Cap SSH)') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="velgblkkndlm_rtanpa">Rusak <strong>(Tanpa Cap SSH)</strong></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4">
                            <div class="form-group">
                                <label class="form-label">Merk/Ukuran Velg Belakang Kanan Dalam<span class="form-required" style="color: red;">*</span></label>
                                <select id="ho_merkukuranvelgblkndlm" name="ho_merkukuranvelgblkndlm" for="ho_merkukuranvelgblkndlm" class="form-control form-control-sm select2-merkban form-equal-height">
                                    <option value="" disabled selected>--Pilih Merk Ukuran Velg Belakang Kanan Dalam--</option>
                                    <?php if(!empty($ho_merk_velg)) : ?>
                                        <?php foreach ($ho_merk_velg as $merkvelg) : ?>
                                            <?php $selected = old('ho_merkukuranvelgblkndlm', $handoverdetails[0]['ho_merkukuranvelgblkndlm'] ?? ($handoverdetails['ho_merkukuranvelgblkndlm'] ?? '' )) == $merkvelg['mv_name'];?>
                                            <option <?= $selected ? 'selected' : '' ?> value="<?= esc($merkvelg['mv_name'])?>">
                                                <?= esc($merkvelg['mv_name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                
                    <div class="col-sm-6 col-md-12">
                        <div class="form-group">
                            <label class="form-label">Keterangan</label>
                            <textarea class="form-control" autocomplete="off" placeholder="Catatan" name="ho_keterangan"><?= old('ho_keterangan', $handoverdetails[0]['ho_keterangan'] ?? ($handoverdetails['ho_keterangan'] ?? '')) ?></textarea>
                        </div>
                    </div>
                </div>

                    <?php if (isset($handoverdetails)) : ?>
                    <div class="border p-3 rounded">
                        <div class="form-group">
                            <div class="text-center">
                                <label>Foto Sebelumnya</label>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <?php
                                        $foto = isset($handoverdetails[0]['foto']) ? $handoverdetails[0]['foto'] : '';
                                        $foto_path = !empty($foto) ? 'assets/uploads/vehicle_handover/' . $foto : 'assets/uploads/user.png';
                                        if (!empty($foto) && file_exists($foto_path)) {
                                            $foto_url = base_url($foto_path) . '?' . time();
                                        } else {
                                            $foto_url = base_url('assets/uploads/user.png');
                                        }
                                        echo '<img src="' . $foto_url . '" class="img-fluid img-thumbnail" id="previous_photo" data-foto="' . $foto . '" style="max-width: 400px; max-height: 300px;">';
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <hr style="border: 0; height: 1px; background-color: black;">

                <div class="form-group">
                    <div class="text-center">
                        <label>Foto Serah Terima</label>
                        <div class="text-center">
                            <button id="global_switch_camera" class="btn btn-success" type="button">Switch Camera</button>
                        </div>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-md-12 text-center">
                        <button type="button" id="take_photo" class="btn btn-primary">Ambil Foto</button>
                        <button type="button" id="retake_photo" class="btn btn-secondary" style="display:none;">Foto Ulang</button>
                        <canvas id="photo_canvas" style="display:none;"></canvas>
                        <video id="photo_video" style="max-width: 100%; max-height: 300px;" autoplay playsinline 
       webkit-playsinline></video>
                        <div>Preview Foto</div>
                        <img id="photo_preview" style="max-width: 400px; max-height: 300px; margin-bottom: 30px;" /></img>
                    </div>
                </div>
                
                <input type="hidden" id="ho_modified_date" name="ho_modified_date" value="<?= date('Y-m-d H:i:s') ?>">
                <input type="hidden" id="photo_data" name="photo_data">
                
                <div class="mb-3 card-footer d-flex">
                    <a href="<?= base_url('handover/handover_management') ?>" class="btn btn-warning" onclick="return confirmCancel()">
                        <i class="fa fa-left"></i> CANCEL
                    </a>
                    <button type="submit" class="btn btn-primary ml-auto" id="submitBtn"><?= (isset($handoverdetails)) ? 'NEXT' : 'NEXT' ?></button>
                </div>
            </div>
        </form>
    </div>

    <div class="modal fade" id="confirmInventoryModal" tabindex="-1" role="dialog" aria-labelledby="confirmInventoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title" id="confirmInventoryModalLabel">
                    <i class="fa fa-info-circle"></i> Confirmation
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div class="alert alert-info">
                    <h6 class="alert-heading">Silahkan Cek Inventaris!</h6>
                    <p class="mb-0">Sebelum menyelesaikan proses serah terima, harap periksa inventaris kendaraan terlebih dahulu.</p>
                </div>
                <p>Apakah Anda ingin melanjutkan ke pengecekan inventaris?</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i> Cancel
                </button>
                <button type="button" class="btn btn-primary" id="confirmProceedBtn">
                    <i class="fa fa-check"></i> Yes
                </button>
            </div>
        </div>
    </div>
</div>
</section>
<?= view('layout/footer') ?>

<script src="<?= base_url('assets/autoLogout.js') ?>"></script>
<script>
    const baseUrl = "<?= base_url() ?>"; 
    enableAutoLogout(7200, baseUrl + "login");

    $(document).ready(function() {
        let videoStream = null;
        let facingMode = "environment";

        function stopStream() {
            if (videoStream) {
                let tracks = videoStream.getTracks();
                tracks.forEach((track) => track.stop());
                videoStream = null;
            }
        }

        function startCamera() {
            const videoElement = document.getElementById('photo_video');
            const constraints = {
                video: { facingMode: facingMode }
            };

            navigator.mediaDevices
                .getUserMedia(constraints)
                .then(function (stream) {
                    videoStream = stream;
                    videoElement.srcObject = stream;
                    videoElement.play();
                })
                .catch(function (error) {
                    console.error('Tidak dapat mengakses kamera:', error);
                });
        }

        $('#take_photo').click(function () {
            const videoElement = document.getElementById('photo_video');
            const canvasElement = document.getElementById('photo_canvas');
            const context = canvasElement.getContext("2d");
            
            canvasElement.width = videoElement.videoWidth;
            canvasElement.height = videoElement.videoHeight;
            
            context.drawImage(videoElement, 0, 0, canvasElement.width, canvasElement.height);
            const photoData = canvasElement.toDataURL("image/png");

            $('#photo_preview').attr("src", photoData);
            $('#retake_photo').show();
            $('#take_photo').hide();
            $('#photo_data').val(photoData);
            
            stopStream();
            $('#photo_video').hide();
        });

        $('#retake_photo').click(function () {
            $('#take_photo').show();
            $('#retake_photo').hide();
            $('#photo_preview').attr("src", "");
            $('#photo_data').val('');
            
            $('#photo_video').show();
            startCamera();
        });

        $("#global_switch_camera").click(function () {
            facingMode = facingMode === "environment" ? "user" : "environment";

            stopStream();
            startCamera();
        });

        document.addEventListener('DOMContentLoaded', function () {
            startCamera();
                function updateDateTime() {
                    const now = new Date();
                    const year = now.getFullYear();
                    const month = String(now.getMonth() + 1).padStart(2, '0');
                    const day = String(now.getDate()).padStart(2, '0');
                    const hours = String(now.getHours()).padStart(2, '0');
                    const minutes = String(now.getMinutes()).padStart(2, '0');
                    const seconds = String(now.getSeconds()).padStart(2, '0');
                    
                    document.getElementById('ho_modified_date').value = 
                        `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
                }
            setInterval(updateDateTime, 1000);
        });

        $('input[type="text"]').on('change', function() {
            $(this).valid();
        });

        $('input[type="checkbox"]').on('change', function() {
            $(this).valid();
        });

        $('.select2-vehicle').on('change', function() {
            $(this).valid();
            updateNOPOL();
        });

        $('.select2-driver1').on('change', function() {
            $(this).valid();
        });

        $('.select2-driver2').on('change', function() {
            $(this).valid();
        });
        
        $('.select2-merkban').on('change', function() {
            $(this).valid();
        });

        $('.select2-vehicle').select2({
                placeholder: "-- Pilih Mobil --",
                allowClear: true
            });
        $('.select2-driver1').select2({
                placeholder: "-- Pilih Supir --",
                allowClear: true
            });
        $('.select2-driver2').select2({
                placeholder: "-- Pilih Supir --",
                allowClear: true
            });
        $('.select2-merkban').select2({
                placeholder: "-- Pilih Merk Ban --",
                allowClear: true
            });
        });

    function validateAndShowModal(event) {
        event.preventDefault();
        
        var form = $('#handover_add');
        if (!form.valid()) {
            return false;
        }
        $('#confirmInventoryModal').modal('show');
        return false;
    }

    document.getElementById('confirmProceedBtn').addEventListener('click', function() {
        $('#confirmInventoryModal').modal('hide');
        $('#submitBtn').prop('disabled', true)
                      .html('<i class="fa fa-spinner fa-spin"></i> Processing...');
        
        var form = document.getElementById('handover_add');
        var formData = new FormData(form);
        
        form.submit();
    });

    $('#confirmInventoryModal').on('hidden.bs.modal', function () {
        $('#submitBtn').prop('disabled', false)
                      .html('<?= (isset($handoverdetails)) ? 'NEXT' : 'NEXT' ?>');
    });

    document.addEventListener('DOMContentLoaded', function() {
        const oldInput = <?= json_encode(session()->getFlashdata('old_input') ?: []) ?>;
        
        if (Object.keys(oldInput).length > 0) {
            if (oldInput.ho_tanggal) {
                document.querySelector('input[name="ho_tanggal"]').value = oldInput.ho_tanggal;
            }
            
            if (oldInput.ho_lokasi) {
                const lokasiCheckboxes = document.querySelectorAll('input[name="ho_lokasi"]');
                lokasiCheckboxes.forEach(checkbox => {
                    if (checkbox.value === oldInput.ho_lokasi) {
                        checkbox.checked = true;
                    }
                });
            }
            
            if (oldInput.ho_nopol) {
                document.querySelector('select[name="ho_nopol"]').value = oldInput.ho_nopol;
                const event = new Event('change');
                document.querySelector('select[name="ho_nopol"]').dispatchEvent(event);
            }
            
            if (oldInput.ho_km) {
                document.querySelector('input[name="ho_km"]').value = oldInput.ho_km;
            }
            
            if (oldInput.ho_solar) {
                document.querySelector('input[name="ho_solar"]').value = oldInput.ho_solar;
            }
            
            if (oldInput.ho_supirlama) {
                document.querySelector('select[name="ho_supirlama"]').value = oldInput.ho_supirlama;
                const event = new Event('change');
                document.querySelector('select[name="ho_supirlama"]').dispatchEvent(event);
            }
            
            if (oldInput.ho_supirbaru) {
                document.querySelector('select[name="ho_supirbaru"]').value = oldInput.ho_supirbaru;
                const event = new Event('change');
                document.querySelector('select[name="ho_supirbaru"]').dispatchEvent(event);
            }

            if (oldInput.ho_merkbankr) {
                document.querySelector('select[name="ho_merkbankr"]').value = oldInput.ho_merkbankr;
            }

            if (oldInput.ho_merkbankn) {
                document.querySelector('select[name="ho_merkbankn"]').value = oldInput.ho_merkbankn;
            }

            if (oldInput.ho_merkbankrlr) {
                document.querySelector('select[name="ho_merkbankrlr"]').value = oldInput.ho_merkbankrlr;
            }

            if (oldInput.ho_merkbanknlr) {
                document.querySelector('select[name="ho_merkbanknlr"]').value = oldInput.ho_merkbanknlr;
            }

            if (oldInput.ho_merkbankrdlm) {
                document.querySelector('select[name="ho_merkbankrdlm"]').value = oldInput.ho_merkbankrdlm;
            }

            if (oldInput.ho_merkbankndlm) {
                document.querySelector('select[name="ho_merkbankndlm"]').value = oldInput.ho_merkbankndlm;
            }

            if (oldInput.ho_merkbantrkkrlr) {
                document.querySelector('select[name="ho_merkbantrkkrlr"]').value = oldInput.ho_merkbantrkkrlr;
            }

            if (oldInput.ho_merkbantrkknlr) {
                document.querySelector('select[name="ho_merkbantrkknlr"]').value = oldInput.ho_merkbantrkknlr;
            }

            if (oldInput.ho_merkbantrkkrdlm) {
                document.querySelector('select[name="ho_merkbantrkkrdlm"]').value = oldInput.ho_merkbantrkkrdlm;
            }

            if (oldInput.ho_merkbantrkkndlm) {
                document.querySelector('select[name="ho_merkbantrkkndlm"]').value = oldInput.ho_merkbantrkkndlm;
            }

            if (oldInput.ho_merkukuranvelgdpnkr) {
                document.querySelector('input[name="ho_merkukuranvelgdpnkr"]').value = oldInput.ho_merkukuranvelgdpnkr;
            }

            if (oldInput.ho_merkukuranvelgdpnkn) {
                document.querySelector('input[name="ho_merkukuranvelgdpnkn"]').value = oldInput.ho_merkukuranvelgdpnkn;
            }

            if (oldInput.ho_merkukuranvelgblkkrlr) {
                document.querySelector('input[name="ho_merkukuranvelgblkkrlr"]').value = oldInput.ho_merkukuranvelgblkkrlr;
            }

            if (oldInput.ho_merkukuranvelgblknlr) {
                document.querySelector('input[name="ho_merkukuranvelgblknlr"]').value = oldInput.ho_merkukuranvelgblknlr;
            }

            if (oldInput.ho_merkukuranvelgblkkrdlm) {
                document.querySelector('input[name="ho_merkukuranvelgblkkrdlm"]').value = oldInput.ho_merkukuranvelgblkkrdlm;
            }

            if (oldInput.ho_merkukuranvelgblkndlm) {
                document.querySelector('input[name="ho_merkukuranvelgblkndlm"]').value = oldInput.ho_merkukuranvelgblkndlm;
            }
            
            if (oldInput.ho_keterangan) {
                document.querySelector('textarea[name="ho_keterangan"]').value = oldInput.ho_keterangan;
            }
            
            if (oldInput.photo_data) {
                document.querySelector('#photo_data').value = oldInput.photo_data;
                document.querySelector('#photo_preview').src = oldInput.photo_data;
                document.querySelector('#photo_preview').style.display = 'block';
                document.querySelector('#take_photo').style.display = 'none';
                document.querySelector('#retake_photo').style.display = 'inline-block';
                document.querySelector('#photo_video').style.display = 'none';
                
                if (window.videoStream) {
                    window.videoStream.getTracks().forEach(track => track.stop());
                }
            }
            
            alert_toast('Data handover sebelumnya telah dikembalikan ke form', 'success');
        }
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

    function updateNIS() {
        const driverLamaSelect = document.getElementById('ho_supirlama');
        const selectedOptionLama = driverLamaSelect.options[driverLamaSelect.selectedIndex];
        const nisLama = selectedOptionLama.getAttribute('data-nis');
        document.getElementById('ho_nislama').value = nisLama || '';

        const driverBaruSelect = document.getElementById('ho_supirbaru');
        const selectedOptionBaru = driverBaruSelect.options[driverBaruSelect.selectedIndex];
        const nisBaru = selectedOptionBaru.getAttribute('data-nis');
        document.getElementById('ho_nisbaru').value = nisBaru || '';
    }

    function updateNOPOL() {
        const inventorySelect = document.getElementById('ho_nopol');
        const selectedOption = inventorySelect.options[inventorySelect.selectedIndex];  
        const jenisMobil = selectedOption.getAttribute('data-jenis');
        const tahunMobil = selectedOption.getAttribute('data-tahun');
            
        document.getElementById('ho_jenis').value = jenisMobil || '';
    }
    
    function updateMerkban() {
        const inventorySelect = document.getElementById('ho_merkbankr', 'ho_merkbankn', 'ho_merkbankrlr', 'ho_merkbanknlr', 'ho_merkbankrdlm', 'ho_merkbankndlm', 'ho_merkbantrkkrlr', 'ho_merkbantrkknlr', 'ho_merkbantrkkrdlm', 'ho_merkbantrkkndlm');
        const selectedOption = inventorySelect.options[inventorySelect.selectedIndex];  
        const merkban = selectedOption.getAttribute('ho_merkbankr', 'ho_merkbankn', 'ho_merkbankrlr', 'ho_merkbanknlr', 'ho_merkbankrdlm', 'ho_merkbankndlm', 'ho_merkbantrkkrlr', 'ho_merkbantrkknlr', 'ho_merkbantrkkrdlm', 'ho_merkbantrkkndlm');
            
        document.getElementById('ho_jenis').value = jenisMobil || '';
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
    
    window.addEventListener('load', function() {
    var loader = document.getElementById('loading-screen');
    if (loader) {
      loader.classList.add('fade-out');
      setTimeout(function() {
        loader.style.display = 'none';
      }, 500);
    }
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
    .checkbox-group.is-invalid .border {
        border: 1px solid #dc3545 !important;
    }
    @keyframes highlight {
        0% { background-color: rgba(255, 255, 0, 0.3); }
        100% { background-color: transparent; }
    }
</style>