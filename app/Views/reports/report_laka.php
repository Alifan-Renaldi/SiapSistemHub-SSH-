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
            <h1 class="m-0 text-dark">Laka Report</h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
               <li class="breadcrumb-item active">Laka Report</li>
            </ol>
         </div>
      </div>
   </div>
</div>
<!-- Main content -->
<section class="content">
   <div class="container-fluid">
    <form method="post" id="laka_report" class="card basicvalidation" action="<?php echo base_url('reports/laka'); ?>">
        <?= csrf_field() ?>
        
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
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
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="nopol" class="form-label">Vehicle</label>
                        <select class="form-control form-control-sm select2-vehicle form-equal-height" id="nopol" name="nopol">
                            <option value="">All Vehicle</option>
                            <?php if(!empty($vehicles)): ?>
                                <?php foreach($vehicles as $vehicle): ?>
                                    <option value="<?= esc($vehicle['v_registration_no']) ?>" 
                                        <?= (isset($postData['nopol']) && $postData['nopol'] == $vehicle['v_registration_no']) ? 'selected' : '' ?>>
                                        <?= esc($vehicle['v_registration_no']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="classification" class="form-label">Classification</label>
                        <select class="form-control form-control-sm" id="classification" name="classification">
                            <option value="">All Classification</option>
                            <option value="Kasus Laka Kecil" <?= (isset($postData['classification']) && $postData['classification'] == 'Kasus Laka Kecil') ? 'selected' : '' ?>>Kasus Laka Kecil</option>
                            <option value="Kasus Laka Besar" <?= (isset($postData['classification']) && $postData['classification'] == 'Kasus Laka Besar') ? 'selected' : '' ?>>Kasus Laka Besar</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="laka_from" class="form-label">Report From</label>
                        <input type="text" class="form-control form-control-sm datepicker" 
                               value="<?= isset($postData['laka_from']) ? $postData['laka_from'] : ''; ?>" 
                               id="laka_from" name="laka_from" placeholder="Date From">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="laka_to" class="form-label">Report To</label>
                        <input type="text" class="form-control form-control-sm datepicker" 
                               value="<?= isset($postData['laka_to']) ? $postData['laka_to'] : ''; ?>" 
                               id="laka_to" name="laka_to" placeholder="Date To">
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
            
            <input type="hidden" id="lakareport" name="lakareport" value="1">
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
                                        if (isset($laka) && is_array($laka)) {
                                            $count = count($laka);
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
         
         <?php if(!empty($laka)){ 
             ?>
                   <table class="datatableexport table card-table">
                      <thead>
                        <tr>
                          <th class="w-1">No</th>
                          <th>Tanggal Kejadian</th>
                          <th>Lokasi Kejadian</th>
                          <th>Nama Supir</th>
                          <th>Nomor Polisi</th>
                          <th>Tahun Mobil</th>
                          <th>Klasifikasi Kasus</th>
                          <th>Riwayat Kejadian</th>
                          <th>Daftar Kerusakan</th>
                          <th>Lokasi Perbaikan</th>
                          <th>Biaya Perbaikan</th>
                          <th>Biaya Lain-lain</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php if(!empty($laka)){  $count=1;
                           foreach($laka as $lakas){
                           ?>
                        <tr>
                        <td><?= $count; $count++; ?></td>
                        <td><?= esc(date('d-m-Y', strtotime($lakas['b_tanggal_kejadian']))); ?></td>
                        <td><?= esc($lakas['b_lokasi_kejadian']); ?></td>
                        <td><?= esc($lakas['b_supir']); ?></td>
                        <td><?= esc($lakas['b_nopol']); ?></td>
                        <td>
                            <?php 
                            if (!empty($lakas['v_reg_exp_date'])) {
                                echo esc($lakas['v_reg_exp_date']);
                            } else {
                                echo 'N/A';
                            }
                            ?>
                        </td>
                        <td><?= esc($lakas['b_klasifikasi']); ?></td>
                        <td><?= esc($lakas['b_kondisi_barang']); ?></td>
                        <td style="text-align: center;"> 
                            <?php
                            if (!empty($lakas['b_daftar_kerusakan']))
                            {
                                echo esc($lakas['b_daftar_kerusakan']);
                            }else{
                                echo 'N/A';
                            }
                        ?>
                        </td>
                        <td style="text-align: center;"> 
                            <?php
                            if (!empty($lakas['b_lokasi_perbaikan']))
                            {
                                echo esc($lakas['b_lokasi_perbaikan']);
                            }else{
                                echo 'N/A';
                            }
                        ?>
                        </td>
                       <td style="text-align: center;"> 
                            <?php
                            if (!empty($lakas['b_biaya_perbaikan']))
                            {
                                echo esc($lakas['b_biaya_perbaikan']);
                            }else{
                                echo 'N/A';
                            }
                        ?>
                        </td>
                       <td style="text-align: center;"> 
                            <?php
                            if (!empty($lakas['b_biaya_lain']))
                            {
                                echo esc($lakas['b_biaya_lain']);
                            }else{
                                echo 'N/A';
                            }
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

    $('.select2').select2({
        placeholder: "All Driver",
        allowClear: true
    });

    $('.select2-vehicle').select2({
        placeholder: "All Vehicle",
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

    function handleLakaSelection() {
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
        $('#driver_name').val('').trigger('change');
        $('#nopol').val('').trigger('change');
        $('#classification').val('').trigger('change');
        
        $('#laka_from').val('');
        $('#laka_to').val('');
        
        if ($.fn.DataTable.isDataTable('.datatableexport')) {
            $('.datatableexport').DataTable().destroy();
        }
        
        $('.datatableexport tbody').empty();
        $('.datatableexport').hide();
        $('#dataCount').text('0');
        toggleActionButtons(false);
        
        handleLakaSelection();
    }

    $('.datepicker').each(function() {
        initDatepicker($(this));
    });

    handleLakaSelection();
    
    $('#bap_name').change(function() {
        handleLakaSelection();
    });
    
    $('#resetFilter').click(function() {
        resetAllFilters();
    });

    $('#exportExcel').click(function() {
        var formData = $('#laka_report').serialize();
        
        var btn = $(this);
        btn.html('<i class="fas fa-spinner fa-spin"></i> Processing...');
        btn.prop('disabled', true);
        
        window.location.href = '<?= base_url(); ?>reports/export_laka_excel?' + formData;
        
        setTimeout(function() {
            btn.html('<i class="fas fa-file-excel me-1"></i> Export Excel');
            btn.prop('disabled', false);
        }, 2000);
    });

    $('#exportPDF').click(function() {
        var formData = $('#laka_report').serialize();
        
        window.location.href = '<?= base_url(); ?>reports/export_laka_pdf?' + formData;
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
        
        var driverName = $('#driver_name option:selected').text() || '';
        var nopolVehicle = $('#nopol option:selected').text() || '';
        var dateFrom = $('#laka_from').val() || '';
        var dateTo = $('#laka_to').val() || '';
        var clasSification = $('#classification option:selected').text() || '';
        
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
                <title>Laka Report - SSH Group</title>
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
                    <div class="company-name">Laka Report</div>
                    <div class="report-info">
                    <div>Generated on: ${formattedDate} at ${formattedTime}</div>
                    <div>Total Records: ${table.rows({ search: 'applied' }).count()}</div>
                </div>
                </div>
                
                <div class="report-filters">
                    <div class="filter-row"><span class="filter-label">Report Period:</span> ${dateFrom} to ${dateTo}</div>
                    <div class="filter-row"><span class="filter-label">Driver Name:</span> ${driverName}</div>
                    <div class="filter-row"><span class="filter-label">Vehicle:</span> ${nopolVehicle}</div>
                    <div class="filter-row"><span class="filter-label">Classification:</span> ${clasSification}</div>
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