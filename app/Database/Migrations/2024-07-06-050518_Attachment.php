<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Attachment extends Migration
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
            'object'                        => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'object_uniq'                   => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'title'                         => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'description'                   => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'ska'                           => [ // SKA SKT
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'level'                         => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'qualification'                 => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'registration_number'           => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'association'                   => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'year'                          => [
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
            'start_date'                    => [
                'type'                          => 'DATE',
                'default'                       => '1980-12-02',
            ],
            'end_date'                      => [
                'type'                          => 'DATE',
                'default'                       => '1980-12-02',
            ],
            'attachment'                    => [
                'type'                          => 'VARCHAR',
                'constraint'                    => 255,
            ],
            'is_active'                     => [
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
        $this->forge->createTable('m_attachment');
    }

    public function down()
    {
        $this->forge->dropTable('m_attachment');
    }
}
