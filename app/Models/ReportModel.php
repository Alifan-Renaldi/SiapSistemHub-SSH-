<?php namespace App\Models;

use CodeIgniter\Model;

class ReportModel extends Model
{

    public function driver_reports($driver_from, $driver_to, $driver_name, $age_from, $age_to, $bpjs_status, $work_period_from, $work_period_to)
    {
        $builder = $this->db->table('drivers')
                    ->select('drivers.*, drivers.d_nis')
                    ->join('users', 'drivers.d_created_by = users.u_id', 'left');
        
        if($driver_name !== 'all' && $driver_name !== null) {
            $builder->where('drivers.d_is_active', $driver_name);
        }
        if(!empty($driver_from) && !empty($driver_to)) {
            $builder->where('drivers.d_created_date >=', $driver_from)
                    ->where('drivers.d_created_date <=', $driver_to);
        }
        if(!empty($age_from) && !empty($age_to)) {
            $builder->where('drivers.d_age >=', $age_from)
                    ->where('drivers.d_age <=', $age_to);
        }
        if(!empty($bpjs_status)) {
            $builder->where('drivers.d_cardbpjs', $bpjs_status);
        }

        if(isset($work_period_from) && $work_period_from !== '' && isset($work_period_to) && $work_period_to !== '') {
            $p_from = (int)$work_period_from;
            $p_to = (int)$work_period_to;
            $builder->where("TIMESTAMPDIFF(YEAR, drivers.d_doj, IF(drivers.d_resigndate IS NOT NULL AND drivers.d_resigndate > '1000-01-01', drivers.d_resigndate, CURDATE())) >= {$p_from}")
                    ->where("TIMESTAMPDIFF(YEAR, drivers.d_doj, IF(drivers.d_resigndate IS NOT NULL AND drivers.d_resigndate > '1000-01-01', drivers.d_resigndate, CURDATE())) <= {$p_to}");
        }
        // if($province_name !== 'all' && $province_name !== null) {
        //     $builder->where('drivers.d_')
        // }

        return $builder->orderBy('drivers.d_id', 'DESC')
                       ->get()
                       ->getResultArray();
    }

    public function bap_reports($bap_from, $bap_to, $bap_name, $driver_status = null, $case_type = null, $classification = null, $payment = null)
    {
        $builder = $this->db->table('baps')
                           ->select('baps.*, drivers.d_is_active')
                           ->join('drivers', 'drivers.d_nis = baps.b_nis', 'left');

        if ($bap_name !== 'all bap') {
            $builder->where('baps.b_is_status', $bap_name);
        }

        if (!empty($bap_from) && !empty($bap_to)) {
            $builder->where("baps.b_created_date >=", $bap_from)
                   ->where("baps.b_created_date <=", $bap_to);
        }

        if ($driver_status !== null && $driver_status !== '') {
            $builder->where('drivers.d_is_active', $driver_status);
        }

        if (!empty($case_type)) {
            $builder->where('baps.b_jenis_kasus', $case_type);
        }

        if (!empty($classification)) {
            $builder->where('baps.b_klasifikasi', $classification);
        }

        if (!empty($payment)) {
            $builder->where('baps.b_potong_tagihan', $payment);
        }

        return $builder->orderBy('baps.b_id', 'DESC')
                      ->get()
                      ->getResultArray();
    }

    public function laka_reports($laka_from, $laka_to, $driver_name, $nopol, $classification = null)
    {
        $builder = $this->db->table('baps')
                            ->select('baps.*, vehicles.v_reg_exp_date, drivers.d_name')
                            ->join('vehicles', "CONCAT(vehicles.v_registration_no, ' - ',vehicles.v_name) = baps.b_nopol", 'left')
                            ->join('drivers', 'drivers.d_nis = baps.b_nis', 'left');
        // Filter hanya data Lakalantas
        $builder->where('baps.b_jenis_kasus', 'Lakalantas');

        if($driver_name !== 'all driver' && $driver_name !== '') {
            $builder->where('drivers.d_name', $driver_name);
        }
        if(!empty($laka_from) && !empty($laka_to)) {
            $builder->where('baps.b_created_date >=', $laka_from)
                    ->where('baps.b_created_date <=', $laka_to);
        }
        if(!empty($nopol) && $nopol !== 'all') {
            $builder->where('baps.b_nopol', $nopol);
        }
        if(!empty($classification)) {
            $builder->where('baps.b_klasifikasi', $classification);
        }

        return $builder->orderBy('baps.b_id', 'DESC')
                       ->get()
                       ->getResultArray();
    }

    public function survey_reports ($survey_from, $survey_to, $survey_status, $driver_status)
    {
        $builder = $this->db->table('surveys')
                            ->select('surveys.*, drivers.d_is_active, drivers.d_name as driver_name, drivers.d_address as driver_address, users.u_name as creator_name')
                            ->join('users', 'surveys.s_created_by = users.u_id', 'left')
                            ->join('drivers', 'drivers.d_nis = surveys.s_nis', 'left');
                            
        if($survey_status !== 'all survey' && $survey_status !== null && $survey_status !== '') {
            $builder->where('surveys.s_nis', $survey_status);
        }
        
        if(!empty($survey_from) && !empty($survey_to)) {
            $builder->where('surveys.s_created_date >=', $survey_from)
                    ->where('surveys.s_created_date <=', $survey_to);
        }
        
        if($driver_status !== 'all' && $driver_status !== null && $driver_status !== '') {
            $builder->where('drivers.d_is_active', $driver_status);
        }

        // Add default limit to prevent timeout on large datasets
        $builder->limit(5000);

        return $builder->orderBy('surveys.s_id', 'DESC')
                       ->get()
                       ->getResultArray();

    }

