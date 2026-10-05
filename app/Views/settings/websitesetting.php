<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <style>
        .content-header {
            background-color: #f8f9fa;
            padding: 15px 0;
            margin-bottom: 20px;
        }
        .card {
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .bg-gradient-success {
            background-color: #28a745;
            color: white;
            padding: 5px;
            border-radius: 3px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h2>Settings</h2>
                </div>
                <div class="col-sm-6">
                     <ol class="breadcrumb float-sm-right bg-light p-2 rounded">
                            <li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
                            <li class="breadcrumb-item active">Settings</li>
                        </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <?php if (session()->has('successmessage')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session('successmessage') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <?php if (session()->has('warningmessage')): ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <?= session('warningmessage') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <?php if (isset($validation)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $validation->listErrors() ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Website Setting</h3>
                </div>
                <form id="addnewcategory" method="post" action="<?= base_url('settings/websitesetting_save') ?>" class="col-md-12" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6 col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Company Name</label>
                                    <input type="text" class="form-control" required value="<?= isset($website_setting[0]['s_companyname']) ? esc($website_setting[0]['s_companyname']) : '' ?>" id="s_companyname" name="s_companyname" placeholder="Enter Company Name">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control" required value="<?= isset($website_setting[0]['s_address']) ? esc($website_setting[0]['s_address']) : '' ?>" id="s_address" name="s_address" placeholder="Enter Address">
                                </div>
                            </div>
                            <!-- <div class="col-sm-6 col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Google API Key</label>
                                    <input type="text" class="form-control" required value="<?= isset($website_setting[0]['s_googel_api_key']) ? esc($website_setting[0]['s_googel_api_key']) : '' ?>" id="s_googel_api_key" name="s_googel_api_key" placeholder="Enter Google API Key">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Invoice Prefix</label>
                                    <input type="text" class="form-control" required value="<?= isset($website_setting[0]['s_inovice_prefix']) ? esc($website_setting[0]['s_inovice_prefix']) : '' ?>" id="s_inovice_prefix" name="s_inovice_prefix" placeholder="Enter Invoice Prefix">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Currency Prefix</label>
                                    <input type="text" class="form-control" required value="<?= isset($website_setting[0]['s_price_prefix']) ? esc($website_setting[0]['s_price_prefix']) : '' ?>" id="s_price_prefix" name="s_price_prefix" placeholder="Enter Currency Prefix">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Invoice Terms and condition</label>
                                    <textarea id="s_inovice_termsandcondition" name="s_inovice_termsandcondition" rows="4" class="form-control" required placeholder="Enter Terms and Condition"><?= isset($website_setting[0]['s_inovice_termsandcondition']) ? esc($website_setting[0]['s_inovice_termsandcondition']) : '' ?></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Invoice Service Name</label>
                                    <input type="text" class="form-control" required value="<?= isset($website_setting[0]['s_inovice_servicename']) ? esc($website_setting[0]['s_inovice_servicename']) : '' ?>" id="s_inovice_servicename" name="s_inovice_servicename" placeholder="Invoice Service Name">
                                </div>
                            </div> -->
                            <div class="col-sm-6 col-md-4">
                                <div class="mb-3">
                                    <label for="file" class="form-label">Logo</label>
                                    <input type="file" class="form-control" id="file" name="file" <?= (isset($website_setting[0]['s_logo']) && $website_setting[0]['s_logo'] != '') ? 'disabled' : '' ?>>
                                    <div class="form-text">Image should be 50x50px and in PNG format</div>
                                </div>
                                <?php if (isset($website_setting[0]['s_logo']) && $website_setting[0]['s_logo'] != ''): ?>
                                    <div class="mt-2">
                                        <img src="<?= base_url('assets/uploads/' . $website_setting[0]['s_logo']) ?>" alt="Logo" height="50" width="50" class="img-thumbnail me-2">
                                        <button type="button" class="btn btn-danger btn-sm logodelete">Delete</button>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="btn-block text-end mt-3">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Bootstrap & jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    $(document).ready(function() {
        // Handle logo delete
        $('.logodelete').click(function() {
            if (confirm('Are you sure you want to delete the logo?')) {
                $.post('<?= base_url('settings/logodelete') ?>', function(response) {
                    if (response) {
                        location.reload();
                    }
                });
            }
        });
        
        // Form validation
        $('#addnewcategory').submit(function() {
            let valid = true;
            $('.form-control:required').each(function() {
                if ($(this).val() === '') {
                    $(this).addClass('is-invalid');
                    valid = false;
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
            return valid;
        });
    });
    </script>
</body>
</html>

<?= view('layout/footer') ?>