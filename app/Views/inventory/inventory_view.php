<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<style>
    .inventory-detail-container {
        padding: 20px;
        max-width: 1400px;
        margin: 0 auto;
    }
    
    .page-header {
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid var(--border-color);
    }
    
    .breadcrumb {
        background-color: transparent;
        padding: 0;
        margin-bottom: 0;
    }
    
    .inventory-card {
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        margin-bottom: 25px;
        border: none;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card-header-custom {
        background: linear-gradient(to right, #f8f9fa, #e9ecef);
        border-bottom: 1px solid var(--border-color);
        padding: 15px 20px;
        font-weight: 600;
        color: var(--primary-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .card-body-custom {
        padding: 25px;
    }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }
    
    .info-item {
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #f0f0f0;
        position: relative;
    }
    
    .item-label {
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 8px;
        font-size: 0.9rem;
    }
    
    .info-value {
        font-size: 1rem;
        word-break: break-word;
        position: relative;
        padding-left: 0;
        min-height: 24px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    /* Status indicator styles */
    .status-indicator {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    .status-ada {
        background-color: #28a745; /* Hijau untuk Ada/Lengkap */
        color: white;
    }
    
    .status-tidak-ada {
        background-color: #dc3545; /* Merah untuk Tidak Ada */
        color: white;
    }
    
    .status-kurang {
        background-color: #ffc107; /* Kuning untuk Kurang/Rusak */
        color: #212529;
    }
    
    .status-icon {
        font-size: 0.75rem;
        line-height: 1;
    }
    
    .problem-data {
        color: #dc3545;
        font-weight: 600;
        padding: 2px 0;
    }
    
    .warning-data {
        color: #856404;
        font-weight: 600;
        padding: 2px 0;
    }
    
    .normal-data {
        color: #495057;
        padding: 2px 0;
    }
    
    .summary-problem {
        margin-top: 20px;
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 6px;
        border-left: 4px solid #dc3545;
    }
    
    .summary-problem h6 {
        color: #dc3545;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.95rem;
    }
    
    .summary-problem p {
        font-size: 0.9rem;
        margin-bottom: 10px;
        color: #495057;
    }
    
    .summary-problem ul {
        margin-bottom: 0;
        padding-left: 20px;
    }
    
    .summary-problem li {
        margin-bottom: 5px;
        color: #495057;
        font-size: 0.9rem;
    }
    
    .photo-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-top: 15px;
    }
    
    .photo-item {
        text-align: center;
        transition: transform 0.3s ease;
    }
    
    .photo-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: var(--primary-color);
        font-size: 0.9rem;
    }
    
    .photo-thumb {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-radius: 6px;
        cursor: pointer;
        box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        border: 1px solid var(--border-color);
    }
    
    .photo-thumb:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.15);
        transform: scale(1.07);
    }
    
    /* Modal Styles */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.92);
        z-index: 1050;
        opacity: 0;
        transition: opacity 0.3s ease;
        overflow: auto;
        -webkit-overflow-scrolling: touch;
    }

    .modal-overlay.active {
        display: block;
        opacity: 1;
    }
    
    .modal-content-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        padding: 20px;
        box-sizing: border-box;
    }
    
    .modal-image {
        max-width: 90vw; /* Batasi lebar */
        max-height: 80vh; /* Batasi tinggi */
        border-radius: 8px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        cursor: grab;
        user-select: none;
        transition: transform 0.2s ease;
    }

    .modal-image:active {
        cursor: grabbing;
    }
    
    .modal-close {
        position: absolute;
        top: 20px;
        right: 25px;
        color: white;
        font-size: 35px;
        font-weight: bold;
        cursor: pointer;
        z-index: 1060;
        transition: color 0.2s ease;
    }
    
    .modal-close {
        position: fixed;
        top: 20px;
        right: 25px;
        color: white;
        font-size: 35px;
        font-weight: bold;
        cursor: pointer;
        z-index: 1060;
        transition: color 0.2s ease;
    }

    .modal-close:hover {
        color: #bbb;
    }
        
    .modal-caption {
        margin-top: 15px;
        color: white;
        font-size: 1.1rem;
        text-align: center;
        padding: 8px 16px;
        background: rgba(0,0,0,0.5);
        border-radius: 6px;
        max-width: 90%;
    }

    .info-grid-three {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
    }
    
    @media (max-width: 768px) {
        .info-grid {
            grid-template-columns: 1fr;
        }
        
        .photo-grid {
            grid-template-columns: 1fr 1fr;
        }
        
        .card-body-custom {
            padding: 15px;
        }

        .info-grid-three {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="inventory-detail-container">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3 mb-0">Inventory Details</h1>
            </div>
            <div class="col-md-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-md-end">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('inventory/inventory_management'); ?>">Inventory</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Inventory Details</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="inventory-card card">
        <div class="card-header card-header-custom">
            <h3 class="card-title"><strong>Informasi Kendaraan</strong></h3>
        </div>
        <div class="card-body card-body-custom">
            <div class="info-grid">
                <div class="info-item">
                    <div class="item-label">Nomor Inventaris</div>
                    <div class="info-value">
                        <?= esc(isset($inventorydetails['iv_code']) && !empty($inventorydetails['iv_code']) ? $inventorydetails['iv_code'] : '-') ?>
                    </div>
                </div>

                <div class="info-item">
                    <div class="item-label">Nomor Polisi</div>
                    <div class="info-value">
                        <?= esc(isset($inventorydetails['iv_nopol']) && !empty($inventorydetails['iv_nopol']) ? $inventorydetails['iv_nopol'] : '-') ?>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="item-label">Tipe Mobil</div>
                    <div class="info-value">
                        <?= esc(isset($inventorydetails['iv_jenis']) && !empty($inventorydetails['iv_jenis']) ? $inventorydetails['iv_jenis'] : '-') ?>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="item-label">Tahun Kendaraan</div>
                    <div class="info-value">
                        <?= esc(isset($inventorydetails['iv_tahun']) && !empty($inventorydetails['iv_tahun']) ? $inventorydetails['iv_tahun'] : '-') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="inventory-card card">
        <div class="card-header card-header-custom">
            <h3 class="card-title"><strong>Kelengkapan Dokumen</strong></h3>
        </div>
        <div class="card-body card-body-custom">
            <div class="info-grid">
            <?php
                $problemItems = [];
                
                // Tanggal STNK warning dan expired
                $pajak_exp_str = $inventorydetails['v_stnk_expdate'];
                $pajak_exp_obj = new dateTime($pajak_exp_str);
                $pajak_exp = $pajak_exp_obj->format('d-m-Y');

                $date = new dateTime(date('Y-m-d'));
                $dateNow = $date->diff($pajak_exp_obj);
                $dateExp = $dateNow->format('%R%a');
                
                // data STNK
                $stnk_value = esc(isset($inventorydetails['iv_stnk']) && !empty($inventorydetails['iv_stnk']) ? $inventorydetails['iv_stnk'] : '-');
                $stnk_class = 'normal-data';
                $stnk_status = '';
                $stnk_icon = '<i class="fas fa-check status-icon"></i>';
                
                if (stripos($stnk_value, 'Tidak Ada') !== false) {
                    $stnk_class = 'problem-data';
                    $stnk_status = 'tidak-ada';
                    $stnk_icon = '<i class="fas fa-times status-icon"></i>';
                    $problemItems[] = 'STNK: ' . $stnk_value;
                } elseif (stripos($stnk_value, 'Rusak') !== false || stripos($stnk_value, 'Kurang') !== false) {
                    $stnk_class = 'warning-data';
                    $stnk_status = 'kurang';
                    $stnk_icon = '<i class="fas fa-exclamation status-icon"></i>';
                    $problemItems[] = 'STNK: ' . $stnk_value;
                } else {
                    $stnk_status = 'ada';
                }
                ?>
                <div class="info-item">
                    <div class="item-label">STNK</div>
                    <div class="info-value">
                        <span class="status-indicator status-<?= $stnk_status ?>">
                            <?= $stnk_icon ?>
                        </span>
                        <span class="<?= $stnk_class ?>"><?= $stnk_value ?></span>
                        <span>
                            <?php
                                if ($dateExp < 0) {
                                echo '<span class="badge badge-danger" style="font-size:12px; width: 100%; max-width:6rem;">
                              '. $pajak_exp .'
                              <br>
                              Expired ' . abs((int)$dateExp) . ' Hari' . 
                              '</span>';
                                }
                                else if ($dateExp < 15) {
                                echo '<span class="badge badge-warning" style="font-size:12px; width: 100%; max-width:6rem;">
                              '. $pajak_exp .'
                              <br>
                              Warning ' . abs((int)$dateExp) . ' Hari' . 
                              '</span>';
                                }else {
                                    echo '<span class="" style="font-size: 15px; width: 100%; max-width:6rem;">
                              ' . $pajak_exp . '</span>';
                                }
                            ?>
                        </span>
                    </div>
                </div>
            <?php
                // KIR
                $kir_exp_str = $inventorydetails['v_kir_expdate'];
                $kir_exp_obj = new dateTime($kir_exp_str);
                $kir_exp = $kir_exp_obj->format('d-m-Y');
                $date = new dateTime(date('Y-m-d'));
                $dateNow = $date->diff($kir_exp_obj);
                $dateExp = $dateNow->format('%R%a');

                $kir_value = esc(isset($inventorydetails['iv_kir']) && !empty($inventorydetails['iv_kir']) ? $inventorydetails['iv_kir'] : '-');
                $kir_class = 'normal-data';
                $kir_status = '';
                $kir_icon = '<i class="fas fa-check status-icon"></i>';

                if (stripos($kir_value, 'Tidak Ada') !== false) {
                    $kir_class = 'problem-data';
                    $kir_status = 'tidak-ada';
                    $kir_icon = '<i class="fas fa-times status-icon"></i>';
                    $problemItems[] = 'KIR: ' . $kir_value;
                } elseif (stripos($kir_value, 'Rusak') !== false || stripos($kir_value, 'Kurang') !== false) {
                    $kir_class = 'warning-data';
                    $kir_status = 'kurang';
                    $kir_icon = '<i class="fas fa-exclamation status-icon"></i>';
                    $problemItems[] = 'KIR: ' . $kir_value;
                } else {
                    $kir_status = 'ada';
                }
                ?>
                <div class="info-item">
                    <div class="item-label">KIR</div>
                    <div class="info-value">
                        <span class="status-indicator status-<?= $kir_status ?>">
                            <?= $kir_icon ?>
                        </span>
                        <span class="<?= $kir_class ?>"><?= $kir_value ?></span>
                        <span>
                            <?php
                                if ($dateExp < 0) {
                                echo '<span class="badge badge-danger" style="font-size:12px; width: 100%; max-width:6rem;">
                              '. $kir_exp .'
                              <br>
                              Expired ' . abs((int)$dateExp) . ' Hari' . 
                              '</span>';
                                } else if ($dateExp < 15) {
                                echo '<span class="badge badge-warning" style="font-size:12px; width: 100%; max-width:6rem;">
                              '. $kir_exp .'
                              <br>
                              Warning ' . abs((int)$dateExp) . ' Hari' . 
                              '</span>';
                                } else {
                                    echo '<span class="" style="font-size: 15px; width: 100%; max-width:6rem;">
                              '. $kir_exp . '</span>';
                                }
                            ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="inventory-card card">
        <div class="card-header card-header-custom">
            <h3 class="card-title"><strong>Data Inventaris</strong></h3>
        </div>
        <div class="card-body card-body-custom">
            <div class="info-grid-three">
                <?php
                $problemItems = [];
                $items = [
                    'iv_kabin' => 'Tempat Tidur Kabin',
                    'iv_dongkrak' => 'Dongkrak',
                    'iv_kunci' => 'Kunci Roda',
                    'iv_stang' => 'Stang/Stick Kunci Roda',
                    'iv_spanner' => 'Spanner',
                    'iv_serep' => 'Ban Serep',
                    'iv_gantungan' => 'Gantungan Ban Serep',
                    'iv_ramkk' => 'RAM (Kanan/Kiri)',
                    'iv_ramdb' => 'RAM (Depan/Belakang)',
                    'iv_karpetd' => 'Karpet Depan (R/L)',
                    'iv_karpetb' => 'Karpet Belakang (R/L)',
                    'iv_tambang' => 'Tali Tambang (3 Gulung)',
                    'iv_tarpolin' => 'Terpal Tarpolin (1 Lembar)',
                    'iv_plastik' => 'Terpal Plastik (1 Lembar)',
                    'iv_lidah' => 'Terpal Lidah (2 Lembar)',
                    'iv_badong' => 'Badong',
                    'iv_kojong' => 'Pipa Kojong',
                    'iv_jumlah' => 'Jumlah Pipa Kojong'
                ];
                
                foreach ($items as $key => $label):
                    $value = esc(isset($inventorydetails[$key]) && !empty($inventorydetails[$key]) ? $inventorydetails[$key] : '-');
                    $class = 'normal-data';
                    $status = '';
                    $icon = '<i class="fas fa-check status-icon"></i>';
                    $hasProblem = false;
                    
                    if (stripos($value, 'Tidak Ada') !== false) {
                        $class = 'problem-data';
                        $status = 'tidak-ada';
                        $icon = '<i class="fas fa-times status-icon"></i>';
                        $hasProblem = true;
                        $problemItems[] = $label . ': ' . $value;
                    } elseif (stripos($value, 'Rusak') !== false || stripos($value, 'Kurang') !== false) {
                        $class = 'warning-data';
                        $status = 'kurang';
                        $icon = '<i class="fas fa-exclamation status-icon"></i>';
                        $hasProblem = true;
                        $problemItems[] = $label . ': ' . $value;
                    } else {
                        $status = 'ada';
                    }
                ?>
                <div class="info-item">
                    <div class="item-label"><?= $label ?></div>
                    <div class="info-value">
                        <span class="status-indicator status-<?= $status ?>">
                            <?= $icon ?>
                        </span>
                        <span class="<?= $class ?>"><?= $value ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

             <div class="info-item">
                    <div class="item-label">Status Inventory</div>
                    <div class="info-value" style="font-size: 20px;">
                        <?= ($inventorydetails['iv_is_active'] == 1) ? '<span class="right badge badge-success">Sudah Pengecekan</span>' : '<span class="right badge badge-danger">Belum Pengecekan</span>' ?>
                    </div>
                </div>
             <div class="info-item">
                    <div class="item-label">Waktu Terakhir Pengecekan</div>
                    <div class="info-value" style="font-size: 18px;font-weight: bold;">
                        <?= date('d-m-Y', strtotime($inventorydetails['iv_created_date'])) ?>
                    </div>
                </div>
            
            <?php if (!empty($problemItems)): ?>
            <div class="summary-problem">
                <h6><i class="fas fa-exclamation-circle"></i> Item yang Perlu Perhatian</h6>
                <p>Berikut adalah item yang memiliki masalah atau kurang lengkap:</p>
                <ul>
                    <?php foreach ($problemItems as $item): ?>
                        <li><?= $item ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
            
            <div class="info-item mt-4">
                <div class="item-label">Catatan</div>
                <div class="info-value">
                    <?= esc(isset($inventorydetails['iv_keterangan']) && !empty($inventorydetails['iv_keterangan']) ? $inventorydetails['iv_keterangan'] : '-') ?>
                </div>
            </div>
        </div>
    </div>

    <div class="inventory-card card">
        <div class="card-header card-header-custom">
            <h3 class="card-title"><strong>Foto Kendaraan</strong></h3>
        </div>
        <div class="card-body card-body-custom">
            <div class="photo-grid">
                <div class="photo-item">
                    <span class="photo-label">Depan</span>
                    <?php
                        if (!empty($foto_dpn)) {
                            $file_path = FCPATH . 'assets/uploads/vehicle_invent/' . $foto_dpn;
                            if (file_exists($file_path)) {
                                $foto_dpn_url = base_url('assets/uploads/vehicle_invent/' . $foto_dpn) . '?' . filemtime($file_path);
                            } else {
                                $foto_dpn_url = base_url('assets/uploads/user.png');
                            }
                        } else {
                            $foto_dpn_url = base_url('assets/uploads/user.png');
                        }
                        echo '<img src="' . $foto_dpn_url . '" class="photo-thumb" alt="Tampak Depan Kendaraan" data-caption="Tampak Depan" data-image="' . $foto_dpn_url . '">';
                    ?>
                </div>

                <div class="photo-item">
                    <span class="photo-label">Belakang</span>
                    <?php
                        if (!empty($foto_blk)) {
                            $file_path = FCPATH . 'assets/uploads/vehicle_invent/' . $foto_blk;
                            if (file_exists($file_path)) {
                                $foto_blk_url = base_url('assets/uploads/vehicle_invent/' . $foto_blk) . '?' . filemtime($file_path);
                            } else {
                                $foto_blk_url = base_url('assets/uploads/user.png');
                            }
                        } else {
                            $foto_blk_url = base_url('assets/uploads/user.png');
                        }
                        echo '<img src="' . $foto_blk_url . '" class="photo-thumb" alt="Tampak Belakang Kendaraan" data-caption="Tampak Belakang" data-image="' . $foto_blk_url . '">';
                    ?> 
                </div>

                <div class="photo-item">
                    <span class="photo-label">Kanan</span>
                    <?php
                        if (!empty($foto_kanan)) {
                            $file_path = FCPATH . 'assets/uploads/vehicle_invent/' . $foto_kanan;
                            if (file_exists($file_path)) {
                                $foto_kanan_url = base_url('assets/uploads/vehicle_invent/' . $foto_kanan) . '?' . filemtime($file_path);
                            } else {
                                $foto_kanan_url = base_url('assets/uploads/user.png');
                            }
                        } else {
                            $foto_kanan_url = base_url('assets/uploads/user.png');
                        }
                        echo '<img src="' . $foto_kanan_url . '" class="photo-thumb" alt="Tampak Kanan Kendaraan" data-caption="Tampak Kanan" data-image="' . $foto_kanan_url . '">';
                    ?> 
                </div>
                
                <div class="photo-item">
                    <span class="photo-label">Kiri</span>
                    <?php
                        if (!empty($foto_kiri)) {
                            $file_path = FCPATH . 'assets/uploads/vehicle_invent/' . $foto_kiri;
                            if (file_exists($file_path)) {
                                $foto_kiri_url = base_url('assets/uploads/vehicle_invent/' . $foto_kiri) . '?' . filemtime($file_path);
                            } else {
                                $foto_kiri_url = base_url('assets/uploads/user.png');
                            }
                        } else {
                            $foto_kiri_url = base_url('assets/uploads/user.png');
                        }
                        echo '<img src="' . $foto_kiri_url . '" class="photo-thumb" alt="Tampak Kiri Kendaraan" data-caption="Tampak Kiri" data-image="' . $foto_kiri_url . '">';
                    ?> 
                </div>
            </div>
        </div>
    </div>

    <div class="back-link">
        <a href="<?= base_url('inventory/inventory_management'); ?>">
            <i class="fa fa-arrow-left"></i> Back To Inventory List
        </a>
    </div>
    <br>
</div>

<!-- Modal for image zoom -->
<div class="modal-overlay" id="imageModal">
    <span class="modal-close" id="closeModal">&times;</span>
    <div class="modal-content-container">
        <img class="modal-image" id="modalImage" src="" alt="">
        <div class="modal-caption" id="modalCaption"></div>
    </div>
</div>
<?= view('layout/footer') ?>

<script src="<?= base_url('assets/autoLogout.js') ?>"></script>
<script>
    const baseUrl = "<?= base_url() ?>"; 
    enableAutoLogout(7200, baseUrl + "login");

    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        const modalCaption = document.getElementById('modalCaption');
        const closeModal = document.getElementById('closeModal');
        const photoThumbs = document.querySelectorAll('.photo-thumb');

        if (!modal || !modalImage || !modalCaption || !closeModal) {
            console.error('Modal elements not found!');
            return;
        }

        let scale = 1;
        let isDragging = false;
        let startX, startY, translateX = 0, translateY = 0;

        function resetZoom() {
            scale = 1;
            translateX = 0;
            translateY = 0;
            applyTransform();
        }

        function applyTransform() {
            modalImage.style.transform = `scale(${scale}) translate(${translateX}px, ${translateY}px)`;
            modalImage.style.transformOrigin = 'center center';
        }

        photoThumbs.forEach(thumb => {
            thumb.addEventListener('click', function() {
                const imageUrl = this.getAttribute('data-image');
                const caption = this.getAttribute('data-caption');

                if (!imageUrl) {
                    console.warn('No image URL provided');
                    return;
                }

                modalImage.src = imageUrl;
                modalCaption.textContent = caption || '';
                modalImage.onload = function() {
                    resetZoom();
                    modal.classList.add('active');
                    document.body.style.overflow = 'hidden';
                };

                modalImage.onerror = function() {
                    modalImage.src = "<?= base_url('assets/uploads/user.png') ?>";
                    resetZoom();
                    modal.classList.add('active');
                    document.body.style.overflow = 'hidden';
                };
            });
        });

        modalImage.addEventListener('wheel', function(e) {
            e.preventDefault();
            if (!modal.classList.contains('active')) return;

            const delta = e.deltaY > 0 ? 0.9 : 1.1;
            const newScale = Math.min(Math.max(scale * delta, 0.5), 4); // Batas 0.5x - 4x

            // Zoom ke posisi kursor
            const rect = modalImage.getBoundingClientRect();
            const mouseX = e.clientX - rect.left;
            const mouseY = e.clientY - rect.top;
            const zoomX = (mouseX / rect.width) * 100;
            const zoomY = (mouseY / rect.height) * 100;

            modalImage.style.transformOrigin = `${zoomX}% ${zoomY}%`;
            scale = newScale;
            applyTransform();
        });

        modalImage.addEventListener('mousedown', function(e) {
            if (scale <= 1) return; // Hanya drag jika zoom > 1
            isDragging = true;
            startX = e.clientX - translateX;
            startY = e.clientY - translateY;
            modalImage.style.cursor = 'grabbing';
            e.preventDefault();
        });

        window.addEventListener('mousemove', function(e) {
            if (!isDragging || !modal.classList.contains('active')) return;
            translateX = e.clientX - startX;
            translateY = e.clientY - startY;
            applyTransform();
        });

        window.addEventListener('mouseup', function() {
            isDragging = false;
            modalImage.style.cursor = 'grab';
        });

        modalImage.addEventListener('dblclick', function(e) {
            if (scale > 1) {
                resetZoom();
            } else {
                const rect = modalImage.getBoundingClientRect();
                const mouseX = e.clientX - rect.left;
                const mouseY = e.clientY - rect.top;
                const zoomX = (mouseX / rect.width) * 100;
                const zoomY = (mouseY / rect.height) * 100;

                modalImage.style.transformOrigin = `${zoomX}% ${zoomY}%`;
                scale = 2;
                applyTransform();
            }
        });

        function closeModalFunc() {
            modal.classList.remove('active');
            document.body.style.overflow = '';
            resetZoom();
        }

        closeModal.addEventListener('click', closeModalFunc);
        modal.addEventListener('click', function(e) {
            if (e.target === modal) closeModalFunc();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal.classList.contains('active')) {
                closeModalFunc();
            }
        });
    });
</script>