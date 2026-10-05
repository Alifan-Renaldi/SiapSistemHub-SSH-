<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Data Preview</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="">Handover</a></li>
                    <li class="breadcrumb-item active">Preview</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <!-- Summary Card -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-info-circle mr-2"></i>Informasi Utama</h3>
                <?php if (isset($handoverdetails) && !empty($handoverdetails) && ($handoverdetails['ho_status'] ?? 'No Driver') == 'draft') : ?>
                <span class="badge badge-warning float-right">DRAFT</span>
    <?php elseif (isset($handoverdetails) && !empty($handoverdetails) && ($handoverdetails['ho_status'] ?? 'No Driver') == 'completed') : ?>
        <span class="badge badge-success float-right">COMPLETED</span>
    <?php endif; ?>
            </div>
            <div class="card-body">
                <?php if (isset($handoverdetails)): ?>
                <div class="row">
                    <div class="col-md-4">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">Tanggal Serah Terima</span>
                                <span class="info-box-number text-center text-primary"><?= date('d F Y', strtotime($handoverdetails['ho_tanggal'] ?? '')) ?></span>
                            </div> 
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">Nomor Polisi</span>
                                <span class="info-box-number text-center text-success"><?= $handoverdetails['ho_nopol'] ?? '-' ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">Lokasi</span>
                                <span class="info-box-number text-center text-info"><?= $handoverdetails['ho_lokasi'] ?? '-' ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="card card-success card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-exchange-alt mr-2"></i>Data Serah Terima Kendaraan</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <?php if (isset($handoverdetails)): ?>
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered table-striped table-sm">
                            <tr>
                                <td class="bg-light"><strong>Nomor Serah Terima</strong></td>
                                <td><?= $handoverdetails['ho_code'] ?? '-' ?></td>
                            </tr>
                            <tr>
                                <td width="40%" class="bg-light"><strong>Supir Lama</strong></td>
                                <td><?= $handoverdetails['ho_supirlama'] ?? '-' ?></td>
                            </tr>
                            <tr>
                                <td class="bg-light"><strong>Supir Baru</strong></td>
                                <td><?= $handoverdetails['ho_supirbaru'] ?? '-' ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-bordered table-striped table-sm">
                            <tr>
                                <td width="40%" class="bg-light"><strong>Jenis Mobil</strong></td>
                                <td><?= $handoverdetails['ho_jenis'] ?? '-' ?></td>
                            </tr>
                            <tr>
                                <td class="bg-light"><strong>Kilometer</strong></td>
                                <td><?= $handoverdetails['ho_km'] ?? '-' ?> km</td>
                            </tr>
                            <tr>
                                <td class="bg-light"><strong>Solar</strong></td>
                                <td><?= $handoverdetails['ho_solar'] ?? '-' ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="card card-warning card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-car mr-2"></i>Kondisi Kendaraan</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="#tab_eksterior" data-toggle="tab">Eksterior & Lampu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#tab_ban" data-toggle="tab">Ban & Velg</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <!-- Tab Eksterior & Lampu -->
                        <div class="tab-pane active" id="tab_eksterior">
                            <div class="row p-3">
                                <div class="col-md-4">
                                    <div class="card card-sm">
                                        <div class="card-header bg-light">
                                            <h6 class="card-title">Body & Kabin</h6>
                                        </div>
                                        <div class="card-body">
                                            <p><strong>Kabin:</strong> <span class="badge badge-<?= ($handoverdetails['ho_kabin'] ?? '') == 'Baik' ? 'success' : 'danger' ?>"><?= $handoverdetails['ho_kabin'] ?? '' ?></span></p>
                                            <p><strong>Spion:</strong> <span class="badge badge-<?= ($handoverdetails['ho_spion'] ?? '') == 'Baik/Lengkap' ? 'success' : 'danger' ?>"><?= $handoverdetails['ho_spion'] ?? '' ?></span></p>
                                            <p><strong>Wiper:</strong> <span class="badge badge-<?= ($handoverdetails['ho_wiper'] ?? '') == 'Hidup' ? 'success' : 'danger' ?>"><?= $handoverdetails['ho_wiper'] ?? '' ?></span></p>
                                            <p><strong>Bak:</strong> <span class="badge badge-<?= ($handoverdetails['ho_bak'] ?? '') == 'Baik' ? 'success' : 'danger' ?>"><?= $handoverdetails['ho_bak'] ?? '' ?></span></p>
                                            <p><strong>Pintu Kupu-kupu:</strong> <span class="badge badge-<?= ($handoverdetails['ho_pintu'] ?? '') == 'Baik' ? 'success' : 'danger' ?>"><?= $handoverdetails['ho_pintu'] ?? '' ?></span></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card card-sm">
                                        <div class="card-header bg-light">
                                            <h6 class="card-title">Sistem Kelistrikan</h6>
                                        </div>
                                        <div class="card-body">
                                            <p><strong>Kabel Body:</strong> <span class="badge badge-<?= ($handoverdetails['ho_kabel'] ?? '') == 'Baik' ? 'success' : 'danger' ?>"><?= $handoverdetails['ho_kabel'] ?? '' ?></span></p>
                                            <p><strong>Lampu Besar:</strong> <span class="badge badge-<?= ($handoverdetails['ho_lampubesar'] ?? '') == 'Hidup' ? 'success' : (($handoverdetails['ho_lampubesar'] ?? '') == 'Redup' ? 'warning' : 'danger') ?>"><?= $handoverdetails['ho_lampubesar'] ?? '' ?></span></p>
                                            <p><strong>Lampu Rem:</strong> <span class="badge badge-<?= ($handoverdetails['ho_lampurem'] ?? '') == 'Hidup' ? 'success' : (($handoverdetails['ho_lampurem'] ?? '') == 'Redup' ? 'warning' : 'danger') ?>"><?= $handoverdetails['ho_lampurem'] ?? '' ?></span></p>
                                            <p><strong>Sein Depan:</strong> <span class="badge badge-<?= ($handoverdetails['ho_seindpn'] ?? '') == 'Hidup' ? 'success' : (($handoverdetails['ho_seindpn'] ?? '') == 'Redup' ? 'warning' : 'danger') ?>"><?= $handoverdetails['ho_seindpn'] ?? '' ?></span></p>
                                            <p><strong>Sein Belakang:</strong> <span class="badge badge-<?= ($handoverdetails['ho_seinblk'] ?? '') == 'Hidup' ? 'success' : (($handoverdetails['ho_seinblk'] ?? '') == 'Redup' ? 'warning' : 'danger') ?>"><?= $handoverdetails['ho_seinblk'] ?? '' ?></span></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card card-sm">
                                        <div class="card-header bg-light">
                                            <h6 class="card-title">Tangki</h6>
                                        </div>
                                        <div class="card-body">
                                            <p><strong>Tangki Solar 1:</strong> <span class="badge badge-<?= ($handoverdetails['ho_tangki1'] ?? '') == 'Ada/Baik' ? 'success' : 'danger' ?>"><?= $handoverdetails['ho_tangki1'] ?? '' ?></span></p>
                                            <p><strong>Tangki Solar 2:</strong> <span class="badge badge-<?= ($handoverdetails['ho_tangki2'] ?? '') == 'Ada/Baik' ? 'success' : 'danger' ?>"><?= $handoverdetails['ho_tangki2'] ?? '' ?></span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab Ban & Velg -->
                        <div class="tab-pane" id="tab_ban">
                            <div class="row p-3">
                                <div class="col-md-6">
                                    <div class="card card-sm">
                                        <div class="card-header bg-light">
                                            <h6 class="card-title">Ban Depan</h6>
                                        </div>
                                        <div class="card-body">
                                            <p><strong>Kanan:</strong> <?= $handoverdetails['ho_bandpnkn'] ?? '-' ?> - <?= $handoverdetails['ho_merkbankn'] ?? '-' ?></p>
                                            <p><strong>Kiri:</strong> <?= $handoverdetails['ho_bandpnkr'] ?? '-' ?> - <?= $handoverdetails['ho_merkbankr'] ?? '-' ?></p>
                                            <p><strong>Velg Kanan:</strong> <?= $handoverdetails['ho_velgdpnkn'] ?? '-' ?> - <?= $handoverdetails['ho_merkukuranvelgdpnkn'] ?? '-' ?></p>
                                            <p><strong>Velg Kiri:</strong> <?= $handoverdetails['ho_velgdpnkr'] ?? '-' ?> - <?= $handoverdetails['ho_merkukuranvelgdpnkr'] ?? '-' ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card card-sm">
                                        <div class="card-header bg-light">
                                            <h6 class="card-title">Ban Tarik</h6>
                                        </div>
                                        <div class="card-body">
                                            <p><strong>Kanan Luar:</strong> <?= $handoverdetails['ho_bantrkknlr'] ?? '-' ?> - <?= $handoverdetails['ho_merkbantrkknlr'] ?? '-' ?></p>
                                            <p><strong>Kiri Luar:</strong> <?= $handoverdetails['ho_bantrkkrlr'] ?? '-' ?> - <?= $handoverdetails['ho_merkbantrkkrlr'] ?? '-' ?></p>
                                            <p><strong>Kanan Dalam:</strong> <?= $handoverdetails['ho_bantrkkndlm'] ?? '-' ?> - <?= $handoverdetails['ho_merkbantrkkndlm'] ?? '-' ?></p>
                                            <p><strong>Kiri Dalam:</strong> <?= $handoverdetails['ho_bantrkkrdlm'] ?? '-' ?> - <?= $handoverdetails['ho_merkbantrkkrdlm'] ?? '-' ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card card-sm">
                                        <div class="card-header bg-light">
                                            <h6 class="card-title">Ban Belakang Kanan</h6>
                                        </div>
                                        <div class="card-body">
                                            <p><strong>Kanan Luar:</strong> <?= $handoverdetails['ho_banblkknlr'] ?? '-' ?> - <?= $handoverdetails['ho_merkbanknlr'] ?? '-' ?></p>
                                            <p><strong>Kanan Dalam:</strong> <?= $handoverdetails['ho_banblkkndlm'] ?? '-' ?> - <?= $handoverdetails['ho_merkbankndlm'] ?? '-' ?></p>
                                            <p><strong>Velg Kanan Luar:</strong> <?= $handoverdetails['ho_velgblkknlr'] ?? '-' ?> - <?= $handoverdetails['ho_merkukuranvelgblknlr'] ?? '-' ?></p>
                                            <p><strong>Velg Kanan Dalam:</strong> <?= $handoverdetails['ho_velgblkkndlm'] ?? '-' ?> - <?= $handoverdetails['ho_merkukuranvelgblkndlm'] ?? '-' ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card card-sm">
                                        <div class="card-header bg-light">
                                            <h6 class="card-title">Ban Belakang Kiri</h6>
                                        </div>
                                        <div class="card-body">
                                            <p><strong>Kiri Luar:</strong> <?= $handoverdetails['ho_banblkkrlr'] ?? '-' ?> - <?= $handoverdetails['ho_merkbankrlr'] ?? '-' ?></p>
                                            <p><strong>Kiri Dalam:</strong> <?= $handoverdetails['ho_banblkkrdlm'] ?? '-' ?> - <?= $handoverdetails['ho_merkbankrdlm'] ?? '-' ?></p>
                                            <p><strong>Velg Kiri Luar:</strong> <?= $handoverdetails['ho_velgblkkrlr'] ?? '-' ?> - <?= $handoverdetails['ho_merkukuranvelgblkkrlr'] ?? '-' ?></p>
                                            <p><strong>Velg Kiri Dalam:</strong> <?= $handoverdetails['ho_velgblkkrdlm'] ?? '-' ?> - <?= $handoverdetails['ho_merkukuranvelgblkkrdlm'] ?? '-' ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Inventaris -->
        <div class="card card-info card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-clipboard-list mr-2"></i>Data Inventaris Kendaraan</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <?php if (isset($inventorydetails)): ?>
                <div class="row">
                    <!-- Informasi Dasar -->
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-header">
                                <h6 class="card-title">Informasi Dasar</h6>
                            </div>
                            <div class="card-body">
                                <p><strong>Kode Inventaris:</strong><br><?= esc($inventorydetails['iv_code'] ?? '-') ?></p>
                                <p><strong>Jenis Mobil:</strong><br><?= esc($inventorydetails['iv_jenis'] ?? '-') ?></p>
                                <p><strong>Tahun:</strong><br><?= esc($inventorydetails['iv_tahun'] ?? '-') ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Dokumen & Perlengkapan -->
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-header">
                                <h6 class="card-title">Dokumen & Interior</h6>
                            </div>
                            <div class="card-body">
                                <p><strong>STNK:</strong> <span class="badge badge-<?= ($inventorydetails['iv_stnk'] ?? '') == 'Ada' ? 'success' : 'danger' ?>"><?= $inventorydetails['iv_stnk'] ?? '-' ?></span></p>
                                <p><strong>KIR:</strong> <span class="badge badge-<?= ($inventorydetails['iv_kir'] ?? '') == 'Ada' ? 'success' : 'danger' ?>"><?= $inventorydetails['iv_kir'] ?? '-' ?></span></p>
                                <p><strong>Tempat Tidur Kabin:</strong> <span class="badge badge-<?= ($inventorydetails['iv_kabin'] ?? '') == 'Ada' ? 'success' : 'danger' ?>"><?= $inventorydetails['iv_kabin'] ?? '-' ?></span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Alat & Perkakas -->
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-header">
                                <h6 class="card-title">Kelengkapan Alat</h6>
                            </div>
                            <div class="card-body">
                                
                                <p><strong>Dongkrak:</strong> <span class="badge badge-<?= ($inventorydetails['iv_dongkrak'] ?? '') == 'Ada/Baik' ? 'success' : (($inventorydetails['iv_dongkrak'] ?? '') == 'Ada/Rusak' ? 'warning' : 'danger') ?>"><?= $inventorydetails['iv_dongkrak'] ?? '-' ?></span></p>
                                <p><strong>Ban Serep:</strong> <span class="badge badge-<?= ($inventorydetails['iv_serep'] ?? '') == 'Ada/Baik' ? 'success' : (($inventorydetails['iv_serep'] ?? '') == 'Ada/Rusak' ? 'warning' : 'danger') ?>"><?= $inventorydetails['iv_serep'] ?? '-' ?></span></p>
                                <p><strong>Kunci Roda:</strong> <span class="badge badge-<?= ($inventorydetails['iv_kunci'] ?? '') == 'Ada/Baik' ? 'success' : (($inventorydetails['iv_kunci'] ?? '') == 'Ada/Rusak' ? 'warning' : 'danger') ?>"><?= $inventorydetails['iv_kunci'] ?? '-' ?></span></p>
                                <p><strong>Stick Kunci Roda:</strong> <span class="badge badge-<?= ($inventorydetails['iv_stang'] ?? '') == 'Ada/Baik' ? 'success' : (($inventorydetails['iv_stang'] ?? '') == 'Ada/Rusak' ? 'warning' : 'danger') ?>"><?= $inventorydetails['iv_stang'] ?? '-' ?></span></p>
                                <p><strong>Spanner:</strong> <span class="badge badge-<?= ($inventorydetails['iv_spanner'] ?? '') == 'Ada/Baik' ? 'success' : (($inventorydetails['iv_spanner'] ?? '') == 'Ada/Rusak' ? 'warning' : 'danger') ?>"><?= $inventorydetails['iv_spanner'] ?? '-' ?></span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Aksesoris & Perlengkapan -->
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-header">
                                <h6 class="card-title">Eksterior</h6>
                            </div>
                            <div class="card-body">
                                <p><strong>Gantungan Ban Serep:</strong> <span class="badge badge-<?= ($inventorydetails['iv_gantungan'] ?? '') == 'Ada/Baik' ? 'success' : (($inventorydetails['iv_gantungan'] ?? '') == 'Ada/Rusak' ? 'warning' : 'danger') ?>"><?= $inventorydetails['iv_gantungan'] ?? '-' ?></span></p>
                                <p><strong>RAM Kanan/Kiri:</strong> <span class="badge badge-<?= ($inventorydetails['iv_ramkk'] ?? '') == 'Ada/Baik' ? 'success' : (($inventorydetails['iv_ramkk'] ?? '') == 'Ada/Rusak' ? 'warning' : 'danger') ?>"><?= $inventorydetails['iv_ramkk'] ?? '-' ?></span></p>
                                <p><strong>RAM Depan/Belakang:</strong> <span class="badge badge-<?= ($inventorydetails['iv_ramdb'] ?? '') == 'Ada/Baik' ? 'success' : (($inventorydetails['iv_ramdb'] ?? '') == 'Ada/Rusak' ? 'warning' : 'danger') ?>"><?= $inventorydetails['iv_ramdb'] ?? '-' ?></span></p>
                                <p><strong>Karpet Depan R/L:</strong> <span class="badge badge-<?= ($inventorydetails['iv_karpetd'] ?? '') == 'Ada/Baik' ? 'success' : (($inventorydetails['iv_karpetd'] ?? '') == 'Ada/Rusak' ? 'warning' : 'danger') ?>"><?= $inventorydetails['iv_karpetd'] ?? '-' ?></span></p>
                                <p><strong>Karpet Belakang R/L:</strong> <span class="badge badge-<?= ($inventorydetails['iv_karpetb'] ?? '') == 'Ada/Baik' ? 'success' : (($inventorydetails['iv_karpetb'] ?? '') == 'Ada/Rusak' ? 'warning' : 'danger') ?>"><?= $inventorydetails['iv_karpetb'] ?? '-' ?></span></p>
                                <p><strong>Badong:</strong> <span class="badge badge-<?= ($inventorydetails['iv_badong'] ?? '') == 'Ada/Baik' ? 'success' : (($inventorydetails['iv_badong'] ?? '') == 'Ada/Rusak' ? 'warning' : 'danger') ?>"><?= $inventorydetails['iv_badong'] ?? '-' ?></span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Perlengkapan Tambahan -->
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-header">
                                <h6 class="card-title">Perlengkapan Muat</h6>
                            </div>
                            <div class="card-body">
                                <p><strong>Tali Tambang (3 Gulung):</strong> <span class="badge badge-<?= ($inventorydetails['iv_tambang'] ?? '') == 'Ada/Baik' ? 'success' : (($inventorydetails['iv_tambang'] ?? '') == 'Ada/Rusak' ? 'warning' : 'danger') ?>"><?= $inventorydetails['iv_tambang'] ?? '-' ?></span></p>
                                <p><strong>Terpal Tarpolin:</strong> <span class="badge badge-<?= ($inventorydetails['iv_tarpolin'] ?? '') == 'Ada/Baik' ? 'success' : (($inventorydetails['iv_tarpolin'] ?? '') == 'Ada/Rusak' ? 'warning' : 'danger') ?>"><?= $inventorydetails['iv_tarpolin'] ?? '-' ?></span></p>
                                <p><strong>Terpal Plastik:</strong> <span class="badge badge-<?= ($inventorydetails['iv_plastik'] ?? '') == 'Ada/Baik' ? 'success' : (($inventorydetails['iv_plastik'] ?? '') == 'Ada/Rusak' ? 'warning' : 'danger') ?>"><?= $inventorydetails['iv_plastik'] ?? '-' ?></span></p>
                                <p><strong>Terpal Lidah (2 Lembar):</strong> <span class="badge badge-<?= ($inventorydetails['iv_lidah'] ?? '') == 'Ada/Baik' ? 'success' : (($inventorydetails['iv_lidah'] ?? '') == 'Ada/Rusak' ? 'warning' : 'danger') ?>"><?= $inventorydetails['iv_lidah'] ?? '-' ?></span></p>
                                
                                <p><strong>Pipa Kojong:</strong> <span class="badge badge-<?= ($inventorydetails['iv_kojong'] ?? '') == 'Ada/Baik' ? 'success' : (($inventorydetails['iv_kojong'] ?? '') == 'Ada/Rusak' ? 'warning' : 'danger') ?>"><?= $inventorydetails['iv_kojong'] ?? '-' ?></span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Tambahan -->
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-header">
                                <h6 class="card-title">Informasi Tambahan</h6>
                            </div>
                            <div class="card-body">
                                <p><strong>Jumlah Pipa Kojong:</strong><br><?= $inventorydetails['iv_jumlah'] ?? '-' ?> pcs</p>
                                <p><strong>Catatan:</strong><br><?= !empty($inventorydetails['iv_catatan'] ?? '') ? $inventorydetails['iv_catatan'] : '<span class="text-muted">Tidak ada catatan</span>' ?></p>
                                <p><strong>Status Inventory:</strong><br><?= !empty($inventorydetails['iv_is_active'] == 1) ? '<span class="badge badge-success">Sudah Pengecekan</span>' : '<span class="badge badge-danger">Belum Pengecekan</span>' ?></p>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                <div class="alert alert-warning text-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i>Data inventaris belum tersedia.
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Tanda Tangan Digital -->
        <div class="card card-danger card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-signature mr-2"></i>Verifikasi & Tanda Tangan Digital</h3>
            </div>
            <div class="card-body">
                <?php
                    $sig_lama    = $handoverdetails['signature_supir_lama'] ?? '';
                    $sig_baru    = $handoverdetails['signature_supir_baru'] ?? '';
                    $sig_petugas = $handoverdetails['signature_petugas'] ?? '';
                    $nama_petugas_saved = $handoverdetails['nama_petugas'] ?? '';
                ?>
                <form id="signatureForm" method="POST">
                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                    <input type="hidden" name="ho_code" value="<?= $handoverdetails['ho_code'] ?? '' ?>">
                    <input type="hidden" name="hand_id" value="<?= $hand_id ?>">
                    <input type="hidden" name="nopol" value="<?= $nopol ?>">
                    
                    <div class="row">
                        <!-- Tanda Tangan Supir Lama -->
                        <div class="col-md-6 mb-4">
                            <div class="card card-signature">
                                <div class="card-header bg-warning d-flex justify-content-between align-items-center">
                                    <h5 class="card-title text-center mb-0"><i class="fas fa-user-clock mr-2"></i>Supir Lama</h5>
                                </div>
                                <div class="card-body text-center">
                                    <div class="signature-container">
                                        <div class="canvas-wrapper im">
                                        <canvas id="signature-pad-supir-lama" class="signature-pad">
                                        </canvas>
                                        </div>
                                        <div class="signature-actions mt-2">
                                            <button type="button" class="btn btn-warning btn-sm" onclick="clearSignature('supir-lama')">
                                                <i class="fa fa-eraser"></i> Hapus
                                            </button>
                                        </div>
                                        <input type="hidden" name="signature_supir_lama" id="signature-supir-lama">
                                        <p class="text-muted mt-2"><strong>Nama:</strong> <?= $handoverdetails['ho_supirlama'] ?? '-' ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tanda Tangan Supir Baru -->
                        <div class="col-md-6 mb-4">
                            <div class="card card-signature">
                                <div class="card-header bg-success d-flex justify-content-between align-items-center">
                                    <h5 class="card-title text-center mb-0"><i class="fas fa-user-plus mr-2"></i>Supir Baru</h5>
                                </div>
                                <div class="card-body text-center">
                                    <div class="signature-container">
                                        <div class="canvas-wrapper">
                                        <canvas id="signature-pad-supir-baru" class="signature-pad"></canvas>
                                        </div>
                                        <div class="signature-actions mt-2">
                                            <button type="button" class="btn btn-warning btn-sm" onclick="clearSignature('supir-baru')">
                                                <i class="fa fa-eraser"></i> Hapus
                                            </button>
                                        </div>
                                        <input type="hidden" name="signature_supir_baru" id="signature-supir-baru">
                                        <p class="text-muted mt-2"><strong>Nama:</strong> <?= $handoverdetails['ho_supirbaru'] ?? '-' ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                        <!-- Tanda Tangan Petugas -->
                    <div class="row justify-content-center">
                        <div class="col-md-6 mb-4">
                            <div class="card card-signature">
                                <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                                    <h5 class="card-title text-center mb-0"><i class="fas fa-user-tie mr-2"></i>Petugas Serah Terima</h5>
                                </div>
                                <div class="card-body text-center">
                                    <div class="signature-container">
                                        <div class="canvas-wrapper">
                                        <canvas id="signature-pad-petugas" class="signature-pad"></canvas>
                                        </div>
                                        <div class="signature-actions mt-2">
                                            <button type="button" class="btn btn-warning btn-sm" onclick="clearSignature('petugas')">
                                                <i class="fa fa-eraser"></i> Hapus
                                            </button>
                                        </div>
                                        <input type="hidden" name="signature_petugas" id="signature-petugas">
                                        <div class="form-group mt-2">
                                            <label class="text-muted"><strong>Nama Petugas:</strong></label>
                                            <input type="text" name="nama_petugas" class="form-control form-control-sm" placeholder="Masukkan nama petugas" required value="<?= esc($nama_petugas_saved) ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center">
                <a href="<?= base_url('handover/handover_management') ?>" class="btn btn-lg btn-secondary float-left" style="width: 12%;">
                    <i class="fa fa-file-signature mr-2"></i> UPDATE
                </a>
                <button type="button" class="btn btn-lg btn-primary" onclick="saveAllSignatures()">
                    <i class="fa fa-file-signature mr-2"></i> SAVE
                </button>
                <a href="<?= base_url('handover/handover_print/' . $hand_id) ?>" class="btn btn-lg btn-success" id="printBtn" style="display: none;">
                    <i class="fa fa-print mr-2"></i> PRINT
                </a>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

