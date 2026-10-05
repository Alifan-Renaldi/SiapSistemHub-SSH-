<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<?= $this->section('content') ?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>404 Error Page</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                    <li class="breadcrumb-item active">404 Error Page</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<br><br><br>

<section class="content">
    <div class="error-page">
        <h2 class="headline text-warning">404</h2>
        <br><br>
        <div class="error-content">
            <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found.</h3>
            <p>
                We could not find the page you were looking for.
                Meanwhile, you may <a href="<?= base_url() ?>">return to dashboard</a> or try using the search form.
            </p>
        </div>
    </div>
</section>
<?= view('layout/footer') ?>

<?= $this->endSection() ?>