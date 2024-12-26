<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Item extends Migration
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
            'code'                          => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'part_number'                   => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'resource_id'                   => [
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
            'brand'                         => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'unit'                          => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'group_account'                 => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'min_stock'                     => [
                'type'                          => 'BIGINT',
                'constraint'                    => 20,
                'default'                       => '0',
            ],
            'price'                         => [
                'type'                          => 'DECIMAL',
                'constraint'                    => [20, 2],
                'default'                       => '0',
            ],
            'mode'                          => [ //serial second stock
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
                'default'                       => '000',
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
        $this->forge->createTable('m_item');
    }

    public function down()
    {
        $this->forge->dropTable('m_item');
    }
}