<style>
.canvas-wrapper {
    position: relative;
    width: 100%;
    height: 0;
    padding-bottom: 60%; /* Rasio aspek 5:3 */
    margin-bottom: 10px;
}

.signature-pad {
    position: absolute;
    top: 0;
    left: 0;
    width: 100% !important;
    height: 100% !important;
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    background-color: #f8f9fa;
    touch-action: none;
    cursor: crosshair;
}

.signature-container {
    text-align: center;
}

.signature-actions {
    margin-bottom: 10px;
}

.card-signature {
    transition: transform 0.2s;
    border: 1px solid #dee2e6;
    height: 100%;
}

.card-signature:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.info-box {
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 10px;
}

.table-sm td {
    padding: 8px 12px;
}

.nav-tabs-custom {
    box-shadow: none;
}

.nav-tabs-custom .nav-tabs {
    border-bottom: 2px solid #dee2e6;
}

.nav-tabs-custom .nav-tabs .nav-link {
    border: none;
    border-bottom: 3px solid transparent;
    font-weight: 500;
}

.nav-tabs-custom .nav-tabs .nav-link.active {
    border-bottom: 3px solid #007bff;
    color: #007bff;
}

.card-sm {
    margin-bottom: 15px;
}

.card-sm .card-body {
    padding: 10px;
}