    public function training_reports ($training_from, $training_to, $training_status, $driver_status, $training_count)
    {
        $builder = $this->db->table('trainings')
                            ->select('trainings.*, drivers.d_is_active, users.u_name as creator_name')
                            ->join('drivers', 'drivers.d_nis = trainings.tr_nis', 'left')
                            ->join('users', 'trainings.tr_created_by = users.u_id', 'left');

        if($training_status !== 'all training' && $training_status !== null && $training_status !== '') {
            $builder->where('trainings.tr_supir', $training_status);
        }
        if(!empty($training_from) && !empty($training_to)) {
            $builder->where('trainings.tr_created_date >=', $training_from)
                    ->where('trainings.tr_created_date <=', $training_to);
        }
        if($driver_status !== 'all drivers' && $driver_status !== null && $driver_status !== '') {
            $builder->where('drivers.d_is_active', $driver_status);
        }
        if($training_count !== null && $training_count !== '') {
            $builder->where('trainings.tr_count', $training_count);
        }

        return $builder->orderBy('trainings.tr_id', 'DESC')
                       ->get()
                       ->getResultArray();
    }

    // public function loan_reports($loan_from, $loan_to, $loan_type, $loan_status, $driver_status, $driver_name, $payment)
    // {
    //     $builder = $this->db->table('loans')
    //                         ->select('loans.*, drivers.d_is_active')
    //                         ->join('drivers', 'drivers.d_nis = loans.l_nis', 'left');

    //     if($loan_status !== 'all loan' && $loan_status !== null && $loan_status !== '') {
    //         $builder->where('loans.l_status', $loan_status);
    //     }
    //     if(!empty($loan_from) && !empty($loan_to)) {
    //         $builder->where('loans.l_created_date >=', $loan_from)
    //                 ->where('loans.l_created_date <=', $loan_to);
    //     }
        
    //     if($driver_status !== 'all drivers' && $driver_status !== null && $driver_status !== '') {
    //         $builder->where('drivers.d_is_active', $driver_status);
    //     }

    //     return $builder->orderBy('loans.l_id', 'DESC')
    //                    ->get()
    //                    ->getResultArray();
    // }

    public function vehicle_reports($vehicle_from, $vehicle_to, $vehicle_name, $vehicle_owner, $vehicle_type, $report_type, $location_kir)
    {
        $builder = $this->db->table('vehicles');

       if($vehicle_name !== 'all' && $vehicle_name !== null){
            $builder->where('vehicles.v_is_active', $vehicle_name);
       }
       if(!empty($vehicle_from) && !empty($vehicle_to)){
          $builder->where('vehicles.v_created_date >=', $vehicle_from)
                  ->where('vehicles.v_created_date <=', $vehicle_to);
       }

       if (!empty($vehicle_owner) && is_array($vehicle_owner)) {
          $builder->whereIn('vehicles.v_legal', $vehicle_owner);
       }
       if(!empty($vehicle_type) && is_array($vehicle_type)){
          $builder->whereIn('vehicles.v_name', $vehicle_type);
       }
       if (!empty($report_type) && $report_type !== 'all'){
          switch ($report_type) {
            case 'stnk':
                $builder->where('vehicles.v_stnk_expdate IS NOT NULL');
                break;
            case 'plat':
                $builder->where('vehicles.v_plat_expdate IS NOT NULL');
                break;
            case 'kir':
                $builder->where('vehicles.v_kir_expdate IS NOT NULL');
                break;
          }
       }
       if (!empty($location_kir)) {
          $builder->where('vehicles.v_lokasi_kir', $location_kir);
       }

       return $builder->orderBy('vehicles.v_id', 'DESC')
                      ->get()
                      ->getResultArray();
    }

    public function inventory_reports($invent_from, $invent_to, $check_status, $nopol, $invent_type, $vech_type)
    {
        $builder = $this->db->table('inventorys')
                           ->select('inventorys.*, users.u_name as creator_name')
                           ->join('users', 'inventorys.iv_created_by = users.u_id', 'left');

        if($check_status !== 'all status' && $check_status !== null)
            $builder->where('inventorys.iv_is_active', $check_status);

        if (!empty($invent_from) && !empty($invent_to)) {
            $builder->where('inventorys.iv_created_date >=', $invent_from)
                    ->where('inventorys.iv_created_date <=', $invent_to);
        }
        if ($nopol !== null && $nopol !== '' && $nopol !== 'all') {
            $builder->where('inventorys.iv_nopol', $nopol);
        }
        if($invent_type !== '' && $invent_type !== null)
            $builder->where('inventorys.iv_is_active', $invent_type);

        if (!empty($vech_type) && is_array($vech_type)) {
            $builder->whereIn('inventorys.iv_jenis', $vech_type);
        }

        return $builder->orderBy('inventorys.iv_id', 'DESC')
                       ->get()
                       ->getResultArray();
    }

    public function handover_reports($hand_from, $hand_to, $check_status, $nopol, $driver)
    {
        $builder = $this->db->table('handovers');

        if($check_status !== 'all status' && $check_status !== '')
            $builder->where('handovers.is_verified', $check_status);

        if (!empty($hand_from) && !empty($hand_to)) {
            $builder->where('handovers.ho_created_date >=', $hand_from)
                    ->where('handovers.ho_created_date <=', $hand_to);
        }
        if ($nopol !== 'all' && $nopol !== null && $nopol !== '') {
            $builder->where('handovers.ho_nopol', $nopol);
        }
        if ($driver !== null && $driver !== '' && $driver !== 'all') {
            $builder->where('handovers.ho_supirlama', $driver);
        }

        return $builder->orderBy('handovers.ho_id', 'DESC')
                       ->get()
                       ->getResultArray();
    }

    

}
