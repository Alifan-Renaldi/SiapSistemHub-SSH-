
<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>
<?php
// Custom loading logo check (developer can replace loading_logo.png in assets/uploads)
$loading_logo = 'assets/uploads/loading_logo.png';
if (!file_exists(FCPATH . $loading_logo)) {
   $loading_logo = 'assets/uploads/Icon SSH.png'; // Fallback to default icon
}
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"></script>
<style>
        /* Premium Loading Screen Overlay CSS */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.671);
            z-index: 999999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 1;
            visibility: visible;
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }
        .loading-overlay.fade-out {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }
        .loader-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #ffffff;
            padding: 20px;
        }
        .loading-logo {
            max-width: 75px;
            height: auto;
            margin-top: 28px;
            margin-left: 11px;
            animation: pulse-glow 2.5s infinite ease-in-out;
            filter: drop-shadow(0 0 15px rgba(239, 28, 37, 0.3));
        }
        .loader-spinner {
            position: relative;
            width: 100px;
            height: 100px;
            margin-bottom: 30px;
        }
        .loader-spinner::before,
        .loader-spinner::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            border: 4px solid transparent;
        }
        .loader-spinner::before {
            top: 0; left: 0; right: 0; bottom: 0;
            border-top-color: #ef1c25; /* SSH Red */
            animation: spin-clockwise 1.5s linear infinite;
        }
        .loader-spinner::after {
            top: 6px; left: 6px; right: 6px; bottom: 6px;
            border-bottom-color: #3b82f6; /* Premium Blue */
            animation: spin-counter 1.2s linear infinite;
        }
        .loading-text {
            font-size: 18px;
            font-weight: 600;
            letter-spacing: 0.03em;
            color: #ffffff;
            margin-top: 10px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            font-family: 'Source Sans Pro', 'Inter', sans-serif;
        }
        .loading-subtext {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.55);
            margin-top: 6px;
            letter-spacing: 0.02em;
            font-family: 'Source Sans Pro', 'Inter', sans-serif;
        }
        @keyframes spin-clockwise {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        @keyframes spin-counter {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(-360deg); }
        }
        @keyframes pulse-glow {
            0%, 100% {
                transform: scale(1);
                filter: drop-shadow(0 0 12px rgba(255, 255, 255, 0.15)) drop-shadow(0 0 6px rgba(239, 28, 37, 0.25));
            }
            50% {
                transform: scale(1.05);
                filter: drop-shadow(0 0 22px rgba(255, 255, 255, 0.35)) drop-shadow(0 0 14px rgba(239, 28, 37, 0.5));
            }
        }
</style>
<!-- Premium Loading Screen Overlay for Dashboard -->
<div id="loading-screen" class="loading-overlay">
  <div class="loader-container">
    <div class="loader-spinner">
      <img src="<?= base_url($loading_logo) ?>" alt="Logo" class="loading-logo">
    </div>
    <!-- <div class="loading-text">Memuat Dashboard</div>
    <div class="loading-subtext">Menyiapkan data overview Anda, mohon tunggu...</div> -->
  </div>
</div>

