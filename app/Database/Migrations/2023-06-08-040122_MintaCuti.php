<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MintaCuti extends Migration
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
            'cuti_id'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'tgl_minta'        => [
                'type'           => 'DATE',
            ],
            'tgl_cuti1'        => [
                'type'           => 'DATE',
            ],
            'tgl_cuti2'        => [
                'type'           => 'DATE',
            ],
            'lama'        => [
                'type'           => 'INT',
                'constraint'     => 5,
                'default'        => '1',
            ],
            'potong'        => [
                'type'           => 'VARCHAR',
                'constraint'     => 10,
            ],
            'status'        => [
                'type'           => 'VARCHAR',
                'constraint'     => 10,
            ],
            'catatan'        => [
                'type'           => 'TEXT',
                'null'             => true,
            ],
            'st_atasan'  => [
                'type'           => 'VARCHAR',
                'constraint'     => 10,
            ],
            'st_hrd'  => [
                'type'           => 'VARCHAR',
                'constraint'     => 10,
            ],
            'st_bos'        => [
                'type'           => 'VARCHAR',
                'constraint'     => 10,
            ],
            'lampiran'        => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
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
        $this->forge->createTable('hrd_cuti');
    }

    public function down()
    {
        $this->forge->dropTable('hrd_cuti');
    }
}
