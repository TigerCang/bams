<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Project extends Migration
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
            'project_name'                  => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'package_name'                  => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'on_name'                       => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'location'                      => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'province'                      => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'district'                      => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'owner'                         => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'scope'                         => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'pay_method'                    => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'category_id'                   => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'standard_id'                   => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'contract_date'                 => [
                'type'                          => 'DATE',
            ],
            'pho_date'                      => [
                'type'                          => 'DATE',
            ],
            'fho_date'                      => [
                'type'                          => 'DATE',
            ],
            'vat'                           => [
                'type'                          => 'DECIMAL',
                'constraint'                    => [10, 2],
                'default'                       => '0',
            ],
            'income_tax'                    => [
                'type'                          => 'DECIMAL',
                'constraint'                    => [10, 2],
                'default'                       => '0',
            ],
            'contract_value'                => [
                'type'                          => 'DECIMAL',
                'constraint'                    => [20, 2],
                'default'                       => '0',
            ],
            'additional_value'              => [
                'type'                          => 'DECIMAL',
                'constraint'                    => [20, 2],
            ],
            'extra_value'                   => [
                'type'                          => 'DECIMAL',
                'constraint'                    => [20, 2],
            ],
            'gross_value'                   => [
                'type'                          => 'DECIMAL',
                'constraint'                    => [20, 2],
                'default'                       => '0',
            ],
            'vat_value'                     => [
                'type'                          => 'DECIMAL',
                'constraint'                    => [20, 2],
                'default'                       => '0',
            ],
            'income_tax_value'              => [
                'type'                          => 'DECIMAL',
                'constraint'                    => [20, 2],
                'default'                       => '0',
            ],
            'net_value'                     => [
                'type'                          => 'DECIMAL',
                'constraint'                    => [20, 2],
                'default'                       => '0',
            ],
            'period_1'                      => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
                'default'                       => '2025',
            ],
            'period_2'                      => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
                'default'                       => '2025',
            ],
            'mode_year'                     => [
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
            'consultant'                    => [
                'type'                          => 'TEXT',
            ],
            'insurance'                     => [
                'type'                          => 'TEXT',
            ],
            'finance'                       => [
                'type'                          => 'TEXT',
            ],
            'implementation'                => [
                'type'                          => 'TEXT',
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
        $this->forge->createTable('m_project');
    }

    public function down()
    {
        $this->forge->dropTable('m_project');
    }
}
