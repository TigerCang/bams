<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Budget2 extends Migration
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
            'parent_id'                     => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'cost_id'                       => [
                'type'                          => 'BIGINT',
                'constraint'                    => 20,
                'unsigned'                      => true,
            ],
            'account_id'                    => [
                'type'                          => 'BIGINT',
                'constraint'                    => 20,
                'unsigned'                      => true,
            ],
            'month'                         => [
                'type'                          => 'DECIMAL',
                'constraint'                    => [20, 2],
                'default'                       => '0',
            ],
            'quantity'                      => [
                'type'                          => 'DECIMAL',
                'constraint'                    => [20, 4],
                'default'                       => '0',
            ],
            'price'                         => [
                'type'                          => 'DECIMAL',
                'constraint'                    => [20, 2],
                'default'                       => '0',
            ],
            'total'                         => [
                'type'                          => 'DECIMAL',
                'constraint'                    => [20, 2],
                'default'                       => '0',
            ],
            'level'                         => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'notes'                         => [
                'type'                          => 'TEXT',
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
        $this->forge->createTable('m_budget2');
    }

    public function down()
    {
        $this->forge->dropTable('m_budget2');
    }
}
