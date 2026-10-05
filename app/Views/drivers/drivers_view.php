<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Driver Details</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('drivers/drivers_management') ?>">Driver</a></li>
                    <li class="breadcrumb-item active">Driver Details</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <!-- Profile Image -->
                <div class="card card-success card-outline">
                    <div class="card-body box-profile">
                        <h3 class="profile-username text-center">
                            <b><?= ucwords(esc($driverdetails['d_name'])) ?></b>
                        </h3>

                        <p class="text-muted text-center"><?= ucwords(esc($driverdetails['d_nis'])) ?></p>

                        <div class="text-center">
                            <img src="<?= (!empty($driverdetails['d_photo'])) ? base_url('assets/uploads/drivers/') . esc($driverdetails['d_photo']) : base_url('assets/images/default-user.png') ?>" 
                                 alt="Driver Photo" style="max-width:200px; max-height:250px; object-fit:cover;">
                        </div>

                        <p class="text-muted text-center"><?= ($driverdetails['d_is_active']==1)?'<span class="right badge badge-success">Active</span>':'<span class="right badge badge-warning">Permission</span>' ?></p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>BAP</b> <a class="float-right"><?= count($baps) ?></a>
                            </li>
                            <li class="list-group-item">
                                <b>Survey</b> <a class="float-right"><?= count($surveys) ?></a>
                            </li>
                            <li class="list-group-item">
                                <b>Training</b> <a class="float-right"><?= count($trainings) ?></a>
                            </li>
                            <li class="list-group-item">
                                <b>Document :</b> <a><?= esc($driverdetails['d_docstatus']) ?></a>
                            </li>
                            <li class="list-group-item">
                                <b>Hutang :</b> 
                                <?php
                                $status = '-';
                                $class = 'no-loan';
                                
                                if (!empty($loansloan)) {
                                    foreach ($loansloan as $loan) {
                                        if ($loan['l_nis'] == $driverdetails['d_nis']) {
                                            if ($loan['l_is_status'] == 1 || $loan['l_is_status'] == 4) {
                                                $status = 'UNPAID';
                                                $class = 'unpaid';
                                            } elseif ($loan['l_is_status'] == 0 || $loan['l_is_status'] == 5) {
                                                $status = 'PAID';
                                                $class = 'paid';
                                            } else {
                                                $status = '-';
                                                $class = 'no-loan';
                                            }
                                            break;
                                        }
                                    }
                                }
                                                                
                                if (!empty($baps)) {
                                    foreach ($baps as $bap) {
                                        if ($bap['b_nis'] == $driverdetails['d_nis']) {
                                            // Check bap status
                                            if ($bap['b_is_status'] == 2) {
                                                $status = 'PAID';
                                                $class = 'paid';
                                            } elseif ($bap['b_is_status'] == 0) {
                                                $status = 'UNPAID';
                                                $class = 'unpaid';
                                            } elseif ($bap['b_is_status'] == 1) {
                                                $status = '-';
                                                $class = 'no-loan';
                                            }
                                            break;
                                        }
                                    }
                                }
                                
                                echo '<span class="' . $class . '">' . $status . '</span>';
                                ?>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-md-12 text-left mb-3">
                    <a href="<?= base_url('drivers/drivers_management') ?>" class="">
                        <i class="fa fa-arrow-left"></i> Back To Driver List
                    </a>
                </div>
            </div>
            
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#basicinfo" data-toggle="tab">Driver Info</a></li>
                            <?php if (function_exists('userpermission') && userpermission('lr_detail_view_bap')) : ?>
                            <li class="nav-item"><a class="nav-link" href="#baps" data-toggle="tab">BAP</a></li>
                            <?php endif; ?>
                            <?php if (function_exists('userpermission') && userpermission('lr_detail_view_svy')) : ?>
                            <li class="nav-item"><a class="nav-link" href="#survey" data-toggle="tab">Survey</a></li>
                            <?php endif; ?>
                            <?php if (function_exists('userpermission') && userpermission('lr_detail_view_trn')) : ?>
                            <li class="nav-item"><a class="nav-link" href="#trainings" data-toggle="tab">Training</a></li>
                            <?php endif; ?>
                            <?php if (function_exists('userpermission') && userpermission('lr_detail_view_doc')) : ?>
                            <li class="nav-item"><a class="nav-link" href="#driverdetailsdocument" data-toggle="tab">Document</a></li>
                            <?php endif; ?>
                            <?php if (function_exists('userpermission') && userpermission('lr_detail_view_loan')) : ?>
                            <li class="nav-item"><a class="nav-link" href="#loans" data-toggle="tab">Loan</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane" id="baps">
                                <div class="table-responsive">
                                <table id="bookingstbl" class="table table-striped projects">
                                    <thead>
                                        <tr>
                                            <th class="percent1">No</th>
                                            <th class="percent1">Tanggal BAP</th>
                                            <th class="percent25">Tanggal Kejadian</th>
                                            <th class="percent25">Lokasi Kejadian</th>
                                            <th class="percent25">Jenis Muatan</th>
                                            <th class="percent25">Jenis Kasus</th>
                                            <th class="percent25">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($baps)): ?>
                                            <?php $count = 1; ?>
                                            <?php foreach ($baps as $bapsdata): ?>
                                                <tr>
                                                    <td><?= $count++ ?></td>
                                                    <td><?= esc (date('d-m-Y', strtotime($bapsdata['b_tanggal']))) ?></td>
                                                    <td><?= esc (date('d-m-Y', strtotime($bapsdata['b_tanggal_kejadian']))) ?></td>
                                                    <td><?= esc($bapsdata['b_lokasi_kejadian']) ?></td>
                                                    <td><?= esc($bapsdata['b_muatan']) ?></td>
                                                    <td><?= esc($bapsdata['b_jenis_kasus']) ?></td>
                                                    <td>
                                                        <?php if(userpermission('lr_drivers_view_bap')): ?>
                                                        <form action="<?= base_url('baps/bap_view') ?>" method="POST" target="_blank" style="display: inline;">
                                                            <?= csrf_field() ?>
                                                            <input type="hidden" name="bap_id" value="<?= $bapsdata['b_id'] ?>">
                                                            <button type="submit" class="btn btn-link text-success p-0 border-0"><i class="fa fa-eye" title="Detail"></i></button>
                                                        </form>
                                                    <?php endif;?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="8">No BAP records found for this driver.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                                </div>
                            </div>

                            <div class="tab-pane" id="survey">
                                <div class="table-responsive">
                                <table id="bookingstbl" class="table table-striped projects">
                                    <thead>
                                        <tr>
                                            <th class="percent1">No</th>
                                            <th class="percent25">Tanggal Survey</th>
                                            <th class="percent25">Nama Istri</th>
                                            <th class="percent25">Pekerjaan Istri</th>
                                            <?php if (function_exists('userpermission') && userpermission('lr_detail_view_bio')) : ?>
                                            <th class="percent25">Telepon Istri</th>
                                            <?php endif; ?>
                                            <th class="percent25">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($surveys)): ?>
                                            <?php $count = 1; ?>
                                            <?php foreach ($surveys as $surveysdata): ?>
                                                <tr>
                                                    <td><?= $count++ ?></td>
                                                    <td><?= esc (date('d-m-Y', strtotime($surveysdata['s_tanggal']))) ?></td>
                                                    <td><?= esc($surveysdata['s_istri']) ?></td>
                                                    <td><?= esc($surveysdata['s_pekerjaan_istri']) ?></td>
                                                    <?php if (function_exists('userpermission') && userpermission('lr_detail_view_bio')) : ?>
                                                    <td><?= esc($surveysdata['s_telepon_istri']) ?></td>
                                                    <?php endif; ?>
                                                    <td>
                                                        <?php if (function_exists('userpermission') && userpermission('lr_drivers_view_survey')) : ?>
                                                         <form action="<?= base_url('surveys/survey_view') ?>" method="POST" target="_blank" style="display: inline;">
                                                            <?= csrf_field() ?>
                                                            <input type="hidden" name="survey_id" value="<?= $surveysdata['s_id'] ?>">
                                                            <button type="submit" class="btn btn-link text-success p-0 border-0"><i class="fa fa-eye" title="Detail"></i></button>
                                                         </form>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="8">No Survey records found for this driver.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                                </div>
                            </div>

                            <div class="tab-pane" id="trainings">
                                <div class="table-responsive">
                                <table id="vgeofencetbl" class="table table-striped projects">
                                    <thead>
                                        <tr>
                                            <th class="percent1">No</th>
                                            <th class="percent25">Tanggal Training</th>
                                            <th class="percent25">Kategori</th>
                                            <th class="percent25">Tema</th>
                                            <th class="percent25">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($trainings)): ?>
                                            <?php $count = 1; ?>
                                            <?php foreach ($trainings as $trainingsdata): ?>
                                                <tr>
                                                    <td><?= $count++ ?></td>
                                                    <td><?= esc (date('d-m-Y', strtotime($trainingsdata['tr_tanggal']))) ?></td>
                                                    <td><?= esc($trainingsdata['tr_kategori']) ?></td>
                                                    <td><?= esc($trainingsdata['tr_tema']) . ' - ' . esc($trainingsdata['tr_pemateri']) ?></td>
                                                    <td><?= esc($trainingsdata['tr_keterangan']) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="8">No Training records found for this driver.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                                </div>
                            </div>

                            <div class="tab-pane" id="driverdetailsdocument">
                                <div class="table-responsive">
                                <table class="table table-striped projects">
                                    <thead>
                                        <tr>
                                            <th class="percent25">Jenis Dokumen Belum Lengkap</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($driver_document['d_docremarks'])): ?>
                                            <tr>
                                                <td><?= esc($driver_document['d_docremarks']) ?></td>
                                            </tr>
                                        <?php else: ?>
                                            <tr>
                                                <td>No Document records found for this driver.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                                <?php if (function_exists('userpermission') && userpermission('lr_detail_view_bio')) : ?>
                                <td>Lampiran Dokumen Berkas Persyaratan</td>
                                <div class="text-center">
                                    <?php if (!empty($driverdetails['d_pdf_document'])): ?>
                                        <?php
                                        $filePath = base_url('assets/uploads/drivers/document_pdf/' . $driverdetails['d_pdf_document']);
                                        $fileExtension = pathinfo($driverdetails['d_pdf_document'], PATHINFO_EXTENSION);
                                        ?>
                                        <?php if (strtolower($fileExtension) === 'pdf'): ?>
                                            <embed src="<?= $filePath ?>" 
                                                   type="application/pdf" 
                                                   class="img-fluid" 
                                                   style="width: 100%; height: 500px;">
                                            <p class="mt-2">
                                                <a href="<?= $filePath ?>" target="_blank" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-file-pdf"></i> View Full PDF</a>
                                            </p>
                                        <?php else: ?>
                                            <img src="<?= $filePath ?>" 
                                                 alt="Lampiran Dokumen" 
                                                 class="img-fluid img-thumbnail zoomable" 
                                                 style="max-width: 100%; height: auto; cursor: pointer;">
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <p class="text-muted">No Document Attachments</p>
                                    <?php endif; ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="tab-pane" id="loans">
                                <div class="table-responsive">
                                <table id="bookingstbl" class="table table-striped projects">
                                    <thead>
                                        <tr>
                                            <th class="percent1">No</th>
                                            <th class="percent1">Tanggal</th>
                                            <th class="percent25">Jenis Hutang</th>
                                            <th class="percent25">Nominal</th>
                                            <th class="percent25">Cara Potong</th>
                                            <th class="percent25">Status</th>
                                            <th class="percent25">Tanggal Lunas</th>
                                            <th class="percent25">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                         <?php if (!empty($combined_records)): ?>
                                            <?php $count = 1; ?>
                                            <?php foreach ($combined_records as $record): ?>
                                                <tr>
                                                    <td><?= $count++ ?></td>
                                                    <td><?= esc (date('d-m-Y', strtotime($record['tanggal']))) ?></td>
                                                    <td><?= esc($record['jenis']) ?></td>
                                                    <td><?= esc($record['nominal']) ?></td>
                                                    <td><?= esc($record['potong']) ?></td>
                                                    <td><span class="badge <?= ($record['status'] == 'PAID') ? 'bg-success' : 'bg-danger' ?>">
                                                        <?= esc($record['status']) ?>
                                                    </span></td>
                                                    <td><?= esc ($record['paid']) ?></td>
                                                    <td>
                                                    <?php if (function_exists('userpermission') && userpermission('lr_drivers_view_loan')) : ?>
                                                        <?php if ($record['type'] === 'loan'): ?>
                                                        <form action="<?= base_url('loans/viewloan') ?>" method="POST" target="_blank" style="display: inline;">
                                                            <?= csrf_field() ?>
                                                            <input type="hidden" name="loan_id" value="<?= esc($record['action_id']) ?>">
                                                            <button type="submit" class="btn btn-link text-primary p-0 border-0">
                                                                <i class="fa fa-eye text-success" title="Detail"></i>
                                                            </button>
                                                        </form>
                                                    <?php elseif ($record['type'] === 'bap'): ?>
                                                        <form action="<?= base_url('baps/bap_view') ?>" method="POST" target="_blank" style="display: inline;">
                                                            <?= csrf_field() ?>
                                                            <input type="hidden" name="bap_id" value="<?= esc($record['action_id']) ?>">
                                                            <button type="submit" class="btn btn-link text-primary p-0 border-0">
                                                                <i class="fa fa-eye text-success" title="Detail"></i>
                                                            </button>
                                                        </form>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                                </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <?php else: ?>
                                            <tr>
                                                <td colspan="8">No Loan records found for this driver.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                            
                            <div class="tab-pane active" id="basicinfo">
                                <div class="row">
                                    <?php if (function_exists('userpermission') && userpermission('lr_detail_view_bio')) : ?>
                                    <div class="col-md-6">
                                        <table class="table table-sm table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th>NIS</th>
                                                    <td><?= esc($driverdetails['d_nis']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Nama Lengkap</th>
                                                    <td><?= esc($driverdetails['d_name']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Nama Panggilan</th>
                                                    <td><?= esc($driverdetails['d_nickname']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Tempat Lahir</th>
                                                    <td><?= esc($driverdetails['d_pob']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Tanggal Lahir</th>
                                                    <td><?= esc (date('d-m-Y', strtotime($driverdetails['d_dob']))) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Umur</th>
                                                    <td>
                                                        <?php
                                                        if (!empty($driverdetails['d_dob'])) {
                                                            $tanggal_lahir = new DateTime($driverdetails['d_dob']);
                                                            $tanggal_sekarang = new DateTime();
                                                            $selisih = $tanggal_lahir->diff($tanggal_sekarang);
                                                            
                                                            $umur = '';
                                                            if ($selisih->y > 0) {
                                                                $umur .= $selisih->y . ' Tahun ';
                                                            }
                                                            echo $umur ?: 'Tidak Diketahui';
                                                        } else {
                                                            echo 'Tanggal Lahir Tidak Tersedia';
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Status Sipil</th>
                                                    <td><?= esc($driverdetails['d_married']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Pendidikan</th>
                                                    <td><?= esc($driverdetails['d_education']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Nomor Handphone</th>
                                                    <td><?= esc($driverdetails['d_mobile']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Alamat Tempat Tinggal</th>
                                                    <td><?= esc($driverdetails['d_address']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Provinsi</th>
                                                    <td><?= esc(capitalEachWord(isset($driverdetails['d_province_name']) ? esc($driverdetails['d_province_name']) : 'N/A')) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Kabupaten/Kota</th>
                                                    <td><?= esc(capitalEachWord(isset($driverdetails['d_city_name']) ? esc($driverdetails['d_city_name']) : 'N/A')) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Kecamatan</th>
                                                    <td><?= esc(capitalEachWord(isset($driverdetails['d_district_name']) ? esc($driverdetails['d_district_name']) : 'N/A')) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Kelurahan</th>
                                                    <td><?= esc(capitalEachWord(isset($driverdetails['d_village_name']) ? esc($driverdetails['d_village_name']) : 'N/A')) ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <table class="table table-sm table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th>NIK</th>
                                                    <td><?= esc($driverdetails['d_identityno']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Masa Berlaku KTP</th>
                                                    <td><?= esc($driverdetails['d_identity_expdate']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>SIM</th>
                                                    <td><?= esc($driverdetails['d_licenseno']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Masa Berlaku SIM</th>
                                                    <td><?= esc (date('d-m-Y', strtotime($driverdetails['d_license_expdate']))) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>BPJS</th>
                                                    <td><?= esc($driverdetails['d_cardbpjs']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Nomor Rekening</th>
                                                    <td><?= esc($driverdetails['d_accountno']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Bank</th>
                                                    <td><?= esc($driverdetails['d_bank']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Pemilik Rekening</th>
                                                    <td><?= esc($driverdetails['d_accountname']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Pengalaman Kerja</th>
                                                    <td>
                                                        <?php 
                                                        $experiences = [
                                                            $driverdetails['d_experience'], 
                                                            $driverdetails['d_total_exp'], 
                                                            $driverdetails['d_infoexp'],
                                                            '<span style="color:red;">'.$driverdetails['d_expstatus'].'</span>'
                                                        ];
                                                        echo implode(', ', array_filter($experiences));
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Referensi</th>
                                                    <td><?= esc($driverdetails['d_ref']) ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php endif; ?>

                                    <div class="col-md-12">
                                        <table class="table table-sm table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th>Tanggal Masuk</th>
                                                    <td><?= esc (date('d-m-Y', strtotime($driverdetails['d_doj']))) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Masa Kerja</th>
                                                    <td>
                                                        <?php
                                                        if (!empty($driverdetails['d_doj'])) {
                                                            $tanggal_masuk = new DateTime($driverdetails['d_doj']);
                                                            $tanggal_sekarang = new DateTime();
                                                            $selisih = $tanggal_masuk->diff($tanggal_sekarang);
                                                            
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
                                                            
                                                            echo $masa_kerja ?: 'Baru Masuk';
                                                        } else {
                                                            echo 'Tanggal Masuk Tidak Tersedia';
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Keterangan</th>
                                                    <td><?= esc($driverdetails['d_notes']) ?></td>
                                                </tr>
                                                <?php if (userpermission('lr_view_userby')): ?>
                                                <tr>
                                                    <td>Petugas</td>
                                                    <td><?= isset($driverdetails['creator_name']) ? $driverdetails['creator_name'] : $driverdetails['d_created_by'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Tanggal Penginputan</td>
                                                    <td><?= esc(dateTimeFormat($driverdetails['d_created_date'])) ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Riwayat Terakhir Perubahan</td>
                                                    <td><?= esc(dateTimeFormat($driverdetails['d_modified_date'])) ?></td>
                                                </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php if (function_exists('userpermission') && userpermission('lr_drivers_list_edit')) : ?>
                                    <form action="<?= base_url('drivers/editdriver') ?>" method="POST" style="display: inline;">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="driver_id" value="<?= $driverdetails['d_id'] ?>">
                                        <button type="submit" class="btn btn-block btn-primary btn-sm">EDIT DATA DRIVER</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
</section>
<?= view('layout/footer') ?>

<script src="<?= base_url('assets/autoLogout.js') ?>"></script>
<script>
    const baseUrl = "<?= base_url() ?>"; 
    enableAutoLogout(7200, baseUrl + "login");
</script>