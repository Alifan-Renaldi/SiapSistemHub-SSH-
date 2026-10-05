<?php

namespace App\Controllers;

use App\Models\ReportModel;
use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use CodeIgniter\HTTP\ResponseInterface;
use DateTime;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use Config\Services;

class Reports extends BaseController
{
    protected $driversModel;
    protected $vehicleModel;
    protected $reportModel;
    protected $session;

    public function __construct()
    {
        $this->driversModel = model('DriversModel');
        $this->vehicleModel = model('VehicleModel');
        $this->reportModel = model('ReportModel');
        $this->session = \Config\Services::session();
        
        helper('url');
    }

    // public function getRegencies($province_id) 
    // {
    //     if (empty($province_id)) {
    //         return $this->response->setJSON(['error' => 'Province ID is required']);
    //     }
    //     $regencies = $this->driversModel->getRegencies($province_id);
    //     if ($regencies) {
    //         return $this->response->setJSON($regencies);
    //     }
    //     return $this->response->setJSON(['error' => 'No regencies found or failed to fetch data']);
    // }

    // public function getDistricts($regency_id) 
    // {
    //     if (empty($regency_id)) {
    //         return $this->response->setJSON(['error' => 'Regency ID is required']);
    //     }
    //     $districts = $this->driversModel->getDistricts($regency_id);
    //     if ($districts) {
    //         return $this->response->setJSON($districts);
    //     }
    //     return $this->response->setJSON(['error' => 'No districts found or failed to fetch data']);
    // }

    // public function getVillages($district_id) 
    // {
    //     if (empty($district_id)) {
    //         return $this->response->setJSON(['error' => 'District ID is required']);
    //     }
    //     $villages = $this->driversModel->getVillages($district_id);
    //     if ($villages) {
    //         return $this->response->setJSON($villages);
    //     }
    //     return $this->response->setJSON(['error' => 'No villages found or failed to fetch data']);
    // }

    public function driver()
    {
        $postData = $this->request->getPost();
        
        if(isset($postData['driverreport'])) {
        $driver_from = !empty($postData['driver_from']) ? $postData['driver_from'] : null;
        $driver_to = !empty($postData['driver_to']) ? $postData['driver_to'] : null;
        $driver_name = !empty($postData['driver_name']) ? $postData['driver_name'] : null;
        $age_from = !empty($postData['age_from']) ? $postData['age_from'] : null;
        $age_to = !empty($postData['age_to']) ? $postData['age_to'] : null;
        $bpjs_status = !empty($postData['bpjs_status']) ? $postData['bpjs_status'] : null;
        $work_period_from = !empty($postData['work_period_from']) ? $postData['work_period_from'] : null;
        $work_period_to = !empty($postData['work_period_to']) ? $postData['work_period_to'] : null;

            $driverreport = $this->reportModel->driver_reports(
                $postData['driver_from'],
                $postData['driver_to'],
                $postData['driver_name'],
                $postData['age_from'],
                $postData['age_to'],
                $postData['bpjs_status'],
                $postData['work_period_from'],
                $postData['work_period_to']
            );

            //Resolve ID wilayah menjadi nama (provinsi/kab-kota/kecamatan/kelurahan) via helper bersama
            // $driverreport = $this->resolveWilayahNames($driverreport);

            if(empty($driverreport)) {
                $this->session->setFlashdata('warningmessage', 'No data found..');
                $data['driver'] = '';
                
            } else {
                $this->session->remove('warningmessage');
                $data['driver'] = $driverreport;
            }
        }
        
        $data['driverlist'] = $this->driversModel->getall_drivers();
        $data['postData'] = $postData;

        return view('reports/report_driver', $data);
    }

    public function bap()
    {
        $postData = $this->request->getPost();

        if(isset($postData['bapreport'])) {
            $bap_from = !empty($postData['bap_from']) ? $postData['bap_from'] : null;
            $bap_to = !empty($postData['bap_to']) ? $postData['bap_to'] : null;
            $bap_name = !empty($postData['bap_name']) ? $postData['bap_name'] : null;
            $driver_status = !empty($postData['driver_status']) ? $postData['driver_status'] : null;
            $case_type = !empty($postData['case_type']) ? $postData['case_type'] : null;
            $classification = !empty($postData['classification']) ? $postData['classification'] : null;
            $payment = !empty($postData['payment']) ? $postData['payment'] : null;
        
            $bapreport = $this->reportModel->bap_reports(
                $postData['bap_from'],
                $postData['bap_to'],
                $postData['bap_name'],
                $postData['driver_status'],
                $postData['case_type'],
                $postData['classification'],
                $postData['payment']
            );
            
            if(empty($bapreport)) {
                $this->session->setFlashdata('warningmessage', 'Tidak ada data BAP');
                $data['bap'] = '';
            } else {
                $this->session->remove('warningmessage');
                $data['bap'] = $bapreport;
            }
        }
        
        $data['baplist'] = $this->driversModel->get_bap();
        $data['postData'] = $postData;

        return view('reports/report_bap', $data);
    }

    public function laka()
    {
        $postData = $this->request->getPost();

        if(isset($postData['lakareport'])) {
            $laka_from = !empty($postData['laka_from']) ? $postData['laka_from'] : null;
            $laka_to = !empty($postData['laka_to']) ? $postData['laka_to'] : null;
            $driver_name = !empty($postData['driver_name']) ? $postData['driver_name'] : null;
            $nopol = !empty($postData['nopol']) ? $postData['nopol'] : null;
            $classification = !empty($postData['classification']) ? $postData['classification'] : null;
        
            $lakareport = $this->reportModel->laka_reports(
            $postData['laka_from'] ?? null,
            $postData['laka_to'] ?? null,
            $postData['driver_name'] ?? 'all driver',
            $postData['nopol'] ?? 'all',
            $postData['classification'] ?? null
        );
            
            if(empty($lakareport)) {
            $this->session->setFlashdata('warningmessage', 'No data found for Lakalantas reports..');
            $data['laka'] = '';
            } else {
                $this->session->remove('warningmessage');
                $data['laka'] = $lakareport;
            }
        } else {
        $data['laka'] = [];
    }
        
        $data['lakalist'] = $this->driversModel->get_bap();
        $data['drivers'] = $this->driversModel->getall_drivers();
        $data['vehicles'] = $this->vehicleModel->getall_vehicle();
        $data['postData'] = $postData;

        return view('reports/report_laka', $data);
    }

    public function survey()
    {
        $postData = $this->request->getPost();
        
        if(isset($postData['surveyreport'])) {
            $surveyreport = $this->reportModel->survey_reports(
            $postData['survey_from'] ?? null,
            $postData['survey_to'] ?? null,
            $postData['survey_status'] ?? 'all survey',
            $postData['driver_status'] ?? 'all'
        );

            $surveyreport = $this->resolveWilayahNamesSurvey($surveyreport);
            
            if(empty($surveyreport)) {
                $this->session->setFlashdata('warningmessage', 'No data found..');
                $data['survey'] = [];
            } else {
                $this->session->remove('warningmessage');
                $data['survey'] = $surveyreport;
            }
        }
    
        $data['surveylist'] = $this->driversModel->get_survey();
        $data['driverlist'] = $this->driversModel->getall_drivers();
        $data['postData'] = $postData;

        return view('reports/report_survey', $data);
    }

    public function training()
    {
        $postData = $this->request->getPost();
        
        if(isset($postData['trainingreport'])) {
            $trainingreport = $this->reportModel->training_reports(
                $postData['training_from'] ?? null,
                $postData['training_to'] ?? null,
                $postData['training_status'] ?? 'all training',
                $postData['driver_status'] ?? null,
                $postData['training_count'] ?? null
            );
            
            if(empty($trainingreport)) {
                $this->session->setFlashdata('warningmessage', 'No data found..');
                $data['training'] = '';
            } else {
                $this->session->remove('warningmessage');
                $data['training'] = $trainingreport;
            }
        }

        $data['traininglist'] = $this->driversModel->get_training();
        $data['postData'] = $postData;

        return view('reports/report_training', $data);
    }

