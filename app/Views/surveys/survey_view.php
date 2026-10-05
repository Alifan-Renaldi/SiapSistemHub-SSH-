<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<style>
    .survey-card {
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }
    
    .survey-card .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #eee;
        padding: 15px 20px;
    }
    
    .survey-card .card-body {
        padding: 20px;
    }
    
    .survey-table {
        width: 100%;
    }
    
    .survey-table th {
        width: 35%;
        background-color: #f8f9fa;
    }
    
    .survey-table th, 
    .survey-table td {
        padding: 12px 15px;
        border: 1px solid #dee2e6;
        vertical-align: top;
    }

    .survey-table td {
        word-wrap: break-word;
        word-break: break-word;
        white-space: normal !important;
    }
    
    .photo-gallery {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }
    
    .photo-thumbnail {
        position: relative;
        transition: all 0.3s ease;
        border-radius: 5px;
        overflow: hidden;
        border: 1px solid #ddd;
    }
    
    .photo-thumbnail:hover {
        transform: scale(1.15);
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        z-index: 10;
    }
    
    .photo-thumbnail img {
        width: 170px;
        height: 150px;
        object-fit: cover;
        cursor: pointer;
    }
    
    .section-title {
        color: #2c3e50;
        border-bottom: 2px solid #eee;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .zoom-modal {
        display: none;
        position: fixed;
        z-index: 1050;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.9);
        overflow: auto;
    }
    
    .zoom-modal-content {
        display: block;
        margin: 60px auto;
        max-width: 90%;
        max-height: 80vh;
        transition: transform 0.3s ease;
    }
    
    .close {
        position: absolute;
        top: 20px;
        right: 30px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
        z-index: 1100;
    }
    
    .close:hover,
    .close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }
    
    .zoom-controls {
        position: fixed;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 10px;
    }
    
    .back-link {
        display: inline-block;
        margin-bottom: 50px;
        color: #3498db;
        font-weight: 500;
    }
    
    .back-link:hover {
        color: #2980b9;
        text-decoration: none;
    }
    
    .address-cell {
        max-width: 300px;
        word-wrap: break-word;
        white-space: normal;
    }

    .survey-header-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 5px;
        flex-wrap: wrap;
        gap: 10px;
    }
    .survey-header-flex > div {
        display: flex;
        align-items: center;
    }
    @media (max-width: 768px) {
        .survey-header-flex {
            flex-direction: column;
            text-align: center;
        }
    }
