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

<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Vehicle Inventory</h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
               <li class="breadcrumb-item active">Inventory</li>
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
                  <?php if (function_exists('userpermission') && userpermission('lr_vech_invent_add')) : ?>
                  <a href="<?= base_url('inventory/addinventory'); ?>" class="btn btn-primary mr-2">
                     <i class="fa fa-plus"></i> Add New Checklist
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
                        <th>Jenis Mobil</th>
                        <th>Tahun</th>
                        <th>Lengkap</th>
                        <th>Rusak</th>
                        <th>Tidak Lengkap</th>
                        <th>Waktu Pengecekan</th>
                        <?php if(userpermission('lr_vech_list_edit') || userpermission('lr_vech_list_view')): ?>
                        <th>Action</th>
                        <?php endif; ?>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if(!empty($inventorylist)) { $count = 1; foreach($inventorylist as $inventorylists) { ?>
                     <tr>
                        <td><?= esc($count); $count++; ?></td>
                        <td><?= esc($inventorylists['iv_nopol']); ?></td>
                        <td><?= esc($inventorylists['iv_jenis']); ?></td>
                        <td><?= esc($inventorylists['iv_tahun']); ?></td>
                        <td><?= esc($inventorylists['lengkap_count']); ?> item</td>
                        <td><?= esc($inventorylists['rusak_count']); ?> item</td>
                        <td><?= esc($inventorylists['tidak_lengkap_count']); ?> item</td>
                        <td><?= date('d-m-Y', strtotime($inventorylists['iv_created_date'])); ?></td>
                        <td>
                           <?php if (function_exists('userpermission') && userpermission('lr_vech_invent_edit')) : ?>
                           <form action="<?= base_url('inventory/editinventory') ?>" method="POST" style="display: inline;">
                                <?= csrf_field() ?>
                                <input type="hidden" name="inv_id" value="<?= $inventorylists['iv_id'] ?>">
                                <button type="submit" class="btn btn-link text-primary p-0 border-0"><i class="fa fa-edit" title="Edit"></i></button>
                            </form>
                            |
                         <?php endif; ?>
                           <?php if(userpermission('lr_vech_invent_view')): ?>
                                <form action="<?= base_url('inventory/inventory_view') ?>" method="POST" style="display: inline;">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="inv_id" value="<?= $inventorylists['iv_id'] ?>">
                                    <button type="submit" class="btn btn-link text-success p-0 border-0"><i class="fa fa-eye" title="Detail"></i></button>
                                </form>
                            <?php endif;?>
                            <?php if (userpermission('lr_vech_invent_print') && $inventorylists['iv_is_active'] == 1): ?>
                            |
                            <a href="javascript:void(0)" 
                               class="btn btn-link text-info p-0 border-0"
                               title="Print / Download PDF"
                               onclick="showPrintOptions(<?= $inventorylists['iv_id'] ?>, '<?= esc($inventorylists['iv_nopol']) ?>', '<?= esc($inventorylists['iv_jenis']) ?>')">
                                <i class="fa fa-print" title="Print"></i>
                            </a>
                           <?php endif;?>
                           <?php if (function_exists('userpermission') && userpermission('lr_vech_invent_delete')) : ?>
                            |
                                 <form id="delete-form-<?= esc($inventorylists['iv_id']) ?>" action="<?= base_url('inventory/inventory_delete/' . $inventorylists['iv_id']) ?>" 
                                          method="post" 
                                          style="display: inline;">
                                        <?= csrf_field() ?>
                                    <button type="button" class="btn btn-link text-danger p-0 border-0" onclick="confirmDeleteInventory(<?= esc($inventorylists['iv_id'])?>, '<?= esc($inventorylists['iv_nopol']) ?>', '<?= esc($inventorylists['iv_jenis']) ?>', '<?= esc($inventorylists['iv_tahun']) ?>')">
                                      <i class="fa fa-trash" title="Delete"></i>
                                    </button>
                                 </form>
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
   const baseUrl = "<?= base_url() ?>"; 
    enableAutoLogout(7200, baseUrl + "login");

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
   function confirmDeleteInventory(id, nopol, vehicleType, vehicleTahun) {
     Swal.fire({
         title: 'Apakah anda yakin menghapus data inventaris mobil tersebut?',
         html: 'Nopol : <b>' + nopol + '</b>' + '<br>' + 'Jenis Mobil : <b>' + vehicleType + '</b>' + '<br>' + 'Tahun Kendaraan : <b>' + vehicleTahun + '</b>',
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

   function showPrintOptions(id, nopol, vehicleType) {
      Swal.fire({
          title: '<i class="fa fa-print" style="color:#17a2b8; margin-right:8px;"></i> Print / Download',
          html: '<div style="text-align:center; padding:10px 0;">' +
                '<div style="background:#f8f9fa; border-radius:8px; padding:15px; margin-bottom:15px;">' +
                '<table style="width:100%; font-size:14px; border-collapse:collapse;">' +
                '<tr><td style="padding:8px; text-align:left; color:#868e96; font-weight:600; font-size:12px; text-transform:uppercase;">Nomor Polisi</td>' +
                '<td style="padding:8px; text-align:right; font-weight:700; font-size:16px; color:#2c3e50;">' + nopol + '</td></tr>' +
                '<tr><td style="padding:8px; text-align:left; color:#868e96; font-weight:600; font-size:12px; text-transform:uppercase;">Jenis Mobil</td>' +
                '<td style="padding:8px; text-align:right; font-weight:700; font-size:16px; color:#2c3e50;">' + vehicleType + '</td></tr>' +
                '</table></div>' +
                '<p style="color:#666; font-size:13px; margin:0;">Pilih aksi yang ingin dilakukan</p>' +
                '</div>',
          showCancelButton: true,
          showDenyButton: true,
          confirmButtonText: '<i class="fa fa-download"></i> Download PDF',
          denyButtonText: '<i class="fa fa-print"></i> Print',
          cancelButtonText: 'Batal',
          confirmButtonColor: '#da0f0f',
          denyButtonColor: '#28a745',
          cancelButtonColor: '#d33',
          width: 420,
      }).then((result) => {
          if (result.isConfirmed) {
              window.location.href = '<?= base_url('inventory/inventory_download_pdf/') ?>' + id;
          } else if (result.isDenied) {
              window.location.href = '<?= base_url('inventory/inventory_print/') ?>' + id;
          }
      });
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