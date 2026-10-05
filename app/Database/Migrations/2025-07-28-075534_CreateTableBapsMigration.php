<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableBapsMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'b_id' => [
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => true,
            'auto_increment' => true,
        ],
        'b_tanggal' => [
            'type' => 'DATE',
            'null' => true,
            'default' => NULL,
        ],
        'b_tanggal_kejadian' => [
            'type' => 'DATE',
            'null' => false,
        ],
        'b_nis' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
                'default' => 'None',
            ],
            'b_supir' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'b_nopol' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
                'default' => 'None',
            ],
            'b_muatan' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
                'default' => 'None',
            ],
            'b_keberangkatan' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
                'default' => 'None',
            ],
            'b_lokasi_muat' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
                'default' => 'None',
            ],
            'b_lokasi_bongkar' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
                'default' => 'None',
            ],
            'b_lokasi_kejadian' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
                'default' => 'None',
            ],
            'b_jenis_kasus' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
                'default' => 'None',
            ],
            'b_kondisi_barang' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'b_kronologi_kejadian' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => false,
                'default' => 'None',
            ],
            'b_korelasi_kasus' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => false,
                'default' => 'None',
            ],
            'b_estimasi_klaim' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'b_realisasi_klaim' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'b_potong_tagihan' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'null' => false,
                'default' => 'None',
            ],
            'b_cash' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'null' => false,
                'default' => 'None',
            ],
            'b_transfer' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'null' => false,
                'default' => 'None',
            ],
            'b_posisi_barang' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'b_klasifikasi' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'b_status_korban' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
                'default' => 'None',
            ],
            'b_keterangan' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => false,
                'default' => 'None',
            ],
            'b_document' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
                'default' => 'None',
            ],
            'b_pdf' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
                'default' => 'None',
            ],
            'b_is_status' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
        'b_created_by' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'b_created_date' => [
                'type' => 'timestamp',
            ],
            'b_modified_date' => [
            'type' => 'DATETIME',
            'null' => false,
        ],
        ]);

        $this->forge->addKey('b_id', true);
        $this->forge->createTable('baps', true, [
            'ENGINE' => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_unicode_ci'
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('baps');
    }
}
