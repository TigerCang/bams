<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Person extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                            => [
                'type'                          => 'BIGINT',
                'constraint'                    => 20,
                'unsigned'                      => true,
                'auto_increment'                => true,
            ],
            'unique'                        => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'code'                          => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'eid'                           => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'name'                          => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'category'                      => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'branch_id'                     => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'location'                      => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'gender'                        => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'blood'                         => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'birth_place'                   => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'birth_date'                    => [
                'type'                          => 'DATE',
            ],
            'address'                       => [
                'type'                          => 'TEXT',
            ],
            'contact'                       => [
                'type'                          => 'TEXT',
            ],
            'email'                         => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'diploma'                       => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'major'                         => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'diploma_st'                    => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'diploma_date'                  => [
                'type'                          => 'DATE',
            ],
            'license_type'                  => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'license_number'                => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'license_date'                  => [
                'type'                          => 'DATE',
            ],
            'worker'                        => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'join_date'                     => [
                'type'                          => 'DATE',
            ],
            'employee_st'                   => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'contract_date_1'               => [
                'type'                          => 'DATE',
            ],
            'contract_date_2'               => [
                'type'                          => 'DATE',
            ],
            'out_select'                    => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'out_date'                      => [
                'type'                          => 'DATE',
            ],
            'out_reason'                    => [
                'type'                          => 'TEXT',
            ],
            'salary_id'                     => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'position_id'                   => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'class_id'                      => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'user_id'                       => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'supervisor_id'                 => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'insurance'                     => [
                'type'                          => 'TEXT',
            ],
            'is_alias'                      => [ // Customer Supplier Lain Employee OSM (operator, driver, mechanic)
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
                'default'                       => '00000',
            ],
            'group_account_customer'        => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'group_account_supplier'        => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'group_account_partner'         => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'group_account_employee'        => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'company_id'                    => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'region_id'                     => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'division_id'                   => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'picture'                       => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
                'default'                       => 'default.png',
            ],
            'notes'                         => [
                'type'                          => 'TEXT',
            ],
            'adaptation'                    => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'save_by'                       => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'confirm_by'                    => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'active_by'                     => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'created_at'                    => [
                'type'                          => 'DATETIME',
                'null'                          => true,
            ],
            'updated_at'                    => [
                'type'                          => 'DATETIME',
                'null'                          => true,
            ],
            'deleted_at'                    => [
                'type'                          => 'DATETIME',
                'null'                          => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('m_person');
    }

    public function down()
    {
        $this->forge->dropTable('m_person');
    }
}
