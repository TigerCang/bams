<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CashChild2 extends Migration // Extra detail
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
            'child_id'                     => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
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
            'saldo'                        => [
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
        $this->forge->createTable('cash_child2');
    }

    public function down()
    {
        $this->forge->dropTable('cash_child2');
    }
}
