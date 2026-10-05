<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\DriversModel;
use App\Models\VehicleModel;
use App\Models\TripsModel;
use App\Models\GeofenceModel;
use App\Models\IncomexpenseModel;

class Workshops extends BaseController
{

    protected $vehicleModel;
    protected $driversModel;
    protected $incomexpenseModel;
    protected $geofenceModel;
    protected $session;
    protected $validation;

    public function __construct()
    {
        $this->driversModel = new DriversModel();
        $this->vehicleModel = new VehicleModel();
        $this->session = session();
        helper(['form', 'url', 'string', 'custom']);
    }
    public function incentive_list()
    {
        return view('mechanics/incentive_management');
    }
}
