<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableJobdescKpi extends Migration
{
    public function up()
    {
        $fields = [
            'jk_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'jk_divisi' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'jk_nama_karyawan' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'null' => false,
                'default' => 'None',
            ],
        ];

        for ($i = 1; $i <= 12; $i++) {
            $fields["jk_indikator_{$i}"] = [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
                'default' => 'None',
            ];
            $fields["jk_bobot_{$i}"] = [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'null' => false,
                'default' => 0,
            ];
            $fields["jk_nilai_{$i}"] = [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'null' => true,
                'default' => null,
            ];
        }

        $fields['jk_total_kpi'] = [
            'type' => 'DECIMAL',
            'constraint' => '5,2',
            'null' => true,
            'default' => null,
        ];
        $fields['jk_status'] = [
            'type' => 'VARCHAR',
            'constraint' => '50',
            'null' => true,
            'default' => null,
        ];
        $fields['jk_created_by'] = [
            'type' => 'VARCHAR',
            'constraint' => '100',
            'null' => false,
            'default' => 'None',
        ];
        $fields['jk_created_date'] = [
            'type' => 'timestamp',
            'null' => true,
        ];
        $fields['jk_modified_date'] = [
            'type' => 'DATETIME',
            'null' => true,
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('jk_id', true);
        $this->forge->createTable('jobdesc_kpi', true, [
            'ENGINE' => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_unicode_ci'
        ]);

        $this->db->query('ALTER TABLE `jobdesc_kpi` MODIFY `jk_created_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP');
    }

    public function down()
    {
        $this->forge->dropTable('jobdesc_kpi');
    }
}
