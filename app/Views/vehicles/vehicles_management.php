
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
            <h1 class="m-0 text-dark">Vehicle List</h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
               <li class="breadcrumb-item active">Vehicle</li>
            </ol>
         </div>
      </div>
   </div>
</section>

<section class="content">
   <div class="container-fluid">
      <div class="card">
         <div class="card-body p-0">
            <div class="d-flex align-items-center justify-content-between p-3">
               <div>
                  <?php if (function_exists('userpermission') && userpermission('lr_vech_add')) : ?>
                  <a href="<?= base_url('vehicles/addvehicle'); ?>" class="btn btn-primary mr-2">
                     <i class="fa fa-plus"></i> Add Vehicle
                  </a>
                  <?php endif; ?>
            
                  <?php if (function_exists('userpermission') && userpermission('lr_vech_group')) : ?>
                  <a href="<?= base_url('vehicles/vehiclegroup'); ?>" class="btn btn-info mr-2">
                     <i class="fa fa-truck-pickup"></i> Vehicle Type
                  </a>
                  <a href="<?= base_url('vehicles/vehicleowner'); ?>" class="btn btn-info mr-2">
                     <i class="fas fa-id-card-alt"></i> Vehicle Owner
                  </a>
                  <?php endif; ?>
               </div>
               <div id="table-filter" class="d-flex align-items-center">
                  <span class="mr-2">Search:</span>
               </div>
            </div>
            <div class="table-responsive">
               <table id="vehiclelisttbl" class="table card-table table-vcenter text-nowrap">
                  <thead>
                     <tr>
                        <th class="w-1">No</th>
                        <th>Nomor Polisi</th>
                        <th>Pemilik</th>
                        <th>Jenis Mobil</th>
                        <th>JT Pajak</th>
                        <th>JT Plat</th>
                        <th>JT KIR</th>
                        <th>Proses KIR</th>
                        <th>Status</th>
                        <?php if(userpermission('lr_vech_list_edit') || userpermission('lr_vech_list_view')): ?>
                        <th>Action</th>
                        <?php endif; ?>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if(!empty($vehiclelist)) { $count = 1; foreach($vehiclelist as $vehiclelists) { ?>
                     <tr
                        data-modified-date="<?= esc($vehiclelists['v_modified_date'] ?? '') ?>"
                        data-v-type="<?= esc($vehiclelists['v_type'] ?? '') ?>"
                        data-v-name="<?= esc($vehiclelists['v_name'] ?? '') ?>">

                        <td><?= esc($count); $count++; ?></td>
                        <td><?= esc($vehiclelists['v_registration_no']); ?></td>
                        <td><?= esc($vehiclelists['v_legal']); ?></td>
                        <td><?= esc($vehiclelists['v_name']); ?></td>
                        <td>
                           <?php
                           $pajak_exp_str = $vehiclelists['v_stnk_expdate'];
                           $pajak_exp_obj = new DateTime($pajak_exp_str);
                           $pajak_exp = $pajak_exp_obj->format('d-m-Y');
                           
                           $date = new dateTime(date('Y-m-d'));
                           $dateNow = $date->diff($pajak_exp_obj);
                           $dateExp = $dateNow->format('%R%a');

                           if ($dateExp < 0) {
                              echo '<span class="badge badge-danger" style="font-size:12px; width: 100%; max-width:6rem;">
                              '. $pajak_exp .'
                              <br>
                              Expired ' . abs((int)$dateExp) . ' Hari' . 
                              '</span>';
                           } else if ($dateExp < 15) {
                              echo '<span class="badge badge-warning" style="font-size: 12px; width: 100%; max-width:6rem;">
                              '. $pajak_exp .'
                              <br>
                              Warning ' . abs((int)$dateExp) . ' Hari' .
                               '</span>';
                           } else {
                              echo '<span class="" style="font-size: 15px; width: 100%; max-width:6rem;">
                              ' . $pajak_exp . '</span>';
                           }
                           ?>
                        </td>
                        <td>
                           <?php 
                           $plat_exp_str = $vehiclelists['v_plat_expdate'];
                           $plat_exp_obj = new DateTime($plat_exp_str);
                           $plat_exp = $plat_exp_obj->format('d-m-Y');
                           
                           $date = new dateTime(date('Y-m-d'));
                           $dateNow = $date->diff($plat_exp_obj);
                           $dateExp = $dateNow->format('%R%a');

                           if ($dateExp < 0) {
                              echo '<span class="badge badge-danger" style="font-size:12px; width: 100%; max-width:6rem;">
                              '. $plat_exp .'
                              <br>
                              Expired ' . abs((int)$dateExp) . ' Hari' . 
                              '</span>';
                           } else if ($dateExp < 15) {
                              echo '<span class="badge badge-warning" style="font-size: 12px; width: 100%; max-width:6rem;">
                              '. $plat_exp .'
                              <br>
                              Warning ' . abs((int)$dateExp) . ' Hari' .
                               '</span>';
                           } else {
                              echo '<span class="" style="font-size: 15px; width: 100%; max-width:6rem;">
                              ' . $plat_exp . '</span>';
                           }
                           ?>
                        </td>
                        <td>
                           <?php 
                           $kir_exp_str = $vehiclelists['v_kir_expdate'];
                           $kir_exp_obj = new DateTime($kir_exp_str);
                           $kir_exp = $kir_exp_obj->format('d-m-Y');
                           
                           $date = new dateTime(date('Y-m-d'));
                           $dateNow = $date->diff($kir_exp_obj);
                           $dateExp = $dateNow->format('%R%a');

                           if ($dateExp < 0) {
                              echo '<span class="badge badge-danger" style="font-size:12px; width: 100%; max-width:6rem;">
                              '. $kir_exp .'
                              <br>
                              Expired ' . abs((int)$dateExp) . ' Hari' . 
                              '</span>';
                           } else if ($dateExp < 15) {
                              echo '<span class="badge badge-warning" style="font-size: 12px; width: 100%; max-width:6rem;">
                              '. $kir_exp .'
                              <br>
                              Warning ' . abs((int)$dateExp) . ' Hari' .
                               '</span>';
                           } else {
                              echo '<span class="" style="font-size: 15px; width: 100%; max-width:6rem;">
                              ' . $kir_exp . '</span>';
                           }
                           ?>
                        </td>
                        <td>
                            <?php 
                            $kir_process_str = $vehiclelists['v_kir_process_date'];
                            $kir_process_obj = new DateTime($kir_process_str);
                            $kir_process = $kir_process_obj->format('d-m-Y');
                            
                            $date = new dateTime(date('Y-m-d'));
                            $dateNow = $date->diff($kir_process_obj);
                            $dateExp = $dateNow->format('%R%a');

                           if ($dateExp < 0) {
                              echo '<span class="badge badge-danger" style="font-size:12px; width: 100%; max-width:6rem;">
                              '. $kir_process .'
                              <br>
                              Expired ' . abs((int)$dateExp) . ' Hari' . 
                              '</span>';
                           } else if ($dateExp < 15) {
                              echo '<span class="badge badge-warning" style="font-size: 12px; width: 100%; max-width:6rem;">
                              '. $kir_process .'
                              <br>
                              Warning ' . abs((int)$dateExp) . 'Hari' .
                               '</span>';
                           } else {
                              echo '<span class="" style="font-size: 15px; width: 100%; max-width:6rem;">
                              ' . $kir_process . '</span>';
                           }
                            ?>
                        </td>
                        <td>
                           <span class="badge <?= ($vehiclelists['v_is_active'] == '1') ? 'badge-success' : 'badge-danger'; ?>" style="font-size:14px;">
                              <?= ($vehiclelists['v_is_active'] == '1') ? 'Active' : 'Inactive'; ?>
                           </span>  
                        </td>
                        <td>
                           <?php if (function_exists('userpermission') && userpermission('lr_vech_list_edit')) : ?>
                                 <form action="<?= base_url('vehicles/editvehicle') ?>" method="POST" style="display: inline;">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="vehicle_id" value="<?= $vehiclelists['v_id'] ?>">
                                    <button type="submit" class="btn btn-link text-primary p-0 border-0"><i class="fa fa-edit" title="Edit"></i></button>
                                 </form>
                                 |
                           <?php endif; ?>
                           <?php if (function_exists('userpermission') && userpermission('lr_vech_list_view')) : ?>
                                 <form action="<?= base_url('vehicles/viewvehicle') ?>" method="POST" style="display: inline;">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="vehicle_id" value="<?= $vehiclelists['v_id'] ?>">
                                    <button type="submit" class="btn btn-link text-success p-0 border-0"><i class="fa fa-eye" title="Detail"></i></button>
                                 </form>
                           <?php endif; ?>
                           <?php if (function_exists('userpermission') && userpermission('lr_vech_list_delete')) : ?>
                            |
                              <form id="delete-form-<?= $vehiclelists['v_id'] ?>" action="<?= base_url('vehicles/vehicle_delete/' . $vehiclelists['v_id']) ?>" method="post" style="display: inline;">
                                 <?= csrf_field() ?>
                                 <input type="hidden" name="vehicle_id" value="<?= $vehiclelists['v_id'] ?>">
                                 <button type="button" class="btn btn-link text-danger p-0 border-0" onclick="confirmDeleteVehicle(<?= $vehiclelists['v_id'] ?>, '<?= esc($vehiclelists['v_registration_no']) ?>', '<?= esc($vehiclelists['v_type']) ?>', '<?= esc($vehiclelists['v_legal']) ?>')">
                                    <i class="fa fa-trash" title="Delete"></i>
                                </button>
                              </form>
                           <?php endif; ?>
                           <?php if (!empty($vehiclelists['v_qr_code_path']) && $vehiclelists['v_is_active'] == 1) : ?>
                             |
                             <a href="javascript:void(0)" 
                                class="btn btn-link text-info p-0 border-0 ml-1"
                                title="QR Code"
                                onclick="viewQRCode(<?= $vehiclelists['v_id'] ?>, '<?= esc($vehiclelists['v_registration_no']) ?>', '<?= esc($vehiclelists['v_name']) ?>', '<?= esc($vehiclelists['v_type']) ?>')">
                                 <i class="fa fa-qrcode"></i>
                             </a>
                           <?php endif; ?>
                        </td>
                     </tr>
                     <?php } } ?>

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
function confirmDeleteVehicle(id, registrationNo, vehicleType, vehicleLegal) {
    Swal.fire({
        title: 'Apakah anda yakin menghapus data mobil tersebut?',
        html: 'Nopol : <b>' + registrationNo + '</b>' + '<br>' + 'Jenis Mobil : <b>' + vehicleType + '</b>' + '<br>' + 'Pemilik : <b>' + vehicleLegal + '</b>',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Hapus'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}

function viewQRCode(id, registrationNo, vehicleName, vehicleType) {
    Swal.fire({
        title: 'QR Code',
        html: '<div style="text-align:center;">' +
              '<img src="<?= base_url('vehicles/view_qrcode/') ?>' + id + '" width="270" height="270" alt="QR Code ' + registrationNo + '" style="border:2px solid #e9ecef; border-radius:8px; padding:8px; margin-bottom:16px;" />' +
              '<table style="width:100%; font-size:14px; border-collapse:collapse; margin-top:8px;">' +
              '<tr style="border-bottom:1px solid #f1f3f5;"><td style="padding:8px; text-align:left; color:#868e96; font-weight:600; font-size:12px; text-transform:uppercase;">Nopol</td><td style="padding:8px; text-align:right; font-weight:700; font-size:16px; color:#2c3e50;">' + registrationNo + '</td></tr>' +
              '<tr style="border-bottom:1px solid #f1f3f5;"><td style="padding:8px; text-align:left; color:#868e96; font-weight:600; font-size:12px; text-transform:uppercase;">Nama Kendaraan</td><td style="padding:8px; text-align:right; font-weight:600;">' + vehicleName + '</td></tr>' +
              '<tr><td style="padding:8px; text-align:left; color:#868e96; font-weight:600; font-size:12px; text-transform:uppercase;">Tipe Kendaraan</td><td style="padding:8px; text-align:right; font-weight:600;">' + vehicleType + '</td></tr>' +
              '</table></div>',
        showCancelButton: false,
        showDenyButton: true,
        confirmButtonText: '<i class="fa fa-download"></i> Download',
        denyButtonText: '<i class="fa fa-print"></i> Print',
        confirmButtonColor: '#3085d6',
        denyButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        width: 420,
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '<?= base_url('vehicles/download_qrcode/') ?>' + id;
        } else if (result.isDenied) {
            window.location.href = '<?= base_url('vehicles/print_qrcode/') ?>' + id;
        }
    });
}

$(document).ready(function () {
   var table = $('#vehiclelisttbl').DataTable({
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
