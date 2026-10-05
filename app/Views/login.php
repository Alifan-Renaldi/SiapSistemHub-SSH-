<?php
$system_name   = config('App')->systemName ?? 'LogEx';
$company_name  = config('App')->companyName ?? 'Siapp System Hub';
$s_companyname = config('App')->sCompanyName ?? 'SSH Group';

$loading_logo = 'assets/uploads/Icon SSH.png';
if (!file_exists(FCPATH . $loading_logo)) {
   $loading_logo = 'assets/uploads/Icon SSH.png'; // Fallback to default icon
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= esc($system_name) ?> | <?= esc($company_name) ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Favicon -->
  <link rel="icon" href="<?= base_url('assets/uploads/Icon SSH.png'); ?>" type="image/png">

  <!-- CSS Dependencies -->
  <link rel="stylesheet" href="<?= base_url('assets/plugins/fontawesome-free/css/all.min.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/dist/css/adminlte.min.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/dist/css/customlogin.css'); ?>">
  <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #ebebeb; /* Light gray background to match image */
            
        }
        .outer-card {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            border-color: #d1d5db; /* gray-300 */
        }
        /* HTML: <div class="curved-edge"></div> */
        .curved-edge {
          --c: 50px; /* control the curvature (works with percentage) */
          height: 100%;
          width: 100%;
          /* you can also update the 60%  */
          mask: radial-gradient(60% var(--c) at bottom,#0000 calc(100% - 5px),#000);
          background: #ef1c25;
          
        }

        /* Premium Loading Screen Overlay CSS */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.671);
            z-index: 999999;
            display: none;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.4s ease, visibility 0.4s ease;
        }
        .loading-overlay.active {
            display: flex;
            opacity: 1;
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
        }
        .loading-subtext {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.55);
            margin-top: 6px;
            letter-spacing: 0.02em;
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
</head>
<body>
  <div>
    <div id="loading-screen" class="loading-overlay">
    <div class="loader-container">
      <div class="loader-spinner">
        <img src="<?= base_url('assets/uploads/Icon SSH.png') ?>" alt="Logo" class="loading-logo">
      </div>
      <!-- <div class="loading-text">Mempersiapkan Sistem</div>
      <div class="loading-subtext">Mohon tunggu sebentar, sedang mengalihkan ke dashboard...</div> -->
    </div>
  </div>

      <div class="hold-transition login-page flex flex-col items-center justify-center" style="background-color: #1B134F;">
        <!-- Alerts Container -->
        <div class="w-full max-w-[900px]">
            <?php if (session()->getFlashdata('successmessage')) : ?>
            <div class="alert alert-success alert-dismissible fade show">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <i class="fas fa-check-circle"></i> <?= esc(session()->getFlashdata('successmessage')) ?>
            </div>
            <?php endif; ?>

            <?php if (isset($error) || session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger alert-dismissible fade show shake">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <i class="fas fa-ban"></i> <?= esc(isset($error) ? $error : session()->getFlashdata('error')) ?>
            </div>
            <?php endif; ?>
        </div>

        <div class="curved-edge flex flex-col items-center justify-center">
        <!-- Card Container -->
        <div class="flex flex-col md:flex-row w-full max-w-[900px] bg-white rounded-[24px] overflow-hidden border outer-card relative min-h-[500px] <?= (isset($error) || session()->getFlashdata('error')) ? 'shake' : '' ?>">

            <!-- Left Side: Graphic -->
            <div class="w-full md:w-1/2 flex items-center justify-center p-8 relative">
                <img src="<?= base_url('assets/uploads/gambar grafis truck.png') ?>" alt="SSH Truck Graphic" class="max-w-full h-auto">
            </div>

            <!-- Right Side: Login Form Box -->
            <div class="w-full md:w-1/2 flex items-center justify-center p-6 md:p-10">
                <!-- Inner bordered box matching the sketch -->
                <div class="w-full h-full border border-black rounded-[16px] p-8 flex flex-col justify-center max-w-[360px]">
                    
                    <div class="text-center mb-10">
                        <h2 class="text-[32px] font-bold text-black leading-tight mb-2 tracking-tight">Welcome</h2>
                        <p class="text-[15px] font-bold text-black tracking-tight">Login to SSH (Siapp System Hub)</p>
                    </div>
                    <form method="post" action="<?= base_url('login/auth'); ?>">
                      <?= csrf_field() ?>
                      <div class="input-group mb-4">
                        <input type="text" name="username" required class="form-control" placeholder="Username" value="<?= old('username') ?>" autocomplete="username">
                        <div class="input-group-append">
                          <div class="input-group-text"><i class="fas fa-user"></i></div>
                        </div>
                      </div>
                      <div class="input-group mb-4">
                        <input type="password" id="lihatPassword" name="password" class="form-control" placeholder="Password" autocomplete="current-password">
                        <div class="input-group-append" style="cursor: pointer;" onclick="lihatPassword()">
                          <div class="input-group-text"><i class="fa fa-eye" id="eyeIcon"></i></div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12">
                          <button type="submit" class="btn btn-primary btn-block">SIGN IN</button>
                        </div>
                      </div>
                    </form>
                </div>
            </div>
        </div>
      </div>
      <div class="text-center text-sm font-bold text-black tracking-wide" style="margin-bottom: 50px;color: #ffff;">
          &copy; <?= date('Y') ?> <?= esc($company_name) ?> - version 1.9.3
      </div>

<script src="<?= base_url('assets/plugins/jquery/jquery.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<script>
  $(function() {
    setTimeout(() => { $('.alert').alert('close'); }, 5000);
    <?php if (isset($error) || session()->getFlashdata('error')) : ?>
      $('input[name="username"]').focus();
    <?php endif; ?>

    $('form').on('submit', function() {
      $('#loading-screen').addClass('active');
    });
  });
  
  function lihatPassword()
  {
    var passwordInput = document.getElementById("lihatPassword");
    var eyeIcon = document.getElementById("eyeIcon");
    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      eyeIcon.classList.remove('fa-eye');
      eyeIcon.classList.add('fa-eye-slash');
    }
    else{
      passwordInput.type = "password";
      eyeIcon.classList.remove('fa-eye-slash');
      eyeIcon.classList.add('fa-eye');
    }
  }
</script>

</body>
</html>
