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
                                    <a href="<?= base_url('users/edituser/' . $userlists['u_id']) ?>" class="btn btn-link text-primary p-0 border-0"><i class="fa fa-edit"></i></a>
                           
                                    | <form id="delete-form-<?= $userlists['u_id'] ?>" action="<?= base_url('users/deleteuser/' . $userlists['u_id']) ?>" 
                                          method="post" 
                                          style="display: inline;">
                                        <?= csrf_field() ?>
                                        <button type="button" class="btn btn-link text-danger p-0 border-0" onclick="confirmDeleteUser(<?= $userlists['u_id'] ?>, '<?= $userlists['u_name'] ?>')"><i class="fa fa-trash"></i></button>
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

function confirmDeleteUser(id, name) {
    Swal.fire({
        title: 'Apakah anda yakin menghapus data user tersebut?',
        html: 'Nama User : <b>' + name + '</b>',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Hapus'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>