</style>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Survey Details</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('surveys/survey_management'); ?>">Survey</a></li>
                    <li class="breadcrumb-item active">Survey Details</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                
                <div class="card survey-card">
                    <div class="card-header">
                        <h3 class="card-title"><strong>Data Survei Calon Supir SSH</strong></h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="survey-header-flex">
                                    <div class="surveyor-info">
                                        <i class="fas fa-user-check" style="margin-right: 8px; color: #3498db;"></i>
                                        <span style="font-weight: 600;">Petugas Survei:</span> 
                                        <span style="margin-left: 6px;"><?= esc($surveydetails['s_petugas']) ?></span>
                                    </div>
                                    <div class="survey-date">
                                        <i class="far fa-calendar-alt" style="margin-right: 8px; color: #e74c3c;"></i>
                                        <span style="font-weight: 600;">Tanggal Survei:</span> 
                                        <span style="margin-left: 6px;"><?= esc(date('d-m-Y', strtotime($surveydetails['s_tanggal']))) ?></span>
                                   </div>
                                </div>
                                    
                                <table class="survey-table">
                                    <tbody>
                                        <tr>
                                            <th>NIS</th>
                                            <td><?= esc($surveydetails['s_nis']) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Nama Supir</th>
                                            <td><?= esc($surveydetails['s_supir']) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Masuk</th>
                                            <td><?= esc(date('d-m-Y', strtotime($surveydetails['s_tanggal_masuk']))) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Referensi</th>
                                            <td><?= esc($surveydetails['s_referensi']) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Status Pernikahan</th>
                                            <td><?= esc($surveydetails['s_nikah']) ?></td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="survey-header" style="text-align: right; border-bottom: none; padding-bottom: 5px;">
                                    <span style="font-weight: 600;">Survey Code :</span>
                                    <span style="font-weight: normal;"><?= esc($surveydetails['s_code']) ?></span>
                                </div>
                                <table class="survey-table">
                                    <tbody>
                                        <tr>
                                            <th>Alamat Lengkap</th>
                                            <td class="address-cell"><?= esc($surveydetails['s_alamat']) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Kelurahan</th>
                                            <td><?= esc(capitalEachWord(isset($surveydetails['s_village_name']) ? esc($surveydetails['s_village_name']) : 'N/A')) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Kecamatan</th>
                                            <td><?= esc(capitalEachWord(isset($surveydetails['s_district_name']) ? esc($surveydetails['s_district_name']) : 'N/A')) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Kabupaten/Kota</th>
                                            <td><?= esc(capitalEachWord(isset($surveydetails['s_city_name']) ? esc($surveydetails['s_city_name']) : 'N/A')) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Provinsi</th>
                                            <td><?= esc(capitalEachWord(isset($surveydetails['s_province_name']) ? esc($surveydetails['s_province_name']) : 'N/A')) ?></td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php if (function_exists('userpermission') && userpermission('lr_detail_view_bio')) : ?>
                <div class="card survey-card">
                    <div class="card-header">
                        <h3 class="card-title"><strong>Informasi Keluarga & Kontak</strong></h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="survey-table">
                                    <tbody>
                                        <tr>
                                            <th>Nama Istri</th>
                                            <td><?= esc($surveydetails['s_istri']) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Nomor Telepon Istri</th>
                                            <td><?= esc($surveydetails['s_telepon_istri']) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Nama Orang Tua (Ayah)</th>
                                            <td><?= esc($surveydetails['s_bapak']) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Nama Orang Tua (Ibu)</th>
                                            <td><?= esc($surveydetails['s_ibu']) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Nama Tetangga</th>
                                            <td><?= esc($surveydetails['s_tetangga']) ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="survey-table">
                                    <tbody>
                                        <tr>
                                            <th>Nama Saudara/Kerabat Tidak Tinggal Serumah</th>
                                            <td><?= esc($surveydetails['s_saudara']) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Alamat Saudara/Kerabat</th>
                                            <td class="address-cell"><?= esc($surveydetails['s_alamat_saudara']) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Nomor Telepon Keluarga <small class="text-muted">(selain istri)</small></th>
                                            <td><?= esc($surveydetails['s_telepon_keluarga']) ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                <div class="card survey-card">
                    <div class="card-header">
                        <h3 class="card-title"><strong>Hasil Survei</strong></h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="survey-table">
                                    <tbody>
                                        <tr>
                                            <th>Kondisi Rumah</th>
                                            <td><?= esc($surveydetails['s_kondisi_rumah']) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Status Rumah</th>
                                            <td><?= esc($surveydetails['s_status_rumah']) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Lama Menetap di Alamat ini</th>
                                            <td><?= esc($surveydetails['s_menetap']) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Jumlah Penghuni Rumah</th>
                                            <td><?= esc($surveydetails['s_penghuni']) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Pekerjaan Istri</th>
                                            <td><?= esc($surveydetails['s_pekerjaan_istri']) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Kendaraan Yang Dimiliki</th>
                                            <td><?= esc($surveydetails['s_kendaraan']) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Jumlah Tanggungan</th>
                                            <td><?= esc($surveydetails['s_tanggungan']) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Keterangan</th>
                                            <td><?= esc($surveydetails['s_keterangan']) ?></td>
                                        </tr>
                                        <?php if (userpermission('lr_view_userby')) { ?>
                                        <tr>
                                            <td>Petugas</td>
                                            <td><?= esc(isset($surveydetails['creator_name']) ? $surveydetails['creator_name'] : $surveydetails['s_created_by']) ?></td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal Penginputan</td>
                                            <td><?= esc(dateTimeFormat($surveydetails['s_created_date'])) ?></td>
                                        </tr>
                                        <tr>
                                            <td>Riwayat Terakhir Perubahan</td>
                                            <td><?= esc(dateTimeFormat($surveydetails['s_modified_date'])) ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card survey-card">
                    <div class="card-header">
                        <h3 class="card-title"><strong>Foto Survei</strong></h3>
                    </div>
                    <div class="card-body">
                        <div class="photo-gallery">
                            <?php if (!empty($surveydetails['s_fotorumah_1'] . $surveydetails['s_fotorumah_2'] . $surveydetails['s_fotorumah_3'])): 
                                $existingPhotos = explode(',', $surveydetails['s_fotorumah_1'] . ',' . $surveydetails['s_fotorumah_2'] . ',' . $surveydetails['s_fotorumah_3']);
                                foreach ($existingPhotos as $index => $photo): 
                                    if (!empty($photo) && file_exists(FCPATH.'assets/uploads/survey/'.$photo)): ?>
                                        <div class="photo-thumbnail">
                                            <img src="<?= base_url('assets/uploads/survey/' . $photo) ?>" 
                                                 onclick="openZoom('<?= base_url('assets/uploads/survey/' . $photo) ?>')"
                                                 alt="Survey Photo <?= $index + 3 ?>">
                                        </div>
                                    <?php endif;
                                endforeach;
                            else: ?>
                                <p class="text-muted">Tidak ada foto yang tersedia</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="back-link">
                    <a href="<?= base_url('surveys/survey_management'); ?>">
                        <i class="fa fa-arrow-left"></i> Back To Survey List
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<?= view('layout/footer') ?>

<!-- Modal for Zoom -->
<div id="zoomModal" class="zoom-modal">
    <span class="close" onclick="closeZoom()">&times;</span>
    <div class="zoom-content-wrapper">
        <img class="zoom-modal-content" id="zoomedImage">
    </div>
    <div class="zoom-controls">
        <button onclick="zoomIn()" class="btn btn-primary btn-sm">Zoom In</button>
        <button onclick="zoomOut()" class="btn btn-secondary btn-sm">Zoom Out</button>
        <button onclick="resetZoom()" class="btn btn-info btn-sm">Reset</button>
    </div>
</div>

<script src="<?= base_url('assets/autoLogout.js') ?>"></script>
<script>
    const baseUrl = "<?= base_url() ?>"; 
    enableAutoLogout(7200, baseUrl + "login");
    
    let scale = 1;
    let currentImageSrc = '';

    function openZoom(src) {
        const modal = document.getElementById("zoomModal");
        modal.style.display = "block";
        document.getElementById("zoomedImage").src = src;
        currentImageSrc = src;
        resetZoom();
        document.body.style.overflow = "hidden";
    }

    function closeZoom() {
        const modal = document.getElementById("zoomModal");
        modal.style.display = "none";
        resetZoom();
        document.body.style.overflow = "auto";
    }

    function zoomIn() {
        scale += 0.2;
        applyZoom();
    }

    function zoomOut() {
        if (scale > 0.4) {
            scale -= 0.2;
            applyZoom();
        }
    }

    function resetZoom() {
        scale = 1;
        applyZoom();
    }

    function applyZoom() {
        const img = document.getElementById("zoomedImage");
        if (img) {
            img.style.transform = `scale(${scale})`;
            img.style.transformOrigin = 'center center';
        }
    }

    document.addEventListener('click', function(event) {
        const modal = document.getElementById('zoomModal');
        const zoomControls = document.querySelector('.zoom-controls');
        
        if (modal.style.display === "block" && 
            event.target === modal &&
            !zoomControls.contains(event.target)) {
            closeZoom();
        }
    });

    document.addEventListener('keydown', function(event) {
        const modal = document.getElementById('zoomModal');
        if (event.key === "Escape" && modal.style.display === "block") {
            closeZoom();
        }
    });
</script>