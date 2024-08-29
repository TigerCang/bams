<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Biaya extends Migration
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
            'induk_id'              => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'kate_id'               => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'kode'                  => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'matabayar'             => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'nama'                  => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'satuan'                => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'level'                 => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'akun_id'               => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'is_jumlah'             => [
                'type'                  => 'BOOLEAN',
                'default'               => false,
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
        $this->forge->createTable('m_biaya');
    }

    public function down()
    {
        $this->forge->dropTable('m_biaya');
    }
}
