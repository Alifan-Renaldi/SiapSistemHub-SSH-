<?php namespace App\Controllers;

use App\Models\LoginModel;
use CodeIgniter\Controller;

class Login extends Controller
{
    public function index()
    {
        $data = [];
        if (session()->getFlashdata('error')) {
            $data['error'] = session()->getFlashdata('error');
        }
        return view('login', $data);
    }

    public function auth()
    {
        $session = session();
        $loginModel = new LoginModel();
        $username = trim($this->request->getPost('username'));
        $password = trim($this->request->getPost('password'));

        if (empty($username) || empty($password)) {
            $session->setFlashdata('error', 'Username dan password harus diisi');
            return redirect()->to('/login');
        }

        $user = $loginModel->checkLogin($username, $password);

        if ($user) {
            $roles = $loginModel->getUserRoles($user['u_id']);

            $session->set([
                'user_id'     => $user['u_id'],
                'username'    => $user['u_username'],
                'name'        => $user['u_name'],
                'permissions' => $roles,
                'logged_in'   => true,
                'last_activity' => time(),
            ]);

            return redirect()->to('/dashboard');
        } else {
            // Login gagal
            $session->setFlashdata('error', 'Username atau password salah');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}