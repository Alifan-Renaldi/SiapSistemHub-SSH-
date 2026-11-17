<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<?php
function kpi_pct_format($value)
{
    return rtrim(rtrim(number_format((float) $value * 100, 2, '.', ''), '0'), '.') . '%';
}

$statusBadges = [
    1  => 'badge-success',
    2  => 'badge-primary',
    3  => 'badge-warning',
    4  => 'badge-danger',
];
?>

<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Detail KPI</h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
               <li class="breadcrumb-item"><a href="<?= base_url('jobdesc/kpi_management'); ?>">KPI Management</a></li>
               <li class="breadcrumb-item active">Detail KPI</li>
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

      <div class="card">
         <div class="card-header">
            <h3 class="card-title">Tabel Nilai Detail Indikator</h3>
         </div>
         <div class="card-body p-0">
            <div class="table-responsive">
               <table class="table table-bordered table-striped">
                  <thead>
                     <tr>
                        <th class="w-1">No</th>
                        <th>Detail Indikator</th>
                        <th class="w-25">Nilai Indikator</th>
                        <th class="w-25">Nilai Konversi</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php for ($i = 1; $i <= 12; $i++) :
                        if ($kpi['jk_indikator_' . $i] === null || $kpi['jk_indikator_' . $i] === '') {
                            continue;
                        }
                        $konversi = (float) $kpi['jk_nilai_' . $i] * (float) $kpi['jk_bobot_' . $i];
                     ?>
                     <tr>
                        <td><?= $i; ?></td>
                        <td><?= esc($kpi['jk_indikator_' . $i]); ?></td>
                        <td><?= number_format((float) $kpi['jk_nilai_' . $i], 2); ?></td>
                        <td><?= number_format($konversi, 2); ?></td>
                     </tr>
                     <?php endfor; ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>

      <div class="card">
         <div class="card-body py-3">
            <div class="row align-items-center">
               <div class="col-md-8">
                  <h5 class="mb-0">Total Nilai KPI</h5>
               </div>
               <div class="col-md-2 text-right">
                  <h4 class="mb-0"><b><?= number_format((float) $kpi['jk_total_kpi'], 2); ?></b></h4>
               </div>
               <div class="col-md-2 text-right">
                  <span>
                     <?php if ($kpi['jk_status'] == 1): ?>
                        <td><span class="badge <?= $statusBadges[$kpi['jk_status']] ?? 'badge-secondary'; ?>">Sangat Baik</span></td>
                     <?php elseif ($kpi['jk_status'] == 2): ?>
                        <td><span class="badge <?= $statusBadges[$kpi['jk_status']] ?? 'badge-secondary'; ?>">Baik</span></td>
                     <?php elseif ($kpi['jk_status'] == 3): ?>
                        <td><span class="badge <?= $statusBadges[$kpi['jk_status']] ?? 'badge-secondary'; ?>">Cukup</span></td>
                     <?php elseif ($kpi['jk_status'] == 4): ?>
                        <td><span class="badge <?= $statusBadges[$kpi['jk_status']] ?? 'badge-secondary'; ?>">Kurang</span></td>
                     <?php endif; ?>
                  </span>
               </div>
            </div>
         </div>
      </div>

      <div class="d-flex justify-content-between mb-3">
         <a href="<?= base_url('jobdesc/kpi_management'); ?>" class="btn btn-warning">
            <i class="fa fa-arrow-left"></i> KEMBALI
         </a>
      </div>
   </div>
</section>
<?= view('layout/footer') ?>

<script src="<?= base_url('assets/autoLogout.js') ?>"></script>
<script>
    const baseUrl = "<?= base_url() ?>";
    enableAutoLogout(7200, baseUrl + "login");
</script>
