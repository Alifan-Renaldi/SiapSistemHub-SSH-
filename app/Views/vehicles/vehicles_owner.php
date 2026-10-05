<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Vehicle Owner</h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
               <li class="breadcrumb-item"><a href="<?= base_url('vehicles/vehicles_management'); ?>">Vehicle</a></li>
               <li class="breadcrumb-item active">Vehicle Owner</li>
            </ol>
         </div>
      </div>
      <?php if (function_exists('userpermission') && userpermission('lr_vech_group_add')) : ?>
      <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-add">
      Add Vehicle Owner
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
                        <th>Legal</th>
                        <th>Keterangan</th>
                        <th>Created Date</th>
                        <?php if(userpermission('lr_vech_group_action')) { ?>
                        <th>Action</th>
                        <?php } ?>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if(!empty($vehicleowner)) { $count = 1;
                        foreach($vehicleowner as $vehicleownerdata) {
                        ?>
                     <tr>
                        <td><?= esc($count); $count++; ?></td>
                        <td><?= esc($vehicleownerdata['ow_name']); ?></td>
                        <td><?= esc($vehicleownerdata['ow_desc']); ?></td>
                        <td><?= esc($vehicleownerdata['ow_created_date']); ?></td>
                        <td>
                            <?php if (function_exists('userpermission') && userpermission('lr_vech_group_action')) : ?>
                           <a class="icon" href="<?= base_url('vehicle/vehiclegroup_delete/'.esc($vehicleownerdata['ow_id'], 'url')); ?>">
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
            <h4 class="modal-title">Add New Owner</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
         </div>
         <div class="modal-body">
            <form id="geofencesave" method="post" action="<?= base_url('vehicle/addowner'); ?>">
               <div class="card-body">
                  <div class="form-group row">
                     <label for="geo_name" class="col-sm-4 col-form-label">Nama Pemilik</label>
                     <div class="form-group col-sm-8">
                        <input type="text" class="form-control" name="ow_name" id="ow_name" required placeholder="Legal/Pemilik">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="Cateogry" class="col-sm-4 col-form-label">Keterangan</label>
                     <div class="form-group col-sm-8">
                        <input type="text" class="form-control" name="ow_desc" id="ow_desc" required placeholder="Deskripsi Pemilik">
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