<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Survey Report</h1>
         </div>
         <!-- /.col -->
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
               <li class="breadcrumb-item active">Survey Report</li>
            </ol>
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->
   </div>
   <!-- /.container-fluid -->
</div>
<!-- Main content -->
<section class="content">
   <div class="container-fluid">
    <form method="post" id="survey_report" class="card basicvalidation" action="<?php echo base_url('reports/survey'); ?>">

        <?= csrf_field() ?>
        
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="survey_status" class="form-label">Survey Status</label>
                        <select required="true" id="survey_status" class="form-control form-control-sm" name="survey_status">
                            <option value="all survey" <?= (isset($postData['survey_status']) && $postData['survey_status'] == 'all survey') ? 'selected' : ''; ?>>All Survey</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="driver_status" class="form-label">Driver Status</label>
                        <select class="form-control form-control-sm" id="driver_status" name="driver_status">
                            <option value="">All Status</option>
                            <option value="1" <?= (isset($postData['driver_status']) && $postData['driver_status'] == '1') ? 'selected' : '' ?>>Active</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="survey_from" class="form-label">Report From</label>
                        <input type="text" class="form-control form-control-sm datepicker" 
                               value="<?= isset($postData['survey_from']) ? $postData['survey_from'] : ''; ?>" 
                               id="survey_from" name="survey_from" placeholder="Date From">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="survey_to" class="form-label">Report To</label>
                        <input type="text" class="form-control form-control-sm datepicker" 
                               value="<?= isset($postData['survey_to']) ? $postData['survey_to'] : ''; ?>" 
                               id="survey_to" name="survey_to" placeholder="Date To">
                    </div>
                </div>
                
                <!-- Action Buttons -->
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
            
            <input type="hidden" id="surveyreport" name="surveyreport" value="1">
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
                                    if (isset($survey) && is_array($survey)) {
                                        $count = count($survey);
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
            <?php if(!empty($survey)){ 
             ?>
                   <table  class="datatableexport table card-table">
                      <thead>
                        <tr>
                          <th class="w-1">No</th>
                           <th>Tanggal Survei</th>
                          <th>Petugas Survei</th>
                          <th>Nama Supir</th>
                          <th>Alamat</th>
                          <th>Kabupaten/Kota</th>
                          <th>Provinsi</th>
                          <th>Status Rumah</th>
                          <th>Kondisi Rumah</th>
                          <th>Jumlah Tanggungan</th>
                          <th>Status Supir</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php if(!empty($survey)){  $count=1;
                           foreach($survey as $surveys){
                           ?>
                        <tr>
                           <td> <?= esc($count); $count++; ?></td>
                           <td>
                               <?php 
                                $survey_date = $surveys['s_tanggal'];
                                if (empty($survey_date) || $survey_date == '0000-00-00' || $survey_date == '0000-00-00 00:00:00') {
                                    echo '00-00-0000';
                                } else {
                                    echo esc(date('d-m-Y', strtotime($survey_date)));
                                }
                            ?>
                           </td>
                           <td> <?= esc($surveys['s_petugas']); ?></td>
                           <td>
                                <?php
                                echo !empty($surveys['driver_name']) ? esc($surveys['driver_name']) : (!empty($surveys['s_supir']) ? esc($surveys['s_supir']) : '-');
                                ?>
                            </td>
                            <td>
                                <?php
                                echo !empty($surveys['driver_address']) ? esc($surveys['driver_address']) : (!empty($surveys['s_alamat']) ? esc($surveys['s_alamat']) : '-');
                                ?>
                            </td>
                            <td>
                                <?php
                                echo capitalEachWord(!empty($surveys['s_city_name']) ? esc($surveys['s_city_name']) :
                                     (!empty($surveys['s_kab']) ? esc($surveys['s_kab']) : '-'));
                                ?>
                            </td>
                            <td>
                                <?php
                                echo capitalEachWord(!empty($surveys['s_province_name']) ? esc($surveys['s_province_name']) : 
                                     (!empty($surveys['s_prov']) ? esc($surveys['s_prov']) : '-'));
                                ?>
                            </td>
                            <td> <?= esc($surveys['s_status_rumah']); ?></td>
                            <td> <?= esc($surveys['s_kondisi_rumah']); ?></td>
                            <td> <?= esc($surveys['s_tanggungan']); ?></td>
                            <td>
                                <?php 
                                    $status = $surveys['d_is_active'];
                                    if($status == 1) echo '<span class="badge badge-success">Active</span>';
                                    elseif($status == 0) echo '<span class="badge badge-danger">Inactive</span>';
                                    elseif($status == 2) echo '<span class="badge badge-dark">Blacklist</span>';
                                    elseif($status == 3) echo '<span class="badge badge-warning">Permission</span>';
                                    else echo 'Unknown';
                                ?>
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
    // Inisialisasi datepicker
    function initDatepicker(element) {
        element.datepicker({
            format: 'yyyy/mm/dd',
            autoclose: true,
            todayHighlight: true
        });
    }

    function handleDriverSelection() {
        var selectedSurvey = $('#survey_status').val();
        var fromDate = $('#survey_from');
        var toDate = $('#survey_to');
        
        if (selectedSurvey === 'all survey' || selectedSurvey === '1') {
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
        const $tbody = $('.datatableexport tbody');
        const hasData = $tbody.children('tr').length > 0 && !$tbody.find('tr td[colspan]').length;
        if (hasData) {
            $('#exportButtons').show();
        } else {
            $('#exportButtons').hide();
        }
    }
    checkAndShowExportButtons();

    function resetAllFilters() {
    $('#survey_status').val('all survey').trigger('change');
    $('#driver_status').val('').trigger('change');
    // Kosongkan field tanggal
    $('#survey_from').val('');
    $('#survey_to').val('');
    
    if ($.fn.DataTable.isDataTable('.datatableexport')) {
        $('.datatableexport').DataTable().destroy();
    }
    
    $('.datatableexport tbody').empty();
    $('.datatableexport').hide();
    $('#dataCount').text('0');
    toggleActionButtons(false);
    
    handleDriverSelection();
}

    $('.datepicker').each(function() {
        initDatepicker($(this));
    });

    handleDriverSelection();
    
    $('#survey_status').change(function() {
        handleDriverSelection();
    });
    
    $('#resetFilter').click(function() {
        resetAllFilters();
    });

    $('#exportExcel').click(function() {
    var formData = $('#survey_report').serialize();
    
    var btn = $(this);
    btn.html('<i class="fas fa-spinner fa-spin"></i> Processing...');
    btn.prop('disabled', true);
    
    window.location.href = '<?= base_url(); ?>reports/export_survey_excel?' + formData;
    
    setTimeout(function() {
        btn.html('<i class="fas fa-file-excel me-1"></i> Export Excel');
        btn.prop('disabled', false);
    }, 2000);
});

$('#exportPDF').click(function() {
    var formData = $('#survey_report').serialize();
    
    window.location.href = '<?= base_url(); ?>reports/export_survey_pdf?' + formData;
});

// Print Report
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

    var table = $('.datatableexport').DataTable();
    var originalPageLength = table.page.len();
    table.page.len(-1).draw();
    
    var surveyStatus = $('#survey_status option:selected').text();
    var driverStatus = $('#driver_status option:selected').text() || 'All Driver';
    var dateFrom = $('#survey_from').val() || 'All survey';
    var dateTo = $('#survey_to').val() || 'All survey';
    
    var printTable = $('<table>').addClass('print-table').css({
        'width': '100%',
        'border-collapse': 'collapse'
    });
    
    printTable.append($('.datatableexport thead').clone());
    
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
            <title>Survey Report - SSH Group</title>
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
                .print-table td { padding: 6px 8px; border-bottom: 1px solid #ddd; }
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
                <div class="company-name">Survey Report</div>
                <div class="report-info">
                <div>Generated on: ${formattedDate} at ${formattedTime}</div>
                <div>Total Records: ${table.rows({ search: 'applied' }).count()}</div>
            </div>
            </div>
            
            <div class="report-filters">
                <div class="filter-row"><span class="filter-label">Report Period:</span> ${dateFrom} to ${dateTo}</div>
                <div class="filter-row"><span class="filter-label">Survey Status:</span> ${surveyStatus}</div>
                <div class="filter-row"><span class="filter-label">Driver Status:</span> ${driverStatus}</div>
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
</script>