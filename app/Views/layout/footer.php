<footer class="main-footer">
  <div class="container-fluid">
    <div class="d-flex flex-md-row justify-content-between">
      <div class="mb-2 mb-md-0 text-md-left">
        <strong>Developed By <a href="https://s.id/sshhelp" target="_blank">IT SSH Group</a>.</strong>
      </div>
      <div class="text-md-right">
        <b>v</b>1.9.2
      </div>
    </div>
  </div>
</footer>

<!-- JS Libraries -->
<script src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?= base_url('assets/dist/js/adminlte.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/jquery-validation/jquery.validate.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js'); ?>"></script>
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables-bs4/css/customstyle.dataTables.css'); ?>">
<script src="<?= base_url('assets/plugins/moment/moment.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/daterangepicker/daterangepicker.js'); ?>"></script>
<script src="<?= base_url('assets/jscolor.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/selectize.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/datepicker/bootstrap-datepicker.min.js'); ?>"></script>

<!-- SweetAlert Toasts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
<?php if (session()->getFlashdata('successmessage')) : ?>
  Swal.fire({
    toast: true,
    position: 'top',
    icon: 'success',
    title: '<?= esc(session()->getFlashdata('successmessage')) ?>',
    showConfirmButton: false,
    timer: 5000
  });
<?php elseif (session()->getFlashdata('warningmessage')) : ?>
  Swal.fire({
    toast: true,
    position: 'top',
    icon: 'error',
    title: '<?= esc(session()->getFlashdata('warningmessage')) ?>',
    showConfirmButton: false,
    timer: 5000
  });
<?php endif; ?>
</script>

<?php
$uri = service('uri');
$last = $uri->getTotalSegments();
$seg = $uri->getSegment($last);
if (is_numeric($seg)) {
    $seg = $uri->getSegment($last - 1);
}
?>

<?php if (in_array($seg, ['booking', 'incomeexpense', 'fuels'])) : ?>
  <script src="<?= base_url('assets/plugins/datatables/dataTables.buttons.min.js'); ?>"></script>
  <script src="<?= base_url('assets/plugins/datatables/jszip.min.js'); ?>"></script>
  <script src="<?= base_url('assets/plugins/datatables/pdfmake.min.js'); ?>"></script>
  <script src="<?= base_url('assets/plugins/datatables/vfs_fonts.js'); ?>"></script>
  <script src="<?= base_url('assets/plugins/datatables/buttons.html5.min.js'); ?>"></script>
<?php endif; ?>

<?php if (in_array($seg, ['addgeofence', 'addtrips', 'geofence', 'livestatus', 'tracking'])) :
  $data = function_exists('sitedata') ? sitedata() : ['s_googel_api_key' => ''];
?>
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
  <script type="text/javascript"
    src="https://maps.google.com/maps/api/js?key=<?= esc($data['s_googel_api_key']) ?>&sensor=false&v=3.21.5a&libraries=drawing&signed_in=true&libraries=places,drawing">
  </script>
  <script src="<?= base_url('assets/distance_calculator.js'); ?>"></script>
<?php endif; ?>

<script src="<?= base_url('assets/custom.js?v=' . mt_rand()); ?>"></script>
<script src="<?= base_url('assets/js/theme-global.js'); ?>"></script>

<?php if ($seg === 'addgeofence') : ?>
  <script src="<?= base_url('assets/geofence.js'); ?>"></script>
  <link rel="stylesheet" href="<?= base_url('assets/plugins/select2/css/select2.min.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/plugins/select2/css/select2-bootstrap4.min.css'); ?>">
  <script src="<?= base_url('assets/plugins/select2/js/select2.full.min.js'); ?>"></script>
  <script>
    $('.select2').select2()
  </script>
<?php endif; ?>
</body>
</html>
