<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Cost extends Migration
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
            'parent_id'                     => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'category_id'                   => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'code'                          => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'pay_code'                      => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'name'                          => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'unit'                          => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'level'                         => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'account_id'                    => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'is_total'                      => [
                'type'                          => 'BOOLEAN',
                'default'                       => false,
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
        $this->forge->createTable('m_cost');
    }

    public function down()
    {
        $this->forge->dropTable('m_cost');
    }
}
