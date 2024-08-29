<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Lampiran extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                    => [
                'type'                  => 'BIGINT',
                'constraint'            => 20,
                'unsigned'              => true,
                'auto_increment'        => true,
            ],
            'idunik'                => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'param'                 => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'judul'                 => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'deskripsi'               => [
                'type'                  => 'TEXT',
            ],
            'tanggal'               => [
                'type'                  => 'DATE',
                'default'               => '1980-12-02',
            ],
            'lampiran'              => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'save_by'               => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'created_at'            => [
                'type'                  => 'DATETIME',
                'null'                  => true,
            ],
            'updated_at'            => [
                'type'                  => 'DATETIME',
                'null'                  => true,
            ],
            'deleted_at'            => [
                'type'                  => 'DATETIME',
                'null'                  => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('m_lampiran');
    }

    public function down()
    {
        $this->forge->dropTable('m_lampiran');
    }
}
