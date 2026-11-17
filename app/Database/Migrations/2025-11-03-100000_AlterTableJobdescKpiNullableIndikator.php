<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTableJobdescKpiNullableIndikator extends Migration
{
    public function up()
    {
        $fields = [];

        for ($i = 1; $i <= 12; $i++) {
            $fields["jk_indikator_{$i}"] = [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
                'default' => null,
            ];
            $fields["jk_bobot_{$i}"] = [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'null' => true,
                'default' => null,
            ];
        }

        $this->forge->modifyColumn('jobdesc_kpi', $fields);
    }

    public function down()
    {
        $fields = [];

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
        }

        $this->forge->modifyColumn('jobdesc_kpi', $fields);
    }
}
