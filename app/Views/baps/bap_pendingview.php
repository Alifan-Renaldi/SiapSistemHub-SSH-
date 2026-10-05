<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<style>
.zoom-modal {
    display: none;
    position: fixed;
    z-index: 9999;
    padding-top: 60px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.9);
}

.zoom-modal-content {
    margin: auto;
    display: block;
    max-width: 90%;
    max-height: 90%;
}

.zoom-modal .close {
    position: absolute;
    top: 20px;
    right: 35px;
    color: white;
    font-size: 40px;
    font-weight: bold;
    cursor: pointer;
}

.zoom-modal .close:hover,
.zoom-modal .close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
}

.zoomable {
    transition: transform 0.2s;
}

.zoomable:hover {
    transform: scale(1.05);
}

.zoom-controls {
    text-align: center;
    margin-top: 20px;
}
.zoom-controls button {
    margin: 0 5px;
}
.lakalantas-section {
    background-color: #fff3cd;
    border: 1px solid #ffeaa7;
    border-radius: 4px;
    padding: 10px;
    margin-bottom: 15px;
}
.lakalantas-section h4 {
    color: #856404;
    background-color: #fff3cd;
    padding: 5px;
    margin: -10px -10px 8px -10px;
    border-bottom: 1px solid #ffeaa7;
}
.lakalantas-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}
.lakalantas-table th, .lakalantas-table td {
    padding: 8px;
    border: 1px solid #ffeaa7;
    vertical-align: top;
}
.lakalantas-table th {
    background-color: #fff3cd;
    font-weight: bold;
    width: 25%;
}
.lakalantas-table td {
    background-color: #fffdf6;
}
</style>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">BAP Details</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('baps/bap_management'); ?>">BAP</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('baps/bap_pending'); ?>">Pending</a></li>
                    <li class="breadcrumb-item active">BAP Pending Details</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="card card-success card-outline">
                    <div class="card-body">
                        <div class="col-md-12">
                            <h3 class="text-center">Dokumen Bukti Kasus</h3>
                            <hr>
                            <h5>Lampiran 1</h5>
                            <div class="text-center">
                                <?php if (!empty($bapdetails['b_document'])): ?>
                                    <?php
                                    $documentName = $bapdetails['b_document'];
                                    $fileExtension = strtolower(pathinfo($documentName, PATHINFO_EXTENSION));
                                    $filePath = base_url('assets/uploads/bap/' . esc($documentName));
                                    ?>

                                    <?php if ($fileExtension === 'pdf'): ?>
                                        <embed src="<?= $filePath ?>" 
                                               type="application/pdf" 
                                               class="img-fluid" 
                                               style="width: 100%; height: 400px; border: 1px solid #ddd;"
                                               alt="Lampiran 1 PDF">
                                        <p class="mt-2">
                                            <a href="<?= $filePath ?>" target="_blank" class="btn btn-primary btn-sm">
                                                <i class="fas fa-file-pdf"></i> View Full PDF
                                            </a>
                                        </p>
                                    <?php else: ?>
                                        <img src="<?= $filePath ?>" 
                                             alt="Lampiran Dokumen" 
                                             class="img-fluid img-thumbnail zoomable" 
                                             style="max-width: 100%; height: auto; cursor: pointer; border: 1px solid #eee;">
                                    <?php endif; ?>

                                <?php else: ?>
                                    <p class="text-muted">Tidak ada dokumen yang diunggah.</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div id="zoomModal" class="zoom-modal">
                            <span class="close" onclick="closeZoom()">&times;</span>
                            <div id="zoomContainer" style="overflow: auto; position: relative;">
                                <img class="zoom-modal-content" id="zoomedImage">
                            </div>
                            <div class="zoom-controls">
                                <button onclick="zoomIn()" class="btn btn-primary btn-sm">Zoom In</button>
                                <button onclick="zoomOut()" class="btn btn-secondary btn-sm">Zoom Out</button>
                                <button onclick="resetZoom()" class="btn btn-info btn-sm">Reset</button>
                            </div>
                        </div>

                        <br>
                        <h5>Lampiran 2</h5>
                        <div class="text-center">
                            <?php if (!empty($bapdetails['b_pdf'])): ?>
                                <?php
                                $filePath = base_url('assets/uploads/bap/pdf/' . $bapdetails['b_pdf']);
                                $fileExtension = pathinfo($bapdetails['b_pdf'], PATHINFO_EXTENSION);
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
                                <p class="text-muted">Tidak Ada Dokumen Lampiran 2</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 text-left mb-3">
                    <a href="<?= base_url('baps/bap_pending') ?>" class="">
                        <i class="fa fa-arrow-left"></i> Back To BAP Waiting List
                    </a>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <hr>
                                    <h3 class="text-center">Data Muatan</h3>
                                    <hr>
                                    <table class="table table-sm table-bordered">
                                        <tbody>
                                            <tr>
                                                <th>NIS</th>
                                                <td><?= esc($bapdetails['b_nis']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Nama Supir</th>
                                                <td><?= esc($bapdetails['b_supir']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Mobil</th>
                                                <td><?= esc($bapdetails['b_nopol']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Jenis Muatan</th>
                                                <td><?= esc($bapdetails['b_muatan']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Keberangkatan</th>
                                                <td><?= esc($bapdetails['b_keberangkatan']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Lokasi Muat</th>
                                                <td><?= esc($bapdetails['b_lokasi_muat']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Lokasi Bongkar</th>
                                                <td><?= esc($bapdetails['b_lokasi_bongkar']) ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="col-md-12">
                                    <hr>
                                    <h3 class="text-center">Berita Acara Pemeriksaan</h3>
                                    <hr>
                                    <table class="table table-sm table-bordered">
                                        <tbody>
                                            <tr>
                                                <th>Nomor BAP</th>
                                                <td><?= esc($bapdetails['b_code']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Tanggal BAP</th>
                                                <td>
                                                    <?php 
                                                        $bap_date = $bapdetails['b_tanggal'];
                                                        if (empty($bap_date) || $bap_date == '0000-00-00' || $bap_date == '0000-00-00 00:00:00') {
                                                            echo '00-00-0000';
                                                        } else {
                                                            echo esc(date('d-m-Y', strtotime($bap_date)));
                                                        }
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Tanggal Kejadian</th>
                                                <td><?= esc(date('d-m-Y', strtotime($bapdetails['b_tanggal_kejadian']))) ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Lokasi Kejadian</th>
                                                <td><?= esc($bapdetails['b_lokasi_kejadian']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Jenis Kasus</th>
                                                <td><?= esc($bapdetails['b_jenis_kasus']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Kondisi Barang</th>
                                                <td><?= esc($bapdetails['b_kondisi_barang']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Posisi Barang</th>
                                                <td><?= esc($bapdetails['b_posisi_barang']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Kronologi Kejadian</th>
                                                <td><?= esc($bapdetails['b_kronologi_kejadian']) ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <?php if (isset($bapdetails['b_jenis_kasus']) && $bapdetails['b_jenis_kasus'] == 'Lakalantas' && (!empty($bapdetails['b_daftar_kerusakan']) || !empty($bapdetails['b_lokasi_perbaikan']) || !empty($bapdetails['b_biaya_perbaikan']) || !empty($bapdetails['b_biaya_lain']))): ?>
                                <div class="col-md-12">
                                    <hr>
                                    <div class="lakalantas-section">
                                        <h4>📋 Detail Lakalantas</h4>
                                        <table class="lakalantas-table">
                                            <tr>
                                                <th>Daftar Kerusakan</th>
                                                <td><?= !empty($bapdetails['b_daftar_kerusakan']) ? esc($bapdetails['b_daftar_kerusakan']) : '-' ?></td>
                                            </tr>
                                            <tr>
                                                <th>Lokasi Perbaikan</th>
                                                <td><?= !empty($bapdetails['b_lokasi_perbaikan']) ? esc($bapdetails['b_lokasi_perbaikan']) : '-' ?></td>
                                            </tr>
                                            <tr>
                                                <th>Biaya Perbaikan</th>
                                                <td>
                                                    <?php 
                                                    if (!empty($bapdetails['b_biaya_perbaikan'])) {
                                                        $biaya_perbaikan = preg_replace('/[^0-9]/', '', $bapdetails['b_biaya_perbaikan']);
                                                        if (is_numeric($biaya_perbaikan) && $biaya_perbaikan > 0) {
                                                            echo 'Rp ' . number_format((float)$biaya_perbaikan, 0, ',', '.');
                                                        } else {
                                                            echo esc($bapdetails['b_biaya_perbaikan']);
                                                        }
                                                    } else {
                                                        echo '-';
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Biaya Lain-Lain</th>
                                                <td>
                                                    <?php 
                                                    if (!empty($bapdetails['b_biaya_lain'])) {
                                                        $biaya_lain = preg_replace('/[^0-9]/', '', $bapdetails['b_biaya_lain']);
                                                        if (is_numeric($biaya_lain) && $biaya_lain > 0) {
                                                            echo 'Rp ' . number_format((float)$biaya_lain, 0, ',', '.');
                                                        } else {
                                                            echo esc($bapdetails['b_biaya_lain']);
                                                        }
                                                    } else {
                                                        echo '-';
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <div class="col-md-12">
                                    <hr>
                                    <h3 class="text-center">Penyelesaian Kasus</h3>
                                    <hr>
                                    <table class="table table-sm table-bordered">
                                        <tbody>
                                            <tr>
                                                <th>Korelasi Kasus</th>
                                                <td><?= esc($bapdetails['b_korelasi_kasus']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Estimasi Klaim</th>
                                                <td><?= esc($bapdetails['b_estimasi_klaim']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Realisasi Klaim</th>
                                                <td><?= esc($bapdetails['b_realisasi_klaim']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Potong Tagihan</th>
                                                <td><?= esc($bapdetails['b_potong_tagihan']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Cash</th>
                                                <td><?= esc($bapdetails['b_cash']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Transfer</th>
                                                <td><?= esc($bapdetails['b_transfer']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Klasifikasi Kasus</th>
                                                <td><?= esc($bapdetails['b_klasifikasi']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Keterangan</th>
                                                <td><?= esc($bapdetails['b_keterangan']) ?></td>
                                            </tr>
                                            <?php if (userpermission('lr_view_userby')) { ?>
                                            <tr>
                                                <td>Modified By Account</td>
                                                <td><?= esc(isset($bapdetails['creator_name']) ? $bapdetails['creator_name'] : $bapdetails['b_created_by']) ?></td>
                                            </tr>
                                            <tr>
                                                <td>Created Date</td>
                                                <td><?= esc($bapdetails['b_created_date']) ?></td>
                                            </tr>
                                            <tr>
                                                <td>Last Modified</td>
                                                <td><?= esc($bapdetails['b_modified_date']) ?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<br>
<?= view('layout/footer') ?>

<script src="<?= base_url('assets/autoLogout.js') ?>"></script>
<script>
    const baseUrl = "<?= base_url() ?>"; 
    enableAutoLogout(7200, baseUrl + "login");

    let scale = 1;

    function closeZoom() {
        document.getElementById("zoomModal").style.display = "none";
        resetZoom();
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
        img.style.transform = `scale(${scale})`;
    }

    document.addEventListener("DOMContentLoaded", function () {
        const zoomableImage = document.querySelector(".zoomable");
        const modal = document.getElementById("zoomModal");
        const modalImg = document.getElementById("zoomedImage");

        if (zoomableImage) {
            zoomableImage.addEventListener("click", function () {
                modal.style.display = "block";
                modalImg.src = this.src;
            });
        }
    });
</script>