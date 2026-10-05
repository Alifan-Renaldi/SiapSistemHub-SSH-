<?php 
namespace App\Models;

use CodeIgniter\Model;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;

class VehicleModel extends Model
{
    protected $table = 'vehicles';
    protected $primaryKey = 'v_id';
    protected $allowedFields = [
        'v_registration_no', 'v_type', 'v_name', 'v_group', 'v_owner', 'v_reg_exp_date', 'v_is_active', 'v_stnk_expdate', 'v_plat_expdate',
        'v_kir_expdate', 'v_kir_process_date', 'v_legal', 'v_chassis_no', 'v_engine_no', 'v_uji_no', 'v_lokasi_kir', 'v_notes_lokasikir', 'v_insurance', 'v_polis_no', 'v_exp_insurance', 'v_notes', 'v_created_by', 'v_created_date', 'v_modified_date', 'v_qr_code_path', 'v_qr_code_filename'
    ];

    public function getall_vehicle()
    {
        return $this->orderBy('v_id', 'DESC')->findAll();
    }

    public function get_vehicledetails($v_id)
    {
        return $this->select('vehicles.*, users.u_name as creator_name')
                    ->join('users', 'vehicles.v_created_by = users.u_id', 'left')
                    ->where('v_id', $v_id)
                    ->findAll();
    }

    public function get_last_vcode()
    {
        $result = $this->db->table('vehicles')
                           ->select('v_code')
                           ->orderBy('v_id', 'DESC')
                           ->get()
                           ->getRowArray();

        return $result['v_code'] ?? null;
    }

    public function vehicle_delete($v_id)
    {
        $vehicleinfo = $this->find($v_id);
        if (!$vehicleinfo) {
            return false;
        }

        // Delete QR code file if it exists
        if (!empty($vehicleinfo['v_qr_code_path'])) {
            $fullPath = WRITEPATH . $vehicleinfo['v_qr_code_path'];
            if (file_exists($fullPath)) {
                @unlink($fullPath);
            }
        }

        return $this->where('v_id', $v_id)->delete();
    }

    public function getall_bookings($v_id)
    {
        $db = \Config\Database::connect();
        $bookings = $db->table('trips')
                      ->where('t_vechicle', $v_id)
                      ->orderBy('t_id', 'desc')
                      ->get()
                      ->getResultArray();
        
        if (!empty($bookings)) {
            $newtripdata = [];
            foreach ($bookings as $key => $tripdataval) {
                $newtripdata[$key] = $tripdataval;
                
                // Get customer details
                $customer = $db->table('customers')
                              ->where('c_id', $tripdataval['t_customer_id'])
                              ->get()
                              ->getRow();
                $newtripdata[$key]['t_customer_details'] = $customer;
                
                // Get driver details
                $driver = $db->table('drivers')
                             ->where('d_id', $tripdataval['t_driver'])
                             ->get()
                             ->getRow();
                $newtripdata[$key]['t_driver_details'] = $driver;
            }
            return $newtripdata;
        } else {
            return [];
        }
    }

    public function get_distinct_owners()
    {
        $db = \Config\Database::connect();
        return $db->table('vehicles')
                 ->select('v_legal')
                 ->distinct()
                 ->orderBy('v_legal', 'ASC')
                 ->get()
                 ->getResultArray();
    }

    public function get_distinct_types()
    {
        $db = \Config\Database::connect();
        return $db->table('vehicles')
                 ->select('v_name')
                 ->distinct()
                 ->orderBy('v_name', 'ASC')
                 ->get()
                 ->getResultArray();
    }

    public function get_vehiclegroup()
    {
        $db = \Config\Database::connect();
        return $db->table('vehicle_group')->get()->getResultArray();
    }

    public function vehiclegroup_delete($gr_id)
    {
        $db = \Config\Database::connect();
        return $db->table('vehicle_group')->where('gr_id', $gr_id)->delete();
    }

    public function get_vehicleowner()
    {
        $db = \Config\Database::connect();
        return $db->table('vehicle_owner')->get()->getResultArray();
    }

    public function vehicleowner_delete($ow_id)
    {
        $db = \Config\Database::connect();
        $ownerinfo = $db->table('vehicles')
                       ->where('v_owner', $ow_id)
                       ->get()
                       ->getResultArray();
        
        if (count($ownerinfo) > 0) {
            return false;
        } else {
            return $db->table('vehicle_owner')->where('ow_id', $ow_id)->delete();
        }
    }

    public function get_last_ivcode()
    {
        $result = $this->db->table('inventorys')
                           ->select('iv_code')
                           ->orderBy('iv_id', 'DESC')
                           ->get()
                           ->getRowArray();

        return $result['iv_code'] ?? null;
    }

    public function insert_inventory($data)
    {
        return $this->db->table('inventorys')->insert($data);
    }

    public function getInventory()
    {
        return $this->db->table('inventorys')->orderBy('iv_id', 'DESC')->get()->getResultArray();
    }

    public function get_inventory_columns()
    {
        $column = 
        [
            [
                'column_name' => 1,
                'column_alias' => 'Sudah Diperiksa'
            ],
            [
                'column_name' => 0,
                'column_alias' => 'Belum Diperiksa'
            ]
        ];

        return $column;
    }   

    public function get_distinct_inventory_data()
    {
        $db = \Config\Database::connect();
        
        // Distinct nopol dari tabel inventorys
        $vehicles = $db->table('inventorys')
                ->select('iv_nopol')
                ->distinct()
                ->orderBy('iv_nopol', 'ASC')
                ->get()
                ->getResultArray();

        // Distinct jenis dari tabel inventorys
        $types = $db->table('inventorys')
                ->select('iv_jenis')
                ->distinct()
                ->where('iv_jenis IS NOT NULL')
                ->where('iv_jenis !=', '')
                ->orderBy('iv_jenis', 'ASC')
                ->get()
                ->getResultArray();

        return [
            'vehicles' => $vehicles,
            'types'    => $types,
        ];
    }

