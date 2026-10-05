<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<?php
// Custom loading logo check (developer can replace loading_logo.png in assets/uploads)
$pendingCount = count($bappending_drivers ?? []);
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BAP Info</title>
    <!-- DataTables CSS -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
</head>
<body>
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
            <h1 class="m-0 text-dark">BAP List</h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
               <li class="breadcrumb-item active">BAP</li>
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
                <?php if (function_exists('userpermission') && userpermission('lr_drivers_add_bap')) : ?>
                <a href="<?= base_url('baps/addbap'); ?>" class="btn btn-primary mr-2">
                    <i class="fas fa-plus"></i> Add New BAP
                </a>
                <?php endif; ?>
                <?php if (function_exists('userpermission') && userpermission('lr_drivers_pending_bap')) : ?>
                <a href="<?= base_url('baps/bap_pending'); ?>" class="btn btn-warning">
                    <i class="fas fa-clock"></i> Pending BAP
                    <span class="badge bg-light text-dark" style="font-size: 1em; padding: 0.3em 0.6em;"><?= $pendingCount; ?></span>
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
                        <th>Nomor BAP</th>
                        <th>Tanggal BAP</th>
                        <th>Tanggal Input BAP</th>
                        <th>Tanggal Kejadian</th>
                        <th>Nama Supir</th>
                        <th>Mobil</th>
                        <th>Jenis Muatan</th>
                        <th>Jenis Kasus</th>
                        <th>Realisasi Klaim</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if(!empty($bapdate_drivers)): 
                        $count = 1;
                        foreach($bapdate_drivers as $baplist_driversdata):
                        ?>
                     <tr>
                        <td><?= esc($count); $count++; ?></td>
                        <td><?= esc($baplist_driversdata['b_code']); ?></td>
                        <td><?= esc(date('d-m-Y', strtotime($baplist_driversdata['b_tanggal']))); ?></td>
                        <td> <?= esc(date('d-m-Y', strtotime($baplist_driversdata['b_created_date']))); ?></td>
                        <td><?= esc(date('d-m-Y', strtotime($baplist_driversdata['b_tanggal_kejadian']))); ?></td>
                        <td><?= esc($baplist_driversdata['b_supir']); ?></td>
                        <td><?= esc($baplist_driversdata['b_nopol']); ?></td>
                        <td><?= esc($baplist_driversdata['b_muatan']); ?></td>
                        <td><?= esc($baplist_driversdata['b_jenis_kasus']); ?></td>
                        <td><?= esc($baplist_driversdata['b_realisasi_klaim']); ?></td>
                        <td>
                            <?php 
                            $status = 'Inactive';
                            $badgeClass = 'badge-danger';
                            $isEditable = false;
                            
                            foreach ($driverlist as $driver) {
                                if ($driver['d_nis'] === $baplist_driversdata['b_nis']) {
                                    if ($driver['d_is_active'] == 1) {
                                        $status = 'Active';
                                        $badgeClass = 'bg-success';
                                        $isEditable = true;
                                    }
                                    break;
                                }
                            }
                            ?>

                           <?php if ($isEditable && userpermission('lr_drivers_edit_bap')): ?>
                            <form action="<?= base_url('baps/editbap') ?>" method="POST" style="display: inline;">
                                <?= csrf_field() ?>
                                <input type="hidden" name="bap_id" value="<?= $baplist_driversdata['b_id'] ?>">
                                <button type="submit" class="btn btn-link text-primary p-0 border-0"><i class="fa fa-edit" title="Edit"></i></button>
                            </form>
                            |
                           <?php endif; 
                           if(userpermission('lr_drivers_view_bap')): ?>
                                <form action="<?= base_url('baps/bap_view') ?>" method="POST" style="display: inline;">
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
                                    | <form id="delete-form-<?= $baplist_driversdata['b_id'] ?>" action="<?= base_url('drivers/bap_delete/' . $baplist_driversdata['b_id']) ?>" 
                                          method="post" 
                                          style="display: inline;">
                                        <?= csrf_field() ?>
                                        <button type="button" class="btn btn-link text-danger p-0 border-0" onclick="confirmDeleteBAPS('<?= $baplist_driversdata['b_id'] ?>', '<?= esc($baplist_driversdata['b_code']) ?>', '<?= esc($baplist_driversdata['b_supir']) ?>', '<?= esc($baplist_driversdata['b_nopol']) ?>')"><i class="fa fa-trash" title="Delete"></i></button>
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
    
    function confirmDeleteBAPS(id, code, Supir, Nopol)
    {
        Swal.fire({
            title: "Apakah anda yakin ingin menghapus data BAPS tersebut?",
            html: 'No BAPS :' + '<b>' + code + '</b>' + '<br>' + 'Supir :' + '<b>' + Supir + '</b>' + '<br>' + 'No Polisi :' + '<b>' + Nopol + '</b>',
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

function confirmDelete() {
    return confirm("Apakah anda yakin ingin menghapus data ini?");
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

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>