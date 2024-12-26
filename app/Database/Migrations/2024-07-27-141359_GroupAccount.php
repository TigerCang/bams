<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class GroupAccount extends Migration
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
            'source'                        => [
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
            'value'                         => [
                'type'                          => 'DECIMAL',
                'constraint'                    => [20, 2],
                'default'                       => '0',
            ],
            'company_id'                    => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'account1_id'                   => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'account2_id'                   => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'account3_id'                   => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'account4_id'                   => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'account5_id'                   => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'notes'                         => [
                'type'                          => 'TEXT',
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
        $this->forge->createTable('group_account');
    }

    public function down()
    {
        $this->forge->dropTable('group_account');
    }
}
