<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<style>
    .form-equal-height {
        height: 31px;
    }
    
    .select2-container--default .select2-selection--single {
        height: 31px;
        padding: 5px 12px;
    }
</style>

<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Loan Report</h1>
         </div>
         <!-- /.col -->
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
               <li class="breadcrumb-item active">Loan Report</li>
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
    <form method="post" id="loan_report" class="card basicvalidation" action="<?php echo base_url('reports/loan'); ?>">
        <?= csrf_field() ?>
        
        <div class="card-body">
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="loan_status" class="form-label">Loan Status</label>
                        <select required="true" id="loan_status" class="form-control form-control-sm" name="loan_status">
                            <option value="all loan" <?= (isset($postData['loan_status']) && $postData['loan_status'] == 'all loan') ? 'selected' : ''; ?>>All Loan</option>
                            <option value="0" <?= (isset($postData['loan_status']) && $postData['loan_status'] == '0') ? 'selected' : ''; ?>>Paid</option>
                            <option value="1" <?= (isset($postData['loan_status']) && $postData['loan_status'] == '1') ? 'selected' : ''; ?>>Unpaid</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="driver_status" class="form-label">Driver Status</label>
                        <select class="form-control form-control-sm" id="driver_status" name="driver_status">
                            <option value="">All Driver</option>
                            <option value="1" <?= (isset($postData['driver_status']) && $postData['driver_status'] == '1') ? 'selected' : ''; ?>>Active</option>
                            <option value="0" <?= (isset($postData['driver_status']) && $postData['driver_status'] == '0') ? 'selected' : '' ?>>Inactive</option>
                            <option value="2" <?= (isset($postData['driver_status']) && $postData['driver_status'] == '2') ? 'selected' : '' ?>>Blacklist</option>
                            <option value="3" <?= (isset($postData['driver_status']) && $postData['driver_status'] == '3') ? 'selected' : '' ?>>Permission</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="driver_name" class="form-label">Driver Name</label>
                        <select class="form-control form-control-sm select2 form-equal-height" id="driver_name" name="driver_name">
                            <option value="">All Driver</option>
                            <?php if(!empty($drivers)): ?>
                                <?php foreach($drivers as $driver): ?>
                                    <option value="<?= esc($driver['d_name']) ?>" 
                                        <?= (isset($postData['driver_name']) && $postData['driver_name'] == $driver['d_name']) ? 'selected' : '' ?>>
                                        <?= esc($driver['d_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="loan_type" class="form-label">Loan Type</label>
                        <select class="form-control form-control-sm" id="loan_type" name="loan_type">
                            <option value="">All Type</option>
                            <option value="Pribadi" <?= (isset($postData['loan_type']) && $postData['loan_type'] == 'Pribadi') ? 'selected' : '' ?>>Pribadi</option>
                            <option value="Klaim" <?= (isset($postData['loan_type']) && $postData['loan_type'] == 'Klaim') ? 'selected' : '' ?>>Klaim</option>
                            <option value="Sparepart" <?= (isset($postData['loan_type']) && $postData['loan_type'] == 'Sparepart') ? 'selected' : '' ?>>Sparepart</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="payment" class="form-label">Payment Type</label>
                        <select class="form-control form-control-sm" id="payment" name="payment">
                            <option value="">All Type</option>
                            <option value="POT. SUJ 30%" <?= (isset($postData['payment']) && $postData['payment'] == 'POT. SUJ 30%') ? 'selected' : '' ?>>POT. SUJ 30%</option>
                            <option value="POT. SUJ Bertahap" <?= (isset($postData['payment']) && $postData['payment'] == 'POT. SUJ Bertahap') ? 'selected' : '' ?>>POT. SUJ Bertahap</option>
                            <option value="CASH" <?= (isset($postData['payment']) && $postData['payment'] == 'CASH') ? 'selected' : '' ?>>CASH</option>
                            <option value="CASH + SUJ 30%" <?= (isset($postData['payment']) && $postData['payment'] == 'CASH + SUJ 30%') ? 'selected' : '' ?>>CASH + SUJ 30%</option>
                            <option value="POT. SUJ Langsung" <?= (isset($postData['payment']) && $postData['payment'] == 'POT. SUJ Langsung') ? 'selected' : '' ?>>POT. SUJ Langsung</option>
                            <option value="Tunggu Nilai Klaim" <?= (isset($postData['payment']) && $postData['payment'] == 'Tunggu Nilai Klaim') ? 'selected' : '' ?>>Tunggu Nilai Klaim</option>
                            <option value="Tidak Klaim" <?= (isset($postData['payment']) && $postData['payment'] == 'Tidak Klaim') ? 'selected' : '' ?>>Tidak Klaim</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="loan_from" class="form-label">Report From</label>
                        <input type="text" class="form-control form-control-sm datepicker" value="<?= isset($postData['loan_from']) ? $postData['loan_from'] : ''; ?>" id="loan_from" name="loan_from" placeholder="Date From">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="loan_to" class="form-label">Report To</label>
                        <input type="text" class="form-control form-control-sm datepicker" value="<?= isset($postData['loan_to']) ? $postData['loan_to'] : ''; ?>" id="loan_to" name="loan_to" placeholder="Date To">
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
            
            <input type="hidden" id="loanreport" name="loanreport" value="1">
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
                                        if (isset($loan) && is_array($loan)) {
                                            $count = count($loan);
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
         
         <?php if(!empty($loan)){ 
             ?>
                   <table class="datatableexport table card-table">
                      <thead>
                        <tr>
                          <th class="w-1">No</th>
                          <th>Tanggal</th>
                          <th>Mobil</th>
                          <th>Nama Supir</th>
                          <th>Jenis Hutang</th>
                          <th>Keterangan</th>
                          <th>Cara Potong</th>
                          <th>Nominal</th>
                          <th>Disetujui oleh</th>
                          <th>Status Hutang</th>
                          <th>Status Supir</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php if(!empty($loan)){  $count=1;
                           foreach($loan as $loans){
                           ?>
                        <tr>
                        <td><?= $count; $count++; ?></td>
                        <td>
                            <?php 
                                $loan_date = $loans['l_tanggal'];
                                if (empty($loan_date) || $loan_date == '0000-00-00' || $loan_date == '0000-00-00 00:00:00') {
                                    echo '00-00-0000';
                                } else {
                                    echo esc(date('d-m-Y', strtotime($loan_date)));
                                }
                            ?>
                        </td>
                        <td><?= esc($loans['l_nopol']); ?></td>
                        <td><?= esc($loans['d_name'] ?? $loans['l_supir'] ?? ''); ?></td>
                        <td>
                            <span>
                                <?php 
                                $jenisHutang = '';
                                
                                if (isset($loans['l_is_status'])) {
                                    $status = $loans['l_is_status'];
                                    
                                    if (in_array($status, [0, 1])) {
                                        $jenisHutang = 'Pribadi';
                                    } elseif (in_array($status, [4, 5])) {
                                        $jenisHutang = 'Sparepart';
                                    }
                                }
                                
                                if (empty($jenisHutang) && isset($loans['b_is_status'])) {
                                    $status = $loans['b_is_status'];
                                    if (in_array($status, [0, 2])) {
                                        $jenisKasus = !empty($loans['b_jenis_kasus']) ? " ({$loans['b_jenis_kasus']})" : '';
                                        $jenisHutang = 'Klaim' . $jenisKasus;
                                    }
                                }
                                
                                if (empty($jenisHutang)) {
                                    $jenisHutang = '-';
                                }
                                echo esc($jenisHutang);
                                ?>
                            </span>
                        </td>
                        <td><?php 
                                $keterangan = '';
                                if (isset($loans['kondisi_barang']) && !empty($loans['kondisi_barang'])) {
                                    $keterangan = esc($loans['kondisi_barang']);
                                } elseif (isset($loans['l_keterangan']) && !empty($loans['l_keterangan'])) {
                                    $keterangan = esc($loans['l_keterangan']);
                                } else {
                                    $keterangan = '-';
                                }
                                echo $keterangan;
                            ?>
                        </td>
                        <td><?= esc($loans['l_potong']); ?></td>
                        <td><?= esc($loans['l_nominal']); ?></td>
                        <td>
                            <?php 
                                $approveDate = !empty($loans['l_tanggal_approve']) ? date('d-m-Y', strtotime($loans['l_tanggal_approve'])) : '';

                                if (isset($loans['creator_name']) && !empty($loans['creator_name'])) {
                                    echo esc($loans['creator_name']);
                                    if (!empty($approveDate)) {
                                        echo '<br><small class="text-muted">' . $approveDate . '</small>';
                                    }
                                } else {
                                    echo '-';
                                }
                            ?>
                        </td>
                        <td>
                            <?php 
                                $loanStatus = $loans['l_is_status'] ?? null;
                                $bapStatus  = $loans['b_is_status'] ?? null;

                                $status = 'Unknown';

                                if ($loanStatus !== null) {
                                    if (in_array($loanStatus, [0, 5])) {
                                        $status = 'Paid';
                                    } elseif (in_array($loanStatus, [1, 4])) {
                                        $status = 'Unpaid';
                                    }
                                }

                                if ($bapStatus !== null) {
                                    if ($bapStatus == 2) {
                                        $status = 'Paid';
                                    } elseif (in_array($bapStatus, [0])) {
                                        $status = 'Unpaid';
                                    }
                                }

                                if ($status == 'Paid') {
                                    echo '<span class="badge badge-success">Paid</span>';
                                } elseif ($status == 'Unpaid') {
                                    echo '<span class="badge badge-warning">Unpaid</span>';
                                } else {
                                    echo '<span class="badge badge-secondary">Unknown</span>';
                                }
                                ?>
                        </td>
                        <td>
                            <?php $driverStatus = $loans['d_is_active'] ?? ''; ?>
                            <?php if ($driverStatus == 1): ?>
                                <span class="badge badge-success">Active</span>
                            <?php elseif ($driverStatus == 0): ?>
                                <span class="badge badge-danger">Inactive</span>
                            <?php elseif ($driverStatus == 2): ?>
                                <span class="badge badge-dark">Blacklist</span>
                            <?php elseif ($driverStatus == 3): ?>
                                <span class="badge badge-warning">Permission</span>
                            <?php else: ?>
                                <span class="badge badge-secondary">Unknown</span>
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

    $('.select2').select2({
        placeholder: "All Driver",
        allowClear: true
    });

    $(document).ready(function() {
    function initDatepicker(element) {
        element.datepicker({
            format: 'yyyy/mm/dd',
            autoclose: true,
            todayHighlight: true
        });
    }

    function handleLoanSelection() {
        var selectedLoan = $('#loan_status').val();
        var fromDate = $('#loan_from');
        var toDate = $('#loan_to');

        if (selectedLoan === 'all loan' || selectedLoan === '1') {
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
        $('#loan_status').val('all loan').trigger('change');
        $('#driver_status').val('').trigger('change');
        $('#driver_name').val('').trigger('change');
        $('#loan_type').val('').trigger('change');
        $('#payment').val('').trigger('change');
        
        $('#loan_from').val('');
        $('#loan_to').val('');
        
        if ($.fn.DataTable.isDataTable('.datatableexport')) {
            $('.datatableexport').DataTable().destroy();
        }
        
        $('.datatableexport tbody').empty();
        $('.datatableexport').hide();
        $('#dataCount').text('0');
        toggleActionButtons(false);
        handleLoanSelection();
    }

    $('.datepicker').each(function() {
        initDatepicker($(this));
    });
    handleLoanSelection();
    
    $('#loan_status').change(function() {
        handleLoanSelection();
    });
    
    $('#resetFilter').click(function() {
        resetAllFilters();
    });

    $('#exportExcel').click(function() {
        var formData = $('#loan_report').serialize();
        
        var btn = $(this);
        btn.html('<i class="fas fa-spinner fa-spin"></i> Processing...');
        btn.prop('disabled', true);
        
        window.location.href = '<?= base_url(); ?>reports/export_loan_excel?' + formData;
        
        setTimeout(function() {
            btn.html('<i class="fas fa-file-excel me-1"></i> Export Excel');
            btn.prop('disabled', false);
        }, 2000);
    });

    $('#exportPDF').click(function() {
        var formData = $('#loan_report').serialize();
        
        window.location.href = '<?= base_url(); ?>reports/export_loan_pdf?' + formData;
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
        
        var loanStatus = $('#loan_status option:selected').text();
        var driverStatus = $('#driver_status option:selected').text() || 'All Driver';
        var dateFrom = $('#loan_from').val() || 'All Loan';
        var dateTo = $('#loan_to').val() || 'All Loan';
        var loanType = $('#loan_type option:selected').text() || 'All Loan';
        var driverName = $('#driver_name option:selected').text() || 'All Loan';
        var payMent = $('#payment option:selected').text() || 'All Loan';
        
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
                <title>Loan Report - SSH Group</title>
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
                    <div class="company-name">Loan Report</div>
                    <div class="report-info">
                    <div>Generated on: ${formattedDate} at ${formattedTime}</div>
                    <div>Total Records: ${table.rows({ search: 'applied' }).count()}</div>
                </div>
                </div>
                
                <div class="report-filters">
                    <div class="filter-row"><span class="filter-label">Report Period:</span> ${dateFrom} to ${dateTo}</div>
                    <div class="filter-row"><span class="filter-label">Loan Status:</span> ${loanStatus}</div>
                    <div class="filter-row"><span class="filter-label">Driver Status:</span> ${driverStatus}</div>
                    <div class="filter-row"><span class="filter-label">Loan Type:</span> ${loanType}</div>
                    <div class="filter-row"><span class="filter-label">Driver Name:</span> ${driverName}</div>
                    <div class="filter-row"><span class="filter-label">Payment Type:</span> ${payMent}</div>
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