    public function loan()
    {
        $postData = $this->request->getPost();

        if(isset($postData['loanreport'])) {
            $loan_from = !empty($postData['loan_from']) ? $postData['loan_from'] : null;
            $loan_to = !empty($postData['loan_to']) ? $postData['loan_to'] : null;
            $loan_type = !empty($postData['loan_type']) ? $postData['loan_type'] : null;
            $loan_status = !empty($postData['loan_status']) ? $postData['loan_status'] : null;
            $driver_status = !empty($postData['driver_status']) ? $postData['driver_status'] : null;
            $driver_name = !empty($postData['driver_name']) ? $postData['driver_name'] : null;
            $payment = !empty($postData['payment']) ? $postData['payment'] : null;
        
            $loanreport = $this->reportModel->loan_reports(
                $postData['loan_from'],
                $postData['loan_to'],
                $postData['loan_type'],
                $postData['loan_status'],
                $postData['driver_status'],
                $postData['driver_name'],
                $postData['payment']
            );
            
            if(empty($loanreport)) {
                $this->session->setFlashdata('warningmessage', 'No data found..');
                $data['loan'] = '';
            } else {
                $this->session->remove('warningmessage');
                $data['loan'] = $loanreport;
            }
        }
        
        $data['drivers'] = $this->driversModel->getall_drivers();
        $data['loanlist'] = $this->driversModel->get_loan();
        $data['postData'] = $postData;

        return view('reports/report_loan', $data);
    }

    public function vehicle()
    {
        $postData = $this->request->getPost();
        
        if(isset($postData['vehiclereport'])) {
            $vehiclereport = $this->reportModel->vehicle_reports(
                $postData['vehicle_from'] ?? null,
                $postData['vehicle_to'] ?? null,
                $postData['vehicle_name'] ?? 'all',
                $postData['vehicle_owner'] ?? [],
                $postData['vehicle_type'] ?? [],
                $postData['report_type'] ?? 'all',
                $postData['location_kir'] ?? null
                );
            
            if(empty($vehiclereport)) {
                $this->session->setFlashdata('warningmessage', 'No data found..');
                $data['vehicle'] = '';
            } else {
                $this->session->remove('warningmessage');
                $data['vehicle'] = $vehiclereport;
            }
        }

        $data['owner_list'] = $this->vehicleModel->get_distinct_owners();
        $data['type_list'] = $this->vehicleModel->get_distinct_types(); 

        $data['vehiclelist'] = $this->vehicleModel->getall_vehicle();
        $data['postData'] = $postData;

        return view('reports/report_vehicle', $data);
    }

    public function inventory()
    {
        $postData = $this->request->getPost();

        if(isset($postData['inventoryreport'])) {
            $inventoryreport = $this->reportModel->inventory_reports(
                $postData['invent_from'] ?? null,
                $postData['invent_to'] ?? null,
                $postData['check_status'] ?? null,
                $postData['nopol'] ?? 'all',
                $postData['invent_type'] ?? null,
                $postData['vech_type'] ?? null
                );
            
            if(empty($inventoryreport)) {
                $this->session->setFlashdata('warningmessage', 'No data found..');
                $data['inventory'] = '';
            } else {
                $this->session->remove('warningmessage');
                $data['inventory'] = $inventoryreport;

                $firstRecord = $inventoryreport[0];
            $data['data_source'] = $firstRecord['data_source'] ?? 'inventory';
            }
        }

        $data['vehiclelist'] = $this->vehicleModel->getall_vehicle();
        $data['inventory_columns'] = $this->vehicleModel->get_inventory_columns();
        $inventoryData = $this->vehicleModel->get_distinct_inventory_data();
        $data['inventory_vehicles'] = $inventoryData['vehicles'];
        $data['type_list'] = $inventoryData['types'];
        $data['postData'] = $postData;

        return view('reports/report_inventory', $data);
    }

    public function handover()
    {
        $postData = $this->request->getPost();
        
        if(isset($postData['handoverreport'])) {
            $handoverreport = $this->reportModel->handover_reports(
                $postData['hand_from'] ?? null,
                $postData['hand_to'] ?? null,
                $postData['check_status'] ?? null,
                $postData['nopol'] ?? 'all',
                $postData['driver'] ?? null
                );
            
            if(empty($handoverreport)) {
                $this->session->setFlashdata('warningmessage', 'No data found..');
                $data['handover'] = '';
            } else {
                $this->session->remove('warningmessage');
                $data['handover'] = $handoverreport;

                $firstRecord = $handoverreport[0];
            $data['data_source'] = $firstRecord['data_source'] ?? 'handover';
            }
        }
        

        $data['vehiclelist'] = $this->vehicleModel->getall_vehicle();
        $data['drivers'] = $this->driversModel->getall_drivers();
        $data['handover_vehicles'] = $this->vehicleModel->get_distinct_handover_vehicles();
        $data['postData'] = $postData;

        return view('reports/report_handover', $data);
    }


    public function export_driver_pdf()
    {
        // Load the data with the same filters
        $reportModel = new ReportModel();
        
        $driverreport = $reportModel->driver_reports(
            $this->request->getGet('driver_from'),
            $this->request->getGet('driver_to'),
            $this->request->getGet('driver_name'),
            $this->request->getGet('age_from'),
            $this->request->getGet('age_to'),
            $this->request->getGet('bpjs_status'),
            $this->request->getGet('work_period_from'),
            $this->request->getGet('work_period_to')
        );
        
        // Pastikan data ada
        if (empty($driverreport)) {
            session()->setFlashdata('error', 'Tidak ada data untuk diexport');
            return redirect()->to('reports/driver');
        }
        
        $data = [
            'drivers' => $driverreport,
            'title' => 'Laporan Data Supir'
        ];
        
        return streamPdf('drivers/drivers_pdf', $data, "Driver_Report_" . date('Y-m-d') . ".pdf", true);
    }

    public function export_bap_pdf()
    {
        $reportModel = new ReportModel();
        
        $bapreport = $reportModel->bap_reports(
            $this->request->getGet('bap_from'),
            $this->request->getGet('bap_to'),
            $this->request->getGet('bap_name'),
            $this->request->getGet('driver_status'),
            $this->request->getGet('case_type'),
            $this->request->getGet('classification'),
            $this->request->getGet('payment')
        );
        
        if (empty($bapreport)) {
            session()->setFlashdata('error', 'Tidak ada data untuk diexport');
            return redirect()->to('reports/bap');
        }
        
        $data = [
            'baps' => $bapreport,
            'title' => 'Laporan Data BAP'
        ];
        return streamPdf('baps/bap_pdf', $data, "Bap_Report_" . date('Y-m-d') . ".pdf", true);
    }

    public function export_laka_pdf()
    {
        $reportModel = new ReportModel();
        
        $lakareport = $reportModel->laka_reports(
            $this->request->getGet('laka_from') ?? null,
            $this->request->getGet('laka_to') ?? null,
            $this->request->getGet('driver_name') ?? 'all driver',
            $this->request->getGet('nopol') ?? null,
            $this->request->getGet('classification') ?? ''
        );
        
        if (empty($lakareport)) {
            session()->setFlashdata('error', 'Tidak ada data untuk diexport');
            return redirect()->to('reports/laka');
        }
        
        $data = [
            'lakas' => $lakareport,
            'title' => 'Laporan Data Laka'
        ];
        return streamPdf('baps/laka_pdf', $data, "Laka_Report_" . date('Y-m-d') . ".pdf", true);
    }

