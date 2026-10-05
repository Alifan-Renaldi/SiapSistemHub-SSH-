<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class Settings extends BaseController
{
    protected $db;
    protected $session;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
        helper(['form', 'url']);
    }

    public function websitesetting()
    {
        $builder = $this->db->table('settings');
        $data['website_setting'] = $builder->get()->getResultArray();
        
        return view('settings/websitesetting', $data);
    }

    public function websitesetting_save()
    {
        $validation = Services::validation();
        
        // Validasi input
        $rules = [
            's_companyname' => 'required',
            's_address' => 'required',
            's_googel_api_key' => 'required',
            's_inovice_prefix' => 'required',
            's_price_prefix' => 'required',
            's_inovice_termsandcondition' => 'required',
            's_inovice_servicename' => 'required'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $insertarray = $this->request->getPost();
        $success = true;
        $msg = '';
        
        // Handle file upload
        $file = $this->request->getFile('file');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Validasi ukuran dan tipe file
            if ($file->getSize() > 1024000) { // 1MB
                $success = false;
                $msg = 'File size exceeds maximum allowed (1MB)';
            } elseif (!in_array($file->getClientExtension(), ['jpg', 'jpeg', 'png'])) {
                $success = false;
                $msg = 'Only JPG, JPEG, and PNG files are allowed';
            } else {
                // Validasi dimensi gambar
                $imageInfo = getimagesize($file->getTempName());
                if ($imageInfo[0] > 250 || $imageInfo[1] > 250) {
                    $success = false;
                    $msg = 'Image dimensions should be 250x250px maximum';
                } else {
                    $newName = $file->getRandomName();
                    $file->move(ROOTPATH . 'assets/uploads', $newName);
                    $insertarray['s_logo'] = $newName;
                }
            }
        }

        if ($success) {
            $builder = $this->db->table('settings');
            $ws = $builder->countAllResults();
            
            if ($ws == 0) {
                $builder->insert($insertarray);
            } else {
                $builder->update($insertarray);
            }
            
            return redirect()->to('settings/websitesetting')->with('successmessage', 'Setting saved successfully!');
        } else {
            return redirect()->back()->withInput()->with('warningmessage', $msg);
        }
    }

    public function logodelete()
    {
        $builder = $this->db->table('settings');
        $builder->update(['s_logo' => '']);
        
        return $this->response->setJSON(true);
    }
}