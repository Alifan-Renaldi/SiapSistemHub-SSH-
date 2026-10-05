<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableLoansMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'l_id' => [
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => true,
            'auto_increment' => true,
        ],
        'l_tanggal' => [
            'type' => 'DATE',
            'null' => false,
        ],
        'l_nis' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
                'default' => 'None',
            ],
            'l_supir' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'l_nopol' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
                'default' => 'None',
            ],
            'l_potong' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'null' => false,
                'default' => 'None',
            ],
            'l_nominal' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'l_keterangan' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => false,
                'default' => 'None',
            ],
            'l_is_status' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'l_paid' => [
            'type' => 'DATE',
            'null' => false,
        ],
        'l_created_by' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'l_created_date' => [
                'type' => 'timestamp',
            ],
            'l_modified_date' => [
            'type' => 'DATETIME',
            'null' => false,
        ],
        ]);

        $this->forge->addKey('l_id', true);
        $this->forge->createTable('loans', true, [
            'ENGINE' => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_unicode_ci'
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('loans');
    }
}