    public function export_survey_pdf()
    {
        $reportModel = new ReportModel();
        
        $surveyreport = $reportModel->survey_reports(
            $this->request->getGet('survey_from'),
            $this->request->getGet('survey_to'),
            $this->request->getGet('survey_status'),
            $this->request->getGet('driver_status')
        );

        $surveyreport = $this->resolveWilayahNamesSurvey($surveyreport);
        
        if (empty($surveyreport)) {
            session()->setFlashdata('error', 'Tidak ada data untuk diexport');
            return redirect()->to('reports/survey');
        }
        
        $data = [
            'surveys' => $surveyreport,
            'title' => 'Laporan Data Survey'
        ];
        return streamPdf('surveys/survey_pdf', $data, "Survey_Report_" . date('Y-m-d') . ".pdf", true);
    }

    public function export_training_pdf()
    {
        $reportModel = new ReportModel();
        
        $trainingreport = $reportModel->training_reports(
            $this->request->getGet('training_from'),
            $this->request->getGet('training_to'),
            $this->request->getGet('training_status'),
            $this->request->getGet('driver_status'),
            $this->request->getGet('training_count')
        );
        
        if (empty($trainingreport)) {
            session()->setFlashdata('error', 'Tidak ada data untuk diexport');
            return redirect()->to('reports/training');
        }
        
        $data = [
            'trainings' => $trainingreport,
            'title' => 'Laporan Data Training'
        ];
        return streamPdf('trainings/training_pdf', $data, "Training_Report_" . date('Y-m-d') . ".pdf", true);
    }

    public function export_loan_pdf()
    {
        $reportModel = new ReportModel();
        
        $loanreport = $reportModel->loan_reports(
            $this->request->getGet('loan_from'),
            $this->request->getGet('loan_to'),
            $this->request->getGet('loan_type'),
            $this->request->getGet('loan_status'),
            $this->request->getGet('driver_status'),
            $this->request->getGet('driver_name'),
            $this->request->getGet('payment')
        );
        
        if (empty($loanreport)) {
            session()->setFlashdata('error', 'Tidak ada data untuk diexport');
            return redirect()->to('reports/loan');
        }
        
        $data = [
            'loans' => $loanreport,
            'title' => 'Laporan Data Loan'
        ];
        return streamPdf('loans/loan_pdf', $data, "Loan_Report_" . date('Y-m-d') . ".pdf", true);
    }

    public function export_vehicle_pdf()
    {
        $reportModel = new ReportModel();
        
        $vehiclereport = $reportModel->vehicle_reports(
            $this->request->getGet('vehicle_from'),
            $this->request->getGet('vehicle_to'),
            $this->request->getGet('vehicle_name'),
            $this->request->getGet('vehicle_owner'),
            $this->request->getGet('vehicle_type'),
            $this->request->getGet('report_type') ?? 'all',
            $this->request->getGet('location_kir')
        );
        
        if (empty($vehiclereport)) {
            session()->setFlashdata('error', 'Tidak ada data untuk diexport');
            return redirect()->to('reports/vehicle');
        }
        
        $data = [
            'vehicle' => $vehiclereport,
            'title' => 'Laporan Data Vehicle'
        ];
        return streamPdf('vehicles/vehicle_pdf', $data, "Vehicle_Report_" . date('Y-m-d') . ".pdf", true);
    }

    public function export_inventory_pdf()
    {
        $reportModel = new ReportModel();

        $inventoryreport = $reportModel->inventory_reports(
            $this->request->getGet('invent_from') ?? null,
            $this->request->getGet('invent_to') ?? null,
            $this->request->getGet('check_status') ?? null,
            $this->request->getGet('nopol') ?? 'all',
            $this->request->getGet('invent_type') ?? null,
            $this->request->getGet('vech_type') ?? null
        );
        
        if (empty($inventoryreport)) {
            session()->setFlashdata('error', 'Tidak ada data untuk diexport');
            return redirect()->to('reports/inventory');
        }
        
        $data = [
            'inventory' => $inventoryreport,
            'title' => 'Laporan Data Inventory'
        ];
        return streamPdf('inventory/inventory_pdf', $data, "Inventory_Report_" . date('Y-m-d') . ".pdf", true);
    }

    public function export_handover_pdf()
    {
        $reportModel = new ReportModel();

        $handoverreport = $reportModel->handover_reports(
            $this->request->getGet('hand_from') ?? null,
            $this->request->getGet('hand_to') ?? null,
            $this->request->getGet('check_status') ?? null,
            $this->request->getGet('nopol') ?? 'all',
            $this->request->getGet('driver') ?? null
        );
        
        if (empty($handoverreport)) {
            session()->setFlashdata('error', 'Tidak ada data untuk diexport');
            return redirect()->to('reports/handover');
        }
        
        $data = [
            'handover' => $handoverreport,
            'title' => 'Laporan Data Handover'
        ];
        return streamPdf('handover/handover_pdf', $data, "Handover_Report_" . date('Y-m-d') . ".pdf", true);
    }

    /**
     * Resolve ID wilayah (provinsi/kab-kota/kecamatan/kelurahan) menjadi nama
     */
    private function resolveWilayahNames(array $rows): array
    {
        if (empty($rows)) {
            return $rows;
        }

        // Provinsi: daftar global, cukup 1x fetch
        $province_map = [];
        foreach ($this->driversModel->getProvinces() as $prov) {
            $province_map[$prov['id']] = $prov['name'];
        }

        // Kabupaten/Kota: fetch per unique province ID
        $regency_map = [];
        $unique_provinces = array_unique(array_filter(array_column($rows, 'd_province'), function ($v) {
            return $v !== '' && $v !== 'None';
        }));
        foreach ($unique_provinces as $pid) {
            foreach ($this->driversModel->getRegencies($pid) as $reg) {
                $regency_map[$reg['id']] = $reg['name'];
            }
        }

        // Kecamatan: fetch per unique city ID
        $district_map = [];
        $unique_cities = array_unique(array_filter(array_column($rows, 'd_city'), function ($v) {
            return $v !== '' && $v !== 'None';
        }));
        foreach ($unique_cities as $cid) {
            foreach ($this->driversModel->getDistricts($cid) as $dis) {
                $district_map[$dis['id']] = $dis['name'];
            }
        }

        // Kelurahan: fetch per unique subdistrict ID
        $village_map = [];
        $unique_subdistricts = array_unique(array_filter(array_column($rows, 'd_subdistrict'), function ($v) {
            return $v !== '' && $v !== 'None';
        }));
        foreach ($unique_subdistricts as $sid) {
            foreach ($this->driversModel->getVillages($sid) as $vil) {
                $village_map[$vil['id']] = $vil['name'];
            }
        }

        // Terapkan nama ke setiap row
        foreach ($rows as &$row) {
            $row['d_province_name'] = $province_map[$row['d_province']] ?? ($row['d_province'] ?: '-');
            $row['d_city_name']     = $regency_map[$row['d_city']]     ?? ($row['d_city'] ?: '-');
            $row['d_district_name'] = $district_map[$row['d_subdistrict']] ?? ($row['d_subdistrict'] ?: '-');
            $row['d_village_name']  = $village_map[$row['d_village']]  ?? ($row['d_village'] ?: '-');
        }
        unset($row);

        return $rows;
    }

