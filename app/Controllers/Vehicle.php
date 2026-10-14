<?php 
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\VehicleModel;
use App\Models\DriversModel;
use App\Models\InventoryModel;
use App\Models\IncomexpenseModel;
use App\Models\GeofenceModel;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;

class Vehicle extends BaseController
{
    protected $vehicleModel;
    protected $driversModel;
    protected $incomexpenseModel;
    protected $geofenceModel;
    protected $session;
    protected $validation;

    public function __construct()
    {
        $this->vehicleModel = new VehicleModel();
        $this->driversModel = new DriversModel();
        $this->session = session();
        helper(['form', 'url', 'string', 'text', 'custom']);
    }

    public function index()
    {
        $data = [
            'vehiclelist' => $this->vehicleModel->getall_vehicle(),
            'v_group' => $this->vehicleModel->get_vehiclegroup(),
            'v_owner' => $this->vehicleModel->get_vehicleowner()
        ];
        return view('vehicles/vehicles_management', $data);
    }

    private function generateAndSaveQrCode(int $vehicleId, string $qrData): void
    {
        $result = Builder::create()
            ->writer(new PngWriter())
            ->writerOptions([])
            ->data($qrData)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::Quartile)
            ->size(300)
            ->margin(10)
            ->roundBlockSizeMode(RoundBlockSizeMode::Margin)
            ->build();

        $qrDir = WRITEPATH . 'uploads/qrcodes/vehicles/';
        if (!is_dir($qrDir)) {
            mkdir($qrDir, 0777, true);
        }

        $cleanPlate = preg_replace('/[^A-Za-z0-9_]/', '_', trim($qrData));
        $filename = 'qrcode_' . $cleanPlate . '_' . md5(uniqid()) . '.png';
        $filepath = $qrDir . $filename; 

        file_put_contents($filepath, $result->getString());

