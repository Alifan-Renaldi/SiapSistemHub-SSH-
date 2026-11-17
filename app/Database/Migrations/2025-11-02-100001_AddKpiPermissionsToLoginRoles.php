<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKpiPermissionsToLoginRoles extends Migration
{
    public function up()
    {
        $columns = [
            'lr_kpi_list',
            'lr_kpi_pending_list',
            'lr_kpi_add',
            'lr_kpi_add_nilai',
            'lr_kpi_edit',
            'lr_kpi_view',
            'lr_kpi_delete',
        ];

        $fields = [];
        foreach ($columns as $column) {
            $fields[$column] = [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
                'default' => 0,
            ];
        }

        $this->forge->addColumn('login_roles', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('login_roles', [
            'lr_kpi_list',
            'lr_kpi_pending_list',
            'lr_kpi_add',
            'lr_kpi_add_nilai',
            'lr_kpi_edit',
            'lr_kpi_view',
            'lr_kpi_delete',
        ]);
    }
}
