<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Company2 extends Migration
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
            'status'                        => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'address'                       => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'city'                          => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'phone'                         => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'fax'                           => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'email'                         => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'tax_number'                    => [
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
        $this->forge->createTable('company_address');
    }

    public function down()
    {
        $this->forge->dropTable('company_address');
    }
}
