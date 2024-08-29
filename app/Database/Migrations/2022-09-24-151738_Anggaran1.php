<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Anggaran1 extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => [
                'type'              => 'BIGINT',
                'constraint'        => 15,
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'idunik'        => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
            ],
            'user_id'       => [
                'type'               => 'INT',
                'constraint'         => 11,
                'unsigned'           => true,
            ],
            'last_id'       => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
            ],
            'pilihan'       => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
            ],
            'tujuan'        => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
            ],
            'jenis'         => [ //btl bn dll
                'type'              => 'VARCHAR',
                'constraint'        => 100,
            ],
            'perusahaan_id' => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
            ],
            'wilayah_id'    => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
            ],
            'divisi_id'     => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
            ],
            'beban_id'      => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
            ],
            'ruas_id'       => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
                'null'              => true,
            ],
            'nodoc'         => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
            ],
            'tanggal1'      => [
                'type'              => 'DATE',
                'null'              => true,
            ],
            'tanggal2'      => [
                'type'              => 'DATE',
                'null'              => true,
            ],
            'adendum'       => [
                'type'              => 'INT',
                'constraint'        => 2,
                'default'           => '0',
            ],
            'revisi'        => [
                'type'              => 'INT',
                'constraint'        => 2,
                'default'           => '0',
            ],
            'level_aw'      => [
                'type'              => 'INT',
                'constraint'        => 2,
            ],
            'level_pos'     => [
                'type'              => 'INT',
                'constraint'        => 2,
            ],
            'status'        => [
                'type'              => 'VARCHAR',
                'constraint'        => 10,
                'default'           => '0',
            ],
            'is_use'        => [
                'type'              => 'INT',
                'constraint'        => 2,
                'default'           => '0',
            ],
            'catatan'       => [
                'type'              => 'TEXT',
                'null'              => true,
            ],
            'created_at'    => [
                'type'              => 'DATETIME',
                'null'              => true,
            ],
            'updated_at'    => [
                'type'              => 'DATETIME',
                'null'              => true,
            ],
            'deleted_at'    => [
                'type'              => 'DATETIME',
                'null'              => true,
            ],
        ]);
        $this->forge->addKey('id', true); //primary key
        $this->forge->createTable('anggaran_induk');
    }

    public function down()
    {
        $this->forge->dropTable('anggaran_induk');
    }
}
