<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CashChild3 extends Migration
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
            'child_id'                      => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'tax_number'                    => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'tax_period'                    => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'tax_object_id'                 => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'ni_dpp'                        => [
                'type'                          => 'DECIMAL',
                'constraint'                    => [20, 2],
            ],
            'tariff'                        => [
                'type'                          => 'DECIMAL',
                'constraint'                    => [10, 2],
            ],
            'ni_tax'                        => [
                'type'                          => 'DECIMAL',
                'constraint'                    => [20, 2],
            ],
            'document_ref'                  => [
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
        $this->forge->createTable('cash_child3');
    }

    public function down()
    {
        $this->forge->dropTable('cash_child3');
    }
}
