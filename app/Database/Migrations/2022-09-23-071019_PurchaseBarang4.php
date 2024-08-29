<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PurchaseBarang4 extends Migration
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
            'pominta_id'          => [
                'type'           => 'BIGINT',
                'constraint'     => 15,
                'unsigned'       => true,
            ],
            'penerima_id'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'nodoc'        => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
            ],
            'tgl_po'        => [
                'type'           => 'DATE',
            ],
            'tgl_masuk'        => [
                'type'           => 'DATE',
            ],
            'tgl_rekap'        => [
                'type'           => 'DATE',
            ],
            'tgl_lunas'        => [
                'type'           => 'DATE',
            ],
            'st_pajak'        => [
                'type'           => 'VARCHAR',
                'constraint'     => 10,
            ],
            'total1'        => [
                'type'           => 'DECIMAL',
                'constraint'     => [20, 3],
                'default'        => '0',
            ],
            'totppn'        => [
                'type'           => 'DECIMAL',
                'constraint'     => [20, 3],
                'default'        => '0',
            ],
            'total2'        => [
                'type'           => 'DECIMAL',
                'constraint'     => [20, 3],
                'default'        => '0',
            ],
            'buktibayar'        => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
            ],
            'level_aw'        => [
                'type'           => 'INT',
                'constraint'     => 2,
            ],
            'level_pos'        => [
                'type'           => 'INT',
                'constraint'     => 2,
            ],
            'aksi'        => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
                'null'             => true,
            ],
            'status'        => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
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
        $this->forge->createTable('po_pesan1');
    }

    public function down()
    {
        $this->forge->dropTable('po_pesan1');
    }
}
