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
    .indikator-label {
        font-weight: 600;
        color: #2c3e50;
        white-space: nowrap;
    }
    .jobdesc-card .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid rgba(0,0,0,.125);
    }
</style>

<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Jobdesc Report</h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url(); ?>dashboard">Dashboard</a></li>
               <li class="breadcrumb-item active">Jobdesc Report</li>
            </ol>
         </div>
      </div>
   </div>
</div>

<section class="content">
   <div class="container-fluid">
    <form method="post" id="jobdesc_report" class="card basicvalidation" action="<?php echo base_url();?>reports/jobdesc">

        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">

        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="jk_divisi" class="form-label">Nama Divisi</label>
                        <select class="form-control form-control-sm select2 form-equal-height" id="jk_divisi" name="jk_divisi">
                            <option value="">All Divisi</option>
                            <?php if(!empty($divisi_list)): ?>
                                <?php foreach($divisi_list as $divisi): ?>
                                    <option value="<?= esc($divisi['jk_divisi']) ?>"
                                        <?= (isset($postData['jk_divisi']) && $postData['jk_divisi'] == $divisi['jk_divisi']) ? 'selected' : '' ?>>
                                        <?= esc($divisi['jk_divisi']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="jk_nama_karyawan" class="form-label">Nama Karyawan</label>
                        <select class="form-control form-control-sm select2 form-equal-height" id="jk_nama_karyawan" name="jk_nama_karyawan">
                            <option value="">All Karyawan</option>
                            <?php if(!empty($karyawan_list)): ?>
                                <?php foreach($karyawan_list as $karyawan): ?>
                                    <option value="<?= esc($karyawan['jk_nama_karyawan']) ?>"
                                        <?= (isset($postData['jk_nama_karyawan']) && $postData['jk_nama_karyawan'] == $karyawan['jk_nama_karyawan']) ? 'selected' : '' ?>>
                                        <?= esc($karyawan['jk_nama_karyawan']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-info btn-sm me-2 flex-grow-1">
                        <i class="fas fa-file-alt me-1"></i> Generate Report
                    </button>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" id="resetFilter" class="btn btn-outline-danger btn-sm flex-grow-1">
                        <i class="fas fa-redo me-1"></i> Reset Filters
                    </button>
                </div>
            </div>

            <input type="hidden" id="jobdescreport" name="jobdescreport" value="1">
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
                                Total Data : <span id="dataCount">
                                    <?php
                                        $count = 0;
                                        if (isset($jobdesc) && is_array($jobdesc)) {
                                            $count = count($jobdesc);
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

            <div id="jobdescResult" class="p-3">
                <?php if(!empty($jobdesc)): ?>
                    <?php foreach($jobdesc as $item): ?>
                    <div class="card jobdesc-card mb-3">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <b>Nama Karyawan:</b> <?= esc($item['jk_nama_karyawan'] ?? '-'); ?>
                                </div>
                                <div class="col-md-6">
                                    <b>Nama Divisi:</b> <?= esc($item['jk_divisi'] ?? '-'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-bordered table-sm mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 12%;">No</th>
                                        <th style="width: 38%;">Indikator Pekerjaan</th>
                                        <th style="width: 12%;">No</th>
                                        <th style="width: 38%;">Indikator Pekerjaan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for($i = 1; $i <= 6; $i++): ?>
                                    <tr>
                                        <td class="indikator-label">Indikator <?= $i; ?></td>
                                        <td><?= esc((!empty($item['jk_indikator_' . $i])) ? $item['jk_indikator_' . $i] : '-'); ?></td>
                                        <td class="indikator-label">Indikator <?= $i + 6; ?></td>
                                        <td><?= esc((!empty($item['jk_indikator_' . ($i + 6)])) ? $item['jk_indikator_' . ($i + 6)] : '-'); ?></td>
                                    </tr>
                                    <?php endfor; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
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
    function toggleExportButtons(show) {
        if (show) {
            $('#exportButtons').show();
        } else {
            $('#exportButtons').hide();
        }
    }

    function checkAndShowExportButtons() {
        var hasData = $('#jobdescResult .jobdesc-card').length > 0;
        toggleExportButtons(hasData);
    }
    checkAndShowExportButtons();

    var allKaryawanHtml = $('#jk_nama_karyawan').html();

    $('.select2').select2({
        placeholder: "All",
        allowClear: true
    });

    function escapeHtml(str) {
        return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#39;');
    }

    function loadKaryawan(divisi, selected) {
        if (!divisi) {
            $('#jk_nama_karyawan').html(allKaryawanHtml);
            if (selected) {
                $('#jk_nama_karyawan').val(selected);
            }
            $('#jk_nama_karyawan').trigger('change');
            return;
        }

        $.ajax({
            url: baseUrl + 'reports/get_karyawan_by_divisi?divisi=' + encodeURIComponent(divisi),
            type: 'GET',
            dataType: 'json',
            beforeSend: function() {
                $('#jk_nama_karyawan').html('<option value="">Loading...</option>').trigger('change');
            },
            success: function(data) {
                var $sel = $('#jk_nama_karyawan');
                $sel.html('<option value="">All Karyawan</option>');
                if (data && !data.error && Array.isArray(data)) {
                    $.each(data, function(index, k) {
                        var val = k.jk_nama_karyawan;
                        var isSel = (selected && val == selected) ? 'selected' : '';
                        $sel.append('<option value="' + escapeHtml(val) + '" ' + isSel + '>' + escapeHtml(val) + '</option>');
                    });
                }
                $sel.trigger('change');
            },
            error: function() {
                $('#jk_nama_karyawan').html('<option value="">Gagal memuat data</option>').trigger('change');
            }
        });
    }

    $('#jk_divisi').on('change', function() {
        loadKaryawan($(this).val());
    });

    var preselectedDivisi = $('#jk_divisi').val();
    if (preselectedDivisi) {
        loadKaryawan(preselectedDivisi, $('#jk_nama_karyawan').val());
    }

    $('#resetFilter').click(function() {
        $('#jk_divisi').val('').trigger('change');
        $('#jk_nama_karyawan').val('').trigger('change');
        $('#jobdescResult').empty();
        $('#dataCount').text('0');
        toggleExportButtons(false);
    });

    $('#exportExcel').click(function() {
        var formData = $('#jobdesc_report').serialize();
        var btn = $(this);
        btn.html('<i class="fas fa-spinner fa-spin"></i> Processing...');
        btn.prop('disabled', true);

        window.location.href = '<?= base_url(); ?>reports/export_jobdesc_excel?' + formData;

        setTimeout(function() {
            btn.html('<i class="fas fa-file-excel me-1"></i> Export Excel');
            btn.prop('disabled', false);
        }, 2000);
    });

    $('#exportPDF').click(function() {
        var formData = $('#jobdesc_report').serialize();
        window.location.href = '<?= base_url(); ?>reports/export_jobdesc_pdf?' + formData;
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

        var divisi = $('#jk_divisi option:selected').text() || 'All';
        var karyawan = $('#jk_nama_karyawan option:selected').text() || 'All';
        var totalRecords = $('#jobdescResult .jobdesc-card').length;

        var printWindow = window.open('', '', 'height=1000,width=1000');

        var currentDate = new Date();
        var formattedDate = formatDate(currentDate);
        var formattedTime = formatTime(currentDate);

        printWindow.document.write(`
            <html>
            <head>
                <title>Jobdesc Report - SSH Group</title>
                <style>
                    @page { size: A4 portrait; margin: 1cm; }
                    body { font-family: "Segoe UI", Arial, sans-serif; margin: 0; padding: 20px; color: #333; }
                    .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #0066cc; padding-bottom: 10px; }
                    .company-name { font-size: 24px; font-weight: bold; color: #0066cc; margin-bottom: 5px; }
                    .report-filters { background: #f5f5f5; padding: 10px; border-radius: 5px; margin-bottom: 20px; font-size: 12px; }
                    .filter-row { display: flex; flex-wrap: wrap; margin-bottom: 5px; }
                    .filter-label { font-weight: bold; min-width: 120px; }
                    .jobdesc-card { border: 1px solid #ccc; border-radius: 5px; margin-bottom: 15px; page-break-inside: avoid; }
                    .jobdesc-card-header { background: #f5f5f5; padding: 10px; border-bottom: 1px solid #ccc; }
                    .print-table { width: 100%; border-collapse: collapse; font-size: 12px; }
                    .print-table th { background-color: #0066cc; color: white; padding: 6px; text-align: left; }
                    .print-table td { padding: 6px; border: 1px solid #ddd; vertical-align: top; }
                    .footer { margin-top: 20px; font-size: 11px; text-align: right; border-top: 1px solid #ddd; padding-top: 10px; }
                </style>
            </head>
            <body>
                <div class="header">
                    <div class="company-name">Jobdesc Report</div>
                    <div>Generated on: ${formattedDate} at ${formattedTime}</div>
                    <div>Total Records: ${totalRecords}</div>
                </div>
                <div class="report-filters">
                    <div class="filter-row"><span class="filter-label">Nama Divisi:</span> ${divisi}</div>
                    <div class="filter-row"><span class="filter-label">Nama Karyawan:</span> ${karyawan}</div>
                </div>
        `);

        $('#jobdescResult .jobdesc-card').each(function() {
            var header = $(this).find('.card-header').clone();
            var table = $(this).find('table').clone();
            printWindow.document.write('<div class="jobdesc-card"><div class="jobdesc-card-header">' + header.html() + '</div>');
            printWindow.document.write('<table class="print-table">' + table.html() + '</table></div>');
        });

        printWindow.document.write(`
                <div class="footer">
                    Document - SSH Group | ${new Date().getFullYear()}
                </div>
            </body>
            </html>
        `);

        printWindow.document.close();

        setTimeout(function() {
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        }, 500);
    });
});
</script>
