<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableIncomeExpenseMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ie_id' => [
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => true,
            'auto_increment' => true,
        ],
            'ie_v_id' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'ie_date' => [
            'type' => 'DATE',
            'null' => false,
        ],
        'ie_type' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'ie_description' => [
                'type' => 'VARCHAR',
                'constraint' => '256',
                'null' => false,
                'default' => 'None',
            ],
            'ie_amount' => [
            'type' => 'INT',
            'constraint' => 11,
        ],
            'ie_modified_date' => [
                'type' => 'timestamp',
            ],
            'ie_created_date' => [
            'type' => 'DATETIME',
            'null' => false,
        ],
        ]);

        $this->forge->addKey('ie_id', true);
        $this->forge->createTable('incomeexpense', true, [
            'ENGINE' => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_unicode_ci'
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('incomeexpense');
    }
}
