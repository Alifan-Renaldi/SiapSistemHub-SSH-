<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<style>
    .col-no { width: 5%; }
    .col-tgl { width: 13%; }
    .col-name { width: 20%; }
    .col-categ { width: 10%; }
    .col-materi { width: 13%; }
    .col-tema { width: 15%; }
    .col-status { width: 13%; }
</style>

<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Training Report</h1>
         </div>
         <!-- /.col -->
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
               <li class="breadcrumb-item active">Training Report</li>
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
    <form method="post" id="training_report" class="card basicvalidation" action="<?= base_url('reports/training'); ?>">
        <?= csrf_field() ?>
        
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="training_status" class="form-label">Training Status</label>
                        <select required="true" id="training_status" class="form-control form-control-sm" name="training_status">
                            <option value="all training" <?= (isset($postData['training_status']) && $postData['training_status'] == 'all training') ? 'selected' : ''; ?>>All Training</option>
                            <option value="1" <?= (isset($postData['training_status']) && $postData['training_status'] == '1') ? 'selected' : ''; ?>>Already</option>
                            <option value="0" <?= (isset($postData['training_status']) && $postData['training_status'] == '0') ? 'selected' : ''; ?>>Yet</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="driver_status" class="form-label">Driver Status</label>
                        <select class="form-control form-control-sm" id="driver_status" name="driver_status">
                            <option value="">All Status</option>
                            <option value="1" <?= (isset($postData['driver_status']) && $postData['driver_status'] == '1') ? 'selected' : '' ?>>Active</option>
                            <option value="0" <?= (isset($postData['driver_status']) && $postData['driver_status'] == '0') ? 'selected' : '' ?>>Inactive</option>
                            <option value="2" <?= (isset($postData['driver_status']) && $postData['driver_status'] == '2') ? 'selected' : '' ?>>Blacklist</option>
                            <option value="3" <?= (isset($postData['driver_status']) && $postData['driver_status'] == '3') ? 'selected' : '' ?>>Permission</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="training_count" class="form-label">Training Attendance</label>
                        <select class="form-control form-control-sm" id="training_count" name="training_count">
                            <option value="">All Drivers</option>
                            <option value="3" <?= (isset($postData['training_count']) && $postData['training_count'] == '3') ? 'selected' : '' ?>>Attended ≥3 Trainings (Different Themes)</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="training_from" class="form-label">Report From</label>
                        <input type="text" class="form-control form-control-sm datepicker" 
                               value="<?= isset($postData['training_from']) ? $postData['training_from'] : ''; ?>" 
                               id="training_from" name="training_from" placeholder="Date From">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="training_to" class="form-label">Report To</label>
                        <input type="text" class="form-control form-control-sm datepicker" 
                               value="<?= isset($postData['training_to']) ? $postData['training_to'] : ''; ?>" 
                               id="training_to" name="training_to" placeholder="Date To">
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
            
            <input type="hidden" id="trainingreport" name="trainingreport" value="1">
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
                                    if (isset($training) && is_array($training)) {
                                        $count = count($training);
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
            <?php if(!empty($training)): ?>
                   <table class="datatableexport table card-table">
                      <thead>
                        <tr>
                          <th class="col-no">No</th>
                          <th class="col-tgl">Tanggal Training</th>
                          <th class="col-name">Nama Supir</th>
                          <th class="col-categ">Kategori</th>
                          <th class="col-materi">Pemateri</th>
                          <th class="col-tema">Tema</th>
                          <th class="col-status">Status Supir</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php if(!empty($training)): 
                           $count = 1;
                           foreach($training as $trainings): ?>
                        <tr>
                           <td> <?= $count; $count++; ?></td>
                           <td>
                               <?php 
                                $training_date = $trainings['tr_tanggal'];
                                if (empty($training_date) || $training_date == '0000-00-00' || $training_date == '0000-00-00 00:00:00') {
                                    echo '00-00-0000';
                                } else {
                                    echo esc(date('d-m-Y', strtotime($training_date)));
                                }
                            ?>
                           </td>
                           <td>
                                <?= !empty($trainings['tr_supir']) ? esc($trainings['tr_supir']) : (!empty($trainings['tr_supir']) ? esc($trainings['tr_supir']) : '-'); ?>
                            </td>
                            <td> <?= esc($trainings['tr_kategori']); ?></td>
                            <td> <?= esc($trainings['tr_pemateri']); ?></td>
                            <td> <?= esc($trainings['tr_tema']); ?></td>
                            <td>
                                <?php 
                                    $status = $trainings['d_is_active'];
                                    if($status == 1) echo '<span class="badge badge-success">Active</span>';
                                    elseif($status == 0) echo '<span class="badge badge-danger">Inactive</span>';
                                    elseif($status == 2) echo '<span class="badge badge-dark">Blacklist</span>';
                                    elseif($status == 3) echo '<span class="badge badge-warning">Permission</span>';
                                    else echo 'Unknown';
                                ?>
                            </td>
                        </tr>
                        <?php endforeach; endif; ?>
                      </tbody>
                    </table>
            <?php endif; ?>
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
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });
    }

    function handleDriverSelection() {
        var selectedTraining = $('#training_status').val();
        var fromDate = $('#training_from');
        var toDate = $('#training_to');
        
        if (selectedTraining === 'all training' || selectedTraining === '0') {
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
        $('#training_status').val('all training').trigger('change');
        $('#driver_status').val('').trigger('change');
        $('#training_count').val('').trigger('change');
        $('#training_from').val('');
        $('#training_to').val('');
        
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
    
    $('#training_status').change(function() {
        handleDriverSelection();
    });
    
    $('#resetFilter').click(function() {
        resetAllFilters();
    });

    $('#exportExcel').click(function() {
        var formData = $('#training_report').serialize();
        
        var btn = $(this);
        btn.html('<i class="fas fa-spinner fa-spin"></i> Processing...');
        btn.prop('disabled', true);
        
        window.location.href = '<?= base_url(); ?>reports/export_training_excel?' + formData;
        
        setTimeout(function() {
            btn.html('<i class="fas fa-file-excel me-1"></i> Export Excel');
            btn.prop('disabled', false);
        }, 2000);
    });

    $('#exportPDF').click(function() {
        var formData = $('#training_report').serialize();
        window.location.href = '<?= base_url(); ?>reports/export_training_pdf?' + formData;
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

        var table = $('.datatableexport').DataTable();
        var originalPageLength = table.page.len();
        table.page.len(-1).draw();
        
        var trainingStatus = $('#training_status option:selected').text();
        var driverStatus = $('#driver_status option:selected').text() || 'All Driver';
        var dateFrom = $('#training_from').val() || 'All training';
        var dateTo = $('#training_to').val() || 'All training';
        
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
                <title>Training Report - SSH Group</title>
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
                    <div class="company-name">Training Report</div>
                    <div class="report-info">
                    <div>Generated on: ${formattedDate} at ${formattedTime}</div>
                    <div>Total Records: ${table.rows({ search: 'applied' }).count()}</div>
                </div>
                </div>
                
                <div class="report-filters">
                    <div class="filter-row"><span class="filter-label">Report Period:</span> ${dateFrom} to ${dateTo}</div>
                    <div class="filter-row"><span class="filter-label">Training Status:</span> ${trainingStatus}</div>
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
        
        setTimeout(function() {
            table.page.len(originalPageLength).draw();
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        }, 500);
    });
});
</script>