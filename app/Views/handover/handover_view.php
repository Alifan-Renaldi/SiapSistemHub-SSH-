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
.highlight-row {
    background-color: #e8f4fd !important;
    font-weight: 600 !important;
    border-left: 4px solid #007bff !important;
}

.highlight-driver-old {
    background-color: #fff3cd !important;
    font-weight: 600 !important;
    color: #856404 !important;
    border-left: 4px solid #ffc107 !important;
}

.highlight-driver-new {
    background-color: #d4edda !important;
    font-weight: 600 !important;
    color: #155724 !important;
    border-left: 4px solid #28a745 !important;
}

.highlight-police-no {
    background-color: #f8d7da !important;
    font-weight: 600 !important;
    color: #721c24 !important;
    border-left: 4px solid #dc3545 !important;
}
</style>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Handover Details</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('handover/handover_management') ?>">Handover</a></li>
                    <li class="breadcrumb-item active">Handover Details</li>
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
                            <h5 class="text-center">Lampiran</h5>
                            <div class="text-center">
                                <?php if (!empty($handoverdetails['foto'])): ?>
                                    <?php
                                        $documentName = $handoverdetails['foto'];
                                        $filePath = 'assets/uploads/vehicle_handover/' . $documentName;
                                        $fullPath = FCPATH . $filePath;

                                        if (!empty($documentName) && file_exists($fullPath)) {
                                            // Gunakan filemtime untuk cache busting yang lebih efisien
                                            $cacheBuster = '?' . filemtime($fullPath);
                                            $imageUrl = base_url($filePath) . $cacheBuster;
                                        } else {
                                            $imageUrl = base_url('assets/uploads/user.png');
                                        }
                                    ?>
                                    <img src="<?= $imageUrl ?>" 
                                         alt="Lampiran Dokumen" 
                                         class="img-fluid img-thumbnail zoomable" 
                                         style="max-width: 100%; height: auto; cursor: pointer; border: 1px solid #eee;">
                                         
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
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <hr>
                                    <h3 class="text-center">Data Serah Terima</h3>
                                    <hr>
                                    <table class="table table-sm table-bordered">
                                        <tbody>
                                            <tr>
                                                <th>Nomor Serah Terima</th>
                                                <td><?= esc($handoverdetails['ho_code']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Tanggal Serah Terima</th>
                                                <td><?= esc($handoverdetails['ho_lokasi']) ?>, <?= date('d-m-Y', strtotime($handoverdetails['ho_tanggal'])) ?></td>
                                            </tr>
                                            <tr class="highlight-driver-old">
                                                <th>Supir Lama/Sebelumnya</th>
                                                <td><?= esc($handoverdetails['ho_supirlama']) ?></td>
                                            </tr>
                                            <tr class="highlight-driver-new">
                                                <th>Supir Baru/Pengganti</th>
                                                <td><?= esc($handoverdetails['ho_supirbaru']) ?></td>
                                            </tr>
                                            <tr class="highlight-police-no">
                                                <th>Nomor Polisi</th>
                                                <td><?= esc($handoverdetails['ho_nopol']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Jenis Mobil</th>
                                                <td><?= esc($handoverdetails['ho_jenis']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Kilometer Saat Serah Terima</th>
                                                <td><?= esc($handoverdetails['ho_km']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Jumlah Solar Saat Serah Terima</th>
                                                <td><?= esc($handoverdetails['ho_solar']) ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="row">
                                <div class="col-md-12">
                                <hr>
                                <h3 class="text-center">Kondisi Mobil</h3>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-sm table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th>Kabin Mobil</th>
                                                    <td><?= esc($handoverdetails['ho_kabin']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Kabel Body</th>
                                                    <td><?= esc($handoverdetails['ho_kabel']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Wiper</th>
                                                    <td><?= esc($handoverdetails['ho_wiper']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Spion Bulat R/L</th>
                                                    <td><?= esc($handoverdetails['ho_spion']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Kondisi Bak</th>
                                                    <td><?= esc($handoverdetails['ho_bak']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Pintu Kupu-Kupu</th>
                                                    <td><?= esc($handoverdetails['ho_pintu']) ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                            
                                    <div class="col-md-6">
                                        <table class="table table-sm table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th>Lampu Besar Depan</th>
                                                    <td><?= esc($handoverdetails['ho_lampubesar']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Lampu Rem R/L</th>
                                                    <td><?= esc($handoverdetails['ho_lampurem']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Lampu Sein Depan R/L</th>
                                                    <td><?= esc($handoverdetails['ho_seindpn']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Lampu Sein Belakang R/L</th>
                                                    <td><?= esc($handoverdetails['ho_seinblk']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Tangki Solar 1</th>
                                                    <td><?= esc($handoverdetails['ho_tangki1']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Tangki Solar 2</th>
                                                    <td><?= esc($handoverdetails['ho_tangki2']) ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <hr>
                                <h3 class="text-center">Kondisi Ban</h3>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-sm table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th>Ban Depan Kanan</th>
                                                    <td><?= esc($handoverdetails['ho_bandpnkn']) ?> - <?= $handoverdetails['ho_merkbankn'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Ban Depan Kiri</th>
                                                    <td><?= esc($handoverdetails['ho_bandpnkr']) ?> - <?= $handoverdetails['ho_merkbankr'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Ban Belakang Kanan Luar</th>
                                                    <td><?= esc($handoverdetails['ho_banblkknlr']) ?> - <?= $handoverdetails['ho_merkbanknlr'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Ban Belakang Kiri Luar</th>
                                                    <td><?= esc($handoverdetails['ho_banblkkrlr']) ?> - <?= $handoverdetails['ho_merkbankrlr'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Ban Belakang Kanan Dalam</th>
                                                    <td><?= esc($handoverdetails['ho_banblkkndlm']) ?> - <?= $handoverdetails['ho_merkbankndlm'] ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col-md-6">
                                        <table class="table table-sm table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th>Ban Belakang Kiri Dalam</th>
                                                    <td><?= esc($handoverdetails['ho_banblkkrdlm']) ?> - <?= $handoverdetails['ho_merkbankrdlm'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Ban Tarik Kanan Luar</th>
                                                    <td><?= esc($handoverdetails['ho_bantrkknlr']) ?> - <?= $handoverdetails['ho_merkbantrkknlr'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Ban Tarik Kiri Luar</th>
                                                    <td><?= esc($handoverdetails['ho_bantrkkrlr']) ?> - <?= $handoverdetails['ho_merkbantrkkrlr'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Ban Tarik Kanan Dalam</th>
                                                    <td><?= esc($handoverdetails['ho_bantrkkndlm']) ?> - <?= $handoverdetails['ho_merkbantrkkndlm'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Ban Tarik Kiri Dalam</th>
                                                    <td><?= esc($handoverdetails['ho_bantrkkrdlm']) ?> - <?= $handoverdetails['ho_merkbantrkkrdlm'] ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <hr>
                                        <h3 class="text-center">Kondisi Velg</h3>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <table class="table table-sm table-bordered">
                                                    <tbody>
                                                        <tr>
                                                            <th>Velg Depan Kanan</th>
                                                            <td><?= esc($handoverdetails['ho_velgdpnkn']) ?> - <?= $handoverdetails['ho_merkukuranvelgdpnkn'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Velg Depan Kiri</th>
                                                            <td><?= esc($handoverdetails['ho_velgdpnkr']) ?> - <?= $handoverdetails['ho_merkukuranvelgdpnkr'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Velg Belakang Kanan Luar</th>
                                                            <td><?= esc($handoverdetails['ho_velgblkknlr']) ?> - <?= $handoverdetails['ho_merkukuranvelgblknlr'] ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="col-md-6">
                                                <table class="table table-sm table-bordered">
                                                    <tbody>
                                                        <tr>
                                                            <th>Velg Belakang Kiri Luar</th>
                                                            <td><?= esc($handoverdetails['ho_velgblkkrlr']) ?> - <?= $handoverdetails['ho_merkukuranvelgblkkrlr'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Velg Belakang Kanan Dalam</th>
                                                            <td><?= esc($handoverdetails['ho_velgblkkndlm']) ?> - <?= $handoverdetails['ho_merkukuranvelgblkndlm'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Velg Belakang Kiri Dalam</th>
                                                            <td><?= esc($handoverdetails['ho_velgblkkrdlm']) ?> - <?= $handoverdetails['ho_merkukuranvelgblkkrdlm'] ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="col-md-12">
                                                <table class="table table-sm table-bordered">
                                                    <tbody>
                                                        <tr>
                                                            <th>Status Serah Terima</th>
                                                            <td><?= esc($handoverdetails['is_verified'] == 1) ? '<span class="badge badge-success">Serah Terima Complete</span>' : '<span class="badge badge-danger">Serah Terima Not Complete</span>' ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Keterangan</th>
                                                            <td><?= esc($handoverdetails['ho_keterangan']) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Petugas Serah Terima</th>
                                                            <td><?= esc($handoverdetails['nama_petugas']) ?></td>
                                                        </tr>
                                                        <?php if (userpermission('lr_view_userby')) { ?>
                                                        <tr>
                                                            <td>Petugas</td>
                                                            <td><?= esc(isset($handoverdetails['creator_name']) ? $handoverdetails['creator_name'] : $handoverdetails['ho_created_by']) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tanggal Penginputan</td>
                                                            <td><?= esc(dateTimeFormat($handoverdetails['ho_created_date'])) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Riwayat Terakhir Perubahan</td>
                                                            <td><?= esc(dateTimeFormat($handoverdetails['ho_modified_date'])) ?></td>
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
            </div>
        </div>
            <div class="col-md-12 text-left mb-3">
                <a href="<?= base_url('handover/handover_management') ?>" class="">
                    <i class="fa fa-arrow-left"></i> Back To Handover List
                </a>
            </div>
            <br>
    </section>

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