.card-sm .card-body p {
    margin-bottom: 8px;
    font-size: 0.9rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .canvas-wrapper {
        padding-bottom: 70%; /* Rasio lebih tinggi untuk mobile */
    }
    
    .card-signature {
        margin-bottom: 20px;
    }
    
    .card-body {
        padding: 15px;
    }
}

@media (max-width: 576px) {
    .canvas-wrapper {
        padding-bottom: 80%; /* Rasio lebih tinggi untuk smartphone kecil */
    }
    
    .signature-actions .btn {
        font-size: 0.8rem;
        padding: 5px 10px;
    }
}

/* Untuk tablet landscape dan desktop kecil */
@media (min-width: 992px) and (max-width: 1199px) {
    .canvas-wrapper {
        padding-bottom: 55%;
    }
}

/* Untuk desktop besar */
@media (min-width: 1200px) {
    .canvas-wrapper {
        padding-bottom: 50%;
    }
}
</style>

<script>
// Initialize signature pads
let signaturePads = {};

const savedSignatures = {
    'supir-lama': <?= !empty($sig_lama) ? json_encode($sig_lama) : 'null' ?>,
    'supir-baru': <?= !empty($sig_baru) ? json_encode($sig_baru) : 'null' ?>,
    'petugas': <?= !empty($sig_petugas) ? json_encode($sig_petugas) : 'null' ?>
};

