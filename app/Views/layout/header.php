<?php
use CodeIgniter\HTTP\URI;

function activate_menu($controller)
{
    $uri = service('uri');
    $last = $uri->getTotalSegments();
    $seg = $uri->getSegment($last);

    if (is_numeric($seg)) {
        $seg = $uri->getSegment($last - 1);
    }

    return ($seg === $controller) ? 'active' : '';
}

$data = function_exists('sitedata') ? sitedata() : ['s_companyname' => 'App'];
$title = ucfirst(service('uri')->getSegment(1)) . ' | LogEx | ' . esc($data['s_companyname']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <!-- Global Theme anti-FOUC: apply dark-mode as early as possible (vanilla JS, no jQuery) -->
  <script>
  (function () {
    try {
      var saved = null;
      try { saved = localStorage.getItem('ssh_theme'); } catch (e) { saved = null; }
      if (!saved) { saved = '<?= esc(session()->get('theme') ?? 'light') ?>'; }
      if (saved === 'dark') {
        try { document.documentElement.classList.add('dark-mode-pre'); } catch (e) {}
        document.addEventListener('DOMContentLoaded', function () {
          try { document.body.classList.add('dark-mode'); } catch (e) {}
        });
      }
    } catch (e) {}
  })();
  </script>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title><?= $title ?></title>

  <!-- Favicon -->
  <link rel="icon" href="<?= base_url('assets/uploads/Icon SSH.png'); ?>" type="image/x-icon">

  <!-- CSS Dependencies -->
  <link rel="stylesheet" href="<?= base_url('assets/plugins/fontawesome-free/css/all.min.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/dist/css/customnew.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/dark-mode-global.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/plugins/daterangepicker/daterangepicker.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/plugins/datepicker/bootstrap-datepicker.min.css'); ?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/plugins/toast/toast.min.css'); ?>" />
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <!-- JS Dependencies -->
  <script src="<?= base_url('assets/plugins/jquery/jquery.min.js'); ?>"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="<?= base_url('assets/plugins/toast/toast.min.js'); ?>"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-dark theme-navbar-primary">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <!-- Base URL hidden input -->
  <input type="hidden" id="base" value="<?= base_url(); ?>">

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <li class="nav-item d-flex align-items-center mr-2">
      <button type="button" id="theme-toggle-global" class="btn btn-sm btn-outline-light" title="Toggle dark / light mode" aria-label="Toggle dark mode">
        <i class="fas fa-moon"></i>
      </button>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="<?= site_url('/logout'); ?>">
        <?= esc(session()->get('name') ?? '') ?>
        <i class="fas fa-sign-out-alt"></i>
      </a>
    </li>
  </ul>
</nav>
<!-- /.navbar -->

<!-- Flash success message -->
<?php if (session()->getFlashdata('successmessage')): ?>
  <div class="php-notification success" style="
    position: fixed;
    top: 70px;
    right: -400px;
    padding: 15px;
    background: #28a745; /* Hijau untuk success */
    color: white;
    border-radius: 4px;
    z-index: 9999;
    animation: slideInOut 7s forwards;">
    <?= esc(session()->getFlashdata('successmessage')) ?>
  </div>
<?php endif; ?>

<!-- Flash warning message -->
<?php if (session()->getFlashdata('warningmessage')): ?>
  <div class="php-notification" style="
    position: fixed;
    top: 70px;
    right: -400px;
    padding: 15px;
    background: #dc3545;
    color: white;
    border-radius: 4px;
    z-index: 9999;
    animation: slideInOut 7s forwards;">
    <?= esc(session()->getFlashdata('warningmessage')) ?>
  </div>
<?php endif; ?>