<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'u_id';
    protected $allowedFields = ['u_name', 'u_username', 'u_password', 'u_email', 'u_is_status'];
    protected $returnType = 'array';

    public function getall_user()
    {
        return $this->db->table('users')
            ->select('*')
            ->orderBy('u_id', 'DE SC')
            ->get()
            ->getResultArray();
    }

    public function get_userdetails($u_id)
    {
        return $this->db->table('users')
            ->select('*')
            ->join('login_roles', 'users.u_id = login_roles.lr_u_id')
            ->where('users.u_id', $u_id)
            ->get()
            ->getResultArray();
    }

    public function add_user($userData, $roleData)
    {
        $userData['u_password'] = password_hash($userData['u_password'], PASSWORD_BCRYPT);
        
        $this->db->table('users')->insert($userData);
        $uid = $this->db->insertID();
        
        $roleData['lr_u_id'] = $uid;
        
        $this->db->table('login_roles')->insert($roleData);
        
        return $uid;
    }

    public function update_user($u_id, $userData, $roleData)
    {
        $this->db->table('users')
            ->where('u_id', $u_id)
            ->update($userData);
        
        $existingRole = $this->db->table('login_roles')
            ->where('lr_u_id', $u_id)
            ->countAllResults();
        
        if ($existingRole > 0) {
            $this->db->table('login_roles')
                ->where('lr_u_id', $u_id)
                ->update($roleData);
        } else {
            $roleData['lr_u_id'] = $u_id;
            $this->db->table('login_roles')->insert($roleData);
        }
        
        return true;
    }

   public function user_delete($u_id)
    {
        $this->db->transBegin();

        try {
            $user = $this->find($u_id);
            if (!$user) {
                return false;
            }
            $this->db->table('login_roles')->where('lr_u_id', $u_id)->delete();

            if ($this->useSoftDeletes) {
                $this->update($u_id, ['deleted_at' => date('Y-m-d H:i:s')]);
            } else {
                $this->where('u_id', $u_id)->delete();
            }

            if ($this->db->transStatus()) {
                $this->db->transCommit();
                return true;
            } else {
                $this->db->transRollback();
                return false;
            }
        } catch (\Exception $e) {
            $this->db->transRollback();
            log_message('error', 'Error deleting user: ' . $e->getMessage());
            return false;
        }
    }
}