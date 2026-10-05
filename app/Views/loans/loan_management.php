<?php
$pendingCount = count($loanapprove_drivers ?? []);
?>

<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Info</title>
    <style>
    .wrap-text {
        white-space: normal !important;
        word-wrap: break-word;
        max-width: 500px;
    }
</style>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
</head>
<body>
<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Loan List
            </h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
               <li class="breadcrumb-item active">Loan</li>
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
                <?php if (function_exists('userpermission') && userpermission('lr_drivers_add_loan')) : ?>
                <a href="<?= base_url('loans/addloan'); ?>" class="btn btn-primary mr-2">
                    <i class="fa fa-hand-holding-usd"></i> Loan Application
                </a>
                <a href="<?= base_url('loans/loan_approve'); ?>" class="btn btn-warning">
                    <i class="fas fa-file-signature"></i> Loan Approval <span class="badge bg-light text-dark" style="font-size: 1em; padding: 0.3em 0.6em;"><?= $pendingCount; ?></span>
                </a>
                <?php endif; ?>
                  </div>
                <div id="table-filter" class="d-flex align-items-center">
                    <span class="mr-2">Search:</span>
                </div>
            </div>

            <div class="table-responsive">
               <div style="overflow-x: auto;">
               <table id="driverslisttbl" class="table card-table table-vcenter text-nowrap">
                  <thead>
                     <tr>
                        <th class="w-1">No</th>
                        <th>Tanggal</th>
                        <th>Nama Supir</th>
                        <th>Mobil</th>
                        <th>Jenis Hutang</th>
                        <th>Nominal</th>
                        <th>Potong Tagihan</th>
                        <th>Persetujuan</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if(!empty($combined_list)):  
                        $count = 1;
                        foreach($combined_list as $data):
                            $isLoan = ($data['type'] == 'loans');
                            $nis = $isLoan ? $data['l_nis'] : $data['b_nis'];
                     ?>
                     <tr>
                        <td><?= esc($count); $count++; ?></td>
                        <td><?= esc(date('d-m-Y', strtotime($isLoan ? $data['l_tanggal'] : $data['b_tanggal']))); ?></td>
                        <td><?= esc($isLoan ? $data['l_supir'] : $data['b_supir']); ?></td>
                        <td><?= esc($isLoan ? $data['l_nopol'] : $data['b_nopol']); ?></td>
                        <td>
                            <span>
                                <?php 
                                if (isset($data['l_is_status'])) {
                                    $status = $data['l_is_status'];
                                    
                                    if (in_array($status, [0, 1, 3])) {
                                        echo esc('PRIBADI');
                                    } elseif (in_array($status, [4, 5])) {
                                        echo esc('SPAREPART');
                                    } elseif ($status == 2) {
                                        echo esc('PRIBADI');
                                    } else {
                                        $jenisKasus = !empty($data['b_jenis_kasus']) ? " ({$data['b_jenis_kasus']})" : '';
                                        echo esc('KLAIM' . $jenisKasus);
                                    }
                                    } elseif ($isLoan) {
                                    echo esc('PRIBADI');
                                } else {
                                    $jenisKasus = !empty($data['b_jenis_kasus']) ? " ({$data['b_jenis_kasus']})" : '';
                                    echo esc('KLAIM' . $jenisKasus);
                                }
                                ?>
                            </span>
                        </td>
                        <td><?= esc($isLoan ? $data['l_nominal'] : $data['b_realisasi_klaim']); ?></td>
                        <td><?= esc($isLoan ? $data['l_potong'] : $data['b_potong_tagihan']); ?></td>
                        <td>
                           <?php if ($isLoan): ?>
                               <?php 
                                   if ($data['l_is_status'] == 1 || $data['l_is_status'] == 0) {
                                    $approveDate = !empty($data['l_tanggal_approve']) ? date('d-m-Y', strtotime($data['l_tanggal_approve'])) : '';
                                    echo '<span class="badge badge-success">APPROVED</span>';
                                    echo '<span style="color: black; font-size: 12px; margin-left: 3px;">' . $approveDate . '</span>';
                                   } elseif ($data['l_is_status'] == 3) {
                                    $approveDate = !empty($data['l_tanggal_approve']) ? date('d-m-Y', strtotime($data['l_tanggal_approve'])) : '';
                                        echo '<span class="badge badge-danger">REJECTED</span>';
                                        echo '<span style="color: black; font-size: 12px; margin-left: 3px;">' . $approveDate . '</span>';
                                   } else {
                                       echo '<span class="badge badge-light">-</span>';
                                   }
                               ?>
                           <?php else: ?>
                               <span class="badge badge-light">-</span>
                           <?php endif; ?>
                       </td>
                        <td>
                            <?php 
                            $status = 'Inactive';
                            $isEditable = false;
                            foreach ($driverlist as $driver) {
                                if ($driver['d_nis'] === $nis) {
                                    if ($driver['d_is_active'] == 1) {
                                        $status = 'Active';
                                        $isEditable = true;
                                    }
                                    break;
                                }
                            }

                             if ((isset($data['l_is_status']) && in_array($data['l_is_status'], [0, 5])) || 
                                    (isset($data['b_is_status']) && $data['b_is_status'] == 2)) {
                                    $isEditable = false;
                                }
                            ?>

                            <?php if ($isEditable && userpermission('lr_drivers_edit_loan')): ?> 
                                <form action="<?= base_url($isLoan ? 'loans/editloan' : 'baps/editbap') ?>" method="POST" style="display: inline;">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="<?= $isLoan ? 'loan_id' : 'bap_id' ?>" value="<?= esc($isLoan ? $data['l_id'] : $data['b_id']) ?>">
                                    <button type="submit" class="btn btn-link text-primary p-0 border-0">
                                        <i class="fa fa-edit" title="Edit"></i>
                                    </button>
                                </form>
                                |
                            <?php endif; ?>
                            <?php if (function_exists('userpermission') && userpermission('lr_drivers_view_loan')) : ?>
                                <form action="<?= base_url($isLoan ? 'loans/viewloan' : 'baps/bap_view') ?>" method="POST" style="display: inline;">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="<?= $isLoan ? 'loan_id' : 'bap_id' ?>" value="<?= esc($isLoan ? $data['l_id'] : $data['b_id']) ?>">
                                    <button type="submit" class="btn btn-link text-primary p-0 border-0">
                                        <i class="fa fa-eye text-success" title="Detail"></i>
                                    </button>
                                </form>
                            <?php endif; ?>
                            <?php if ($isEditable && userpermission('lr_drivers_delete_loan')): ?>
                                |
                                <form action="<?= base_url('drivers/' . ($isLoan ? 'loan_delete' : 'bap_delete') . '/' . esc($isLoan ? $data['l_id'] : $data['b_id'])); ?>" method="post"     style="display: inline;"
                                     onsubmit="return confirm('Yakin hapus bap ini?')">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-link text-danger p-0 border-0"><i class="fa fa-trash" title="Delete"></i></button>
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
   </div>
</section>
<?= view('layout/footer') ?>

<script src="<?= base_url('assets/autoLogout.js') ?>"></script>
<script>
    const baseUrl = "<?= base_url() ?>"; 
    enableAutoLogout(7200, baseUrl + "login");
    
$(document).ready(function () {
    var table = $('#driverslisttbl').DataTable({
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
            "info": "Showing _START_ to _END_ of _TOTAL_ entri"
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

function confirmDelete() {
    return confirm("Apakah anda yakin ingin menghapus data ini?");
}
</script>

</body>
</html>