function initializeSignaturePads() {
    const pads = [
        'supir-lama',
        'supir-baru', 
        'petugas'
    ];

    pads.forEach(padId => {
        const canvas = document.getElementById(`signature-pad-${padId}`);
        const signaturePad = new SignaturePad(canvas, {
            backgroundColor: 'rgb(255, 255, 255)',
            penColor: 'rgb(0, 0, 0)',
            minWidth: 1,
            maxWidth: 3,
            throttle: 16
        });

        signaturePads[padId] = signaturePad;
        
        resizeCanvas(padId, canvas, signaturePad);
        
        // Load previously saved signature if any
        if (savedSignatures[padId]) {
            signaturePad.fromDataURL(savedSignatures[padId]);
            document.getElementById(`signature-${padId}`).value = savedSignatures[padId];
        }
        
        // Handle window resize
        window.addEventListener("resize", () => {
            resizeCanvas(padId, canvas, signaturePad);
        });

        // Add touch event listeners for better mobile support
        canvas.addEventListener('touchstart', (e) => {
            e.preventDefault();
        });
    });
}

        // Handle resize for better mobile experience
        function resizeCanvas(padId, canvas, signaturePad) {
    const wrapper = canvas.parentElement;
    const width = wrapper.offsetWidth;
    const height = wrapper.offsetHeight;
    
    // Set canvas dimensions
    canvas.width = width;
    canvas.height = height;
    
    // Clear and redraw if there's existing signature
    if (!signaturePad.isEmpty()) {
        const data = signaturePad.toData();
        signaturePad.clear();
        signaturePad.fromData(data);
    }
}

