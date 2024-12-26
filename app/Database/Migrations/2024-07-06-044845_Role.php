<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Role extends Migration
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
            'name'                          => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'menu_1'                        => [
                'type'                          => 'TEXT',
            ],
            'menu_2'                        => [
                'type'                          => 'TEXT',
            ],
            'menu_3'                        => [
                'type'                          => 'TEXT',
            ],
            'menu_4'                        => [
                'type'                          => 'TEXT',
            ],
            'menu_5'                        => [
                'type'                          => 'TEXT',
            ],
            'menu_6'                        => [
                'type'                          => 'TEXT',
            ],
            'menu_7'                        => [
                'type'                          => 'TEXT',
            ],
            'menu_8'                        => [
                'type'                          => 'TEXT',
            ],
            'menu_9'                        => [
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
        $this->forge->createTable('m_role');
    }

    public function down()
    {
        $this->forge->dropTable('m_role');
    }
}
