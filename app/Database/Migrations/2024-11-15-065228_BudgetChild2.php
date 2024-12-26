<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BudgetChild2 extends Migration
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
            'object_id'                     => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'segment_id'                    => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'parent_cost'                   => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'resource_id'                   => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
                'default'                       => '0',
            ],
            'frequency'                     => [
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
        $this->forge->createTable('budget_child2');
    }

    public function down()
    {
        $this->forge->dropTable('budget_child2');
    }
}
