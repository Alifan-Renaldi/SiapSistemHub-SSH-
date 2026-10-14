<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Training Info</title>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .form-required {
            color: red;
            margin-left: 4px;
        }

        /* Add some custom styling for better appearance */
        .form-control-plaintext.border-bottom {
            min-height: 10px;
            padding: 1px 0;
        }
        .modal-body .form-group {
            margin-bottom: 1.0rem;
        }
        label strong {
            color: #495057;
        }

        /* Validation error styles */
        .is-invalid {
            border-color: #dc3545 !important;
        }
        .invalid-feedback {
            display: none;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 80%;
            color: #dc3545;
        }
        .was-validated .form-control:invalid,
        .was-validated .form-control.is-invalid,
        .form-control.is-invalid {
            border-color: #dc3545;
            padding-right: calc(1.5em + 0.75rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23dc3545' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }

        .form-equal-height {
        height: 36px;
        width: 470px;
        }
    
        .select2-container--default .select2-selection--single {
        height: 36px;
        padding: 5px 12px;
    }

        /* ============== DETAIL TRAINING MODAL STYLES ============== */
        .btn-detail-training, .btn-detail-tema {
            font-weight: 500 !important;
            font-family: inherit;
        }
        .btn-detail-training:hover {
            color: #0056b3 !important;
            font-weight: 600 !important;
            text-decoration: underline !important
        }
        .btn-detail-tema:hover {
            color: #1e7e34 !important;
            font-weight: 600 !important;
            text-decoration: underline !important;
        }
        #detailTrainingTable, #detailTemaTable { font-size: 0.9rem; }
        #detailTrainingTable tbody tr:hover, #detailTemaTable tbody tr:hover { background-color: #f8f9fa; }
        #detailTrainingTable .badge, #detailTemaTable .badge { font-size: 0.8rem; padding: 0.35em 0.65em; }
        #detailTrainingTable code, #detailTemaTable code { font-size: 0.75rem; color: #6c757d; background-color: #f8f9fa; padding: 0.2rem 0.4rem; border-radius: 0.25rem; }
        #emptyState, #emptyTemaState { opacity: 1; }
        #emptyState .fa-inbox, #emptyTemaState .fa-inbox { opacity: 0.3; }
        .tooltip-inner { max-width: 300px; text-align: left; }
        @media (max-width: 768px) {
            #modalDetailTraining .modal-dialog, #modalDetailTema .modal-dialog { max-width: 95%; margin: 1rem auto; }
            #detailTrainingTable, #detailTemaTable { font-size: 0.8rem; }
            #detailTrainingTable th, #detailTrainingTable td, #detailTemaTable th, #detailTemaTable td { padding: 0.5rem; }
        }
        /* ============== END DETAIL TRAINING MODAL STYLES ============== */
    </style>
</head>
<body>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Training List</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Training</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body p-0">
                <div class="d-flex align-items-center justify-content-between p-3">
                    <?php if (function_exists('userpermission') && userpermission('lr_drivers_add_training')) : ?>
                <a href="#" class="btn btn-primary" data-toggle="modal" 
                   data-target="#trainingModal" data-action="add" onclick="$(this).data('action', 'add')">
                   <i class="fa fa-plus"></i>
                    Add New Training
                </a>
                <?php endif; ?>
                <div id="table-filter" class="d-flex align-items-center">
                    <span class="mr-2">Search:</span>
                </div>
            </div>
                <div class="table-responsive">
                    <table id="driverslisttbl" class="table card-table table-vcenter text-nowrap">
                        <thead>
                            <tr>
                                <th class="w-1">No</th>
                                <th>Tanggal Training</th>
                                <th>Nama Supir</th>
                                <th>Tema</th>
                                <th>Pemateri</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($traininglist_drivers)):  $count = 1;
                        ?>
                        <?php foreach($traininglist_drivers as $traininglist_driversdata): ?>
                            <tr>
                                <td><?= $count; $count++; ?></td>
                                <td><?= esc(date('d-m-Y', strtotime($traininglist_driversdata['tr_tanggal']))); ?></td>
                                <td>
                                    <a href="#" class="btn-detail-training text-primary" data-driver-name="<?= esc($traininglist_driversdata['tr_supir']); ?>" data-driver-nis="<?= esc($traininglist_driversdata['tr_nis']); ?>" style="cursor: pointer; text-decoration: none; font-weight: 500;">
                                        <i class="fa fa-users mr-1"></i><?= esc($traininglist_driversdata['tr_supir']); ?>
                                    </a>
                                </td>
                                <td>
                                    <a href="#" class="btn-detail-tema text-success" data-tema-name="<?= esc($traininglist_driversdata['tr_tema']); ?>" style="cursor: pointer; text-decoration: none; font-weight: 500;">
                                        <i class="fa fa-book mr-1"></i><?= esc($traininglist_driversdata['tr_tema']); ?>
                                    </a>
                                </td>
                                <td><?= esc($traininglist_driversdata['tr_pemateri']); ?></td>
                                <td>
                                    <?php if (function_exists('userpermission') && userpermission('lr_drivers_edit_training')) : ?>
                                    <a class="icon edit-training" href="<?= base_url('trainings/edittraining/' . $traininglist_driversdata['tr_id']); ?>" data-id="<?= esc($traininglist_driversdata['tr_id']); ?>">
                                        <i class="fa fa-edit text-primary"></i>
                                    </a>
                                    |
                                    <?php endif; ?>
                                    <?php if (function_exists('userpermission') && userpermission('lr_drivers_view_training')) : ?>
                                    <a class="icon" href="<?= base_url('viewtraining/' . $traininglist_driversdata['tr_id']); ?>">
                                    <i class="fa fa-eye text-success"></i>
                                    </a>
                                    <?php endif; ?>
                                    <?php if (function_exists('userpermission') && userpermission('lr_drivers_delete_training')) : ?>
                                    |
                                    <form id="delete-form-<?= $traininglist_driversdata['tr_id'] ?>" action="<?= base_url('drivers/training_delete/' . $traininglist_driversdata['tr_id']) ?>" 
                                          method="post"
                                          style="display: inline;" 
                                          >
                                        <?= csrf_field() ?>
                                        <button type="button" class="btn btn-link text-danger p-0 border-0" onclick="confirmDeleteTraining('<?= esc($traininglist_driversdata['tr_id']) ?>', '<?= esc($traininglist_driversdata['tr_code']) ?>', '<?= esc($traininglist_driversdata['tr_nis']) ?>', '<?= esc($traininglist_driversdata['tr_supir']) ?>')"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                                <?php endif; ?>
                            </tr>
                            <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Insert the modal to handle both add and edit -->
<div class="modal fade" id="trainingModal" tabindex="-1" role="dialog" aria-labelledby="trainingModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="trainingModalLabel">Add Training</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="trainingForm" action="<?= base_url('drivers/inserttraining'); ?>" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>
                <input type="hidden" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>" />
                 <input type="hidden" id="tr_id" name="tr_id" value="">
                 <input type="hidden" id="tr_nis" name="tr_nis" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="trCode">Nomor Training<span class="form-required"></span></label>
                        <input type="text" id="tr_code" class="form-control" name="tr_code" value="<?= (isset($traininglist_driversdata) && !empty($traininglist_driversdata[0]['tr_code'])) ? esc($traininglist_driversdata[0]['tr_code']) : '' ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="trainingDate">Tanggal Training<span class="form-required">*</span></label>
                        <input type="date" class="form-control" id="trainingDate" name="tr_tanggal" required>
                        <div class="invalid-feedback">Harap isi tanggal training</div>
                    </div>
                    <div class="form-group">
                        <label for="tr_supir">Nama Supir<span class="form-required">*</span></label>
                        <select id="tr_supir" class="form-control select2" name="tr_supir[]" multiple required>
                            <option value="">-- Pilih Supir --</option>
                            <?php 
                            usort($driverlist, function($a, $b) {
                                return strcmp($a['d_name'], $b['d_name']);
                            });
                            foreach ($driverlist as $driver) {
                                if ($driver['d_is_active'] == 1) {
                                    echo '<option value="' . esc($driver['d_name']) . '" data-nis="' . esc($driver['d_nis']) . '">' . esc($driver['d_name']) . '</option>';
                                }
                            }
                            ?>
                        </select>
                        <div class="invalid-feedback">Harap pilih minimal satu supir</div>
                    </div>
                    <div class="form-group">
                        <label for="category">Kategori<span class="form-required">*</span></label>
                        <select class="form-control" id="category" name="tr_kategori" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Operasional">Operasional</option>
                            <option value="Bengkel">Bengkel</option>
                            <option value="Etika, Kesehatan, & Keselamatan">Etika, Kesehatan, & Keselamatan</option>
                        </select>
                        <div class="invalid-feedback">Harap pilih kategori training</div>
                    </div>
                    <div class="form-group">
                        <label for="trainer">Pemateri<span class="form-required">*</span></label>
                        <input type="text" class="form-control" id="trainer" name="tr_pemateri" required>
                        <div class="invalid-feedback">Harap isi nama pemateri</div>
                    </div>
                    <div class="form-group">
                        <label for="trainingTheme">Tema<span class="form-required">*</span></label>
                        <input type="text" class="form-control" id="trainingTheme" name="tr_tema" required>
                        <div class="invalid-feedback">Harap isi tema training</div>
                    </div>
                    <div class="form-group">
                        <label>Lokasi<span class="form-required">*</span></label>
                        <div class="d-flex">
                            <div class="form-check form-check-inline mr-3">
                                <input class="form-check-input" type="radio" name="tr_lokasi" id="lokasi1" value="Pool Way Lunik" required>
                                <label class="form-check-label" for="lokasi1">Pool Way Lunik</label>
                            </div>
                            <div class="form-check form-check-inline mr-3">
                                <input class="form-check-input" type="radio" name="tr_lokasi" id="lokasi2" value="Pool PJR" required>
                                <label class="form-check-label" for="lokasi2">Pool PJR</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tr_lokasi" id="lokasi3" value="Pool Yos" required>
                                <label class="form-check-label" for="lokasi3">Pool Yos</label>
                            </div>
                        </div>
                        <div class="invalid-feedback" style="display: block;">Harap pilih lokasi training</div>
                    </div>
                    <div class="form-group">
                        <label for="trainingDescription">Keterangan</label>
                        <textarea class="form-control" id="trainingDescription" name="tr_keterangan" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="tr_document">Upload Modul Training (PDF) <span class="form-required" style="color: red;">*</span></label>
                        <input type="file" name="tr_document" id="tr_document" class="form-control" accept=".pdf,application/pdf">
                    </div>
                </div>
                <input type="hidden" id="tr_modified_date" name="tr_modified_date" value="<?= date('Y-m-d H:i:s'); ?>">
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editTrainingModal" tabindex="-1" role="dialog" aria-labelledby="editTrainingModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTrainingModalLabel">Edit Training</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editTrainingForm" action="<?= base_url('drivers/updatetraining'); ?>" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>
                <input type="hidden" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>" />
                <input type="hidden" id="edit_tr_id" name="tr_id" value="">
                <input type="hidden" id="edit_tr_nis" name="tr_nis" value="">

                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_tr_code">Nomor Training</label>
                        <input type="text" id="edit_tr_code" class="form-control" name="tr_code" readonly>
                    </div>
                    <div class="form-group">
                        <label for="edit_trainingDate">Tanggal Training<span class="form-required">*</span></label>
                        <input type="date" class="form-control" id="edit_trainingDate" name="tr_tanggal" required>
                        <div class="invalid-feedback">Harap isi tanggal training</div>
                    </div>

                    <div class="form-group">
                        <label for="edit_tr_supir">Nama Supir<span class="form-required">*</span></label>
                        <select id="edit_tr_supir" class="form-control select2" name="tr_supir" required>
                            <option value="">-- Pilih Supir --</option>
                            <?php 
                            foreach ($driverlist as $driver) {
                                if ($driver['d_is_active'] == 1) {
                                    echo '<option value="' . esc($driver['d_name']) . '" data-nis="' . esc($driver['d_nis']) . '">' . esc($driver['d_name']) . '</option>';
                                }
                            }
                            ?>
                        </select>
                        <div class="invalid-feedback">Harap pilih nama supir</div>
                    </div>

                    <div class="form-group">
                        <label for="edit_category">Kategori<span class="form-required">*</span></label>
                        <select class="form-control" id="edit_category" name="tr_kategori" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Operasional">Operasional</option>
                            <option value="Bengkel">Bengkel</option>
                            <option value="Etika, Kesehatan, & Keselamatan">Etika, Kesehatan, & Keselamatan</option>
                        </select>
                        <div class="invalid-feedback">Harap pilih kategori training</div>
                    </div>
                    <div class="form-group">
                        <label for="edit_trainer">Pemateri<span class="form-required">*</span></label>
                        <input type="text" class="form-control" id="edit_trainer" name="tr_pemateri" required>
                        <div class="invalid-feedback">Harap isi nama pemateri</div>
                    </div>
                    <div class="form-group">
                        <label for="edit_trainingTheme">Tema<span class="form-required">*</span></label>
                        <input type="text" class="form-control" id="edit_trainingTheme" name="tr_tema" required>
                        <div class="invalid-feedback">Harap isi tema training</div>
                    </div>
                    <div class="form-group">
                        <label>Lokasi<span class="form-required">*</span></label>
                        <div class="d-flex">
                            <div class="form-check form-check-inline mr-3">
                                <input class="form-check-input" type="radio" name="tr_lokasi" id="edit_lokasi1" value="Pool Way Lunik" required>
                                <label class="form-check-label" for="edit_lokasi1">Pool Way Lunik</label>
                            </div>
                            <div class="form-check form-check-inline mr-3">
                                <input class="form-check-input" type="radio" name="tr_lokasi" id="edit_lokasi2" value="Pool PJR" required>
                                <label class="form-check-label" for="edit_lokasi2">Pool PJR</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tr_lokasi" id="edit_lokasi3" value="Pool Yos" required>
                                <label class="form-check-label" for="edit_lokasi3">Pool Yos</label>
                            </div>
                        </div>
                        <div class="invalid-feedback">Harap pilih lokasi training</div>
                    </div>
                    <div class="form-group">
                        <label for="edit_trainingDescription">Keterangan</label>
                        <textarea class="form-control" id="edit_trainingDescription" name="tr_keterangan" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit_tr_document">Ganti Modul Training (PDF)</label>
                        <input type="file" name="tr_document" id="edit_tr_document" class="form-control" accept=".pdf,application/pdf">
                        <input type="hidden" name="existing_pdf" id="existing_pdf" value="">
                        <small id="current_tr_document" class="form-text text-muted" style="display:none;"></small>
                    </div>
                </div>
                <input type="hidden" id="edit_tr_modified_date" name="tr_modified_date" value="<?= date('Y-m-d H:i:s'); ?>">
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Training Modal -->
<div class="modal fade" id="viewTrainingModal" tabindex="-1" role="dialog" aria-labelledby="viewTrainingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="viewTrainingModalLabel" style="font-size: 1.5rem;">Training Details</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card-body">
                    <div class="col-md-12">
                            <h3 class="text-center"><strong>Modul Training Supir</strong></h3>
                            <hr>
                            <div class="text-center" id="viewTrDocument"></div>
                        </div>
                    </div>
                </div>
                    <div class="col-md-8">
                        <div class="row">
                            <!-- First Column -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Nomor Training</strong></label>
                                    <div class="form-control-plaintext border-bottom" id="viewTrCode"></div>
                                </div>
                                <div class="form-group">
                                    <label><strong>Nomor Induk Supir</strong></label>
                                    <div class="form-control-plaintext border-bottom" id="viewTrNis"></div>
                                </div>
                                <div class="form-group">
                                    <label><strong>Kategori</strong></label>
                                    <div class="form-control-plaintext border-bottom" id="viewCategory"></div>
                                </div>
                                <div class="form-group">
                                    <label><strong>Pemateri</strong></label>
                                    <div class="form-control-plaintext border-bottom" id="viewTrainer"></div>
                                </div>
                            </div>
                            
                            <!-- Second Column -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Tanggal Training</strong></label>
                                    <div class="form-control-plaintext border-bottom" id="viewTrainingDate"></div>
                                </div>
                                <div class="form-group">
                                    <label><strong>Nama Supir</strong></label>
                                    <div class="form-control-plaintext border-bottom text-primary font-weight-bold">
                                        <a href="#" id="viewDetailTrainingLink" class="btn-detail-training text-primary" data-driver-name="" data-driver-nis="" style="cursor: pointer; text-decoration: none; font-weight: 500;">
                                            <i class="fa fa-users mr-1"></i><span id="viewTrSupir"></span>
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label><strong>Tema</strong></label>
                                    <div class="form-control-plaintext border-bottom text-success font-weight-bold">
                                        <a href="#" id="viewDetailTemaLink" class="btn-detail-tema text-success" data-tema-name="" style="cursor: pointer; text-decoration: none; font-weight: 500;">
                                            <i class="fa fa-book mr-1"></i><span id="viewTrainingTheme"></span>
                                        </a>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label><strong>Lokasi</strong></label>
                                    <div class="form-control-plaintext border-bottom" id="viewLocation"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Full width row for description -->
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="form-group">
                            <label><strong>Keterangan</strong></label>
                            <div class="form-control-plaintext border p-3 bg-light" id="viewTrainingDescription" style="min-height: 100px;"></div>
                        </div>
                    </div>
                </div>
                <!-- Full width row for system info -->
                <?php if (userpermission('lr_view_userby')) { ?>
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <!-- <div class="card-header">
                                <h3 class="card-title">System Information</h3>
                            </div> -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4" style="text-align: center;">
                                        <div class="form-group">
                                            <label><strong>Petugas</strong></label>
                                            <div class="form-control-plaintext border-bottom" id="viewCreatedBy"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="text-align: center;">
                                        <div class="form-group">
                                            <label><strong>Tanggal Penginputan</strong></label>
                                            <div class="form-control-plaintext border-bottom" id="viewCreatedDate"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="text-align: center;">
                                        <div class="form-group">
                                            <label><strong>Riwayat Terakhir Perubahan</strong></label>
                                            <div class="form-control-plaintext border-bottom" id="viewModifiedDate"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<!-- ============== MODAL DETAIL TRAINING (NEW) ============== -->
<div class="modal fade" id="modalDetailTraining" tabindex="-1" role="dialog" aria-labelledby="modalDetailTrainingLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalDetailTrainingLabel"><i class="fa fa-list-alt mr-2"></i>Riwayat Training Supir</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="card mb-3">
                    <div class="card-header bg-light"><h6 class="mb-0"><i class="fa fa-user mr-2"></i>Informasi Supir</h6></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6"><strong>Nama Supir:</strong><p id="detailDriverName" class="mb-2">-</p></div>
                            <div class="col-md-6"><strong>NIS:</strong><p id="detailDriverNIS" class="mb-2">-</p></div>
                        </div>
                        <div class="row"><div class="col-12"><strong>Total Modul Training:</strong> <span id="detailTrainingCount" class="badge badge-primary">0</span></div></div>
                    </div>
                </div>
                <div id="loadingIndicator" class="text-center py-5" style="display: none;">
                    <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"><span class="sr-only">Loading...</span></div>
                    <p class="mt-3 text-muted">Memuat data training...</p>
                </div>
                <div id="errorMessage" class="alert alert-danger" role="alert" style="display: none;"><i class="fa fa-exclamation-triangle mr-2"></i><span id="errorText">Terjadi kesalahan</span></div>
                <div id="emptyState" class="text-center py-5" style="display: none;"><i class="fa fa-inbox fa-3x text-muted mb-3"></i><p class="text-muted">Supir ini belum pernah mengikuti training</p></div>
                <div id="trainingListContainer" style="display: none;">
                    <h6 class="mb-3"><i class="fa fa-book mr-2"></i>Daftar Tema Training</h6>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="detailTrainingTable">
                            <thead class="thead-light">
                                <tr>
                                    <th width="5%" class="text-center">No</th>
                                    <th width="18%" class="text-center">Kode Training</th>
                                    <th width="15%"class="text-center">Tanggal</th>
                                    <th width="15%" class="text-center">Modul Training</th>
                                    <th width="15%" class="text-center">Divisi</th>
                                    <th width="13%" class="text-center">Pemateri</th>
                                    <th width="10%" class="text-center">Lokasi</th>
                                </tr>
                            </thead>
                            <tbody id="trainingListBody"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times mr-2"></i>Tutup</button></div>
        </div>
    </div>
</div>
<!-- ============== MODAL DETAIL TEMA -> DAFTAR SUPIR (INVERSE) ============== -->
<div class="modal fade" id="modalDetailTema" tabindex="-1" role="dialog" aria-labelledby="modalDetailTemaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalDetailTemaLabel"><i class="fa fa-users mr-2"></i>Daftar Supir - Tema Training</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="card mb-3">
                    <div class="card-header bg-light"><h6 class="mb-0"><i class="fa fa-book mr-2"></i>Informasi Tema</h6></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8"><strong>Nama Tema:</strong><p id="detailTemaName" class="mb-2">-</p></div>
                            <div class="col-md-4"><strong>Total Supir:</strong> <span id="detailTemaCount" class="badge badge-success">0</span></div>
                        </div>
                    </div>
                </div>
                <div id="loadingTemaIndicator" class="text-center py-5" style="display: none;">
                    <div class="spinner-border text-success" role="status" style="width: 3rem; height: 3rem;"><span class="sr-only">Loading...</span></div>
                    <p class="mt-3 text-muted">Memuat daftar supir...</p>
                </div>
                <div id="errorTemaMessage" class="alert alert-danger" role="alert" style="display: none;"><i class="fa fa-exclamation-triangle mr-2"></i><span id="errorTemaText">Terjadi kesalahan</span></div>
                <div id="emptyTemaState" class="text-center py-5" style="display: none;"><i class="fa fa-inbox fa-3x text-muted mb-3"></i><p class="text-muted">Belum ada supir yang mengikuti tema ini</p></div>
                <div id="temaListContainer" style="display: none;">
                    <h6 class="mb-3"><i class="fa fa-list mr-2"></i>Daftar Supir Peserta</h6>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="detailTemaTable">
                            <thead class="thead-light">
                                <tr>
                                    <th width="5%" class="text-center">No</th>
                                    <th width="22%" class="text-center">Kode Training</th>
                                    <th width="13%" class="text-center">Tanggal</th>
                                    <th width="16%" class="text-center">Nama Supir</th>
                                    <th width="13%" class="text-center">NIS</th>
                                    <th width="12%" class="text-center">Kategori</th>
                                    <th width="15%" class="text-center">Pemateri</th>
                                    <th width="10%" class="text-center">Lokasi</th>
                                </tr>
                            </thead>
                            <tbody id="temaListBody"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times mr-2"></i>Tutup</button></div>
        </div>
    </div>
</div>
<!-- ============== END MODAL DETAIL TRAINING ============== -->
<?= view('layout/footer') ?>

<script src="<?= base_url('assets/autoLogout.js') ?>"></script>
<script>
    const baseUrl = "<?= base_url() ?>"; 
    enableAutoLogout(7200, baseUrl + "login");

    function confirmDeleteTraining(id, code, nis, name){
        Swal.fire({
            title: 'Apakah anda yakin ingin menghapus data training supir tersebut?',
            icon: 'warning',
            html: 'Kode Training : <b>' + code + '</b>' + '<br>' + 'NIS : <b>' + nis + '</b>' + '<br>' + 'Nama Supir : <b>' + name + '</b>',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
        }).then(result => {
            if(result.isConfirmed){
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
    
    function showNotification(message, type = 'error') {
    const existingNotification = document.querySelector('.custom-notification');
    if (existingNotification) {
        existingNotification.remove();
    }
    
    const notification = document.createElement('div');
    notification.className = `custom-notification alert alert-${type === 'error' ? 'danger' : 'success'} alert-dismissible fade show`;
    notification.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        ${message}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}
    
$(document).ready(function () {
    var table = $('#driverslisttbl').DataTable({
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

    
    $('.select2').select2({
        placeholder: "-- Pilih Supir --",
        allowClear: true,
        width: '100%'
    });
    
    $('#tr_supir').on('change', function() {
        updateNIS(this, document.getElementById('tr_nis'));
    });

    $('#edit_tr_supir').on('change', function() {
        updateNIS(this, document.getElementById('edit_tr_nis'));
    });

    function updateNIS(selectElement, hiddenInputElement) {
        if (!selectElement || !hiddenInputElement) return;
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const nis = selectedOption ? selectedOption.getAttribute('data-nis') : '';
        hiddenInputElement.value = nis || '';
    }
});

var today = new Date().toISOString().split('T')[0];
$('#trainingDate').val(today);

$('a[href*="addtraining"]').attr('data-toggle', 'modal').attr('data-target', '#trainingModal').attr('href', '#');

$.get('<?= base_url('drivers/generateTrCode') ?>', function(res) {
        if (res.status) {
            $('#add_tr_code').val(res.code);
        } else {
            alert('Gagal generate kode');
        }
    });

$(document).on('click', '.edit-training', function(e) {
    e.preventDefault();
    const tr_id = $(this).data('id');

    $.get('<?= base_url('trainings/edittraining') ?>/' + tr_id, function(response) {
        if (response.status) {
            const d = response.data;
            $('#edit_tr_id').val(d.tr_id);
            $('#edit_tr_code').val(d.tr_code);
            $('#edit_trainingDate').val(d.tr_tanggal);
            $('#edit_category').val(d.tr_kategori);
            $('#edit_trainer').val(d.tr_pemateri);
            $('#edit_trainingTheme').val(d.tr_tema);
            $(`input[name="tr_lokasi"][value="${d.tr_lokasi}"]`).prop('checked', true);
            $('#edit_trainingDescription').val(d.tr_keterangan);
            $('#existing_pdf').val(d.tr_document || '');
            if (d.tr_document) {
                $('#current_tr_document').html('File saat ini: <a href="' + baseUrl + 'assets/uploads/training/' + d.tr_document + '" target="_blank">' + d.tr_document + '</a>').show();
            } else {
                $('#current_tr_document').hide().empty();
            }
            $('#edit_tr_document').val('');

            const supirValue = d.tr_supir;
            $('#edit_tr_supir').val(supirValue).trigger('change');

            const nis = $('#edit_tr_supir').find(`option[value="${supirValue}"]`).data('nis') || '';
            $('#edit_tr_nis').val(nis);

            $('#editTrainingModal').modal('show');
        } else {
            alert('Gagal memuat data training.');
        }
    }).fail(function() {
        alert('Error koneksi saat memuat data edit.');
    });
});

// Reset modal when closed
$('#trainingModal').on('show.bs.modal', function (e) {
    const button = $(e.relatedTarget);
    const action = button.data('action'); // 'add' atau 'edit'

    if (action === 'add') {
        // Reset form
        $('#trainingForm')[0].reset();
        $('#tr_id').val('');
        $('#trainingModalLabel').text('Add Training');
        $('#trainingForm').attr('action', '<?= base_url('drivers/inserttraining'); ?>');
        $('input[name="tr_lokasi"]').prop('checked', false);

        // Ambil tr_code baru
        $.get('<?= base_url('drivers/generateCode') ?>', function(res) {
            if (res.status) {
                $('#tr_code').val(res.code);
            } else {
                alert('Gagal generate kode');
            }
        }).fail(() => alert('Gagal koneksi ke server'));
    }
});

// Form validation
(function() {
    'use strict';
    const addForm = document.getElementById('trainingForm');
    if (addForm) {
        addForm.addEventListener('submit', function(e) {
            if (!this.checkValidity()) {
                e.preventDefault(); e.stopPropagation();
            }

            const supirVal = $('#tr_supir').val();
            if (!supirVal || supirVal.length === 0) {
                $('#tr_supir').addClass('is-invalid');
                $('#tr_supir').siblings('.invalid-feedback').show();
                e.preventDefault(); e.stopPropagation();
            } else {
                $('#tr_supir').removeClass('is-invalid');
                $('#tr_supir').siblings('.invalid-feedback').hide();
            }

            if (!$('input[name="tr_lokasi"]:checked').length) {
                $('input[name="tr_lokasi"]').closest('.form-group').find('.invalid-feedback').show();
                e.preventDefault(); e.stopPropagation();
            }

            const trDocument = document.getElementById('tr_document');
            if (!trDocument.files || trDocument.files.length === 0) {
                showNotification('Harap unggah Modul Training (PDF).', 'error');
                e.preventDefault(); e.stopPropagation();
            }

            this.classList.add('was-validated');
        }, false);
    }

    const editForm = document.getElementById('editTrainingForm');
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            if (!this.checkValidity()) {
                e.preventDefault(); e.stopPropagation();
            }

            const supirVal = $('#edit_tr_supir').val();
            if (!supirVal) {
                $('#edit_tr_supir').addClass('is-invalid');
                $('#edit_tr_supir').siblings('.invalid-feedback').show();
                e.preventDefault(); e.stopPropagation();
            } else {
                $('#edit_tr_supir').removeClass('is-invalid');
                $('#edit_tr_supir').siblings('.invalid-feedback').hide();
            }

            if (!$('input[name="tr_lokasi"]:checked').length) {
                $('input[name="tr_lokasi"]').closest('.form-group').find('.invalid-feedback').show();
                e.preventDefault(); e.stopPropagation();
            }

            this.classList.add('was-validated');
        }, false);
    }
})();

// Validasi upload modul training (PDF, maks 5MB)
function validateTrainingPdf(input) {
    const file = input.files[0];
    if (!file) return true;
    const isPdf = file.type === 'application/pdf' || file.name.toLowerCase().endsWith('.pdf');
    const sizeMB = file.size / (1024 * 1024);
    if (!isPdf) {
        showNotification('Format file modul training hanya PDF.', 'error');
        input.value = '';
        return false;
    }
    if (sizeMB > 5) {
        showNotification('Ukuran file modul training maksimal 5MB.', 'error');
        input.value = '';
        return false;
    }
    return true;
}
document.getElementById('tr_document').addEventListener('change', function () { validateTrainingPdf(this); });
document.getElementById('edit_tr_document').addEventListener('change', function () { validateTrainingPdf(this); });

// Reset modal edit training saat ditutup
$('#editTrainingModal').on('hidden.bs.modal', function () {
    $('#editTrainingForm')[0].reset();
    $('#existing_pdf').val('');
    $('#current_tr_document').hide().empty();
    $('#edit_tr_document').val('');
    $('#editTrainingForm').removeClass('was-validated');
    $('#editTrainingForm').find('.invalid-feedback').hide();
});

// Radio button validation
document.querySelectorAll('input[name="tr_lokasi"]').forEach(function(radio) {
    radio.addEventListener('change', function() {
        if (this.checked) {
            document.querySelector('input[name="tr_lokasi"]').closest('.form-group').querySelector('.invalid-feedback').style.display = 'none';
            document.querySelector('input[name="tr_lokasi"]').closest('.form-group').classList.remove('is-invalid');
        }
    });
});

// Reset validation when modal is closed
$('#trainingModal').on('hidden.bs.modal', function () {
    $('#trainingForm')[0].reset();
    $('#trainingModalLabel').text('Add Training');
    $('#trainingForm').attr('action', '<?= base_url('drivers/inserttraining'); ?>');
    $('#tr_id').val('');
    $('#tr_supir').val(null).trigger('change');
    $('#trainingForm').removeClass('was-validated');
    // Hide all error messages
    $('#trainingForm').find('.invalid-feedback').hide();
});

// Handle view buttons
$(document).on('click', 'a[href*="viewtraining"]', function(e) {
    e.preventDefault();
    var url = $(this).attr('href');
    var tr_id = url.split('/').pop();
    
    // Fetch training details via AJAX
    $.ajax({
        url: '<?= base_url('trainings/viewtraining'); ?>/' + tr_id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            try {
                $('#viewTrDocument').empty();
                if(response.status) {
                    let format = response.data || {};
                    // Populate the modal with the data
                    if (format.tr_tanggal) {
                        const date = new Date(format.tr_tanggal);
                        const formattedDate = `${date.getDate().toString().padStart(2, '0')}-${(date.getMonth() + 1).toString().padStart(2, '0')}-${date.getFullYear()}`;
                        $('#viewTrainingDate').text(formattedDate);
                    }
                    else {
                        $('#viewTrainingDate').text('-');
                    }
                    if(format.tr_created_date) {
                        const dateCreated = new Date(format.tr_created_date);
                        const formattedDateCreated = `${dateCreated.getDate().toString().padStart(2, '0')}-${(dateCreated.getMonth() + 1).toString().padStart(2, '0')}-${dateCreated.getFullYear()}
                        (${dateCreated.getHours().toString().padStart(2, '0')}:${dateCreated.getMinutes().toString().padStart(2, '0')}:${dateCreated.getSeconds().toString().padStart(2, '0')})`;
                        $('#viewCreatedDate').text(formattedDateCreated);
                    } 
                    else {
                        $('#viewCreatedDate').text('-');
                    }
                    if(format.tr_modified_date) {
                        const dateModified = new Date(format.tr_modified_date);
                        const formattedDateModified = `${dateModified.getDate().toString().padStart(2, '0')}-${(dateModified.getMonth() + 1).toString().padStart(2, '0')}-${dateModified.getFullYear()}
                        (${dateModified.getHours().toString().padStart(2, '0')}:${dateModified.getMinutes().toString().padStart(2, '0')}:${dateModified.getSeconds().toString().padStart(2, '0')})`;
                        $('#viewModifiedDate').text(formattedDateModified);
                    } 
                    else {
                        $('#viewCreatedDate').text('-');
                    }
                    $('#viewTrNis').text(response.data.tr_nis || '-');
                    $('#viewTrCode').text(response.data.tr_code || '-');
                    $('#viewTrSupir').text(response.data.tr_supir || '-');
                    $('#viewCategory').text(response.data.tr_kategori || '-');
                    $('#viewTrainer').text(response.data.tr_pemateri || '-');
                    $('#viewTrainingTheme').text(response.data.tr_tema || '-');
                    $('#viewLocation').text(response.data.tr_lokasi || '-');
                    $('#viewTrainingDescription').text(response.data.tr_keterangan || '-');
                    $('#viewCreatedBy').text(response.data.creator_name || response.data.tr_created_by || '-');
                    $('#viewDetailTrainingLink').attr('data-driver-name', response.data.tr_supir || '').attr('data-driver-nis', response.data.tr_nis || '');
                    $('#viewDetailTemaLink').attr('data-tema-name', response.data.tr_tema || '');

                    const trDocument = response.data.tr_document || '';
                    if (trDocument) {
                        const trainingModul = baseUrl + 'assets/uploads/training/' + trDocument;
                        $('#viewTrDocument').html(
                            '<embed src="' + trainingModul + '" type="application/pdf" style="width: 100%; height: 250px; border: 1px solid #ddd;">' +
                            '<p class="mt-2"><a href="' + trainingModul + '" target="_blank" class="btn btn-primary btn-sm"><i class="fas fa-file-pdf"></i> View Full PDF</a></p>'
                        );
                    } else {
                        $('#viewTrDocument').html('<p class="text-muted">Tidak ada modul training yang diunggah.</p>');
                    }

                    
                    // Show the modal
                    $('#viewTrainingModal').modal('show');
                } else {
                    alert('Failed to load training details: ' + (response.message || 'Unknown error'));
                }
            } catch(e) {
                console.error('Error parsing response:', e);
                alert('Invalid response from server');
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
            try {
                var response = JSON.parse(xhr.responseText);
                alert('Error: ' + (response.message || 'Unknown error'));
            } catch(e) {
                alert('Error loading training details');
            }
        }
    });
});

// ============== DETAIL TRAINING FUNCTIONALITY ==============
$(document).on('click', '.btn-detail-training', function(e) {
    e.preventDefault();
    const driverName = $(this).data('driver-name');
    const driverNIS = $(this).data('driver-nis');
    if (!driverName) {
        Swal.fire({ icon: 'error', title: 'Error', text: 'Nama supir tidak ditemukan' });
        return;
    }
    $('#modalDetailTema').modal('hide');
    $('#modalDetailTraining').modal('show');
    $('#detailDriverName').text(driverName);
    $('#detailDriverNIS').text(driverNIS || '-');
    showLoadingState();
    fetchTrainingDetails(driverName);
});
function fetchTrainingDetails(driverName) {
    const csrfName = '<?= csrf_token(); ?>';
    const csrfHash = '<?= csrf_hash(); ?>';
    $.ajax({
        url: '<?= base_url('trainings/getDetailByDriver'); ?>',
        type: 'POST',
        dataType: 'json',
        data: { [csrfName]: csrfHash, driver_name: driverName },
        success: function(response) {
            if (response.success) {
                if (response.data && response.data.length > 0) {
                    renderTrainingList(response.data, response.total);
                } else {
                    showEmptyState();
                }
            } else {
                showErrorState(response.message || 'Gagal memuat data');
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
            let errorMsg = 'Gagal menghubungi server. Silakan coba lagi.';
            try { const r = JSON.parse(xhr.responseText); errorMsg = r.message || errorMsg; } catch(e) {}
            showErrorState(errorMsg);
        },
        timeout: 10000
    });
}
function renderTrainingList(data, total) {
    $('#loadingIndicator').hide(); $('#errorMessage').hide(); $('#emptyState').hide();
    $('#trainingListContainer').show();
    $('#detailTrainingCount').text(total);
    const tbody = $('#trainingListBody'); tbody.empty();
    data.forEach(function(training, index) {
        const rowNumber = index + 1;
        const keteranganTooltip = training.tr_keterangan && training.tr_keterangan !== '-' ? 'data-toggle="tooltip" data-placement="top" title="'+training.tr_keterangan+'"' : '';
        const row = '<tr><td class="text-center">'+rowNumber+'</td><td class="text-center"><code>'+training.tr_code+'</code></td><td class="text-center">'+training.tr_tanggal+'</td><td class="text-center">'+ '<a href="#" class="btn-detail-tema text-success" data-tema-name="<?= esc($traininglist_driversdata['tr_tema']); ?>" style="cursor: pointer; text-decoration: none; font-weight: 500;">' + '<i class="fa fa-book mr-1"></i>'+ '<strong>' + training.tr_tema + '</strong>' + '</a></td>'+(training.tr_keterangan !== '-' ? ' <i class="text-muted ml-1" '+keteranganTooltip+'></i>' : '')+'</td><td class="text-center"><span class="badge badge-'+getCategoryBadgeClass(training.tr_kategori)+'">'+training.tr_kategori+'</span></td><td class="text-center">'+training.tr_pemateri+'</td><td class="text-center">'+training.tr_lokasi+'</td></tr>';
        tbody.append(row);
    });
    $('[data-toggle="tooltip"]').tooltip();
}
function getCategoryBadgeClass(category) {
    const map = { 'Operasional': 'info', 'Bengkel': 'warning'};
    return map[category] || 'success';
}
function showLoadingState() { $('#loadingIndicator').show(); $('#errorMessage').hide(); $('#emptyState').hide(); $('#trainingListContainer').hide(); $('#detailTrainingCount').text('0'); }
function showErrorState(message) { $('#loadingIndicator').hide(); $('#emptyState').hide(); $('#trainingListContainer').hide(); $('#errorText').text(message); $('#errorMessage').show(); $('#detailTrainingCount').text('0'); }
function showEmptyState() { $('#loadingIndicator').hide(); $('#errorMessage').hide(); $('#trainingListContainer').hide(); $('#emptyState').show(); $('#detailTrainingCount').text('0'); }
$('#modalDetailTraining').on('hidden.bs.modal', function() {
    $('#detailDriverName').text('-'); $('#detailDriverNIS').text('-'); $('#detailTrainingCount').text('0');
    $('#trainingListBody').empty();
    $('#loadingIndicator').hide(); $('#errorMessage').hide(); $('#emptyState').hide(); $('#trainingListContainer').hide();
    $('[data-toggle="tooltip"]').tooltip('dispose');
});
// ============== END DETAIL TRAINING FUNCTIONALITY ==============

// ============== DETAIL TEMA -> DAFTAR SUPIR (INVERSE) ==============
$(document).on('click', '.btn-detail-tema', function(e) {
    e.preventDefault();
    const temaName = $(this).data('tema-name');
    if (!temaName) {
        Swal.fire({ icon: 'error', title: 'Error', text: 'Nama tema tidak ditemukan' });
        return;
    }
    $('#modalDetailTraining').modal('hide');
    $('#modalDetailTema').modal('show');
    $('#detailTemaName').text(temaName);
    showLoadingTemaState();
    fetchTemaDetails(temaName);
});
function fetchTemaDetails(temaName) {
    const csrfName = '<?= csrf_token(); ?>';
    const csrfHash = '<?= csrf_hash(); ?>';
    $.ajax({
        url: '<?= base_url('trainings/getDetailByTema'); ?>',
        type: 'POST',
        dataType: 'json',
        data: { [csrfName]: csrfHash, tema_name: temaName },
        success: function(response) {
            if (response.success) {
                if (response.data && response.data.length > 0) {
                    renderTemaList(response.data, response.total);
                } else {
                    showEmptyTemaState();
                }
            } else {
                showErrorTemaState(response.message || 'Gagal memuat data');
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Tema Error:', status, error);
            let errorMsg = 'Gagal menghubungi server. Silakan coba lagi.';
            try { const r = JSON.parse(xhr.responseText); errorMsg = r.message || errorMsg; } catch(e) {}
            showErrorTemaState(errorMsg);
        },
        timeout: 10000
    });
}
function renderTemaList(data, total) {
    $('#loadingTemaIndicator').hide(); $('#errorTemaMessage').hide(); $('#emptyTemaState').hide();
    $('#temaListContainer').show();
    $('#detailTemaCount').text(total);
    const tbody = $('#temaListBody'); tbody.empty();
    data.forEach(function(row, index) {
        const keteranganTooltip = row.tr_keterangan && row.tr_keterangan !== '-' ? 'data-toggle="tooltip" data-placement="top" title="'+row.tr_keterangan+'"' : '';
        const html = '<tr><td class="text-center">'+(index+1)+'</td><td class="text-center"><code>'+row.tr_code+'</code></td><td class="text-center">'+row.tr_tanggal+'</td><td class="text-center"><strong class="text-primary">'+ '<a href="#" class="btn-detail-training text-primary" data-driver-name="<?= esc($traininglist_driversdata['tr_supir']); ?>" data-driver-nis="<?= esc($traininglist_driversdata['tr_nis']); ?>" style="cursor: pointer; text-decoration: none; font-weight: 500;">'+ '<i class="fa fa-users mr-1"></i>'+ '<strong>'+ row.tr_supir + '</strong>' + '</a>' +'</strong>'+(row.tr_keterangan !== '-' ? ' <i class="text-muted ml-1" '+keteranganTooltip+'></i>' : '')+'</td><td class="text-center">'+row.tr_nis+'</td><td class="text-center"><span class="badge badge-'+getCategoryBadgeClass(row.tr_kategori)+'">'+row.tr_kategori+'</span></td><td class="text-center">'+row.tr_pemateri+'</td><td class="text-center">'+row.tr_lokasi+'</td></tr>';
        tbody.append(html);
    });
    $('[data-toggle="tooltip"]').tooltip();
}
function showLoadingTemaState() { $('#loadingTemaIndicator').show(); $('#errorTemaMessage').hide(); $('#emptyTemaState').hide(); $('#temaListContainer').hide(); $('#detailTemaCount').text('0'); }
function showErrorTemaState(msg) { $('#loadingTemaIndicator').hide(); $('#emptyTemaState').hide(); $('#temaListContainer').hide(); $('#errorTemaText').text(msg); $('#errorTemaMessage').show(); $('#detailTemaCount').text('0'); }
function showEmptyTemaState() { $('#loadingTemaIndicator').hide(); $('#errorTemaMessage').hide(); $('#temaListContainer').hide(); $('#emptyTemaState').show(); $('#detailTemaCount').text('0'); }
$('#modalDetailTema').on('hidden.bs.modal', function() {
    $('#detailTemaName').text('-'); $('#detailTemaCount').text('0');
    $('#temaListBody').empty();
    $('#loadingTemaIndicator').hide(); $('#errorTemaMessage').hide(); $('#emptyTemaState').hide(); $('#temaListContainer').hide();
    $('[data-toggle="tooltip"]').tooltip('dispose');
});
// ============== END DETAIL TEMA FUNCTIONALITY ==============

function confirmDelete() {
    return confirm("Apakah anda yakin ingin menghapus data ini?");
}

function updateDateTime() {
    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const day = String(now.getDate()).padStart(2, '0');
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    
    document.getElementById('tr_modified_date').value = 
        `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
}

setInterval(updateDateTime, 1000);
</script>

</body>
</html>