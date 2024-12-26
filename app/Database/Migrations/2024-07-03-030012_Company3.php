<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Company3 extends Migration
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
            'company_id'                    => [
                'type'                          => 'BIGINT',
                'constraint'                    => 20,
                'unsigned'                      => true,
            ],
            'revision_notes'                => [ // if change ...
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'param'                         => [ // people, share
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'name'                          => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'identity'                      => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'position'                      => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'address'                       => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'quantity'                      => [
                'type'                          => 'DECIMAL',
                'constraint'                    => [20, 4],
            ],
            'price'                         => [
                'type'                          => 'DECIMAL',
                'constraint'                    => [20, 2],
            ],
            'is_use'                        => [
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
        $this->forge->createTable('company_person');
    }

    public function down()
    {
        $this->forge->dropTable('company_person');
    }
}
