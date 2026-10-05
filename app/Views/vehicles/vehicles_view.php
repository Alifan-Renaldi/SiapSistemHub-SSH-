<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Vehicle Details</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('vehicles/vehicles_management'); ?>">Vehicle</a></li>
                    <li class="breadcrumb-item active">Vehicle Details</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <!-- Profile Image -->
                <div class="card card-success card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <!-- Image placeholder -->
                        </div>

                        <h3 class="profile-username text-center"><b><?= ucwords($vehicledetails['v_registration_no']); ?></b></h3>

                        <div class="text-center mt-4 mb-4">
                            <?php if (!empty($vehicledetails['v_qr_code_path'])) : ?>
                                <div class="qr-code-block" style="border: 1px solid #ddd; padding: 10px; border-radius: 8px; display: inline-block; background: #fff;">
                                    <img src="<?= base_url('vehicles/view_qrcode/' . $vehicledetails['v_id']) ?>" 
                                         alt="QR Code" 
                                         class="img-fluid" 
                                         style="width: 200px; height: 200px; object-fit: contain;">
                                </div>
                            <?php else : ?>
                                <div class="text-muted border rounded p-4" style="background: #f8f9fa;">
                                    <i class="fa fa-qrcode fa-4x text-gray-300"></i>
                                    <p class="mt-2 mb-0">QR Code belum dibuat</p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <p class="text-muted text-center"><?= ($vehicledetails['v_is_active'] == 1) ? '<span class="right badge badge-success">Active</span>' : '<span class="right badge badge-danger">Inactive</span>' ?></p>

                        <!-- <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Bookings</b> <a class="float-right"><?= count($bookings); ?></a>
                            </li>
                            <li class="list-group-item">
                                <b>Notifications</b>
                            </li>
                        </ul> -->
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
                <div class="col-md-12 text-left mb-3">
                    <a href="<?= base_url('vehicles/vehicles_management'); ?>" class="">
                        <i class="fa fa-arrow-left"></i> Back To Vehicle List
                    </a>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#basicinfo" data-toggle="tab">Vehicle Info</a></li>
                            <!-- <li class="nav-item"><a class="nav-link" href="#bookings" data-toggle="tab">Bookings</a></li>
                            <li class="nav-item"><a class="nav-link" href="#vechicle_incomexpense" data-toggle="tab">Income & Expense</a></li> -->
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane" id="bookings">
                                <table id="bookingstbl" class="table table-striped projects">
                                    <thead>
                                        <tr>
                                            <th class="percent1">#</th>
                                            <th class="percent25">Driver</th>
                                            <th class="percent25">Customer</th>
                                            <th class="percent25">From & To</th>
                                            <th class="percent25">Booking Value</th>
                                            <th class="percent25">Trip Status</th>
                                            <th class="percent25">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($bookings)) : ?>
                                            <?php $count = 1; ?>
                                            <?php foreach ($bookings as $bookingsdata) : ?>
                                                <tr>
                                                    <td><?= $count; $count++; ?></td>
                                                    <td><?= (isset($bookingsdata['t_driver_details']->d_name)) ? $bookingsdata['t_driver_details']->d_name : '<span class="badge badge-danger">Yet to Assign</span>'; ?></td>
                                                    <td><?= $bookingsdata['t_customer_details']->c_name; ?></td>
                                                    <td>
                                                        <small><?= $bookingsdata['t_trip_fromlocation']; ?></small><br>
                                                        <span class="badge badge-success">to</span><br>
                                                        <small><?= $bookingsdata['t_trip_tolocation']; ?></small>
                                                    </td>
                                                    <td><?= $bookingsdata['t_trip_amount']; ?></td>
                                                    <td>
                                                        <?php
                                                        switch ($bookingsdata['t_trip_status']) {
                                                            case 'ongoing':
                                                                $status = '<span class="badge badge-info">Ongoing</span>';
                                                                break;
                                                            case 'completed':
                                                                $status = '<span class="badge badge-success">Completed</span>';
                                                                break;
                                                            case 'yettostart':
                                                                $status = '<span class="badge badge-warning">Yet to start</span>';
                                                                break;
                                                            case 'cancelled':
                                                                $status = '<span class="badge badge-danger">Cancelled</span>';
                                                                break;
                                                            case 'yettoconfirm':
                                                                $status = '<span class="badge badge-danger">Yet to Confirm</span>';
                                                                break;
                                                        }
                                                        echo $status;
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <a class="icon" target="_blank" href="<?= base_url('trips/details/' . $bookingsdata['t_id']); ?>">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.tab-pane -->

                            <div class="tab-pane" id="vechicle_geofence">
                                <table id="vgeofencetbl" class="table table-striped projects">
                                    <thead>
                                        <tr>
                                            <th class="percent1">#</th>
                                            <th class="percent25">Name</th>
                                            <th class="percent25">Description</th>
                                            <th class="percent25">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($vechicle_geofence)) : ?>
                                            <?php $count = 1; ?>
                                            <?php foreach ($vechicle_geofence as $geofence) : ?>
                                                <tr>
                                                    <td><?= $count; $count++; ?></td>
                                                    <td><?= $geofence['geo_name']; ?></td>
                                                    <td><?= $geofence['geo_description']; ?></td>
                                                    <td>
                                                        <a class="icon" href="<?= base_url('geofence'); ?>">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane" id="vechicle_incomexpense">
                                <table id="incomexpenstbl" class="table table-striped projects">
                                    <thead>
                                        <tr>
                                            <th class="percent1">#</th>
                                            <th class="percent25">Date</th>
                                            <th class="percent25">Description</th>
                                            <th class="percent25">Amount</th>
                                            <th class="percent25">Type</th>
                                            <th class="percent25">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($vechicle_incomexpense)) : ?>
                                            <?php $count = 1; ?>
                                            <?php foreach ($vechicle_incomexpense as $incomexpensdata) : ?>
                                                <tr>
                                                    <td><?= $count; $count++; ?></td>
                                                    <td><?= $incomexpensdata['ie_date']; ?></td>
                                                    <td><?= $incomexpensdata['ie_description']; ?></td>
                                                    <td><?= $incomexpensdata['ie_amount']; ?></td>
                                                    <td>
                                                        <?= ($incomexpensdata['ie_type'] == 'income') ? '<span class="right badge badge-success">Income</span>' : '<span class="right badge badge-danger">Expense</span>'; ?>
                                                    </td>
                                                    <td>
                                                        <a class="icon" href="<?= base_url('incomexpense'); ?>">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane active" id="basicinfo">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-sm table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th>Pemilik</th>
                                                    <td><?= $vehicledetails['v_legal'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Merk</th>
                                                    <td><?= $vehicledetails['v_type'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Jenis Mobil/Bak</th>
                                                    <td><?= $vehicledetails['v_name'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Tahun Kendaraan</th>
                                                    <td><?= $vehicledetails['v_reg_exp_date'] ?></td>
                                                </tr>
                                                <?php if (function_exists('userpermission') && userpermission('lr_vech_detail_num')) : ?>
                                                <tr>
                                                    <th>Nomor Rangka</th>
                                                    <td><?= $vehicledetails['v_chassis_no'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Nomor Mesin</th>
                                                    <td><?= $vehicledetails['v_engine_no'] ?></td>
                                                </tr>
                                                <?php endif; ?>
                                                <tr>
                                                    <th>Masa Berlaku Pajak STNK</th>
                                                    <td><?= (empty($vehicledetails['v_stnk_expdate']) || $vehicledetails['v_stnk_expdate'] == '0000-00-00') ? '-' : date('d-m-Y', strtotime($vehicledetails['v_stnk_expdate'])) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Masa Berlaku Plat</th>
                                                    <td><?= (empty($vehicledetails['v_plat_expdate']) || $vehicledetails['v_plat_expdate'] == '0000-00-00') ? '-' : date('d-m-Y', strtotime($vehicledetails['v_plat_expdate'])) ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-sm table-bordered">
                                            <tbody>
                                                <?php if (function_exists('userpermission') && userpermission('lr_vech_detail_num')) : ?>
                                                <tr>
                                                    <th>Nomor Uji</th>
                                                    <td><?= $vehicledetails['v_uji_no'] ?></td>
                                                </tr>
                                                <?php endif; ?>
                                                <tr>
                                                    <th>Masa Berlaku KIR</th>
                                                    <td><?= (empty($vehicledetails['v_kir_expdate']) || $vehicledetails['v_kir_expdate'] == '0000-00-00') ? '-' : date('d-m-Y', strtotime($vehicledetails['v_kir_expdate'])) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Tanggal Proses KIR</th>
                                                    <td><?= (empty($vehicledetails['v_kir_process_date']) || $vehicledetails['v_kir_process_date'] == '0000-00-00') ? '-' : date('d-m-Y', strtotime($vehicledetails['v_kir_process_date'])) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Lokasi Dishub</th>
                                                    <td><?= $vehicledetails['v_lokasi_kir'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Catatan Lokasi Dishub</th>
                                                    <td><?= 
                                                    $catatanLokasi = $vehicledetails['v_notes_lokasikir'];
                                                    if (empty($catatanLokasi) == '') {
                                                        echo '';
                                                    }else {
                                                        echo ($catatanLokasi);
                                                    }
                                                    ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Asuransi</th>
                                                    <td><?= 
                                                    $asuransi = $vehicledetails['v_insurance'];
                                                    if (empty($asuransi) == '') {
                                                        echo '';
                                                    }else {
                                                        echo esc($asuransi);
                                                    } 
                                                    ?></td>
                                                </tr>
                                                <?php if (function_exists('userpermission') && userpermission('lr_vech_detail_num')) : ?>
                                                <tr>
                                                    <th>Nomor Polis</th>
                                                    <td><?=
                                                    $noPolis = $vehicledetails['v_polis_no'];
                                                    if (empty($noPolis) == '') {
                                                        echo '';
                                                    }else {
                                                        echo esc($noPolis);
                                                    }
                                                     ?></td>
                                                </tr>
                                                <?php endif; ?>
                                                <tr>
                                                    <th>Masa Berlaku Asuransi</th>
                                                    <td>
                                                        <?php 
                                                        $insurance_date = $vehicledetails['v_exp_insurance'];
                                                        if (empty($insurance_date) || $insurance_date == '0000-00-00' || $insurance_date == '0000-00-00 00:00:00') {
                                                            echo '';
                                                        } else {
                                                            echo esc(date('d-m-Y', strtotime($insurance_date)));
                                                        }
                                                        ?>
                                                    </td>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col-md-12">
                                        <table class="table table-sm table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th>Keterangan</th>
                                                    <td><?= $vehicledetails['v_notes'] ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col-md-12">
                                        <table class="table table-sm table-bordered">
                                            <tbody>
                                                <?php if (userpermission('lr_view_userby')) : ?>
                                                    <tr>
                                                        <td>Petugas</td>
                                                        <td><?= isset($vehicledetails['creator_name']) ? $vehicledetails['creator_name'] : $vehicledetails['v_created_by'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tanggal Penginputan</td>
                                                        <td><?= esc(dateTimeFormat($vehicledetails['v_created_date'] ?? '')) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Riwayat Terakhir Perubahan</td>
                                                        <td><?= esc(dateTimeFormat($vehicledetails['v_modified_date'] ?? '')) ?></td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php if (function_exists('userpermission') && userpermission('lr_vech_list_edit')) : ?>
                                    <form action="<?= base_url('vehicles/editvehicle') ?>" method="POST" style="display: inline;">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="vehicle_id" value="<?= $vehicledetails['v_id'] ?>">
                                        <button type="submit" class="btn btn-block btn-primary btn-sm">EDIT DATA VEHICLE</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
<br>
<?= view('layout/footer') ?>

<script src="<?= base_url('assets/autoLogout.js') ?>"></script>
<script>
    const baseUrl = "<?= base_url() ?>"; 
    enableAutoLogout(7200, baseUrl + "login");
</script>