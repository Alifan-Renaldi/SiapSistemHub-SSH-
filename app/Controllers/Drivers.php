<?php
namespace App\Controllers;

use App\Models\DriversModel;
use App\Controllers\BaseController;
use App\Models\VehicleModel;
use App\Models\TripsModel;
use App\Models\GeofenceModel;
use App\Models\IncomexpenseModel;

class Drivers extends BaseController
{
    protected $driversModel;
    protected $vehicleModel;
    protected $tripsModel;
    protected $geofenceModel;
    protected $incomexpenseModel;
    protected $session;

    public function __construct()
    {
        $this->driversModel = new DriversModel();
        $this->vehicleModel = new VehicleModel();
        $this->session = session();
        helper(['form', 'url', 'string', 'custom']);
    }

    public function index()
    {

        $driverslist = $this->driversModel->getall_drivers();
        $inactive_drivers = array_filter($driverslist, function($driver) {
            return $driver['d_is_active'] == '1' || $driver['d_is_active'] == '3';
        });
        $data['loanlist_drivers'] = $this->driversModel->get_loan();
        $data['baplist_drivers'] = $this->driversModel->getBap();
        $data['provinces'] = $this->driversModel->getProvinces();
        $data['driverslist'] = $inactive_drivers;
        return view('drivers/drivers_management', $data);

    }

    public function generateBapCode($last_bcode, $created_at = null)
    {
        $date = $created_at ? new \DateTime($created_at) : new \DateTime();
        $year = $date->format('Y');
        $month = $date->format('n'); 
        $romawi = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V',
            6 => 'VI', 7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X',
            11 => 'XI', 12 => 'XII'
        ];
        $bulan_romawi = $romawi[$month];

        $last_number = 0;
        if ($last_bcode) {
            $pattern = '/\/(\d+)\/[IVX]+\/\d{4}$/';
            if (preg_match($pattern, $last_bcode, $matches)) {
                $last_number = (int) $matches[1];
            }
        }

        $new_number = str_pad($last_number + 1, 4, '0', STR_PAD_LEFT);

