<?php namespace App\Models;

use CodeIgniter\Model;

class DriversModel extends Model
{
    protected $table = 'drivers';
    protected $primaryKey = 'd_id';
    protected $allowedFields = [
        'd_nis', 'd_name', 'd_nickname', 'd_pob', 'd_dob', 'd_age', 'd_married', 'd_education',
        'd_mobile', 'd_address', 'd_province', 'd_city', 'd_subdistrict', 'd_village',
        'd_identityno', 'd_identity_expdate', 'd_licenseno', 'd_license_expdate', 'd_cardbpjs',
        'd_accountno', 'd_bank', 'd_accountname', 'd_experience', 'd_total_exp', 'd_infoexp',
        'd_expstatus', 'd_ref', 'd_doj', 'd_notes', 'd_resigndate', 'd_is_active',
        'd_docstatus', 'd_docremarks', 'd_photo', 'd_pdf_document', 'd_created_by', 'd_modified_date', 'd_notes_blacklist'
    ];

    public function get_driver_by_nis($d_nis)
    {
        return $this->where('d_nis', $d_nis)->get()->getResultArray();
    }

    /**
     * Fetch data from the Indonesian region API (emsifa)
     */
    private function fetchData($endpoint)
    {
        $url = "https://www.emsifa.com/api-wilayah-indonesia/api/" . $endpoint;
        
        try {
            $client = \Config\Services::curlrequest();
            $response = $client->get($url, [
                'timeout' => 0,
                'verify'  => false,
            ]);
            
            if ($response->getStatusCode() === 200) {
                return json_decode($response->getBody(), true);
            }
        } catch (\Exception $e) {
            log_message('error', 'Failed to fetch region data: ' . $e->getMessage());
        }
        
        return [];
    }

    /**
     * Get all provinces from the API
     */
    public function getProvinces()
    {
        return $this->fetchData("provinces.json");
    }

    /**
     * Get regencies by province ID from the API
     */
    public function getRegencies($province_id)
    {
        return $this->fetchData("regencies/{$province_id}.json");
    }

    /**
     * Get districts by regency ID from the API
     */
    public function getDistricts($regency_id)
    {
        return $this->fetchData("districts/{$regency_id}.json");
    }

    /**
     * Get villages by district ID from the API
     */
    public function getVillages($district_id)
    {
        return $this->fetchData("villages/{$district_id}.json");
    }


    public function get_last_nis()
    {
        $result = $this->select('d_nis')
                      ->orderBy('d_nis', 'DESC')
                      ->first();
        return $result ? $result['d_nis'] : null;
    }

    public function getProvinceName($province_id)
    {
        $data = $this->fetchData("provinces.json");
        if ($data) {
            foreach ($data as $province) {
                if ($province['id'] == $province_id) {
                    return $province['name'];
                }
            }
        }
        return "Provinsi Tidak Ada";
    }

    public function generateDriverCode($last_nis)
    {
        $data = $this->last_nis();
        $last_code = $data['d_nis'];
        $last_number = (int)substr($last_code, 3);
        $new_number = $last_number + 1;
        $new_code = '002' . str_pad($new_number, 4, '0', STR_PAD_LEFT);
        return $new_code;
    }

    public function getRegencyName($province_id, $regency_id)
    {
        $data = $this->fetchData("regencies/{$province_id}.json");
        if ($data) {
            foreach ($data as $regency) {
                if ((string)$regency['id'] === (string)$regency_id) {
                    return $regency['name'];
                }
            }
        }
        log_message('error', 'Kota Tidak Ditemukan untuk ID: ' . $regency_id);
        return "Kota Tidak Ada";
    }

    public function getDistrictName($regency_id, $district_id)
    {
        $data = $this->fetchData("districts/{$regency_id}.json");
        if ($data) {
            foreach ($data as $district) {
                if ((string)$district['id'] === (string)$district_id) {
                    return $district['name'];
                }
            }
        }
        log_message('error', 'Kecamatan Tidak Ditemukan untuk ID: ' . $district_id);
        return "Kecamatan Tidak Ada";
    }

    public function getVillageName($district_id, $village_id)
    {
        $data = $this->fetchData("villages/{$district_id}.json");
        if ($data) {
            foreach ($data as $village) {
                if ((string)$village['id'] === (string)$village_id) {
                    return $village['name'];
                }
            }
        }
        log_message('error', 'Desa Tidak Ditemukan untuk ID: ' . $village_id);
        return "Desa Tidak Ada";
    }