    private function resolveWilayahNamesSurvey(array $rows): array
    {
        if (empty($rows)) {
            return $rows;
        }

        // Provinsi: daftar global, cukup 1x fetch
        $province_map = [];
        foreach ($this->driversModel->getProvinces() as $prov) {
            $province_map[$prov['id']] = $prov['name'];
        }

        // Kabupaten/Kota: fetch per unique province ID
        $regency_map = [];
        $unique_provinces = array_unique(array_filter(array_column($rows, 's_prov'), function ($v) {
            return $v !== '' && $v !== 'None';
        }));
        foreach ($unique_provinces as $pid) {
            foreach ($this->driversModel->getRegencies($pid) as $reg) {
                $regency_map[$reg['id']] = $reg['name'];
            }
        }

        // Kecamatan: fetch per unique city ID
        $district_map = [];
        $unique_cities = array_unique(array_filter(array_column($rows, 's_kab'), function ($v) {
            return $v !== '' && $v !== 'None';
        }));
        foreach ($unique_cities as $cid) {
            foreach ($this->driversModel->getDistricts($cid) as $dis) {
                $district_map[$dis['id']] = $dis['name'];
            }
        }

        // Kelurahan: fetch per unique subdistrict ID
        $village_map = [];
        $unique_subdistricts = array_unique(array_filter(array_column($rows, 's_kec'), function ($v) {
            return $v !== '' && $v !== 'None';
        }));
        foreach ($unique_subdistricts as $sid) {
            foreach ($this->driversModel->getVillages($sid) as $vil) {
                $village_map[$vil['id']] = $vil['name'];
            }
        }

        // Terapkan nama ke setiap row
        foreach ($rows as &$row) {
            $row['s_province_name'] = $province_map[$row['s_prov']] ?? ($row['s_prov'] ?: '-');
            $row['s_city_name']     = $regency_map[$row['s_kab']]     ?? ($row['s_kab'] ?: '-');
            $row['s_district_name'] = $district_map[$row['s_kec']] ?? ($row['s_kec'] ?: '-');
            $row['s_village_name']  = $village_map[$row['s_kel']]  ?? ($row['s_kel'] ?: '-');
        }
        unset($row);

        return $rows;
    }

    public function export_driver_excel()
    {
        $driverreport = $this->reportModel->driver_reports(
            $this->request->getGet('driver_from'),
            $this->request->getGet('driver_to'),
            $this->request->getGet('driver_name'),
            $this->request->getGet('age_from'),
            $this->request->getGet('age_to'),
            $this->request->getGet('bpjs_status'),
            $this->request->getGet('work_period_from'),
            $this->request->getGet('work_period_to'),
        );

        if (empty($driverreport)) {
            session()->setFlashdata('warningmessage', 'Tidak ada data untuk diexport.');
            return redirect()->to('reports/driver');
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Driver Report');

        //pengubahan format ID wilayah menjadi nama (provinsi/kab-kota/kecamatan/kelurahan)
        $driverreport = $this->resolveWilayahNames($driverreport);

        // Header kolom
        $headers = [
            'A1' => 'No',
            'B1' => 'NIS',
            'C1' => 'Nama Supir',
            'D1' => 'Nama Panggilan',
            'E1' => 'Tempat Lahir',
            'F1' => 'Tanggal Lahir',
            'G1' => 'Umur',
            'H1' => 'Pendidikan',
            'I1' => 'Status Sipil',
            'J1' => 'No Handphone',
            'K1' => 'Alamat Tempat Tinggal',
            'L1' => 'No NIK',
            'M1' => 'Masa Berlaku KTP',
            'N1' => 'No SIM',
            'O1' => 'Masa Berlaku SIM',
            'P1' => 'Status BPJS',
            'Q1' => 'No Rekening',
            'R1' => 'Bank',
            'S1' => 'Pemilik Rekening',
            'T1' => 'Tanggal Masuk',
            'U1' => 'Tanggal Keluar',
            'V1' => 'Refrensi',
            'W1' => 'Status Supir',
            'X1' => 'Keterangan',
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        // Style header: bold, center, border, background
        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFD9E1F2'],
            ],
        ];
        $sheet->getStyle('A1:AB1')->applyFromArray($headerStyle);

        // Isi data
        $row = 2;
        $no = 1;
        foreach ($driverreport as $driver) {
            $sheet->setCellValue("A{$row}", $no);
            $sheet->setCellValue("B{$row}", $driver['d_nis'] ?? '');
            $sheet->setCellValue("C{$row}", $driver['d_name'] ?? '');
            $sheet->setCellValue("D{$row}", $driver['d_nickname'] ?? '');
            $sheet->setCellValue("E{$row}", $driver['d_pob'] ?? '');
            $sheet->setCellValue("F{$row}", $driver['d_dob'] ?? '');
            $sheet->setCellValue("G{$row}", $driver['d_age'] ?? '');
            $sheet->setCellValue("H{$row}", $driver['d_education'] ?? '');
            $sheet->setCellValue("I{$row}", $driver['d_married'] ?? '');
            $sheet->setCellValue("J{$row}", $driver['d_mobile'] ?? '');
            $sheet->setCellValue("K{$row}", $driver['d_address'] ?? '');
            $sheet->setCellValue("L{$row}", $driver['d_identityno'] ?? '');
            $sheet->setCellValue("M{$row}", $driver['d_identity_expdate'] ?? '');
            $sheet->setCellValue("N{$row}", $driver['d_licenseno'] ?? '');
            $sheet->setCellValue("O{$row}", date('d-m-Y', strtotime($driver['d_license_expdate'])) ?? '');
            $sheet->setCellValue("P{$row}", $driver['d_cardbpjs'] ?? '');
            $sheet->setCellValue("Q{$row}", $driver['d_accountno'] ?? '');
            $sheet->setCellValue("R{$row}", $driver['d_bank'] ?? '');
            $sheet->setCellValue("S{$row}", $driver['d_accountname'] ?? '');
            $sheet->setCellValue("T{$row}", date('d-m-Y', strtotime($driver['d_doj'])) ?? '');
            $sheet->setCellValue("U{$row}", date('d-m-Y', strtotime($driver['d_resigndate'])) ?? '');
            $sheet->setCellValue("V{$row}", $driver['d_ref'] ?? '');
            if($driver['d_is_active'] == 1) {
                $sheet->setcellValue("W{$row}", 'Aktif');
            } else {
                $sheet->setcellValue("W{$row}", 'Inactive');
            }
            $sheet->setCellValue("X{$row}", $driver['d_notes'] ?? '');
            $row++;
            $no++;
        }

        // Style data rows: border
        $dataStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];
        $lastRow = $row - 1;
        if ($lastRow >= 2) {
            $sheet->getStyle("A2:AB{$lastRow}")
                  ->applyFromArray($dataStyle);
        }

