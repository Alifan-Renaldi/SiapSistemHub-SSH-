<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<?php
function kpi_pct_format($value)
{
    return rtrim(rtrim(number_format((float) $value * 100, 2, '.', ''), '0'), '.') . '%';
}
?>

<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Detail Indikator KPI (Belum Dinilai)</h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
               <li class="breadcrumb-item"><a href="<?= base_url('jobdesc/kpi_nilai_management'); ?>">KPI Nilai Management</a></li>
               <li class="breadcrumb-item active">Detail Indikator KPI</li>
            </ol>
         </div>
      </div>
   </div>
</div>

<section class="content">
   <div class="container-fluid">
      <div class="row mb-3">
         <div class="col-md-6">
            <div class="card">
               <div class="card-body py-3">
                  <div class="d-flex justify-content-between align-items-center">
                     <div>
                        <small class="text-muted">Nama Divisi</small>
                        <h5 class="mb-0"><?= esc($kpi['jk_divisi']); ?></h5>
                     </div>
                     <i class="fas fa-sitemap fa-2x text-muted"></i>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-6">
            <div class="card">
               <div class="card-body py-3">
                  <div class="d-flex justify-content-between align-items-center">
                     <div>
                        <small class="text-muted">Nama Karyawan</small>
                        <h5 class="mb-0"><?= esc($kpi['jk_nama_karyawan']); ?></h5>
                     </div>
                     <i class="fas fa-user fa-2x text-muted"></i>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="card">
         <div class="card-header">
            <h3 class="card-title">Tabel Detail Indikator</h3>
         </div>
         <div class="card-body p-0">
            <div class="table-responsive">
               <table class="table table-bordered table-striped">
                  <thead>
                     <tr>
                        <th class="w-1">No</th>
                        <th>Detail Indikator</th>
                        <th class="w-25">Bobot Nilai Indikator</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php for ($i = 1; $i <= 12; $i++) :
                        if ($kpi['jk_indikator_' . $i] === null || $kpi['jk_indikator_' . $i] === '') {
                            continue;
                        }
                     ?>
                     <tr>
                        <td><?= $i; ?></td>
                        <td><?= esc($kpi['jk_indikator_' . $i]); ?></td>
                        <td><?= kpi_pct_format($kpi['jk_bobot_' . $i]); ?></td>
                     </tr>
                     <?php endfor; ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>

      <div class="alert alert-warning">
         <i class="fas fa-info-circle"></i> Nilai indikator KPI ini <b>belum diisi</b>. Total Nilai KPI dan Status akan tersedia setelah nilai seluruh indikator diinputkan.
      </div>

      <div class="d-flex justify-content-between mb-3">
         <a href="<?= base_url('jobdesc/kpi_nilai_management'); ?>" class="btn btn-warning">
            <i class="fa fa-arrow-left"></i> KEMBALI
         </a>
         <?php if (function_exists('userpermission') && userpermission('lr_kpi_add_nilai')) : ?>
         <a href="<?= base_url('jobdesc/add_nilai/' . $kpi['jk_id']); ?>" class="btn btn-primary">
            <i class="fas fa-edit"></i> ISI NILAI SEKARANG
         </a>
         <?php endif; ?>
      </div>
   </div>
</section>
<?= view('layout/footer') ?>

<script src="<?= base_url('assets/autoLogout.js') ?>"></script>
<script>
    const baseUrl = "<?= base_url() ?>";
    enableAutoLogout(7200, baseUrl + "login");
</script>