    public function getall_drivers()
    {
        return $this->orderBy('d_id', 'DESC')->findAll();
    }
    
    public function getDriversById($d_id)
    {
        return $this->db->table('drivers')
                        ->where('d_id', $d_id)
                        ->get()
                        ->getRowArray();
    }

    public function get_driverdetails($d_id)
    {
        return $this->select('drivers.*, users.u_name as creator_name')
                   ->join('users', 'drivers.d_created_by = users.u_id', 'left')
                   ->where('d_id', $d_id)
                   ->first();
    }

    public function add_drivers($data)
    {
        return $this->db->table('drivers')->insert($data);
    }

    public function edit_driver($d_id, $data)
    {
        return $this->db->table('drivers')->where('d_id', $d_id)->update($data);
    }

    public function drivers_delete($d_id)
    {
        $driver = $this->find($d_id);
        if (!$driver) {
            return false;
        }

        if ($this->useSoftDeletes) {
            return $this->where('d_id', $d_id)->delete();
        } else {
            return $this->where('d_id', $d_id)->delete();
        }
    }

    public function deleteOldPhoto($d_id)
    {
        $driver = $this->find($d_id);
        if (!$driver) {
            return false;
        }

        if ($driver['']) {
            $filePath = FCPATH . 'writable/uploads/drivers/' . $driver['d_photo'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $return = true;
        } else {
            $return = false;
        }

        return $return;   
    }

    public function deleteOldPdf($d_id)
    {
        $driver = $this->find($d_id);
        if (!$driver) {
            return false;
        }

        if ($driver['d_pdf_document']) {
            $filePath = FCPATH . 'writable/uploads/document/' . $driver['d_pdf_document'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $return = true;
        } else {
            $return = false;
        }

        return $return;   
    }

    public function insert_driversblacklist($data)
    {
        return $this->db->table('drivers')->insert($data);
    }

    public function get_driver_inactive_blacklist()
    {
        return $this->db->table('drivers')
                       ->where('d_is_active', '0')
                       ->orWhere('d_is_active', '2')
                       ->get()
                       ->getResultArray();
    }

    public function edit_driverblacklist($data)
    {
        return $this->update($data['d_id'], $data);
    }

    public function get_last_bcode()
    {
        $result = $this->db->table('baps')
                           ->select('b_code')
                           ->orderBy('b_id', 'DESC')
                           ->get()
                           ->getRowArray();

        return $result['b_code'] ?? null;
    }

    public function getBap()
    {
        return $this->db->table('baps')->get()->getResultArray();
    }

    public function get_bap()
    {
        return $this->db->table('baps')
                       ->orderBy('b_id', 'DESC')
                       ->get()
                       ->getResultArray();
    }

    public function get_bapdetails($b_id)
    {
        return $this->db->table('baps')
                       ->select('baps.*, users.u_name as creator_name')
                       ->join('users', 'baps.b_created_by = users.u_id', 'left')
                       ->where('b_id', $b_id)
                       ->get()
                       ->getResultArray();
    }

    public function get_baps_by_nis($d_nis)
    {
        return $this->db->table('baps')
                       ->where('b_nis', $d_nis)
                       ->whereIn('b_is_status', ['2', '0'])
                       ->orderBy('b_id', 'DESC')
                       ->get()
                       ->getResultArray();
    }
    
    public function getBapById($b_id)
    {
        return $this->db->table('baps')
                        ->where('b_id', $b_id)
                        ->get()
                        ->getRowArray();
    }

    public function get_bap_date()
    {
        return $this->db->table('baps')
                       ->where('b_tanggal >', '1000-01-01')
                       ->orderBy('b_id', 'DESC')
                       ->get()
                       ->getResultArray();
    }

    public function get_bap_by_date()
    {
        return $this->db->table('baps')
                       ->groupStart()
                       ->where('b_tanggal', null)
                       ->groupEnd()
                       ->orderBy('b_id', 'DESC')
                       ->get()
                       ->getResultArray();
    }

    public function add_bap($data)
    {
        return $this->db->table('baps')->insert($data);
    }

    public function edit_bap($data)
    {
        return $this->db->table('baps')
                       ->where('b_id', $data['b_id'])
                       ->update($data);
    }

    public function bap_delete($b_id)
    {
        $bapinfo = $this->db->table('baps')
                           ->where('b_id', $b_id)
                           ->get()
                           ->getResultArray();
        if (count($bapinfo) > 0) {
            return $this->db->table('baps')
                           ->where('b_id', $b_id)
                           ->delete();
        }
        return false;
    }

    public function editpending_bap($data)
    {
        return $this->db->table('baps')
                       ->where('b_id', $data['b_id'])
                       ->update($data);
    }

    public function get_survey()
    {
        return $this->db->table('surveys')
                       ->orderBy('s_id', 'DESC')
                       ->get()
                       ->getResultArray();
    }

    public function generateSurveyCode()
    {
        $data = $this->get_last_scode();
        $last_code = $data['s_code'];
        $last_number = (int)substr($last_code, 3);
        $new_number = $last_number + 1;
        $new_code = '001' . str_pad($new_number, 4, '0', STR_PAD_LEFT);
        return $new_code;
    }

    public function get_surveydetails($s_id)
    {
        return $this->db->table('surveys')
                       ->select('surveys.*, users.u_name as creator_name')
                       ->join('users', 'surveys.s_created_by = users.u_id', 'left')
                       ->where('s_id', $s_id)
                       ->get()
                       ->getResultArray();
    }

    public function get_survey_by_nis($d_nis)
    {
        return $this->db->table('surveys')
                       ->where('s_nis', $d_nis)
                       ->get()
                       ->getResultArray();
    }

    public function add_survey($data)
    {
        return $this->db->table('surveys')->insert($data);
    }
    
    public function edit_survey($s_id, $data)
    {
        return $this->db->table('surveys')
                       ->where('s_id', $s_id)
                       ->update($data);
    }

    public function survey_delete($s_id)
    {
        return $this->db->table('surveys')
                   ->where('s_id', $s_id)
                   ->delete();
    }

    public function getSurveyById($s_id)
    {
        return $this->db->table('surveys')
                       ->where('s_id', $s_id)
                       ->get()
                       ->getRowArray();
    }

    public function get_last_trcode()
    {
        $result = $this->db->table('trainings')
                           ->select('tr_code')
                           ->orderBy('tr_id', 'DESC')
                           ->get()
                           ->getRowArray();

        return $result['tr_code'] ?? null;
    }

    public function get_training()
    {
        return $this->db->table('trainings')
                       ->orderBy('tr_id', 'DESC')
                       ->get()
                       ->getResultArray();
    }

    public function get_trainingdetails($tr_id)
    {
        return $this->db->table('trainings')
                       ->select('trainings.*, users.u_name as creator_name')
                       ->join('users', 'trainings.tr_created_by = users.u_id', 'left')
                       ->where('tr_id', $tr_id)
                       ->get()
                       ->getResultArray();
    }

    public function generateTrainingCode()
    {
        $data = $this->get_last_training_code();
        $last_code = $data['tr_code'];
        $last_number = (int)substr($last_code, 3);
        $new_number = $last_number + 1;
        $new_code = '002' . str_pad($new_number, 4, '0', STR_PAD_LEFT);
        return $new_code;
    }

    public function get_training_by_nis($d_nis)
    {
        return $this->db->table('trainings')
                       ->where('tr_nis', $d_nis)
                       ->get()
                       ->getResultArray();
    }

    public function add_training($data)
    {
        return $this->db->table('trainings')->insert($data);
    }

    public function edit_training($tr_id, $data)
    {
        return $this->db->table('trainings', $tr_id)
                       ->where('tr_id', $tr_id)
                       ->update($data);
    }

    public function training_delete($tr_id)
    {
        $traininginfo = $this->db->table('trainings')
                                ->where('tr_id', $tr_id)
                                ->get()
                                ->getResultArray();
        if (count($traininginfo) > 0) {
            return $this->db->table('trainings')
                           ->where('tr_id', $tr_id)
                           ->delete();
        }
        return false;
    }

    public function get_last_lcode()
    {
        $result = $this->db->table('loans')
                           ->select('l_code')
                           ->orderBy('l_id', 'DESC')
                           ->get()
                           ->getRowArray();

        return $result['l_code'] ?? null;
    }

    public function get_loan()
    {
        return $this->db->table('loans')
                       ->orderBy('l_id', 'DESC')
                       ->get()
                       ->getResultArray();
    }

    public function get_loandetails($l_id)
    {
        return $this->db->table('loans')
                       ->select('loans.*, users.u_name as creator_name')
                       ->join('users', 'loans.l_created_by = users.u_id', 'left')
                       ->where('l_id', $l_id)
                       ->get()
                       ->getResultArray();
    }

    public function get_loan_bystatus()
    {
        return $this->db->table('loans')
                       ->where('l_is_status', '2')
                       ->orderBy('l_id', 'DESC')
                       ->get()
                       ->getResultArray();
    }

    public function add_loan($data)
    {
        return $this->db->table('loans')->insert($data);
    }

    public function edit_loan($data)
    {
        return $this->db->table('loans')
                       ->where('l_id', $data['l_id'])
                       ->update($data);
    }
    
    public function getLoanById($l_id)
    {
        return $this->db->table('loans')
                        ->where('l_id', $l_id)
                        ->get()
                        ->getRowArray();
    }

    public function update_loan_status($loanId, $data)
    {
        return $this->db->table('loans')
                       ->where('l_id', $loanId)
                       ->update($data);
    }

    public function get_last_scode()
    {
        $result = $this->db->table('surveys')
                           ->select('s_code')
                           ->orderBy('s_id', 'DESC')
                           ->get()
                           ->getRowArray();

        return $result['s_code'] ?? null;
    }

    public function get_driver_survey($d_id)
    {
        return $this->db->table('drivers')
                       ->where('d_id', $d_id)
                       ->get()
                       ->getRowArray();
    }

    public function get_combined_loan_bap()
    {
        $loans = $this->db->table('loans')
                         ->select('*, "loans" as type')
                         ->orderBy('l_id', 'DESC')
                         ->get()
                         ->getResultArray();

        $baps = $this->db->table('baps')
                        ->select('*, "baps" as type')
                        ->orderBy('b_id', 'DESC')
                        ->get()
                        ->getResultArray();

        return array_merge($loans, $baps);
    }

    public function get_loan_by_nis($d_nis)
    {
        return $this->db->table('loans')
                       ->where('l_nis', $d_nis)
                       ->orderBy('l_id', 'DESC')
                       ->get()
                       ->getResultArray();
    }

    public function get_all_baps_by_nis($d_nis)
    {
        return $this->db->table('baps')
                       ->where('b_nis', $d_nis)
                       ->orderBy('b_id', 'DESC')
                       ->get()
                       ->getResultArray();
    }

    /**
     * Get All Trainings by Driver Name
     * @param string $driverName Nama supir
     * @return array List training ordered by tr_tanggal DESC
     */
    public function getTrainingsByDriver($driverName)
    {
            return $this->db->table('trainings')
                ->select('tr_id, tr_code, tr_tanggal, tr_nis, tr_supir, tr_kategori, tr_pemateri, tr_tema, tr_lokasi, tr_keterangan, tr_created_by, tr_created_date, tr_modified_date')
                ->where('tr_supir', $driverName)
                ->orderBy('tr_tanggal', 'DESC')
                ->orderBy('tr_id', 'DESC')
                ->get()
                ->getResultArray();
    }

    /**
     * Count Trainings by Driver Name
     * @param string $driverName Nama supir
     * @return int Jumlah training
     */
    public function countTrainingsByDriver($driverName)
    {
            return $this->db->table('trainings')
                ->where('tr_supir', $driverName)
                ->countAllResults();
    }

    /**
     * Get All Trainings by Tema (Inverse: Tema -> List Supir)
     * Mirror getTrainingsByDriver, filter by tr_tema exact match
     * @param string $temaName Nama tema
     * @return array
     */
    public function getTrainingsByTema($temaName)
    {
        try {
            return $this->db->table('trainings')
                ->select('tr_id, tr_code, tr_tanggal, tr_nis, tr_supir, tr_kategori, tr_pemateri, tr_tema, tr_lokasi, tr_keterangan, tr_created_by, tr_created_date, tr_modified_date')
                ->where('tr_tema', $temaName)
                ->orderBy('tr_tanggal', 'DESC')
                ->orderBy('tr_id', 'DESC')
                ->get()
                ->getResultArray();
        } catch (\Exception $e) {
            log_message('error', 'Error in getTrainingsByTema: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Count Trainings by Tema
     * @param string $temaName Nama tema
     * @return int
     */
    public function countTrainingsByTema($temaName)
    {
        try {
            return $this->db->table('trainings')
                ->where('tr_tema', $temaName)
                ->countAllResults();
        } catch (\Exception $e) {
            log_message('error', 'Error in countTrainingsByTema: ' . $e->getMessage());
            return 0;
        }
    }

}
