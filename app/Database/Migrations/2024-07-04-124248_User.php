<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
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
            'unique'                          => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'code'                          => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
                'character set'                 => 'utf8',
                'collate'                       => 'utf8_bin',
            ],
            'password'                      => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'role_id'                       => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'supervisor_id'                 => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'act_approve'                   => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'act_limit'                     => [
                'type'                          => 'DECIMAL',
                'constraint'                    => [20, 2],
                'default'                       => '0',
            ],
            'act_button'                    => [ // Create Read Update Delete Confirm Active
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
                'default'                       => '000000',
            ],
            'act_access'                    => [ // Company Region Division Salary Project Branch Tools Land Supervisor Filter
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
                'default'                       => '0000000000',
            ],
            'company'                       => [
                'type'                          => 'TEXT',
            ],
            'region'                        => [
                'type'                          => 'TEXT',
            ],
            'division'                      => [
                'type'                          => 'TEXT',
            ],
            'salary'                        => [
                'type'                          => 'TEXT',
            ],
            'project'                       => [
                'type'                          => 'TEXT',
            ],
            'branch'                        => [
                'type'                          => 'TEXT',
            ],
            'tool'                          => [
                'type'                          => 'TEXT',
            ],
            'land'                          => [
                'type'                          => 'TEXT',
            ],
            'cash'                      => [
                'type'                          => 'TEXT',
            ],
            'token_id'                      => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'is_reset'                      => [
                'type'                          => 'BOOLEAN',
                'default'                       => false,
            ],
            'dashboard'                     => [ // card dashboard
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
                'default'                       => 'user,sale,employee,sales',
            ],
            'template'                      => [ // layout language theme mode : vertical,indonesia,default,light
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
                'default'                       => 'vertical,english,default,light',
            ],
            'shortcut'                      => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'set_default'                   => [ // Company Region Division Object
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
                'default'                       => '0,0,0,-',
            ],
            'picture'                       => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
                'default'                       => 'photo.png',
            ],
            'picture_line'                  => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
                'default'                       => '01.jpg',
            ],
            'adaptation'                    => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
                'default'                       => '100',
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
        $this->forge->createTable('m_user');
    }

    public function down()
    {
        $this->forge->dropTable('m_user');
    }
}
