<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PurchaseBarang5 extends Migration
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
            'popesan_id'          => [
                'type'           => 'BIGINT',
                'constraint'     => 15,
                'unsigned'       => true,
            ],
            'poanak_id'          => [
                'type'           => 'BIGINT',
                'constraint'     => 15,
                'unsigned'       => true,
            ],
            'tanggal'        => [
                'type'           => 'DATETIME',
            ],
            'gudang_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'cabang_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'tiket'        => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
            ],
            'nopol'        => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
            ],
            'supir'        => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
            ],
            'jl_awal'        => [
                'type'           => 'DECIMAL',
                'constraint'     => [20, 4],
            ],
            'jl_hasil'        => [
                'type'           => 'DECIMAL',
                'constraint'     => [20, 4],
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
        $this->forge->createTable('po_masuk1');
    }

    public function down()
    {
        $this->forge->dropTable('po_masuk1');
    }
}
