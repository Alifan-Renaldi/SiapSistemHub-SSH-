<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Login::index');
$routes->get('/login', 'Login::index');
$routes->post('/login/auth', 'Login::auth');
$routes->get('/logout', 'Login::logout');
$routes->get('/dashboard', 'Dashboard::index');

//user
$routes->get('/users/user_management', 'Users::index');
$routes->match(['get', 'post'], 'users/adduser', 'Users::adduser');
$routes->match(['get', 'post'], 'users/edituser/(:num)', 'Users::edituser/$1');
$routes->post('users/insertuser', 'Users::insertuser');
$routes->post('users/updateuser', 'Users::updateuser');
$routes->post('users/deleteuser/(:num)', 'Users::deleteuser/$1');

//settings
$routes->get('settings/websitesetting', 'Settings::websitesetting');
$routes->post('settings/websitesetting_save', 'Settings::websitesetting_save');
$routes->post('settings/logodelete', 'Settings::logodelete');

//driver active
$routes->get('/drivers/drivers_management', 'Drivers::index');
$routes->match(['get', 'post'], 'drivers/adddrivers', 'Drivers::adddrivers');
$routes->match(['get', 'post'], 'drivers/editdriver', 'Drivers::editdriver');
$routes->post('drivers/viewdriver', 'Drivers::viewdriver');
$routes->post('drivers/drivers_delete/(:num)', 'Drivers::drivers_delete/$1');
$routes->post('drivers/insertdriver', 'Drivers::insertdriver');
$routes->post('drivers/updatedriver', 'Drivers::updatedriver');
//driver inactive
$routes->get('/drivers/drivers_inactive', 'Drivers::inactivedriver');
$routes->match(['get', 'post'], 'drivers/adddriversblacklist', 'Drivers::adddriversblacklist');
$routes->match(['get', 'post'], 'drivers/editdriverblacklist', 'Drivers::editdriverblacklist');
$routes->post('drivers/viewdriver_inactive', 'Drivers::viewdriver_inactive');
$routes->post('drivers/insertdriverblacklist', 'Drivers::insertdriverblacklist');
$routes->post('drivers/updatedriverblacklist', 'Drivers::updatedriverblacklist');

$routes->get('drivers/getRegencies/(:num)', 'Drivers::getRegencies/$1');
$routes->get('drivers/getDistricts/(:num)', 'Drivers::getDistricts/$1');
$routes->get('drivers/getVillages/(:num)', 'Drivers::getVillages/$1');

//bap
$routes->get('/baps/bap_management', 'Drivers::baplists_drivers');
$routes->get('/baps/bap_pending', 'Drivers::baplist_pending');
$routes->match(['get', 'post'], 'baps/addbap', 'Drivers::addbap');
$routes->match(['get', 'post'], 'baps/editbap', 'Drivers::editbap');
$routes->match(['get', 'post'], 'baps/editbap/(:num)', 'Drivers::editbap/$1');
$routes->post('baps/bap_view', 'Drivers::viewbap');
$routes->post('drivers/insertbap', 'Drivers::insertbap');
$routes->post('drivers/updatebap', 'Drivers::updatebap');
$routes->post('drivers/bap_delete/(:num)', 'Drivers::bap_delete/$1');
$routes->match(['get', 'post'], 'baps/editbap_pending/(:num)', 'Drivers::editbap_pending/$1');
$routes->post('baps/bap_pendingview', 'Drivers::viewbappending');
$routes->post('drivers/updatebap_pending', 'Drivers::updatebap_pending');
$routes->post('drivers/bappending_delete/(:num)', 'Drivers::bappending_delete/$1');
$routes->get('drivers/printbap/(:num)', 'Drivers::printbap/$1');
$routes->get('baps/bap_print/(:num)', 'Drivers::printbap/$1');

//survey
$routes->get('/surveys/survey_management', 'Drivers::surveylist_drivers');
$routes->match(['get', 'post'], 'surveys/addsurvey', 'Drivers::addsurvey');
$routes->match(['get', 'post'], 'surveys/editsurvey', 'Drivers::editsurvey');
$routes->post('drivers/insertsurvey', 'Drivers::insertsurvey');
$routes->post('drivers/updatesurvey', 'Drivers::updatesurvey');
$routes->post('surveys/survey_view', 'Drivers::viewsurvey');
$routes->post('drivers/survey_delete/(:num)', 'Drivers::survey_delete/$1');

//training
$routes->get('trainings/training_management', 'Drivers::traininglist_drivers');
$routes->match(['get', 'post'], 'trainings/addtraining', 'Drivers::addtraining');
$routes->match(['get', 'post'], 'trainings/edittraining/(:num)', 'Drivers::edittraining/$1');
$routes->post('drivers/inserttraining', 'Drivers::inserttraining');
$routes->post('drivers/updatetraining', 'Drivers::updatetraining');
$routes->post('drivers/training_delete/(:num)', 'Drivers::training_delete/$1');
$routes->get('trainings/viewtraining/(:num)', 'Drivers::viewtraining/$1');
$routes->get('drivers/generateCode', 'Drivers::generateCode');
$routes->post('trainings/getDetailByDriver', 'Drivers::getDetailTrainingByDriver');
$routes->post('trainings/getDetailByTema', 'Drivers::getDetailTrainingByTema');