        $this->vehicleModel->update($vehicleId, [
            'v_qr_code_path' => 'writable/uploads/qrcodes/vehicles/' . $filename,
            'v_qr_code_filename' => $filename
        ]);
    }

    public function addvehicle()
    {
        if(!$this->session->getFlashdata('warningmessage')) {
            $this->session->remove('old_input');
        }
        $data = [
            'v_group' => $this->vehicleModel->get_vehiclegroup(),
            'v_owner' => $this->vehicleModel->get_vehicleowner()
        ];
        return view('vehicles/vehicles_add', $data);
    }

    public function insertvehicle()
    {
        $data = $this->request->getPost();

        if (empty($data)) {
            session()->setFlashdata('warningmessage', 'No data submitted.');
            return redirect()->to('vehicles/addvehicle');
        }

        // Set audit fields
        $data['v_created_by'] = session('user_id');
        $data['v_created_date'] = date('Y-m-d H:i:s');
        $data['v_is_active'] = 1;
        
        $dateFieldsToConvert = ['v_stnk_expdate', 'v_plat_expdate', 'v_kir_expdate', 'v_exp_insurance', 'v_kir_process_date'];
        foreach ($dateFieldsToConvert as $field) {
            if (!empty($data[$field])) {
                if (preg_match('/^\d{2}\-\d{2}\-\d{4}$/', $data[$field])) {
                    $dateObj = \DateTime::createFromFormat('d-m-Y', $data[$field]);
                    if ($dateObj) { 
                        $data[$field] = $dateObj->format('Y-m-d');
                    }
                }
            }
        }

        // Auto-calculate KIR process date (30 days AFTER KIR expiry)
        if (!empty($data['v_kir_expdate'])) {
            $kirExpiry = new \DateTime($data['v_kir_expdate']);
            $kirExpiry->modify('+31 days');
            $data['v_kir_process_date'] = $kirExpiry->format('Y-m-d');
        }

        // Set empty date fields to NULL (DATE column does not accept '0000-00-00')
        $dateFields = ['v_exp_insurance'];
        foreach ($dateFields as $field) {
            if (!isset($data[$field]) || trim($data[$field]) === '') {
                $data[$field] = '0000-00-00';
            }
        }

        // Remove fields not in DB
        unset($data['v_id']);

        $insert_id = $this->vehicleModel->insert($data);
        if ($insert_id) {
            // Generate QR code locally using Endroid QR Code (PngWriter)
            $qrData = json_encode(["Nopol:" . $data['v_registration_no'] .
            ", ". "Pemilik:" . $data['v_legal'] . ", " . "Type:" . $data['v_type'] 
            . ", " . "Jenis:" . $data['v_name'] . ", " . "Tahun:" . $data['v_reg_exp_date'] 
            . ", " . "Riwayat Waktu:" . $data['v_created_date']]);
            $this->generateAndSaveQrCode($insert_id, $qrData);

            session()->setFlashdata('successmessage', 'Vehicle added successfully.');
            return redirect()->to('vehicles/vehicles_management');
        } else {
            session()->setFlashdata('old_input', $data);
            session()->setFlashdata('warningmessage', 'Something went wrong. Try again.');
            return redirect()->to('vehicles/addvehicle');
        }
    }

    public function viewvehicle()
    {
        $vehicle_id = $this->request->getPost('vehicle_id');
    
        if (empty($vehicle_id)) {
            $vehicle_id = $this->request->getUri()->getSegment(3);
        }
        
        if (empty($vehicle_id)) {
            return redirect()->to('vehicles/vehicles_management')->with('error', 'Vehicle tidak ditemukan');
        }
        $vehicledetails = $this->vehicleModel->get_vehicledetails($vehicle_id);

        if (empty($vehicledetails)) {
            return redirect()->to('vehicles/vehicles_management')->with('error', 'Vehicle tidak ditemukan');
        }

        $data = [
            'v_group' => $this->vehicleModel->get_vehiclegroup(),
            'v_owner' => $this->vehicleModel->get_vehicleowner(),
            'vehicledetails' => $vehicledetails[0],
            'bookings' => $this->vehicleModel->getall_bookings($vehicle_id),
            'vechicle_incomexpense' => [],
            'vechicle_geofence' => []
        ];
        return view('vehicles/vehicles_view', $data);
    }

    public function editvehicle()
    {
        $vehicle_id = $this->request->getPost('vehicle_id');
    
        if (empty($vehicle_id)) {
            $vehicle_id = $this->request->getUri()->getSegment(3);
        }
        
        if (empty($vehicle_id)) {
            return redirect()->to('/pagenotfound')->with('error', 'Vehicle tidak ditemukan');
        }
        $data = [
            'v_group' => $this->vehicleModel->get_vehiclegroup(),
            'v_owner' => $this->vehicleModel->get_vehicleowner(),
            'vehicledetails' => $this->vehicleModel->get_vehicledetails($vehicle_id)
        ];
        return view('vehicles/vehicles_add', $data);
    }

    /**
     * Generate a QR code PNG using Endroid and save it to disk.
     * Updates the vehicle record with the file path.
     */

    // public function qr_code_filename()
    // {
        
    // }
    /**
     * Serve the QR code image for display in the browser (used by viewQRCode JS).
     */
    public function view_qrcode($vehicleId)
    {
        $vehicle = $this->vehicleModel->find($vehicleId);
        if (empty($vehicle) || empty($vehicle['v_qr_code_path'])) {
            // Regenerate if missing
            if (!empty($vehicle)) {
                $this->generateAndSaveQrCode($vehicleId, $vehicle['v_registration_no']);
                $vehicle = $this->vehicleModel->find($vehicleId);
            }
            if (empty($vehicle) || empty($vehicle['v_qr_code_path'])) {
                return $this->response->setStatusCode(404)->setBody('QR Code not found');
            }
        }

        // Try writable path first
        $filepath = WRITEPATH . 'uploads/qrcodes/vehicles/' . basename($vehicle['v_qr_code_path']);
        
        if (!file_exists($filepath)) {
            $filepath = FCPATH . $vehicle['v_qr_code_path'];
        }

        if (!file_exists($filepath)) {
            // Regenerate the file
            $this->generateAndSaveQrCode($vehicleId, $vehicle['v_registration_no']);
            $vehicle = $this->vehicleModel->find($vehicleId);
            $filepath = WRITEPATH . 'uploads/qrcodes/vehicles/' . basename($vehicle['v_registration_no']);

        }

        return $this->response
            ->setHeader('Content-Type', 'image/png')
            ->setHeader('Cache-Control', 'public, max-age=86400')
            ->setBody(file_get_contents($filepath));
    }

    /**
     * Download the QR code image as a PNG file.
     */
    public function download_qrcode($vehicleId)
    {
        $vehicle = $this->vehicleModel->find($vehicleId);
        if (empty($vehicle) || empty($vehicle['v_qr_code_path'])) {
            // Try to regenerate if vehicle exists but QR is missing
            if (!empty($vehicle)) {
                $qrData = json_encode([
                    "Nopol:" . ($vehicle['v_registration_no'] ?? ''),
                    "Type:" . ($vehicle['v_type'] ?? ''),
                    "Jenis:" . ($vehicle['v_name'] ?? ''),
                ]);
                $this->generateAndSaveQrCode((int)$vehicleId, $qrData);
                $vehicle = $this->vehicleModel->find($vehicleId);
            }
            if (empty($vehicle) || empty($vehicle['v_qr_code_path'])) {
                session()->setFlashdata('warningmessage', 'QR Code not found.');
                return redirect()->to('vehicles/vehicles_management');
            }
        }

        $filepath = WRITEPATH . 'uploads/qrcodes/vehicles/' . 
        basename($vehicle['v_qr_code_path'], basename($vehicle['v_registration_no']));

        if (!file_exists($filepath)) {
            $filepath = FCPATH . $vehicle['v_qr_code_path'] . $vehicle['v_registration_no'];
        }

        if (!file_exists($filepath)) {
            // Regenerate the QR code file
            $qrData = json_encode([
                "Nopol:" . ($vehicle['v_registration_no'] ?? ''),
                "Type:" . ($vehicle['v_type'] ?? ''),
                "Jenis:" . ($vehicle['v_name'] ?? ''),
            ]);
            $this->generateAndSaveQrCode((int)$vehicleId, $qrData);
            $vehicle = $this->vehicleModel->find($vehicleId);
            $filepath = WRITEPATH . 'uploads/qrcodes/vehicles/' . basename($vehicle['v_qr_code_path']);
        }

        $filename = 'QRCode_' . preg_replace('/[^A-Za-z0-9_]/', '_', $vehicle['v_registration_no']) . '.png';

        return $this->response->download($filepath, null)->setFileName($filename);
    }

    /**
     * Generate a page displaying the QR code with vehicle label information.
     */
    // public function generate_qrcode_with_label($vehicleId)
    // {
    //     $vehicle = $this->vehicleModel->find($vehicleId);
    //     if (empty($vehicle)) {
    //         session()->setFlashdata('warningmessage', 'Vehicle not found.');
    //         return redirect()->to('vehicles/vehicles_management');
    //     }

    //     $imageUrl = base_url('vehicles/view_qrcode/' . $vehicleId);

    //     $data = [
    //         'title'       => 'QR Code - ' . esc($vehicle['v_registration_no']),
    //         'imageUrl'    => $imageUrl,
    //         'regNo'       => esc($vehicle['v_registration_no']),
    //         'vehicleName' => esc($vehicle['v_name']),
    //         'vehicleType' => esc($vehicle['v_type']),
    //     ];

    //     return view('vehicles/vehicle_qrcode_label', $data);
    // }

    public function print_qrcode($vehicleId)
    {
        $vehicle = $this->vehicleModel->get_vehicledetails($vehicleId);
        if (!$vehicle) {
            session()->setFlashdata('warningmessage', 'QR Code not found.');
            return redirect()->to('vehicles/vehicles_management');
        }
        if ($this->request->getVar('new') === 'true') {
        session()->setFlashdata('successmessage', 'New Inventory added successfully.');
        }

        // $imageUrl = base_url('vehicles/view_qrcode/' . $vehicleId);
        // $title = 'QR Code - ' . esc($vehicle['v_registration_no']);

        // $data = [
        //     'title' => $title,
        //     'imageUrl' => $imageUrl,
        //     'regNo' => esc($vehicle['v_registration_no']),
        //     'vehicleName' => esc($vehicle['v_name']),
        //     'vehicleType' => esc($vehicle['v_type']),
        // ];

        return view('vehicles/vehicle_qrcode_label', ['vehicledetails' => $vehicle]);
    }

    public function updatevehicle()
    {
        $data = $this->request->getPost();
        $v_id = $data['v_id'] ?? '';

        if (empty($v_id)) {
            session()->setFlashdata('warningmessage', 'Vehicle ID not found.');
            return redirect()->to('vehicles/vehicles_management');
        }

        // Convert date fields from dd/mm/yyyy to yyyy-mm-dd format
        $dateFieldsToConvert = ['v_stnk_expdate', 'v_plat_expdate', 'v_kir_expdate', 'v_exp_insurance', 'v_kir_process_date'];
        foreach ($dateFieldsToConvert as $field) {
            if (!empty($data[$field])) {
                if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $data[$field])) {
                    $dateObj = \DateTime::createFromFormat('d-m-Y', $data[$field]);
                    if ($dateObj) {
                        $data[$field] = $dateObj->format('Y-m-d');
                    }
                }
            }
        }

        // data modified user dan modified date diisi saat update
        $data['v_created_by'] = session('user_id');
        $data['v_created_date'] = date('Y-m-d H:i:s');

        // Auto-calculate KIR process date (30 days AFTER KIR expiry)
        if (!empty($data['v_kir_expdate'])) {
            $kirExpiry = new \DateTime($data['v_kir_expdate']);
            $kirExpiry->modify('+31 days');
            $data['v_kir_process_date'] = $kirExpiry->format('Y-m-d');
        }

        // Set empty date fields to NULL (DATE column does not accept '0000-00-00')
        $dateFields = ['v_exp_insurance'];
        foreach ($dateFields as $field) {
            if (!isset($data[$field]) || trim($data[$field]) === '') {
                $data[$field] = '0000-00-00';
            }
        }

        // Check if license plate changed — we'll need to regenerate QR code
        $existingVehicle = $this->vehicleModel->find($v_id);
        $plateChanged = !empty($data['v_registration_no']) 
            && $existingVehicle 
            && $existingVehicle['v_registration_no'] !== $data['v_registration_no'];

        // Remove primary key from update payload
        unset($data['v_id']);

        $response = $this->vehicleModel->update($v_id, $data);
        if ($response) {
            // Regenerate QR code if license plate was changed
            if ($plateChanged) {
                // Delete old QR code file if it exists
                if (!empty($existingVehicle['v_qr_code_path'])) {
                    $oldFile = WRITEPATH . 'uploads/qrcodes/vehicles/' . basename($existingVehicle['v_registration_no']);
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }
                // Generate new QR code with updated license plate
                 $this->generateAndSaveQrCode((int)$v_id,json_encode(["Nopol:". $data['v_registration_no'], ", ". "Pemilik:" . $data['v_legal'] . ", " . "Type:" . $data['v_type'] 
            . ", " . "Jenis:" . $data['v_name'] . ", " . "Tahun:" . $data['v_reg_exp_date'] 
            . ", " . "Riwayat Waktu:" . $data['v_created_date']]));
            }

            if ($plateChanged) {
                // Delete old QR code file if it exists
                if (empty($existingVehicle['v_qr_code_path'])) {
                    $oldFile = WRITEPATH . 'uploads/qrcodes/vehicles/' . basename($existingVehicle['v_registration_no']);
                }
                // Generate new QR code with updated license plate
                 $this->generateAndSaveQrCode((int)$v_id,json_encode(["Nopol:". $data['v_registration_no'], ", ". "Pemilik:" . $data['v_legal'] . ", " . "Type:" . $data['v_type'] 
            . ", " . "Jenis:" . $data['v_name'] . ", " . "Tahun:" . $data['v_reg_exp_date'] 
            . ", " . "Riwayat Waktu:" . $data['v_created_date']]));
            }

            session()->setFlashdata('successmessage', 'Vehicle updated successfully.');
            return redirect()->to('vehicles/vehicles_management');
        } else {
            session()->setFlashdata('warningmessage', 'Something went wrong. Try again.');
            return redirect()->to('vehicles/editvehicle/' . $v_id);
        }
    }

    public function vehicle_delete($v_id)
    {
        if (!$this->request->is('post')) {
            return redirect()->to('vehicles/vehicles_management');
        }

        try {
            $returndata = $this->vehicleModel->vehicle_delete($v_id);
            
            if ($returndata) {
                return redirect()->to('vehicles/vehicles_management')->with('successmessage', 'Vehicle deleted successfully.');
            } else {
                return redirect()->to('vehicles/vehicles_management')->with('warningmessage', 'Failed to delete vehicle.');
            }
        } catch (\Exception $e) {
            log_message('error', 'Failed to delete vehicle: ' . $e->getMessage());
            return redirect()->to('vehicles/vehicles_management')->with('warningmessage', 'Error occurred while deleting vehicle.');
        }
    }

    public function vehiclegroup()
    {
        $data = [
            'vehiclegroup' => $this->vehicleModel->get_vehiclegroup()
        ];
        return view('vehicles/vehicles_group', $data);
    }

    public function vehiclegroup_delete()
    {
        $gr_id = $this->request->getUri()->getSegment(3);
        $returndata = $this->vehicleModel->vehiclegroup_delete($gr_id);
        if($returndata) {
            $this->session->setFlashdata('successmessage', 'Group deleted successfully..');
        } else {
            $this->session->setFlashdata('warningmessage', 'Error..! Some vechicle are mapped with this group. Please remove from vechicle management');
        }
        return redirect()->to('vehicles/vehiclegroup');
    }

    public function addgroup()
    {
        $db = \Config\Database::connect();
        $response = $db->table('vehicle_group')->insert($this->request->getPost());
        if($response) {
            $this->session->setFlashdata('successmessage', 'Group added successfully..');
        } else {
            $this->session->setFlashdata('warningmessage', 'Something went wrong..Try again');
        }
        return redirect()->to('vehicles/vehiclegroup');
    }

    public function vehicleowner()
    {
        $data = [
            'vehicleowner' => $this->vehicleModel->get_vehicleowner()
        ];
        return view('vehicles/vehicles_owner', $data);
    }

    public function addowner()
    {
        $db = \Config\Database::connect();
        $response = $db->table('vehicle_owner')->insert($this->request->getPost());
        if($response) {
            $this->session->setFlashdata('successmessage', 'Owner added successfully..');
        } else {
            $this->session->setFlashdata('warningmessage', 'Something went wrong..Try again');
        }
        return redirect()->to('vehicles/vehicleowner');
    }

    public function vehicleowner_delete()
    {
        $ow_id = $this->request->getUri()->getSegment(3);
        $returndata = $this->vehicleModel->vehicleowner_delete($ow_id);
        if($returndata) {
            $this->session->setFlashdata('successmessage', 'Owner deleted successfully..');
        } else {
            $this->session->setFlashdata('warningmessage', 'Error..! Some vechicle are mapped with this owner. Please remove from vechicle management');
        }
        return redirect()->to('vehicles/vehicleowner');
    }

    public function printinventory($invent_id)
    {
        $invdetails = $this->vehicleModel->get_inventorydetails($invent_id);
        if (!$invdetails) {
            session()->setFlashdata('error', 'Data tidak ditemukan.');
            return redirect()->to('inventory/inventory_management');
        }
        if ($this->request->getVar('new') === 'true') {
        session()->setFlashdata('successmessage', 'New Inventory added successfully.');
        }
        return view('inventory/inventory_print', ['invdetails' => $invdetails]);
    }

    public function downloadInventoryPdf($invent_id)
    {
        helper('pdf');

        $invdetails = $this->vehicleModel->get_inventorydetails($invent_id);
        if (!$invdetails) {
            session()->setFlashdata('error', 'Data tidak ditemukan.');
            return redirect()->to('inventory/inventory_management');
        }

        // Extract single item and free the original array
        $singleItem = $invdetails[0];
        unset($invdetails);

        $nopol = $singleItem['iv_nopol'] ?? 'inventory';
        $cleanNopol = preg_replace('/[^A-Za-z0-9_]/', '_', $nopol);
        $filename = "Inventory_{$cleanNopol}_" . date('Y-m-d') . ".pdf";
        unset($nopol, $cleanNopol);

        // inventory_pdf.php expects $inventorys (single item detail)
        $data = [
            'inventorys' => $singleItem,
        ];
        unset($singleItem);

        return streamPdf('inventory/data_inventory_pdf', $data, $filename, true);
    }

    public function inventorylist_vehicle()
    {
        $data = [
            'vehiclelist' => $this->vehicleModel->getall_vehicle(),
            'inventorylist' => $this->vehicleModel->getInventory(),
        ];

        $checkFields = [
            'iv_stnk', 'iv_kir', 'iv_kabin', 'iv_dongkrak', 'iv_kunci',
            'iv_stang', 'iv_spanner', 'iv_serep', 'iv_gantungan',
            'iv_ramkk', 'iv_ramdb', 'iv_karpetd', 'iv_karpetb',
            'iv_tambang', 'iv_tarpolin', 'iv_plastik', 'iv_lidah',
            'iv_badong', 'iv_kojong','iv_jumlah'
        ];

        foreach ($data['inventorylist'] as &$row) {
            $lengkap = 0;
            $rusak = 0;
            $tidak_lengkap = 0;

            foreach ($checkFields as $field) {
                $value = $row[$field] ?? '';

                if (empty($value) || $value === '-') {
                    continue;
                }

                if (stripos($value, 'Tidak Ada') !== false) {
                    $tidak_lengkap++;
                } elseif (stripos($value, 'Rusak') !== false || stripos($value, 'Kurang') !== false) {
                    $rusak++;
                } else {
                    $lengkap++;
                }
            }

            $row['lengkap_count'] = $lengkap;
            $row['rusak_count'] = $rusak;
            $row['tidak_lengkap_count'] = $tidak_lengkap;
        }
        
        unset($row); // break reference
        return view('inventory/inventory_management', $data);
    }

    public function addinventory()
    {
        if(!$this->session->getFlashdata('warningmessage')) {
            $this->session->remove('old_input');
        }
        $last_ivcode = $this->vehicleModel->get_last_ivcode();
        $data['new_inv_code'] = $this->generateInvCode($last_ivcode);
        $data['vechiclelist'] = $this->vehicleModel->getall_vehicle();
        return view('inventory/inventory_add', $data);
    }

    public function insertinventory()
    {
        $data = $this->request->getPost();

        // Map of photo_data field => database column
        $photoMapping = [
            'front_photo_data' => 'foto_dpn',
            'left_photo_data'  => 'foto_kiri',
            'right_photo_data' => 'foto_kanan',
            'back_photo_data'  => 'foto_blk',
        ];

        $data['iv_is_active'] = 1;

        foreach ($photoMapping as $dataField => $dbColumn) {
            $photoData = $data[$dataField] ?? '';
            if (!empty($photoData)) {
                $data[$dbColumn] = $this->saveInventoryPhoto($photoData, ($data['iv_nopol'] ?? 'inventory') . '_' . $dbColumn);
            }
            // Remove the non-database field
            unset($data[$dataField]);
        }

        // Remove fields not in the database table
        unset($data['iv_id']);

        $data['iv_created_by'] = session('user_id');
        $data['iv_created_date'] = date('Y-m-d H:i:s');

        $response = $this->vehicleModel->insert_inventory($data);
        if ($response) {
            $this->session->setFlashdata('successmessage', 'Inventory added successfully..');
        } else {
            $this->session->setFlashdata('warningmessage', 'Something went wrong..Try again');
        }
        return redirect()->to('inventory/inventory_management');
    }

    public function editinventory() 
    {
        $inv_id = $this->request->getPost('inv_id');
    
        if (empty($inv_id)) {
            $inv_id = $this->request->getUri()->getSegment(3);
        }
        
        if (empty($inv_id)) {
            return redirect()->to('/pagenotfound')->with('error', 'Inventory tidak ditemukan');
        }
        $last_ivcode = $this->vehicleModel->get_last_ivcode();
        $data['new_inv_code'] = $this->generateInvCode($last_ivcode);
        $data['vechiclelist'] = $this->vehicleModel->getall_vehicle();
        $data['inventorydetails'] = $this->vehicleModel->get_inventorydetails($inv_id);
        return view('inventory/inventory_add', $data);
    }

    public function updateinventory()
    {
        $data = $this->request->getPost();

        // Map of photo_data field => database column
        $photoMapping = [
            'front_photo_data' => 'foto_dpn',
            'left_photo_data'  => 'foto_kiri',
            'right_photo_data' => 'foto_kanan',
            'back_photo_data'  => 'foto_blk',
        ];

        foreach ($photoMapping as $dataField => $dbColumn) {
            $photoData = $data[$dataField] ?? '';
            if (!empty($photoData)) {
                $data[$dbColumn] = $this->saveInventoryPhoto($photoData, ($data['iv_nopol'] ?? 'inventory') . '_' . $dbColumn);
            }
            // Remove the non-database field
            unset($data[$dataField]);
        }

        $data['iv_modified_date'] = date('Y-m-d H:i:s');

        $response = $this->vehicleModel->update_inventory($data);
        if ($response) {
            $this->session->setFlashdata('successmessage', 'Inventory updated successfully..');
        } else {
            $this->session->setFlashdata('warningmessage', 'Something went wrong..Try again');
        }
        return redirect()->to('inventory/inventory_management');
    }
    public function viewinventory()
    {
        $inv_id = $this->request->getPost('inv_id');
    
        if (empty($inv_id)) {
            $inv_id = $this->request->getUri()->getSegment(3);
        }
        
        if (empty($inv_id)) {
            return redirect()->to('/pagenotfound')->with('error', 'Inventory tidak ditemukan');
        }
        $inventorydetails = $this->vehicleModel->get_inventorydetails($inv_id);

        if (isset($inventorydetails[0]['iv_id'])) {
            $data['inventorydetails'] = $inventorydetails[0];
            $data['foto_dpn'] = $inventorydetails[0]['foto_dpn'] ?? '';
            $data['foto_kiri'] = $inventorydetails[0]['foto_kiri'] ?? '';
            $data['foto_kanan'] = $inventorydetails[0]['foto_kanan'] ?? '';
            $data['foto_blk'] = $inventorydetails[0]['foto_blk'] ?? '';

            return view('inventory/inventory_view', $data);
        } else {
            return view('pagenotfound');
        }
    }

    public function inventory_delete($iv_id)
    {
        $inventoryData = $this->vehicleModel->getInventoryById($iv_id);
        
        if ($inventoryData) {
            $this->deleteUploadedFiles($inventoryData);
            
            $returndata = $this->vehicleModel->inventory_delete($iv_id);
            
            if ($returndata) {
                session()->setFlashdata('successmessage', 'Inventory deleted successfully..');
                return redirect()->to('inventory/inventory_management');
            } else {
                session()->setFlashdata('warningmessage', 'Failed to delete inventory from database');
                return redirect()->to('inventory/inventory_management');
            }
        } else {
            session()->setFlashdata('warningmessage', 'Inventory not found');
            return redirect()->to('inventory/inventory_management');
        }
    }

    public function handoverlist_vehicle()
    {
        $data = [
            'inventorylist' => $this->vehicleModel->getInventory(),
            'handoverlist' => $this->vehicleModel->getHandover(),
            'ho_merk_ban' => $this->vehicleModel->get_handovermerkban(),
            'ho_merk_velg' => $this->vehicleModel->get_handovermerkvelg(),
        ];
        return view('handover/handover_management', $data);
    }

    public function addhandover()
    {
        $oldInput = session()->getFlashdata('old_input') ?: session()->get('old_input');

        if(!$this->session->getFlashdata('warningmessage')) {
            $this->session->remove('old_input');
        }
        $last_hocode = $this->vehicleModel->get_last_hocode();
        $data['new_hdo_code'] = $this->generateHdoCode($last_hocode);
        $data['inventorylist'] = $this->vehicleModel->getInventory();
        $data['driverlist'] = $this->driversModel->getall_drivers();
        $data['ho_merk_ban'] = $this->vehicleModel->get_handovermerkban();
        $data['ho_merk_velg'] = $this->vehicleModel->get_handovermerkvelg();
        $data['inventorys'] = $this->vehicleModel->get_distinct_inventory_data();
        $data['old_input'] = $oldInput;

        return view('handover/handover_add', $data);
    }
    
    public function edithandover() 
    {
        $hand_id = $this->request->getPost('hand_id');
    
        if (empty($hand_id)) {
            $hand_id = $this->request->getUri()->getSegment(3);
        }
        
        if (empty($hand_id)) {
            return redirect()->to('/pagenotfound')->with('error', 'Handover tidak ditemukan');
        }
        $last_hocode = $this->vehicleModel->get_last_hocode();
        $data['new_hdo_code'] = $this->generateHdoCode($last_hocode);
        $data['inventorylist'] = $this->vehicleModel->getInventory();
        $data['handoverdetails'] = $this->vehicleModel->get_handoverdetails($hand_id);
        $data['driverlist'] = $this->driversModel->getall_drivers();
        $data['ho_merk_ban'] = $this->vehicleModel->get_handovermerkban();  
        $data['ho_merk_velg'] = $this->vehicleModel->get_handovermerkvelg();  
        return view('handover/handover_add', $data);
    }

    public function viewhandover()
    {
        $hand_id = $this->request->getPost('hand_id');
    
        if (empty($hand_id)) {
            $hand_id = $this->request->getUri()->getSegment(3);
        }
        
        if (empty($hand_id)) {
            return redirect()->to('/pagenotfound')->with('error', 'Handover tidak ditemukan');
        }
        $handoverdetails = $this->vehicleModel->get_handoverdetails($hand_id);

        if (isset($handoverdetails[0]['ho_id'])) {
            $data['handoverdetails'] = $handoverdetails[0];

            $data['foto'] = $handoverdetails[0]['foto'] ?? '';

            return view('handover/handover_view', $data);
        } else {
            return view('pagenotfound');
        }
    }

    public function handover_delete($ho_id)
    {
        $handoverData = $this->vehicleModel->getHandoverById($ho_id);
            if ($handoverData) {
                $this->deleteUploadFiles($handoverData);
            $returndata = $this->vehicleModel->handover_delete($ho_id);
            if ($returndata) {
                session()->setFlashdata('successmessage', 'Handover deleted successfully..');
                return redirect()->to('handover/handover_management');
            } else {
                session()->setFlashdata('warningmessage', 'Error..! Some driver are mapped with this group. Please remove from Handover management');
                return redirect()->to('handover/handover_management');
            }
        }
    }

    public function inserthandover()
    {
        $validation = \Config\Services::validation();
        $validation->setRule('ho_tanggal', 'Tanggal', 'required');
        $validation->setRule('ho_nopol', 'Nomor Polisi', 'required');
        $validation->setRule('ho_supirlama', 'Supir Lama', 'required');
        $validation->setRule('ho_supirbaru', 'Supir Baru', 'required');

        $testxss = $this->request->getPost();

        if ($validation->withRequest($this->request)->run() && $testxss) {

            $data = $this->request->getPost();

            $dateFieldsToConvert = ['ho_tanggal'];
            foreach ($dateFieldsToConvert as $field) {
                if (!empty($data[$field])) {
                    if (preg_match('/^\d{2}\-\d{2}\-\d{4}$/', $data[$field])) {
                        $dateObj = \DateTime::createFromFormat('d-m-Y', $data[$field]);
                        if ($dateObj) {
                            $data[$field] = $dateObj->format('Y-m-d');
                        }
                    }
                }
            }

            // HANDLE FOTO KAMERA BASE 64
            $photoFilename = '';
            $photoData = $data['photo_data'] ?? '';
            if (!empty($photoData)) {
                $photoFilename = $this->saveBase64Photo($photoData, $data['ho_code'] ?? 'handover');
            }

            $data['foto'] = $photoFilename;
            $data['ho_created_by'] = session('user_id');
            $data['ho_created_date'] = date('Y-m-d H:i:s');
            $data['signature_date'] = date('Y-m-d H:i:s');
            
            if($data['ho_supirbaru'] == 'No Driver'){
            $data['is_verified'] = 0;
            $data['ho_status'] = "draft";
        } else {
            $data['is_verified'] = 1;
            $data['ho_status'] = "completed";
        }

            // HAPUS DATA JIKA TIDAK ADA DI DALAM TABLE DATABASE HANDOVER
            unset($data['ho_id']);
            unset($data['photo_data']);

            $response = $this->vehicleModel->add_handover($data);
            if ($response) {
                $db = \Config\Database::connect();
                $ho_id = $db->insertID();

                // STORE DATA UPDATE DATA BARU
                session()->set('handover_data', [
                    'ho_id' => $ho_id,
                    'ho_code' => $data['ho_code'] ?? '',
                    'ho_nopol' => $data['ho_nopol'] ?? ''
                ]);

                // MENUJU KEHALAMAN HANDOVER INVENTORY
                $nopol = rawurlencode($data['ho_nopol'] ?? '');
                return redirect()->to("handover/viewhandoverinventory/{$nopol}/{$ho_id}");
            } else {
                // SIMPAN DATA LAMA YANG SUDAH DIINPUTKAN OLEH USER
                session()->setFlashdata('old_input', $data);
                session()->setFlashdata('warningmessage', 'Something went wrong. Try again.');
                return redirect()->to('handover/addhandover');
            }
        } else {
            $errormsg = $validation->getErrors() ? implode('<br>', $validation->getErrors()) : '';
            if (!$testxss) {
                $errormsg = 'Error! Your input is not allowed. Please try again';
            }

            // MENYIMPAN DATA YANG SUDAH DIISI OLEH USER
            $oldInput = $this->request->getPost();
            session()->setFlashdata('old_input', $oldInput);
            session()->setFlashdata('warningmessage', $errormsg);
            return redirect()->to('handover/addhandover');
        }
    }

    public function updatehandover()
    {
        $data = $this->request->getPost();
        $data['ho_created_by'] = session('user_id');

        if (!$data) {
            session()->setFlashdata('warningmessage', 'No data submitted.');
            return redirect()->to('handover/handover_management');
        }

        $dateFieldsToConvert = ['ho_tanggal'];
            foreach ($dateFieldsToConvert as $field) {
                if (!empty($data[$field])) {
                    if (preg_match('/^\d{2}\-\d{2}\-\d{4}$/', $data[$field])) {
                        $dateObj = \DateTime::createFromFormat('d-m-Y', $data[$field]);
                        if ($dateObj) {
                            $data[$field] = $dateObj->format('Y-m-d');
                        }
                    }
                }
            }
            
        $data['ho_created_by'] = session('user_id');
        $data['ho_created_date'] = date('Y-m-d H:i:s');
        $data['signature_date'] = date('Y-m-d H:i:s');

        if($data['ho_supirbaru'] == 'No Driver'){
            $data['is_verified'] = 0;
            $data['ho_status'] = "draft";
        } else {
            $data['is_verified'] = 1;
            $data['ho_status'] = "completed";
        }

        // Handle photo from camera capture (base64 data)
        $photoData = $data['photo_data'] ?? '';
        if (!empty($photoData)) {
            // Delete old photo if exists
            $oldHandover = $this->vehicleModel->getHandoverById($data['ho_id']);
            if ($oldHandover && !empty($oldHandover['foto'])) {
                $oldPath = FCPATH . 'assets/uploads/vehicle_handover/' . $oldHandover['foto'];
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            $data['foto'] = $this->saveBase64Photo($photoData, $data['ho_code'] ?? 'handover');
        }

        // Remove fields that are not in the database table
        unset($data['photo_data']);

        $response = $this->vehicleModel->edit_handover($data);
        if ($response) {
            $ho_id = $data['ho_id'];

            // Store data in session for inventory handover flow
            session()->set('handover_data', [
                'ho_id' => $ho_id,
                'ho_code' => $data['ho_code'] ?? '',
                'ho_nopol' => $data['ho_nopol'] ?? ''
            ]);

            // Redirect to handover inventory view
            $nopol = rawurlencode($data['ho_nopol'] ?? '');
            return redirect()->to("handover/viewhandoverinventory/{$nopol}/{$ho_id}");
        } else {
            session()->setFlashdata('warningmessage', 'Something went wrong. Try again.');
            return redirect()->to('handover/edithandover/' . $data['ho_id']);
        }
    }

    public function viewhandoverinventory($nopol = null, $hand_id = null)
    { 
        // Jika nopol mengandung '/' (misal "BE 8280 AUE / BE 8575 BF"),
        // URL segment terpecah sehingga $hand_id bisa salah.
        // Solusi: scan semua URI segments untuk cari angka terakhir sebagai hand_id.
        if (empty($hand_id) || !is_numeric($hand_id)) {
            $segments = $this->request->getUri()->getSegments();
            $hand_id = null;
            foreach (array_reverse($segments) as $seg) {
                if (is_numeric($seg)) {
                    $hand_id = $seg;
                    break;
                }
            }
        }

        if (empty($hand_id)) {
            return redirect()->to('handover/handover_management')->with('warningmessage', 'Data tidak lengkap');
        }

        // Ambil data handover dari database
        $handoverdetails = $this->vehicleModel->get_handoverdetails($hand_id);

        if (empty($handoverdetails)) {
            return redirect()->to('handover/handover_management')->with('warningmessage', 'Data handover tidak ditemukan');
        }

        // Ambil nopol dari database
        $nopol = $handoverdetails[0]['ho_nopol'] ?? '';

        if (empty($nopol)) {
            return redirect()->to('handover/handover_management')->with('warningmessage', 'Nomor polisi tidak ditemukan');
        }

        // Get inventory for this vehicle
        $db = \Config\Database::connect();
        $cleanNopol = str_replace(' ', '', $nopol);
        $inventory = $db->table('inventorys')
                        ->where("LOWER(REPLACE(iv_nopol, ' ', '')) =", strtolower($cleanNopol))
                        ->orderBy('iv_id', 'DESC')
                        ->get()
                        ->getRowArray();

        $data = [
            'hand_id' => $hand_id,
            'nopol' => $nopol,
            'handoverdetails' => $handoverdetails[0] ?? [],
            'inventorydetails' => $inventory,
            'foto_dpn' => $inventory['foto_dpn'] ?? '',
            'foto_blk' => $inventory['foto_blk'] ?? '',
            'foto_kanan' => $inventory['foto_kanan'] ?? '',
            'foto_kiri' => $inventory['foto_kiri'] ?? '',
        ];


        return view('handover/handover_inventory_view', $data);
    }

    public function edithandoverinventory()
    {
        $hand_id = $this->request->getGet('hand_id') ?? '';
        $nopol = $this->request->getGet('nopol') ?? '';

        if (empty($hand_id) || empty($nopol)) {
            return redirect()->to('handover/handover_management')->with('warningmessage', 'Data tidak lengkap');
        }

        // Get inventory for this vehicle
        $db = \Config\Database::connect();
        $inventory = $db->table('inventorys')
                        ->where('iv_nopol', $nopol)
                        ->orderBy('iv_id', 'DESC')
                        ->get()
                        ->getRowArray();

        $data = [
            'hand_id' => $hand_id,
            'nopol' => $nopol,
            'inventory' => $inventory,
            'inventorydetails' => $inventory,
            'vechiclelist' => $this->vehicleModel->getall_vehicle()
        ];

        return view('handover/handover_inventory_edit', $data);
    }

    public function updateinventoryandproceed()
    {
        $data = $this->request->getPost();
        $hand_id = $this->request->getPost('hand_id') ?? '';
        $nopol = $this->request->getPost('iv_nopol') ?? '';
        
        if (empty($hand_id) || empty($nopol)) {
            session()->setFlashdata('warningmessage', 'Data handover tidak ditemukan.');
            return redirect()->to('handover/handover_management');
        }

        $db = \Config\Database::connect();
        // Check if inventory exists for this nopol
        $existingInventory = $db->table('inventorys')
                                ->where('iv_nopol', $nopol)
                                ->get()
                                ->getRowArray();

        // Handle photo uploads for inventory
        $photoFields = ['front_photo_data' => 'foto_dpn', 'left_photo_data' => 'foto_kiri', 'right_photo_data' => 'foto_kanan', 'back_photo_data' => 'foto_blk'];
        foreach ($photoFields as $field => $dbColumn) {
            $photoData = $data[$field] ?? '';
            if (!empty($photoData)) {
                $data[$dbColumn] = $this->saveInventoryPhoto($photoData, $data['iv_code'] . '_' . $dbColumn);
            } else {
                unset($data[$dbColumn]);
            }
            unset($data[$field]);
        }

        // Remove non-inventory fields
        unset($data['hand_id']);
        unset($data['nopol']);

        if ($existingInventory) {
            $iv_id = $existingInventory['iv_id'];
            $db->table('inventorys')
              ->where('iv_id', $iv_id)
              ->update($data);
        } else {
            $data['iv_created_by'] = session('user_id');
            $data['iv_created_date'] = date('Y-m-d H:i:s');
            $db->table('inventorys')->insert($data);
        }
        $nopol_encoded = rawurlencode($nopol);
        return redirect()->to("handover/preview?nopol={$nopol_encoded}&hand_id={$hand_id}");
    }

    public function preview()
   {
        $nopol = $this->request->getGet('nopol') ?? '';
        $hand_id = $this->request->getGet('hand_id') ?? '';

        if (empty($hand_id)) {
            return redirect()->to('handover/handover_management')->with('warningmessage', 'Data tidak lengkap');
        }

        $nopol = rawurldecode($nopol);
        $handoverdetails = $this->vehicleModel->get_handoverdetails($hand_id);

        $db = \Config\Database::connect();
        $inventory = $db->table('inventorys')
                        ->where('iv_nopol', $nopol)
                        ->orderBy('iv_id', 'DESC')
                        ->get()
                        ->getRowArray();

        $data = [
            'hand_id' => $hand_id,
            'nopol' => $nopol,
            'handoverdetails' => $handoverdetails[0] ?? [],
            'inventorydetails' => $inventory,
        ];

        return view('handover/preview_handover_inventory', $data);
    }

    public function printhandover($hand_id)
    {

        if (empty($hand_id)) {
            return redirect()->to('handover/handover_management')->with('warningmessage', 'Data tidak lengkap');
        }

        $handoverdetails = $this->vehicleModel->get_handoverdetails($hand_id);

        if (empty($handoverdetails)) {
            session()->setFlashdata('warningmessage', 'Data handover tidak ditemukan.');
            return redirect()->to('handover/handover_management');
        }

        $nopol = $handoverdetails[0]['ho_nopol'] ?? '';

        $db = \Config\Database::connect();
        $cleanNopol = str_replace(' ', '', $nopol);
        $inventory = $db->table('inventorys')
                        ->where("LOWER(REPLACE(iv_nopol, ' ', '')) =", strtolower($cleanNopol))
                        ->orderBy('iv_id', 'DESC')
                        ->get()
                        ->getRowArray();

        $data = [
            'handoverdetails' => $handoverdetails[0] ?? [],
            'inventory' => $inventory,
            'nopol' => $nopol
        ];

        return view('handover/handover_print', $data);
    }

    public function save_signature()
    {
        $hand_id = $this->request->getPost('hand_id');
        $signature_supirlama = $this->request->getPost('signature_supir_lama');
        $signature_supirbaru = $this->request->getPost('signature_supir_baru');
        $signature_petugas = $this->request->getPost('signature_petugas');

        if (empty($hand_id)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Handover ID tidak ditemukan']);
        }

        // Max signature size: 30KB (decoded binary size)
        $maxSizeBytes = 30 * 1024;

        $updateData = [];

        // Store signatures as base64 data URI directly in the database
        // Format: data:image/png;base64,iVBORw0KGgo...
        // This allows direct rendering in <img src="..."> on the print page
        $signatures = [
            'signature_supir_lama' => $signature_supirlama,
            'signature_supir_baru' => $signature_supirbaru,
            'signature_petugas'    => $signature_petugas,
        ];

        foreach ($signatures as $field => $sigData) {
            if (!empty($sigData)) {
                // Extract base64 part and calculate actual binary size
                $base64Part = preg_replace('/^data:image\/\w+;base64,/', '', $sigData);
                $binarySize = (int) (strlen
                ($base64Part) * 3 / 4);

                if ($binarySize > $maxSizeBytes) {
                    $sizeKB = round($binarySize / 1024, 1);
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => "Ukuran tanda tangan {$field} terlalu besar ({$sizeKB}KB). Maksimal 30KB."
                    ]);
                }

                $updateData[$field] = $sigData;
            }
        }

        // Save petugas name if provided
        $nama_petugas = $this->request->getPost('nama_petugas');
        if (!empty($nama_petugas)) {
            $updateData['nama_petugas'] = $nama_petugas;
        }

        if (!empty($updateData)) {
            $db = \Config\Database::connect();
            $db->table('handovers')
               ->where('ho_id', $hand_id)
               ->update($updateData);

            return $this->response->setJSON(['success' => true, 'hand_id' => $hand_id, 'message' => 'Tanda tangan berhasil disimpan']);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Tidak ada tanda tangan yang dikirim']);
    }

    public function downloadHandoverPdf($hand_id)
    {
        helper('pdf');

        $handoverdetails = $this->vehicleModel->get_handoverdetails($hand_id);
        if (!$handoverdetails) {
            session()->setFlashdata('error', 'Data tidak ditemukan.');
            return redirect()->to('handover/handover_management');
        }

        // Extract single item and free the original array
        $singleItem = $handoverdetails[0];
        unset($handoverdetails);

        $nopol = $singleItem['ho_nopol'] ?? 'handover';
        $cleanNopol = preg_replace('/[^A-Za-z0-9_]/', '_', $nopol);
        $filename = "Handover_{$cleanNopol}_" . date('Y-m-d') . ".pdf";
        unset($nopol, $cleanNopol);

        // handover_pdf.php expects $handoverdetails (single item detail)
        $data = [
            'handovers' => $singleItem,
        ];
        unset($singleItem);

        return streamPdf('handover/data_handover_pdf', $data, $filename, true);
    }

    public function handovermerkban()
    {
        $data = [
            'handovermerkban' => $this->vehicleModel->get_handovermerkban()
        ];

        return view('handover/handover_merkban', $data);
    }

    public function addhandovermerkban()
    {
        $db = \Config\Database::connect();
        $response = $db->table('handover_merk_ban')->insert($this->request->getPost());

        if($response) {
            $this->session->setFlashdata('successmessage', 'Data merek ban telah berhasil ditambahkan');
        } else {
            $this->session->setFlashdata('errormessage', 'Data merek ban tidak berhasil ditambahkan');
        }

        return redirect()->to('handover/handovermerkban');
    }

    public function handovermerkban_delete()
    {
        $mb_id = $this->request->getUri()->getSegment(3);
        $response = $this->vehicleModel->handovermerkban_delete($mb_id);

        if ($response) {
            $this->session->setFlashdata('successmessage', 'Data merek ban berhasil dihapus');
        } else {
            $this->session->setFlashdata('errormessage', 'Data merek ban gagal dihapus');
        }

        return redirect()->to('handover/handovermerkban');
    }

    public function handovermerkvelg()
    {
        $data = [
            'handovermerkvelg' => $this->vehicleModel->get_handovermerkvelg()
        ];

        return view('handover/handover_merkvelg', $data);
    }

    public function addhandovermerkvelg()
    {
        $db = \Config\Database::connect();
        $response = $db->table('handover_merk_velg')->insert($this->request->getPost());

        if($response) {
            $this->session->setFlashdata('successmessage', 'Data merek velg telah berhasil ditambahkan');
        } else {
            $this->session->setFlashdata('errormessage', 'Data merek velg tidak berhasil ditambahkan');
        }

        return redirect()->to('handover/handovermerkvelg');
    }

    public function handovermerkvelg_delete()
    {
        $mv_id = $this->request->getUri()->getSegment(3);
        $response = $this->vehicleModel->handovermerkvelg_delete($mv_id);

        if ($response) {
            $this->session->setFlashdata('successmessage', 'Data merek velg berhasil dihapus');
        } else {
            $this->session->setFlashdata('errormessage', 'Data merek velg gagal dihapus');
        }

        return redirect()->to('handover/handovermerkvelg');
    }

    // ==================== HELPER METHODS ====================

    /**
     * Generate handover code (HDO/0001/IV/2026)
     */
    private function generateHdoCode($last_hocode)
    {
        $date = new \DateTime();
        $year = $date->format('Y');
        $month = $date->format('n');
        $romawi = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V',
            6 => 'VI', 7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X',
            11 => 'XI', 12 => 'XII'
        ];
        $bulan_romawi = $romawi[$month];

        $last_number = 0;
        if ($last_hocode) {
            $pattern = '/\/(\d+)\/[IVX]+\/\d{4}$/';
            if (preg_match($pattern, $last_hocode, $matches)) {
                $last_number = (int) $matches[1];
            }
        }

        $new_number = str_pad($last_number + 1, 4, '0', STR_PAD_LEFT);

        return "HDO/{$new_number}/{$bulan_romawi}/{$year}";
    }

    /**
     * Generate inventory code (INV/0001/IV/2026)
     */


    private function generateInvCode($last_ivcode)
    {
        $date = new \DateTime();
        $year = $date->format('Y');
        $month = $date->format('n');
        $romawi = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V',
            6 => 'VI', 7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X',
            11 => 'XI', 12 => 'XII'
        ];
        $bulan_romawi = $romawi[$month];

        $last_number = 0;
        if ($last_ivcode) {
            $pattern = '/\/(\d+)\/[IVX]+\/\d{4}$/';
            if (preg_match($pattern, $last_ivcode, $matches)) {
                $last_number = (int) $matches[1];
            }
        }

        $new_number = str_pad($last_number + 1, 4, '0', STR_PAD_LEFT);

        return "INV/{$new_number}/{$bulan_romawi}/{$year}";
    }

    /**
     * Save base64 photo data to file
     */
    private function saveBase64Photo($base64Data, $prefix = 'photo')
    {
        if (empty($base64Data)) {
            return '';
        }

        // Remove data URI header if present
        if (strpos($base64Data, 'data:image') !== false) {
            $base64Data = preg_replace('/^data:image\/\w+;base64,/', '', $base64Data);
        }

        $imageData = base64_decode($base64Data);
        if ($imageData === false) {
            return '';
        }

        $uploadPath = FCPATH . 'assets/uploads/vehicle_handover/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $cleanPrefix = preg_replace('/[^A-Za-z0-9_\-]/', '_', $prefix);
        $filename = $cleanPrefix . '_' . date('YmdHis') . '_' . random_string('alnum', 8) . '.png';

        if (file_put_contents($uploadPath . $filename, $imageData)) {
            return $filename;
        }

        return '';
    }

    /**
     * Save base64 photo data to file for inventory
     */
    private function saveInventoryPhoto($base64Data, $prefix = 'photo')
    {
        if (empty($base64Data)) {
            return '';
        }

        // Remove data URI header if present
        if (strpos($base64Data, 'data:image') !== false) {
            $base64Data = preg_replace('/^data:image\/\w+;base64,/', '', $base64Data);
        }

        $imageData = base64_decode($base64Data);
        if ($imageData === false) {
            return '';
        }

        $uploadPath = FCPATH . 'assets/uploads/vehicle_invent/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $cleanPrefix = preg_replace('/[^A-Za-z0-9_\-]/', '_', $prefix);
        $filename = $cleanPrefix . '_' . date('YmdHis') . '_' . random_string('alnum', 8) . '.png';

        if (file_put_contents($uploadPath . $filename, $imageData)) {
            return $filename;
        }

        return '';
    }

    /**
     * Delete uploaded files for inventory (used during inventory delete)
     */
    private function deleteUploadedFiles($inventoryData)
    {
        $photoFields = ['foto_dpn', 'foto_kiri', 'foto_kanan', 'foto_blk'];
        foreach ($photoFields as $field) {
            if (!empty($inventoryData[$field])) {
                $filePath = FCPATH . 'assets/uploads/inventory/' . $inventoryData[$field];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }
    }

    /**
     * Delete uploaded files for handover
     */
    private function deleteUploadFiles($handoverData)
    {
        $photoFields = ['foto', 'ho_ttd_supirlama', 'ho_ttd_supirbaru', 'ho_ttd_admin'];
        foreach ($photoFields as $field) {
            if (!empty($handoverData[$field])) {
                $filePath = FCPATH . 'assets/uploads/vehicle_handover/' . $handoverData[$field];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }
    }
}