function clearSignature(padId) {
    if (signaturePads[padId]) {
        signaturePads[padId].clear();
        document.getElementById(`signature-${padId}`).value = '';
        updateSignatureBadge(padId, false);
    }
}

// function updateSignatureBadge(padId, signed) {
//     const badge = document.getElementById(`sig-badge-${padId}`);
//     if (!badge) return;
//     if (signed) {
//         badge.className = 'badge badge-success';
//         badge.textContent = 'Sudah ditandatangani';
//     } else {
//         badge.className = 'badge badge-secondary';
//         badge.textContent = 'Belum ditandatangani';
//     }
// }

// Compress signature canvas to fit under maxSizeKB (default 30KB)
function compressSignature(signaturePad, maxSizeKB) {
    maxSizeKB = maxSizeKB || 30;
    const maxBytes = maxSizeKB * 1024;
    const sourceCanvas = signaturePad._canvas || signaturePad.canvas;

    // Create a smaller canvas (max 300x150) to reduce data size
    const tempCanvas = document.createElement('canvas');
    const maxW = 300, maxH = 150;
    let w = sourceCanvas.width, h = sourceCanvas.height;
    if (w > maxW || h > maxH) {
        const ratio = Math.min(maxW / w, maxH / h);
        w = Math.round(w * ratio);
        h = Math.round(h * ratio);
    }
    tempCanvas.width = w;
    tempCanvas.height = h;
    const ctx = tempCanvas.getContext('2d');
    ctx.fillStyle = '#ffffff';
    ctx.fillRect(0, 0, w, h);
    ctx.drawImage(sourceCanvas, 0, 0, w, h);

    // Try PNG first
    let dataUrl = tempCanvas.toDataURL('image/png');
    let sizeBytes = Math.round((dataUrl.length - 'data:image/png;base64,'.length) * 3 / 4);
    if (sizeBytes <= maxBytes) return dataUrl;

    // Fall back to JPEG with decreasing quality
    let quality = 0.7;
    while (quality >= 0.1) {
        dataUrl = tempCanvas.toDataURL('image/jpeg', quality);
        sizeBytes = Math.round((dataUrl.length - 'data:image/jpeg;base64,'.length) * 3 / 4);
        if (sizeBytes <= maxBytes) return dataUrl;
        quality -= 0.1;
    }
    // Return lowest quality if still over
    return tempCanvas.toDataURL('image/jpeg', 0.1);
}

