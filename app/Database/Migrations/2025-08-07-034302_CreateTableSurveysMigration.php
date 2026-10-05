<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableSurveysMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            's_id' => [
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => true,
            'auto_increment' => true,
        ],
        's_nis' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
                'default' => 'None',
            ],
            's_petugas' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
        's_tanggal' => [
            'type' => 'DATE',
            'null' => true,
            'default' => NULL,
        ],
        's_supir' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
        's_tanggal_masuk' => [
            'type' => 'DATE',
            'null' => false,
        ],
        
            
            's_referensi' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => false,
                'default' => 'None',
            ],
            's_nikah' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
                'default' => 'None',
            ],
            's_alamat' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => false,
                'default' => 'None',
            ],
            's_prov' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            's_kab' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            's_kec' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            's_kel' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            's_status_rumah' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            's_kondisi_rumah' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            's_penghuni' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => false,
                'default' => 'None',
            ],
            's_menetap' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            's_istri' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            's_pekerjaan_istri' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'null' => false,
                'default' => 'None',
            ],
            's_kendaraan' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => false,
                'default' => 'None',
            ],
            's_tanggungan' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => false,
                'default' => 'None',
            ],
            's_bapak' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => false,
                'default' => 'None',
            ],
            's_ibu' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => false,
                'default' => 'None',
            ],
            's_tetangga' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => false,
                'default' => 'None',
            ],
            's_saudara' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            's_alamat_saudara' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => false,
                'default' => 'None',
            ],
            's_telepon_istri' => [
                'type' => 'VARCHAR',
                'constraint' => '15',
                'null' => false,
                'default' => 'None',
            ],
            's_telepon_keluarga' => [
                'type' => 'VARCHAR',
                'constraint' => '15',
                'null' => false,
                'default' => 'None',
            ],
            's_keterangan' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => false,
                'default' => 'None',
            ],
            's_fotorumah' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
                'default' => 'None',
            ],
            's_is_status' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
        's_created_by' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            's_created_date' => [
                'type' => 'timestamp',
            ],
            's_modified_date' => [
            'type' => 'DATETIME',
            'null' => false,
        ],
        ]);

        $this->forge->addKey('s_id', true);
        $this->forge->createTable('surveys', true, [
            'ENGINE' => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_unicode_ci'
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('surveys');
    }
}
