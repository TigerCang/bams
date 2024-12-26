<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CashChild1 extends Migration // Main cost
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
            'source'                        => [ //cost dll
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'parent_id'                     => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'detail_id'                     => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'extra'                         => [ // secret 0 false 1 true
                'type'                          => 'BOOLEAN',
                'default'                       => false,
            ],
            'segment_id'                    => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'budget_id'                     => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'cost_id'                       => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
                'default'                       => '0',
            ],
            'resource_id'                   => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
                'default'                       => '0',
            ],
            'account_id'                    => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
                'default'                       => '0',
            ],
            'osm_id'                        => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
                'default'                       => '0',
            ],
            'item_id'                       => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
                'default'                       => '0',
            ],
            'quantity'                      => [
                'type'                          => 'DECIMAL',
                'constraint'                    => [20, 4],
            ],
            'price'                         => [
                'type'                          => 'DECIMAL',
                'constraint'                    => [20, 2],
            ],
            'debit'                         => [
                'type'                          => 'DECIMAL',
                'constraint'                    => [20, 2],
                'default'                       => '0',
            ],
            'credit'                        => [
                'type'                          => 'DECIMAL',
                'constraint'                    => [20, 2],
                'default'                       => '0',
            ],
            'notes'                         => [
                'type'                          => 'TEXT',
            ],
            'child_id'                      => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
                'default'                       => '0',
            ],
            'mode'                          => [
                'type'                          => 'VARCHAR', //a input, b1 change quantity, b2 change price, c pph
                'constraint'                    => 255,
                'default'                       => 'a',
            ],
            'in_pph'                        => [
                'type'                          => 'BOOLEAN',
                'default'                       => false,
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
        $this->forge->createTable('cash_child1');
    }

    public function down()
    {
        $this->forge->dropTable('cash_child1');
    }
}
