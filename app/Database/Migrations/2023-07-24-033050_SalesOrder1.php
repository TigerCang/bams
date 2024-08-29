<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SalesOrder1 extends Migration
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
            'modeorder'        => [ //penjualan sewa
                'type'           => 'VARCHAR',
                'constraint'     => 100,
            ],
            'camp_id'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'             => true,
            ],
            'nodoc'        => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
            ],
            'tanggal'        => [
                'type'           => 'DATE',
            ],
            'nopo'        => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
            ],
            'penerima_id'        => [ //pelanggan
                'type'           => 'BIGINT',
                'constraint'     => 15,
                'unsigned'       => true,
            ],
            'proyek_id'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'             => true,
            ],
            'pilihdata'        => [
                'type'           => 'VARCHAR', //stok alat tanah
                'constraint'     => 100,
            ],
            'is_pajak'    => [
                'type'           => 'INT',
                'constraint'     => 1,
                'default'        => '0',
            ],
            'level_aw'        => [
                'type'           => 'INT',
                'constraint'     => 2,
            ],
            'level_pos'        => [
                'type'           => 'INT',
                'constraint'     => 2,
            ],
            'level_acc'        => [
                'type'           => 'INT',
                'constraint'     => 2,
            ],
            'st_cek'  => [
                'type'           => 'VARCHAR',
                'constraint'     => 10,
                'default'        => '0',
            ],
            'st_setuju'  => [
                'type'           => 'VARCHAR',
                'constraint'     => 10,
                'default'        => '0',
            ],
            'st_jual'        => [
                'type'           => 'VARCHAR',
                'constraint'     => 10,
                'default'        => '0',
            ],
            'st_tutup'        => [
                'type'           => 'VARCHAR',
                'constraint'     => 10,
                'default'        => '0',
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
        $this->forge->createTable('sales_induk');
    }

    public function down()
    {
        $this->forge->dropTable('sales_induk');
    }
}
