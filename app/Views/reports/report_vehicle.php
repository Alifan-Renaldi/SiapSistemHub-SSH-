<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<?php
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
            <h1 class="m-0 text-dark">Vehicle Report
            </h1>
         </div>
         
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url(); ?>dashboard">Dashboard</a></li>
               <li class="breadcrumb-item active">Vehicle Report</li>
            </ol>
         </div>
      </div>
   </div>
</div>

<section class="content">
   <div class="container-fluid">
    <form method="post" id="vehicle_report" class="card basicvalidation" action="<?php echo base_url();?>reports/vehicle">

        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
        
        <div class="card-body">
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="vehicle_name" class="form-label">Vehicle Status</label>
                        <select required="true" id="vehicle_name" class="form-control form-control-sm" name="vehicle_name">
                            <option value="all" <?php echo (isset($postData['vehicle_name']) && $postData['vehicle_name'] == 'all') ? 'selected' : ''; ?>>All Vehicles</option>
                            <option value="1" <?php echo (isset($postData['vehicle_name']) && $postData['vehicle_name'] == '1') ? 'selected' : ''; ?>>Active</option>
                            <option value="0" <?php echo (isset($postData['vehicle_name']) && $postData['vehicle_name'] == '0') ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="vehicle_owner" class="form-label">Vehicle Owner</label>
                        <select class="form-control form-control-sm select2-multiple" id="vehicle_owner" name="vehicle_owner[]" multiple="multiple">
                            <?php foreach($owner_list as $owner): ?>
                                <option value="<?= $owner['v_legal'] ?>" 
                                    <?= (isset($postData['vehicle_owner']) && in_array($owner['v_legal'], $postData['vehicle_owner'])) ? 'selected' : '' ?>>
                                    <?= $owner['v_legal'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="vehicle_type" class="form-label">Vehicle Type</label>
                        <select class="form-control form-control-sm select2-multiple-type" id="vehicle_type" name="vehicle_type[]" multiple="multiple">
                            <?php foreach($type_list as $type): ?>
                                <option value="<?= $type['v_name'] ?>" 
                                    <?= (isset($postData['vehicle_type']) && in_array($type['v_name'], $postData['vehicle_type'])) ? 'selected' : '' ?>>
                                    <?= $type['v_name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="report_type" class="form-label">Document Type</label>
                        <select required="true" id="report_type" class="form-control form-control-sm" name="report_type">
                            <option value="all" <?php echo (isset($postData['report_type']) && $postData['report_type'] == 'all') ? 'selected' : ''; ?>>All Report Type</option>
                            <option value="stnk" <?php echo (isset($postData['report_type']) && $postData['report_type'] == 'stnk') ? 'selected' : ''; ?>>STNK</option>
                            <option value="plat" <?php echo (isset($postData['report_type']) && $postData['report_type'] == 'plat') ? 'selected' : ''; ?>>PLAT</option>
                            <option value="kir" <?php echo (isset($postData['report_type']) && $postData['report_type'] == 'kir') ? 'selected' : ''; ?>>KIR</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                            <div class="form-group">
                        <label for="location_kir" class="form-label">Location KIR</label>
                        <select class="form-control form-control-sm" id="location_kir" name="location_kir">
                            <option value="">All Location</option>
                            <option value="BANDAR LAMPUNG" <?= (isset($postData['location_kir']) && $postData['location_kir'] == 'BANDAR LAMPUNG') ? 'selected' : '' ?>>BANDAR LAMPUNG</option>
                            <option value="LUAR BANDAR LAMPUNG" <?= (isset($postData['location_kir']) && $postData['location_kir'] == 'LUAR BANDAR LAMPUNG') ? 'selected' : '' ?>>LUAR BANDAR LAMPUNG</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="vehicle_from" class="form-label">Report From</label>
                        <input type="text" class="form-control form-control-sm datepicker" 
                               value="<?php echo isset($postData['vehicle_from']) ? $postData['vehicle_from'] : ''; ?>" 
                               id="vehicle_from" name="vehicle_from" placeholder="Date From">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="vehicle_to" class="form-label">Report To</label>
                        <input type="text" class="form-control form-control-sm datepicker" 
                               value="<?php echo isset($postData['vehicle_to']) ? $postData['vehicle_to'] : ''; ?>" 
                               id="vehicle_to" name="vehicle_to" placeholder="Date To">
                    </div>
                </div>
                
                
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-info btn-sm me-2 flex-grow-1">
                        <i class="fas fa-file-alt me-1"></i> Generate Report
                    </button>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="button" id="resetFilter" class="btn btn-outline-danger btn-sm flex-grow-1">
                        <i class="fas fa-redo me-1"></i> Reset Filters
                    </button>
                </div>
            </div>
            
            <input type="hidden" id="vehiclereport" name="vehiclereport" value="1">
        </div>
    </form>

    <div class="card">
        <div class="card-body p-0">
    <div class="card-footer">
         <div class="row">
            <div class="col-md-6">
                <div class="data-count-info h4">
                    <span class="badge badge-info">
                        <i class="fas fa-database me-1"></i>
                            Total Data : <span id="dataCount" > 
                                <?php
                                    $count = 0;
                                    if (isset($vehicle) && is_array($vehicle)) {
                                        $count = count($vehicle);
                                    }
                                    echo $count;
                                ?></span>
                    </span>
                </div>
            </div>
            <div class="col-md-6 text-right">
                        <div id="exportButtons" style="display: none;">
                        <button type="button" class="btn btn-success btn-sm" id="exportExcel">
                            <i class="fas fa-file-excel me-1"></i> Export Excel
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" id="exportPDF">
                            <i class="fas fa-file-pdf me-1"></i> Export PDF
                        </button>
                        <button type="button" class="btn btn-primary btn-sm" id="printReport">
                            <i class="fas fa-print me-1"></i> Print
                        </button>
                        </div>
                    </div>
            </div>
        </div>
            <?php if(!empty($vehicle)){ 
             ?>
                   <table  class="datatableexportvehicle table card-table">
                      <thead>
                        <tr>
                          <th class="w-1">No</th>
                          <th>Nomor Polisi</th>
                          <th>Pemilik</th>
                          <th>Jenis Mobil</th>
                          <?php if (function_exists('userpermission') && userpermission('lr_vech_detail_num')) : ?>
                          <th>Nomor Rangka</th>
                          <th>Nomor Mesin</th>
                          <th>Nomor Uji</th>
                          <?php endif; ?>
                          <th>JT Pajak</th>
                          <th>JT Plat</th>
                          <th>JT KIR</th>
                          <th>Proses KIR</th>
                          <th>Lokasi KIR</th>
                          <th>Catatan KIR</th>
                          <th>Status Mobil</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php if(!empty($vehicle)){  $count=1;
                           foreach($vehicle as $vehicles){
                           ?>
                        <tr>
                           <td> <?php echo $count; $count++; ?></td>
                            <td> <?php echo $vehicles['v_registration_no']; ?></td>
                           <td> <?php echo $vehicles['v_legal']; ?></td>
                           <td> <?php echo $vehicles['v_name']; ?></td>
                           <?php if (function_exists('userpermission') && userpermission('lr_vech_detail_num')) : ?>
                           <td><?php echo $vehicles['v_chassis_no']; ?></td>
                           <td><?php echo $vehicles['v_engine_no']; ?></td>
                           <td><?php echo $vehicles['v_uji_no']; ?></td>
                           <?php endif; ?>
                           <td>
                            <?php 
                                $stnk_expiry = $vehicles['v_stnk_expdate'];
                                if (!empty($stnk_expiry)) {
                                    $today = new DateTime();
                                    $expiry_date = new DateTime($stnk_expiry);
                                    $formatted_stnk_expiry = $expiry_date->format('d-m-Y');
                                        if ($today > $expiry_date) {
                                        echo '<span class="badge badge-danger" style="font-size: 1em; font-weight: bold;">STNK (' . $formatted_stnk_expiry . ')</span>';
                                                
                                        } else {
                                            $interval = $today->diff($expiry_date);
                                            if ($interval->days <= 59) {
                                                echo '<span class="badge badge-warning" style="font-size: 1em; font-weight: bold;">STNK (' . $formatted_stnk_expiry . ')</span>';

                                        } else {
                                            echo $formatted_stnk_expiry;
                                                }
                                            }
                                        } else {
                                            echo 'Tanggal STNK Tidak Tersedia';
                                    }
                                ?>
                            </td>
                            <td>
                            <?php 
                                $plat_expiry = $vehicles['v_plat_expdate'];
                                    if (!empty($plat_expiry)) {
                                        $today = new DateTime();
                                        $expiry_date = new DateTime($plat_expiry);
                                        $formatted_plat_expiry = $expiry_date->format('d-m-Y');
                                        if ($today > $expiry_date) {
                                            echo '<span class="badge badge-danger" style="font-size: 1em; font-weight: bold;">PLAT (' . $formatted_plat_expiry . ')</span>';
                                                
                                        } else {

                                        $interval = $today->diff($expiry_date);
                                        if ($interval->days <= 59) {
                                            echo '<span class="badge badge-warning" style="font-size: 1em; font-weight: bold;">PLAT (' . $formatted_plat_expiry . ')</span>';

                                        } else {
                                            echo $formatted_plat_expiry;
                                                }
                                            }
                                        } else {
                                            echo 'Tanggal PLAT Tidak Tersedia';
                                    }
                                ?>
                            </td>
                           <td>
                            <?php 
                                $kir_expiry = $vehicles['v_kir_expdate'];
                                    if (!empty($kir_expiry)) {
                                        $today = new DateTime();
                                        $expiry_date = new DateTime($kir_expiry);
                                        $formatted_kir_expiry = $expiry_date->format('d-m-Y');
                                    if ($today > $expiry_date) {
                                        echo '<span class="badge badge-danger" style="font-size: 1em; font-weight: bold;">KIR (' . $formatted_kir_expiry . ')</span>';
                                                
                                    } else {

                                        $interval = $today->diff($expiry_date);
                                        if ($interval->days <= 59) {
                                        echo '<span class="badge badge-warning" style="font-size: 1em; font-weight: bold;">KIR (' . $formatted_kir_expiry . ')</span>';

                                    } else {
                                        echo $formatted_kir_expiry;
                                            }
                                        }
                                    } else {
                                        echo 'Tanggal KIR Tidak Tersedia';
                                }
                            ?></td>
                           <td>
                            <?php 
                            $kir_process = $vehicles['v_kir_process_date'];
                            if (!empty($kir_process)) {
                                $process_date = new DateTime($kir_process);
                                echo esc($process_date->format('d-m-Y'));
                            } else {
                                echo 'Tanggal KIR Tidak Tersedia';
                            }
                            ?>
                            </td>
                            <td> <?php echo $vehicles['v_lokasi_kir']; ?></td>
                            <td> <?php echo $vehicles['v_notes_lokasikir']; ?></td>
                           <td>
                            <?php if ($vehicles['v_is_active'] == 1): ?>
                                <span class="badge badge-success">Active</span>
                            <?php elseif ($vehicles['v_is_active'] == 0): ?>
                                <span class="badge badge-danger">Inactive</span>
                            <?php endif; ?>
                        </td>
                        </tr>
                        <?php } } ?>
                      </tbody>
                    </table>
                     <?php }  ?>
        </div>
      </div>
      <br>
   </div>
</section>
<?= view('layout/footer') ?>

<script src="<?= base_url('assets/autoLogout.js') ?>"></script>
<script>
    const baseUrl = "<?= base_url() ?>"; 
    enableAutoLogout(7200, baseUrl + "login");
    
$(document).ready(function() {
    function initDatepicker(element) {
        element.datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
            todayHighlight: true
        });
    }

    function handleVehicleSelection() {
        var selectedSTNK = $('#vehicle_name').val();
        var fromDate = $('#vehicle_from');
        var toDate = $('#vehicle_to');
        
        if (selectedSTNK === 'all') {
            fromDate.prop('readonly', true).val('').datepicker('destroy');
            toDate.prop('readonly', true).val('').datepicker('destroy');
            fromDate.removeAttr('required');
            toDate.removeAttr('required');
            
            fromDate.removeClass('datepicker').attr('type', 'text');
            toDate.removeClass('datepicker').attr('type', 'text');
        } else {
            fromDate.prop('readonly', false);
            toDate.prop('readonly', false);
            fromDate.removeAttr('required');
            toDate.removeAttr('required');
            
            if (!fromDate.hasClass('hasDatepicker')) {
                fromDate.addClass('datepicker');
                initDatepicker(fromDate);
            }
            if (!toDate.hasClass('hasDatepicker')) {
                toDate.addClass('datepicker');
                initDatepicker(toDate);
            }
        }
    }

    function toggleActionButtons(show) {
        if (show) {
            $('#exportExcel, #exportPDF, #printReport').show();
        } else {
            $('#exportExcel, #exportPDF, #printReport').hide();
        }
    }

    function checkAndShowExportButtons() {
        const $tbody = $('.datatableexportvehicle tbody');
        const hasData = $tbody.children('tr').length > 0 && !$tbody.find('tr td[colspan]').length;
        if (hasData) {
            $('#exportButtons').show();
        } else {
            $('#exportButtons').hide();
        }
    }
    checkAndShowExportButtons();

    $('.select2-multiple').select2({
        placeholder: "Select Owners",
        allowClear: true
    });
    $('.select2-multiple-type').select2({
        placeholder: "Select Types",
        allowClear: true
    });

    function resetAllFilters() {
    $('#vehicle_name').val('all').trigger('change');
    $('#vehicle_from').val('');
    $('#vehicle_to').val('');
    $('.select2-multiple').val(null).trigger('change');
    $('.select2-multiple-type').val(null).trigger('change');
    $('#location_kir').val('');
    $('#report_type').val('all').trigger('change');
    
    if ($.fn.DataTable.isDataTable('.datatableexportvehicle')) {
        $('.datatableexportvehicle').DataTable().destroy();
    }
    
    $('.datatableexportvehicle tbody').empty();
    $('.datatableexportvehicle').hide();
    $('#dataCount').text('0');
    toggleActionButtons(false);
    handleVehicleSelection();
    }

    $('.datepicker').each(function() {
        initDatepicker($(this));
    });

    handleVehicleSelection();
    
    $('#vehicle_name').change(function() {
        handleVehicleSelection();
    });
    
    $('#resetFilter').click(function() {
        resetAllFilters();
    });

    $('#exportExcel').click(function() {
    var formData = $('#vehicle_report').serialize();
    
    var btn = $(this);
    btn.html('<i class="fas fa-spinner fa-spin"></i> Processing...');
    btn.prop('disabled', true);
    
    window.location.href = '<?= base_url(); ?>reports/export_vehicle_excel?' + formData;
    
    setTimeout(function() {
        btn.html('<i class="fas fa-file-excel me-1"></i> Export Excel');
        btn.prop('disabled', false);
    }, 2000);
});

$('#exportPDF').click(function() {
    var formData = $('#vehicle_report').serialize();
    
    window.location.href = '<?= base_url(); ?>reports/export_vehicle_pdf?' + formData;
});

$('#printReport').click(function() {
    function formatDate(date) {
        if (!date) return '';
        var d = new Date(date),
            day = '' + d.getDate(),
            month = '' + (d.getMonth() + 1),
            year = d.getFullYear();

        if (day.length < 2) day = '0' + day;
        if (month.length < 2) month = '0' + month;

        return day + '/' + month + '/' + year;
    }

    function formatTime(date) {
        if (!date) return '';
        var d = new Date(date),
            hours = '' + d.getHours(),
            minutes = '' + d.getMinutes();

        if (hours.length < 2) hours = '0' + hours;
        if (minutes.length < 2) minutes = '0' + minutes;

        return hours + ':' + minutes;
    }

    var table = $('.datatableexportvehicle').DataTable();
    var originalPageLength = table.page.len();
    table.page.len(-1).draw();
    
    var vehicleStatus = $('#vehicle_name option:selected').text();
    var dateFrom = $('#vehicle_from').val() || 'all';
    var dateTo = $('#vehicle_to').val() || 'all';
    var vehicleOwner = $('#vehicle_owner').val() || '';
    var vehicleType = $('#vehicle_type').val() || '';
    var reportType = $('#report_type option:selected').text();
    var locationKir = $('#location_kir option:selected').text() || 'All Location';
    
    var printTable = $('<table>').addClass('print-table').css({
        'width': '100%',
        'border-collapse': 'collapse'
    });
    
    printTable.append($('.datatableexportvehicle thead').clone());
    
    var tbody = $('<tbody>');
    table.rows({ search: 'applied' }).nodes().each(function(row) {
        tbody.append($(row).clone());
    });
    printTable.append(tbody);
    
    var printWindow = window.open('', '', 'height=1000,width=1000');
    
    // Get current date and time
    var currentDate = new Date();
    var formattedDate = formatDate(currentDate);
    var formattedTime = formatTime(currentDate);
    
    printWindow.document.write(`
        <html>
        <head>
            <title>Vehicle Report - SSH Group</title>
            <style>
                @page { size: A4 portrait; margin: 1cm; }
                body { font-family: "Segoe UI", Arial, sans-serif; margin: 0; padding: 20px; color: #333; }
                .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #0066cc; padding-bottom: 10px; }
                .company-name { font-size: 24px; font-weight: bold; color: #0066cc; margin-bottom: 5px; }
                .report-info { margin-bottom: 20px; font-size: 12px; }
                .report-filters { background: #f5f5f5; padding: 10px; border-radius: 5px; margin-bottom: 20px; font-size: 12px; }
                .filter-row { display: flex; flex-wrap: wrap; margin-bottom: 5px; }
                .filter-label { font-weight: bold; min-width: 120px; }
                .print-table { width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 12px; }
                .print-table th { background-color: #0066cc; color: white; padding: 8px; text-align: left; }
                .print-table td { padding: 6px 8px; border-bottom: 1px solid #ddd;}
                .print-table tr:nth-child(even) { background-color: #f9f9f9; }
                .footer { margin-top: 20px; font-size: 11px; text-align: right; border-top: 1px solid #ddd; padding-top: 10px; }
                .badge { padding: 3px 6px; border-radius: 3px; font-size: 11px; font-weight: bold; }
                .badge-success { background-color: #28a745; color: white; }
                .badge-danger { background-color: #dc3545; color: white; }
                .badge-dark { background-color: #343a40; color: white; }
                .badge-warning { background-color: #FFC107; color: black; }
                .page-break { page-break-after: always; }
            </style>
        </head>
        <body>
            <div class="header">
                <div class="company-name">Vehicle Report</div>
                <div class="report-info">
                <div>Generated on: ${formattedDate} at ${formattedTime}</div>
                <div>Total Records: ${table.rows({ search: 'applied' }).count()}</div>
            </div>
            </div>
            
            <div class="report-filters">
                <div class="filter-row"><span class="filter-label">Report Period:</span> ${dateFrom} to ${dateTo}</div>
                <div class="filter-row"><span class="filter-label">Vehicle Status:</span> ${vehicleStatus}</div>
                <div class="filter-row"><span class="filter-label">Vehicle Owner:</span> ${vehicleOwner}</div>
                <div class="filter-row"><span class="filter-label">Vehicle Type:</span> ${vehicleType}</div>
                <div class="filter-row"><span class="filter-label">Document Type:</span> ${reportType}</div>
                <div class="filter-row"><span class="filter-label">Location KIR:</span> ${locationKir}</div>
            </div>
    `);
    
    printWindow.document.write(printTable[0].outerHTML);
    
    printWindow.document.write(`
            <div class="footer">
                Document - SSH Group | ${new Date().getFullYear()}
            </div>
        </body>
        </html>
    `);
    
    printWindow.document.close();
    
    // Restore original pagination after a short delay
    setTimeout(function() {
        table.page.len(originalPageLength).draw();
        printWindow.focus();
        printWindow.print();
        printWindow.close();
    }, 500);
});
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