<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Merek Velg List</h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
               <li class="breadcrumb-item"><a href="<?= base_url('handover/handover_management'); ?>">Handover</a></li>
               <li class="breadcrumb-item active">Merek Velg</li>
            </ol>
         </div>
      </div>
      <?php if (function_exists('userpermission') && userpermission('lr_vech_merk_group_add')) : ?>
      <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-add">
      Add Merek Velg
      </button>
      <?php endif; ?>
   </div>
</div>
<section class="content">
   <div class="container-fluid">
      <div class="card">
         <div class="card-body p-0">
            <div class="table-responsive">
               <table id="handovermerkvelgtbl" class="table card-table table-vcenter text-nowrap">
                  <thead>
                     <tr>
                        <th class="w-1">No</th>
                        <th>Merek Velg</th>
                        <th>Keterangan</th>
                        <th>Created Date</th>
                        <?php if(userpermission('lr_vech_merk_group_action')) { ?>
                        <th>Action</th>
                        <?php } ?>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if(!empty($handovermerkvelg)) { $count = 1;
                        foreach($handovermerkvelg as $handovermerkvelgdata) {
                        ?>
                     <tr>
                        <td><?= esc($count); $count++; ?></td>
                        <td><?= esc($handovermerkvelgdata['mv_name']); ?></td>
                        <td><?= esc($handovermerkvelgdata['mv_desc']); ?></td>
                        <td><?= esc($handovermerkvelgdata['mv_created_date']); ?></td>
                        <td>
                            <?php if (function_exists('userpermission') && userpermission('lr_vech_merk_group_action')) : ?>
                           <a class="icon" href="<?= base_url('handover/handovermerkvelg_delete/'.esc($handovermerkvelgdata['mv_id'], 'url')); ?>">
                           <i class="fa fa-trash text-danger"></i>
                           </a> 
                           <?php endif; ?>
                        </td>
                     </tr>
                     <?php } } ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
      <div class="mb-5">
          <a href="<?= base_url('handover/handover_management'); ?>">
              <i class="fa fa-arrow-left"></i> Back to List Handover
          </a>
      </div>
   </div>
</section>
<div class="modal fade show" id="modal-add" aria-modal="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Add New Owner</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
         </div>
         <div class="modal-body">
            <form id="handovermerkvelgsave" method="post" action="<?= base_url('handover/addhandovermerkvelg'); ?>">
               <div class="card-body">
                  <div class="form-group row">
                     <label for="geo_name" class="col-sm-4 col-form-label">Merek Velg</label>
                     <div class="form-group col-sm-8">
                        <input type="text" class="form-control" name="mv_name" id="mv_name" required placeholder="Merek Velg">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="Cateogry" class="col-sm-4 col-form-label">Keterangan</label>
                     <div class="form-group col-sm-8">
                        <input type="text" class="form-control" name="mv_desc" id="mv_desc" required placeholder="Deskripsi Merek Velg">
                     </div>
                  </div>
               </div>
         </div>
         <div class="modal-footer justify-content-between">
         <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
         <button type="submit" id="geofenvaluesave" class="btn btn-primary">Save</button>
         </div>
         </form>
      </div>
   </div>
</div>
<?= view('layout/footer') ?>