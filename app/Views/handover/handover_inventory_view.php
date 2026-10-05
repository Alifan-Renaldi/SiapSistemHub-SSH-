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
    }
    
    .info-label {
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 5px;
        font-size: 0.9rem;
    }
    
    .info-value {
        color: #495057;
        font-size: 1rem;
        word-break: break-word;
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
                <h1 class="h3 mb-0">Review Inventory</h1>
            </div>
            <div class="col-md-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-md-end">
                        <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="">Handover</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Review</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="alert alert-info">
        <i class="icon fas fa-info-circle"></i> 
        <strong>Informasi:</strong> Periksa kelengkapan data inventaris sebelum melanjutkan untuk proses serah terima kendaraan.
    </div>

    <div class="inventory-card card">
        <div class="card-header card-header-custom">
            <h3 class="card-title"><strong>Informasi Kendaraan</strong></h3>
        </div>
        <div class="card-body card-body-custom">
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Nomor Inventaris</div>
                    <div class="info-value"><?= esc(isset($inventorydetails['iv_code']) && !empty($inventorydetails['iv_code']) ? esc($inventorydetails['iv_code']) : '-') ?></div>
                </div>

                <div class="info-item">
                    <div class="info-label">Nomor Polisi</div>
                    <div class="info-value"><?= esc(isset($inventorydetails['iv_nopol']) && !empty($inventorydetails['iv_nopol']) ? $inventorydetails['iv_nopol'] : '-') ?></div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Tipe Mobil</div>
                    <div class="info-value"><?= esc(isset($inventorydetails['iv_jenis']) && !empty($inventorydetails['iv_jenis']) ? $inventorydetails['iv_jenis'] : '-') ?></div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Tahun Kendaraan</div>
                    <div class="info-value"><?= esc(isset($inventorydetails['iv_tahun']) && !empty($inventorydetails['iv_tahun']) ? $inventorydetails['iv_tahun'] : '-') ?></div>
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
                <div class="info-item">
                    <div class="info-label">STNK</div>
                    <div class="info-value"><?= esc(isset($inventorydetails['iv_stnk']) && !empty($inventorydetails['iv_stnk']) ? $inventorydetails['iv_stnk'] : '-') ?></div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">KIR</div>
                    <div class="info-value"><?= esc(isset($inventorydetails['iv_kir']) && !empty($inventorydetails['iv_kir']) ? $inventorydetails['iv_kir'] : '-') ?></div>
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
                <div class="info-item">
                    <div class="info-label">Tempat Tidur Kabin</div>
                    <div class="info-value"><?= esc(isset($inventorydetails['iv_kabin']) && !empty($inventorydetails['iv_kabin']) ? $inventorydetails['iv_kabin'] : '-') ?></div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Dongkrak</div>
                    <div class="info-value"><?= esc(isset($inventorydetails['iv_dongkrak']) && !empty($inventorydetails['iv_dongkrak']) ? $inventorydetails['iv_dongkrak'] : '-') ?></div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Kunci Roda</div>
                    <div class="info-value"><?= esc(isset($inventorydetails['iv_kunci']) && !empty($inventorydetails['iv_kunci']) ? $inventorydetails['iv_kunci'] : '-') ?></div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Stang/Stick Kunci Roda</div>
                    <div class="info-value"><?= esc(isset($inventorydetails['iv_stang']) && !empty($inventorydetails['iv_stang']) ? $inventorydetails['iv_stang'] : '-') ?></div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Spanner</div>
                    <div class="info-value"><?= esc(isset($inventorydetails['iv_spanner']) && !empty($inventorydetails['iv_spanner']) ? $inventorydetails['iv_spanner'] : '-') ?></div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Ban Serep</div>
                    <div class="info-value"><?= esc(isset($inventorydetails['iv_serep']) && !empty($inventorydetails['iv_serep']) ? $inventorydetails['iv_serep'] : '-') ?></div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Gantungan Ban Serep</div>
                    <div class="info-value"><?= esc(isset($inventorydetails['iv_gantungan']) && !empty($inventorydetails['iv_gantungan']) ? $inventorydetails['iv_gantungan'] : '-') ?></div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">RAM (Kanan/Kiri)</div>
                    <div class="info-value"><?= esc(isset($inventorydetails['iv_ramkk']) && !empty($inventorydetails['iv_ramkk']) ? $inventorydetails['iv_ramkk'] : '-') ?></div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">RAM (Depan/Belakang)</div>
                    <div class="info-value"><?= esc(isset($inventorydetails['iv_ramdb']) && !empty($inventorydetails['iv_ramdb']) ? $inventorydetails['iv_ramdb'] : '-') ?></div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Karpet Depan (R/L)</div>
                    <div class="info-value"><?= esc(isset($inventorydetails['iv_karpetd']) && !empty($inventorydetails['iv_karpetd']) ? $inventorydetails['iv_karpetd'] : '-') ?></div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Karpet Belakang (R/L)</div>
                    <div class="info-value"><?= esc(isset($inventorydetails['iv_karpetb']) && !empty($inventorydetails['iv_karpetb']) ? $inventorydetails['iv_karpetb'] : '-') ?></div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Tali Tambang (3 Gulung)</div>
                    <div class="info-value"><?= esc(isset($inventorydetails['iv_tambang']) && !empty($inventorydetails['iv_tambang']) ? $inventorydetails['iv_tambang'] : '-') ?></div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Terpal Tarpolin (1 Lembar)</div>
                    <div class="info-value"><?= esc(isset($inventorydetails['iv_tarpolin']) && !empty($inventorydetails['iv_tarpolin']) ? $inventorydetails['iv_tarpolin'] : '-') ?></div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Terpal Plastik (1 Lembar)</div>
                    <div class="info-value"><?= esc(isset($inventorydetails['iv_plastik']) && !empty($inventorydetails['iv_plastik']) ? $inventorydetails['iv_plastik'] : '-') ?></div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Terpal Lidah (2 Lembar)</div>
                    <div class="info-value"><?= esc(isset($inventorydetails['iv_lidah']) && !empty($inventorydetails['iv_lidah']) ? $inventorydetails['iv_lidah'] : '-') ?></div>
                </div>

                <div class="info-item">
                    <div class="info-label">Badong</div>
                    <div class="info-value"><?= esc(isset($inventorydetails['iv_badong']) && !empty($inventorydetails['iv_badong']) ? $inventorydetails['iv_badong'] : '-') ?></div>
                </div>

                <div class="info-item">
                    <div class="info-label">Pipa Kojong</div>
                    <div class="info-value"><?= esc(isset($inventorydetails['iv_kojong']) && !empty($inventorydetails['iv_kojong']) ? $inventorydetails['iv_kojong'] : '-') ?></div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Jumlah Pipa Kojong</div>
                    <div class="info-value"><?= esc(isset($inventorydetails['iv_jumlah']) && !empty($inventorydetails['iv_jumlah']) ? $inventorydetails['iv_jumlah'] : '-') ?></div>
                </div>
            </div>
                <div class="info-item">
                    <div class="info-label">Status Inventory</div>
                    <div class="info-value"><?= ($inventorydetails['iv_is_active'] == '1') ? '<span class="right badge badge-success">Sudah Pengecekan</span>' : '<span class="right badge badge-danger">Belum Pengecekan</span>' ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Waktu Terakhir Pengecekan</div>
                    <div class="info-value"><?= date('d-m-Y', strtotime($inventorydetails['iv_created_date'])) ?></div>
                </div>
            
            <div class="info-item mt-4">
                <div class="info-label">Catatan</div>
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

    <!-- Modal for image zoom -->
    <div class="modal-overlay" id="imageModal">
        <span class="modal-close" id="closeModal">&times;</span>
        <div class="modal-content-container">
            <img class="modal-image" id="modalImage" src="" alt="">
            <div class="modal-caption" id="modalCaption"></div>
        </div>
    </div>

    <div class="mb-4 d-flex">
        <div class="col-md-6">
            <?php if ($nopol && $hand_id): ?>
            <a href="<?= base_url('handover/edithandoverinventory?nopol=' . rawurlencode($nopol) . '&hand_id=' . $hand_id) ?>" class="btn btn-warning">
                <i class="fa fa-edit"></i> Edit Inventory
            </a>
            <?php endif; ?>
        </div>
        <div class="col-md-6 text-right">
            <?php if ($nopol && $hand_id): ?>
            <a href="<?= base_url('handover/preview?nopol=' . rawurlencode($nopol) . '&hand_id=' . $hand_id) ?>" class="btn btn-primary">Next <i class="fa fa-arrow-right"></i>
            </a>
            <?php endif; ?>
        </div>
    </div>
    <br>
</div>

<script>
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

<?= view('layout/footer') ?>