<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BAP Pending Info</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <style>
        .dataTables_wrapper .dataTables_filter {
            float: right;
        }
        .dataTables_wrapper .dt-buttons {
            float: left;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">BAP Waiting List
            </h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
               <li class="breadcrumb-item"><a href="<?= base_url('baps/bap_management'); ?>">BAP</a></li>
               <li class="breadcrumb-item active">Pending</li>
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
                <a href="<?= base_url('baps/bap_management'); ?>" class="">
                    <i class="fa fa-arrow-left"></i> Back to List BAP
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
                        <th>Nomor BAP</th>
                        <th>Timestamp</th>
                        <th>Tanggal Kejadian</th>
                        <th>Nama Supir</th>
                        <th>Mobil</th>
                        <th>Jenis Muatan</th>
                        <th>Jenis Kasus</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if(!empty($bappending_drivers)):
                        $count=1;
                        foreach($bappending_drivers as $baplist_driversdata):
                        ?>
                     <tr>
                        <td> <?= esc($count); $count++; ?></td>
                        <td><?= esc($baplist_driversdata['b_code']); ?></td>
                        <td> <?= esc(date('d-m-Y', strtotime($baplist_driversdata['b_created_date']))); ?></td>
                        <td> <?= esc(date('d-m-Y', strtotime($baplist_driversdata['b_tanggal_kejadian']))); ?></td>
                        <td> <?= esc($baplist_driversdata['b_supir']); ?></td>
                        <td> <?= esc($baplist_driversdata['b_nopol']); ?></td>
                        <td> <?= esc($baplist_driversdata['b_muatan']); ?></td>
                        <td> <?= esc($baplist_driversdata['b_jenis_kasus']); ?></td>
                        <td>
                            <?php 
                            $status = 'Inactive';
                            $badgeClass = 'badge-danger';
                            $isEditable = false;
                            foreach ($driverlist as $driver) {
                                if ($driver['d_nis'] === $baplist_driversdata['b_nis']) {
                                    if ($driver['d_is_active'] == 1) {
                                        $status = 'Active';
                                        $badgeClass = 'badge-success';
                                        $isEditable = true;
                                    }
                                    break;
                                }
                            }
                            ?>

                            <?php if ($isEditable && userpermission('lr_drivers_edit_bap')): ?>
                                <form action="<?= base_url('baps/editbap_pending') ?>" method="POST" style="display: inline;">
                                <?= csrf_field() ?>
                                <input type="hidden" name="bap_id" value="<?= $baplist_driversdata['b_id'] ?>">
                                <button type="submit" class="btn btn-link text-primary p-0 border-0"><i class="fa fa-edit" title="Edit"></i></button>
                            </form>
                            |
                             <?php endif;
                           if(userpermission('lr_drivers_view_bap')): ?>
                           <form action="<?= base_url('baps/bap_pendingview') ?>" method="POST" style="display: inline;">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="bap_id" value="<?= $baplist_driversdata['b_id'] ?>">
                                    <button type="submit" class="btn btn-link text-success p-0 border-0"><i class="fa fa-eye" title="Detail"></i></button>
                                </form>
                           <?php endif;?>
                           <?php if (userpermission('lr_drivers_print_bap')): ?>
                            |
                            <a class="icon" href="<?= base_url('baps/bap_print/' . $baplist_driversdata['b_id']); ?>">
                                <i class="fa fa-print text-info" title="Print"></i>
                            </a>
                           <?php endif;?>
                           <?php if ($isEditable && userpermission('lr_drivers_delete_bap')): ?>
                                    | <form action="<?= base_url('drivers/bappending_delete/' . $baplist_driversdata['b_id']) ?>" 
                                          method="post" 
                                          style="display: inline;" 
                                          onsubmit="return confirm('Yakin hapus bap ini?')">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-link text-danger p-0 border-0"><i class="fa fa-trash" title="Delete"></i></button>
                                    </form>
                                <?php endif; ?>
                        </td>
                     </tr>
                     <?php endforeach; 
                     endif; ?>
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