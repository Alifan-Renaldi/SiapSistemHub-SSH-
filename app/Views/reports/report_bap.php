<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

    <style>
        table th:nth-child(7), table td:nth-child(7) { max-width: 20mm; }
        table th:nth-child(8), table td:nth-child(8) { max-width: 20mm; }
        table th:nth-child(9), table td:nth-child(9) { max-width: 20mm; }
        table th:nth-child(10), table td:nth-child(10) { max-width: 20mm; }
    </style>

<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">BAP Report</h1>
         </div>
         <!-- /.col -->
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
               <li class="breadcrumb-item active">BAP Report</li>
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
    <form method="post" id="bap_report" class="card basicvalidation" action="<?php echo base_url('reports/bap'); ?>">
        <?= csrf_field() ?>
        
        <div class="card-body">
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="bap_name" class="form-label">BAP Status</label>
                        <select required="true" id="bap_name" class="form-control form-control-sm" name="bap_name">
                            <option value="all bap" <?= (isset($postData['bap_name']) && $postData['bap_name'] == 'all bap') ? 'selected' : ''; ?>>All BAP</option>
                            <option value="0" <?= (isset($postData['bap_name']) && $postData['bap_name'] == '0') ? 'selected' : ''; ?>>Done</option>
                            <option value="1" <?= (isset($postData['bap_name']) && $postData['bap_name'] == '1') ? 'selected' : ''; ?>>Pending</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="driver_status" class="form-label">Driver Status</label>
                        <select class="form-control form-control-sm" id="driver_status" name="driver_status">
                            <option value="">All Status</option>
                            <option value="1" <?= (isset($postData['driver_status']) && $postData['driver_status'] == '1') ? 'selected' : ''; ?>>Active</option>
                            <option value="0" <?= (isset($postData['driver_status']) && $postData['driver_status'] == '0') ? 'selected' : '' ?>>Inactive</option>
                            <option value="2" <?= (isset($postData['driver_status']) && $postData['driver_status'] == '2') ? 'selected' : '' ?>>Blacklist</option>
                            <option value="3" <?= (isset($postData['driver_status']) && $postData['driver_status'] == '3') ? 'selected' : '' ?>>Permission</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="case_type" class="form-label">Case Type</label>
                        <select class="form-control form-control-sm" id="case_type" name="case_type">
                            <option value="">All Case</option>
                            <option value="Barang Rusak" <?= (isset($postData['case_type']) && $postData['case_type'] == 'Barang Rusak') ? 'selected' : '' ?>>Barang Rusak</option>
                            <option value="Barang Kurang/Hilang" <?= (isset($postData['case_type']) && $postData['case_type'] == 'Barang Kurang/Hilang') ? 'selected' : '' ?>>Barang Kurang/Hilang</option>
                            <option value="Inventaris Mobil Hilang/Rusak" <?= (isset($postData['case_type']) && $postData['case_type'] == 'Inventaris Mobil Hilang/Rusak') ? 'selected' : '' ?>>Inventaris Mobil Hilang/Rusak</option>
                            <option value="Lakalantas" <?= (isset($postData['case_type']) && $postData['case_type'] == 'Lakalantas') ? 'selected' : '' ?>>Lakalantas</option>
                            <option value="Mobil Rusak" <?= (isset($postData['case_type']) && $postData['case_type'] == 'Mobil Rusak') ? 'selected' : '' ?>>Mobil Rusak</option>
                            <option value="Supir Bermasalah" <?= (isset($postData['case_type']) && $postData['case_type'] == 'Supir Bermasalah') ? 'selected' : '' ?>>Supir Bermasalah</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="classification" class="form-label">Classification</label>
                        <select class="form-control form-control-sm" id="classification" name="classification">
                            <option value="">All Classification</option>
                            <option value="Kasus Muatan Rugi Kecil" <?= (isset($postData['classification']) && $postData['classification'] == 'Kasus Muatan Rugi Kecil') ? 'selected' : '' ?>>Kasus Muatan Rugi Kecil</option>
                            <option value="Kasus Muatan Rugi Besar" <?= (isset($postData['classification']) && $postData['classification'] == 'Kasus Muatan Rugi Besar') ? 'selected' : '' ?>>Kasus Muatan Rugi Besar</option>
                            <option value="Kasus Laka Kecil" <?= (isset($postData['classification']) && $postData['classification'] == 'Kasus Laka Kecil') ? 'selected' : '' ?>>Kasus Laka Kecil</option>
                            <option value="Kasus Laka Besar" <?= (isset($postData['classification']) && $postData['classification'] == 'Kasus Laka Besar') ? 'selected' : '' ?>>Kasus Laka Besar</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
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
                        <label for="bap_from" class="form-label">Report From</label>
                        <input type="text" class="form-control form-control-sm datepicker" 
                               value="<?= isset($postData['bap_from']) ? $postData['bap_from'] : ''; ?>" 
                               id="bap_from" name="bap_from" placeholder="Date From">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="bap_to" class="form-label">Report To</label>
                        <input type="text" class="form-control form-control-sm datepicker" 
                               value="<?= isset($postData['bap_to']) ? $postData['bap_to'] : ''; ?>" 
                               id="bap_to" name="bap_to" placeholder="Date To">
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
            
            <input type="hidden" id="bapreport" name="bapreport" value="1">
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
                                        if (isset($bap) && is_array($bap)) {
                                            $count = count($bap);
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
         
         <?php if(!empty($bap)){ 
             ?>
                   <table class="datatableexport table card-table">
                      <thead>
                        <tr>
                          <th class="w-1">No</th>
                          <th>No BAP</th>
                          <th>Tanggal</th>
                          <th>Tanggal BAP</th>
                          <th>Tanggal Kejadian</th>
                          <th style="width: 100px;">Nama Supir</th>
                          <th style="width: 100px;">Mobil</th>
                          <th>Jenis Muatan</th>
                          <th>Keberangkatan</th>
                          <th>Lokasi Kejadian</th>
                          <th>Kronologi Kasus</th>
                          <th>Jenis Kasus</th>
                          <th>Realisasi Klaim</th>
                          <th>Potong Tagihan</th>
                          <th>Cash</th>
                          <th>Transfer</th>
                          <th>Klasifikasi Kasus</th>
                          <th>Status Supir</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php if(!empty($bap)){  $count=1;
                           foreach($bap as $baps){
                           ?>
                        <tr>
                        <td><?= $count; $count++; ?></td>
                        <td><?= esc($baps['b_code']); ?></td>
                        <td><?= esc(date('d-m-Y', strtotime($baps['b_created_date']))); ?></td>
                        <td>
                            <?php 
                                $bap_date = $baps['b_tanggal'];
                                if (empty($bap_date) || $bap_date == '0000-00-00' || $bap_date == '0000-00-00 00:00:00') {
                                    echo '00-00-0000';
                                } else {
                                    echo esc(date('d-m-Y', strtotime($bap_date)));
                                }
                            ?>
                        </td>
                        <td><?= esc(date('d-m-Y', strtotime($baps['b_tanggal_kejadian']))); ?></td>
                        <td><?= esc($baps['b_supir']); ?></td>
                        <td><?= esc($baps['b_nopol']); ?></td>
                        <td><?= esc($baps['b_muatan']); ?></td>
                        <td><?= esc($baps['b_keberangkatan']); ?></td>
                        <td><?= esc($baps['b_lokasi_kejadian']); ?></td>
                        <td><?= esc($baps['b_kondisi_barang']); ?></td>
                        <td><?= esc($baps['b_jenis_kasus']); ?></td>
                        <td><?= esc($baps['b_realisasi_klaim']); ?></td>
                        <td><?= esc($baps['b_potong_tagihan']); ?></td>
                        <td><?= esc($baps['b_cash']); ?></td>
                        <td><?= esc($baps['b_transfer']); ?></td>
                        <td><?= esc($baps['b_klasifikasi']); ?></td>
                        <td>
                            <?php if ($baps['d_is_active'] == 1): ?>
                                <span class="badge badge-success">Active</span>
                            <?php elseif ($baps['d_is_active'] == 0): ?>
                                <span class="badge badge-danger">Inactive</span>
                            <?php elseif ($baps['d_is_active'] == 2): ?>
                                <span class="badge badge-dark">Blacklist</span>
                             <?php elseif ($baps['d_is_active'] == 3): ?>
                                <span class="badge badge-warning">Permission</span>
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
            format: 'yyyy/mm/dd',
            autoclose: true,
            todayHighlight: true
        });
    }

    function handleDriverSelection() {
        var selectedBap = $('#bap_name').val();
        var fromDate = $('#bap_from');
        var toDate = $('#bap_to');

        if (selectedBap === 'all bap') {
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
        $('#bap_name').val('all bap').trigger('change');
        $('#driver_status').val('').trigger('change');
        $('#case_type').val('').trigger('change');
        $('#classification').val('').trigger('change');
        $('#payment').val('').trigger('change');
        
        $('#bap_from').val('');
        $('#bap_to').val('');
        
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
    
    $('#bap_name').change(function() {
        handleDriverSelection();
    });
    
    $('#resetFilter').click(function() {
        resetAllFilters();
    });

    $('#exportExcel').click(function() {
        var formData = $('#bap_report').serialize();
        
        var btn = $(this);
        btn.html('<i class="fas fa-spinner fa-spin"></i> Processing...');
        btn.prop('disabled', true);
        
        window.location.href = '<?= base_url(); ?>reports/export_bap_excel?' + formData;
        
        setTimeout(function() {
            btn.html('<i class="fas fa-file-excel me-1"></i> Export Excel');
            btn.prop('disabled', false);
        }, 2000);
    });

    $('#exportPDF').click(function() {
        var formData = $('#bap_report').serialize();
        
        window.location.href = '<?= base_url(); ?>reports/export_bap_pdf?' + formData;
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
        
        var bapStatus = $('#bap_name option:selected').text();
        var driverStatus = $('#driver_status option:selected').text() || 'All Driver';
        var dateFrom = $('#bap_from').val() || 'All BAP';
        var dateTo = $('#bap_to').val() || 'All BAP';
        var caseType = $('#case_type option:selected').text() || 'All BAP';
        var clasSification = $('#classification option:selected').text() || 'All BAP';
        var payMent = $('#payment option:selected').text() || 'All BAP';
        
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
        
        var currentDate = new Date();
        var formattedDate = formatDate(currentDate);
        var formattedTime = formatTime(currentDate);
        
        printWindow.document.write(`
            <html>
            <head>
                <title>BAP Report - SSH Group</title>
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
                    <div class="company-name">BAP Report</div>
                    <div class="report-info">
                    <div>Generated on: ${formattedDate} at ${formattedTime}</div>
                    <div>Total Records: ${table.rows({ search: 'applied' }).count()}</div>
                </div>
                </div>
                
                <div class="report-filters">
                    <div class="filter-row"><span class="filter-label">Report Period:</span> ${dateFrom} to ${dateTo}</div>
                    <div class="filter-row"><span class="filter-label">BAP Status:</span> ${bapStatus}</div>
                    <div class="filter-row"><span class="filter-label">Driver Status:</span> ${driverStatus}</div>
                    <div class="filter-row"><span class="filter-label">Case Type:</span> ${caseType}</div>
                    <div class="filter-row"><span class="filter-label">Classification:</span> ${clasSification}</div>
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
        
        setTimeout(function() {
            table.page.len(originalPageLength).draw();
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        }, 500);
    });
});
</script>