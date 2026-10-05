<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Users extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session = session();
        helper(['form', 'url']);
    }

    public function index()
    {
        $data['userlist'] = $this->userModel->getall_user();
        return view('users/user_management', $data);
    }

    public function adduser()
    {
        return view('users/user_add');
    }

    public function insertuser()
    {
        $userData = [
            'u_name' => $this->request->getPost('u_name'),
            'u_username' => $this->request->getPost('u_username'),
            'u_email' => $this->request->getPost('u_email'),
            'u_password' => $this->request->getPost('basic[u_password]'),
            'u_is_status' => $this->request->getPost('basic[u_is_status]') ?? 1
        ];

        $roleData = $this->request->getPost('permissions');

        $this->userModel->add_user($userData, $roleData);
        return redirect()->to('users/user_management')->with('success', 'User berhasil ditambahkan');
    }

    public function edituser($u_id)
    {
        $userdetails = $this->userModel->get_userdetails($u_id);
        $data['userdetails'] = !empty($userdetails) ? $userdetails[0] : [];
        $data['user'] = !empty($userdetails) ? $userdetails[0] : [];
        return view('users/user_add', $data);
    }

    public function updateuser()
    {
    $u_id = $this->request->getPost('u_id');
    
    $userData = [
        'u_name' => $this->request->getPost('u_name'),
        'u_username' => $this->request->getPost('u_username'),
        'u_email' => $this->request->getPost('u_email'),
        'u_is_status' => $this->request->getPost('basic[u_is_status]') ?? 1
    ];

    $newPassword = $this->request->getPost('new_password');
    if (!empty($newPassword)) {
        $userData['u_password'] = password_hash($newPassword, PASSWORD_BCRYPT);
    }

    $roleData = $this->request->getPost('permissions');
    
    $this->userModel->update_user($u_id, $userData, $roleData);
    
    return redirect()->to('users/user_management')->with('success', 'User berhasil diupdate');
    }

    public function deleteuser($u_id)
    {
        if (!$this->request->is('post')) {
        return redirect()->to('users/user_management');
        }

        $returndata = $this->userModel->user_delete($u_id);
        if ($returndata) {
            return redirect()->to('users/user_management')->with('successmessage', 'User deleted successfully.');
        } else {
            return redirect()->to('users/user_management')->with('warningmessage', 'Error! User is still in use.');
        }
    }
     
}