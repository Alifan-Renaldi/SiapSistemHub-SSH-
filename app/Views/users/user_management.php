<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">User List</h1>
         </div>
         <!-- /.col -->
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
               <li class="breadcrumb-item active">User List</li>
            </ol>
         </div>
      </div>
   </div>
</div>
<section class="content">
   <div class="container-fluid">
      <div class="card">
         <div class="d-flex align-items-center justify-content-between p-3">
            <?php if(userpermission('lr_add_user')): ?>
                <a href="<?= base_url('users/adduser') ?>" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Add User
                </a>
            <?php endif; ?>
            <div id="table-filter" class="d-flex align-items-center">
                <span class="mr-2">Search:</span>
            </div>
        </div>
         <div class="card-body p-0">
            <div class="table-responsive">
               <table id="custtbl" class="table card-table table-vcenter text-nowrap">
                  <thead>
                     <tr>
                        <th class="w-1">No</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if(!empty($userlist)): 
                        $count = 1;
                        foreach($userlist as $userlists):
                     ?>
                     <tr>
                        <td> <?= $count; $count++; ?></td>
                        <td> <?= esc($userlists['u_name']); ?></td>
                        <td> <?= esc($userlists['u_username']); ?></td>
                        <td> <?= esc($userlists['u_email']); ?></td>
                        <td><span class="badge <?= esc ($userlists['u_is_status']=='1') ? 'badge-success' : 'badge-danger'; ?> "><?= esc ($userlists['u_is_status']=='1') ? 'Active' : 'Inactive'; ?></span>  
                        </td>
                        <td>
                           <?php if (function_exists('userpermission') && userpermission('lr_edit_user')) : ?>
                                    <a href="<?= base_url('users/edituser/' . $userlists['u_id']) ?>"><i class="fa fa-edit"></i></a>

                                    | <form action="<?= base_url('users/deleteuser/' . $userlists['u_id']) ?>" 
                                          method="post" 
                                          style="display: inline;" 
                                          onsubmit="return confirm('Yakin hapus user ini?')">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-link text-danger p-0 border-0"><i class="fa fa-trash"></i></button>
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

<script>
function confirmDelete() {
    return confirm("Apakah anda yakin ingin menghapus data ini?");
}

$(function () {
    var table = $('#custtbl').DataTable({
        pageLength: 15,
        lengthChange: false,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: false,
        scrollX: true,
        language: {
            paginate: {
                previous: "Previous",
                next: "Next"
            },
            search: "Search:",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri"
        },
        initComplete: function () {
            $('#table-filter').append($('.dataTables_filter input'));
            $('.dataTables_filter').remove();
        }
    });

    table.on('order.dt search.dt draw.dt', function () {
        let i = 1;
        table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell) {
            cell.innerHTML = i++;
        });
    }).draw();
});
</script>