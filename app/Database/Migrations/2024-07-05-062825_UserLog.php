<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserLog extends Migration
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
            'username'                      => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'menu'                          => [ // optional 
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'action'                        => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'data'                          => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'notes'                         => [
                'type'                          => 'TEXT',
            ],
            'source'                        => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
                'default'                       => 'a',
            ],
            'web_address'                   => [
                'type'                          => 'TEXT',
            ],
            'ip_address'                    => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'user_agent'                    => [ // Browser OS Device
                'type'                          => 'TEXT',
            ],
            'last_act'                      => [
                'type'                          => 'BIGINT',
                'constraint'                    => 20,
                'unsigned'                      => true,
            ],
            'created_at'                    => [
                'type'                          => 'DATETIME',
                'null'                          => true,
            ],
            'updated_at'                    => [
                'type'                          => 'DATETIME',
                'null'                          => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('user_log');
    }

    public function down()
    {
        $this->forge->dropTable('user_log');
    }
}
