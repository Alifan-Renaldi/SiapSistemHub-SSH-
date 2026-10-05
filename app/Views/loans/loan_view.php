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
</style>

    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Loan Details
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="<?= base_url(); ?>/loans/loan_management">Loan</a></li>
              <li class="breadcrumb-item active">Loan Details</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                <!-- Profile Image -->
                <div class="card card-success card-outline">
                    <div class="card-body">
                        <div class="col-md-12">
                            <h5>Lampiran</h5>
                            <div class="text-center">
                                <?php if (!empty($loandetails['l_lampiran'])): ?>
                                    <?php
                                    $documentName = $loandetails['l_lampiran'];
                                    $fileExtension = strtolower(pathinfo($documentName, PATHINFO_EXTENSION));
                                    $filePath = base_url('assets/uploads/loan/' . esc($documentName));
                                    ?>

                                    <?php if ($fileExtension === 'pdf'): ?>
                                        <embed src="<?= $filePath ?>" 
                                               type="application/pdf" 
                                               class="img-fluid" 
                                               style="width: 100%; height: 400px; border: 1px solid #ddd;"
                                               alt="Lampiran PDF">
                                        <p class="mt-2">
                                            <a href="<?= $filePath ?>" target="_blank" class="btn btn-primary btn-sm">
                                                <i class="fas fa-file-pdf"></i> View Full PDF
                                            </a>
                                        </p>
                                    <?php else: ?>
                                        <img src="<?= $filePath ?>" 
                                             alt="Lampiran Foto" 
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
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
                <div class="col-md-12 text-left mb-3">
                    <a href="<?= base_url('loans/loan_management'); ?>">
                        <i class="fa fa-arrow-left"></i> Back To Loan List
                    </a>
                </div>
                <br>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="row">
                                <hr>
                                <h3 class="text-center">Hutang Supir</h3>
                                <hr>
                                    <table class="table table-sm table-bordered">
                                        <tbody>
                                            <tr>
                                                <th>Nomor Hutang</th>
                                                    <td><?= esc($loandetails['l_code']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Tanggal</th>
                                                    <td><?= esc(date('d-m-Y', strtotime($loandetails['l_tanggal']))) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Nomor Induk Supir</th>
                                                    <td><?= esc($loandetails['l_nis']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Nama Supir</th>
                                                    <td><?= esc($loandetails['l_supir']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Mobil</th>
                                                    <td><?= esc($loandetails['l_nopol']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Jenis Hutang</th>
                                                    <td>
                                                        <?php 
                                                        if (isset($loandetails['l_is_status'])) {
                                                            if (in_array($loandetails['l_is_status'], [0, 1, 2, 3])) {
                                                                echo esc('PRIBADI');
                                                            } elseif (in_array($loandetails['l_is_status'], [4, 5])) {
                                                                echo esc('SPAREPART');
                                                            } else {
                                                                echo esc('-');
                                                            }
                                                        } else {
                                                            echo esc('-');
                                                        }
                                                        ?>
                                                    </td>
                                            </tr>
                                            <tr>
                                                <th>Cara Potong</th>
                                                    <td><?= esc($loandetails['l_potong']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Nominal</th>
                                                    <td><?= esc($loandetails['l_nominal']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Keterangan</th>
                                                    <td><?= esc($loandetails['l_keterangan']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Persetujuan</th>
                                                    <td><?php 
                                                           if ($loandetails['l_is_status'] == 1 || $loandetails['l_is_status'] == 0) {
                                                            $approveDate = !empty($loandetails['l_tanggal_approve']) ? date('d-m-Y', strtotime($loandetails['l_tanggal_approve'])) : '';
                                                            echo '<span class="badge badge-success">APPROVED</span>';
                                                            echo '<span style="color: black; font-size: 14px; margin-left: 5px;">' . $approveDate . '</span>';
                                                           } elseif ($loandetails['l_is_status'] == 3) {
                                                            $approveDate = !empty($loandetails['l_tanggal_approve']) ? date('d-m-Y', strtotime($loandetails['l_tanggal_approve'])) : '';
                                                                echo '<span class="badge badge-danger">REJECTED</span>';
                                                                echo '<span style="color: black; font-size: 14px; margin-left: 5px;">' . $approveDate . '</span>';
                                                            } else {
                                                                echo '<span class="badge badge-light">-</span>';
                                                            }
                                                            ?>
                                                    </td>
                                            </tr>
                                            <tr>
                                                <th>Disetujui oleh</th>
                                                    <td>
                                                        <?php
                                                            if (isset($loandetails['creator_name']) && !empty($loandetails['creator_name'])) {
                                                                    echo esc($loandetails['creator_name']);
                                                                } else {
                                                                    echo '-';
                                                                }
                                                        ?>
                                                    </td>
                                            </tr>
                                                <?php if (userpermission('lr_view_userby')) { ?>
                                            <tr>
                                                    <td>Modified By Account</td>
                                                    <td><?= esc(isset($loandetails['creator_name']) ? $loandetails['creator_name'] : $loandetails['l_created_by']) ?></td>
                                            </tr>
                                            <tr>
                                                    <td>Created Date</td>
                                                    <td><?= esc($loandetails['l_created_date']) ?></td>
                                            </tr>
                                            <tr>
                                                    <td>Last Modified</td>
                                                    <td><?= esc($loandetails['l_modified_date']) ?></td>
                                            </tr>
                                                <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>
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