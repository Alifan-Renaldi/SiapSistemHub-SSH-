<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTableTrainingsTrNisLength extends Migration
{
    public function up()
    {
        $fields = [
            'tr_nis' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => false,
                'default'    => 'None',
            ],
        ];

        $this->forge->modifyColumn('trainings', $fields);
    }

    public function down()
    {
        $fields = [
            'tr_nis' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => false,
                'default'    => 'None',
            ],
        ];

        $this->forge->modifyColumn('trainings', $fields);
    }
}
