<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class File extends Migration
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
            'sub_param'                     => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'name'                          => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'name2'                         => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'company_id'                    => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'region_id'                     => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'division_id'                   => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'value'                         => [
                'type'                          => 'BIGINT',
                'constraint'                    => 20,
                'default'                       => '0',
            ],
            'set_default'                   => [
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
        $this->forge->createTable('m_file');
    }

    public function down()
    {
        $this->forge->dropTable('m_file');
    }
}
