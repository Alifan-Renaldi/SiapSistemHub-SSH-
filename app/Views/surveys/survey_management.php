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
                            <a href="javascript:void(0)" 
                               class="btn btn-link text-info p-0 border-0"
                               title="Print / Download Gambar"
                               onclick="showPrintOptions(<?= $survey['s_id'] ?>, '<?= esc(date('d-m-Y', strtotime($survey['s_tanggal']))) ?>', '<?= esc($survey['s_supir']) ?>')">
                                <i class="fa fa-print" title="Print"></i>
                            </a>
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
<script src="<?= base_url('assets/js/html2canvas.min.js') ?>"></script>
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

function showPrintOptions(id, tanggal, supir) {
      Swal.fire({
          title: '<i class="fa fa-print" style="color:#17a2b8; margin-right:8px;"></i> Print / Download',
          html: '<div style="text-align:center; padding:10px 0;">' +
                '<div style="background:#f8f9fa; border-radius:8px; padding:15px; margin-bottom:15px;">' +
                '<table style="width:100%; font-size:14px; border-collapse:collapse;">' +
                '<tr><td style="padding:8px; text-align:left; color:#868e96; font-weight:600; font-size:12px; text-transform:uppercase;">Tanggal Survey</td>' +
                '<td style="padding:8px; text-align:right; font-weight:700; font-size:16px; color:#2c3e50;">'+ tanggal + '</td></tr>' +
                '<tr><td style="padding:8px; text-align:left; color:#868e96; font-weight:600; font-size:12px; text-transform:uppercase;">Nama Supir</td>' +
                '<td style="padding:8px; text-align:right; font-weight:700; font-size:16px; color:#2c3e50;">' + supir + '</td></tr>' +
                '</table></div>' +
                '</div>',
          showDenyButton: true,
          confirmButtonText: '<i class="fa fa-image"></i> Download Gambar',
          denyButtonText: '<i class="fa fa-print"></i> Print',
          confirmButtonColor: '#3085d6',
          denyButtonColor: '#28a745',
          width: 420,
      }).then((result) => {
          if (result.isConfirmed) {
                chooseImageFormat(id, tanggal, supir);
          } else if (result.isDenied) {
              window.location.href = '<?= base_url('surveys/survey_print/') ?>' + id;
          }
      });
   }

function chooseImageFormat(id, tanggal, supir) {
      Swal.fire({
          title: '<i class="fa fa-image" style="color:#fd7e14; margin-right:8px;"></i> Download Gambar Survey',
          html: '<p style="color:#666; font-size:13px; margin:0 0 12px;">Pilih format file gambar</p>' +
                '<div style="display:flex; gap:8px; justify-content:center;">' +
                '<button class="fmt-btn" data-format="jpg" style="background:#ffc107; color:#212529; border:none; border-radius:6px; padding:10px 18px; font-size:14px; font-weight:600; cursor:pointer;">JPG</button>' +
                '<button class="fmt-btn" data-format="jpeg" style="background:#fd7e14; color:#fff; border:none; border-radius:6px; padding:10px 18px; font-size:14px; font-weight:600; cursor:pointer;">JPEG</button>' +
                '<button class="fmt-btn" data-format="png" style="background:#007bff; color:#fff; border:none; border-radius:6px; padding:10px 18px; font-size:14px; font-weight:600; cursor:pointer;">PNG</button>' +
                '</div>',
          showCancelButton: true,
          cancelButtonText: 'Batal',
          cancelButtonColor: '#d33',
          width: 420,
          didOpen: () => {
              document.querySelectorAll('.fmt-btn').forEach((btn) => {
                  btn.addEventListener('click', () => {
                      Swal.close();
                      downloadSurveyImage(id, tanggal, supir, btn.getAttribute('data-format'));
                  });
              });
          }
      });
   }

async function downloadSurveyImage(id, tanggal, supir, format) {
      const mime = (format === 'png') ? 'image/png' : 'image/jpeg';
      const cleanSupir = (supir || 'survey').replace(/[^A-Za-z0-9_]/g, '_');
      const cleanTanggal = (tanggal || '').replace(/[^A-Za-z0-9]/g, '-');
      const filename = 'Survey_' + cleanSupir + '_' + cleanTanggal + '.' + format;

      Swal.fire({
          title: 'Membuat gambar...',
          html: 'Mohon tunggu, gambar sedang diproses.',
          allowOutsideClick: false,
          allowEscapeKey: false,
          didOpen: () => {
              Swal.showLoading();
          }
      });

      let iframe = null;
      try {
          if (typeof html2canvas === 'undefined') {
              throw new Error('Library html2canvas tidak termuat. Muat ulang halaman (Ctrl+F5) atau cek koneksi.');
          }

          const resp = await fetch(baseUrl + 'surveys/survey_image/' + id);
          if (!resp.ok) {
              throw new Error('Gagal memuat halaman survey (HTTP ' + resp.status + ')');
          }
          const html = await resp.text();

          iframe = document.createElement('iframe');
          iframe.style.cssText = 'position:fixed; left:-10000px; top:0; width:860px; height:1200px; border:none;';
          document.body.appendChild(iframe);

          const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
          iframeDoc.open();
          iframeDoc.write(html);
          iframeDoc.close();

          await new Promise((resolve) => {
              if (iframeDoc.readyState === 'complete') {
                  resolve();
              } else {
                  iframe.addEventListener('load', resolve);
                  setTimeout(resolve, 4000);
              }
          });

          await Promise.race([
              Promise.all(Array.from(iframeDoc.images).map((img) => {
                  if (img.complete) return Promise.resolve();
                  return new Promise((resolve) => {
                      img.addEventListener('load', resolve);
                      img.addEventListener('error', resolve);
                  });
              })),
              new Promise((resolve) => setTimeout(resolve, 5000))
          ]);

          const captureArea = iframeDoc.querySelector('#survey-capture-area') || iframeDoc.body;
          const canvas = await html2canvas(captureArea, {
              scale: 2,
              backgroundColor: '#ffffff',
              logging: false,
              windowWidth: 860
          });

          const dataUrl = canvas.toDataURL(mime, 0.95);
          const link = document.createElement('a');
          link.href = dataUrl;
          link.download = filename;
          document.body.appendChild(link);
          link.click();
          link.remove();

          Swal.fire({
              icon: 'success',
              title: 'Gambar berhasil diunduh!',
              text: filename,
              timer: 2500,
              showConfirmButton: false
          });
      } catch (e) {
          console.error(e);
          Swal.fire({
              icon: 'error',
              title: 'Gagal membuat gambar',
              text: e.message || 'Terjadi kesalahan saat memproses gambar.'
          });
      } finally {
          if (iframe && iframe.parentNode) {
              iframe.parentNode.removeChild(iframe);
          }
      }
   }
</script>