<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Serial extends Migration
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
            'item_id'                       => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'serial'                     => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'price'                         => [
                'type'                          => 'DECIMAL',
                'constraint'                    => [20, 2],
                'default'                       => '0',
            ],
            'tool_id'                       => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'repair'                        => [
                'type'                          => 'BIGINT',
                'constraint'                    => 20,
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
        $this->forge->createTable('m_serial');
    }

    public function down()
    {
        $this->forge->dropTable('m_serial');
    }
}
