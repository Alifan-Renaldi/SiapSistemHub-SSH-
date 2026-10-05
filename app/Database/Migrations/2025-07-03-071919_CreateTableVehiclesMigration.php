<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableVehiclesMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'v_id' => [
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => true,
            'auto_increment' => true,
        ],
            'v_registration_no' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
                'default' => 'None',
            ],
            'v_name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'v_legal' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'v_chassis_no' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
                'default' => 'None',
            ],
            'v_engine_no' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
                'default' => 'None',
            ],
            'v_uji_no' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => false,
                'default' => 'None',
            ],
            'v_type' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'v_color' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'v_mileageperlitre' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'v_is_active' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
                'default' => 1,
            ],
            'v_group' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
                'default' => 'None',
            ],
            'v_owner' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
                'default' => 'None',
            ],
            'v_reg_exp_date' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'v_stnk_expdate' => [
            'type' => 'DATE',
            'null' => true,
            'default' => null,
        ],
            'v_plat_expdate' => [
            'type' => 'DATE',
            'null' => true,
            'default' => null,
        ],
        'v_kir_expdate' => [
            'type' => 'DATE',
            'null' => true,
            'default' => null,
        ],
            'v_lokasi_kir' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'v_notes_lokasikir' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'v_insurance' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'v_polis_no' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => false,
                'default' => 'None',
            ],
            'v_exp_insurance' => [
            'type' => 'DATE',
            'null' => true,
            'default' => null,
        ],
            'v_notes' => [
                'type' => 'VARCHAR',
                'constraint' => '256',
                'null' => false,
                'default' => 'None',
            ],
            'v_api_url' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'v_api_username' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'v_api_password' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'v_created_by' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'v_created_date' => [
                'type' => 'timestamp',
                'null' => false,
                'default' => 'CURRENT_TIMESTAMP',
            ],
            'v_modified_date' => [
            'type' => 'DATETIME',
            'null' => true,
            'default' => null,
        ],
        ]);

        $this->forge->addKey('v_id', true);
        $this->forge->createTable('vehicles', true, [
            'ENGINE' => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_unicode_ci'
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('vehicles');
    }
}
