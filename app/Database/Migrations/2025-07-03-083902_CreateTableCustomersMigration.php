<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableCustomersMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'c_id' => [
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => true,
            'auto_increment' => true,
        ],
            'c_name' => [
                'type' => 'VARCHAR',
                'constraint' => '256',
                'null' => false,
                'default' => 'None',
            ],
            'c_mobile' => [
                'type' => 'VARCHAR',
                'constraint' => '15',
                'null' => false,
                'default' => 'None',
            ],
            'c_email' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'c_address' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => false,
                'default' => 'None',
            ],
            'c_created_date' => [
            'type' => 'DATETIME',
            'null' => false,
            ],
            'c_pwd' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
                'default' => 'null',
            ],
            'c_isactive' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
                'default' => 1,
            ],
            'c_modified_date' => [
                'type' => 'timestamp',
            ],
        ]);

        $this->forge->addKey('c_id', true);
        $this->forge->createTable('customers', true, [
            'ENGINE' => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_unicode_ci'
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('customers');
    }
}
