<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<?php
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
            <h1 class="m-0 text-dark">KPI Management</h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
               <li class="breadcrumb-item active">KPI Management</li>
            </ol>
         </div>
      </div>
   </div>
</div>

<section class="content">
   <div class="container-fluid">
      <div class="card">
         <div class="card-body p-0">
            <div class="d-flex align-items-center justify-content-between p-3">
               <div>
                  <?php if (function_exists('userpermission') && userpermission('lr_kpi_add')) : ?>
                  <a href="<?= base_url('jobdesc/add_indikator'); ?>" class="btn btn-primary mr-2">
                     <i class="fas fa-plus"></i> Tambah Indikator
                  </a>
                  <?php endif; ?>
                  <?php if (function_exists('userpermission') && userpermission('lr_kpi_pending_list')) : ?>
                  <a href="<?= base_url('jobdesc/kpi_nilai_management'); ?>" class="btn btn-warning">
                     <i class="fas fa-clock"></i> KPI Nilai (Pending)
                  </a>
                  <?php endif; ?>
               </div>
               <div id="table-filter" class="d-flex align-items-center">
                  <span class="mr-2">Search:</span>
               </div>
            </div>

            <div class="table-responsive">
                  <table id="kpilisttbl" class="table card-table table-vcenter text-nowrap">
                     <thead>
                        <tr>
                           <th class="w-1">No</th>
                           <th>Nama Divisi</th>
                           <th>Nama Karyawan</th>
                           <?php for ($i = 1; $i <= 12; $i++) : ?>
                           <th>Nilai Indikator <?= $i; ?></th>
                           <?php endfor; ?>
                           <th>Total Nilai KPI</th>
                           <th>Status</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php if (!empty($kpilist)) :
                           $count = 1;
                           foreach ($kpilist as $kpi) :
                        ?>
                        <tr>
                           <td><?= esc($count); $count++; ?></td>
                           <td><?= esc($kpi['jk_divisi']); ?></td>
                           <td><?= esc($kpi['jk_nama_karyawan']); ?></td>
                           <?php for ($i = 1; $i <= 12; $i++) :
                              if ($kpi['jk_nilai_' . $i] !== null && $kpi['jk_bobot_' . $i] !== null) {
                                  $konversi = number_format((float) $kpi['jk_nilai_' . $i] * (float) $kpi['jk_bobot_' . $i], 2);
                              } else {
                                  $konversi = '-';
                              }
                           ?>
                           <td><?= $konversi; ?></td>
                           <?php endfor; ?>
                           <td><b><?= number_format((float) $kpi['jk_total_kpi'], 2); ?></b></td>
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
                           <td>
                              <?php if (function_exists('userpermission') && userpermission('lr_kpi_edit')) : ?>
                              <a href="<?= base_url('jobdesc/edit_indikator/' . $kpi['jk_id']); ?>" class="btn btn-link text-primary p-0 border-0"><i class="fa fa-edit" title="Edit"></i></a>
                              |
                              <?php endif; ?>
                              <?php if (function_exists('userpermission') && userpermission('lr_kpi_view')) : ?>
                              <a href="<?= base_url('jobdesc/view_kpi/' . $kpi['jk_id']); ?>" class="btn btn-link text-success p-0 border-0"><i class="fa fa-eye" title="Detail"></i></a>
                              |
                              <?php endif; ?>
                              <?php if (function_exists('userpermission') && userpermission('lr_kpi_delete')) : ?>
                              <form id="delete-form-<?= $kpi['jk_id']; ?>" action="<?= base_url('jobdesc/kpi_delete/' . $kpi['jk_id']); ?>"
                                    method="post"
                                    style="display: inline;">
                                 <?= csrf_field() ?>
                                 <button type="button" class="btn btn-link text-danger p-0 border-0" onclick="confirmDeleteKPI(<?= $kpi['jk_id']; ?>, '<?= esc($kpi['jk_divisi']); ?>', '<?= esc($kpi['jk_nama_karyawan']); ?>')"><i class="fa fa-trash" title="Delete"></i></button>
                              </form>
                              <?php endif; ?>
                           </td>
                        </tr>
                        <?php endforeach; endif; ?>
                     </tbody>
                  </table>
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

    function confirmDeleteKPI(id, divisi, karyawan)
    {
        Swal.fire({
            title: "Apakah anda yakin ingin menghapus data KPI tersebut?",
            html: 'Divisi :' + '<b>' + divisi + '</b>' + '<br>' + 'Nama Karyawan :' + '<b>' + karyawan + '</b>',
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#dc3545",
            confirmButtonText: "Delete",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    $(document).ready(function () {
        var table = $('#kpilisttbl').DataTable({
            "pageLength": 15,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "scrollX": true,
            "language": {
                "paginate": {
                    "previous": "Previous",
                    "next": "Next"
                },
                "search": "Search:",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries"
            },
            initComplete: function () {
                var searchInput = $('div.dataTables_filter input');
                $('#table-filter').append(searchInput);
                $('div.dataTables_filter').remove();
            }
        });

        table.on('order.dt search.dt draw.dt', function () {
            let i = 1;
            table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell) {
                cell.innerHTML = i++;
            });
        }).draw();
    });
</script>