<div class="content">
  <div class="container-fluid">
    <!-- Header dengan Filter -->
    <div class="row mb-4 align-items-center">
      <div class="col-md-6">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Overview</h1>
        <p class="mb-0">Welcome to Siapp System!</p>
      </div>
      <div class="col-md-6 d-flex justify-content-end align-items-center">
        <div class="btn-group mr-3">
          <button type="button" class="btn btn-sm btn-outline-primary active">Today</button>
          <button type="button" class="btn btn-sm btn-outline-primary">This Week</button>
          <button type="button" class="btn btn-sm btn-outline-primary">This Month</button>
        </div>
        <button class="btn btn-sm btn-outline-secondary" id="theme-toggle">
          <i class="fas fa-moon"></i>
        </button>
      </div>
    </div>

    <!-- Quick Actions -->
    
    <div class="row mb-4">
      
      <div class="col-12">
        <div class="card shadow-sm">
          <div class="card-body py-2">
            
            <div class="d-flex justify-content-between">
              <?php if (function_exists('userpermission') && userpermission('lr_drivers_list')) : ?>
               <a href="<?= base_url() ?>drivers/drivers_management" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-user-secret mr-1"></i> Driver Management
              </a>
               <?php endif; ?>
               <?php if (function_exists('userpermission') && userpermission('lr_vech_list')) : ?>
              <a href="<?= base_url() ?>vehicles/vehicles_management" class="btn btn-sm btn-outline-success">
                <i class="fas fa-truck mr-1"></i> Vehicle Management
              </a>
              <?php endif; ?>
              <!-- <a href="<?= base_url() ?>trips/add" class="btn btn-sm btn-outline-success">
                <i class="fas fa-route mr-1"></i> Create Trip
              </a>
              <a href="<?= base_url() ?>customers/add" class="btn btn-sm btn-outline-warning">
                <i class="fas fa-users mr-1"></i> Add Customer
              </a> -->
              <?php if (function_exists('userpermission') && userpermission('lr_reports_driver')) : ?>
              <a href="<?= base_url() ?>reports/driver" class="btn btn-sm btn-outline-danger">
                <i class="fas fa-chart-bar mr-1"></i> Generate Report
              </a>
              <?php endif; ?>
            </div>
            
          </div>
        </div>
      </div>

    </div>
    

    <!-- Stats Cards dengan Animasi -->
    <div class="row">
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card border-left-primary shadow-sm h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2 mt-4">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Drivers</div>
                <div class="h5 font-weight-bold text-gray-800"><?= $dashboard['tot_drivers'] ?? 0 ?></div>
                <div class="mt-2 text-small">
                  <!-- <span class="text-success">
                    <i class="fas fa-arrow-up"></i> 5.6%
                  </span>
                  <span class="text-muted">since last month</span> -->
                </div>
              </div>
              <div class="col-auto mt-4">
                <i class="fa fa-user-secret fa-2x text-gray-300"></i>
              </div>
            </div>
            <!-- <div class="h6 mt-3 font-weight-bold text-gray-800">
              Active: <span class="text-success"><?= $dashboard['tot_drivers_active'] ?? 0 ?></span> &nbsp;|&nbsp;
              Inactive: <span class="text-danger"><?= $dashboard['tot_drivers_inactive'] ?? 0 ?></span>
            </div> -->
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card border-left-success shadow-sm h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2 mt-4">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Vehicles</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $dashboard['tot_vehicles'] ?? 0 ?></div>
                <div class="mt-2 text-small">
                  <!-- <span class="text-success">
                    <i class="fas fa-arrow-up"></i> 2.3%
                  </span>
                  <span class="text-muted">since last month</span> -->
                </div>
              </div>
              <div class="col-auto mt-4">
                <i class="fas fa-truck fa-2x text-gray-300"></i>
              </div>
            </div>
            <!-- <div class="h6 mt-3 font-weight-bold text-gray-800">
                  Active: <span class="text-success"><?= $dashboard['tot_vehicles_active'] ?? 0 ?></span> &nbsp;|&nbsp;
                  Inactive: <span class="text-danger"><?= $dashboard['tot_vehicles_inactive'] ?? 0 ?></span>
                </div> -->
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card border-left-info shadow-sm h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2 mt-4">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total BAP</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $dashboard['tot_bap'] ?? 0 ?></div>
                <div class="mt-2 text-small">
                  <!-- <span class="text-danger">
                    <i class="fas fa-arrow-down"></i> 1.2%
                  </span>
                  <span class="text-muted">since last month</span> -->
                </div>
              </div>
              <div class="col-auto mt-4">
                <i class="fas fa-users fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card border-left-warning shadow-sm h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2 mt-4">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Today Trips</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $dashboard['tot_today_trips'] ?? 0 ?></div>
                <div class="mt-2 text-small">
                  <!-- <span class="text-success">
                    <i class="fas fa-arrow-up"></i> 12.8%
                  </span>
                  <span class="text-muted">since yesterday</span> -->
                </div>
              </div>
              <div class="col-auto mt-4">
                <i class="fas fa-route fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Charts & Reminders Row -->
    <div class="row">
      <!-- Income/Expenses Chart -->
      <div class="col-xl-8 col-lg-7">
        <div class="card shadow-sm mb-4">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Sample Overview</h6>
            <div class="dropdown no-arrow">
              <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                <div class="dropdown-header">Chart Options:</div>
                <a class="dropdown-item" href="#">View Report</a>
                <a class="dropdown-item" href="#">Export Data</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" id="toggle-chart-type">Switch to Bar Chart</a>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="chart-area">
              <canvas id="ie-chart" height="250"></canvas>
            </div>
            <div class="mt-4 text-center small">
              <span class="mr-3">
                <i class="fas fa-circle text-success"></i> Income
              </span>
              <span class="mr-3">
                <i class="fas fa-circle text-danger"></i> Expenses
              </span>
              <span class="mr-3">
                <i class="fas fa-circle text-info"></i> Profit
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Reminders & Notifications Card -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow-sm mb-4">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Reminders Documentation</h6>
            <!-- <span class="badge badge-primary badge-pill"><?= count($todayreminder) ?></span> -->
          </div>
          <div class="card-body px-5">
            <table class="w-full text-center text-sm font-bold table-fixed tracking-wide border-collapse" style="border: 1px solid black !important;">
                        <thead class="rounded-3">
                            <tr class="bg-white text-blue-400">
                                <th class="py-2" style="border: 1px solid black !important;">Pajak</th>
                                <th class="py-2" style="border: 1px solid black !important;">Plat</th>
                                <th class="py-2" style="border: 1px solid black !important;">KIR</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-yellow-400 text-black">
                                <td class="py-2" style="border: 1px solid black !important;"><?= $reminderYellow['stnk_yellow'] ?? 0 ?></td>
                                <td class="py-2" style="border: 1px solid black !important;"><?= $reminderYellow['plat_yellow'] ?? 0 ?></td>
                                <td class="py-2" style="border: 1px solid black !important;"><?= $reminderYellow['kir_yellow'] ?? 0 ?></td>
                            </tr>
                            <tr class="bg-red-600 text-black">
                                <td class="py-2" style="border: 1px solid black !important;"><?= $reminderRed['stnk_red'] ?? 0 ?></td>
                                <td class="py-2" style="border: 1px solid black !important;"><?= $reminderRed['plat_red'] ?? 0 ?></td>
                                <td class="py-2" style="border: 1px solid black !important;"><?= $reminderRed['kir_red'] ?? 0 ?></td>
                            </tr>
                        </tbody>
                    </table>
          </div>
        </div>
      </div>
    </div>
  

    <!-- Vehicle Map & Status Row -->
    <div class="row">
      <!-- Vehicle Map -->
      <div class="col-lg-6 mb-4">
        <div class="card shadow-sm mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Status Mobil</h6>
          </div>
          <div class="card-body">
            <div class="chart-pie pt-5 pb-4">
              <canvas id="statusPieChart" height="287"></canvas>
            </div>
            <div class="mt-4 text-center small">
              <span class="mr-2">
                <i class="fas fa-circle text-success"></i> Idle
              </span>
              <span class="mr-2">
                <i class="fas fa-circle text-primary"></i> In Trip
              </span>
              <span class="mr-2">
                <i class="fas fa-circle text-info"></i> Maintenance
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Inventory Current Location -->
      <div class="col-lg-6 mb-4">
        <div class="card shadow-sm mb-4">
          <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Inventaris Mobil</h6>
            <div class="dropdown">
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-hover" id="vehicleLocationTable" width="100%" cellspacing="0">
                <thead class="thead-light">
                  <tr>
                    <th>No</th>
                    <th>Jenis Mobil</th>
                    <th>Total Seluruh Jenis</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $count = 1; ?>
                  <?php if(!empty($inventoryReadyList)): ?>
                    <?php foreach($inventoryReadyList as $inventory): ?>
                      <tr>
                        <td><?= esc($count); $count++; ?></td>
                        <td><?= esc($inventory['iv_jenis']); ?></td>
                        <td><?= esc($inventory['total_inventory']) ?></td>
                      </tr>
                      
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="3" class="text-center">Tidak Ada Data Inventaris</td>
                    </tr>
                  <?php endif; ?>
                </tbody>
                      <tr style="font-weight: bold;">
                        <td>Total Inventaris</td>
                        <td colspan="2"><?= esc($dashboard['tot_inventorys']) ?></td>
                      </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
      <!-- Vehicle Status Chart
      <div class="col-lg-6 mb-4">
        <div class="card shadow-sm mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Status Supir</h6>
          </div>
          <div class="card-body">
            <div class="chart-pie pt-4 pb-2">
              <canvas id="statusDriverChart" height="250"></canvas>
            </div>
            <div class="mt-4 text-center small">
              <span class="mr-2">
                <i class="fas fa-circle text-success"></i> Idle
              </span>
              <span class="mr-2">
                <i class="fas fa-circle text-primary"></i> In Trip
              </span>
              <span class="mr-2">
                <i class="fas fa-circle text-info"></i> Maintenance
              </span>
            </div>
          </div>
        </div>
      </div>
    </div> -->

    <!-- Vehicle Information Row -->
    <div class="row">
      <!-- Vehicle Current Location -->
      <div class="col-lg-6 mb-4">
        <div class="card shadow-sm mb-4">
          <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Status Mobil</h6>
            <div class="dropdown">
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-hover" id="vehicleLocationTable" width="100%" cellspacing="0">
                <thead class="thead-light">
                  <tr>
                    <th>No</th>
                    <th>Jenis Mobil</th>
                    <th>Total Unit Aktif</th>
                    <th>Total Unit Tidak Aktif</th>
                    <th>Total Seluruh Unit</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $count = 1; ?>
                  <?php if(!empty($vehicleReadyList)): ?>
                    <?php foreach($vehicleReadyList as $vehicle): ?>
                      <tr>
                        <td><?= esc($count); $count++; ?></td>
                        <td><?= esc($vehicle['gr_name']); ?></td>
                        <td><?= esc($vehicle['total_active_vehicle']) ?></td>
                        <td><?= esc($vehicle['total_inactive_vehicle']) ?></td>
                        <td><?= esc($vehicle['total_vehicle']) ?></td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="3" class="text-center">Tidak Ada Data Mobil</td>
                    </tr>
                  <?php endif; ?>
                </tbody>
                    <tr style="font-weight: bold;">
                      <td colspan="2">Total Vehicle</td>
                      <td colspan="3"><?= esc($dashboard['tot_vehicles']) ?></td>
                    </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- Vehicle Running Status -->
      <div class="col-lg-6 mb-4">
        <div class="card shadow-sm mb-4">
          <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Status Supir dan Unit Mobil</h6>
            <button class="btn btn-sm btn-outline-primary" id="refresh-status">
              <i class="fas fa-sync-alt"></i> Refresh
            </button>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                <thead class="thead-light">
                  <tr>
                    <th>Kategori
                    <th>Jumlah Supir Aktif</th>
                    <th>Jumlah Supir Tidak Aktif</th>
                  </tr>
                </thead>
                <a style="margin-bottom: 10px;" href="<?= base_url() ?>drivers/drivers_management" class="btn btn-sm btn-outline-success">Detail Supir</a>
                    <tbody>
                          <tr>
                            <td>Supir</td>
                            <td class="text-success font-weight-bold"><?= esc($dashboard['tot_drivers_active']) ?></td>
                            <td class="text-danger font-weight-bold"><?= esc($dashboard['tot_drivers_inactive']) ?></td>
                          </tr>
                    </tbody>
              </table>
              <br>
              <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                <thead class="thead-light">
                  <tr>
                    <th>Kategori
                    <th>Jumlah Unit Aktif</th>
                    <th>Jumlah Unit Tidak Aktif</th>
                  </tr>
                </thead>
                <tbody>
                  <a style="margin-bottom: 10px;" href="<?= base_url() ?>vehicles/vehicles_management" class="btn btn-sm btn-outline-success">Detail Unit</a>
                      <tr>
                        <td>Unit Mobil</td>
                        <td class="text-success font-weight-bold"><?= esc($dashboard['tot_vehicles_active']) ?></td>
                        <td class="text-danger font-weight-bold"><?= esc($dashboard['tot_vehicles_inactive']) ?></td>
                      </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
    <!-- Geofence Status -->
    <!-- <div class="row">
      <div class="col-12">
        <div class="card shadow-sm mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Vehicle Ready Status</h6>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-hover" id="geofenceTable" width="100%" cellspacing="0">
                <thead class="thead-light">
                  <tr>
                    <th>Vehicle</th>
                    <th>Event</th>
                    <th>Geofence</th>
                    <th>Time</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if(!empty($geofenceevents)): ?>
                    <?php foreach($geofenceevents as $geofence): ?>
                    <tr>
                      <td><?= output($geofence['v_name']) ?></td>
                      <td>
                        <span class="badge badge-<?= $geofence['ge_event'] == 'inside' ? 'success' : 'warning' ?>">
                          <?= ucfirst($geofence['ge_event']) ?>
                        </span>
                      </td>
                      <td><?= $geofence['geo_name'] ?></td>
                      <td><?= output($geofence['ge_timestamp']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="4" class="text-center">No geofence events recorded</td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div> -->
    <div class="row">
          <div class="col-12">
        <div class="card shadow-sm mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Company Locations</h6>
          </div>
          <div class="card-body">
            <div class="mapouter"><div class="gmap_canvas"><iframe class="gmap_iframe" width="100%" height="330px"
             frameborder="0" scrolling="no" marginheight="0" marginwidth="0" 
             src="https://maps.google.com/maps?width=600&amp;height=330&amp;hl=en&amp;q=PT.SSH (POOL_YOS) SKAR SINDO HARAPAN&amp;t=&amp;z=15&amp;ie=UTF8&amp;iwloc=B&amp;output=embed">
            </iframe><a href="https://connectionssports.net/">Sports Connections</a></div><style>
              .mapouter{position:relative;text-align:right;width:100%;height:330px;}.gmap_canvas 
              {overflow:hidden;background:none!important;width:100%;height:330px;}.gmap_iframe 
              {height:330px!important;}</style></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= view('layout/footer') ?>

<!-- JavaScript Libraries -->
<script src="<?php echo base_url(); ?>assets/plugins/chart.js/Chart.min.js"></script>
<script src="<?= base_url('assets/autoLogout.js') ?>"></script>
<script>
  const baseUrl = "<?= base_url() ?>"; 
    enableAutoLogout(7200, baseUrl + "login");

// Hide loading overlay after full page load. Registered first so it always runs,
// even if a chart below fails to initialize (e.g. when a canvas is removed).
window.addEventListener('load', function() {
  var loader = document.getElementById('loading-screen');
  if (loader) {
    loader.classList.add('fade-out');
    setTimeout(function() {
      loader.style.display = 'none';
    }, 500);
  }
});

// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Income and Expenses Chart
var ctx = document.getElementById("ie-chart");
var ieChart = null;
if (ctx) {
ieChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: <?= "['" . implode("', '", array_keys($iechart)) . "']" ?>,
    datasets: [{
      label: "Income",
      lineTension: 0.3,
      backgroundColor: "rgba(40, 167, 69, 0.05)",
      borderColor: "rgba(40, 167, 69, 1)",
      pointRadius: 3,
      pointBackgroundColor: "rgba(40, 167, 69, 1)",
      pointBorderColor: "rgba(40, 167, 69, 1)",
      pointHoverRadius: 5,
      pointHoverBackgroundColor: "rgba(40, 167, 69, 1)",
      pointHoverBorderColor: "rgba(40, 167, 69, 1)",
      pointHitRadius: 10,
      pointBorderWidth: 2,
      data: <?= "['" . implode("', '", array_column($iechart, 'income')) . "']" ?>,
    },
    {
      label: "Expenses",
      lineTension: 0.3,
      backgroundColor: "rgba(220, 53, 69, 0.05)",
      borderColor: "rgba(220, 53, 69, 1)",
      pointRadius: 3,
      pointBackgroundColor: "rgba(220, 53, 69, 1)",
      pointBorderColor: "rgba(220, 53, 69, 1)",
      pointHoverRadius: 5,
      pointHoverBackgroundColor: "rgba(220, 53, 69, 1)",
      pointHoverBorderColor: "rgba(220, 53, 69, 1)",
      pointHitRadius: 10,
      pointBorderWidth: 2,
      data: <?= "['" . implode("', '", array_column($iechart, 'expense')) . "']" ?>,
    },
    {
      label: "Profit",
      lineTension: 0.3,
      backgroundColor: "rgba(54, 185, 204, 0.05)",
      borderColor: "rgba(54, 185, 204, 1)",
      pointRadius: 3,
      pointBackgroundColor: "rgba(54, 185, 204, 1)",
      pointBorderColor: "rgba(54, 185, 204, 1)",
      pointHoverRadius: 5,
      pointHoverBackgroundColor: "rgba(54, 185, 204, 1)",
      pointHoverBorderColor: "rgba(54, 185, 204, 1)",
      pointHitRadius: 10,
      pointBorderWidth: 2,
      data: [1500, 3200, 2800, 3900, 4200, 5100, 6000],
    }],
  },
  options: {
    maintainAspectRatio: false,
    layout: {
      padding: {
        left: 10,
        right: 25,
        top: 25,
        bottom: 0
      }
    },
    scales: {
      xAxes: [{
        gridLines: {
          display: false,
          drawBorder: false
        },
        ticks: {
          maxTicksLimit: 7
        }
      }],
      yAxes: [{
        ticks: {
          beginAtZero: true,
          padding: 10,
          callback: function(value) {
            return '$' + number_format(value);
          }
        },
        gridLines: {
          color: "rgb(234, 236, 244)",
          zeroLineColor: "rgb(234, 236, 244)",
          drawBorder: false,
          borderDash: [2],
          zeroLineBorderDash: [2]
        }
      }],
    },
    legend: {
      display: false
    },
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      titleMarginBottom: 10,
      titleFontColor: '#6e707e',
      titleFontSize: 14,
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      intersect: false,
      mode: 'index',
      caretPadding: 10,
      callbacks: {
        label: function(tooltipItem, chart) {
          var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
          return datasetLabel + ': $' + number_format(tooltipItem.yLabel);
        }
      }
    }
  }
});
}

