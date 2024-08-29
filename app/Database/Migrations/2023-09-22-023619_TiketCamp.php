<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TiketCamp extends Migration
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
            'sojual_id'        => [
                'type'           => 'BIGINT',
                'constraint'     => 15,
                'unsigned'       => true,
            ],
            'sojual2_id'        => [
                'type'           => 'BIGINT',
                'constraint'     => 15,
                'unsigned'       => true,
            ],
            'sosewa_id'        => [
                'type'           => 'BIGINT',
                'constraint'     => 15,
                'unsigned'       => true,
            ],
            'sosewa2_id'        => [
                'type'           => 'BIGINT',
                'constraint'     => 15,
                'unsigned'       => true,
            ],
            'asal'        => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
                'null'             => true,
            ],
            'notiket'        => [
                'type'           => 'VARCHAR',
                'constraint'     => 10,
                'null'             => true,
            ],
            'lokasi_id'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'biaya_id'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'             => true,
            ],
            'gudang_id'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'barang_id'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'alat_id'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'alatperush_id'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'alatdiv_id'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'supir_id'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'supirperush_id'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'supirwil_id'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'supirdiv_id'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'tanggal'        => [
                'type'           => 'DATETIME',
            ],
            'jumlah'        => [
                'type'           => 'DECIMAL',
                'constraint'     => [20, 4],
                'default'        => '0',
            ],
            'catatan'        => [
                'type'           => 'TEXT',
                'null'             => true,
            ],
            'st_tiket'        => [
                'type'           => 'VARCHAR',
                'constraint'     => 10,
            ],
            'st_tagih'        => [
                'type'           => 'VARCHAR',
                'constraint'     => 10,
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
        $this->forge->createTable('tiket_camp');
    }

    public function down()
    {
        $this->forge->dropTable('tiket_camp');
    }
}
