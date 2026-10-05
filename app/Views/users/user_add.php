<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><?= (isset($user)) ? 'Edit User' : 'Add User' ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('users/user_management') ?>">User List</a></li>
                    <li class="breadcrumb-item active"><?= (isset($user)) ? 'Edit User' : 'Add User' ?></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <form method="post" id="adduser" class="card basicvalidation" action="<?= base_url('users/' . ((isset($user)) ? 'updateuser' : 'insertuser')); ?>">
            
            <div class="card-body">
                <div class="row">
                    <input type="hidden" name="u_id" id="u_id" value="<?= (isset($user) && !empty($user)) ? esc($user['u_id']) : '' ?>">

                    <div class="col-sm-6 col-md-4">
                        <label class="form-label">Name</label>
                        <div class="form-group">
                            <input type="text" name="u_name" id="u_name" required class="form-control" placeholder="Name" value="<?= (isset($user) && !empty($user)) ? esc($user['u_name']) : '' ?>" oninput="this.value = capitalizeEachWord(this.value)">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <label class="form-label">Username</label>
                        <div class="form-group">
                            <input type="text" name="u_username" id="u_username" required class="form-control" placeholder="Username" value="<?= (isset($user) && !empty($user)) ? esc($user['u_username']) : '' ?>">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <label class="form-label">Email</label>
                        <div class="form-group">
                            <input type="email" name="u_email" id="u_email" required class="form-control" placeholder="Email" value="<?= (isset($user) && !empty($user)) ? esc($user['u_email']) : '' ?>">
                        </div>
                    </div>
                    <?php if (!isset($userdetails)): ?>
                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label class="form-label">Password</label>
                            <input type="password" name="basic[u_password]" required minlength="8" class="form-control" placeholder="Password" autocomplete="new-password">
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label class="form-label">New Password</label>
                            <input type="password" name="new_password" id="new_password" class="form-control" placeholder="New Password (leave blank if unchanged)" autocomplete="new-password">
                            <small class="text-muted">Min. 8 characters</small>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm New Password" autocomplete="new-password">
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if (isset($userdetails['u_is_status'])) { ?>
                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label for="u_is_status" class="form-label">User Status</label>
                            <select id="u_is_status" name="basic[u_is_status]" class="form-control " required="">
                                <option value="">Select User Status</option>  
                                <option value="1" <?= (isset($user) && !empty($user) && $user['u_is_status'] == 1) ? 'selected' : '' ?>>Active</option>
                                <option value="0" <?= (isset($user) && !empty($user) && $user['u_is_status'] == 0) ? 'selected' : '' ?>>Inactive</option>
                            </select>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <hr>
                <div class="form-label"><b>User Permission</b></div><br>

                <div class="row">
                      <div class="col-sm-6 col-md-2">
                        <div class="form-group">
                          <label class="form-label">Driver</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_drivers_mgmt]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_drivers_mgmt']) && $user['lr_drivers_mgmt'] == 1) ? 'checked' : '' ?> name="permissions[lr_drivers_mgmt]" class="custom-control-input" id="lr_drivers_mgmt">
                          <label class="custom-control-label" for="lr_drivers_mgmt">Management</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_drivers_list]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_drivers_list']) && $user['lr_drivers_list'] == 1) ? 'checked' : '' ?> name="permissions[lr_drivers_list]" class="custom-control-input" id="lr_drivers_list">
                          <label class="custom-control-label" for="lr_drivers_list">Active List</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_drivers_list_inactive]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_drivers_list_inactive']) && $user['lr_drivers_list_inactive'] == 1) ? 'checked' : '' ?> name="permissions[lr_drivers_list_inactive]" class="custom-control-input" id="lr_drivers_list_inactive">
                          <label class="custom-control-label" for="lr_drivers_list_inactive">Inactive List</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_drivers_add]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_drivers_add']) && $user['lr_drivers_add'] == 1) ? 'checked' : '' ?> name="permissions[lr_drivers_add]" class="custom-control-input" id="lr_drivers_add">
                          <label class="custom-control-label" for="lr_drivers_add">Add</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_drivers_list_edit]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_drivers_list_edit']) && $user['lr_drivers_list_edit'] == 1) ? 'checked' : '' ?> name="permissions[lr_drivers_list_edit]" class="custom-control-input" id="lr_drivers_list_edit">
                          <label class="custom-control-label" for="lr_drivers_list_edit">Edit</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_drivers_list_delete]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_drivers_list_delete']) && $user['lr_drivers_list_delete'] == 1) ? 'checked' : '' ?> name="permissions[lr_drivers_list_delete]" class="custom-control-input" id="lr_drivers_list_delete">
                          <label class="custom-control-label" for="lr_drivers_list_delete">Delete</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_drivers_list_view]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_drivers_list_view']) && $user['lr_drivers_list_view'] == 1) ? 'checked' : '' ?> name="permissions[lr_drivers_list_view]" class="custom-control-input" id="lr_drivers_list_view">
                          <label class="custom-control-label" for="lr_drivers_list_view">View</label>
                        </div>
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-sm-6 col-md-2">
                        <div class="form-group">
                          <label class="form-label">Driver Details</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_detail_view_bio]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_detail_view_bio']) && $user['lr_detail_view_bio'] == 1) ? 'checked' : '' ?> name="permissions[lr_detail_view_bio]" class="custom-control-input" id="lr_detail_view_bio">
                          <label class="custom-control-label" for="lr_detail_view_bio">Biodata</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_detail_view_bap]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_detail_view_bap']) && $user['lr_detail_view_bap'] == 1) ? 'checked' : '' ?> name="permissions[lr_detail_view_bap]" class="custom-control-input" id="lr_detail_view_bap">
                          <label class="custom-control-label" for="lr_detail_view_bap">BAP</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_detail_view_svy]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_detail_view_svy']) && $user['lr_detail_view_svy'] == 1) ? 'checked' : '' ?> name="permissions[lr_detail_view_svy]" class="custom-control-input" id="lr_detail_view_svy">
                          <label class="custom-control-label" for="lr_detail_view_svy">Survey</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_detail_view_trn]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_detail_view_trn']) && $user['lr_detail_view_trn'] == 1) ? 'checked' : '' ?> name="permissions[lr_detail_view_trn]" class="custom-control-input" id="lr_detail_view_trn">
                          <label class="custom-control-label" for="lr_detail_view_trn">Training</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_detail_view_doc]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_detail_view_doc']) && $user['lr_detail_view_doc'] == 1) ? 'checked' : '' ?> name="permissions[lr_detail_view_doc]" class="custom-control-input" id="lr_detail_view_doc">
                          <label class="custom-control-label" for="lr_detail_view_doc">Document</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_detail_view_loan]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_detail_view_loan']) && $user['lr_detail_view_loan'] == 1) ? 'checked' : '' ?> name="permissions[lr_detail_view_loan]" class="custom-control-input" id="lr_detail_view_loan">
                          <label class="custom-control-label" for="lr_detail_view_loan">Loan</label>
                        </div>
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-sm-6 col-md-2">
                        <div class="form-group">
                          <label class="form-label">BAP</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_drivers_list_bap]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_drivers_list_bap']) && $user['lr_drivers_list_bap'] == 1) ? 'checked' : '' ?> name="permissions[lr_drivers_list_bap]" class="custom-control-input" id="lr_drivers_list_bap">
                          <label class="custom-control-label" for="lr_drivers_list_bap">All List</label>
                        </div>
                      </div> 
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_drivers_pending_bap]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_drivers_pending_bap']) && $user['lr_drivers_pending_bap'] == 1) ? 'checked' : '' ?> name="permissions[lr_drivers_pending_bap]" class="custom-control-input" id="lr_drivers_pending_bap">
                          <label class="custom-control-label" for="lr_drivers_pending_bap">Pending List</label>
                        </div>
                      </div> 
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_drivers_add_bap]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_drivers_add_bap']) && $user['lr_drivers_add_bap'] == 1) ? 'checked' : '' ?> name="permissions[lr_drivers_add_bap]" class="custom-control-input" id="lr_drivers_add_bap">
                          <label class="custom-control-label" for="lr_drivers_add_bap">Add</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_drivers_edit_bap]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_drivers_edit_bap']) && $user['lr_drivers_edit_bap'] == 1) ? 'checked' : '' ?> name="permissions[lr_drivers_edit_bap]" class="custom-control-input" id="lr_drivers_edit_bap">
                          <label class="custom-control-label" for="lr_drivers_edit_bap">Edit</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_drivers_delete_bap]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_drivers_delete_bap']) && $user['lr_drivers_delete_bap'] == 1) ? 'checked' : '' ?> name="permissions[lr_drivers_delete_bap]" class="custom-control-input" id="lr_drivers_delete_bap">
                          <label class="custom-control-label" for="lr_drivers_delete_bap">Delete</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_drivers_view_bap]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_drivers_view_bap']) && $user['lr_drivers_view_bap'] == 1) ? 'checked' : '' ?> name="permissions[lr_drivers_view_bap]" class="custom-control-input" id="lr_drivers_view_bap">
                          <label class="custom-control-label" for="lr_drivers_view_bap">View</label>
                        </div>
                      </div>  
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_drivers_print_bap]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_drivers_print_bap']) && $user['lr_drivers_print_bap'] == 1) ? 'checked' : '' ?> name="permissions[lr_drivers_print_bap]" class="custom-control-input" id="lr_drivers_print_bap">
                          <label class="custom-control-label" for="lr_drivers_print_bap">Print</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_drivers_edit_bappending]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_drivers_edit_bappending']) && $user['lr_drivers_edit_bappending'] == 1) ? 'checked' : '' ?> name="permissions[lr_drivers_edit_bappending]" class="custom-control-input" id="lr_drivers_edit_bappending">
                          <label class="custom-control-label" for="lr_drivers_edit_bappending">Edit Bap Pending</label>
                        </div>
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-sm-6 col-md-2">
                        <div class="form-group">
                          <label class="form-label"></label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_drivers_edit_bapsolution]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_drivers_edit_bapsolution']) && $user['lr_drivers_edit_bapsolution'] == 1) ? 'checked' : '' ?> name="permissions[lr_drivers_edit_bapsolution]" class="custom-control-input" id="lr_drivers_edit_bapsolution">
                          <label class="custom-control-label" for="lr_drivers_edit_bapsolution">Edit Bap Penyelesaian</label>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                      <div class="col-sm-6 col-md-2">
                        <div class="form-group">
                          <label class="form-label">Survey</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_drivers_list_survey]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_drivers_list_survey']) && $user['lr_drivers_list_survey'] == 1) ? 'checked' : '' ?> name="permissions[lr_drivers_list_survey]" class="custom-control-input" id="lr_drivers_list_survey">
                          <label class="custom-control-label" for="lr_drivers_list_survey">All List</label>
                        </div>
                      </div> 
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_drivers_add_survey]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_drivers_add_survey']) && $user['lr_drivers_add_survey'] == 1) ? 'checked' : '' ?> name="permissions[lr_drivers_add_survey]" class="custom-control-input" id="lr_drivers_add_survey">
                          <label class="custom-control-label" for="lr_drivers_add_survey">Add</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                           <input type="hidden" name="permissions[lr_drivers_edit_survey]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_drivers_edit_survey']) && $user['lr_drivers_edit_survey'] == 1) ? 'checked' : '' ?> name="permissions[lr_drivers_edit_survey]" class="custom-control-input" id="lr_drivers_edit_survey">
                          <label class="custom-control-label" for="lr_drivers_edit_survey">Edit</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_drivers_delete_survey]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_drivers_delete_survey']) && $user['lr_drivers_delete_survey'] == 1) ? 'checked' : '' ?> name="permissions[lr_drivers_delete_survey]" class="custom-control-input" id="lr_drivers_delete_survey">
                          <label class="custom-control-label" for="lr_drivers_delete_survey">Delete</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_drivers_view_survey]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_drivers_view_survey']) && $user['lr_drivers_view_survey'] == 1) ? 'checked' : '' ?> name="permissions[lr_drivers_view_survey]" class="custom-control-input" id="lr_drivers_view_survey">
                          <label class="custom-control-label" for="lr_drivers_view_survey">View</label>
                        </div>
                      </div>     
                  </div>

                  <div class="row">
                      <div class="col-sm-6 col-md-2">
                        <div class="form-group">
                          <label class="form-label">Training</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_drivers_list_training]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_drivers_list_training']) && $user['lr_drivers_list_training'] == 1) ? 'checked' : '' ?> name="permissions[lr_drivers_list_training]" class="custom-control-input" id="lr_drivers_list_training">
                          <label class="custom-control-label" for="lr_drivers_list_training">All List</label>
                        </div>
                      </div> 
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_drivers_add_training]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_drivers_add_training']) && $user['lr_drivers_add_training'] == 1) ? 'checked' : '' ?> name="permissions[lr_drivers_add_training]" class="custom-control-input" id="lr_drivers_add_training">
                          <label class="custom-control-label" for="lr_drivers_add_training">Add</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_drivers_edit_training]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_drivers_edit_training']) && $user['lr_drivers_edit_training'] == 1) ? 'checked' : '' ?> name="permissions[lr_drivers_edit_training]" class="custom-control-input" id="lr_drivers_edit_training">
                          <label class="custom-control-label" for="lr_drivers_edit_training">Edit</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_drivers_delete_training]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_drivers_delete_training']) && $user['lr_drivers_delete_training'] == 1) ? 'checked' : '' ?> name="permissions[lr_drivers_delete_training]" class="custom-control-input" id="lr_drivers_delete_training">
                          <label class="custom-control-label" for="lr_drivers_delete_training">Delete</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_drivers_view_training]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_drivers_view_training']) && $user['lr_drivers_view_training'] == 1) ? 'checked' : '' ?> name="permissions[lr_drivers_view_training]" class="custom-control-input" id="lr_drivers_view_training">
                          <label class="custom-control-label" for="lr_drivers_view_training">View</label>
                        </div>
                      </div>     
                  </div>

                  <div class="row">
                      <div class="col-sm-6 col-md-2">
                        <div class="form-group">
                          <label class="form-label">Loan</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_drivers_list_loan]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_drivers_list_loan']) && $user['lr_drivers_list_loan'] == 1) ? 'checked' : '' ?> name="permissions[lr_drivers_list_loan]" class="custom-control-input" id="lr_drivers_list_loan">
                          <label class="custom-control-label" for="lr_drivers_list_loan">All List</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_drivers_payment_loan]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_drivers_payment_loan']) && $user['lr_drivers_payment_loan'] == 1) ? 'checked' : '' ?> name="permissions[lr_drivers_payment_loan]" class="custom-control-input" id="lr_drivers_payment_loan">
                          <label class="custom-control-label" for="lr_drivers_payment_loan">Payment</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_drivers_approve_loan]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_drivers_approve_loan']) && $user['lr_drivers_approve_loan'] == 1) ? 'checked' : '' ?> name="permissions[lr_drivers_approve_loan]" class="custom-control-input" id="lr_drivers_approve_loan">
                          <label class="custom-control-label" for="lr_drivers_approve_loan">Approval</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_drivers_add_loan]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_drivers_add_loan']) && $user['lr_drivers_add_loan'] == 1) ? 'checked' : '' ?> name="permissions[lr_drivers_add_loan]" class="custom-control-input" id="lr_drivers_add_loan">
                          <label class="custom-control-label" for="lr_drivers_add_loan">Add</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_drivers_edit_loan]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_drivers_edit_loan']) && $user['lr_drivers_edit_loan'] == 1) ? 'checked' : '' ?> name="permissions[lr_drivers_edit_loan]" class="custom-control-input" id="lr_drivers_edit_loan">
                          <label class="custom-control-label" for="lr_drivers_edit_loan">Edit</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_drivers_delete_loan]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_drivers_delete_loan']) && $user['lr_drivers_delete_loan'] == 1) ? 'checked' : '' ?> name="permissions[lr_drivers_delete_loan]" class="custom-control-input" id="lr_drivers_delete_loan">
                          <label class="custom-control-label" for="lr_drivers_delete_loan">Delete</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_drivers_view_loan]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_drivers_view_loan']) && $user['lr_drivers_view_loan'] == 1) ? 'checked' : '' ?> name="permissions[lr_drivers_view_loan]" class="custom-control-input" id="lr_drivers_view_loan">
                          <label class="custom-control-label" for="lr_drivers_view_loan">View</label>
                        </div>
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-sm-6 col-md-2">
                        <div class="form-group">
                          <label class="form-label">Vehicle</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_vech_mgmt]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_vech_mgmt']) && $user['lr_vech_mgmt'] == 1) ? 'checked' : '' ?> name="permissions[lr_vech_mgmt]" class="custom-control-input" id="lr_vech_mgmt">
                          <label class="custom-control-label" for="lr_vech_mgmt">Management</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_vech_list]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_vech_list']) && $user['lr_vech_list'] == 1) ? 'checked' : '' ?> name="permissions[lr_vech_list]" class="custom-control-input" id="lr_vech_list">
                          <label class="custom-control-label" for="lr_vech_list">All List</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_vech_add]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_vech_add']) && $user['lr_vech_add'] == 1) ? 'checked' : '' ?> name="permissions[lr_vech_add]" class="custom-control-input" id="lr_vech_add">
                          <label class="custom-control-label" for="lr_vech_add">Add</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_vech_list_edit]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_vech_list_edit']) && $user['lr_vech_list_edit'] == 1) ? 'checked' : '' ?> name="permissions[lr_vech_list_edit]" class="custom-control-input" id="lr_vech_list_edit">
                          <label class="custom-control-label" for="lr_vech_list_edit">Edit</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_vech_list_delete]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_vech_list_delete']) && $user['lr_vech_list_delete'] == 1) ? 'checked' : '' ?> name="permissions[lr_vech_list_delete]" class="custom-control-input" id="lr_vech_list_delete">
                          <label class="custom-control-label" for="lr_vech_list_delete">Delete</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_vech_list_view]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_vech_list_view']) && $user['lr_vech_list_view'] == 1) ? 'checked' : '' ?> name="permissions[lr_vech_list_view]" class="custom-control-input" id="lr_vech_list_view">
                          <label class="custom-control-label" for="lr_vech_list_view">View</label>
                        </div>
                      </div>
                  </div>
                  
                  <div class="row">
                      <div class="col-sm-6 col-md-2">
                        <div class="form-group">
                          <label class="form-label">Vehicle Details</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_vech_detail_num]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_vech_detail_num']) && $user['lr_vech_detail_num'] == 1) ? 'checked' : '' ?> name="permissions[lr_vech_detail_num]" class="custom-control-input" id="lr_vech_detail_num">
                          <label class="custom-control-label" for="lr_vech_detail_num">Id Number</label>
                        </div>
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-sm-6 col-md-2">
                        <div class="form-group">
                          <label class="form-label">Vehicle Group</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_vech_group]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_vech_group']) && $user['lr_vech_group'] == 1) ? 'checked' : '' ?> name="permissions[lr_vech_group]" class="custom-control-input" id="lr_vech_group">
                          <label class="custom-control-label" for="lr_vech_group">All List</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_vech_group_add]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_vech_group_add']) && $user['lr_vech_group_add'] == 1) ? 'checked' : '' ?> name="permissions[lr_vech_group_add]" class="custom-control-input" id="lr_vech_group_add">
                          <label class="custom-control-label" for="lr_vech_group_add">Add</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_vech_group_action]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_vech_group_action']) && $user['lr_vech_group_action'] == 1) ? 'checked' : '' ?> name="permissions[lr_vech_group_action]" class="custom-control-input" id="lr_vech_group_action">
                          <label class="custom-control-label" for="lr_vech_group_action">Delete</label>
                        </div>
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-sm-6 col-md-2">
                        <div class="form-group">
                          <label class="form-label">Vehicle Inventory</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_vech_list_invent]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_vech_list_invent']) && $user['lr_vech_list_invent'] == 1) ? 'checked' : '' ?> name="permissions[lr_vech_list_invent]" class="custom-control-input" id="lr_vech_list_invent">
                          <label class="custom-control-label" for="lr_vech_list_invent">All List</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_vech_invent_add]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_vech_invent_add']) && $user['lr_vech_invent_add'] == 1) ? 'checked' : '' ?> name="permissions[lr_vech_invent_add]" class="custom-control-input" id="lr_vech_invent_add">
                          <label class="custom-control-label" for="lr_vech_invent_add">Add</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_vech_invent_edit]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_vech_invent_edit']) && $user['lr_vech_invent_edit'] == 1) ? 'checked' : '' ?> name="permissions[lr_vech_invent_edit]" class="custom-control-input" id="lr_vech_invent_edit">
                          <label class="custom-control-label" for="lr_vech_invent_edit">Edit</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_vech_invent_delete]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_vech_invent_delete']) && $user['lr_vech_invent_delete'] == 1) ? 'checked' : '' ?> name="permissions[lr_vech_invent_delete]" class="custom-control-input" id="lr_vech_invent_delete">
                          <label class="custom-control-label" for="lr_vech_invent_delete">Delete</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_vech_invent_view]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_vech_invent_view']) && $user['lr_vech_invent_view'] == 1) ? 'checked' : '' ?> name="permissions[lr_vech_invent_view]" class="custom-control-input" id="lr_vech_invent_view">
                          <label class="custom-control-label" for="lr_vech_invent_view">View</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_vech_invent_print]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_vech_invent_print']) && $user['lr_vech_invent_print'] == 1) ? 'checked' : '' ?> name="permissions[lr_vech_invent_print]" class="custom-control-input" id="lr_vech_invent_print">
                          <label class="custom-control-label" for="lr_vech_invent_print">Print</label>
                        </div>
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-sm-6 col-md-2">
                        <div class="form-group">
                          <label class="form-label">Vehicle Handover</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_vech_handover_list]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_vech_handover_list']) && $user['lr_vech_handover_list'] == 1) ? 'checked' : '' ?> name="permissions[lr_vech_handover_list]" class="custom-control-input" id="lr_vech_handover_list">
                          <label class="custom-control-label" for="lr_vech_handover_list">All List</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_vech_handover_add]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_vech_handover_add']) && $user['lr_vech_handover_add'] == 1) ? 'checked' : '' ?> name="permissions[lr_vech_handover_add]" class="custom-control-input" id="lr_vech_handover_add">
                          <label class="custom-control-label" for="lr_vech_handover_add">Add</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_vech_handover_edit]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_vech_handover_edit']) && $user['lr_vech_handover_edit'] == 1) ? 'checked' : '' ?> name="permissions[lr_vech_handover_edit]" class="custom-control-input" id="lr_vech_handover_edit">
                          <label class="custom-control-label" for="lr_vech_handover_edit">Edit</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_vech_handover_delete]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_vech_handover_delete']) && $user['lr_vech_handover_delete'] == 1) ? 'checked' : '' ?> name="permissions[lr_vech_handover_delete]" class="custom-control-input" id="lr_vech_handover_delete">
                          <label class="custom-control-label" for="lr_vech_handover_delete">Delete</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_vech_handover_view]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_vech_handover_view']) && $user['lr_vech_handover_view'] == 1) ? 'checked' : '' ?> name="permissions[lr_vech_handover_view]" class="custom-control-input" id="lr_vech_handover_view">
                          <label class="custom-control-label" for="lr_vech_handover_view">View</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_vech_handover_print]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_vech_handover_print']) && $user['lr_vech_handover_print'] == 1) ? 'checked' : '' ?> name="permissions[lr_vech_handover_print]" class="custom-control-input" id="lr_vech_handover_print">
                          <label class="custom-control-label" for="lr_vech_handover_print">Print</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_vech_handover_print]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_vech_handover_print']) && $user['lr_vech_handover_print'] == 1) ? 'checked' : '' ?> name="permissions[lr_vech_handover_print]" class="custom-control-input" id="lr_vech_handover_print">
                          <label class="custom-control-label" for="lr_vech_handover_print">Print</label>
                        </div>
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-sm-6 col-md-2">
                        <div class="form-group">
                          <label class="form-label">Handover Merek Group</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_vech_merk_group]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_vech_merk_group']) && $user['lr_vech_merk_group'] == 1) ? 'checked' : '' ?> name="permissions[lr_vech_merk_group]" class="custom-control-input" id="lr_vech_merk_group">
                          <label class="custom-control-label" for="lr_vech_merk_group">All List</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_vech_merk_group_add]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_vech_merk_group_add']) && $user['lr_vech_merk_group_add'] == 1) ? 'checked' : '' ?> name="permissions[lr_vech_merk_group_add]" class="custom-control-input" id="lr_vech_merk_group_add">
                          <label class="custom-control-label" for="lr_vech_merk_group_add">Add</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_vech_merk_group_action]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_vech_merk_group_action']) && $user['lr_vech_merk_group_action'] == 1) ? 'checked' : '' ?> name="permissions[lr_vech_merk_group_action]" class="custom-control-input" id="lr_vech_merk_group_action">
                          <label class="custom-control-label" for="lr_vech_merk_group_action">Delete</label>
                        </div>
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-sm-6 col-md-2">
                        <div class="form-group">
                          <label class="form-label">Workshop</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_mech_mgmt]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_mech_mgmt']) && $user['lr_mech_mgmt'] == 1) ? 'checked' : '' ?> name="permissions[lr_mech_mgmt]" class="custom-control-input" id="lr_mech_mgmt">
                          <label class="custom-control-label" for="lr_mech_mgmt">Management</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_mech_list]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_mech_list']) && $user['lr_mech_list'] == 1) ? 'checked' : '' ?> name="permissions[lr_mech_list]" class="custom-control-input" id="lr_mech_list">
                          <label class="custom-control-label" for="lr_mech_list">All List</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_vech_invent_add]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_vech_invent_add']) && $user['lr_vech_invent_add'] == 1) ? 'checked' : '' ?> name="permissions[lr_vech_invent_add]" class="custom-control-input" id="lr_vech_invent_add">
                          <label class="custom-control-label" for="lr_vech_invent_add">Add</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_vech_invent_edit]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_vech_invent_edit']) && $user['lr_vech_invent_edit'] == 1) ? 'checked' : '' ?> name="permissions[lr_vech_invent_edit]" class="custom-control-input" id="lr_vech_invent_edit">
                          <label class="custom-control-label" for="lr_vech_invent_edit">Edit</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_vech_invent_delete]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_vech_invent_delete']) && $user['lr_vech_invent_delete'] == 1) ? 'checked' : '' ?> name="permissions[lr_vech_invent_delete]" class="custom-control-input" id="lr_vech_invent_delete">
                          <label class="custom-control-label" for="lr_vech_invent_delete">Delete</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_vech_invent_view]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_vech_invent_view']) && $user['lr_vech_invent_view'] == 1) ? 'checked' : '' ?> name="permissions[lr_vech_invent_view]" class="custom-control-input" id="lr_vech_invent_view">
                          <label class="custom-control-label" for="lr_vech_invent_view">View</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_vech_invent_print]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_vech_invent_print']) && $user['lr_vech_invent_print'] == 1) ? 'checked' : '' ?> name="permissions[lr_vech_invent_print]" class="custom-control-input" id="lr_vech_invent_print">
                          <label class="custom-control-label" for="lr_vech_invent_print">Print</label>
                        </div>
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-sm-6 col-md-2">
                        <div class="form-group">
                          <label class="form-label">Reports</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_reports]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_reports']) && $user['lr_reports'] == 1) ? 'checked' : '' ?> name="permissions[lr_reports]" class="custom-control-input" id="lr_reports">
                          <label class="custom-control-label" for="lr_reports">Management</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_reports_driver]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_reports_driver']) && $user['lr_reports_driver'] == 1) ? 'checked' : '' ?> name="permissions[lr_reports_driver]" class="custom-control-input" id="lr_reports_driver">
                          <label class="custom-control-label" for="lr_reports_driver">Report Driver</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_reports_bap]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_reports_bap']) && $user['lr_reports_bap'] == 1) ? 'checked' : '' ?> name="permissions[lr_reports_bap]" class="custom-control-input" id="lr_reports_bap">
                          <label class="custom-control-label" for="lr_reports_bap">Report BAP</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_reports_laka]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_reports_laka']) && $user['lr_reports_laka'] == 1) ? 'checked' : '' ?> name="permissions[lr_reports_laka]" class="custom-control-input" id="lr_reports_laka">
                          <label class="custom-control-label" for="lr_reports_laka">Report Lakalantas</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_reports_survey]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_reports_survey']) && $user['lr_reports_survey'] == 1) ? 'checked' : '' ?> name="permissions[lr_reports_survey]" class="custom-control-input" id="lr_reports_survey">
                          <label class="custom-control-label" for="lr_reports_survey">Report Survey</label>
                        </div>
                      </div>
                    </div>
                        <div class="row">
                          <div class="col-sm-6 col-md-2">
                            <div class="form-group">
                              <label class="form-label"></label>
                            </div>
                          </div>
                          <div class="form-group mr-4">
                            <div class="custom-control custom-checkbox">
                              <input type="hidden" name="permissions[lr_reports_training]" value="0">
                              <input type="checkbox" value="1" <?= (isset($user['lr_reports_training']) && $user['lr_reports_training'] == 1) ? 'checked' : '' ?> name="permissions[lr_reports_training]" class="custom-control-input" id="lr_reports_training">
                              <label class="custom-control-label" for="lr_reports_training">Report Training</label>
                            </div>
                          </div>
                        <div class="form-group mr-4">
                          <div class="custom-control custom-checkbox">
                              <input type="hidden" name="permissions[lr_reports_loan]" value="0">
                              <input type="checkbox" value="1" <?= (isset($user['lr_reports_loan']) && $user['lr_reports_loan'] == 1) ? 'checked' : '' ?> name="permissions[lr_reports_loan]" class="custom-control-input" id="lr_reports_loan">
                              <label class="custom-control-label" for="lr_reports_loan">Report Loan</label>
                          </div>
                        </div>
                          <div class="form-group mr-4">
                            <div class="custom-control custom-checkbox">
                              <input type="hidden" name="permissions[lr_reports_vehicle]" value="0">
                              <input type="checkbox" value="1" <?= (isset($user['lr_reports_vehicle']) && $user['lr_reports_vehicle'] == 1) ? 'checked' : '' ?> name="permissions[lr_reports_vehicle]" class="custom-control-input" id="lr_reports_vehicle">
                              <label class="custom-control-label" for="lr_reports_vehicle">Report Vehicle</label>
                            </div>
                          </div>
                          <div class="form-group mr-4">
                            <div class="custom-control custom-checkbox">
                              <input type="hidden" name="permissions[lr_reports_inventory]" value="0">
                              <input type="checkbox" value="1" <?= (isset($user['lr_reports_inventory']) && $user['lr_reports_inventory'] == 1) ? 'checked' : '' ?> name="permissions[lr_reports_inventory]" class="custom-control-input" id="lr_reports_inventory">
                              <label class="custom-control-label" for="lr_reports_inventory">Report Inventory</label>
                            </div>
                          </div>
                          <div class="form-group mr-4">
                            <div class="custom-control custom-checkbox">
                              <input type="hidden" name="permissions[lr_reports_handover]" value="0">
                              <input type="checkbox" value="1" <?= (isset($user['lr_reports_handover']) && $user['lr_reports_handover'] == 1) ? 'checked' : '' ?> name="permissions[lr_reports_handover]" class="custom-control-input" id="lr_reports_handover">
                              <label class="custom-control-label" for="lr_reports_handover">Report Handover</label>
                            </div>
                          </div>
                        </div>

                    <div class="row">
                      <div class="col-sm-6 col-md-2">
                        <div class="form-group">
                          <label class="form-label">Settings</label>
                        </div>
                      </div>
                      <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                          <input type="hidden" name="permissions[lr_settings]" value="0">
                          <input type="checkbox" value="1" <?= (isset($user['lr_settings']) && $user['lr_settings'] == 1) ? 'checked' : '' ?> name="permissions[lr_settings]" class="custom-control-input" id="lr_settings">
                          <label class="custom-control-label" for="lr_settings">All Settings</label>
                        </div>
                      </div>
                    </div>
                
                <div class="row">
                    <div class="col-sm-6 col-md-2">
                        <div class="form-group">
                            <label class="form-label">User</label>
                        </div>
                    </div>
                    <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                            <input type="hidden" name="permissions[lr_view_userby]" value="0">
                            <input type="checkbox" value="1" <?= (isset($user['lr_view_userby']) && $user['lr_view_userby'] == 1) ? 'checked' : '' ?> name="permissions[lr_view_userby]" class="custom-control-input" id="lr_view_userby">
                            <label class="custom-control-label" for="lr_view_userby">View UserBy</label>
                        </div>
                    </div>
                    <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                            <input type="hidden" name="permissions[lr_list_user]" value="0">
                            <input type="checkbox" value="1" <?= (isset($user['lr_list_user']) && $user['lr_list_user'] == 1) ? 'checked' : '' ?> name="permissions[lr_list_user]" class="custom-control-input" id="lr_list_user">
                            <label class="custom-control-label" for="lr_list_user">User List</label>
                        </div>
                    </div>
                    <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                            <input type="hidden" name="permissions[lr_add_user]" value="0">
                            <input type="checkbox" value="1" <?= (isset($user['lr_add_user']) && $user['lr_add_user'] == 1) ? 'checked' : '' ?> name="permissions[lr_add_user]" class="custom-control-input" id="lr_add_user">
                            <label class="custom-control-label" for="lr_add_user">Add</label>
                        </div>
                    </div>
                    <div class="form-group mr-4">
                        <div class="custom-control custom-checkbox">
                            <input type="hidden" name="permissions[lr_edit_user]" value="0">
                            <input type="checkbox" value="1" <?= (isset($user['lr_edit_user']) && $user['lr_edit_user'] == 1) ? 'checked' : '' ?> name="permissions[lr_edit_user]" class="custom-control-input" id="lr_edit_user">
                            <label class="custom-control-label" for="lr_edit_user">Edit</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex">
                <a href="<?= base_url('users/user_management') ?>" class="btn btn-warning" onclick="return confirmCancel()">
                        <i class="fa fa-left"></i> CANCEL
                    </a>
                <button type="submit" class="btn btn-primary ml-auto"> <?= (isset($userdetails)) ? 'UPDATE' : 'SAVE' ?></button>
            </div>
            <br>
        </form>
    </div>
</section>
<?= view('layout/footer') ?>
<!-- /.content -->

<script>
$(document).ready(function() {
    $('#adduser').on('submit', function (e) {
        const newPass = $('#new_password').val();
        const confirmPass = $('#confirm_password').val();
        
        if (newPass || confirmPass) {
            if (newPass.length < 8) {
                alert('Password must be at least 8 characters.');
                $('#new_password').focus();
                return false;
            }
            
            if (newPass !== confirmPass) {
                alert('Password confirmation does not match.');
                $('#confirm_password').focus();
                return false;
            }
        }

        const email = $('#u_email').val();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!emailRegex.test(email)) {
            alert('Please enter a valid email address.');
            $('#u_email').focus();
            return false;
        }
        return true;
    });
});

function capitalizeEachWord(str) {
    return str.toLowerCase().replace(/\b\w/g, function(letter) {
        return letter.toUpperCase();
    });
}
</script>