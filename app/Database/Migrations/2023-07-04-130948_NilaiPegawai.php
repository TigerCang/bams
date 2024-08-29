<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class NilaiPegawai extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'BIGINT',
                'constraint'     => 15,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'idunik'     => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
            ],
            'perusahaan_id'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'wilayah_id'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'divisi_id'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'userid'        => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
            ],
            'pegawai_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'nodoc'        => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
            ],
            'tgl_nilai'        => [
                'type'           => 'DATE',
            ],
            'nilai'        => [
                'type'           => 'TEXT',
                'null'             => true,
            ],
            'catatan'        => [
                'type'           => 'TEXT',
                'null'             => true,
            ],
            'created_at'  => [
                'type'           => 'DATETIME',
                'null'             => true,
            ],
            'updated_at'  => [
                'type'           => 'DATETIME',
                'null'             => true,
            ],
            'deleted_at'  => [
                'type'           => 'DATETIME',
                'null'             => true,
            ],
        ]);
        $this->forge->addKey('id', true); //primary key
        $this->forge->createTable('hrd_nilai');
    }

    public function down()
    {
        $this->forge->dropTable('hrd_nilai');
    }
}
