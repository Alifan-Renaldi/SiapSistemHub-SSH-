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
            <h1 class="m-0 text-dark">Loan Approval
            </h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
               <li class="breadcrumb-item active"><a href="<?= base_url('loans/loan_management'); ?>">Loan</a></li>
               <li class="breadcrumb-item active">Approval</li>
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
                <a href="<?= base_url('loans/loan_management'); ?>" class="">
                    <i class="fa fa-arrow-left"></i> Back to List Loan
                </a>
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
                        <th>Nomor Hutang</th>
                        <th>Tanggal</th>
                        <th>Nama Supir</th>
                        <th>Mobil</th>
                        <th>Nominal</th>
                        <th>Potong Tagihan</th>
                        <th>Keterangan</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if(!empty($loanapprove_drivers)):
                        $count=1;
                        foreach($loanapprove_drivers as $loanlist_approve):
                        ?>
                     <tr>
                        <td><?= esc($count); $count++; ?></td>
                        <td><?= esc($loanlist_approve['l_code']); ?></td>
                        <td> <?= esc(date('d-m-Y', strtotime($loanlist_approve['l_tanggal']))); ?></td>
                        <td> <?= esc($loanlist_approve['l_supir']); ?></td>
                        <td> <?= esc($loanlist_approve['l_nopol']); ?></td>
                        <td> <?= esc($loanlist_approve['l_nominal']); ?></td>
                        <td> <?= esc($loanlist_approve['l_potong']); ?></td>
                        <td> <?= esc($loanlist_approve['l_keterangan']); ?></td>
                        <td>
                            <?php 
                            $status = 'Inactive';
                            $isEditable = false;
                            foreach ($driverlist as $driver) {
                                if ($driver['d_nis'] === $loanlist_approve['l_nis']) {
                                    if ($driver['d_is_active'] == 1) {
                                        $status = 'Active';
                                        $isEditable = true;
                                    }
                                    break;
                                }
                            }
                            ?>

                            <?php if ($isEditable && userpermission('lr_drivers_edit_loan')): ?>
                                <form action="<?= base_url('loans/editloan') ?>" method="POST" style="display: inline;">
                                <?= csrf_field() ?>
                                <input type="hidden" name="loan_id" value="<?= $loanlist_approve['l_id'] ?>">
                                <button type="submit" class="btn btn-link text-primary p-0 border-0"><i class="fa fa-edit" title="Edit"></i></button>
                            </form>
                            |
                             <?php endif;
                           if(userpermission('lr_drivers_view_loan')): ?>
                           <form action="<?= base_url('loans/viewloan') ?>" method="POST" style="display: inline;">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="loan_id" value="<?= $loanlist_approve['l_id'] ?>">
                                    <button type="submit" class="btn btn-link text-success p-0 border-0"><i class="fa fa-eye" title="Detail"></i></button>
                                </form>
                           <?php endif;?>
                           <?php if ($isEditable && userpermission('lr_drivers_delete_loan')): ?>
                                    | <form action="<?= base_url('drivers/loan_delete/' . $loanlist_approve['l_id']) ?>" 
                                          method="post" 
                                          style="display: inline;" 
                                          onsubmit="return confirm('Yakin hapus loan ini?')">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-link text-danger p-0 border-0"><i class="fa fa-trash" title="Delete"></i></button>
                                    </form>
                            <?php endif; ?>
                            <?php if($isEditable && userpermission('lr_drivers_approve_loan')): ?>
                                    | <a href="#" class="text-info" onclick="approveLoan(<?= $loanlist_approve['l_id'] ?>)"><i class="fa fa-thumbs-up" title="Approve"></i></a>
                                    | <a href="#" onclick="rejectLoan(<?= $loanlist_approve['l_id'] ?>)"
                                        style="color: orange; display: inline-block; transform: scaleX(-1); transition: color 0.3s ease;"
                                         onmouseover="this.style.color='darkorange'"
                                         onmouseout="this.style.color='orange'"><i class="fa fa-thumbs-down" title="Reject"></i></a>
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

function approveLoan(loanId) {
    if (confirm("Apakah anda yakin ingin menyetujui pengajuan hutang ini?")) {
        $.ajax({
            url: baseUrl + 'loans/update_loan_status',
            type: 'POST',
            data: {
                loan_id: loanId,
                status: 1,
                <?= csrf_token() ?>: '<?= csrf_hash() ?>'
            },
            success: function(response) {
                if (response.success) {
                    alert('Pengajuan Hutang berhasil disetujui');
                    location.reload();
                } else {
                    alert('Gagal menyetujui pengajuan hutang: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                alert('Terjadi kesalahan: ' + error);
            }
        });
    }
}

function rejectLoan(loanId) {
    if (confirm("Apakah anda yakin ingin menolak pengajuan hutang ini?")) {
        $.ajax({
            url: baseUrl + 'loans/update_loan_status',
            type: 'POST',
            data: {
                loan_id: loanId,
                status: 3,
                <?= csrf_token() ?>: '<?= csrf_hash() ?>'
            },
            success: function(response) {
                if (response.success) {
                    alert('Pengajuan Hutang berhasil ditolak');
                    location.reload();
                } else {
                    alert('Gagal menolak pengajuan hutang: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                alert('Terjadi kesalahan: ' + error);
            }
        });
    }
}
</script>

</body>
</html>