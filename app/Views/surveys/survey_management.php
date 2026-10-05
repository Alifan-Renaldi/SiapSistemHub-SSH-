<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>
<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Survey List</h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
               <li class="breadcrumb-item active">Survey</li>
            </ol>
         </div>
      </div>
   </div>
</div>
<section class="content">
   <div class="container-fluid">
      <div class="card">
         <div class="d-flex align-items-center justify-content-between p-3">
            <?php if (function_exists('userpermission') && userpermission('lr_drivers_add_survey')) : ?>
            <a href="<?= base_url('surveys/addsurvey'); ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Survey</a>
            <?php endif; ?>
            <div id="table-filter" class="d-flex align-items-center">
                <span class="mr-2">Search:</span>
            </div>
         </div>
         <div class="card-body p-0">
            <div class="table-responsive">
               <table id="driverslisttbl" class="table card-table table-vcenter text-nowrap">
                  <thead>
                     <tr>
                        <th class="w-1">No</th>
                        <th>Tanggal Survei</th>
                        <th>Nama Supir</th>
                        <th>Nama Istri</th>
                        <?php if (function_exists('userpermission') && userpermission('lr_detail_view_bio')) : ?>
                        <th>Telepon Istri</th>
                        <?php endif; ?>
                        <th>Kondisi Rumah</th>
                        <th>Status Rumah</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if (!empty($surveylist_drivers)):  $count = 1;
                        ?>
                        <?php foreach($surveylist_drivers as $survey): ?>
                     <tr>
                        <td><?= esc($count); $count++; ?></td>
                        <td><?= esc(date('d-m-Y', strtotime($survey['s_tanggal']))); ?></td>
                        <td><?= esc($survey['s_supir']); ?></td>
                        <td><?= esc($survey['s_istri']); ?></td>
                        <?php if (function_exists('userpermission') && userpermission('lr_detail_view_bio')) : ?>
                        <td><?= esc($survey['s_telepon_istri']); ?></td>
                        <?php endif; ?>
                        <td><?= esc($survey['s_kondisi_rumah']); ?></td>
                        <td><?= esc($survey['s_status_rumah']); ?></td>
                        <td>
                           <?php if (function_exists('userpermission') && userpermission('lr_drivers_edit_survey')) : ?>
                                 <form action="<?= base_url('surveys/editsurvey') ?>" method="POST" style="display: inline;">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="survey_id" value="<?= $survey['s_id'] ?>">
                                    <button type="submit" class="btn btn-link text-primary p-0 border-0"><i class="fa fa-edit" title="Edit"></i></button>
                                 </form>
                                 |
                           <?php endif; ?>
                           <?php if (function_exists('userpermission') && userpermission('lr_drivers_view_survey')) : ?>
                                 <form action="<?= base_url('surveys/survey_view') ?>" method="POST" style="display: inline;">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="survey_id" value="<?= $survey['s_id'] ?>">
                                    <button type="submit" class="btn btn-link text-success p-0 border-0"><i class="fa fa-eye" title="Detail"></i></button>
                                 </form>
                           <?php endif; ?>
                          <?php if (function_exists('userpermission') && userpermission('lr_drivers_delete_survey')) : ?>
                                    | <form id="delete-form-<?= esc($survey['s_id']) ?>" action="<?= base_url('drivers/survey_delete/' . $survey['s_id']) ?>" 
                                          method="post" 
                                          style="display: inline;" 
                                          >
                                        <?= csrf_field() ?>
                                        <button type="button" class="btn btn-link text-danger p-0 border-0" onclick="confirmDeleteSurvey('<?= esc($survey['s_id']) ?>', '<?= esc($survey['s_code']) ?>', '<?= esc($survey['s_nis']) ?>', '<?= esc($survey['s_supir']) ?>')"><i class="fa fa-trash" title="Delete"></i></button>
                                    </form>
                                <?php endif; ?>
                        </td>
                     </tr>
                     <?php endforeach; endif; ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</section>
<?= view('layout/footer') ?>

<script src="<?= base_url('assets/autoLogout.js') ?>"></script>
<script>
   const baseUrl = "<?= base_url() ?>"; 
    enableAutoLogout(7200, baseUrl + "login");

function confirmDeleteSurvey(id, survey, nis, name)
{
   Swal.fire({
      title: 'Apakah anda yakin ingin menghapus data survey supir tersebut? ',
      html: 'No Survey :' + '<b>' + survey +'</b><br>' + 'NIS : <b>' + nis + '</b><br>' + 'Nama Supir : <b>' + name + '</b>',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Hapus',
      cancelButtonText: 'Batal'
   }).then(result => {
      if (result.isConfirmed) {
         document.getElementById('delete-form-' + id).submit();
      }
   })
}

$(document).ready(function () {
    var table = $('#driverslisttbl').DataTable({
        "pageLength": 15,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "scrollX": true,
        "language": {
            "paginate": {
                "previous": "Previous",
                "next": "Next"
            },
            "search": "Search:",
            "info": "Showing _START_ to _END_ of _TOTAL_ entri"
        },
        initComplete: function () {
            var searchInput = $('div.dataTables_filter input');
            $('#table-filter').append(searchInput);
            $('div.dataTables_filter').remove(); // Remove default search
        }
    });
    // Dynamic numbering based on filter and search
    table.on('order.dt search.dt draw.dt', function () {
        let i = 1;
        table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell) {
            cell.innerHTML = i++;
        });
    }).draw();
});

</script>