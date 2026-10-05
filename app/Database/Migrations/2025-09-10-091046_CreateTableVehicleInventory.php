<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableVehicleInventory extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'iv_id' => [
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => true,
            'auto_increment' => true,
            ],
            'iv_code' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'iv_nopol' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'iv_jenis' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'iv_tahun' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => false,
            ],
            'iv_stnk' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'iv_kir' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'iv_kabin' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'iv_dongkrak' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'iv_kunci' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'iv_stang' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'iv_spanner' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'iv_serep' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'iv_gantungan' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'iv_ramkk' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'iv_ramdb' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'iv_karpetd' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'iv_karpetb' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'iv_tambang' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'iv_tarpolin' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'iv_plastik' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'iv_lidah' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'iv_badong' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'iv_kojong' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'iv_jumlah' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'iv_fotod' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => false,
            ],
            'iv_fotob' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => false,
            ],
            'iv_fotokn' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => false,
            ],
            'iv_fotokr' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => false,
            ],
            'iv_keterangan' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => false,
            ],
            'iv_created_by' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'iv_created_date' => [
                'type' => 'timestamp',
            ],
            'iv_modified_date' => [
            'type' => 'DATETIME',
            'null' => false,
            ],
        ]);

        $this->forge->addKey('iv_id', true);
        $this->forge->createTable('inventorys', true, [
            'ENGINE' => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_unicode_ci'
        ]);
    }

    public function down()
    {
         $this->forge->dropTable('inventorys');
    }
}
