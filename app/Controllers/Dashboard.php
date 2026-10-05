<?php
namespace App\Controllers;

use App\Models\DashboardModel;
use CodeIgniter\I18n\Time;

class Dashboard extends BaseController
{
    public function index()
    {
        // helper('custom_tanggal');
        // if (!session()->get('logged_in')) {
        //     return redirect()->to('/login');
        // }

        $dashboardModel = new DashboardModel();
        $dashboardData = $dashboardModel->getDashboardCounts();
        $reminderData = $dashboardModel->get_todayreminder();
        $incomeexpenseData = $dashboardModel->get_iechartdata();
        $vehiclesData = $dashboardModel->get_vehicle_expdate();
        $vehicleReadyList = $dashboardModel->get_vehicle_ready_list();
        $inventoryReadyList = $dashboardModel->get_inventory_ready_list();
        // $driverReadyList = $dashboardModel->get_driver_ready_list();

        foreach($vehiclesData as &$vehicle) {
            $vehicle['v_stnk_expdate_str'] = $this->dateToString($vehicle['v_stnk_expdate'] ?? '');
            $vehicle['v_plat_expdate_str'] = $this->dateToString($vehicle['v_plat_expdate'] ?? '');
            $vehicle['v_kir_expdate_str'] = $this->dateToString($vehicle['v_kir_expdate'] ?? '');
        }
        
        unset($vehicle);



        $reminderYellow = $dashboardModel->get_reminders_yellow();
        $reminderRed = $dashboardModel->get_reminders_red();

        $data = [
            'dashboard' => $dashboardData,
            'todayreminder' => $reminderData,
            'iechart' => $incomeexpenseData,
            'vehicles' => $vehiclesData,
            'reminderYellow' => $reminderYellow,
            'reminderRed' => $reminderRed,
            'vehicleReadyList' => $vehicleReadyList,
            'inventoryReadyList' => $inventoryReadyList,
            // 'driverReadyList' => $driverReadyList,
            'username'  => session()->get('username')
        ];

        return view('dashboard', $data);
    }

    private function dateToString($date, $format = 'Y-m-d')
    {
        if (empty($date)) {
            return '-';
        }

        return date($format, strtotime($date));
    }

    /**
     * Save theme preference (dark/light) to session via AJAX.
     * Route: POST /theme/set
     */
    public function setTheme()
    {
        $theme = strtolower(trim((string) $this->request->getPost('theme')));
        if (! in_array($theme, ['dark', 'light'], true)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => 'error',
                'message' => 'Invalid theme value. Use dark or light.',
            ]);
        }

        session()->set('theme', $theme);

        return $this->response->setJSON([
            'status' => 'ok',
            'theme'  => $theme,
        ]);
    }
}
