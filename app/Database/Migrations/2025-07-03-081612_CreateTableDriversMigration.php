<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableDriversMigration extends Migration
{
    public function up()
    {
        
        $this->forge->addField([
            'd_id' => [
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => true,
            'auto_increment' => true,
        ],
            'd_nis' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
                'default' => 'None',
            ],
            'd_name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'd_nickname' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'd_pob' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'd_dob' => [
            'type' => 'DATE',
            'null' => false,
        ],
        'd_age' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'd_married' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
                'default' => 'None',
            ],
            'd_address' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => false,
                'default' => 'None',
            ],
            'd_province' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'd_city' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'd_subdistrict' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'd_village' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'd_mobile' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => false,
                'default' => 'None',
            ],
            'd_identityno' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => false,
                'default' => 'None',
            ],
            'd_identity_expdate' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'd_licenseno' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => false,
                'default' => 'None',
            ],
            'd_license_expdate' => [
            'type' => 'DATE',
            'null' => false,
        ],
        'd_cardbpjs' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
                'default' => 'None',
            ],
            'd_bpjsnotes' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => false,
                'default' => 'None',
            ],
            'd_education' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
                'default' => 'None',
            ],
            'd_experience' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'd_total_exp' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
                'default' => 'None',
            ],
            'd_infoexp' => [
                'type' => 'VARCHAR',
                'constraint' => '256',
                'null' => false,
                'default' => 'None',
            ],
            'd_expstatus' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'd_doj' => [
            'type' => 'DATE',
            'null' => false,
        ],
        'd_resigndate' => [
            'type' => 'DATE',
            'null' => false,
        ],
        'd_workperiod' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => false,
                'default' => 'None',
            ],
            'd_reason' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => false,
                'default' => 'None',
            ],
            'd_accountno' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
                'default' => 'None',
            ],
            'd_bank' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
                'default' => 'None',
            ],
            'd_accountname' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'd_ref' => [
                'type' => 'VARCHAR',
                'constraint' => '256',
                'null' => false,
                'default' => 'None',
            ],
            'd_is_active' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
                'default' => 1,
            ],
            'd_notes' => [
                'type' => 'VARCHAR',
                'constraint' => '256',
                'null' => false,
                'default' => 'None',
            ],
            'd_notes_blacklist' => [
                'type' => 'VARCHAR',
                'constraint' => '256',
                'null' => false,
                'default' => 'None',
            ],
            'd_docstatus' => [
                'type' => 'ENUM',
            'constraint' => ['null', 'complete', 'incomplete'],
            'null' => false
            ],
            'd_docremarks' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'd_photo' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => false,
                'default' => 'None',
            ],
            'd_pdf_document' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
                'default' => 'None',
            ],
            'd_created_by' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'default' => 'None',
            ],
            'd_created_date' => [
                'type' => 'timestamp',
            ],
            'd_modified_date' => [
            'type' => 'DATETIME',
            'null' => false,
        ],
        ]);

        $this->forge->addKey('d_id', true);
        $this->forge->createTable('drivers', true, [
            'ENGINE' => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_unicode_ci'
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('drivers');
    }
}
