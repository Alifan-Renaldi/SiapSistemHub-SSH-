<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTableLoginRoles extends Migration
{
    public function up()
    {
        $this->forge->addColumn('login_roles', [
        'lr_vech_add' => [
            'type' => 'INT',
            'constraint' => 11,
            'default' => 0,
            'null' => false,
        ],
    ]);

        $this->forge->modifyColumn('login_roles', [
            'lr_id' => [
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => true,
            'auto_increment' => true,
        ],
        'lr_u_id' => [
            'type' => 'INT',
            'constraint' => 11,
            'null' => false,
        ],
        'lr_vech_list' => [
            'type' => 'INT',
            'constraint' => 11,
            'default' => 0,
            'null' => false,
        ],
        'lr_vech_list_view' => [
            'type' => 'INT',
            'constraint' => 11,
            'default' => 0,
            'null' => false,
        ],
        'lr_vech_list_edit' => [
            'type' => 'INT',
            'constraint' => 11,
            'default' => 0,
            'null' => false,
        ],
        ]);

        $this->forge->addKey('lr_id', true);
    }

    public function down()
    {
        $this->forge->dropColumn('login_roles', 'lr_vech_add');
    }
}
