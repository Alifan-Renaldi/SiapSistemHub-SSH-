<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<?php
function kpi_pct_format($value)
{
    return rtrim(rtrim(number_format((float) $value * 100, 2, '.', ''), '0'), '.') . '%';
}

function kpi_indikator_terisi_nilai($value)
{
    return $value !== null && $value !== '';
}
?>

<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Tambah Nilai Indikator KPI</h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
               <li class="breadcrumb-item"><a href="<?= base_url('jobdesc/kpi_nilai_management'); ?>">KPI Nilai Management</a></li>
               <li class="breadcrumb-item active">Tambah Nilai Indikator</li>
            </ol>
         </div>
      </div>
   </div>
</div>

<section class="content">
   <div class="container-fluid">
      <form method="post" id="addnilai" class="card" action="<?= base_url('jobdesc/insert_nilai'); ?>">
         <?= csrf_field() ?>
         <input type="hidden" name="jk_id" id="jk_id" value="<?= esc($kpi['jk_id']); ?>">

         <div class="card-body">
            <div class="row">
               <div class="col-sm-6 col-md-6">
                  <label class="form-label">Nama Divisi</label>
                  <div class="form-group">
                     <input type="text" class="form-control" readonly value="<?= esc($kpi['jk_divisi']); ?>">
                  </div>
               </div>
               <div class="col-sm-6 col-md-6">
                  <label class="form-label">Nama Karyawan</label>
                  <div class="form-group">
                     <input type="text" class="form-control" readonly value="<?= esc($kpi['jk_nama_karyawan']); ?>">
                  </div>
               </div>
            </div>

            <hr>
            <?php $jumlahIndikator = 0; ?>
            <?php for ($i = 1; $i <= 12; $i++) : ?>
               <?php if (kpi_indikator_terisi_nilai($kpi['jk_indikator_' . $i])) : ?>
                  <?php $jumlahIndikator++; ?>
               <?php endif; ?>
            <?php endfor; ?>
            <div class="d-flex justify-content-between align-items-center mb-2">
               <div class="form-label"><b>Nilai Indikator (<?= $jumlahIndikator; ?> Indikator Terisi)</b></div>
               <div class="text-right">
                  <span class="form-label"><b>Preview Total Nilai KPI: </b></span>
                  <span id="total-preview" class="badge badge-secondary" style="font-size: 1em;">0.00</span>
               </div>
            </div>
            <small class="text-muted d-block mb-2">Nilai konversi = nilai indikator &times; bobot indikator (contoh: nilai 90 dengan bobot 80% menghasilkan 72).</small>

            <?php for ($i = 1; $i <= 12; $i++) :
               if (!kpi_indikator_terisi_nilai($kpi['jk_indikator_' . $i])) {
                   continue;
               }
            ?>
            <div class="row align-items-center mb-2">
               <div class="col-sm-12 col-md-5">
                  <div class="form-group mb-md-0">
                     <label class="form-label">Detail Indikator <?= $i; ?></label>
                     <input type="text" class="form-control" readonly value="<?= esc($kpi['jk_indikator_' . $i]); ?>">
                  </div>
               </div>
               <div class="col-sm-6 col-md-2">
                  <div class="form-group mb-0">
                     <label class="form-label">Bobot</label>
                     <input type="text" class="form-control" readonly value="<?= kpi_pct_format($kpi['jk_bobot_' . $i]); ?>">
                  </div>
               </div>
               <div class="col-sm-6 col-md-3">
                  <div class="form-group mb-0">
                     <label class="form-label">Input Nilai Indikator <?= $i; ?></label>
                     <input type="number" name="jk_nilai_<?= $i; ?>" id="jk_nilai_<?= $i; ?>" required
                            class="form-control nilai-input" min="1" max="100" step="0.01"
                            placeholder="1 - 100"
                            data-bobot="<?= esc($kpi['jk_bobot_' . $i]); ?>">
                  </div>
               </div>
               <div class="col-sm-12 col-md-2">
                  <span class="form-label text-muted">Konversi: <b id="konversi_<?= $i; ?>">-</b></span>
               </div>
            </div>
            <?php endfor; ?>
         </div>

         <div class="card-footer d-flex">
            <a href="<?= base_url('jobdesc/kpi_nilai_management'); ?>" class="btn btn-warning">
               <i class="fa fa-arrow-left"></i> CANCEL
            </a>
            <button type="submit" class="btn btn-primary ml-auto">
               <i class="fa fa-save"></i> SAVE
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

    function recalcTotalNilai()
    {
        var total = 0;
        $('.nilai-input').each(function () {
            var idx = $(this).attr('id').replace('jk_nilai_', '');
            var val = parseFloat($(this).val());
            var bobot = parseFloat($(this).data('bobot'));

            if (!isNaN(val) && !isNaN(bobot)) {
                var konversi = val * bobot;
                total += konversi;
                $('#konversi_' + idx).text(konversi.toFixed(2));
            } else {
                $('#konversi_' + idx).text('-');
            }
        });

        $('#total-preview').text(total.toFixed(2));
    }

    $(document).ready(function () {
        $('.nilai-input').on('input change', function () {
            recalcTotalNilai();
        });

        recalcTotalNilai();
    });
</script>
