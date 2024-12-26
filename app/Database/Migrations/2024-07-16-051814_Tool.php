<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tool extends Migration
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
            'param'                         => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'partner_id'                    => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'code'                          => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'code2'                         => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'name'                          => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'model'                         => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'brand'                         => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'category'                      => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'type'                          => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'person_id'                     => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'resource_id'                   => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'standard_id'                   => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'group_account'                 => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'invoice'                       => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'index_fuel'                    => [
                'type'                          => 'DECIMAL',
                'constraint'                    => [12, 2],
                'default'                       => '1',
            ],
            'weight'                        => [
                'type'                          => 'DECIMAL',
                'constraint'                    => [12, 2],
                'default'                       => '1',
            ],
            'purchase_date'                 => [
                'type'                          => 'DATE',
            ],
            'manufacture_date'              => [
                'type'                          => 'DATE',
            ],
            'register_date'                 => [
                'type'                          => 'DATE',
            ],
            'departure_date'                => [
                'type'                          => 'DATE',
            ],
            'depreciation_mode'             => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'tool_age'                      => [
                'type'                          => 'BIGINT',
                'constraint'                    => 20,
                'unsigned'                      => true,
                'default'                       => '0',
            ],
            'remain'                        => [
                'type'                          => 'BIGINT',
                'constraint'                    => 20,
                'unsigned'                      => true,
                'default'                       => '0',
            ],
            'purchase_value'                => [
                'type'                          => 'DECIMAL',
                'constraint'                    => [20, 2],
                'default'                       => '0',
            ],
            'residual_value'                => [
                'type'                          => 'DECIMAL',
                'constraint'                    => [20, 2],
                'default'                       => '0',
            ],
            'rental_value'                  => [
                'type'                          => 'DECIMAL',
                'constraint'                    => [20, 2],
                'default'                       => '0',
            ],
            'depreciation_value'            => [
                'type'                          => 'DECIMAL',
                'constraint'                    => [20, 2],
                'default'                       => '0',
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
            'company2_id'                   => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'picture'                       => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
                'default'                       => 'default.png',
            ],
            'document'                      => [
                'type'                          => 'TEXT',
            ],
            'machine'                       => [
                'type'                          => 'TEXT',
            ],
            'transmission'                  => [
                'type'                          => 'TEXT',
            ],
            'notes'                         => [
                'type'                          => 'TEXT',
            ],
            'is_sale'                       => [
                'type'                          => 'BOOLEAN',
                'default'                       => false,
            ],
            'adaptation'                    => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'invoice_link'                  => [
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
        $this->forge->createTable('m_tool');
    }

    public function down()
    {
        $this->forge->dropTable('m_tool');
    }
}
