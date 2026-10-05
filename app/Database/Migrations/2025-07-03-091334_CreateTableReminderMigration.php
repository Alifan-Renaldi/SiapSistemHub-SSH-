<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableReminderMigration extends Migration
{
    public function up()
    {
        
        $this->forge->addField([
            'r_id' => [
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => true,
            'auto_increment' => true,
        ],
            'r_v_id' => [
                'type' => 'VARCHAR',
                'constraint' => '11',
                'null' => false,
                'default' => 'None',
            ],
            'r_date' => [
            'type' => 'DATE',
            'null' => false,
        ],
        'r_message' => [
                'type' => 'VARCHAR',
                'constraint' => '256',
                'null' => false,
                'default' => 'None',
            ],
            'r_isread' => [
                'type' => 'VARCHAR',
                'constraint' => '11',
                'null' => false,
                'default' => 0,
            ],
            't_trip_fromlat' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'r_created_date' => [
            'type' => 'timestamp',
        ],
        ]);

        $this->forge->addKey('r_id', true);
        $this->forge->createTable('reminder', true, [
            'ENGINE' => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_unicode_ci'
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('reminder');
    }
}
