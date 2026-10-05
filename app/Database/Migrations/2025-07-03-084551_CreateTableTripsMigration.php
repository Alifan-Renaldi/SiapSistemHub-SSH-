<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableTripsMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            't_id' => [
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => true,
            'auto_increment' => true,
        ],
            't_customer_id' => [
                'type' => 'VARCHAR',
                'constraint' => '11',
                'null' => false,
                'default' => 'None',
            ],
            't_vechicle' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            't_type' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            't_driver' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            't_start_date' => [
            'type' => 'DATE',
            'null' => false,
        ],
        't_end_date' => [
            'type' => 'DATE',
            'null' => false,
        ],
        't_trip_fromlocation' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            't_trip_tolocation' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            't_trip_fromlat' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
                'default' => 'null',
            ],
            't_trip_fromlog' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
                'default' => 'null',
            ],
            't_trip_tolat' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
                'default' => 'null',
            ],
            't_trip_tolog' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            't_totaldistance' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            't_trip_amount' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 0,
            ],
            '   t_trip_status' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
                'default' => 'ongoing',
            ],
            't_trackingcode' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
                'default' => 'null',
            ],
            't_created_by' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            't_modified_date' => [
                'type' => 'timestamp',
            ],
            't_created_date' => [
            'type' => 'DATETIME',
            'null' => false,
        ],
        ]);

        $this->forge->addKey('t_id', true);
        $this->forge->createTable('trips', true, [
            'ENGINE' => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_unicode_ci'
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('trips');
    }
}
