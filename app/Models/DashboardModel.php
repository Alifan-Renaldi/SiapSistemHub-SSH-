<?php namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\BaseConnection;

class DashboardModel
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function getDashboardCounts()
    {
        $data['tot_vehicles'] = $this->db->table('vehicles')->countAll();
        $data['tot_vehicles_active'] = $this->db->table('vehicles')->where('v_is_active', '1')->countAllResults();
        $data['tot_vehicles_inactive'] = $this->db->table('vehicles')->where('v_is_active', '0')->countAllResults();
        $data['tot_drivers'] = $this->db->table('drivers')->countAll();
        $data['tot_inventorys'] = $this->db->table('inventorys')->countAll();
        $data['tot_drivers_active'] = $this->db->table('drivers')->where('d_is_active', '1')->countAllResults();
        $data['tot_drivers_inactive'] = $this->db->table('drivers')->where('d_is_active', '0')->countAllResults();
        $data['tot_bap'] = $this->db->table('baps')->countAll();
        $data['tot_customers'] = $this->db->table('customers')->countAll();
        $data['tot_today_trips'] = $this->db->table('trips')
            ->where('t_start_date', date('Y-m-d'))
            ->countAllResults();

        $data['tot_today_income'] = $this->db->table('incomeexpense')
            ->selectSum('ie_amount')
            ->where(['ie_date' => date('Y-m-d'), 'ie_type' => 'income'])
            ->get()->getRow()->ie_amount ?? 0;

        $data['tot_today_expense'] = $this->db->table('incomeexpense')
            ->selectSum('ie_amount')
            ->where(['ie_date' => date('Y-m-d'), 'ie_type' => 'expense'])
            ->get()->getRow()->ie_amount ?? 0;

        return $data;
    }

    public function get_driverdetails($d_id)
    {
        return $this->db->table('drivers')
            ->where('d_id', $d_id)
            ->get()
            ->getResultArray();
    }

    public function get_todayreminder()
    {
        return $this->db->table('reminder')
            ->where(['r_date' => date('Y-m-d'), 'r_isread' => 0])
            ->get()
            ->getResultArray();
    }

    public function get_iechartdata()
    {
        $date = $this->createDateRangeArray(date('Y-m-d', strtotime('-5 day')), date('Y-m-d'));
        $arr = [];

        foreach ($date as $dates) {
            $income = $this->db->table('incomeexpense')
                ->selectSum('ie_amount')
                ->where(['ie_date' => $dates, 'ie_type' => 'income'])
                ->get()->getRow()->ie_amount ?? 0;

            $expense = $this->db->table('incomeexpense')
                ->selectSum('ie_amount')
                ->where(['ie_date' => $dates, 'ie_type' => 'expense'])
                ->get()->getRow()->ie_amount ?? 0;

            $arr[$dates] = [
                'income' => $income,
                'expense' => $expense
            ];
        }

        return $arr;
    }

    public function get_vechicle_currentlocation()
    {
        $vehicles = $this->db->table('vehicles')
            ->select('v_id,v_registration_no,v_name')
            ->get()
            ->getResultArray();

        $lastlocation = [];

        foreach ($vehicles as $key => $vehicle) {
            $lastlocation[$key] = $vehicle;
            $location = $this->db->table('positions')
                ->select('latitude,longitude')
                ->where('v_id', $vehicle['v_id'])
                ->orderBy('id', 'DESC')
                ->get()->getRow();

            $lastlocation[$key]['current_location'] = $location
                ? $this->getaddress($location->latitude, $location->longitude)
                : '';
        }

        return $lastlocation;
    }

    public function getvechicle_status()
    {
        $sql = 'SELECT `t_vechicle`, `t_trip_status`, b.v_name, b.v_registration_no 
                FROM trips a 
                INNER JOIN vehicles b ON a.t_vechicle = b.v_id 
                WHERE t_id IN (
                    SELECT MAX(t_id) FROM trips GROUP BY t_vechicle
                ) 
                ORDER BY t_trip_status';

        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function get_reminders_yellow()
    {
        $today = date('Y-m-d');
        $today15Days = date('Y-m-d', strtotime('+15 days'));

        $data = [];

        $data['stnk_yellow'] = $this->db->table('vehicles')
                             ->where('v_stnk_expdate IS NOT NULL')
                             ->where('v_stnk_expdate >=', $today)
                             ->where('v_stnk_expdate <=', $today15Days)
                             ->countAllResults();
        
        $data['plat_yellow'] = $this->db->table('vehicles')
                             ->where('v_plat_expdate IS NOT NULL')
                             ->where('v_plat_expdate >=', $today)
                             ->where('v_plat_expdate <=', $today15Days)
                             ->countAllResults();

        $data['kir_yellow'] = $this->db->table('vehicles')
                             ->where('v_kir_expdate IS NOT NULL')
                             ->where('v_kir_expdate >=', $today)
                             ->where('v_kir_expdate <=', $today15Days)
                             ->countAllResults();

        return $data;
    }

    public function get_reminders_red()
    {
        $today = date('Y-m-d');

        $data = [];

        $data['stnk_red'] = $this->db->table('vehicles')
                             ->where('v_stnk_expdate IS NOT NULL')
                             ->where('v_stnk_expdate <', $today)
                             ->countAllResults();
        
        $data['plat_red'] = $this->db->table('vehicles')
                             ->where('v_plat_expdate IS NOT NULL')
                             ->where('v_plat_expdate <', $today)
                             ->countAllResults();

        $data['kir_red'] = $this->db->table('vehicles')
                             ->where('v_kir_expdate IS NOT NULL')
                             ->where('v_kir_expdate <', $today)
                             ->countAllResults();

        return $data;
    }

    public function get_vehicle_expdate()
    {
        return $this->db->table('vehicles')
                        ->select('v_id,v_stnk_expdate,v_plat_expdate,v_kir_expdate')
                        ->get()
                        ->getResultArray();
    }

    public function createDateRangeArray($start, $end)
    {
        $range = [];
        $start = strtotime($start);
        $end = strtotime($end);

        while ($start <= $end) {
            $range[] = date('Y-m-d', $start);
            $start = strtotime("+1 day", $start);
        }

        return $range;
    }

    public function get_vehicle_ready_list() {
        return $this->db->table('vehicle_group')
                        ->select(
                            'vehicle_group.gr_id, vehicle_group.gr_name,
                            COUNT(vehicles.v_id) as total_vehicle,
                            SUM(CASE WHEN vehicles.v_is_active = 1 THEN 1 ELSE 0 END) as total_active_vehicle,
                            SUM(CASE WHEN vehicles.v_is_active = 0 THEN 1 ELSE 0 END) as total_inactive_vehicle'
                        )
                        ->join('vehicles', 'vehicles.v_name = vehicle_group.gr_name', 'left')
                        ->groupBy('vehicle_group.gr_id , vehicle_group.gr_name')
                        ->orderBy('vehicle_group.gr_name', 'DESC')
                        ->get()
                        ->getResultArray();
    }

    public function get_inventory_ready_list() {
        return $this->db->table('inventorys')
                        ->select(
                            'inventorys.iv_jenis,
                            COUNT(inventorys.iv_id) as total_inventory'
                        )
                        ->groupBy('inventorys.iv_jenis')
                        ->orderBy('inventorys.iv_jenis', 'DESC')
                        ->get()
                        ->getResultArray();
    }

    // public function get_driver_ready_list() {
    //     return $this->db->table('drivers')
    //                     ->select(
    //                         'drivers.d_id, drivers.d_name,
    //                         COUNT(drivers.d_id) as total_driver,
    //                         SUM(CASE WHEN drivers.d_is_active = 1 THEN 1 ELSE 0 END) as total_active_driver,
    //                         SUM(CASE WHEN drivers.d_is_active = 0 THEN 1 ELSE 0 END) as total_inactive_driver'
    //                         )
    //                         ->get()
    //                         ->getResultArray();
    // }

    public function getaddress($lat, $lng)
    {
        $google_api_key = getenv('GOOGLE_API_KEY');
        $url = "https://maps.googleapis.com/maps/api/geocode/json?key=$google_api_key&latlng={$lat},{$lng}&sensor=false";

        $client = \Config\Services::curlrequest();
        $response = $client->get($url);
        $data = json_decode($response->getBody());

        if (!empty($data) && $data->status == "OK") {
            return $data->results[1]->formatted_address ?? '';
        }

        return '';
    }

}