//loan
$routes->get('loans/loan_management', 'Drivers::loanlist_drivers');
$routes->get('loans/loan_management/(:num)', 'Drivers::loanlist_drivers/$1');
$routes->match(['get', 'post'], 'loans/addloan', 'Drivers::addloan');
$routes->match(['get', 'post'], 'loans/editloan', 'Drivers::editloan');
$routes->post('drivers/insertloan', 'Drivers::insertloan');
$routes->post('drivers/updateloan', 'Drivers::updateloan');
$routes->post('loans/viewloan', 'Drivers::viewloan');
$routes->post('drivers/loan_delete/(:num)', 'Drivers::loan_delete/$1');
$routes->post('drivers/mark_debt_paid', 'Drivers::mark_debt_paid');
$routes->get('loans/loan_approve', 'Drivers::loanlist_approve');
$routes->post('loans/update_loan_status', 'Drivers::update_loan_status');

//vehicle management
$routes->get('/vehicles/vehicles_management', 'Vehicle::index');
$routes->match(['get', 'post'], 'vehicles/vehiclegroup', 'Vehicle::vehiclegroup');
$routes->match(['get', 'post'], 'vehicle/addgroup', 'Vehicle::addgroup');
$routes->match(['get', 'post'], 'vehicles/vehicleowner', 'Vehicle::vehicleowner');
$routes->match(['get', 'post'], 'vehicle/addowner', 'Vehicle::addowner');
$routes->match(['get', 'post'], 'vehicles/addvehicle', 'Vehicle::addvehicle');
$routes->match(['get', 'post'], 'vehicles/editvehicle', 'Vehicle::editvehicle');
$routes->post('vehicles/viewvehicle', 'Vehicle::viewvehicle');
$routes->post('vehicles/insertvehicle', 'Vehicle::insertvehicle');
$routes->post('vehicles/updatevehicle', 'Vehicle::updatevehicle');
$routes->post('vehicles/vehicle_delete/(:num)', 'Vehicle::vehicle_delete/$1');
$routes->get('vehicle/vehiclegroup_delete/(:num)', 'Vehicle::vehiclegroup_delete/$1');
$routes->get('vehicle/vehicleowner_delete/(:num)', 'Vehicle::vehicleowner_delete/$1');
$routes->get('vehicles/download_qrcode/(:num)', 'Vehicle::download_qrcode/$1');
$routes->get('vehicles/view_qrcode/(:num)', 'Vehicle::view_qrcode/$1');
$routes->get('vehicles/generate_qrcode_with_label/(:num)', 'Vehicle::generate_qrcode_with_label/$1');
$routes->get('vehicles/print_qrcode/(:num)', 'Vehicle::print_qrcode/$1');
$routes->post('vehicles/generate_qrcode_preview', 'Vehicle::generate_qrcode_preview');
$routes->get('vehicles/generate_qrcode_preview', 'Vehicle::generate_qrcode_preview');

//inventory
$routes->get('inventory/inventory_management', 'Vehicle::inventorylist_vehicle');
$routes->match(['get', 'post'], 'inventory/addinventory', 'Vehicle::addinventory');
$routes->match(['get', 'post'], 'inventory/editinventory', 'Vehicle::editinventory');
$routes->match(['get', 'post'], 'inventory/editinventory/(:num)', 'Vehicle::editinventory');
$routes->post('vehicles/insertinventory', 'Vehicle::insertinventory');
$routes->post('vehicles/updateinventory', 'Vehicle::updateinventory');
$routes->post('inventory/inventory_view', 'Vehicle::viewinventory');
$routes->post('inventory/inventory_delete/(:num)', 'Vehicle::inventory_delete/$1');
$routes->get('vehicles/printinventory/(:num)', 'Vehicle::printinventory/$1');
$routes->get('inventory/inventory_print/(:num)', 'Vehicle::printinventory/$1');
$routes->get('inventory/inventory_download_pdf/(:num)', 'Vehicle::downloadInventoryPdf/$1');

