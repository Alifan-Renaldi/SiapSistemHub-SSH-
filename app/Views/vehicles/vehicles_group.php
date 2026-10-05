<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Vehicle Type</h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
               <li class="breadcrumb-item"><a href="<?= base_url('vehicles/vehicles_management'); ?>">Vehicle</a></li>
               <li class="breadcrumb-item active">Vehicle Type</li>
            </ol>
         </div>
      </div>
      <?php if (function_exists('userpermission') && userpermission('lr_vech_group_add')) : ?>
      <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-add">
      Add Vehicle Type
      </button>
      <?php endif; ?>
   </div>
</div>
<section class="content">
   <div class="container-fluid">
      <div class="card">
         <div class="card-body p-0">
            <div class="table-responsive">
               <table id="vehiclelisttbl" class="table card-table table-vcenter text-nowrap">
                  <thead>
                     <tr>
                        <th class="w-1">No</th>
                        <th>Tipe Bak</th>
                        <th>Keterangan</th>
                        <th>Created Date</th>
                        <?php if(userpermission('lr_vech_group_action')) { ?>
                        <th>Action</th>
                        <?php } ?>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if(!empty($vehiclegroup)) { $count = 1;
                        foreach($vehiclegroup as $vehiclegroupdata) {
                        ?>
                     <tr>
                        <td><?= esc($count); $count++; ?></td>
                        <td><?= esc($vehiclegroupdata['gr_name']); ?></td>
                        <td><?= esc($vehiclegroupdata['gr_desc']); ?></td>
                        <td><?= esc($vehiclegroupdata['gr_created_date']); ?></td>
                        <td>
                           <?php if (function_exists('userpermission') && userpermission('lr_vech_group_action')) : ?>
                           <a class="icon" href="<?= base_url('vehicle/vehiclegroup_delete/'.esc($vehiclegroupdata['gr_id'], 'url')); ?>">
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
          <a href="<?= base_url('vehicles/vehicles_management'); ?>">
              <i class="fa fa-arrow-left"></i> Back to List Vehicle
          </a>
      </div>
   </div>
</section>
<div class="modal fade show" id="modal-add" aria-modal="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Add New Type</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
         </div>
         <div class="modal-body">
            <form id="geofencesave" method="post" action="<?= base_url('vehicle/addgroup'); ?>">
               <div class="card-body">
                  <div class="form-group row">
                     <label for="geo_name" class="col-sm-4 col-form-label">Tipe Bak</label>
                     <div class="form-group col-sm-8">
                        <input type="text" class="form-control" name="gr_name" id="gr_name" required placeholder="Tipe Bak">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="Cateogry" class="col-sm-4 col-form-label">Keterangan</label>
                     <div class="form-group col-sm-8">
                        <input type="text" class="form-control" name="gr_desc" id="gr_desc" required placeholder="Deskripsi Tipe">
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