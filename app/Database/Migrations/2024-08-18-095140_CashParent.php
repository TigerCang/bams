<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CashParent extends Migration
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
            'source'                        => [ // from direct cash dll
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'object'                        => [
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
            'object_id'                     => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'document_number'               => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'person_id'                     => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'role_as'                       => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'standard_id'                   => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'date_request'                    => [
                'type'                          => 'DATE',
            ],
            'date_in'                       => [
                'type'                          => 'DATE',
            ],
            'revision'                      => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'level'                         => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'status'                        => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'period'                        => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'is_journal'                    => [
                'type'                          => 'VARCHAR', //ju - ajp ; in - out
                'constraint'                    => 255,
                'default'                       => 'ju,out',
            ],
            'is_ok'                         => [
                'type'                          => 'VARCHAR', //000 1. level 2. accounting 3. after cashier
                'constraint'                    => 255,
            ],
            'is_tax'                        => [
                'type'                          => 'BOOLEAN',
                'default'                       => false,
            ],
            'attachment'                    => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'request_by'                    => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'save_by'                       => [
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
        $this->forge->createTable('cash_parent');
    }

    public function down()
    {
        $this->forge->dropTable('cash_parent');
    }
}
