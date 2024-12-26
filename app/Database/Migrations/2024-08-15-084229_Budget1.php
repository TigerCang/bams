<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Budget1 extends Migration
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
            'title'                         => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'source'                        => [ // income cost
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'object'                        => [ // project branch tool land
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'type'                          => [ //btl bn dll
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'total'                         => [
                'type'                          => 'DECIMAL',
                'constraint'                    => [20, 2],
                'default'                       => '0',
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
        $this->forge->createTable('m_budget1');
    }

    public function down()
    {
        $this->forge->dropTable('m_budget1');
    }
}