// Status Pie Chart
var ctx2 = document.getElementById("statusPieChart");
var statusPieChart = null;
if (ctx2) {
statusPieChart = new Chart(ctx2, {
  type: 'doughnut',
  data: {
    labels: ["Idle", "In Trip", "Maintenance"],
    datasets: [{
      data: [55, 30, 15],
      backgroundColor: ['#1cc88a', '#4e73df', '#36b9cc'],
      hoverBackgroundColor: ['#17a673', '#2e59d9', '#2c9faf'],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: false
    },
    cutoutPercentage: 80,
  },
});
}

var ctx3 = document.getElementById("statusDriverChart");
var statusDriverChart = null;
if (ctx3) {
statusDriverChart = new Chart(ctx3, {
  type: 'doughnut',
  data: {
    labels: ["Idle", "In Trip", "Maintenance"],
    datasets: [{
      data: [55, 30, 15],
      backgroundColor: ['#1cc88a', '#4e73df', '#36b9cc'],
      hoverBackgroundColor: ['#17a673', '#2e59d9', '#2c9faf'],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: false
    },
    cutoutPercentage: 80,
  },
});
}

// Function to format numbers
function number_format(number, decimals, dec_point, thousands_sep) {
  number = (number + '').replace(',', '').replace(' ', '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}

// Initialize DataTables for better table experience
$(document).ready(function() {
  $('#vehicleLocationTable, #vehicleStatusTable, #geofenceTable').DataTable({
    "pageLength": 5,
    "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
    "language": {
      "search": "_INPUT_",
      "searchPlaceholder": "Search...",
      "lengthMenu": "Show _MENU_ entries",
      "info": "Showing _START_ to _END_ of _TOTAL_ entries",
      "infoEmpty": "Showing 0 to 0 of 0 entries",
      "infoFiltered": "(filtered from _MAX_ total entries)",
      "paginate": {
        "first": "First",
        "last": "Last",
        "next": "Next",
        "previous": "Previous"
      }
    }
  });


  
  // NOTE: theme toggle is handled globally by assets/js/theme-global.js (vanilla JS).
  // Recolor dashboard charts when the global theme changes (never breaks the toggle).
  function updateChartColorsSafe(theme) {
    try {
      var textColor = theme === 'dark' ? '#f8f9fc' : '#858796';
      var gridColor = theme === 'dark' ? '#454545' : 'rgb(234, 236, 244)';
      var tooltipBg = theme === 'dark' ? '#2d2d2d' : 'rgb(255,255,255)';
      var tooltipBorder = theme === 'dark' ? '#454545' : '#dddfeb';
      if (typeof ieChart !== 'undefined' && ieChart && ieChart.options) {
        var scales = ieChart.options.scales || {};
        if (scales.xAxes && scales.xAxes[0]) {
          scales.xAxes[0].ticks = scales.xAxes[0].ticks || {};
          scales.xAxes[0].gridLines = scales.xAxes[0].gridLines || {};
          scales.xAxes[0].ticks.fontColor = textColor;
          scales.xAxes[0].gridLines.color = gridColor;
        } else if (scales.x) {
          scales.x.ticks = scales.x.ticks || {};
          scales.x.grid = scales.x.grid || {};
          scales.x.ticks.color = textColor;
          scales.x.grid.color = gridColor;
        }
        if (scales.yAxes && scales.yAxes[0]) {
          scales.yAxes[0].ticks = scales.yAxes[0].ticks || {};
          scales.yAxes[0].gridLines = scales.yAxes[0].gridLines || {};
          scales.yAxes[0].ticks.fontColor = textColor;
          scales.yAxes[0].gridLines.color = gridColor;
        } else if (scales.y) {
          scales.y.ticks = scales.y.ticks || {};
          scales.y.grid = scales.y.grid || {};
          scales.y.ticks.color = textColor;
          scales.y.grid.color = gridColor;
        }
        if (typeof ieChart.update === 'function') ieChart.update();
      }
    } catch (e) { /* chart recolor must never break the page */ }
  }
  try {
    document.addEventListener('theme:changed', function (ev) {
      try { updateChartColorsSafe(ev && ev.detail ? ev.detail.theme : 'light'); } catch (e) {}
    });
  } catch (e) {}
  // Chart type toggle
  $('#toggle-chart-type').click(function(e) {
    e.preventDefault();
    var currentType = ieChart.config.type;
    var newType = currentType === 'line' ? 'bar' : 'line';
    ieChart.destroy();
    
    ieChart = new Chart(ctx, {
      type: newType,
      data: ieChart.data,
      options: ieChart.options
    });
    
    $(this).text(currentType === 'line' ? 'Switch to Line Chart' : 'Switch to Bar Chart');
  });
  
  // Refresh status button
  $('#refresh-status').click(function() {
    var $btn = $(this);
    var originalText = $btn.html();
    
    $btn.prop('disabled', true).html('<i class="fas fa-sync-alt fa-spin"></i> Refreshing...');
    
    // Simulate API call
    setTimeout(function() {
      $btn.prop('disabled', false).html(originalText);
      // In a real app, you would reload the data here
    }, 1500);
  });
  
  // Add animation to stats cards on scroll
  $('.stats-card').each(function() {
    $(this).appear(function() {
      $(this).addClass('animated fadeInUp');
    });
  });
});

</script>
<style>
:root {
  --primary: #4e73df;
  --success: #1cc88a;
  --info: #36b9cc;
  --warning: #f6c23e;
  --danger: #e74a3b;
  --secondary: #858796;
  --light: #f8f9fc;
  --dark: #5a5c69;
}

body.dark-mode {
  background-color: #1a1a1a;
  color: #f8f9fc;
}

body.dark-mode .card {
  background-color: #2d2d2d;
  color: #f8f9fc;
  border-color: #454545;
}

body.dark-mode .card-header {
  background-color: #2d2d2d;
  border-color: #454545;
  color: #f8f9fc;
}

body.dark-mode .card-footer {
  background-color: #2d2d2d;
  border-color: #454545;
}

body.dark-mode .table {
  color: #f8f9fc;
  background-color: #2d2d2d;
}

body.dark-mode .table td, 
body.dark-mode .table th {
  border-color: #454545;
  color: #f8f9fc;
}

body.dark-mode .thead-light th {
  background-color: #454545;
  color: #f8f9fc;
}

body.dark-mode .btn-outline-primary {
  color: #4e73df;
  border-color: #4e73df;
}

body.dark-mode .btn-outline-primary:hover {
  color: #fff;
  background-color: #4e73df;
}

body.dark-mode .btn-outline-secondary {
  color: #858796;
  border-color: #858796;
}

body.dark-mode .btn-outline-secondary:hover {
  color: #fff;
  background-color: #858796;
}

body.dark-mode .btn-outline-success {
  color: #1cc88a;
  border-color: #1cc88a;
}

body.dark-mode .btn-outline-success:hover {
  color: #fff;
  background-color: #1cc88a;
}

body.dark-mode .btn-outline-danger {
  color: #e74a3b;
  border-color: #e74a3b;
}

body.dark-mode .btn-outline-danger:hover {
  color: #fff;
  background-color: #e74a3b;
}

body.dark-mode .btn-outline-warning {
  color: #f6c23e;
  border-color: #f6c23e;
}

body.dark-mode .btn-outline-warning:hover {
  color: #fff;
  background-color: #f6c23e;
}

body.dark-mode .stats-card {
  background-color: #2d2d2d;
  border-left-color: #4e73df;
}

body.dark-mode .text-gray-800 {
  color: #f8f9fc !important;
}

body.dark-mode .text-gray-300 {
  color: #858796 !important;
}

body.dark-mode .text-primary {
  color: #6587d6 !important;
}

body.dark-mode .text-success {
  color: #3ae3a4 !important;
}

body.dark-mode .text-info {
  color: #65d5dd !important;
}

body.dark-mode .text-warning {
  color: #fae07b !important;
}

body.dark-mode .text-danger {
  color: #f1756b !important;
}

body.dark-mode .text-muted {
  color: #858796 !important;
}

body.dark-mode .bg-white {
  background-color: #2d2d2d !important;
}

body.dark-mode .chart-area canvas {
  background-color: #2d2d2d;
}

body.dark-mode .dropdown-menu {
  background-color: #2d2d2d;
  color: #f8f9fc;
  border-color: #454545;
}

body.dark-mode .dropdown-item {
  color: #f8f9fc;
}

body.dark-mode .dropdown-item:hover {
  background-color: #454545;
}

body.dark-mode .badge {
  background-color: #454545;
  color: #f8f9fc;
}

body.dark-mode .btn-sm {
  color: #f8f9fc;
  border-color: #454545;
}

body.dark-mode .btn-group .btn-outline-primary.active {
  color: #fff;
  background-color: #4e73df;
  border-color: #4e73df;
}

body.dark-mode .btn-group .btn-outline-primary:not(.active) {
  color: #f8f9fc;
  background-color: #2d2d2d;
  border-color: #454545;
}

body.dark-mode .btn-group .btn-outline-primary:not(.active):hover {
  color: #fff;
  background-color: #4e73df;
}

body.dark-mode .mr-3 {
  color: #f8f9fc;
}

/* AdminLTE Dark Mode Overrides */
body.dark-mode .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active,
body.dark-mode .sidebar-dark-primary .nav-sidebar > .nav-item.active > .nav-link {
  background-color: #4e73df;
  color: #fff;
}

body.dark-mode .sidebar-dark-primary .nav-treeview > .nav-item > .nav-link {
  color: #cfcfcf;
}

body.dark-mode .sidebar-dark-primary .nav-treeview > .nav-item > .nav-link:hover {
  background-color: #343a40;
  color: #fff;
}

body.dark-mode .sidebar-dark-primary .nav-header {
  color: #cfcfcf;
}

body.dark-mode .sidebar-dark-primary .user-panel .info {
  color: #cfcfcf;
}

body.dark-mode .main-footer {
  background-color: #2d2d2d;
  color: #cfcfcf;
  border-top-color: #454545;
}

body.dark-mode .navbar-dark {
  background-color: #343a40 !important;
}

body.dark-mode .navbar-dark .navbar-nav .nav-link {
  color: #cfcfcf !important;
}

body.dark-mode .wrapper {
  background-color: #1a1a1a;
}

.stats-card {
  transition: transform 0.3s;
}

.stats-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 0.5rem 2rem rgba(0, 0, 0, 0.15) !important;
}

.icon-circle {
  height: 2.5rem;
  width: 2.5rem;
  border-radius: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.reminder-item {
  transition: all 0.2s;
  border-left: 3px solid transparent;
}

.reminder-item:hover {
  background-color: #f8f9fc !important;
  border-left-color: var(--primary);
}

#theme-toggle {
  border-radius: 50%;
  width: 38px;
  height: 38px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.quick-actions .btn {
  border-radius: 20px;
  transition: all 0.3s;
}

.quick-actions .btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animated {
  animation-duration: 0.5s;
  animation-fill-mode: both;
}

.fadeInUp {
  animation-name: fadeInUp;
}

#vehicle-map {
  transition: all 0.3s;
}

#vehicle-map:hover {
  box-shadow: 0 0 15px rgba(78, 115, 223, 0.3);
}
</style>