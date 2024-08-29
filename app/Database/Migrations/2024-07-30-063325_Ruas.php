<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Ruas extends Migration
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
                'type'                   => 'VARCHAR',
                'constraint'             => 255,
            ],
            'param'                 => [
                'type'                   => 'VARCHAR',
                'constraint'             => 255,
            ],
            'proyek_id'             => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'ruas_id'               => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'cabang_id'             => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'kode'                  => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'nama'                  => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'jarak'                 => [
                'type'                  => 'BIGINT',
                'constraint'            => 20,
                'unsigned'              => true,
                'default'               => '0',
            ],
            'catatan'               => [
                'type'                  => 'TEXT',
            ],
            'kondisi'               => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'save_by'               => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'conf_by'               => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'aktif_by'              => [
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
        $this->forge->createTable('m_ruas');
    }

    public function down()
    {
        $this->forge->dropTable('m_ruas');
    }
}
