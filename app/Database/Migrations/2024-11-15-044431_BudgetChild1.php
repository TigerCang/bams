<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BudgetChild1 extends Migration
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
            'budget_id'                     => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
                'default'                       => '0',
            ],
            'cost_id'                       => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
                'default'                       => '0',
            ],
            'account_id'                    => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
                'default'                       => '0',
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
            'price_contract'                => [
                'type'                          => 'DECIMAL',
                'constraint'                    => [20, 2],
                'default'                       => '0',
            ],
            'price_work'                    => [
                'type'                          => 'DECIMAL',
                'constraint'                    => [20, 2],
                'default'                       => '0',
            ],
            'total_contract'                => [
                'type'                          => 'DECIMAL',
                'constraint'                    => [20, 2],
                'default'                       => '0',
            ],
            'total_work'                    => [
                'type'                          => 'DECIMAL',
                'constraint'                    => [20, 2],
                'default'                       => '0',
            ],
            'group_industry'                => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
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
        $this->forge->createTable('budget_child1');
    }

    public function down()
    {
        $this->forge->dropTable('budget_child1');
    }
}
