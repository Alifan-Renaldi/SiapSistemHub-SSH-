<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableVehicleGroup extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'gr_id' => [
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => true,
            'auto_increment' => true,
        ],
            'gr_name' => [
                'type' => 'VARCHAR',
                'constraint' => '256',
                'null' => false,
            ],
            'gr_desc' => [
                'type' => 'VARCHAR',
                'constraint' => '256',
                'null' => false,
            ],
            'gr_created_date' => [
                'type' => 'timestamp',
            ],
        ]);

        $this->forge->addKey('gr_id', true);
        $this->forge->createTable('vehicle_group', true, [
            'ENGINE' => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_unicode_ci'
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('vehicle_group');
    }
}