        // Auto-width kolom
        $columns = array_merge(range('A', 'Z'), ['AA', 'AB']);
        foreach ($columns as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Download file
        $filename = 'Driver_Report_' . date('Y-m-d') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function export_bap_excel()
    {
        $bapreport = $this->reportModel->bap_reports(
            $this->request->getGet('bap_from'),
            $this->request->getGet('bap_to'),
            $this->request->getGet('bap_name'),
            $this->request->getGet('driver_status'),
            $this->request->getGet('case_type'),
            $this->request->getGet('classification'),
            $this->request->getGet('payment')
        );

        if (empty($bapreport)) {
            session()->setFlashdata('warningmessage', 'Tidak ada data untuk diexport.');
            return redirect()->to('reports/bap');
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('BAP Report');

        // Header kolom
        $headers = [
            'A1' => 'No',
            'B1' => 'No BAP',
            'C1' => 'Tanggal',
            'D1' => 'Tanggal BAP',
            'E1' => 'Tanggal Kejadian',
            'F1' => 'Nama Supir',
            'G1' => 'Mobil',
            'H1' => 'Jenis Muatan',
            'I1' => 'Keberangakatan',
            'J1' => 'Lokasi Kejadian',
            'K1' => 'Kronologi Kasus',
            'L1' => 'Jenis Kasus',
            'M1' => 'Realisasi Klaim',
            'N1' => 'Potong Tagihan',
            'O1' => 'Cash',
            'P1' => 'Transfer',
            'Q1' => 'Klasifikasi Kasus',
            'R1' => 'Status Supir',
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        // Style header: bold, center, border, background
        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFD9E1F2'],
            ],
        ];
        $sheet->getStyle('A1:R1')->applyFromArray($headerStyle);

        // Isi data
        $row = 2;
        $no = 1;
        foreach ($bapreport as $bap) {
            $sheet->setCellValue("A{$row}", $no);
            $sheet->setCellValue("B{$row}", $bap['b_code'] ?? '');
            $sheet->setCellValue("C{$row}", date('d-m-Y', strtotime($bap['b_created_date'])) ?? '');
            if(empty($bap['b_tanggal']) || $bap['b_tanggal'] == '0000-00-00' || $bap['b_tanggal'] == '0000-00-00 00:00:00') {
                $sheet->setCellValue("D{$row}", '00-00-0000');
            }
            else {
                $sheet->setCellValue("D{$row}", $bap['b_tanggal']);
            }
            $sheet->setCellValue("E{$row}", date('d-m-Y', strtotime($bap['b_tanggal_kejadian'])) ?? '');
            $sheet->setCellValue("F{$row}", $bap['b_supir'] ?? '');
            $sheet->setCellValue("G{$row}", $bap['b_nopol'] ?? '');
            $sheet->setCellValue("H{$row}", $bap['b_muatan'] ?? '');
            $sheet->setCellValue("I{$row}", $bap['b_keberangkatan'] ?? '');
            $sheet->setCellValue("J{$row}", $bap['b_lokasi_kejadian'] ?? '');
            $sheet->setCellValue("K{$row}", $bap['b_kondisi_barang'] ?? '');
            $sheet->setCellValue("L{$row}", $bap['b_jenis_kasus'] ?? '');
            $parseValue = preg_replace('/[^0-9]/', '', (string)($bap['b_realisasi_klaim'] ?? ''));
            $sheet->setCellValue("M{$row}", ($parseValue === '') ? 0 : (int)$parseValue);
            $sheet->setCellValue("N{$row}", $bap['b_potong_tagihan'] ?? '');
            $parseValue = preg_replace('/[^0-9]/', '', (string)($bap['b_cash'] ?? ''));
            $sheet->setCellValue("O{$row}", ($parseValue === '') ? 0 : (int)($parseValue));
            $parseValue = preg_replace('/[^0-9]/', '', (string)($bap['b_transfer'] ?? ''));
            $sheet->setCellValue("P{$row}", ($parseValue === '') ? 0 : (int)($parseValue));
            $sheet->setCellValue("Q{$row}", $bap['b_klasifikasi'] ?? '');
            if ($bap['d_is_active'] == '1') {
                $sheet->setCellValue("R{$row}", 'Aktif');
            } else {
                $sheet->setCellValue("R{$row}", 'Inactive');
            }
            $row++;
            $no++;
        }

        // Style data rows: border
        $dataStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];
        $lastRow = $row - 1;
        if ($lastRow >= 2) {
            $sheet->getStyle("A2:R{$lastRow}")
                  ->getNumberFormat()
                  ->setFormatCode('RP#,##0')
                  ->applyFromArray($dataStyle);
        }

        // Auto-width kolom
        foreach (range('A', 'R') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Download file
        $filename = 'Bap_Report_' . date('Y-m-d') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
    
    public function export_laka_excel()
    {
        $lakareport = $this->reportModel->laka_reports(
            $this->request->getGet('laka_from') ?? null,
            $this->request->getGet('laka_to') ?? null,
            $this->request->getGet('driver_name') ?? 'all driver',
            $this->request->getGet('nopol') ?? null,
            $this->request->getGet('classification') ?? '',
        );

        if (empty($lakareport)) {
            session()->setFlashdata('warningmessage', 'Tidak ada data untuk diexport.');
            return redirect()->to('reports/laka');
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Lakalantas Report');

        // Header kolom
        $headers = [
            'A1' => 'No',
            'B1' => 'Tanggal Kejadian',
            'C1' => 'Lokasi Kejadian',
            'D1' => 'Nama Supir',
            'E1' => 'No Polisi',
            'F1' => 'Tahun Kendaraan',
            'G1' => 'Klasifikasi Kasus',
            'H1' => 'Riwayat Kejadian',
            'I1' => 'Daftar Kerusakan',
            'J1' => 'Lokasi Perbaikan',
            'K1' => 'Biaya Perbaikan',
            'L1' => 'Biaya Lain-lain',
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        // Style header: bold, center, border, background
        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFD9E1F2'],
            ],
        ];
        $sheet->getStyle('A1:L1')->applyFromArray($headerStyle);

        // Isi data
        $row = 2;
        $no = 1;
        foreach ($lakareport as $laka) {
            $sheet->setCellValue("A{$row}", $no);
            $sheet->setCellValue("B{$row}", date('d-m-Y', strtotime($laka['b_tanggal_kejadian'])) ?? '');
            $sheet->setCellValue("C{$row}", $laka['b_lokasi_kejadian'] ?? '');
            $sheet->setCellValue("D{$row}", $laka['b_supir'] ?? '');
            $sheet->setCellValue("E{$row}", $laka['b_nopol'] ?? '');
            $sheet->setCellValue("F{$row}", $laka['v_reg_exp_date'] ?? '');
            $sheet->setCellValue("G{$row}", $laka['b_klasifikasi'] ?? '');
            $sheet->setCellValue("H{$row}", $laka['b_kondisi_barang'] ?? '');
            $sheet->setCellValue("I{$row}", $laka['b_daftar_kerusakan'] ?? '');
            $sheet->setCellValue("J{$row}", $laka['b_lokasi_perbaikan'] ?? '');
            $parseValue = preg_replace('/[^0-9]/', '', (string)($laka['b_biaya_perbaikan'] ?? ''));
            $sheet->setCellValue("K{$row}", ($parseValue === '') ? 0 : (int)($parseValue));
            $parseValue = preg_replace('/[^0-9]/', '', (string)($laka['b_biaya_lain'] ?? ''));
            $sheet->setCellValue("L{$row}", ($parseValue === '') ? 0 : (int)($parseValue));
            $row++;
            $no++;
        }

        // Style data rows: border
        $dataStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];
        $lastRow = $row - 1;
        if ($lastRow >= 2) {
            $sheet->getStyle("A2:L{$lastRow}")
            ->applyFromArray($dataStyle);

            // Format Rp hanya untuk kolom K (Biaya Perbaikan) & L (Biaya Lain-lain)
            $sheet->getStyle("K2:L{$lastRow}")
                  ->getNumberFormat()
                  ->setFormatCode('RP#,##0');

            // Kolom F (Tahun Kendaraan) tetap General
            $sheet->getStyle("F2:F{$lastRow}")
                  ->getNumberFormat()
                  ->setFormatCode(NumberFormat::FORMAT_GENERAL);
        }
        
        
        // Auto-width kolom
        foreach (range('A', 'L') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Download file
        $filename = 'Lakalantas_Report_' . date('Y-m-d') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function export_survey_excel()
    {
        $surveyreport = $this->reportModel->survey_reports(
            $this->request->getGet('survey_from') ?? null,
            $this->request->getGet('survey_to') ?? null,
            $this->request->getGet('survey_status') ?? 'all survey',
            $this->request->getGet('driver_status') ?? 'all driver',
        );

        if (empty($surveyreport)) {
            session()->setFlashdata('warningmessage', 'Tidak ada data untuk diexport.');
            return redirect()->to('reports/survey');
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Survey Report');

        // Header kolom
        $headers = [
            'A1' => 'No',
            'B1' => 'Code Survey',
            'C1' => 'Tanggal Survey',
            'D1' => 'Petugas Survey',
            'E1' => 'NIS',
            'F1' => 'Nama Supir',
            'G1' => 'Tanggal Masuk',
            'H1' => 'Refrensi',
            'I1' => 'Status Pernikahan',
            'J1' => 'Alamat Lengkap',
            'K1' => 'Nama Istri',
            'L1' => 'No Telp Istri',
            'M1' => 'Nama Ayah',
            'N1' => 'Nama Ibu',
            'O1' => 'Nama Tetangga',
            'P1' => 'Nama Saudara / Kerabat',
            'Q1' => 'Alamat Saudara',
            'R1' => 'Kondisi Rumah',
            'S1' => 'Status rumah',
            'T1' => 'Lama Menetap di Alamat ini',
            'U1' => 'Jumlah Penghuni Rumah',
            'V1' => 'Pekerjaan Istri',
            'W1' => 'Kendaraan Yang Dimiliki',
            'X1' => 'Jumlah Tanggungan',
            'Y1' => 'Keterangan',
            'Z1' => 'Petugas Input Survey',
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        // Style header: bold, center, border, background
        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFD9E1F2'],
            ],
        ];
        $sheet->getStyle('A1:Z1')->applyFromArray($headerStyle);

        // Isi data
        $row = 2;
        $no = 1;
        foreach ($surveyreport as $survey) {
            $sheet->setCellValue("A{$row}", $no);
            $sheet->setCellValue("B{$row}", $survey['s_code'] ?? '');
            $sheet->setCellValue("C{$row}", date('d-m-Y', strtotime($survey['s_tanggal'])) ?? '');
            $sheet->setCellValue("D{$row}", $survey['s_petugas'] ?? '');
            $sheet->setCellValue("E{$row}", $survey['s_nis'] ?? '');
            $sheet->setCellValue("F{$row}", $survey['s_supir'] ?? '');
            $sheet->setCellValue("G{$row}", date('d-m-Y', strtotime($survey['s_tanggal_masuk'])) ?? '');
            $sheet->setCellValue("H{$row}", $survey['s_refrensi'] ?? '');
            $sheet->setCellValue("I{$row}", $survey['s_nikah'] ?? '');
            $sheet->setCellValue("J{$row}", $survey['s_alamat'] ?? '');
            $sheet->setCellValue("K{$row}", $survey['s_istri'] ?? '');
            $sheet->setCellValue("L{$row}", $survey['s_telepon_istri'] ?? '');
            $sheet->setCellValue("M{$row}", $survey['s_bapak'] ?? '');
            $sheet->setCellValue("N{$row}", $survey['s_ibu'] ?? '');
            $sheet->setCellValue("O{$row}", $survey['s_tetangga'] ?? '');
            $sheet->setCellValue("P{$row}", $survey['s_saudara'] ?? '');
            $sheet->setCellValue("Q{$row}", $survey['s_alamat_saudara'] ?? '');
            $sheet->setCellValue("R{$row}", $survey['s_kondisi_rumah'] ?? '');
            $sheet->setCellValue("S{$row}", $survey['s_status_rumah'] ?? '');
            $sheet->setCellValue("T{$row}", $survey['s_menetap'] ?? '');
            $sheet->setCellValue("U{$row}", $survey['s_penghuni'] ?? '');
            $sheet->setCellValue("V{$row}", $survey['s_pekerjaan_istri'] ?? '');
            $sheet->setCellValue("W{$row}", $survey['s_kendaraan'] ?? '');
            $sheet->setCellValue("X{$row}", $survey['s_tanggungan'] ?? '');
            $sheet->setCellValue("Y{$row}", $survey['s_keterangan'] ?? '');
            $sheet->setCellValue("Z{$row}", $survey['creator_name'] ?? $survey['s_created_by'] ?? '');
            $row++;
            $no++;
        }

        // Style data rows: border
        $dataStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];
        $lastRow = $row - 1;
        if ($lastRow >= 2) {
            $sheet->getStyle("A2:Z{$lastRow}")
            ->applyFromArray($dataStyle);
        }
        
        
        // Auto-width kolom
        foreach (range('A', 'Z') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Download file
        $filename = 'Survey_Report_' . date('Y-m-d') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function export_training_excel()
    {
        $trainingreport = $this->reportModel->training_reports(
            $this->request->getGet('training_from') ?? null,
            $this->request->getGet('training_to') ?? null,
            $this->request->getGet('training_status') ?? 'all training',
            $this->request->getGet('driver_status') ?? 'all driver',
            $this->request->getGet('training_count') ?? '',
        );

        if (empty($trainingreport)) {
            session()->setFlashdata('warningmessage', 'Tidak ada data untuk diexport.');
            return redirect()->to('reports/training');
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Training Report');

        // Header kolom
        $headers = [
            'A1' => 'No',
            'B1' => 'Kode Training',
            'C1' => 'Tanggal Training',
            'D1' => 'NIS',
            'E1' => 'Nama Supir',
            'F1' => 'Kategori',
            'G1' => 'Tema/Modul Training',
            'H1' => 'Pemateri',
            'I1' => 'Lokasi',
            'J1' => 'Keterangan',
            'K1' => 'Petugas',
            'L1' => 'Tanggal Penginputan',
            'M1' => 'Riwayat Terakhir Perubahan',
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        // Style header: bold, center, border, background
        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFD9E1F2'],
            ],
        ];
        $sheet->getStyle('A1:M1')->applyFromArray($headerStyle);

        // Isi data
        $row = 2;
        $no = 1;
        foreach ($trainingreport as $training) {
            $sheet->setCellValue("A{$row}", $no);
            $sheet->setCellValue("B{$row}", $training['tr_code'] ?? '');
            $sheet->setCellValue("C{$row}", date('d-m-Y', strtotime($training['tr_tanggal'])) ?? '');
            $sheet->setCellValue("D{$row}", $training['tr_nis'] ?? '');
            $sheet->setCellValue("E{$row}", $training['tr_supir'] ?? '');
            $sheet->setCellValue("F{$row}", $training['tr_kategori'] ?? '');
            $sheet->setCellValue("G{$row}", $training['tr_tema'] ?? '');
            $sheet->setCellValue("H{$row}", $training['tr_pemateri'] ?? '');
            $sheet->setCellValue("I{$row}", $training['tr_lokasi'] ?? '');
            $sheet->setCellValue("J{$row}", $training['tr_keterangan'] ?? '');
            $sheet->setCellValue("K{$row}", $training['creator_name']);
            $sheet->setCellValue("L{$row}", $training['tr_created_date'] ?? '');
            $sheet->setCellValue("M{$row}", strtotime($training['tr_modified_date']) ?? '');
            $row++;
            $no++;
        }

        // Style data rows: border
        $dataStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];
        $lastRow = $row - 1;
        if ($lastRow >= 2) {
            $sheet->getStyle("A2:M{$lastRow}")
            ->applyFromArray($dataStyle);
        }
        
        
        // Auto-width kolom
        foreach (range('A', 'M') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Download file
        $filename = 'Training_Report_' . date('d-m-Y') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function export_vehicle_excel()
    {
        $vehiclereport = $this->reportModel->vehicle_reports(
            $this->request->getGet('vehicle_from'),
            $this->request->getGet('vehicle_to'),
            $this->request->getGet('vehicle_name'),
            $this->request->getGet('vehicle_owner'),
            $this->request->getGet('vehicle_type'),
            $this->request->getGet('report_type') ?? 'all',
            $this->request->getGet('location_kir')
        );

        if (empty($vehiclereport)) {
            session()->setFlashdata('warningmessage', 'Tidak ada data untuk diexport.');
            return redirect()->to('reports/vehicle');
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Vehicle Report');

        // Header kolom
        $headers = [
            'A1' => 'No',
            'B1' => 'Tanggal Input',
            'C1' => 'No Polisi',
            'D1' => 'Pemilik',
            'E1' => 'Jenis Kendaraan',
            'F1' => 'No Rangka',
            'G1' => 'No Mesin',
            'H1' => 'No Uji',
            'I1' => 'Berlaku STNK',
            'J1' => 'Berlaku Plat',
            'K1' => 'Berlaku KIR',
            'L1' => 'Tanggal Proses KIR',
            'M1' => 'Lokasi KIR',
            'N1' => 'Keterangan',
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        // Style header: bold, center, border, background
        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFD9E1F2'],
            ],
        ];
        $sheet->getStyle('A1:N1')->applyFromArray($headerStyle);

        // Isi data
        $row = 2;
        $no = 1;
        foreach ($vehiclereport as $vehicle) {
            $sheet->setCellValue("A{$row}", $no);
            $sheet->setCellValue("B{$row}", date('d-m-Y', strtotime($vehicle['v_created_date'])) ?? '');
            $sheet->setCellValue("C{$row}", $vehicle['v_registration_no'] ?? '');
            $sheet->setCellValue("D{$row}", $vehicle['v_legal'] ?? '');
            $sheet->setCellValue("E{$row}", $vehicle['v_name'] ?? '');
            $sheet->setCellValue("F{$row}", $vehicle['v_chassis_no'] ?? '');
            $sheet->setCellValue("G{$row}", $vehicle['v_engine_no'] ?? '');
            $sheet->setCellValue("H{$row}", $vehicle['v_uji_no'] ?? '');
            $sheet->setCellValue("I{$row}", date('d-m-Y', strtotime($vehicle['v_stnk_expdate'])) ?? '');
            $sheet->setCellValue("J{$row}", date('d-m-Y', strtotime($vehicle['v_plat_expdate'])) ?? '');
            $sheet->setCellValue("K{$row}", date('d-m-Y', strtotime($vehicle['v_kir_expdate'])) ?? '');
            $sheet->setCellValue("L{$row}", date('d-m-Y', strtotime($vehicle['v_kir_process_date'])) ?? '');
            $sheet->setCellValue("M{$row}", $vehicle['v_lokasi_kir'] ?? '');
            $sheet->setCellValue("N{$row}", $vehicle['v_notes'] ?? '');
            $row++;
            $no++;
        }

        // Style data rows: border
        $dataStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];
        $lastRow = $row - 1;
        if ($lastRow >= 2) {
            $sheet->getStyle("A2:N{$lastRow}")->applyFromArray($dataStyle);
        }

        // Auto-width kolom
        foreach (range('A', 'N') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Download file
        $filename = 'Vehicle_Report_' . date('Y-m-d') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function export_inventory_excel()
    {
        $inventoryreport = $this->reportModel->inventory_reports(
            $this->request->getGet('invent_from'),
            $this->request->getGet('invent_to'),
            $this->request->getGet('check_status'),
            $this->request->getGet('nopol'),
            $this->request->getGet('invent_type'),
            $this->request->getGet('vech_type'),
        );

        if (empty($inventoryreport)) {
            session()->setFlashdata('warningmessage', 'Tidak ada data untuk diexport.');
            return redirect()->to('reports/inventory');
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Inventory Report');

        // Header kolom
        $headers = [
            'A1' => 'No',
            'B1' => 'Tanggal Cek Inventaris',
            'C1' => 'Nopol',
            'D1' => 'Jenis Mobil',
            'E1' => 'Tahun Kendaraan',
            'F1' => 'STNK',
            'G1' => 'KIR',
            'H1' => 'Keadaan Kabin',
            'I1' => 'Keadaan Dongkrak',
            'J1' => 'Keadaan Kunci Roda',
            'K1' => 'Keadaan Stang/Stick Kunci Roda',
            'L1' => 'Keadaan Spanner',
            'M1' => 'Keadaan Ban Serep',
            'N1' => 'Keadaan Gantungan Ban Serep',
            'O1' => 'Keadaan RAM (Kanan/Kiri)',
            'P1' => 'Keadaan Ram (Depan/Belakang)',
            'Q1' => 'Keadaan Karpet Depan (R/L)',
            'R1' => 'Keadaan Karpet Belakang (R/L)',
            'S1' => 'Keadaan Tali Tambang',
            'T1' => 'Keadaan Terpal Tarpolin',
            'U1' => 'Keadaan Terpal Plastik',
            'V1' => 'Keadaan Terpal Lidah',
            'W1' => 'Keadaan Badong',
            'X1' => 'Keadaan Pipa Kojong',
            'Y1' => 'Keadaan Jumlah Pipa Kojong',
            'Z1' => 'Tipe Inventaris',
            'AA1' => 'Status Inventaris',
            'AB1' => 'Status Pengecekan',
            'AC1' => 'Keterangan',
            'AD1' => 'Diperbarui Oleh',
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        // Style header: bold, center, border, background
        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFD9E1F2'],
            ],
        ];
        $sheet->getStyle('A1:AD1')->applyFromArray($headerStyle);

        // Isi data
        $row = 2;
        $no = 1;
        foreach ($inventoryreport as $inventory) {
            $sheet->setCellValue("A{$row}", $no);
            $sheet->setCellValue("B{$row}", date('d-m-Y', strtotime($inventory['iv_modified_date'])) ?? '');
            $sheet->setCellValue("C{$row}", $inventory['iv_nopol'] ?? '');
            $sheet->setCellValue("D{$row}", $inventory['iv_jenis'] ?? '');
            $sheet->setCellValue("E{$row}", $inventory['iv_tahun'] ?? '');
            $sheet->setCellValue("F{$row}", $inventory['iv_stnk'] ?? '');
            $sheet->setCellValue("G{$row}", $inventory['iv_kir'] ?? '');
            $sheet->setCellValue("H{$row}", $inventory['iv_kabin'] ?? '');
            $sheet->setCellValue("I{$row}", $inventory['iv_dongkrak'] ?? '');
            $sheet->setCellValue("J{$row}", $inventory['iv_kunci'] ?? '');
            $sheet->setCellValue("K{$row}", $inventory['iv_stang'] ?? '');
            $sheet->setCellValue("L{$row}", $inventory['iv_spanner'] ?? '');
            $sheet->setCellValue("M{$row}", $inventory['iv_serep'] ?? '');
            $sheet->setCellValue("O{$row}", $inventory['iv_gantungan'] ?? '');
            $sheet->setCellValue("P{$row}", $inventory['iv_ramkk'] ?? '');
            $sheet->setCellValue("Q{$row}", $inventory['iv_ramdb'] ?? '');
            $sheet->setCellValue("R{$row}", $inventory['iv_karpetd'] ?? '');
            $sheet->setCellValue("S{$row}", $inventory['iv_karpetb'] ?? '');
            $sheet->setCellValue("T{$row}", $inventory['iv_tambang'] ?? '');
            $sheet->setCellValue("U{$row}", $inventory['iv_tarpolin'] ?? '');
            $sheet->setCellValue("V{$row}", $inventory['iv_plastik'] ?? '');
            $sheet->setCellValue("W{$row}", $inventory['iv_lidah'] ?? '');
            $sheet->setCellValue("X{$row}", $inventory['iv_badong'] ?? '');
            $sheet->setCellValue("Y{$row}", $inventory['iv_kojong'] ?? '');
            $sheet->setCellValue("Z{$row}", $inventory['iv_jumlah'] ?? '');
            if ($inventory['iv_is_active'] == '1') {
                $sheet->setCellValue("AA{$row}", 'Sudah Diperiksa');
            } else {
                $sheet->setCellValue("AA{$row}", 'Belum Diperiksa');
            }
            if ($inventory['iv_is_active'] == '1') {
                $sheet->setCellValue("AB{$row}", 'Sudah Pengecekan');
            } else {
                $sheet->setCellValue("AB{$row}", 'Belum Pengecekan');
            }
            $sheet->setCellValue("AC{$row}", ($inventory['iv_keterangan']) ?? '');
            $sheet->setCellValue("AD{$row}", ($inventory['creator_name']) ? $inventory['creator_name'] : $inventory['iv_created_by']);
            $row++;
            $no++;
        }

        // Style data rows: border
        $dataStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];
        $lastRow = $row - 1;
        if ($lastRow >= 2) {
            $sheet->getStyle("A2:AD{$lastRow}")->applyFromArray($dataStyle);
        }

        // Auto-width kolom
        $column = array_merge(range('A', 'Z'), ['AA', 'AD']);
        foreach ($column as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Download file
        $filename = 'Inventory_Report_' . date('Y-m-d') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function export_handover_excel()
    {
        $handoverreport = $this->reportModel->handover_reports(
            $this->request->getGet('hand_from'),
            $this->request->getGet('hand_to'),
            $this->request->getGet('check_status'),
            $this->request->getGet('nopol'),
            $this->request->getGet('driver')
        );

        if (empty($handoverreport)) {
            session()->setFlashdata('warningmessage', 'Tidak ada data untuk diexport.');
            return redirect()->to('reports/handover');
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Serah Terima Report');

        // Header kolom
        $headers = [
            'A1' => 'No',
            'B1' => 'No Serah Terima',
            'C1' => 'Tanggal Serah Terima',
            'D1' => 'Lokasi',
            'E1' => 'Nomor Polisi',
            'F1' => 'Supir Lama',
            'G1' => 'Supir Baru',
            'H1' => 'Jenis Mobil',
            'I1' => 'Kilometer Serah Terima',
            'J1' => 'Kilometer Solar Serah Terima',
            'K1' => 'Kabin Mobil',
            'L1' => 'Kabel Body',
            'M1' => 'Wiper',
            'N1' => 'Spion Bulat R/L',
            'O1' => 'Kondisi Bak',
            'P1' => 'Pintu Kupu-Kupu',
            'Q1' => 'Lampu Besar Depan',
            'R1' => 'Lampu Rem R/L',
            'S1' => 'Lampu Sein Depan R/L',
            'T1' => 'Lampu Sein Belakang R/L',
            'U1' => 'Tangki Solar 1',
            'V1' => 'Tangki Solar 2',
            'W1' => 'Ban Depan Kanan',
            'X1' => 'Ban Depan Kiri',
            'Y1' => 'Ban Belakang Kanan Luar',
            'Z1' => 'Ban Belakang Kiri Luar',
            'AA1' => 'Ban Belakang Kanan Dalam',
            'AB1' => 'Ban Belakang Kiri Dalam',
            'AC1' => 'Ban Tarik Kanan Luar',
            'AD1' => 'Ban Tarik Kiri Luar',
            'AE1' => 'Ban Tarik Kanan Dalam',
            'AF1' => 'Ban Tarik Kiri Dalam',
            'AG1' => 'Velg Depan Kanan',
            'AH1' => 'Velg Depan Kiri',
            'AI1' => 'Velg Belakang Kanan Luar',
            'AJ1' => 'Velg Belakang Kiri Luar',
            'AK1' => 'Velg Belakang Kanan Dalam',
            'AL1' => 'Velg Belakang Kiri Dalam',
            'AM1' => 'Status Serah Terima',
            'AN1' => 'Keterangan',
            'AO1' => 'Petugas Serah Terima',
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        // Style header: bold, center, border, background
        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFD9E1F2'],
            ],
        ];
        $sheet->getStyle('A1:AO1')->applyFromArray($headerStyle);

        // Isi data
        $row = 2;
        $no = 1;
        foreach ($handoverreport as $handover) {
            $sheet->setCellValue("A{$row}", $no);
            $sheet->setCellValue("B{$row}", $handover['ho_code']);
            $sheet->setCellValue("C{$row}", date('d-m-Y', strtotime($handover['ho_tanggal'])) ?? '');
            $sheet->setCellValue("D{$row}", $handover['ho_lokasi'] ?? '');
            $sheet->setCellValue("E{$row}", $handover['ho_nopol'] ?? '');
            $sheet->setCellValue("F{$row}", $handover['ho_supirlama'] ?? '');
            $sheet->setCellValue("G{$row}", $handover['ho_supirbaru'] ?? '');
            $sheet->setCellValue("H{$row}", $handover['ho_jenis'] ?? '');
            $sheet->setCellValue("I{$row}", $handover['ho_km'] ?? '');
            $sheet->setCellValue("J{$row}", $handover['ho_solar'] ?? '');
            $sheet->setCellValue("K{$row}", $handover['ho_kabin'] ?? '');
            $sheet->setCellValue("L{$row}", $handover['ho_kabel'] ?? '');
            $sheet->setCellValue("M{$row}", $handover['ho_wiper'] ?? '');
            $sheet->setCellValue("N{$row}", $handover['ho_spion'] ?? '');
            $sheet->setCellValue("O{$row}", $handover['ho_bak'] ?? '');
            $sheet->setCellValue("P{$row}", $handover['ho_pintu'] ?? '');
            $sheet->setCellValue("Q{$row}", $handover['ho_lampubesar'] ?? '');
            $sheet->setCellValue("R{$row}", $handover['ho_lampurem'] ?? '');
            $sheet->setCellValue("S{$row}", $handover['ho_seindpn'] ?? '');
            $sheet->setCellValue("T{$row}", $handover['ho_seinblk'] ?? '');
            $sheet->setCellValue("U{$row}", $handover['ho_tangki1'] ?? '');
            $sheet->setCellValue("V{$row}", $handover['ho_tangki2'] ?? '');
            $sheet->setCellValue("W{$row}", $handover['ho_bandpnkn'] . '-' .  $handover['ho_merkbankn'] ?? '');
            $sheet->setCellValue("X{$row}", $handover['ho_bandpnkr'] . '-' .  $handover['ho_merkbankr'] ?? '');
            $sheet->setCellValue("Y{$row}", $handover['ho_banblkknlr'] . '-' .  $handover['ho_merkbanknlr'] ?? '' );
            $sheet->setCellValue("Z{$row}", $handover['ho_banblkkrlr'] .  '-' .  $handover['ho_merkbankrlr'] ?? '');
            $sheet->setCellValue("AA{$row}", $handover['ho_banblkkndlm'] .  '-' .  $handover['ho_merkbankndlm'] ?? '');
            $sheet->setCellValue("AB{$row}", $handover['ho_banblkkrdlm'] .  '-' .  $handover['ho_merkbankrdlm'] ?? '');
            $sheet->setCellValue("AC{$row}", $handover['ho_bantrkknlr'] .  '-' .  $handover['ho_merkbantrkknlr'] ?? '');
            $sheet->setCellValue("AD{$row}", $handover['ho_bantrkkrlr'] .  '-' .  $handover['ho_merkbantrkkrlr'] ?? '');
            $sheet->setCellValue("AE{$row}", $handover['ho_bantrkkndlm'] .  '-' .  $handover['ho_merkbantrkkndlm'] ?? '');
            $sheet->setCellValue("AF{$row}", $handover['ho_bantrkkrdlm'] .  '-' .  $handover['ho_merkbantrkkrdlm'] ?? '');
            $sheet->setCellValue("AG{$row}", $handover['ho_velgdpnkn'] .  '-' .  $handover['ho_merkukuranvelgdpnkn'] ?? '');
            $sheet->setCellValue("AH{$row}", $handover['ho_velgdpnkr'] .  '-' .  $handover['ho_merkukuranvelgdpnkr'] ?? '');
            $sheet->setCellValue("AI{$row}", $handover['ho_velgblkknlr'] .  '-' .  $handover['ho_merkukuranvelgblknlr'] ?? '');
            $sheet->setCellValue("AJ{$row}", $handover['ho_velgblkkrlr'] .  '-' .  $handover['ho_merkukuranvelgblkkrlr'] ?? '');
            $sheet->setCellValue("AK{$row}", $handover['ho_velgblkkndlm'] .  '-' .  $handover['ho_merkukuranvelgblkndlm'] ?? '');
            $sheet->setCellValue("AL{$row}", $handover['ho_velgblkkrdlm'] .  '-' .  $handover['ho_merkukuranvelgblkkrdlm'] ?? '');
            $sheet->setCellValue("AM{$row}", $handover['ho_status'] ?? '');
            $sheet->setCellValue("AN{$row}", $handover['ho_keterangan'] ?? '');
            $sheet->setCellValue("AO{$row}", $handover['nama_petugas'] ?? '');
            $row++;
            $no++;
        }

        // Style data rows: border
        $dataStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];
        $lastRow = $row - 1;
        if ($lastRow >= 2) {
            $sheet->getStyle("A2:AO{$lastRow}")->applyFromArray($dataStyle);
        }

        // Auto-width kolom
        $column = array_merge(range('A', 'Z'), ['AA', 'AO']);
        foreach ($column as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Download file
        $filename = 'Handover_Report_' . date('Y-m-d') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
