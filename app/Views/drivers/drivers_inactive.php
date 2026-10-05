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
                <h1 class="m-0 text-dark">Inactive Driver List / Blacklist</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Inactive-Blacklist</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
<div class="container-fluid">
    <div class="card">
        <div class="d-flex align-items-center justify-content-between p-3">
            <?php if (function_exists('userpermission') && userpermission('lr_drivers_add')) : ?>
                <a href="<?= base_url('drivers/adddriversblacklist') ?>" class="btn btn-dark">
                    <i class="fa fa-plus"></i> New Driver Blacklisted
                </a>
            <?php endif; ?>
            <div id="table-filter" class="d-flex align-items-center">
                <span class="mr-2">Search:</span>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="driverslisttbl" class="table card-table table-vcenter text-nowrap">
                    <thead>
                        <tr>
                            <th class="w-1">No</th>
                            <th>NIS</th>
                            <th>Nama Supir</th>
                            <?php if (function_exists('userpermission') && userpermission('lr_detail_view_bio')) : ?>
                            <th>Nomor HP</th>
                            <th>NIK</th>
                            <?php endif; ?>
                            <th>Tanggal Masuk</th>
                            <th>Tanggal Keluar</th>
                            <th>Masa Kerja</th>
                            <th>Status</th>
                            <th>Hutang</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1; if($driverslist): ?>
                        <?php foreach ($driverslist as $driverslists): ?>
                        <tr>
                            <td><?= esc($count++) ?></td>
                            <td><?= esc($driverslists['d_nis']) ?></td>
                            <td><?= esc($driverslists['d_name'] . ' ' . '(' . $driverslists['d_nickname'] . ')' ) ?></td>
                            <?php if (function_exists('userpermission') && userpermission('lr_detail_view_bio')) : ?>
                            <td><?= esc($driverslists['d_mobile']) ?></td>
                            <td><?= esc($driverslists['d_identityno']) ?></td>
                            <?php endif; ?>
                            <td>
                                <?= 
                                    esc($driverslists['d_doj'])
                                ?>
                            </td>
                            <td>
                                <?= 
                                    esc($driverslists['d_resigndate'])
                                ?>
                            </td>
                            <td>
                               <?php
                                    $doj = $driverslists['d_doj'] ?? '';
                                    if (!empty($doj) && $doj !== '0000-00-00') {
                                        try {
                                            $start = new \DateTime($doj);
                                            $now = new \DateTime();
                                            $diff = $start->diff($now);
                                            echo $diff->y . ' Tahun ' . $diff->m . ' Bulan';
                                        } catch (\Exception $e) {
                                            echo '-';
                                        }
                                    } else {
                                        echo '-';
                                    }
                                ?>
                            </td>
                            <td>
                                <?php if ($driverslists['d_is_active'] == 0): ?>
                                    <span class="badge badge-danger">Inactive</span>
                                <?php elseif ($driverslists['d_is_active'] == 2): ?>
                                    <span class="badge badge-dark">Blacklist</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge <?= ($driverslists['d_is_active'] == '0') || ($driverslists['d_is_active'] == '2') ? 'badge-danger' : 'badge-dark'; ?>" style="font-size:14px;">
                                    <?= ($driverslists['d_is_active'] == '0') || ($driverslists['d_is_active'] == '2') ? 'Inactive' : 'Blacklist'; ?>
                                </span>
                            </td>
                            <td>
                            <?php if (function_exists('userpermission') && userpermission('lr_drivers_list_edit')) { ?>
                                <form action="<?= base_url('drivers/editdriverblacklist') ?>" method="POST" style="display: inline;">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="driver_id" value="<?= $driverslists['d_id'] ?>">
                                        <button type="submit" class="btn btn-link text-primary p-0 border-0"><i class="fa fa-edit" title="Edit"></i></button>
                                    </form>
                                     |
                            <?php } ?>
                            
                            <?php if (function_exists('userpermission') && userpermission('lr_drivers_list_view')) : ?>
                                    <form action="<?= base_url('drivers/viewdriver_inactive') ?>" method="POST" style="display: inline;">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="driver_id" value="<?= $driverslists['d_id'] ?>">
                                        <button type="submit" class="btn btn-link text-success p-0 border-0"><i class="fa fa-eye" title="Detail"></i></button>
                                    </form>
                            <?php endif; ?>
                            
                            <?php if (function_exists('userpermission') && userpermission('lr_drivers_list_delete')) : ?>
                            |
                            <form id="delete-form-<?= $driverslists['d_id'] ?>" action="<?= base_url('drivers/drivers_delete/' . $driverslists['d_id']) ?>" 
                                method="post" 
                                style="display: inline;">
                                <?= csrf_field() ?>
                                <button type="button" class="btn btn-link text-danger p-0 border-0" onclick="confirmDeleteInactive(<?= $driverslists['d_id'] ?>, '<?= $driverslists['d_nis'] ?>', '<?= $driverslists['d_name'] ?>')"><i class="fa fa-trash" title="Delete"></i></button>
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

    function confirmDeleteInactive(id, nis, name){
        Swal.fire({
            title: 'Apakah anda yakin menghapus data driver tersebut?',
            html: 'NIS : <b>' + nis + '</b><br>' + 'Nama Supir : <b>' + name + '</b><br>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Hapus'
        }).then((result) => {
            if(result.isConfirmed)
            {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

// function confirmDelete() {
//     return confirm("Apakah anda yakin ingin menghapus data ini?");
// }

$(function () {
    var table = $('#driverslisttbl').DataTable({
        pageLength: 15,
        lengthChange: false,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: false,
        scrollX: true,
        language: {
            paginate: {
                previous: "Previous",
                next: "Next"
            },
            search: "Search:",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri"
        },
        initComplete: function () {
            $('#table-filter').append($('.dataTables_filter input'));
            $('.dataTables_filter').remove();
        }
    });

    table.on('order.dt search.dt draw.dt', function () {
        let i = 1;
        table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell) {
            cell.innerHTML = i++;
        });
    }).draw();
});

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
