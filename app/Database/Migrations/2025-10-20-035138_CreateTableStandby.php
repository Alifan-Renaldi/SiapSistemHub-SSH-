<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableStandby extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'sb_id' => [
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => true,
            'auto_increment' => true,
            ],
            'sb_code' => [
            'type' => 'VARCHAR',
            'constraint' => '50',
            'null' => false,
            ],
            'sb_tanggal' => [
            'type' => 'DATE',
            'null' => false,
            ],
            'sb_lokasi' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
                'default' => 'None',
            ],
            'sb_nopol' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'sb_jenis' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'sb_supirutama' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'sb_supirpengganti' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'sb_keterangan' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => false,
            ],
            'sb_created_by' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'sb_created_date' => [
                'type' => 'timestamp',
            ],
            'sb_modified_date' => [
            'type' => 'DATETIME',
            'null' => false,
            ],
        ]);

        $this->forge->addKey('sb_id', true);
        $this->forge->createTable('standby', true, [
            'ENGINE' => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_unicode_ci'
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('standby');
    }
}
