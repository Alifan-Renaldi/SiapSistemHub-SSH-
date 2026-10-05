<?php
use CodeIgniter\HTTP\URI;

$data = function_exists('sitedata') ? sitedata() : ['s_logo' => 'default.png'];

$uri = service('uri');
$segments = $uri->getSegments();
$firstSegment = $segments[0] ?? 'dashboard';
$secondSegment = $segments[1] ?? '';

?>

<aside class="main-sidebar elevation-4 sidebar-dark-warning">
  <a href="<?= base_url('dashboard'); ?>" class="brand-link">
    <img src="<?= base_url('assets/uploads/' . $data['s_logo']); ?>" class="brand-image img-circle elevation-1 frlogo">
    <span class="brand-text font-weight-bold">Siapp System Hub</span>
  </a>

  <div class="sidebar">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="<?= base_url('dashboard'); ?>" class="nav-link <?= ($firstSegment === 'dashboard') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <?php if (function_exists('userpermission') && userpermission('lr_drivers_mgmt')) : ?>
        <li class="nav-item has-treeview <?= ($firstSegment === 'drivers' || $firstSegment === 'baps' || $firstSegment === 'surveys' || $firstSegment === 'trainings' || $firstSegment === 'loans') ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?= ($firstSegment === 'drivers' || $firstSegment === 'baps' || $firstSegment === 'surveys' || $firstSegment === 'trainings' || $firstSegment === 'loans') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-user-secret"></i>
            <p>
              Driver Management
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <?php endif; ?>

          
          <ul class="nav nav-treeview">
            <?php if (function_exists('userpermission') && userpermission('lr_drivers_list')) : ?>
            <li class="nav-item">
              <a href="<?= base_url('drivers/drivers_management'); ?>"
                class="nav-link <?= ($firstSegment === 'drivers' && in_array($secondSegment, ['drivers_management', 'adddrivers', 'editdriver', 'viewdriver'])) ? 'active' : '' ?>">
                <span class="nav-icon" style="width: 2.25rem; display: inline-block;"></span>
                <p>Driver List</p>
              </a>
            </li>
            <?php endif; ?>
            <?php if (function_exists('userpermission') && userpermission('lr_drivers_list_inactive')) : ?>
            <li class="nav-item">
              <a href="<?= base_url('drivers/drivers_inactive'); ?>"
                class="nav-link <?= ($firstSegment === 'drivers' && in_array($secondSegment, ['drivers_inactive', 'viewdriver_inactive', 'adddriversblacklist', 'editdriverblacklist'])) ? 'active' : '' ?>">
                <span class="nav-icon" style="width: 2.25rem; display: inline-block;"></span>
                <p>Inactive / Blacklist</p>
              </a>
            </li>
            <?php endif; ?>
            <?php if (function_exists('userpermission') && userpermission('lr_drivers_list_bap')) : ?>
            <li class="nav-item">
              <a href="<?= base_url('baps/bap_management'); ?>"
                class="nav-link <?= ($firstSegment === 'baps' && in_array($secondSegment, ['bap_management', 'bap_pending', 'addbap', 'editbap', 'bap_view', 'editbap_pending', 'bap_pendingview'])) ? 'active' : '' ?>">
                <span class="nav-icon" style="width: 2.25rem; display: inline-block;"></span>
                <p>BAP</p>
              </a>
            </li>
            <?php endif; ?>
            <?php if (function_exists('userpermission') && userpermission('lr_drivers_list_survey')) : ?>
            <li class="nav-item">
              <a href="<?= base_url('surveys/survey_management'); ?>"
                class="nav-link <?= ($firstSegment === 'surveys' && in_array($secondSegment, ['survey_management', 'addsurvey', 'editsurvey', 'survey_view'])) ? 'active' : '' ?>">
                <span class="nav-icon" style="width: 2.25rem; display: inline-block;"></span>
                <p>Survey</p>
              </a>
            </li>
            <?php endif; ?>
            <?php if (function_exists('userpermission') && userpermission('lr_drivers_list_training')) : ?>
            <li class="nav-item">
              <a href="<?= base_url('trainings/training_management'); ?>"
                class="nav-link <?= ($firstSegment === 'trainings' && in_array($secondSegment, ['training_management', 'addtraining', 'edittraining', 'viewtraining'])) ? 'active' : '' ?>">
                <span class="nav-icon" style="width: 2.25rem; display: inline-block;"></span>
                <p>Training</p>
              </a>
            </li>
            <?php endif; ?>
            <?php if (function_exists('userpermission') && userpermission('lr_drivers_list_loan')) : ?>
            <li class="nav-item">
              <a href="<?= base_url('loans/loan_management'); ?>"
                class="nav-link <?= ($firstSegment === 'loans' && in_array($secondSegment, ['loan_management', 'addloan', 'editloan', 'viewloan', 'loan_approve'])) ? 'active' : '' ?>">
                <span class="nav-icon" style="width: 2.25rem; display: inline-block;"></span>
                <p>Loan</p>
              </a>
            </li>
            <?php endif; ?>
          </ul>
        </li>

        <?php if (function_exists('userpermission') && userpermission('lr_vech_mgmt')) : ?>
        <li class="nav-item has-treeview <?= ($firstSegment === 'vehicles' || $firstSegment === 'inventory' || $firstSegment === 'handover') ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?= ($firstSegment === 'vehicles' || $firstSegment === 'inventory' || $firstSegment === 'handover') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-truck"></i>
            <p>
              Vehicle Management
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <?php endif; ?>

         
          <ul class="nav nav-treeview">
             <?php if (function_exists('userpermission') && userpermission('lr_vech_list')) : ?>
            <li class="nav-item">
              <a href="<?= base_url('vehicles/vehicles_management'); ?>"
                class="nav-link <?= ($firstSegment === 'vehicles' && in_array($secondSegment, ['vehicles_management', 'vehiclegroup', 'vehicleowner', 'addvehicle', 'editvehicle', 'viewvehicle'])) ? 'active' : '' ?>">
                <span class="nav-icon" style="width: 2.25rem; display: inline-block;"></span>
                <p>Vehicle List</p>
              </a>
            </li>
             <?php endif; ?>

            <?php if (function_exists('userpermission') && userpermission('lr_vech_list_invent')) : ?>
            <li class="nav-item">
              <a href="<?= base_url('inventory/inventory_management'); ?>"
                class="nav-link <?= ($firstSegment === 'inventory' && in_array($secondSegment, ['inventory_management', 'addinventory', 'editinventory', 'inventory_view'])) ? 'active' : '' ?>">
                <span class="nav-icon" style="width: 2.25rem; display: inline-block;"></span>
                <p>Inventory</p>
              </a>
            </li>
            <?php endif; ?>

            <?php if (function_exists('userpermission') && userpermission('lr_vech_handover_list')) : ?>
            <li class="nav-item">
              <a href="<?= base_url('handover/handover_management'); ?>"
                class="nav-link <?= ($firstSegment === 'handover' && in_array($secondSegment, ['handover_management', 'addhandover', 'edithandover', 'handover_view', 'viewhandoverinventory', 'edithandoverinventory', 'preview'])) ? 'active' : '' ?>">
                <span class="nav-icon" style="width: 2.25rem; display: inline-block;"></span>
                <p>Handover</p>
              </a>
            </li>
            <?php endif; ?>

            <?php if (function_exists('userpermission') && userpermission('lr_vech_tire')) : ?>
            <li class="nav-item">
              <a href="<?= base_url('form_information'); ?>"
                class="nav-link <?= ($firstSegment === 'vehicle' && in_array($secondSegment, ['tireservice', 'add_tireservice', 'edit_tireservice', 'view_tireservice'])) ? 'active' : '' ?>">
                <span class="nav-icon" style="width: 2.25rem; display: inline-block;"></span>
                <p>Tire Service</p>
              </a>
            </li>
            <?php endif; ?>
          </ul>
          
       

        <?php if (function_exists('userpermission') && userpermission('lr_trips_list')) : ?>
        <li class="nav-item has-treeview <?= ($firstSegment === 'ops') ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?= ($firstSegment === 'ops') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-road"></i>
            <p>
              Operational Support
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= base_url('form_information'); ?>"
                class="nav-link <?= ($firstSegment === 'ops' && in_array($secondSegment, ['vehicles_management', 'vehiclegroup', 'vehicleowner', 'addvehicle', 'editvehicle', 'viewvehicle'])) ? 'active' : '' ?>">
                <span class="nav-icon" style="width: 2.25rem; display: inline-block;"></span>
                <p>Vehicle Ready</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('form_information'); ?>"
                class="nav-link <?= ($firstSegment === 'vehicle' && in_array($secondSegment, ['vehicleinventory', 'addvehicle_inventory', 'editvehicle_inventory', 'viewvehicle_inventory'])) ? 'active' : '' ?>">
                <span class="nav-icon" style="width: 2.25rem; display: inline-block;"></span>
                <p>Driver Ready</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('form_information'); ?>"
                class="nav-link <?= ($firstSegment === 'vehicle' && in_array($secondSegment, ['vehiclehandover', 'addvehicle_handover', 'editvehicle_handover', 'viewvehicle_handover'])) ? 'active' : '' ?>">
                <span class="nav-icon" style="width: 2.25rem; display: inline-block;"></span>
                <p>Unit Status</p>
              </a>
            </li>
          </ul>
        </li>
        <?php endif; ?>

        <?php if (function_exists('userpermission') && userpermission('lr_mech_mgmt')) : ?>
        <li class="nav-item has-treeview <?= ($firstSegment === 'incentive') ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?= ($firstSegment === 'incentive') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-wrench"></i>
            <p>
              Workshop Management
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <?php endif; ?>

            <ul class="nav nav-treeview">
            <?php if (function_exists('userpermission') && userpermission('lr_mech_list')) : ?>
            <li class="nav-item">
              <a href="<?= base_url('mechanics/incentive_management'); ?>"
                class="nav-link <?= ($firstSegment === 'incentive' && in_array($secondSegment, ['incentive_management', 'addincentive', 'editincentive', 'viewincentive', 'deleteincentive'])) ? 'active' : '' ?>">
                <span class="nav-icon" style="width: 2.25rem; display: inline-block;"></span>
                <p>Mechanic Incentive</p>
              </a>
            </li>
            <?php endif; ?>
          </ul>
        </li>

        <?php if (function_exists('userpermission') && userpermission('lr_reports')) : ?>
        <li class="nav-item has-treeview <?= ($firstSegment === 'reports') ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?= ($firstSegment === 'reports') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-file-invoice"></i>
            <p>
              Report
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <?php endif; ?>
          
          <ul class="nav nav-treeview">
            <?php if (function_exists('userpermission') && userpermission('lr_reports_driver')) : ?>
            <li class="nav-item">
              <a href="<?= base_url('reports/driver'); ?>"
                class="nav-link <?= ($firstSegment === 'reports' && $secondSegment === 'driver') ? 'active' : '' ?>">
                <span class="nav-icon" style="width: 2.25rem; display: inline-block;"></span>
                <p>Driver</p>
              </a>
            </li>
            <?php endif; ?>
            <?php if (function_exists('userpermission') && userpermission('lr_reports_bap')) : ?>
            <li class="nav-item">
              <a href="<?= base_url('reports/bap'); ?>"
                class="nav-link <?= ($firstSegment === 'reports' && $secondSegment === 'bap') ? 'active' : '' ?>">
                <span class="nav-icon" style="width: 2.25rem; display: inline-block;"></span>
                <p>BAP</p>
              </a>
            </li>
            <?php endif; ?>
            <?php if (function_exists('userpermission') && userpermission('lr_reports_laka')) : ?>
            <li class="nav-item">
              <a href="<?= base_url('reports/laka'); ?>"
                class="nav-link <?= ($firstSegment === 'reports' && $secondSegment === 'laka') ? 'active' : '' ?>">
                <span class="nav-icon" style="width: 2.25rem; display: inline-block;"></span>
                <p>Lakalantas</p>
              </a>
            </li>
            <?php endif; ?>
            <?php if (function_exists('userpermission') && userpermission('lr_reports_survey')) : ?>
            <li class="nav-item">
              <a href="<?= base_url('reports/survey'); ?>"
                class="nav-link <?= ($firstSegment === 'reports' && $secondSegment === 'survey') ? 'active' : '' ?>">
                <span class="nav-icon" style="width: 2.25rem; display: inline-block;"></span>
                <p>Survey</p>
              </a>
            </li>
            <?php endif; ?>
            <?php if (function_exists('userpermission') && userpermission('lr_reports_training')) : ?>
            <li class="nav-item">
              <a href="<?= base_url('reports/training'); ?>"
                class="nav-link <?= ($firstSegment === 'reports' && $secondSegment === 'training') ? 'active' : '' ?>">
                <span class="nav-icon" style="width: 2.25rem; display: inline-block;"></span>
                <p>Training</p>
              </a>
            </li>
            <?php endif; ?>
            <?php if (function_exists('userpermission') && userpermission('lr_reports_loan')) : ?>
            <li class="nav-item">
              <a href="<?= base_url('reports/loan'); ?>"
                class="nav-link <?= ($firstSegment === 'reports' && $secondSegment === 'loan') ? 'active' : '' ?>">
                <span class="nav-icon" style="width: 2.25rem; display: inline-block;"></span>
                <p>Loan</p>
              </a>
            </li>
            <?php endif; ?>
            <?php if (function_exists('userpermission') && userpermission('lr_reports_vehicle')) : ?>
            <li class="nav-item">
              <a href="<?= base_url('reports/vehicle'); ?>"
                class="nav-link <?= ($firstSegment === 'reports' && $secondSegment === 'vehicle') ? 'active' : '' ?>">
                <span class="nav-icon" style="width: 2.25rem; display: inline-block;"></span>
                <p>Vehicle</p>
              </a>
            </li>
            <?php endif; ?>
            <?php if (function_exists('userpermission') && userpermission('lr_reports_inventory')) : ?>
            <li class="nav-item">
              <a href="<?= base_url('reports/inventory'); ?>"
                class="nav-link <?= ($firstSegment === 'reports' && $secondSegment === 'inventory') ? 'active' : '' ?>">
                <span class="nav-icon" style="width: 2.25rem; display: inline-block;"></span>
                <p>Inventory</p>
              </a>
            </li>
            <?php endif; ?>
            <?php if (function_exists('userpermission') && userpermission('lr_reports_handover')) : ?>
            <li class="nav-item">
              <a href="<?= base_url('reports/handover'); ?>"
                class="nav-link <?= ($firstSegment === 'reports' && $secondSegment === 'handover') ? 'active' : '' ?>">
                <span class="nav-icon" style="width: 2.25rem; display: inline-block;"></span>
                <p>Handover</p>
              </a>
            </li>
            <?php endif; ?>
          </ul>
        </li>
 
        <?php if (function_exists('userpermission') && userpermission('lr_list_user')) : ?>
        <li class="nav-item has-treeview <?= ($firstSegment === 'users' || $firstSegment === 'adduser' || $firstSegment === 'edituser') ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?= ($firstSegment === 'users' || $firstSegment === 'adduser' || $firstSegment === 'edituser') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-user-cog"></i>
            <p>
              User Management
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= base_url('users/user_management'); ?>"
                class="nav-link <?= ($firstSegment === 'users' && in_array($secondSegment,['user_management', 'adduser', 'edituser'])) ? 'active' : '' ?>">
                <span class="nav-icon" style="width: 2.25rem; display: inline-block;"></span>
                <p>User List</p>
              </a>
            </li>
          </ul>
        </li>
        <?php endif; ?>

        <?php if (function_exists('userpermission') && userpermission('lr_settings')) : ?>
        <li class="nav-item has-treeview <?= ($firstSegment === 'settings') ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?= ($firstSegment === 'settings') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-tools"></i>
            <p>
              Setting
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= base_url('settings/websitesetting'); ?>"
                class="nav-link <?= ($firstSegment === 'settings' && $secondSegment === 'websitesetting') ? 'active' : '' ?>">
                <span class="nav-icon" style="width: 2.25rem; display: inline-block;"></span>
                <p>General Settings</p>
              </a>
            </li>
            <!-- <li class="nav-item">
              <a href="<?= base_url('settings/smtpconfig'); ?>"
                class="nav-link <?= ($firstSegment === 'settings' && $secondSegment === 'smtpconfig') ? 'active' : '' ?>">
                <span class="nav-icon" style="width: 2.25rem; display: inline-block;"></span>
                <p>SMTP Configuration</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('settings/email_template'); ?>"
                class="nav-link <?= ($firstSegment === 'settings' && $secondSegment === 'email_template') ? 'active' : '' ?>">
                <span class="nav-icon" style="width: 2.25rem; display: inline-block;"></span>
                <p>Email Template</p>
              </a>
            </li> -->
          </ul>
        </li>
        <?php endif; ?>
      </ul>
    </nav>
  </div>
</aside>
<div class="content-wrapper pb-2 mb-0">