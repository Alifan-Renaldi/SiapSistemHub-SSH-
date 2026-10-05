<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableVehicleHandover extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ho_id' => [
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => true,
            'auto_increment' => true,
            ],
            'ho_code' => [
            'type' => 'VARCHAR',
            'constraint' => '50',
            'null' => false,
            ],
            'ho_tanggal' => [
            'type' => 'DATE',
            'null' => false,
            ],
            'ho_lokasi' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
                'default' => 'None',
            ],
            'ho_nopol' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_jenis' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_km' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
            'ho_solar' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_supirlama' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_supirbaru' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_kabin' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_kabel' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_lampubesar' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_lampurem' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_seindpn' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_seinblk' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_wiper' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_spion' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_tangki1' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_tangki2' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_bak' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_pintu' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_bandpnkr' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_bandpnkn' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_merkbankr' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_merkbankn' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_banblkkrlr' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_banblkknlr' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_merkbankrlr' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_merkbanknlr' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_banblkkrdlm' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_banblkkndlm' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_merkbankrdlm' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_merkbankndlm' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_bantrkkrlr' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_bantrkknlr' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_merkbantrkkrlr' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_merkbantrkknlr' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_bantrkkrdlm' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_bantrkkndlm' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_merkbantrkkrdlm' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_merkbantrkkndlm' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_velgdpnkr' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_velgdpnkn' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_merkukuranvelgdpnkr' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_merkukuranvelgdpnkn' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_velgblkkrlr' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_velgblkknlr' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_merkukuranvelgblkkrlr' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_merkukuranvelgblknlr' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_velgblkkrdlm' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_velgblkkndlm' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_merkukuranvelgblkkrdlm' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_merkukuranvelgblkndlm' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'ho_foto' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => false,
            ],
            'ho_keterangan' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => false,
            ],
            'ho_created_by' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'ho_created_date' => [
                'type' => 'timestamp',
            ],
            'ho_modified_date' => [
            'type' => 'DATETIME',
            'null' => false,
            ],
        ]);

        $this->forge->addKey('ho_id', true);
        $this->forge->createTable('handovers', true, [
            'ENGINE' => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_unicode_ci'
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('handovers');
    }
}
