<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Company1 extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                            => [
                'type'                          => 'BIGINT',
                'constraint'                    => 20,
                'unsigned'                      => true, // positive value only
                'auto_increment'                => true,
            ],
            'unique'                        => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'code'                          => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'initial'                       => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'name'                          => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'law1'                          => [
                'type'                          => 'TEXT',
            ],
            'law2'                          => [
                'type'                          => 'TEXT',
            ],
            'person_id'                     => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'picture'                       => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
                'default'                       => 'default.png',
            ],
            'is_tax'                        => [
                'type'                          => 'BOOLEAN',
                'default'                       => true,
            ],
            'adaptation'                    => [ // Readonly Confirm Active
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
        $this->forge->addKey('id', true); //primary key
        $this->forge->createTable('m_company');
    }

    public function down()
    {
        $this->forge->dropTable('m_company');
    }
}
