<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableTrainingsMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'tr_id' => [
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => true,
            'auto_increment' => true,
        ],
        'tr_tanggal' => [
            'type' => 'DATE',
            'null' => false,
            'default' => 'None',
        ],
        'tr_nis' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
                'default' => 'None',
            ],
        'tr_supir' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'tr_kategori' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'tr_pemateri' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'tr_tema' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => false,
                'default' => 'None',
            ],
            'tr_lokasi' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
                'default' => 'None',
            ],
            'tr_keterangan' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => false,
                'default' => 'None',
            ],
        'tr_created_by' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'tr_created_date' => [
                'type' => 'timestamp',
            ],
            'tr_modified_date' => [
            'type' => 'DATETIME',
            'null' => false,
        ],
        ]);

        $this->forge->addKey('tr_id', true);
        $this->forge->createTable('trainings', true, [
            'ENGINE' => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_unicode_ci'
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('trainings');
    }
}
