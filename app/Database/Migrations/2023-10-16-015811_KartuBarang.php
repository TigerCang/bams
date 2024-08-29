<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KartuBarang extends Migration
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
            'nodoc'        => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
            ],
            'masuk_id'          => [
                'type'           => 'BIGINT',
                'constraint'     => 15,
                'unsigned'       => true,
            ],
            'keluar_id'          => [
                'type'           => 'BIGINT',
                'constraint'     => 15,
                'unsigned'       => true,
            ],
            'barang_id'          => [
                'type'           => 'BIGINT',
                'constraint'     => 15,
                'unsigned'       => true,
            ],
            'gudang_id'              => [
                'type'               => 'INT',
                'constraint'         => 11,
                'unsigned'           => true,
            ],
            'tanggal'        => [
                'type'           => 'DATE',
            ],
            'jl_masuk'        => [
                'type'           => 'DECIMAL',
                'constraint'     => [20, 4],
            ],
            'jl_keluar'        => [
                'type'           => 'DECIMAL',
                'constraint'     => [20, 4],
            ],
            'jl_sisa'        => [
                'type'           => 'DECIMAL',
                'constraint'     => [20, 4],
            ],
            'harga'        => [
                'type'           => 'DECIMAL',
                'constraint'     => [20, 2],
                'default'        => '0',
            ],
            'catatan'        => [
                'type'           => 'TEXT',
                'null'             => true,
            ],
            'penerima_id'              => [
                'type'               => 'INT',
                'constraint'         => 11,
                'unsigned'           => true,
            ],
            'pilihan'        => [ //proyek alat dll
                'type'           => 'VARCHAR',
                'constraint'     => 100,
            ],
            'beban_id'              => [
                'type'               => 'INT',
                'constraint'         => 11,
                'unsigned'           => true,
            ],
            'biaya_id'              => [
                'type'               => 'INT',
                'constraint'         => 11,
                'unsigned'           => true,
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
        $this->forge->createTable('kartu_barang');
    }

    public function down()
    {
        $this->forge->dropTable('kartu_barang');
    }
}
