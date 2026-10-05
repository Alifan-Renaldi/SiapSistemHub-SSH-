<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<!-- <style>
    table th:nth-child(7), table td:nth-child(7) { max-width: 20mm; }
    table th:nth-child(8), table td:nth-child(8) { max-width: 20mm; }
    table th:nth-child(9), table td:nth-child(9) { max-width: 20mm; }
    table th:nth-child(10), table td:nth-child(10) { max-width: 20mm; }
</style> -->

<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Driver Report</h1>
         </div>
         <!-- /.col -->
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
               <li class="breadcrumb-item active">Driver Report</li>
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
    <form method="post" id="driver_report" class="card basicvalidation" action="<?php echo base_url('reports/driver'); ?>">
        <?= csrf_field() ?>
        
        <div class="card-body">
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="driver_name" class="form-label">Driver Status</label>
                        <select required="true" id="driver_name" class="form-control form-control-sm" name="driver_name">
                            <option value="all" <?= (isset($postData['driver_name']) && $postData['driver_name'] == 'all') ? 'selected' : ''; ?>>All Drivers</option>
                            <option value="1" <?= (isset($postData['driver_name']) && $postData['driver_name'] == '1') ? 'selected' : ''; ?>>Active</option>
                            <option value="0" <?= (isset($postData['driver_name']) && $postData['driver_name'] == '0') ? 'selected' : ''; ?>>Inactive</option>
                            <option value="2" <?= (isset($postData['driver_name']) && $postData['driver_name'] == '2') ? 'selected' : ''; ?>>Blacklist</option>
                            <option value="3" <?= (isset($postData['driver_name']) && $postData['driver_name'] == '3') ? 'selected' : ''; ?>>Permission</option>
                        </select>
                    </div>
                </div>
                <!-- BPJS Status Filter -->
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="bpjs_status" class="form-label">BPJS Status</label>
                        <select class="form-control form-control-sm" id="bpjs_status" name="bpjs_status">
                            <option value="">All</option>
                            <option value="Ada" <?= (isset($postData['bpjs_status']) && $postData['bpjs_status'] == 'Ada') ? 'selected' : '' ?>>Ada</option>
                            <option value="Tidak Ada" <?= (isset($postData['bpjs_status']) && $postData['bpjs_status'] == 'Tidak Ada') ? 'selected' : '' ?>>Tidak Ada</option>
                        </select>
                    </div>
                </div>
                <!-- Work Period Filter -->
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="work_period_from" class="form-label">Work Period (Years)</label>
                        <div class="input-group">
                            <input type="number" class="form-control form-control-sm" 
                                   value="<?= isset($postData['work_period_from']) ? $postData['work_period_from'] : ''; ?>" 
                                   id="work_period_from" name="work_period_from" placeholder="From" min="0" step="1">
                            <span class="input-group-text">-</span>
                            <input type="number" class="form-control form-control-sm" 
                                   value="<?= isset($postData['work_period_to']) ? $postData['work_period_to'] : ''; ?>" 
                                   id="work_period_to" name="work_period_to" placeholder="To" min="0" step="1">
                        </div>
                    </div>
                </div>
                <!-- Age Range Filter -->
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="age_from" class="form-label">Age Range</label>
                        <div class="input-group">
                            <input type="number" class="form-control form-control-sm" 
                                   value="<?= isset($postData['age_from']) ? $postData['age_from'] : ''; ?>" 
                                   id="age_from" name="age_from" placeholder="From" min="18">
                            <span class="input-group-text">-</span>
                            <input type="number" class="form-control form-control-sm" 
                                   value="<?= isset($postData['age_to']) ? $postData['age_to'] : ''; ?>" 
                                   id="age_to" name="age_to" placeholder="To" min="18">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <!-- Date Range Filters -->
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="driver_from" class="form-label">Report From</label>
                        <input type="text" class="form-control form-control-sm datepicker"value="<?= isset($postData['driver_from']) ? $postData['driver_from'] : ''; ?>" 
                               id="driver_from" name="driver_from" placeholder="Date From">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="driver_to" class="form-label">Report To</label>
                        <input type="text" class="form-control form-control-sm datepicker" 
                               value="<?= isset($postData['driver_to']) ? $postData['driver_to'] : ''; ?>" 
                               id="driver_to" name="driver_to" placeholder="Date To">
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
            
            <input type="hidden" id="driverreport" name="driverreport" value="1">
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
                                    if (isset($driver) && is_array($driver)) {
                                        $count = count($driver);
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
            <?php if(!empty($driver)){ 
             ?>
                   <table class="datatableexport table card-table">
                      <thead>
                        <tr>
                          <th class="w-1">No</th>
                           <th>NIS</th>
                          <th>Nama Supir</th>
                          <th>Umur</th>
                          <th>BPJS</th>
                          <th>Tanggal Masuk</th>
                          <th>Tanggal Keluar</th>
                          <th>Masa Kerja</th>
                          <th>Referensi</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php if(!empty($driver)){  $count=1;
                           foreach($driver as $drivers){
                           ?>
                        <tr>
                           <td> <?= $count; $count++; ?></td>
                            <td> <?= esc($drivers['d_nis']); ?></td>
                           <td> <?= esc($drivers['d_name']); ?></td>
                           <td><?php
                      if (!empty($drivers['d_dob'])) {
                          $tanggal_lahir = new DateTime($drivers['d_dob']);
                          $tanggal_sekarang = new DateTime();
                          $selisih = $tanggal_lahir->diff($tanggal_sekarang);
                          // Format hasil
                          $umur = '';
                          if ($selisih->y > 0) {
                              $umur .= $selisih->y . ' Tahun ';
                          }
                          echo $umur ?: 'Tidak Diketahui';
                      } else {
                          echo 'Tanggal Lahir Tidak Tersedia';
                      }
                      ?></td>
                           <td><?= esc($drivers['d_cardbpjs']); ?></td>
                           <td>
                               <?php 
                                $doj_date = $drivers['d_doj'];
                                if (empty($doj_date) || $doj_date == '0000-00-00' || $doj_date == '0000-00-00 00:00:00') {
                                    echo '00-00-0000';
                                } else {
                                    echo esc(date('d-m-Y', strtotime($doj_date)));
                                }
                                ?>
                           </td>
                           <td>
                               <?php 
                                $resign_date = $drivers['d_resigndate'];
                                if (empty($resign_date) || $resign_date == '0000-00-00' || $resign_date == '0000-00-00 00:00:00') {
                                    echo '00-00-0000';
                                } else {
                                    echo esc(date('d-m-Y', strtotime($resign_date)));
                                }
                                ?>
                           </td>
                           <td><?php
                            if (!empty($drivers['d_doj'])) {
                                // Check if join date is '0000-00-00'
                                if ($drivers['d_doj'] == '0000-00-00') {
                                    echo 'Tidak Pernah Bekerja di SSH';
                                } else {
                                    $tanggal_masuk = new DateTime($drivers['d_doj']);
                                    $tanggal_sekarang = new DateTime();
                                    
                                    // Jika ada tanggal resign yang valid, gunakan sebagai tanggal akhir
                                    if (!empty($drivers['d_resigndate']) && $drivers['d_resigndate'] != '0000-00-00') {
                                        $tanggal_akhir = new DateTime($drivers['d_resigndate']);
                                    } else {
                                        $tanggal_akhir = $tanggal_sekarang;
                                    }
                                    
                                    $selisih = $tanggal_masuk->diff($tanggal_akhir);
                                    
                                    // Format hasil dengan benar
                                    $masa_kerja = '';
                                    if ($selisih->y > 0) {
                                        $masa_kerja .= $selisih->y . ' Tahun ';
                                    }
                                    if ($selisih->m > 0) {
                                        $masa_kerja .= $selisih->m . ' Bulan ';
                                    }
                                    if ($selisih->d > 0) {
                                        $masa_kerja .= $selisih->d . ' Hari';
                                    }
                                    
                                    // Handle kasus khusus
                                    if (empty($masa_kerja)) {
                                        if ($tanggal_masuk->format('Y-m-d') == $tanggal_akhir->format('Y-m-d')) {
                                            echo 'Baru Masuk';
                                        } else {
                                            echo 'Kurang dari 1 Hari';
                                        }
                                    } else {
                                        echo trim($masa_kerja);
                                    }
                                }
                            } else {
                                echo 'Tanggal Masuk Tidak Tersedia';
                            }?>
                            </td>
                           <td> <?= esc($drivers['d_ref']); ?></td>
                            <td>
                             <?php if ($drivers['d_is_active'] == 1): ?>
                                 <span class="badge badge-success">Active</span>
                             <?php elseif ($drivers['d_is_active'] == 0): ?>
                                 <span class="badge badge-danger">Inactive</span>
                             <?php elseif ($drivers['d_is_active'] == 2): ?>
                                 <span class="badge badge-dark">Blacklist</span>
                              <?php elseif ($drivers['d_is_active'] == 3): ?>
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
    // Inisialisasi datepicker
    function initDatepicker(element) {
        element.datepicker({
            format: 'yyyy/mm/dd',
            autoclose: true,
            todayHighlight: true
        });
    }

    // Mengatur readonly, mengosongkan, dan menonaktifkan datepicker
    function handleDriverSelection() {
        var selectedDriver = $('#driver_name').val();
        var fromDate = $('#driver_from');
        var toDate = $('#driver_to');
        
        if (selectedDriver === 'all') {
            // Jika "All Driver" dipilih
            fromDate.prop('readonly', true).val('').datepicker('destroy');
            toDate.prop('readonly', true).val('').datepicker('destroy');
            fromDate.removeAttr('required');
            toDate.removeAttr('required');
            
            // Elemen input biasa (non-datepicker)
            fromDate.removeClass('datepicker').attr('type', 'text');
            toDate.removeClass('datepicker').attr('type', 'text');
        } else {
            // Jika pilihan lain dipilih
            fromDate.prop('readonly', false);
            toDate.prop('readonly', false);
            fromDate.removeAttr('required');
            toDate.removeAttr('required');
            
            // Inisialisasi ulang datepicker
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

    // Jalankan saat halaman selesai dimuat
    checkAndShowExportButtons();

    // Reset semua filter dan tabel
    function resetAllFilters() {
    // Reset dropdown driver ke "All Driver"
    $('#driver_name').val('all').trigger('change');
    
    // Kosongkan field tanggal
    $('#driver_from').val('');
    $('#driver_to').val('');

    $('#age_from').val('');
    $('#age_to').val('');
    $('#bpjs_status').val('');
    $('#work_period_from').val('');
    $('#work_period_to').val('');
    
    // Hancurkan DataTable jika sudah diinisialisasi
    if ($.fn.DataTable.isDataTable('.datatableexport')) {
        $('.datatableexport').DataTable().destroy();
    }
    
    // Kosongkan tabel dan sembunyikan
    $('.datatableexport tbody').empty();
    $('.datatableexport').hide();
    $('#dataCount').text('0');
    toggleActionButtons(false);
    
    // HandleDriverSelection untuk update tampilan
    handleDriverSelection();
    }

    // Inisialisasi awal datepicker
    $('.datepicker').each(function() {
        initDatepicker($(this));
    });

    // Panggil fungsi saat halaman dimuat
    handleDriverSelection();
    
    // Panggil fungsi saat dropdown berubah
    $('#driver_name').change(function() {
        handleDriverSelection();
    });
    
    // Handler untuk tombol reset filter
    $('#resetFilter').click(function() {
        resetAllFilters();
    });

    $('#exportExcel').click(function() {
    // Get current filters
    var formData = $('#driver_report').serialize();
    
    // Add loading indicator
    var btn = $(this);
    btn.html('<i class="fas fa-spinner fa-spin"></i> Processing...');
    btn.prop('disabled', true);
    
    // Submit request
    window.location.href = '<?= base_url(); ?>reports/export_driver_excel?' + formData;
    
    // Reset button after 2 seconds (in case of error)
    setTimeout(function() {
        btn.html('<i class="fas fa-file-excel me-1"></i> Export Excel');
        btn.prop('disabled', false);
    }, 2000);
});

// Export to PDF
$('#exportPDF').click(function() {
    // Get the current filter values
    var formData = $('#driver_report').serialize();
    
    // Submit the form to PDF export URL
    window.location.href = '<?= base_url(); ?>reports/export_driver_pdf?' + formData;
});

// Print Report
$('#printReport').click(function() {
    // Function to format date to d/m/Y
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

    // Function to format time to HH:MM
    function formatTime(date) {
        if (!date) return '';
        var d = new Date(date),
            hours = '' + d.getHours(),
            minutes = '' + d.getMinutes();

        if (hours.length < 2) hours = '0' + hours;
        if (minutes.length < 2) minutes = '0' + minutes;

        return hours + ':' + minutes;
    }

    var $table = $('.datatableexport');
    var isDT = $.fn.DataTable.isDataTable($table);
    var table = null;
    var originalPageLength = null;
    if (isDT) {
        try {
            table = $table.DataTable();
            originalPageLength = table.page.len();
            table.page.len(-1).draw();
        } catch(e) {
            console.warn('DataTable page.len failed, fallback to DOM', e);
            isDT = false;
        }
    }
    
    var driverStatus = $('#driver_name option:selected').text();
    var dateFrom = $('#driver_from').val() || 'All';
    var dateTo = $('#driver_to').val() || 'All';
    var bpjsStatus = $('#bpjs_status option:selected').text() || 'All';
    var ageRange = ($('#age_from').val() || '') + ' - ' + ($('#age_to').val() || '');
    var workPeriod = ($('#work_period_from').val() || '') + ' - ' + ($('#work_period_to').val() || '');
    
    var printTable = $('<table>').addClass('print-table').css({
        'width': '100%',
        'border-collapse': 'collapse'
    });
    
    printTable.append($('.datatableexport thead').clone());
    
    var tbody = $('<tbody>');
    if (isDT && table) {
        try {
            table.rows({ search: 'applied' }).nodes().each(function(row) {
                tbody.append($(row).clone());
            });
        } catch(e) {
            console.warn('DataTable rows clone failed, fallback to DOM', e);
        }
        // Fallback jika DataTable rows kosong akibat mismatch kolom atau filtering
        if (tbody.children().length === 0) {
            $table.find('tbody tr').each(function(){
                if ($(this).find('td[colspan]').length) return;
                if ($(this).text().trim() === '') return;
                tbody.append($(this).clone());
            });
        }
    } else {
        $table.find('tbody tr').each(function(){
            if ($(this).find('td[colspan]').length) return;
            tbody.append($(this).clone());
        });
    }
    printTable.append(tbody);
    
    var printWindow = window.open('', '', 'height=1000,width=1000');
    
    // Get current date and time
    var currentDate = new Date();
    var formattedDate = formatDate(currentDate);
    var formattedTime = formatTime(currentDate);
    
    printWindow.document.write(`
        <html>
        <head>
            <title>Driver Report - SSH Group</title>
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
                <div class="company-name">Driver Report</div>
                <div class="report-info">
                <div>Generated on: ${formattedDate} at ${formattedTime}</div>
                <div>Total Records: ${tbody.children().length}</div>
            </div>
            </div>
            
            <div class="report-filters">
                <div class="filter-row"><span class="filter-label">Report Period:</span> ${dateFrom} to ${dateTo}</div>
                <div class="filter-row"><span class="filter-label">Driver Status:</span> ${driverStatus}</div>
                <div class="filter-row"><span class="filter-label">BPJS Status:</span> ${bpjsStatus}</div>
                <div class="filter-row"><span class="filter-label">Age Range:</span> ${ageRange}</div>
                <div class="filter-row"><span class="filter-label">Work Period (Years):</span> ${workPeriod}</div>
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
        if (isDT && table && originalPageLength !== null) {
            try { table.page.len(originalPageLength).draw(); } catch(e) {}
        }
        printWindow.focus();
        printWindow.print();
        printWindow.close();
    }, 500);
});
});
</script>