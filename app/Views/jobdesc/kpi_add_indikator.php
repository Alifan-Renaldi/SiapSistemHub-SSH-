<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<?php $isEdit = isset($kpi) && !empty($kpi); ?>
<?php $hasNilai = $isEdit && ($kpi['jk_nilai_1'] !== null); ?>
<?php
function kpi_indikator_terisi($value)
{
    return $value !== null && $value !== '';
}
?>

<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?= $isEdit ? 'Edit Indikator KPI' : 'Tambah Indikator KPI'; ?></h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
               <li class="breadcrumb-item"><a href="<?= base_url('jobdesc/kpi_management'); ?>">KPI Management</a></li>
               <li class="breadcrumb-item active"><?= $isEdit ? 'Edit Indikator KPI' : 'Tambah Indikator KPI'; ?></li>
            </ol>
         </div>
      </div>
   </div>
</div>

<section class="content">
   <div class="container-fluid">
      <form method="post" id="addindikator" class="card"
            action="<?= base_url('jobdesc/' . ($isEdit ? 'update_indikator' : 'insert_indikator')); ?>">
         <?= csrf_field() ?>
         <div class="card-body">
            <?php if ($isEdit) : ?>
            <input type="hidden" name="jk_id" id="jk_id" value="<?= esc($kpi['jk_id']); ?>">
            <?php endif; ?>

            <div class="row">
               <div class="col-sm-6 col-md-6">
                  <label class="form-label">Nama Divisi</label>
                  <div class="form-group">
                     <input type="text" name="jk_divisi" id="jk_divisi" required class="form-control" placeholder="Nama Divisi"
                            value="<?= $isEdit ? esc($kpi['jk_divisi']) : ''; ?>">
                  </div>
               </div>
               <div class="col-sm-6 col-md-6">
                  <label class="form-label">Nama Karyawan</label>
                  <div class="form-group">
                     <input type="text" name="jk_nama_karyawan" id="jk_nama_karyawan" required class="form-control" placeholder="Nama Karyawan"
                            value="<?= $isEdit ? esc($kpi['jk_nama_karyawan']) : ''; ?>">
                  </div>
               </div>
            </div>

            <hr>
            <div class="d-flex justify-content-between align-items-center mb-2">
               <div class="form-label"><b><?= $hasNilai ? 'Detail, Bobot &amp; Nilai Indikator' : 'Detail &amp; Bobot Indikator'; ?></b></div>
               <div class="text-right">
                  <?php if ($hasNilai) : ?>
                  <span id="total-kpi-preview" class="badge badge-secondary mr-2" style="font-size: 1em;">Preview Total KPI: <?= number_format((float) $kpi['jk_total_kpi'], 2); ?></span>
                  <?php endif; ?>
                  <span id="indikator-count" class="badge badge-info mr-2" style="font-size: 1em;">0 Indikator</span>
                  <span class="form-label"><b>Total Bobot: </b></span>
                  <span id="total-bobot" class="badge badge-danger" style="font-size: 1em;">0 / 100</span>
               </div>
            </div>
            <small class="text-muted d-block mb-1">Indikator diisi berurutan mulai dari Indikator 1 — minimal 5 dan maksimal 12 indikator. Baris yang tidak dipakai biarkan kosong.</small>
            <small class="text-muted d-block mb-2">Bobot nilai memakai skala 1 - 100 (contoh: 80 menjadi 0.8) dan total bobot indikator terisi harus tepat 100.<?= $hasNilai ? ' Nilai konversi = nilai indikator &times; bobot indikator.' : ''; ?></small>
            <div id="indikator-warning" class="text-danger small mb-2"></div>

            <?php for ($i = 1; $i <= 12; $i++) :
               $rowTerisi = $isEdit && kpi_indikator_terisi($kpi['jk_indikator_' . $i]);
               $bobotValue = ($isEdit && $kpi['jk_bobot_' . $i] !== null) ? round((float) $kpi['jk_bobot_' . $i] * 100, 2) : '';
               $nilaiValue = ($hasNilai && $rowTerisi) ? (float) $kpi['jk_nilai_' . $i] : '';
            ?>
            <div class="row align-items-center mb-2" id="row_<?= $i; ?>">
               <div class="col-sm-12 <?= $hasNilai ? 'col-md-4' : 'col-md-6'; ?>">
                  <div class="form-group mb-md-0">
                     <label class="form-label">Detail Indikator <?= $i; ?></label>
                     <input type="text" name="jk_indikator_<?= $i; ?>" id="jk_indikator_<?= $i; ?>" class="form-control indikator-input"
                            placeholder="Detail Indikator <?= $i; ?>"
                            value="<?= $isEdit ? esc($kpi['jk_indikator_' . $i]) : ''; ?>">
                  </div>
               </div>
               <div class="col-sm-<?= $hasNilai ? '6' : '8'; ?> <?= $hasNilai ? 'col-md-2' : 'col-md-3'; ?>">
                  <div class="form-group mb-0">
                     <label class="form-label">Bobot Nilai <?= $i; ?></label>
                     <input type="number" name="jk_bobot_<?= $i; ?>" id="jk_bobot_<?= $i; ?>"
                            class="form-control bobot-input" min="1" max="100" step="0.01"
                            placeholder="1 - 100"
                            value="<?= $bobotValue !== '' ? esc($bobotValue) : ''; ?>">
                     <small class="text-muted">= <span id="preview_<?= $i; ?>"><?= $bobotValue !== '' ? number_format((float) $bobotValue / 100, 2) : '-'; ?></span></small>
                  </div>
               </div>
               <?php if ($hasNilai) : ?>
               <div class="col-sm-6 col-md-2" id="nilai-wrap_<?= $i; ?>" <?= $rowTerisi ? '' : 'style="display: none;"'; ?>>
                  <div class="form-group mb-0">
                     <label class="form-label">Nilai Indikator <?= $i; ?></label>
                     <input type="number" name="jk_nilai_<?= $i; ?>" id="jk_nilai_<?= $i; ?>"
                            class="form-control nilai-edit-input" min="1" max="100" step="0.01"
                            placeholder="1 - 100"
                            value="<?= $nilaiValue !== '' ? esc($nilaiValue) : ''; ?>">
                  </div>
               </div>
               <div class="col-sm-12 col-md-4">
                  <span class="form-label text-muted">Konversi: <b id="konversi_<?= $i; ?>"><?= $rowTerisi ? number_format((float) $kpi['jk_nilai_' . $i] * (float) $kpi['jk_bobot_' . $i], 2) : '-'; ?></b></span>
               </div>
               <?php endif; ?>
            </div>
            <?php endfor; ?>
         </div>

         <div class="card-footer d-flex">
            <a href="<?= base_url('jobdesc/kpi_management'); ?>" class="btn btn-warning">
               <i class="fa fa-arrow-left"></i> CANCEL
            </a>
            <button type="submit" id="submit-btn" class="btn btn-primary ml-auto" disabled>
               <i class="fa fa-save"></i> <?= $isEdit ? 'UPDATE' : 'SAVE'; ?>
            </button>
         </div>
         <br>
      </form>
   </div>
