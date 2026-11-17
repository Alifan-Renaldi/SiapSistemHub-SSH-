<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddVehicleInactivePermissionToLoginRoles extends Migration
{
    public function up()
    {
        $this->forge->addColumn('login_roles', [
            'lr_vech_list_inactive' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
                'default' => 0,
            ],
        ]);

        $this->db->query('UPDATE login_roles SET lr_vech_list_inactive = lr_vech_list');
    }

    public function down()
    {
        $this->forge->dropColumn('login_roles', 'lr_vech_list_inactive');
    }
}
