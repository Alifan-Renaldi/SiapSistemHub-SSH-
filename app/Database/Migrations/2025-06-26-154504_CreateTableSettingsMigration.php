<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableSettingsMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            's_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            's_companyname' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
                'default' => true,
            ],
            's_address' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
                'default' => true,
            ],
            's_inovice_prefix' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            's_logo' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            's_price_prefix' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            's_inovice_termsandcondition' => [
                'type' => 'VARCHAR',
                'constraint' => '256',
            ],
            's_inovice_servicename' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            's_googel_api_key' => [
                'type' => 'VARCHAR',
                'constraint' => '256',
            ],
        ]);

        $this->forge->addKey('s_id', true);
        $this->forge->createTable('settings', true, [
            'ENGINE' => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_unicode_ci'
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('settings');
    }
}