    public function get_inventorydetails($iv_id)
    {
        return $this->db->table('inventorys')
                       ->select('inventorys.*, users.u_name as creator_name, vehicles.v_stnk_expdate, vehicles.v_kir_expdate')
                       ->join('users', 'inventorys.iv_created_by = users.u_id', 'left')
                       ->join('vehicles', 'vehicles.v_registration_no = inventorys.iv_nopol', 'left')
                       ->where('iv_id', $iv_id)
                       ->get()
                       ->getResultArray();
    }

    public function update_inventory($data)
    {
        $iv_id = $data['iv_id'];
        unset($data['iv_id']);
        return $this->db->table('inventorys')->where('iv_id', $iv_id)->update($data);
    }

    public function inventory_delete($iv_id)
    {
        try {
            $this->db->transBegin();

            $this->db->table('inventory_history')
                    ->where('iv_id', $iv_id)
                    ->delete();
            
            $deleteResult = $this->db->table('inventorys')
                                    ->where('iv_id', $iv_id)
                                    ->delete();
            
            if ($this->db->transStatus() === false) {
                $this->db->transRollback();
                return false;
            }
            
            $this->db->transCommit();
            return $deleteResult;
            
        } catch (\Exception $e) {
            $this->db->transRollback();
            log_message('error', 'Failed to delete inventory: ' . $e->getMessage());
            return false;
        }
    }

    public function getInventoryById($iv_id)
    {
        return $this->db->table('inventorys')
                        ->where('iv_id', $iv_id)
                        ->get()
                        ->getRowArray();
    }

    public function get_last_hocode()
    {
        $result = $this->db->table('handovers')
                           ->select('ho_code')
                           ->orderBy('ho_id', 'DESC')
                           ->get()
                           ->getRowArray();

        return $result['ho_code'] ?? null;
    }

    public function getHandover()
    {
        return $this->db->table('handovers')->orderBy('ho_tanggal', 'DESC')->get()->getResultArray();
    }

    public function get_distinct_handover_vehicles()
    {
        $db = \Config\Database::connect();
        return $db->table('handovers')->select('ho_nopol')->distinct()->orderBy('ho_nopol', 'ASC')->get()->getResultArray();
    }

    public function get_handoverdetails($ho_id)
    {
        return $this->db->table('handovers')
                       ->select('handovers.*, users.u_name as creator_name')
                       ->join('users', 'handovers.ho_created_by = users.u_id', 'left')
                       ->where('ho_id', $ho_id)
                       ->get()
                       ->getResultArray();
    }

    public function getHandoverById($ho_id)
    {
        return $this->db->table('handovers')
                        ->where('ho_id', $ho_id)
                        ->get()
                        ->getRowArray();
    }

    public function get_handover_by_hocode($ho_code)
    {
        // Pastikan ho_code di-trim jika diperlukan
        $ho_code = trim($ho_code);
        return $this->db->table('handovers')
                       ->where('ho_code', $ho_code) // Cari berdasarkan ho_code yang unik
                       ->get()
                       ->getRowArray(); // Ambil satu record
    }

    public function add_handover($data)
    {
        return $this->db->table('handovers')
        ->join('inventorys', 'handovers.ho_nopol = inventorys.iv_nopol', 'left')
        ->where('inventorys.iv_is_active', 1)
        ->insert($data);
    }

    public function edit_handover($data)
    {
        $ho_id = $data['ho_id'];
        unset($data['ho_id']);
        return $this->db->table('handovers')
                       ->where('ho_id', $ho_id)
                       ->update($data);
    }

    public function handover_delete($ho_id)
    {
        return $this->db->table('handovers')
                       ->where('ho_id', $ho_id)
                       ->delete();
    }

    public function get_distinct_merk_ban()
    {
        $db = \Config\Database::connect();
        return $db->table('handover')
                 ->select('ho_merkbankr')
                 ->distinct()
                 ->orderBy('ho_merkbankr', 'ASC')
                 ->get()
                 ->getResultArray();
    }

    public function get_handovermerkban()
    {
        $db = \Config\Database::connect();
        return $db->table('handover_merk_ban')->get()->getResultArray();
    }

    public function handovermerkban_delete($mb_id)
    {
        $db = \Config\Database::connect();
        return $db->table('handover_merk_ban')->where('mv_id', $mb_id)->delete();
    }

    public function get_handovermerkvelg()
    {
        $db = \Config\Database::connect();
        return $db->table('handover_merk_velg')->get()->getResultArray();
    }

    public function handovermerkvelg_delete($mv_id)
    {
        $db = \Config\Database::connect();
        return $db->table('handover_merk_velg')->where('mv_id', $mv_id)->delete();
    }

    // public function get_handovermerkvelg()
    // {
    //     $db = \Config\Database::connect();
    //     return $db->table('handover_merk_velg')->get()->getResultArray();
    // }

    // public function handover_merk_velg_delete($mv_id)
    // {
    //     $db = \Config\Database::connect();
    //     $velginfo = $db->table('handovers')
    //                 ->where('ho_merk_velg', $mv_id)
    //                 ->get()
    //                 ->getResultArray();
        
    //     if (count($velginfo) > 0) {
    //         return false;
    //     } else {
    //         return $db->table('handover_merk_velg')->where('mv_id', $mv_id)->delete();
    //     }
    // }
}