function saveAllSignatures() {
    let allSigned = true;

    // Check all required signatures and compress to max 30KB
    const requiredPads = ['supir-lama', 'supir-baru', 'petugas'];
    const MAX_SIZE_KB = 30;
    
    requiredPads.forEach(padId => {
        const signaturePad = signaturePads[padId];
        if (signaturePad && !signaturePad.isEmpty()) {
            const signatureData = compressSignature(signaturePad, MAX_SIZE_KB);
            document.getElementById(`signature-${padId}`).value = signatureData;
        } else {
            allSigned = false;
            const names = {
                'supir-lama': 'Supir Lama',
                'supir-baru': 'Supir Baru', 
                'petugas': 'Petugas Serah Terima'
            };
            alert(`Tanda tangan ${names[padId]} belum diisi!`);
            return;
        }
    });

    if (!allSigned) return;

    const namaPetugas = document.querySelector('input[name="nama_petugas"]').value;
    const handId = document.querySelector('input[name="hand_id"]').value;
    const nopol = document.querySelector('input[name="nopol"]').value;
    
    if (!namaPetugas.trim()) {
        alert('Nama petugas serah terima harus diisi!');
        return;
    }

    // Show loading state
    const saveBtn = document.querySelector('button[onclick="saveAllSignatures()"]');
    const originalText = saveBtn.innerHTML;
    saveBtn.innerHTML = '<i class="fa fa-spinner fa-spin mr-2"></i> Menyimpan...';
    saveBtn.disabled = true;

    // Submit form via AJAX
    const formData = new FormData(document.getElementById('signatureForm'));
    
    fetch('<?= base_url('handover/save_signature') ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Verifikasi berhasil! Dokumen siap dicetak.');
            document.getElementById('printBtn').style.display = 'inline-block';
            saveBtn.style.display = 'none';

            ['supir-lama', 'supir-baru', 'petugas'].forEach(padId => updateSignatureBadge(padId, true));
            
            const actualHandId = data.hand_id || handId;
            const printUrl = `<?= base_url('handover/handover_print/') ?>${actualHandId}`;
            document.getElementById('printBtn').href = printUrl;
        } else {
            alert('Error: ' + (data.message || 'Terjadi kesalahan tidak diketahui'));
        }
    })
    .catch(error => {
        alert('Terjadi kesalahan saat menyimpan tanda tangan.');
    })
    .finally(() => {
        saveBtn.innerHTML = originalText;
        saveBtn.disabled = false;
    });
}
// Initialize when page loads
document.addEventListener('DOMContentLoaded', function() {
    initializeSignaturePads();
    
    // Add some interactive features
    const cards = document.querySelectorAll('[data-card-widget="collapse"]');
    cards.forEach(card => {
        card.addEventListener('click', function() {
            const icon = this.querySelector('i');
            if (icon.classList.contains('fa-minus')) {
                icon.classList.replace('fa-minus', 'fa-plus');
            } else {
                icon.classList.replace('fa-plus', 'fa-minus');
            }
        });
    });
});
</script>

<?= view('layout/footer') ?>