        return "BAP/{$new_number}/{$bulan_romawi}/{$year}";
    }

    public function generateSurveyCode($last_scode, $created_at = null)
    {
        $date = $created_at ? new \DateTime($created_at) : new \DateTime();
        $year = $date->format('Y');
        $month = $date->format('n'); 
        $romawi = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V',
            6 => 'VI', 7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X',
            11 => 'XI', 12 => 'XII'
        ];
        $bulan_romawi = $romawi[$month];

        $last_number = 0;
        if ($last_scode) {
            $pattern = '/\/(\d+)\/[IVX]+\/\d{4}$/';
            if (preg_match($pattern, $last_scode, $matches)) {
                $last_number = (int) $matches[1];
            }
        }

        $new_number = str_pad($last_number + 1, 4, '0', STR_PAD_LEFT);

        return "SRV/{$new_number}/{$bulan_romawi}/{$year}";
    }

    
    public function generateCode()
    {
        $last_trcode = $this->driversModel->get_last_trcode();
        $new_code = $this->generateTrainingCode($last_trcode);
        
        return $this->response->setJSON([
            'status' => true,
            'code'   => $new_code
        ]);
    }
    
    public function generateTrainingCode($last_trcode, $created_at = null)
    {
        $date = $created_at ? new \DateTime($created_at) : new \DateTime();
        $year = $date->format('Y');
        $month = $date->format('n'); 
        $romawi = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V',
            6 => 'VI', 7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X',
            11 => 'XI', 12 => 'XII'
        ];
        $bulan_romawi = $romawi[$month];

        $last_number = 0;
        if ($last_trcode) {
            $pattern = '/\/(\d+)\/[IVX]+\/\d{4}$/';
            if (preg_match($pattern, $last_trcode, $matches)) {
                $last_number = (int) $matches[1];
            }
        }

        $new_number = str_pad($last_number + 1, 4, '0', STR_PAD_LEFT);

        return "TRN/{$new_number}/{$bulan_romawi}/{$year}";

    }
    public function getRegencies($province_id) 
    {
        if (empty($province_id)) {
            return $this->response->setJSON(['error' => 'Province ID is required']);
        }
        $regencies = $this->driversModel->getRegencies($province_id);
        if ($regencies) {
            return $this->response->setJSON($regencies);
        }
        return $this->response->setJSON(['error' => 'No regencies found or failed to fetch data']);
    }

    public function getDistricts($regency_id) 
    {
        if (empty($regency_id)) {
            return $this->response->setJSON(['error' => 'Regency ID is required']);
        }
        $districts = $this->driversModel->getDistricts($regency_id);
        if ($districts) {
            return $this->response->setJSON($districts);
        }
        return $this->response->setJSON(['error' => 'No districts found or failed to fetch data']);
    }

    public function getVillages($district_id) 
    {
        if (empty($district_id)) {
            return $this->response->setJSON(['error' => 'District ID is required']);
        }
        $villages = $this->driversModel->getVillages($district_id);
        if ($villages) {
            return $this->response->setJSON($villages);
        }
        return $this->response->setJSON(['error' => 'No villages found or failed to fetch data']);
    }

    /**
     * Generate a new driver NIS code in format 002.XXXXX
     * e.g., if last NIS is 002.01135, the next will be 002.01136
     */
    public function generateDriverCode($last_nis)
    {
        if (!empty($last_nis) && strpos($last_nis, '.') !== false) {
            $parts = explode('.', $last_nis);
            $prefix = $parts[0];            // e.g. "002"
            $last_number = (int)$parts[1];   // e.g. 1135
            $new_number = $last_number + 1;
        } else {
            $prefix = '002';
            $new_number = 1;
        }

        return $prefix . '.' . str_pad($new_number, 5, '0', STR_PAD_LEFT);
    }

    public function adddrivers() 
    {
        if(!session()->getFlashdata('warningmessage')) {
            session()->remove('old_input');
        }
        $last_nis = $this->driversModel->get_last_nis();
        $data['new_driver_nis'] = $this->generateDriverCode($last_nis);
        $data['provinces'] = $this->driversModel->getProvinces();
        $data['provinces_name'] = $this->driverModel->getProvinceName();
        return view('drivers/drivers_add', $data);
    }

    public function insertdriver()
    {
        $data = $this->request->getPost();

        if (empty($data)) {
            session()->setFlashdata('warningmessage', 'No data submitted.');
            return redirect()->to('drivers/adddrivers');
        }

        $dateFieldsToConvert = ['d_dob', 'd_license_expdate', 'd_doj'];
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

        $data['d_created_by'] = session()->get('user_id');
        $data['d_created_date'] = date('Y-m-d H:i:s');

        if(empty($data['d_resigndate'])) {
            $data['d_resigndate'] = '0000-00-00';
        }

        // Upload foto driver
        $photo = $this->request->getFile('d_photo');
        if ($photo && $photo->isValid() && !$photo->hasMoved()) {
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!in_array($photo->getMimeType(), $allowedTypes)) {
                session()->setFlashdata('old_input', $data);
                session()->setFlashdata('warningmessage', 'Format foto tidak valid. Hanya JPG/JPEG/PNG yang diperbolehkan.');
                return redirect()->to('drivers/adddrivers');
            }

            $uploadPath = FCPATH . 'assets/uploads/drivers/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $nis = $data['d_nis'] ?? 'driver';
            $cleanNis = preg_replace('/[^A-Za-z0-9_\-]/', '_', $nis);
            $originalName = pathinfo($photo->getClientName(), PATHINFO_FILENAME);
            $cleanOriginalName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
            $newName = $cleanOriginalName . '_' . $cleanNis . '.' . $photo->guessExtension();

            if ($photo->move($uploadPath, $newName)) {
                $data['d_photo'] = $newName;
            }
        }

        $pdf_document = $this->request->getFile('d_pdf_document');
            if ($pdf_document && $pdf_document->isValid() && !$pdf_document->hasMoved()) {
                $allowedTypes = ['application/pdf'];
                if (!in_array($pdf_document->getMimeType(), $allowedTypes)) {
                    session()->setFlashdata('old_input', $data);
                    session()->setFlashdata('warningmessage', 'Format PDF tidak valid. Hanya PDF yang diperbolehkan.');
                    return redirect()->to('drivers/adddrivers');
                }

                $uploadPath = FCPATH . 'assets/uploads/drivers/document_pdf';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                $nis = $data['d_nis'] ?? 'driver';
                $cleanNis = preg_replace('/[^A-Za-z0-9_\-]/', '_', $nis);
                $originalName = pathinfo($pdf_document->getClientName(), PATHINFO_FILENAME);
                $cleanOriginalName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
                $newName = $cleanOriginalName . '_' . $cleanNis . '.' . $pdf_document->guessExtension();

                if ($pdf_document->move($uploadPath, $newName)) {
                    $data['d_pdf_document'] = $newName;
                }
        }

        // Hapus field yang tidak perlu masuk database
        unset($data['existing_photo']);
        unset($data['csrf_token']);
        unset($data['d_city_name']);
        unset($data['d_subdistrict_name']);
        unset($data['d_village_name']);

        $insert_id = $this->driversModel->insert($data);
        if ($insert_id) {
            session()->setFlashdata('successmessage', 'Driver added successfully.');
            return redirect()->to('drivers/drivers_management');
        } else {
            session()->setFlashdata('old_input', $data);
            session()->setFlashdata('warningmessage', 'Something went wrong. Try again.');
            return redirect()->to('drivers/adddrivers');
        }
    }

    public function viewdriver()
    {
        $d_id = $this->request->getPost('d_id');

        if (empty($d_id)) {
            $d_id = $this->request->getPost('driver_id');
        }

        if (empty($d_id)) {
            $d_id = $this->request->getUri()->getSegment(3);
        }

        if (empty($d_id)) {
            return redirect()->to('/pagenotfound')->with('error', 'ID Driver tidak ditemukan');
        }

        $driver = $this->driversModel->get_driverdetails($d_id);

        if (!empty($driver) && isset($driver['d_id'])) {

            // Resolve location names from API
            if (!empty($driver['d_province'])) {
                $driver['d_province_name'] = $this->driversModel->getProvinceName($driver['d_province']);
            }
            if (!empty($driver['d_province']) && !empty($driver['d_city'])) {
                $driver['d_city_name'] = $this->driversModel->getRegencyName($driver['d_province'], $driver['d_city']);
            }
            if (!empty($driver['d_city']) && !empty($driver['d_subdistrict'])) {
                $driver['d_district_name'] = $this->driversModel->getDistrictName($driver['d_city'], $driver['d_subdistrict']);
            }
            if (!empty($driver['d_subdistrict']) && !empty($driver['d_village'])) {
                $driver['d_village_name'] = $this->driversModel->getVillageName($driver['d_subdistrict'], $driver['d_village']);
            }

            $d_nis = $driver['d_nis'];

            $data['driverdetails'] = $driver;
            $data['driver_document'] = $driver;
            $data['baps'] = $this->driversModel->get_all_baps_by_nis($d_nis);
            $data['surveys'] = $this->driversModel->get_survey_by_nis($d_nis);
            $data['trainings'] = $this->driversModel->get_training_by_nis($d_nis);
            $data['loansloan'] = $this->driversModel->get_loan_by_nis($d_nis);

            // Build combined records for Loan tab
            $combined = [];

            if (!empty($data['loansloan'])) {
                foreach ($data['loansloan'] as $loan) {
                    $combined[] = [
                        'tanggal'   => $loan['l_tanggal'] ?? '',
                        'jenis'     => $loan['l_jenis'] ?? '',
                        'nominal'   => $loan['l_nominal'] ?? '',
                        'potong'    => $loan['l_potong'] ?? '',
                        'status'    => (($loan['l_is_status'] ?? '') == '0' || ($loan['l_is_status'] ?? '') == '5') ? 'PAID' : 'UNPAID',
                        'paid'      => $loan['l_paid'] ?? '',
                        'type'      => 'loan',
                        'action_id' => $loan['l_id'],
                    ];
                }
            }

            // Add BAPs with financial status (only status 0=UNPAID, 2=PAID)
            $baps_financial = $this->driversModel->get_baps_by_nis($d_nis);
            if (!empty($baps_financial)) {
                foreach ($baps_financial as $bap) {
                    $combined[] = [
                        'tanggal'   => $bap['b_tanggal'] ?? '',
                        'jenis'     => 'BAP - ' . ($bap['b_jenis_kasus'] ?? ''),
                        'nominal'   => $bap['b_nominal'] ?? '',
                        'potong'    => $bap['b_potong_tagihan'] ?? '',
                        'status'    => (($bap['b_is_status'] ?? '') == '2') ? 'PAID' : 'UNPAID',
                        'paid'      => $bap['b_paid'] ?? '',
                        'type'      => 'bap',
                        'action_id' => $bap['b_id'],
                    ];
                }
            }

            $data['combined_records'] = $combined;

            return view('drivers/drivers_view', $data);
        } else {
            return view('pagenotfound');
        }
    }

    public function editdriver() 
    {
        $driver_id = $this->request->getPost('driver_id');
    
        if (empty($driver_id)) {
            $driver_id = $this->request->getUri()->getSegment(3);
        }
        
        if (empty($driver_id)) {
            return redirect()->to('/pagenotfound')->with('error', 'ID Driver tidak ditemukan');
        }
        $last_nis = $this->driversModel->get_last_nis();
        $data['new_driver_nis'] = $this->generateDriverCode($last_nis);
        $driver = $this->driversModel->get_driverdetails($driver_id);
        $data['driverdetails'] = [$driver];
        $data['provinces'] = $this->driversModel->getProvinces();
        return view('drivers/drivers_add', $data);
    }

    public function updatedriver()
    {
        $data = $this->request->getPost();

        if (empty($data) || empty($data['d_id'])) {
            session()->setFlashdata('warningmessage', 'No data submitted.');
            return redirect()->to('drivers/drivers_management');
        }

        $dateFieldsToConvert = ['d_dob', 'd_license_expdate', 'd_doj'];
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

        $driver_id = $data['d_id'];
        $data['d_created_by'] = session()->get('user_id');
        $data['d_created_date'] = date('Y-m-d H:i:s');

        // Upload foto driver (jika ada file baru)
        $photo = $this->request->getFile('d_photo');
        if ($photo && $photo->isValid() && !$photo->hasMoved()) {
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!in_array($photo->getMimeType(), $allowedTypes)) {
                session()->setFlashdata('warningmessage', 'Format foto tidak valid. Hanya JPG/JPEG/PNG yang diperbolehkan.');
                return redirect()->to('drivers/editdriver/' . $driver_id);
            }

            $uploadPath = FCPATH . 'assets/uploads/drivers/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $nis = $data['d_nis'] ?? 'driver';
            $cleanNis = preg_replace('/[^A-Za-z0-9_\-]/', '_', $nis);
            $originalName = pathinfo($photo->getClientName(), PATHINFO_FILENAME);
            $cleanOriginalName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
            $newName = $cleanOriginalName . '_' . $cleanNis . '.' . $photo->guessExtension();

            // Hapus foto lama jika ada
            $oldPhoto = $data['existing_photo'] ?? '';
            if (!empty($oldPhoto) && file_exists($uploadPath . $oldPhoto)) {
                unlink($uploadPath . $oldPhoto);
            }

            if ($photo->move($uploadPath, $newName)) {
                $data['d_photo'] = $newName;
            }
        } else {
            // Tetap gunakan foto lama
            unset($data['d_photo']);
        }

        $pdf_document = $this->request->getFile('d_pdf_document');
            if ($pdf_document && $pdf_document->isValid() && !$pdf_document->hasMoved()) {
                $allowedTypes = ['application/pdf'];
                if (!in_array($pdf_document->getMimeType(), $allowedTypes)) {
                    session()->setFlashdata('old_input', $data);
                    session()->setFlashdata('warningmessage', 'Format PDF tidak valid. Hanya PDF yang diperbolehkan.');
                    return redirect()->to('drivers/adddrivers');
                }

                $uploadPath = FCPATH . 'assets/uploads/drivers/document_pdf';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                $nis = $data['d_nis'] ?? 'driver';
                $cleanNis = preg_replace('/[^A-Za-z0-9_\-]/', '_', $nis);
                $originalName = pathinfo($pdf_document->getClientName(), PATHINFO_FILENAME);
                $cleanOriginalName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
                $newName = $cleanOriginalName . '_' . $cleanNis . '.' . $pdf_document->guessExtension();

                if ($pdf_document->move($uploadPath, $newName)) {
                    $data['d_pdf_document'] = $newName;
                }
            } else {
                unset($data['d_pdf_document']);
            }

        // Hapus field yang tidak perlu masuk database
        unset($data['d_id']);
        unset($data['existing_photo']);
        unset($data['existing_pdf_document']);
        unset($data['csrf_token']);
        unset($data['d_identity_expdate']);
        unset($data['d_city_name']);
        unset($data['d_subdistrict_name']);
        unset($data['d_village_name']);

        $response = $this->driversModel->edit_driver($driver_id, $data);

        if ($response) {
            return redirect()->to('drivers/drivers_management')->with('successmessage', 'Driver updated successfully.');
        } else {
            return redirect()->to('drivers/editdriver/' . $driver_id)->with('warningmessage', 'Something went wrong. Try again.');
        }
    }

    public function drivers_delete($d_id)
    {
        if (!$this->request->is('post')) {
        return redirect()->to('drivers/drivers_management');
        }

        $filename = $this->driversModel->getDriversById($d_id);
        $fileDeleted = $this->deleteOldPhoto($filename);
        $fileDeletedPDF = $this->deleteOldPdf($filename);

        $returndata = $this->driversModel->drivers_delete($d_id);
        if ($returndata) {
            return redirect()->to('drivers/drivers_management')->with('successmessage', 'Driver deleted successfully.');
        } else {
            return redirect()->to('drivers/drivers_management')->with('warningmessage', 'Error! Driver is still in use.');
        }
    }

    public function inactivedriver()
    {
        $driverslist = $this->driversModel->getall_drivers();
        $inactive_drivers = array_filter($driverslist, function($driver) {
            return $driver['d_is_active'] == '0' || $driver['d_is_active'] == '2';
        });


        $data['loanlist_drivers'] = $this->driversModel->get_loan();
        $data['baplist_drivers'] = $this->driversModel->getBap();
        $data['provinces'] = $this->driversModel->getProvinces();
        $data['driverslist'] = $inactive_drivers;
        return view('drivers/drivers_inactive', $data);
    }

    public function adddriversblacklist() 
    {
        $data['provinces'] = $this->driversModel->getProvinces();
        return view('drivers/driversblacklist_add', $data);
    }

    public function insertdriverblacklist()
    {
        $data = $this->request->getPost();
        $data['d_is_active'] = '2';

        $photo = $this->request->getFile('d_photo');
        if ($photo && $photo->isValid() && !$photo->hasMoved()) {
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!in_array($photo->getMimeType(), $allowedTypes)) {
                session()->setFlashdata('old_input', $data);
                session()->setFlashdata('warningmessage', 'Format foto tidak valid. Hanya JPG/JPEG/PNG yang diperbolehkan.');
                return redirect()->to('drivers/adddriversblacklist');
            }

            $uploadPath = FCPATH . 'assets/uploads/drivers/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $nis = $data['d_nis'] ?? 'driver';
            $cleanNis = preg_replace('/[^A-Za-z0-9_\-]/', '_', $nis);
            $originalName = pathinfo($photo->getClientName(), PATHINFO_FILENAME);
            $cleanOriginalName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
            $newName = $cleanOriginalName . '_' . $cleanNis . '.' . $photo->guessExtension();

            if ($photo->move($uploadPath, $newName)) {
                $data['d_photo'] = $newName;
            }
        }

        // Hapus field yang tidak perlu masuk database
        unset($data['existing_photo']);
        unset($data['csrf_token']);
        unset($data['d_identity_expdate']);
        unset($data['d_city_name']);
        unset($data['d_subdistrict_name']);
        unset($data['d_village_name']);

        if (empty($data)) {
            return redirect()->to('drivers/adddriversblacklist')->with('warningmessage', 'No data submitted.');
        }

        $response = $this->driversModel->insert_driversblacklist($data);

        if ($response) {
            return redirect()->to('drivers/drivers_inactive')->with('successmessage', 'Driver Blacklist added successfully.');
        } else {
            return redirect()->to('drivers/adddriversblacklist')->with('warningmessage', 'Something went wrong. Try again.');
        }
    }

    public function viewdriver_inactive()
    {
         $d_id = $this->request->getPost('d_id');
         $driverslist = $this->driversModel->get_driver_inactive_blacklist();

        $driverslist = array_filter($driverslist, function($driver) {
            return $driver['d_is_active'] == '0' || $driver['d_is_active'] == '2';
        });

        if (empty($d_id)) {
            $d_id = $this->request->getPost('driver_id');
        }

        if (empty($d_id)) {
            $d_id = $this->request->getUri()->getSegment(3);
        }

        if (empty($d_id)) {
            return redirect()->to('/pagenotfound')->with('error', 'ID Driver tidak ditemukan');
        }

        $driver = $this->driversModel->get_driverdetails($d_id);

        if (!empty($driver) && isset($driver['d_id'])) {

            if (!empty($driver['d_province'])) {
                $driver['d_province_name'] = $this->driversModel->getProvinceName($driver['d_province']);
            }
            if (!empty($driver['d_province']) && !empty($driver['d_city'])) {
                $driver['d_city_name'] = $this->driversModel->getRegencyName($driver['d_province'], $driver['d_city']);
            }
            if (!empty($driver['d_city']) && !empty($driver['d_subdistrict'])) {
                $driver['d_district_name'] = $this->driversModel->getDistrictName($driver['d_city'], $driver['d_subdistrict']);
            }
            if (!empty($driver['d_subdistrict']) && !empty($driver['d_village'])) {
                $driver['d_village_name'] = $this->driversModel->getVillageName($driver['d_subdistrict'], $driver['d_village']);
            }


            $d_nis = $driver['d_nis'];
            $d_resign_data = $driver['d_resigndate'];
            $d_notes_blacklist = $driver['d_notes_blacklist'];

            $data['driverdetails'] = $driver;
            $data['driver_document'] = $driver;
            $data['baps'] = $this->driversModel->get_all_baps_by_nis($d_nis);
            $data['surveys'] = $this->driversModel->get_survey_by_nis($d_nis);
            $data['trainings'] = $this->driversModel->get_training_by_nis($d_nis);
            $data['loansloan'] = $this->driversModel->get_loan_by_nis($d_nis);

            // Build combined records for Loan tab
            $combined = [];

            if (!empty($data['loansloan'])) {
                foreach ($data['loansloan'] as $loan) {
                    $combined[] = [
                        'tanggal'   => $loan['l_tanggal'] ?? '',
                        'jenis'     => $loan['l_jenis'] ?? '',
                        'nominal'   => $loan['l_nominal'] ?? '',
                        'potong'    => $loan['l_potong'] ?? '',
                        'status'    => (($loan['l_is_status'] ?? '') == '0' || ($loan['l_is_status'] ?? '') == '5') ? 'PAID' : 'UNPAID',
                        'paid'      => $loan['l_paid'] ?? '',
                        'type'      => 'loan',
                        'action_id' => $loan['l_id'],
                    ];
                }
            }

            // Add BAPs with financial status (only status 0=UNPAID, 2=PAID)
            $baps_financial = $this->driversModel->get_baps_by_nis($d_nis);
            if (!empty($baps_financial)) {
                foreach ($baps_financial as $bap) {
                    $combined[] = [
                        'tanggal'   => $bap['b_tanggal'] ?? '',
                        'jenis'     => 'BAP - ' . ($bap['b_jenis_kasus'] ?? ''),
                        'nominal'   => $bap['b_nominal'] ?? '',
                        'potong'    => $bap['b_potong_tagihan'] ?? '',
                        'status'    => (($bap['b_is_status'] ?? '') == '2') ? 'PAID' : 'UNPAID',
                        'paid'      => $bap['b_paid'] ?? '',
                        'type'      => 'bap',
                        'action_id' => $bap['b_id'],
                    ];
                }
            }

            $data['combined_records'] = $combined;

            return view('drivers/drivers_viewinactive', $data);
        } else {
            return view('pagenotfound');
        }
    }
    
    public function editdriverblacklist() 
    {
        $driver_id = $this->request->getPost('driver_id');
    
        if (empty($driver_id)) {
            $driver_id = $this->request->getUri()->getSegment(3);
        }
        
        if (empty($driver_id)) {
            return redirect()->to('/pagenotfound')->with('error', 'ID Driver tidak ditemukan');
        }
        $driver = $this->driversModel->get_driverdetails($driver_id);
        $data['driverdetails'] = [$driver];
        $data['provinces'] = $this->driversModel->getProvinces();
        return view('drivers/driversblacklist_add', $data);
    }

    public function updatedriverblacklist()
    {
        $data = $this->request->getPost();

        $driver_id = $data['d_id'];

        $dateFieldsToConvert = ['d_dob', 'd_resigndate'];
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

        $photo = $this->request->getFile('d_photo');
        if ($photo && $photo->isValid() && !$photo->hasMoved()) {
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!in_array($photo->getMimeType(), $allowedTypes)) {
                return redirect()->to('drivers/editdriverblacklist/' . $driver_id)->with('warningmessage', 'Format foto tidak valid. Hanya JPG/JPEG/PNG yang diperbolehkan.');
            }


            $uploadPath = FCPATH . 'assets/uploads/drivers/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $nis = $data['d_nis'] ?? 'driver';
            $cleanNis = preg_replace('/[^A-Za-z0-9_\-]/', '_', $nis);
            $originalName = pathinfo($photo->getClientName(), PATHINFO_FILENAME);
            $cleanOriginalName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
            $newName = $cleanOriginalName . '_' . $cleanNis . '.' . $photo->guessExtension();

            if ($photo->move($uploadPath, $newName)) {
                $data['d_photo'] = $newName;
            }
        } else {
            // Tetap gunakan foto lama
            unset($data['d_photo']);
        }

        // Hapus field yang tidak perlu masuk database
        unset($data['d_id']);
        unset($data['existing_photo']);
        unset($data['csrf_token']);
        unset($data['d_identity_expdate']);
        unset($data['d_city_name']);
        unset($data['d_subdistrict_name']);
        unset($data['d_village_name']);

        $response = $this->driversModel->edit_driver($driver_id, $data);

        if ($response) {
            return redirect()->to('drivers/drivers_inactive')->with('successmessage', 'Driver Blacklist updated successfully.');
        } else {
            return redirect()->to('drivers/editdriverblacklist/' . $driver_id)->with('warningmessage', 'Something went wrong. Try again.');
        }
    }

    // public function delete_driverblacklist($d_id)
    // {
    //     if (!$this->request->is('post')) {
    //     return redirect()->to('drivers/drivers_inactive');
    //     }

    //     $driverblacklist = $this->driversModel->getDriversById($d_id);
    //     if ($driverblacklist) {
    //         $filesDeleted = $this->deleteOldPhoto($driverblacklist);
    //         $returndata = $this->driversModel->drivers_delete($d_id);

    //     if ($returndata) {
    //         session()->setFlashdata('successmessage', 'Driver Blacklist deleted successfully..');
    //         return redirect()->to('drivers/drivers_inactive');
    //     } else {
    //         session()->setFlashdata('warningmessage', 'Error..! Some driver are mapped with this group. Please remove from Driver blacklist management');
    //         return redirect()->to('drivers/drivers_inactive');
    //         }
    //     }
    // }


    public function baplists_drivers()
    {
        $data['baplists_drivers'] = $this->driversModel->get_bap();
        $data['bapdate_drivers'] = $this->driversModel->get_bap_date();
        $data['driverlist'] = $this->driversModel->getall_drivers();
        $data['bappending_drivers'] = $this->driversModel->get_bap_by_date();
        $data['pendingCount'] = !empty($data['bappending_drivers']) ? count($data['bappending_drivers']) : 0;
        return view('baps/bap_management', $data);
    }

    public function baplist_pending()
    {
        $data['baplists_drivers'] = $this->driversModel->get_bap();
        $data['bappending_drivers'] = $this->driversModel->get_bap_by_date();
        $data['driverlist'] = $this->driversModel->getall_drivers();
        $data['pendingCount'] = !empty($data['bappending_drivers']) ? count($data['bappending_drivers']) : 0;
        return view('baps/bap_pending', $data);
    }

    public function printbap($bap_id)
    {
        $bapdetails = $this->driversModel->get_bapdetails($bap_id);
        if (!$bapdetails) {
            session()->setFlashdata('error', 'Data tidak ditemukan.');
            return redirect()->to('baps/bap_management');
        }
        if ($this->request->getVar('new') === 'true') {
        session()->setFlashdata('successmessage', 'New BAP added successfully.');
        }
        return view('baps/bap_print', ['bapdetails' => $bapdetails]);
    }

    private function deleteOldPhoto($fileName)
    {
        if (!empty($fileName['d_photo'])) {
            $pdfPath = FCPATH . 'assets/uploads/drivers/';
            $filePath = $pdfPath . $fileName['d_photo'];
            if (file_exists($filePath)) {
                    if (unlink($filePath)) {
                        log_message('info', 'Driver photo deleted: ' . $filePath);
                        return true;
                    } else {
                        log_message('error', 'Failed to delete driver photo: ' . $filePath);
                        return false;
                    }
                } else {
                    log_message('warning', 'Driver photo not found: ' . $filePath);
                }
            }
        return false;
    }

     private function deleteOldPdf($fileName)
    {
        if (!empty($fileName['d_pdf_document'])) {
            $pdfPath = FCPATH . 'writable/uploads/document/';
            $filePath = $pdfPath . $fileName['d_pdf_document'];
            if (file_exists($filePath)) {
                    if (unlink($filePath)) {
                        log_message('info', 'Driver document deleted: ' . $filePath);
                        return true;
                    } else {
                        log_message('error', 'Failed to delete driver document: ' . $filePath);
                        return false;
                    }
                } else {
                    log_message('warning', 'Driver document not found: ' . $filePath);
                }
            }
        return false;
    }

    private function upload_documentbap($driverName = '', $bapNumber = '', $oldFileName = '') 
    {
        $photo = $this->request->getFile('b_document');

        if (!($photo && $photo->isValid() && !$photo->hasMoved())) {
            return null;
        }

        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
        if (!in_array($photo->getMimeType(), $allowedTypes)) {
            return false;
        }

        if ($photo->getSize() > 5 * 1024 * 1024) {
            return false;
        }

        $uploadPath = FCPATH . 'assets/uploads/bap/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $extension = $photo->guessExtension();
        $newName = $this->generateDocumentBap($driverName, $bapNumber, $extension);

        $baseName = pathinfo($newName, PATHINFO_FILENAME);
        $counter = 1;
        while (file_exists($uploadPath . $newName) && $newName !== $oldFileName) {
            $newName = $baseName . '_' . $counter . '.' . $extension;
            $counter++;
        }

        if ($photo->move($uploadPath, $newName)) {
            if (!empty($oldFileName) && $oldFileName !== $newName && file_exists($uploadPath . $oldFileName)) {
                unlink($uploadPath . $oldFileName);
            }
            return $newName;
        }

        return false;
    }

    private function upload_pdfbap($driverName = '', $bapNumber = '', $oldFileName = '') 
    {
        $file = $this->request->getFile('b_pdf');

        if (!($file && $file->isValid() && !$file->hasMoved())) {
            return null;
        }

        if ($file->getMimeType() !== 'application/pdf') {
            return false;
        }

        $uploadPath = FCPATH . 'assets/uploads/bap/pdf/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $extension = $file->guessExtension();
        $newName = $this->generateDocumentBap($driverName, $bapNumber, $extension);

        $baseName = pathinfo($newName, PATHINFO_FILENAME);
        $counter = 1;
        while (file_exists($uploadPath . $newName) && $newName !== $oldFileName) {
            $newName = $baseName . '_' . $counter . '.' . $extension;
            $counter++;
        }

        if ($file->move($uploadPath, $newName, $newName === $oldFileName)) {
            if (!empty($oldFileName) && $oldFileName !== $newName && file_exists($uploadPath . $oldFileName)) {
                unlink($uploadPath . $oldFileName);
            }
            return $newName;
        }

        return false;
    }

    private function generateDocumentBap($driverName, $bapNumber, $extension)
    {
        $cleanDriverName = preg_replace('/[^A-Za-z0-9]/', '', $driverName);
        $cleanDriverName = strtoupper($cleanDriverName);
        
        $cleanBapNumber = preg_replace('/[^A-Za-z0-9]+/', '.', $bapNumber);
        $cleanBapNumber = strtoupper($cleanBapNumber);
        
        $cleanBapNumber = trim($cleanBapNumber, '.');
        
        $extension = strtolower($extension);
        
        $filename = $cleanDriverName . '_' . $cleanBapNumber . '.' . $extension;
        
        if (strlen($filename) > 255) {
            $maxLength = 255 - strlen($extension) - 2;
            $maxDriverLength = floor($maxLength / 2);
            $maxBapLength = $maxLength - $maxDriverLength;
            
            $cleanDriverName = substr($cleanDriverName, 0, $maxDriverLength);
            $cleanBapNumber = substr($cleanBapNumber, 0, $maxBapLength);
            
            $filename = $cleanDriverName . '_' . $cleanBapNumber . '.' . $extension;
        }
        
        return $filename;
    }

    private function deleteOldDocumentBap($fileName)
    {
        if (!empty($fileName['b_document'])) {
                $uploadPath = FCPATH . 'assets/uploads/bap/';
                $filePath = $uploadPath . $fileName['b_document'];
                
                if (file_exists($filePath)) {
                    if (unlink($filePath)) {
                        log_message('info', 'BAP document deleted: ' . $filePath);
                        return true;
                    } else {
                        log_message('error', 'Failed to delete bap document: ' . $filePath);
                        return false;
                    }
                } else {
                    log_message('warning', 'BAP document not found: ' . $filePath);
                }
            }
        return false;
    }

    private function deleteOldPdfBap($fileName)
    {
        if (!empty($fileName['b_pdf'])) {
            $pdfPath = FCPATH . 'assets/uploads/bap/pdf/';
            $filePath = $pdfPath . $fileName['b_pdf'];
            if (file_exists($filePath)) {
                    if (unlink($filePath)) {
                        log_message('info', 'BAP document deleted: ' . $filePath);
                        return true;
                    } else {
                        log_message('error', 'Failed to delete bap document: ' . $filePath);
                        return false;
                    }
                } else {
                    log_message('warning', 'BAP document not found: ' . $filePath);
                }
            }
        return false;
    }

    public function addbap() 
    {
        $last_bcode = $this->driversModel->get_last_bcode();
        $data['new_bap_code'] = $this->generateBapCode($last_bcode);
        $data['driverlist'] = $this->driversModel->getall_drivers();
        $data['vechiclelist'] = $this->vehicleModel->getall_vehicle();
        return view('baps/bap_add', $data);
    }

    public function insertbap()
    {
        $validation = \Config\Services::validation();
        $validation->setRule('b_tanggal_kejadian', 'Tanggal Kejadian', 'required');
        $validation->setRule('b_nis', 'NIS', 'required');
        $validation->setRule('b_supir', 'Driver', 'required');
        $validation->setRule('b_nopol', 'Mobil', 'required');

        $testxss = $this->request->getPost();

        if ($validation->withRequest($this->request)->run() && $testxss) {

            $data = $this->request->getPost();

            $dateFieldsToConvert = ['b_tanggal_kejadian', 'b_tanggal'];
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

            $driverName = $data['b_supir'] ?? '';
            $bapNumber = $data['b_code'] ?? '';

            $photo = $this->upload_documentbap($driverName, $bapNumber);
            if ($photo === false) {
                session()->setFlashdata('warningmessage', 'Gagal mengunggah dokumen. Format harus JPG/JPEG/PNG/PDF dan ukuran maksimal 5MB.');
                return redirect()->to('drivers/addbap');
            }

            $data['b_created_by'] = session('user_id');
            unset($data['b_id']);
            unset($data['b_tanggal']);
            unset($data['existing_document']);
            unset($data['existing_pdf']);

            if (!empty($data['b_nopol'])) {
                list($v_registration_no, $v_name) = explode(' - ', $data['b_nopol']);
            }

            $data['b_document'] = $photo ? $photo : 'default_photo.png';
            $data['b_is_status'] = 1;
            $data['b_status_korban'] = '';
            $data['b_pdf'] = '';
            $dateFields = ['b_tanggal'];
            foreach ($dateFields as $field) {
                if (!isset($data[$field]) || trim($data[$field]) == '') {
                    $data[$field] = null;
                }
            }

            $response = $this->driversModel->add_bap($data);
            if ($response) {
                $bap_id = $this->driversModel->insertID();
                return redirect()->to('drivers/printbap/' . $bap_id . '?new=true');
            }
        } else {
            $errormsg = $validation->getErrors() ? implode('<br>', $validation->getErrors()) : '';
            if (!$testxss) {
                $errormsg = 'Error! Your input is not allowed. Please try again';
            }
            session()->setFlashdata('warningmessage', $errormsg);
            return redirect()->to('drivers/addbap');
        }
    }

    public function editbap() 
    {
        $bap_id = $this->request->getPost('bap_id');
    
        if (empty($bap_id)) {
            $bap_id = $this->request->getUri()->getSegment(3);
        }
        
        if (empty($bap_id)) {
            return redirect()->to('/pagenotfound')->with('error', 'BAP tidak ditemukan');
        }
        $last_bcode = $this->driversModel->get_last_bcode();
        $data['new_bap_code'] = $this->generateBapCode($last_bcode);
        $data['driverlist'] = $this->driversModel->getall_drivers();
        $data['vechiclelist'] = $this->vehicleModel->getall_vehicle();
        $data['bapdetails'] = $this->driversModel->get_bapdetails($bap_id);
        return view('baps/bap_add', $data);
    }

    public function updatebap() 
    {
        $data = $this->request->getPost();

        $dateFieldsToConvert = ['b_tanggal_kejadian', 'b_tanggal'];
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
        
        $data['b_created_by'] = session('user_id');
        if (!$data) {
            session()->setFlashdata('warningmessage', 'No data submitted.');
            return redirect()->to('drivers');
        }

            $driverName = $data['b_supir'] ?? '';
            $bapNumber = $data['b_code'] ?? '';
            $oldDocument = $data['existing_document'] ?? null;
            $oldPdf = $data['existing_pdf'] ?? null;

            $photo = $this->upload_documentbap($driverName, $bapNumber, $oldDocument);
            if ($photo === false) {
                session()->setFlashdata('warningmessage', 'Gagal mengunggah dokumen. Format harus JPG/JPEG/PNG/PDF dan ukuran maksimal 5MB.');
                return redirect()->to('baps/editbap/' . $data['b_id']);
            }

            $pdf_document = $this->upload_pdfbap($driverName, $bapNumber, $oldPdf);
            if ($pdf_document === false) {
                session()->setFlashdata('warningmessage', 'Gagal mengunggah PDF. Format harus PDF dan ukuran maksimal 5MB.');
                return redirect()->to('baps/editbap/' . $data['b_id']);
            }

            $data['b_document'] = $photo ?: $oldDocument;
            $data['b_pdf'] = $pdf_document ?: $oldPdf;
            unset($data['existing_document'], $data['existing_pdf']);

        $response = $this->driversModel->edit_bap($data);
        if ($response) {
            session()->setFlashdata('successmessage', 'BAP updated successfully.');
            return redirect()->to('baps/bap_management');
        } else {
            session()->setFlashdata('warningmessage', 'Something went wrong. Try again.');
            return redirect()->to('baps/editbap/' . $data['b_id']);
        }
    }

    public function bap_delete()
    {
        $b_id = $this->request->getUri()->getSegment(3);
        $filename = $this->driversModel->getBapById($b_id);
            $fileDeleted = $this->deleteOldDocumentBap($filename);
            $fileDeletedPDF = $this->deleteOldPdfBap($filename);
            $returndata = $this->driversModel->bap_delete($b_id);
            if ($returndata) {
                $message = 'BAP deleted successfully';
                session()->setFlashdata('successmessage', $message);
                return redirect()->to('baps/bap_management');
        } else {
            session()->setFlashdata('warningmessage', 'Error..! Some driver are mapped with this group. Please remove from BAP management');
            return redirect()->to('baps/bap_management');
        }
    }

    public function viewbap()
    {
        $bap_id = $this->request->getPost('bap_id');
    
        if (empty($bap_id)) {
            $bap_id = $this->request->getUri()->getSegment(3);
        }
        
        if (empty($bap_id)) {
            return redirect()->to('/pagenotfound')->with('error', 'BAP tidak ditemukan');
        }
        $bapdetails = $this->driversModel->get_bapdetails($bap_id);

        if (isset($bapdetails[0]['b_id'])) {
            $d_nis = $bapdetails[0]['b_nis'];
            $data['bapdetails'] = $bapdetails[0];
            return view('baps/bap_view', $data);
        } else {
            return view('pagenotfound');
        }
    }

    public function editbap_pending() 
    {
        $bap_id = $this->request->getPost('bap_id');
    
        if (empty($bap_id)) {
            $bap_id = $this->request->getUri()->getSegment(3);
        }
        
        if (empty($bap_id)) {
            return redirect()->to('/pagenotfound')->with('error', 'BAP tidak ditemukan');
        }
        $last_bcode = $this->driversModel->get_last_bcode();
        $data['new_bap_code'] = $this->generateBapCode($last_bcode);
        $data['driverlist'] = $this->driversModel->getall_drivers();
        $data['vechiclelist'] = $this->vehicleModel->getall_vehicle();
        $data['bapdetails'] = $this->driversModel->get_bapdetails($bap_id);
        return view('baps/bap_pendingedit', $data);
    }

    public function updatebap_pending() 
    {
        $data = $this->request->getPost();

        $dateFieldsToConvert = ['b_tanggal_kejadian', 'b_tanggal'];
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

        $data['b_created_by'] = session('user_id');
        if (!$data) {
        session()->setFlashdata('warningmessage', 'No data submitted.');
        return redirect()->to('drivers');
        }

        $driverName = $data['b_supir'] ?? '';
        $bapNumber = $data['b_code'] ?? '';
        $oldDocument = $data['existing_document'] ?? null;
        $oldPdf = $data['existing_pdf'] ?? null;

            $photo = $this->upload_documentbap($driverName, $bapNumber, $oldDocument);
            if ($photo === false) {
                session()->setFlashdata('warningmessage', 'Gagal mengunggah dokumen. Format harus JPG/JPEG/PNG/PDF dan ukuran maksimal 5MB.');
                return redirect()->to('baps/editbap_pending/' . $data['b_id']);
            }

            $pdf_document = $this->upload_pdfbap($driverName, $bapNumber, $oldPdf);
            if ($pdf_document === null && !empty($_FILES['b_pdf']['name'])) {
                session()->setFlashdata('warningmessage', 'Gagal mengunggah PDF. Format harus PDF dan ukuran maksimal 5MB.');
                return redirect()->to('baps/editbap_pending/' . $data['b_id']);
            }

            if ($photo) {
                $data['b_document'] = $photo;
            } else {
                $data['b_document'] = $oldDocument ?? null;
            }

            $data['b_pdf'] = $pdf_document ?? $oldPdf ?? null;
        
            $b_tanggal = $data['b_tanggal'] ?? '';
            if (!empty($b_tanggal) && $b_tanggal !== null) {
                $data['b_is_status'] = 0;
            } else {
                unset($data['b_is_status']);
            }

        unset($data['existing_document'], $data['existing_pdf']);

        $response = $this->driversModel->editpending_bap($data);
        if ($response) {
            session()->setFlashdata('successmessage', 'BAP updated successfully.');
            if (!empty($b_tanggal) && $b_tanggal != null) {
                return redirect()->to('baps/bap_management');
            }
            return redirect()->to('baps/bap_pending');
        } else {
            session()->setFlashdata('warningmessage', 'Something went wrong. Try again.');
            return redirect()->to('baps/editbap_pending/' . $data['b_id']);
        }
    }

    public function bappending_delete()
    {
        $b_id = $this->request->getUri()->getSegment(3);
        $filename = $this->driversModel->getBapById($b_id);
            $fileDeleted = $this->deleteOldDocumentBap($filename);
        $returndata = $this->driversModel->bap_delete($b_id);
        if ($returndata) {
            session()->setFlashdata('successmessage', 'BAP deleted successfully..');
            return redirect()->to('baps/bap_pending');
        } else {
            session()->setFlashdata('warningmessage', 'Error..! Some driver are mapped with this group. Please remove from BAP management');
            return redirect()->to('baps/bap_pending');
        }
    }

    public function viewbappending()
    {
        $bap_id = $this->request->getPost('bap_id');
    
        if (empty($bap_id)) {
            $bap_id = $this->request->getUri()->getSegment(3);
        }
        
        if (empty($bap_id)) {
            return redirect()->to('/pagenotfound')->with('error', 'BAP tidak ditemukan');
        }
        $bapdetails = $this->driversModel->get_bapdetails($bap_id);

        if (isset($bapdetails[0]['b_id'])) {
            $d_nis = $bapdetails[0]['b_nis'];
            $data['bapdetails'] = $bapdetails[0];
            return view('baps/bap_pendingview', $data);
        } else {
            return view('pagenotfound');
        }
    }

    public function printsurvey($survey_id)
    {
        $surveydetails = $this->driversModel->get_surveydetails($survey_id);
        if (!$surveydetails) {
            session()->setFlashdata('error', 'Data tidak ditemukan.');
            return redirect()->to('surveys/survey_management');
        }

        $surveydetails = $this->driversModel->resolveWilayahNamesSurvey($surveydetails);

        if ($this->request->getVar('new') === 'true') {
        session()->setFlashdata('successmessage', 'Survey Berhasil Ditambahkan.');
        }

        return view('surveys/survey_print', ['surveydetails' => $surveydetails]);
    }

    public function downloadSurveyPdf($survey_id)
    {
        try {
            $surveydetails = $this->driversModel->get_surveydetails($survey_id);
            if (!$surveydetails) {
                session()->setFlashdata('error', 'Data tidak ditemukan.');
                return redirect()->to('surveys/survey_management');
            }

            // resolveWilayahNamesSurvey expects array-of-rows; resolve region
            // names but never let a wilayah API failure block the PDF download
            try {
                $surveydetails = $this->driversModel->resolveWilayahNamesSurvey($surveydetails);
            } catch (\Throwable $e) {
                log_message('error', 'Wilayah resolve failed for survey #' . $survey_id . ': ' . $e->getMessage());
            }

            $singleItem = $surveydetails[0];
            unset($surveydetails);

            $supir = $singleItem['s_supir'] ?? 'survey';
            $cleanSurvey = preg_replace('/[^A-Za-z0-9_]/', '_', $supir);
            $filename = "Survey_{$cleanSurvey}_" . date('Y-m-d') . ".pdf";
            unset($supir, $cleanSurvey);

            $data = [
                'surveys' => $singleItem,
            ];
            unset($singleItem);

            return streamPdf('surveys/data_survey_pdf', $data, $filename, true);
        } catch (\Throwable $e) {
            log_message('error', 'Gagal generate PDF survey #' . $survey_id . ': ' . $e->getMessage());
            session()->setFlashdata('error', 'Gagal membuat PDF: ' . $e->getMessage());
            return redirect()->to('surveys/survey_management');
        }
    }

    public function downloadSurveyImage($survey_id)
    {
        try {
            $surveydetails = $this->driversModel->get_surveydetails($survey_id);
            if (!$surveydetails) {
                session()->setFlashdata('error', 'Data tidak ditemukan.');
                return redirect()->to('surveys/survey_management');
            }

            // resolveWilayahNamesSurvey expects array-of-rows; resolve region
            // names but never let a wilayah API failure block the image page
            try {
                $surveydetails = $this->driversModel->resolveWilayahNamesSurvey($surveydetails);
            } catch (\Throwable $e) {
                log_message('error', 'Wilayah resolve failed for survey image #' . $survey_id . ': ' . $e->getMessage());
            }

            $singleItem = $surveydetails[0];
            unset($surveydetails);

            $data = [
                'surveys' => $singleItem,
            ];
            unset($singleItem);

            return view('surveys/survey_image', $data);
        } catch (\Throwable $e) {
            log_message('error', 'Gagal generate image survey #' . $survey_id . ': ' . $e->getMessage());
            session()->setFlashdata('error', 'Gagal membuat gambar survey: ' . $e->getMessage());
            return redirect()->to('surveys/survey_management');
        }
    }

    public function surveylist_drivers()
    {
        $data['surveylist_drivers'] = $this->driversModel->get_survey();
        return view('surveys/survey_management', $data);
    }

    public function get_driver_surveydetails()
    {
        if ($this->request->getGet('d_id')) {
            $d_id = $this->request->getGet('d_id');
            log_message('info', 'Received d_id: ' . $d_id);

            $driverDetails = $this->driversModel->get_driver_survey($d_id);
            log_message('info', 'Driver Details: ' . json_encode($driverDetails));

            if (empty($driverDetails)) {
                return $this->response->setJSON(['error' => 'No driver found']);
            }
            return $this->response->setJSON($driverDetails);
        }
        log_message('error', 'No d_id received');
        return $this->response->setJSON([]);
    }

    public function addsurvey() 
    {
        $last_scode = $this->driversModel->get_last_scode();
        $data['new_survey_code'] = $this->generateSurveyCode($last_scode);
        $data['driverlist'] = $this->driversModel->getall_drivers();
        $data['provinces'] = $this->driversModel->getProvinces();
        return view('surveys/survey_add', $data);
    }

    public function insertsurvey()
    {
        $data = $this->request->getPost();
        if (empty($data)) {
            session()->setFlashdata('warningmessage', 'No data submitted.');
            return redirect()->to('drivers/addsurvey');
        }

        $data['s_created_by'] = session('user_id');
        $data['s_created_date'] = date('Y-m-d H:i:s');

        $dateFieldsToConvert = ['s_tanggal', 's_tanggal_masuk'];
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

        // Upload multiple foto rumah (maksimal 3 file)
        $allFiles = $this->request->getFiles();
        $photos = $allFiles['s_fotorumah'] ?? [];
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        $uploadPath = FCPATH . 'assets/uploads/survey/';

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $code = $data['s_code'] ?? 'driver';
        $nis = $data['s_nis'] ?? 'driver';
        $cleanCode = preg_replace('/[^A-Za-z0-9_\-]/', '_', $code);
        $cleanNis = preg_replace('/[^A-Za-z0-9_\-]/', '_', $nis);

        // Inisialisasi kolom foto sebagai kosong
        $data['s_fotorumah_1'] = '';
        $data['s_fotorumah_2'] = '';
        $data['s_fotorumah_3'] = '';

        $photoIndex = 0;
        foreach ($photos as $photo) {
            if ($photoIndex >= 3) break; // Maksimal 3 foto

            if ($photo->isValid() && !$photo->hasMoved()) {
                if (!in_array($photo->getMimeType(), $allowedTypes)) {
                    session()->setFlashdata('old_input', $data);
                    session()->setFlashdata('warningmessage', 'Format foto tidak valid. Hanya JPG/JPEG/PNG yang diperbolehkan.');
                    return redirect()->to('drivers/addsurvey');
                }

                $originalName = pathinfo($photo->getClientName(), PATHINFO_FILENAME);
                $cleanOriginalName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
                $newName = $cleanOriginalName . '_' . $cleanCode . '_' . $cleanNis . '_' . ($photoIndex + 1) . '.' . $photo->guessExtension();

                if ($photo->move($uploadPath, $newName)) {
                    $data['s_fotorumah_' . ($photoIndex + 1)] = $newName;
                }
                $photoIndex++;
            }
        }
        

        // Hapus field yang tidak perlu masuk database
        unset($data['s_fotorumah']);
        unset($data['existing_fotorumah_1']);
        unset($data['existing_fotorumah_2']);
        unset($data['existing_fotorumah_3']);
        unset($data['deleted_existing_fotorumah']);
        unset($data['csrf_token']);
        unset($data['s_kab_name']);
        unset($data['s_kec_name']);
        unset($data['s_kel_name']);

        $insert_id = $this->driversModel->add_survey($data);
        if ($insert_id) {
            session()->setFlashdata('successmessage', 'Survey added successfully.');
            return redirect()->to('surveys/survey_management');
        } else {
            session()->setFlashdata('old_input', $data);
            session()->setFlashdata('warningmessage', 'Something went wrong. Try again.');
            return redirect()->to('drivers/addsurvey');
        }
    }

    public function editsurvey() 
    {
        $survey_id = $this->request->getPost('survey_id');
    
        if (empty($survey_id)) {
            $survey_id = $this->request->getUri()->getSegment(3);
        }
        
        if (empty($survey_id)) {
            return redirect()->to('/pagenotfound')->with('error', 'Survey tidak ditemukan');
        }
        $last_scode = $this->driversModel->get_last_scode();
        $data['new_survey_code'] = $this->generateSurveyCode($last_scode);
        $data['driverlist'] = $this->driversModel->getall_drivers();
        $data['surveydetails'] = $this->driversModel->get_surveydetails($survey_id);
        $data['provinces'] = $this->driversModel->getProvinces();
        return view('surveys/survey_add', $data);
    }

    public function updatesurvey()
    {
      $data = $this->request->getPost();

        if (empty($data) || empty($data['s_id'])) {
            session()->setFlashdata('warningmessage', 'No data submitted.');
            return redirect()->to('surveys/survey_management');
        }

        $survey_id = $data['s_id'];
        $data['s_created_by'] = session('user_id');
        $data['s_modified_date'] = date('Y-m-d H:i:s');

        $dateFieldsToConvert = ['s_tanggal', 's_tanggal_masuk'];
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

        // Upload foto rumah (jika ada file baru)
        $allFiles = $this->request->getFiles();
        $photos = $allFiles['s_fotorumah'] ?? [];
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        $uploadPath = FCPATH . 'assets/uploads/survey/';

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $nis = $data['s_nis'] ?? 'survey';
        $code = $data['s_code'] ?? 'survey';
        $cleanNis = preg_replace('/[^A-Za-z0-9_\-]/', '_', $nis);
        $cleanCode = preg_replace('/[^A-Za-z0-9_\-]/', '_', $code);

        // Cek apakah ada file yang diupload (bukan empty file input)
        $hasNewFiles = false;
        foreach ($photos as $photo) {
            if ($photo->isValid() && !$photo->hasMoved()) {
                $hasNewFiles = true;
                break;
            }
        }

        if ($hasNewFiles) {
            // Hapus semua foto lama
            for ($i = 1; $i <= 3; $i++) {
                $oldPhoto = $data['existing_fotorumah_' . $i] ?? '';
                if (!empty($oldPhoto) && file_exists($uploadPath . $oldPhoto)) {
                    unlink($uploadPath . $oldPhoto);
                }
            }

            // Inisialisasi kolom foto sebagai kosong
            $data['s_fotorumah_1'] = '';
            $data['s_fotorumah_2'] = '';
            $data['s_fotorumah_3'] = '';

            $photoIndex = 0;
            foreach ($photos as $photo) {
                if ($photoIndex >= 3) break;

                if ($photo->isValid() && !$photo->hasMoved()) {
                    if (!in_array($photo->getMimeType(), $allowedTypes)) {
                        session()->setFlashdata('warningmessage', 'Format foto tidak valid. Hanya JPG/JPEG/PNG yang diperbolehkan.');
                        return redirect()->to('surveys/editsurvey/' . $survey_id);
                    }

                    $originalName = pathinfo($photo->getClientName(), PATHINFO_FILENAME);
                    $cleanOriginalName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
                    $newName = $cleanOriginalName . '_' . '_' . ($photoIndex + 1) . '.' . $photo->guessExtension();

                    if ($photo->move($uploadPath, $newName)) {
                        $data['s_fotorumah_' . ($photoIndex + 1)] = $newName;
                    }
                    $photoIndex++;
                }
            }
        } else {
            // Tidak ada file baru, tapi mungkin ada foto existing yang dihapus user
            $deletedExisting = $data['deleted_existing_fotorumah'] ?? '';
            if (!empty($deletedExisting)) {
                $deletedFiles = array_filter(array_map('trim', explode(',', $deletedExisting)));
                foreach ($deletedFiles as $deletedFile) {
                    if (!empty($deletedFile) && file_exists($uploadPath . $deletedFile)) {
                        unlink($uploadPath . $deletedFile);
                    }
                }
            }

            // Update kolom foto berdasarkan hidden input yang masih tersisa
            for ($i = 1; $i <= 3; $i++) {
                $data['s_fotorumah_' . $i] = $data['existing_fotorumah_' . $i] ?? '';
            }
        }

        // Hapus field yang tidak perlu masuk database
        unset($data['s_id']);
        unset($data['s_fotorumah']);
        unset($data['existing_fotorumah_1']);
        unset($data['existing_fotorumah_2']);
        unset($data['existing_fotorumah_3']);
        unset($data['deleted_existing_fotorumah']);
        unset($data['csrf_token']);
        unset($data['s_kab_name']);
        unset($data['s_kec_name']);
        unset($data['s_kel_name']);

        $update_survey = $this->driversModel->edit_survey($survey_id, $data);

        if ($update_survey) {
            return redirect()->to('surveys/survey_management')->with('successmessage', 'Survey updated successfully.');
        } else {
            return redirect()->to('surveys/editsurvey/' . $survey_id)->with('warningmessage', 'Something went wrong. Try again.');
        }
    }

    public function viewsurvey()
    {
        $survey_id = $this->request->getPost('survey_id');

        if (empty($survey_id)) {
            $survey_id = $this->request->getUri()->getSegment(3);
        }

        if (empty($survey_id)) {
            return redirect()->to('/pagenotfound')->with('error', 'Survey tidak ditemukan');
        }

        $surveydetails = $this->driversModel->get_surveydetails($survey_id);

        if (isset($surveydetails[0]['s_id'])) {
            $survey = $surveydetails[0];

            if (!empty($survey['s_prov'])) {
                $survey['s_province_name'] = $this->driversModel->getProvinceName($survey['s_prov']);
            }
            if (!empty($survey['s_prov']) && !empty($survey['s_kab'])) {
                $survey['s_city_name'] = $this->driversModel->getRegencyName($survey['s_prov'], $survey['s_kab']);
            }
            if (!empty($survey['s_kab']) && !empty($survey['s_kec'])) {
                $survey['s_district_name'] = $this->driversModel->getDistrictName($survey['s_kab'], $survey['s_kec']);
            }
            if (!empty($survey['s_kec']) && !empty($survey['s_kel'])) {
                $survey['s_village_name'] = $this->driversModel->getVillageName($survey['s_kec'], $survey['s_kel']);
            }

            $data['surveydetails'] = $survey;
            return view('surveys/survey_view', $data);
        } else {
            return view('pagenotfound');
        }
    }

    public function survey_delete()
    {
        $s_id = $this->request->getUri()->getSegment(3);

        $surveyinfo = $this->driversModel->getSurveyById($s_id);
            if ($surveyinfo) {
            $filesDeleted = $this->deleteSurveyFiles($surveyinfo);
            $returndata = $this->driversModel->survey_delete($s_id);

        if ($returndata) {
            session()->setFlashdata('successmessage', 'Survey deleted successfully..');
            return redirect()->to('surveys/survey_management');
        } else {
            session()->setFlashdata('warningmessage', 'Error..! Some driver are mapped with this group. Please remove from Survey management');
            return redirect()->to('drivers/surveylist_drivers');
            }
        }
    }

    private function deleteSurveyFiles($surveyinfo)
    {
        $deleted = false;
        if (!empty($surveyinfo['s_fotorumah'])) {
            $uploadPath = FCPATH . 'assets/uploads/survey/';
            $filePath = $uploadPath . $surveyinfo['s_fotorumah'];
            if (file_exists($filePath)) {
                if (unlink($filePath)) {
                    log_message('info', 'Survey photo deleted: ' . $filePath);
                    $deleted = true;
                } else {
                    log_message('error', 'Failed to delete survey photo: ' . $filePath);
                }
            } else {
                log_message('warning', 'Survey photo not found: ' . $filePath);
            }
        }
        return $deleted;
    }

    public function traininglist_drivers()
    {
        $data['driverlist'] = $this->driversModel->getall_drivers();
        $data['traininglist_drivers'] = $this->driversModel->get_training();
        return view('trainings/training_management', $data);
    }

    private function generateDocumentTraining($driverName, $trainingNumber, $extension)
    {
        $cleanDriverName = preg_replace('/[^A-Za-z0-9]/', '', $driverName);
        $cleanDriverName = strtoupper($cleanDriverName);
        
        $cleantrainingNumber = preg_replace('/[^A-Za-z0-9]+/', '.', $trainingNumber);
        $cleantrainingNumber = strtoupper($cleantrainingNumber);
        
        $cleantrainingNumber = trim($cleantrainingNumber, '.');
        
        $extension = strtolower($extension);
        
        $filename = $cleanDriverName . '_' . $cleantrainingNumber . '.' . $extension;
        
        if (strlen($filename) > 255) {
            $maxLength = 255 - strlen($extension) - 2;
            $maxDriverLength = floor($maxLength / 2);
            $maxBapLength = $maxLength - $maxDriverLength;
            
            $cleanDriverName = substr($cleanDriverName, 0, $maxDriverLength);
            $cleantrainingNumber = substr($cleantrainingNumber, 0, $maxBapLength);
            
            $filename = $cleanDriverName . '_' . $cleantrainingNumber . '.' . $extension;
        }
        
        return $filename;
    }

    private function upload_modultraining($driverName = '', $trainingNumber = '', $oldFileName = '') 
    {
        $file = $this->request->getFile('tr_document');

        if (!($file && $file->isValid() && !$file->hasMoved())) {
            return null;
        }

        if ($file->getMimeType() !== 'application/pdf' && strtolower($file->getClientExtension()) !== 'pdf') {
            return false;
        }

        if ($file->getSize() > 5 * 1024 * 1024) {
            return false;
        }

        $uploadPath = FCPATH . 'assets/uploads/training/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $extension = $file->guessExtension();
        $newName = $this->generateDocumentTraining($driverName, $trainingNumber, $extension);

        $baseName = pathinfo($newName, PATHINFO_FILENAME);
        $counter = 1;
        while (file_exists($uploadPath . $newName) && $newName !== $oldFileName) {
            $newName = $baseName . '_' . $counter . '.' . $extension;
            $counter++;
        }

        if ($file->move($uploadPath, $newName, $newName === $oldFileName)) {
            if (!empty($oldFileName) && $oldFileName !== $newName && file_exists($uploadPath . $oldFileName)) {
                unlink($uploadPath . $oldFileName);
            }
            return $newName;
        }

        return false;
    }

    public function addtraining() 
    {
        $data['driverlist'] = $this->driversModel->getall_drivers(); 
        $data['new_training_code'] = $this->generateCode();

        return view('trainings/training_management', $data);
    }

    public function inserttraining()
    {
        $data = $this->request->getPost();
        if (empty($data)) {
            session()->setFlashData('warningmessage','data training tidak ditemukan');
            return redirect()->to('drivers/traininglist_drivers');
        }

        // Hapus CSRF token dari data (menggunakan fungsi csrf_token() untuk nama dinamis)
        unset($data[csrf_token()]);

        // Convert tr_supir array ke string (karena form menggunakan multiple select)
        if (isset($data['tr_supir']) && is_array($data['tr_supir'])) {
            $data['tr_supir'] = implode(', ', $data['tr_supir']);
        }
        
        $data['tr_created_by'] = session()->get('user_id');
        $data['tr_created_date'] = date('Y-m-d H:i:s');
        $driverName = $data['tr_supir'] ?? '';
        $trainingNumber = $data['tr_code'] ?? '';
        $oldPdf = $data['existing_pdf'] ?? '';

        $pdf_document = $this->upload_modultraining($driverName, $trainingNumber, $oldPdf);
            if ($pdf_document === false) {
                session()->setFlashdata('warningmessage', 'Gagal mengunggah Modul Training. Format harus PDF dan ukuran maksimal 5MB.');
                return redirect()->to('trainings/training_management');
            }

        $data['tr_document'] = $pdf_document ?: $oldPdf;
        unset($data['existing_pdf']);

        $insertTraining = $this->driversModel->add_training($data);
        if ($insertTraining) {
            session()->setFlashData('successmessage', 'Training added successfully.');
            return redirect()->to('trainings/training_management');
        }
        else {
            session()->setFlashData('warningmessage', 'Error! Data training gagal ditambahkan.');
            return redirect()->to('trainings/training_management');
        }
    }

    public function edittraining($tr_id = null) 
    {
        if ($tr_id === null) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'ID training tidak ditemukan'
            ]);
        }

        $training = $this->driversModel->get_trainingdetails($tr_id);

        if ($training && isset($training[0])) {
            return $this->response->setJSON([
                'status' => true,
                'data'   => $training[0]
            ]);
        } else {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Data training tidak ditemukan'
            ]);
        }
    }

    public function updatetraining()
    {
        $data = $this->request->getPost();
        if (empty($data) || empty($data['tr_id'])) {
            session()->setFlashdata('warningmessage', 'Update data training tidak ada');
            return redirect()->to('trainings/training_management');
        }
        
        if (isset($data['tr_supir']) && is_array($data['tr_supir'])) {
            $data['tr_supir'] = implode(', ', $data['tr_supir']);
        }

        $data['tr_modified_date'] = date('Y-m-d H:i:s');
        $driverName = $data['tr_supir'] ?? '';
        $trainingNumber = $data['tr_code'] ?? '';
        $oldPdf = $data['existing_pdf'] ?? null;

        $pdf_document = $this->upload_modultraining($driverName, $trainingNumber, $oldPdf);
            if ($pdf_document === false) {
                session()->setFlashdata('warningmessage', 'Gagal mengunggah Modul Training. Format harus PDF dan ukuran maksimal 5MB.');
                return redirect()->to('trainings/training_management');
            }

            
        $training_id = $data['tr_id'];
        $data['tr_document'] = $pdf_document ?: $oldPdf;
        unset($data['tr_id']);
        unset($data['csrf_token']);
        unset($data['existing_pdf']);
        
        $update_training = $this->driversModel->edit_training($training_id, $data);
        if ($update_training) {
            return redirect()->to('trainings/training_management')->with('successmessage', 'Training updated successfully.');
        } else {
            return redirect()->to('trainings/training_management')->with('warningmessage', 'Something went wrong. Try again.');
        }
    }

    public function training_delete($tr_id = null)
    {
        if ($tr_id === null) {
            $tr_id = $this->request->getUri()->getSegment(3);
        }
        $returndata = $this->driversModel->training_delete($tr_id);
        if ($returndata) {
            session()->setFlashdata('successmessage', 'Training deleted successfully..');
            return redirect()->to('trainings/training_management');
        } else {
            session()->setFlashdata('warningmessage', 'Error..! Some driver are mapped with this group. Please remove from Training management');
            return redirect()->to('trainings/training_management');
        }
    }

    public function viewtraining($tr_id = null) 
    {
        if ($tr_id === null) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'ID training tidak ditemukan'
            ]);
        }

        $training = $this->driversModel->get_trainingdetails($tr_id);

        if ($training && isset($training[0])) {
            return $this->response->setJSON([
                'status' => true,
                'data'   => $training[0]
            ]);
        } else {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Data training tidak ditemukan'
            ]);
        }
    }

    /**
     * Get Detail Training by Driver Name (AJAX)
     * Mengembalikan JSON daftar tr_tema untuk modal detail
     */
    public function getDetailTrainingByDriver()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal memanggil data'
            ])->setStatusCode(400);
        }

        try {
            $driverName = $this->request->getPost('driver_name');

            if (empty($driverName)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Nama supir tidak boleh kosong'
                ])->setStatusCode(400);
            }

            $driverName = strip_tags(trim($driverName));

            $trainings = $this->driversModel->getTrainingsByDriver($driverName);

            if (empty($trainings)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Supir ini belum pernah mengikuti training',
                    'data' => [],
                    'total' => 0
                ]);
            }

            $formattedData = [];
            foreach ($trainings as $training) {
                $formattedData[] = [
                    'tr_id' => $training['tr_id'],
                    'tr_tanggal' => date('d-m-Y', strtotime($training['tr_tanggal'])),
                    'tr_tanggal_raw' => $training['tr_tanggal'],
                    'tr_tema' => htmlspecialchars($training['tr_tema'], ENT_QUOTES, 'UTF-8'),
                    'tr_kategori' => htmlspecialchars($training['tr_kategori'], ENT_QUOTES, 'UTF-8'),
                    'tr_pemateri' => htmlspecialchars($training['tr_pemateri'], ENT_QUOTES, 'UTF-8'),
                    'tr_lokasi' => htmlspecialchars($training['tr_lokasi'], ENT_QUOTES, 'UTF-8'),
                    'tr_keterangan' => htmlspecialchars($training['tr_keterangan'], ENT_QUOTES, 'UTF-8'),
                    'tr_code' => htmlspecialchars($training['tr_code'] ?? '-', ENT_QUOTES, 'UTF-8')
                ];
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data berhasil dimuat',
                'data' => $formattedData,
                'total' => count($formattedData),
                'driver_name' => htmlspecialchars($driverName, ENT_QUOTES, 'UTF-8'),
                'driver_nis' => $trainings[0]['tr_nis'] ?? '-'
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error in getDetailTrainingByDriver: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memuat data. Silakan coba lagi.'
            ])->setStatusCode(500);
        }
    }

    public function getDetailTrainingByTema()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal memanggil data'
            ])->setStatusCode(400);
        }

        try {
            $temaName = $this->request->getPost('tema_name');

            if (empty($temaName)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Nama tema tidak boleh kosong'
                ])->setStatusCode(400);
            }

            $temaName = strip_tags(trim($temaName));

            $trainings = $this->driversModel->getTrainingsByTema($temaName);

            if (empty($trainings)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Modul tema belum pernah ditrainingkan',
                    'data' => [],
                    'total' => 0
                ]);
            }

            $formattedData = [];
            foreach ($trainings as $training) {
                $formattedData[] = [
                    'tr_id' => $training['tr_id'],
                    'tr_tanggal' => date('d-m-Y', strtotime($training['tr_tanggal'])),
                    'tr_tanggal_raw' => $training['tr_tanggal'],
                    'tr_tema' => htmlspecialchars($training['tr_tema'], ENT_QUOTES, 'UTF-8'),
                    'tr_supir' => htmlspecialchars($training['tr_supir'], ENT_QUOTES, 'UTF-8'),
                    'tr_nis' => htmlspecialchars($training['tr_nis'], ENT_QUOTES, 'UTF-8'),
                    'tr_kategori' => htmlspecialchars($training['tr_kategori'], ENT_QUOTES, 'UTF-8'),
                    'tr_pemateri' => htmlspecialchars($training['tr_pemateri'], ENT_QUOTES, 'UTF-8'),
                    'tr_lokasi' => htmlspecialchars($training['tr_lokasi'], ENT_QUOTES, 'UTF-8'),
                    'tr_keterangan' => htmlspecialchars($training['tr_keterangan'], ENT_QUOTES, 'UTF-8'),
                    'tr_code' => htmlspecialchars($training['tr_code'] ?? '-', ENT_QUOTES, 'UTF-8')
                ];
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data berhasil dimuat',
                'data' => $formattedData,
                'total' => count($formattedData),
                'tema_name' => htmlspecialchars($temaName, ENT_QUOTES, 'UTF-8'),
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error in getDetailTrainingByTema: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memuat data. Silakan coba lagi.'
            ])->setStatusCode(500);
        }
    }

    public function loanlist_drivers()
    {
        $data['loanlist_drivers'] = $this->driversModel->get_loan();
        $data['driverlist'] = $this->driversModel->getall_drivers();
        $data['loanapprove_drivers'] = $this->driversModel->get_loan_bystatus();
        $data['pendingCount'] = !empty($data['loanapprove_drivers']) ? count($data['loanapprove_drivers']) : 0;
        $combined = $this->driversModel->get_combined_loan_bap();
        $data['combined_list'] = array_filter($combined, function($item) {
            if ($item['type'] == 'baps') {
                return $item['b_tanggal'] != '0000-00-00' && !empty($item['b_tanggal']);
            }
            return true;
        });

        return view('loans/loan_management', $data);
    }

    public function loanlist_approve()
    {
        $data['loanapprove_drivers'] = $this->driversModel->get_loan_bystatus();
        $data['driverlist'] = $this->driversModel->getall_drivers();
        return view('loans/loan_approve', $data);
    }

    public function addloan() 
    {
        $last_lcode = $this->driversModel->get_last_lcode();
        $data['new_loan_code'] = $this->generateLoanCode($last_lcode);
        $data['driverlist'] = $this->driversModel->getall_drivers();
        $data['vechiclelist'] = $this->vehicleModel->getall_vehicle();
        return view('loans/loan_add', $data);
    }

    public function editloan() 
    {
        $loan_id = $this->request->getPost('loan_id');
    
        if (empty($loan_id)) {
            $loan_id = $this->request->getUri()->getSegment(3);
        }
        
        if (empty($loan_id)) {
            return redirect()->to('/pagenotfound')->with('error', 'Loan tidak ditemukan');
        }
        $last_lcode = $this->driversModel->get_last_lcode();
        $data['new_loan_code'] = $this->generateLoanCode($last_lcode);
        $data['driverlist'] = $this->driversModel->getall_drivers();
        $data['vechiclelist'] = $this->vehicleModel->getall_vehicle();
        $data['loandetails'] = $this->driversModel->get_loandetails($loan_id);
        return view('loans/loan_add', $data);
    }

    public function viewloan()
    {
        $loan_id = $this->request->getPost('loan_id');
    
        if (empty($loan_id)) {
            $loan_id = $this->request->getUri()->getSegment(3);
        }
        
        if (empty($loan_id)) {
            return redirect()->to('/pagenotfound')->with('error', 'Loan tidak ditemukan');
        }
        $loandetails = $this->driversModel->get_loandetails($loan_id);

        if (isset($loandetails[0]['l_id'])) {
            $d_nis = $loandetails[0]['l_nis'];
            $data['loandetails'] = $loandetails[0];
            return view('loans/loan_view', $data);
        } else {
            return view('pagenotfound');
        }
    }

}