</section>
<?= view('layout/footer') ?>

<script src="<?= base_url('assets/autoLogout.js') ?>"></script>
<script>
    const baseUrl = "<?= base_url() ?>";
    enableAutoLogout(7200, baseUrl + "login");

    var NILAI_MODE = <?= $hasNilai ? 'true' : 'false' ?>;
    var MIN_INDIKATOR = 5;

    function filledText(val)
    {
        return val !== undefined && val !== null && String(val).trim() !== '';
    }

    function recalc()
    {
        var n = 0, totalBobot = 0, totalKpi = 0;
        var holes = [], pairErrors = [], bobotErrors = [], nilaiErrors = [];

        for (var i = 1; i <= 12; i++) {
            var detailVal = $('#jk_indikator_' + i).val();
            var bobotVal = $('#jk_bobot_' + i).val();
            var b = parseFloat(bobotVal);

            $('#preview_' + i).text(filledText(bobotVal) && !isNaN(b) ? (b / 100).toFixed(2) : '-');

            var filled = filledText(detailVal) || filledText(bobotVal);

            if (!filled) {
                if (NILAI_MODE) {
                    $('#nilai-wrap_' + i).hide();
                    $('#konversi_' + i).text('-');
                }
                continue;
            }

            if (i !== n + 1) {
                holes.push(i);
                continue;
            }

            if (NILAI_MODE) {
                $('#nilai-wrap_' + i).show();
            }

            if (!filledText(detailVal) || !filledText(bobotVal)) {
                pairErrors.push(i);
            }

            if (!filledText(bobotVal) || isNaN(b) || b < 1 || b > 100) {
                bobotErrors.push(i);
            } else {
                totalBobot += b;
            }

            if (NILAI_MODE) {
                var nilaiVal = $('#jk_nilai_' + i).val();
                var nv = parseFloat(nilaiVal);

                if (filledText(nilaiVal) && !isNaN(nv) && nv >= 1 && nv <= 100) {
                    if (!isNaN(b)) {
                        totalKpi += nv * (b / 100);
                        $('#konversi_' + i).text((nv * (b / 100)).toFixed(2));
                    }
                } else {
                    nilaiErrors.push(i);
                    $('#konversi_' + i).text('-');
                }
            }

            n = i;
        }

        var totalBobotRounded = Math.round(totalBobot * 100) / 100;
        var bobotExact = Math.abs(totalBobotRounded - 100) < 0.011;

        $('#indikator-count').text(n + ' Indikator');
        $('#indikator-count').removeClass('badge-info badge-success badge-danger');
        $('#indikator-count').addClass(n >= MIN_INDIKATOR ? 'badge-success' : 'badge-danger');

        $('#total-bobot').text(totalBobotRounded.toFixed(2) + ' / 100');
        $('#total-bobot').removeClass('badge-success badge-danger');
        $('#total-bobot').addClass(bobotExact ? 'badge-success' : 'badge-danger');

        if (NILAI_MODE) {
            $('#total-kpi-preview').text('Preview Total KPI: ' + totalKpi.toFixed(2));
        }

        var warnings = [];
        if (holes.length > 0) {
            warnings.push('Indikator harus diisi berurutan mulai dari Indikator 1 tanpa melompat (baris bermasalah: ' + holes.join(', ') + ').');
        }
        if (pairErrors.length > 0) {
            warnings.push('Detail indikator dan bobot harus terisi berpasangan (baris bermasalah: ' + pairErrors.join(', ') + ').');
        }
        if (bobotErrors.length > 0) {
            warnings.push('Bobot nilai harus berupa angka skala 1 - 100 (baris bermasalah: ' + bobotErrors.join(', ') + ').');
        }
        
        
        if (NILAI_MODE && nilaiErrors.length > 0) {
            warnings.push('Nilai indikator terisi harus pada skala 1 - 100 (baris bermasalah: ' + nilaiErrors.join(', ') + ').');
        }

        $('#indikator-warning').html(warnings.join('<br>'));

        var valid = holes.length === 0 && pairErrors.length === 0 && bobotErrors.length === 0
            && nilaiErrors.length === 0 && n >= MIN_INDIKATOR && bobotExact;

        $('#submit-btn').prop('disabled', !valid);
    }

    $(document).ready(function () {
        $('#addindikator').on('input change', '.indikator-input, .bobot-input, .nilai-edit-input', function () {
            recalc();
        });

        recalc();
    });
</script>
