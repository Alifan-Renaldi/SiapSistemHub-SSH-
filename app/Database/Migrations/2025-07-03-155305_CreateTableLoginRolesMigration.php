<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableLoginRolesMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'lr_id' => [
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => true,
            'auto_increment' => true,
        ],
        'lr_u_id' => [
            'type' => 'INT',
            'constraint' => 11,
        ],
        'lr_vech_list' => [
            'type' => 'INT',
            'constraint' => 11,
        ],
        ]);

        $this->forge->addKey('lr_id', true);
        $this->forge->createTable('login_roles', true, [
            'ENGINE' => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_unicode_ci'
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('login_roles');
    }
}
