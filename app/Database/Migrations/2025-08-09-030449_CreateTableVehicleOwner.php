<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableVehicleOwner extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ow_id' => [
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => true,
            'auto_increment' => true,
        ],
            'ow_name' => [
                'type' => 'VARCHAR',
                'constraint' => '256',
                'null' => false,
            ],
            'ow_desc' => [
                'type' => 'VARCHAR',
                'constraint' => '256',
                'null' => false,
            ],
            'ow_created_date' => [
                'type' => 'timestamp',
            ],
        ]);

        $this->forge->addKey('ow_id', true);
        $this->forge->createTable('vehicle_owner', true, [
            'ENGINE' => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_unicode_ci'
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('vehicle_owner');
    }
}
