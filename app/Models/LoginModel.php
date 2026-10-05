<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'u_id';
    protected $allowedFields = ['u_username', 'u_password'];

    public function checkLogin($username, $password)
    {
        $query = $this->where('u_username', $username)->first();

        if ($query && password_verify($password, $query['u_password'])) {
            return $query;
        }

        return false;
    }

    public function getUserRoles($userId)
    {
        $builder = $this->db->table('login_roles');
        $roles = $builder->where('lr_u_id', $userId)
                         ->get()
                         ->getRowArray();

        $permissions = [];
        if ($roles) {
        foreach ($roles as $key => $value) {
            if (strpos($key, 'lr_') === 0 && $value == '1') {
                $permissions[] = $key;
            }
        }
    }

        return $permissions;
    }
}
