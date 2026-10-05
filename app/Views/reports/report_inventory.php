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
    .col-no { width: 6%; }
    .col-jenis { width: 8%; }
    .col-owner { width: 7%; }
    .col-rangka { width: 11%; }
    .col-mesin { width: 10%; }
</style>

<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Inventory Report
            </h1>
         </div>
         
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url(); ?>dashboard">Dashboard</a></li>
               <li class="breadcrumb-item active">Inventory Report</li>
            </ol>
         </div>
      </div>
   </div>
</div>

<section class="content">
   <div class="container-fluid">
    <form method="post" id="inventory_report" class="card basicvalidation" action="<?php echo base_url();?>reports/inventory">

        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
        
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="check_status" class="form-label">Checklist Status</label>
                        <select class="form-control form-control-sm" id="check_status" name="check_status">
                            <option value="all status" <?= (isset($postData['check_status']) && $postData['check_status'] == 'all status') ? 'selected' : ''; ?>>All Status</option>
                            <option value="1" <?= (isset($postData['check_status']) && $postData['check_status'] == '1') ? 'selected' : '' ?>>Active Pengecekan</option>
                            <option value="0" <?= (isset($postData['check_status']) && $postData['check_status'] == '0') ? 'selected' : '' ?>>Inactive Pengecekan</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="nopol" class="form-label">Vehicle</label>
                        <select class="form-control form-control-sm select2 form-equal-height" id="nopol" name="nopol">
                            <option value="">All Vehicle</option>
                            <?php if(!empty($inventory_vehicles)): ?>
                                <?php foreach($inventory_vehicles as $vehicle): ?>
                                    <option value="<?= esc($vehicle['iv_nopol']) ?>" 
                                        <?= (isset($postData['nopol']) && $postData['nopol'] == $vehicle['iv_nopol']) ? 'selected' : '' ?>>
                                        <?= esc($vehicle['iv_nopol']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="invent_type" class="form-label">Inventory Type</label>
                        <select class="form-control form-control-sm select2 form-equal-height" id="invent_type" name="invent_type">
                            <option value="">All Type</option>
                            <?php if(!empty($inventory_columns)): ?>
                                <?php foreach($inventory_columns as $column): ?>
                                    <option value="<?= esc($column['column_name']) ?>" 
                                        <?= (isset($postData['invent_type']) && $postData['invent_type'] == $column['column_name']) ? 'selected' : '' ?>>
                                        <?= esc($column['column_alias']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="vech_type" class="form-label">Vehicle Type</label>
                        <select class="form-control form-control-sm select2-multiple-type" id="vech_type" name="vech_type[]" multiple="multiple">
                            <?php if(!empty($type_list)): ?>
                                <?php foreach($type_list as $type): ?>
                                    <option value="<?= esc($type['iv_jenis']) ?>" 
                                        <?= (isset($postData['vech_type']) && in_array($type['iv_jenis'], $postData['vech_type'])) ? 'selected' : '' ?>>
                                        <?= esc($type['iv_jenis']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="invent_from" class="form-label">Report From</label>
                        <input type="text" class="form-control form-control-sm datepicker"
                               value="<?php echo isset($postData['invent_from']) ? $postData['invent_from'] : ''; ?>" 
                               id="invent_from" name="invent_from" placeholder="Date From">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="invent_to" class="form-label">Report To</label>
                        <input type="text" class="form-control form-control-sm datepicker" 
                               value="<?php echo isset($postData['invent_to']) ? $postData['invent_to'] : ''; ?>" 
                               id="invent_to" name="invent_to" placeholder="Date To">
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
            
            <input type="hidden" id="inventoryreport" name="inventoryreport" value="1">
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
                                        if (isset($inventory) && is_array($inventory)) {
                                            $count = count($inventory);
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
            <?php if(!empty($inventory)): ?>
                    <table  class="datatableexportvehicle table card-table">
                      <thead>
                        <tr>
                          <th class="w-1">No</th>
                          <th>Tanggal Cek</th>
                          <th>Nomor Polisi</th>
                          <th class="col-jenis">Jenis Mobil</th>
                          <th class="col-owner">Tahun</th>
                          <th class="col-rangka">Tipe Inventaris</th>
                          <th>Status Inventory</th>
                          <th>Keterangan</th>
                          <th>Diperbarui oleh</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php $count = 1; ?>
                        <?php foreach($inventory as $inventorys): ?>
                        <tr>
                           <td> <?php echo $count; $count++; ?></td>
                           <td>   <?php 
                                if (isset($postData['check_status']) && $postData['check_status'] === '0') {
                                    echo '-';
                                }
                                elseif (isset($postData['invent_type']) && $postData['invent_type'] === '0') {
                                    echo '-';
                                } else {
                                    echo esc(date('d-m-Y', strtotime($inventorys['iv_modified_date'] ?? '')));
                                }
                                ?>
                           </td>
                           <td> <?php echo $inventorys['iv_nopol']; ?></td>
                           <td> <?php echo $inventorys['iv_jenis']; ?></td>
                           <td> <?php echo $inventorys['iv_tahun']; ?></td>
                           <td>
                                <?php 
                                    if (isset($postData['check_status']) && $postData['check_status'] === '0') {
                                        echo 'Belum Diperiksa';
                                        } elseif (isset($postData['check_status']) && $postData['check_status'] === '1') {
                                        echo '<span>Sudah Diperiksa</span>';
                                        } elseif (isset($postData['invent_type']) && $postData['invent_type'] === '0') {
                                        echo '<span>Belum Diperiksa</span>';
                                        } elseif (isset($postData['invent_type']) && $postData['invent_type'] === '1') {
                                        echo '<span>Sudah Diperiksa</span>';
                                        
                                    } else {
                                        echo esc($inventorys['inventory_type_value'] ?? 'Inventory Type');
                                    }
                                ?>
                            </td>
                            <td>
                                <?php if($inventorys['iv_is_active'] == 1): ?>
                                    <div class="status_success">    
                                       <?php echo '<span class="badge badge-success">Sudah Pengecekan</span>'; ?>
                                    </div>
                                <?php elseif($inventorys['iv_is_active'] == 0): ?>
                                    <div class="status_danger">
                                       <?php echo '<span class="badge badge-danger">Belum Pengecekan</span>'; ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                             <td>
                              <?php 
                                    if (isset($postData['check_status']) && $postData['check_status'] === '0') {
                                        echo 'Kendaraan belum dilakukan inventory check';
                                    } else {
                                        echo esc($inventorys['iv_keterangan'] ?? '');
                                    }
                                ?>
                            </td>
                            <td>   <?php 
                                if (isset($postData['check_status']) && $postData['check_status'] === '0') {
                                    echo '-';
                                }
                                elseif (isset($postData['invent_type']) && $postData['invent_type'] === '0') {
                                    echo '-';
                                }
                                else {
                                    echo (isset($inventorys['creator_name']) ? ($inventorys['creator_name']) : $inventorys['iv_created_by']);
                                }
                                ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
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
            format: 'yyyy/mm/dd',
            autoclose: true,
            todayHighlight: true
        });
    }

    function handleInventorySelection() {
        var selectedInvent = $('#check_status').val();
        var fromDate = $('#invent_from');
        var toDate = $('#invent_to');
        var inventType = $('#invent_type');
        var vechType = $('#vech_type');
        var nopol = $('#nopol');

        if (selectedInvent === '1') {
            nopol.prop('disabled', true).val('').trigger('change');
        } else {
            nopol.prop('disabled', false);
        }

        if (selectedInvent === '0' || selectedInvent === 'all status') {
            fromDate.prop('readonly', false);
            toDate.prop('readonly', false);

            if (!fromDate.hasClass('hasDatepicker')) {
                fromDate.addClass('datepicker');
                initDatepicker(fromDate);
            }
            if (!toDate.hasClass('hasDatepicker')) {
                toDate.addClass('datepicker');
                initDatepicker(toDate);
            }
        } else {
            fromDate.prop('readonly', true).val('').datepicker('destroy');
            toDate.prop('readonly', true).val('').datepicker('destroy');
            fromDate.removeClass('datepicker').attr('type', 'text');
            toDate.removeClass('datepicker').attr('type', 'text');
        }

        if (selectedInvent === 'all status') {
            // Hanya "all status" yang mengizinkan inventory type
            vechType.prop('disabled', true).val(null).trigger('change');
            inventType.prop('disabled', false);
        } else {
            // "Done" dan "Yet": kunci inventory type
            vechType.prop('disabled', false);
            inventType.prop('disabled', true).val('').trigger('change');
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

    $('.select2').select2({
        placeholder: "All Vehicle",
        allowClear: true
    });

    $('#invent_type').select2({
    placeholder: "All Types",
    allowClear: true
    });

    $('.select2-multiple-type').select2({
        placeholder: "Select Types",
        allowClear: true
    });

    function resetAllFilters()
    {
        $('#check_status').val('all status').trigger('change');
        $('#nopol').val('').trigger('change');
        $('#invent_type').val('').trigger('change');
        $('.select2-multiple-type').val(null).trigger('change');
        $('#invent_from').val('');
        $('#invent_to').val('');
        // $('.select2').val(null).trigger('change');
        if ($('#invent_from').hasClass('hasDatepicker')) {
        $('#invent_from').datepicker('destroy');
            }
            if ($('#invent_to').hasClass('hasDatepicker')) {
                $('#invent_to').datepicker('destroy');
            }
        
            if ($.fn.DataTable.isDataTable('.datatableexportvehicle')) {
                $('.datatableexportvehicle').DataTable().destroy();
            }
        
        $('.datatableexportvehicle tbody').empty();
        $('.datatableexportvehicle').hide();
        $('#dataCount').text('0');
        toggleActionButtons(false);
        handleInventorySelection();
    }

    $('.datepicker').each(function() {
        initDatepicker($(this));
    });

    handleInventorySelection();
    
    $('#check_status').change(function() {
        handleInventorySelection();
    });
    
    $('#resetFilter').click(function() {
        resetAllFilters();
    });

    $('#exportExcel').click(function() {
    var formData = $('#inventory_report').serialize();
    
    var btn = $(this);
    btn.html('<i class="fas fa-spinner fa-spin"></i> Processing...');
    btn.prop('disabled', true);
    
    window.location.href = '<?= base_url(); ?>reports/export_inventory_excel?' + formData;
    
        setTimeout(function() {
            btn.html('<i class="fas fa-file-excel me-1"></i> Export Excel');
            btn.prop('disabled', false);
        }, 2000);
    });

    $('#exportPDF').click(function() {
        var formData = $('#inventory_report').serialize();
        
        window.location.href = '<?= base_url(); ?>reports/export_inventory_pdf?' + formData;
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
    
    var inventoryStatus = $('#check_status option:selected').text();
    var vehicleName = $('#nopol option:selected').text() || 'All Status';
    var inventType = $('#invent_type option:selected').text() || 'All Types';
    var vechType = $('#vech_type').val() || 'All Types';
    var dateFrom = $('#invent_from').val() || 'All';
    var dateTo = $('#invent_to').val() || 'All';
    
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
    
    var currentDate = new Date();
    var formattedDate = formatDate(currentDate);
    var formattedTime = formatTime(currentDate);
    
    printWindow.document.write(`
        <html>
        <head>
            <title>Inventory Report - SSH Group</title>
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
                .status_success {color: #28a745; }
                .status_danger {color: #dc3545; }
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
                <div class="company-name">Inventory Report</div>
                <div class="report-info">
                <div>Generated on: ${formattedDate} at ${formattedTime}</div>
                <div>Total Records: ${table.rows({ search: 'applied' }).count()}</div>
            </div>
            </div>
            
            <div class="report-filters">
                <div class="filter-row"><span class="filter-label">Report Period:</span> ${dateFrom} to ${dateTo}</div>
                <div class="filter-row"><span class="filter-label">Inventory Status:</span> ${inventoryStatus}</div>
                <div class="filter-row"><span class="filter-label">Vehicle Name:</span> ${vehicleName}</div>
                <div class="filter-row"><span class="filter-label">Inventory Type:</span> ${inventType}</div>
                <div class="filter-row"><span class="filter-label">Vehicle Type:</span> ${vechType}</div>
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