//handover
$routes->get('handover/handover_management', 'Vehicle::handoverlist_vehicle');
$routes->match(['get', 'post'], 'handover/handovermerkban', 'Vehicle::handovermerkban');
$routes->match(['get', 'post'], 'handover/addhandovermerkban', 'Vehicle::addhandovermerkban');
$routes->match(['get', 'post'], 'handover/handovermerkvelg', 'Vehicle::handovermerkvelg');
$routes->match(['get', 'post'], 'handover/addhandovermerkvelg', 'Vehicle::addhandovermerkvelg');
// $routes->match(['get', 'post'], 'handover/handovermerkvelg', 'Vehicle::handovermerkvelg');
// $routes->match(['get', 'post'], 'handover/addhandovermerkvelg', 'Vehicle::addhandovermerkvelg');
$routes->match(['get', 'post'], 'handover/addhandover', 'Vehicle::addhandover');
$routes->match(['get', 'post'], 'handover/edithandover', 'Vehicle::edithandover');
$routes->match(['get', 'post'], 'handover/edithandover/(:num)', 'Vehicle::edithandover');
$routes->post('vehicles/inserthandover', 'Vehicle::inserthandover');
$routes->post('vehicles/updatehandover', 'Vehicle::updatehandover');
$routes->post('handover/handover_view', 'Vehicle::viewhandover');
$routes->post('handover/handover_delete/(:num)', 'Vehicle::handover_delete/$1');
$routes->get('handover/handovermerkban_delete/(:num)', 'Vehicle::handovermerkban_delete/$1');
$routes->get('handover/handovermerkvelg_delete/(:num)', 'Vehicle::handovermerkvelg_delete/$1');
$routes->get('handover/viewhandoverinventory/(:any)/(:num)', 'Vehicle::viewhandoverinventory/$1/$2');
$routes->get('handover/edithandoverinventory', 'Vehicle::edithandoverinventory');
$routes->post('handover/updateinventoryandproceed', 'Vehicle::updateinventoryandproceed');
$routes->get('handover/preview', 'Vehicle::preview');
$routes->get('handover/handover_print/(:num)', 'Vehicle::printhandover/$1');
$routes->post('handover/save_signature', 'Vehicle::save_signature');
$routes->get('handover/handover_download_pdf/(:num)', 'Vehicle::downloadHandoverPdf/$1');

//report
$routes->match(['get', 'post'], 'reports/driver', 'Reports::driver');
$routes->match(['get', 'post'], 'reports/export_driver_excel', 'Reports::export_driver_excel');
$routes->match(['get', 'post'], 'reports/export_driver_pdf', 'Reports::export_driver_pdf');
$routes->match(['get', 'post'], 'reports/bap', 'Reports::bap');
$routes->match(['get', 'post'], 'reports/export_bap_excel', 'Reports::export_bap_excel');
$routes->match(['get', 'post'], 'reports/export_bap_pdf', 'Reports::export_bap_pdf');
$routes->match(['get', 'post'], 'reports/laka', 'Reports::laka');
$routes->match(['get', 'post'], 'reports/export_laka_excel', 'Reports::export_laka_excel');
$routes->match(['get', 'post'], 'reports/export_laka_pdf', 'Reports::export_laka_pdf');
$routes->match(['get', 'post'], 'reports/survey', 'Reports::survey');
$routes->match(['get', 'post'], 'reports/export_survey_excel', 'Reports::export_survey_excel');
$routes->match(['get', 'post'], 'reports/export_survey_pdf', 'Reports::export_survey_pdf');
$routes->match(['get', 'post'], 'reports/training', 'Reports::training');
$routes->match(['get', 'post'], 'reports/export_training_excel', 'Reports::export_training_excel');
$routes->match(['get', 'post'], 'reports/export_training_pdf', 'Reports::export_training_pdf');
$routes->match(['get', 'post'], 'reports/loan', 'Reports::loan');
$routes->match(['get', 'post'], 'reports/export_loan_excel', 'Reports::export_loan_excel');
$routes->match(['get', 'post'], 'reports/export_loan_pdf', 'Reports::export_loan_pdf');
$routes->match(['get', 'post'], 'reports/vehicle', 'Reports::vehicle');
$routes->match(['get', 'post'], 'reports/export_vehicle_excel', 'Reports::export_vehicle_excel');
$routes->match(['get', 'post'], 'reports/export_vehicle_pdf', 'Reports::export_vehicle_pdf');
$routes->match(['get', 'post'], 'reports/inventory', 'Reports::inventory');
$routes->match(['get', 'post'], 'reports/export_inventory_excel', 'Reports::export_inventory_excel');
$routes->match(['get', 'post'], 'reports/export_inventory_pdf', 'Reports::export_inventory_pdf');
$routes->match(['get', 'post'], 'reports/handover', 'Reports::handover');
$routes->match(['get', 'post'], 'reports/export_handover_excel', 'Reports::export_handover_excel');
$routes->match(['get', 'post'], 'reports/export_handover_pdf', 'Reports::export_handover_pdf');

//mechanics
$routes->get('mechanics/incentive_management', 'Workshops::incentive_list');
$routes->match(['get', 'post'], 'mechanics/addincentive', 'Workshops::addincentive');
$routes->match(['get', 'post'], 'mechanics/editincentive', 'Vehicle::editincentive');
$routes->post('mechanics/viewincentive', 'Workshops::viewincentive');
$routes->post('mechanics/insertincentive', 'Workshops::insertincentive');
$routes->post('mechanics/updateincentive', 'Workshops::updateincentive');
$routes->post('mechanics/incentive_delete/(:num)', 'Vehicle::incentive_delete/$1');

$routes->get('form_information', 'Development::index');

// Global theme preference (dark/light) persisted to session
$routes->post('theme/set', 'Dashboard::setTheme');

