<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PurchaseOrder2 extends Migration
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
            'pominta_id'      => [
                'type'              => 'BIGINT',
                'constraint'        => 15,
                'unsigned'          => true,
            ],
            'jenis'         => [
                'type'              => 'BOOLEAN',
                'default'           => true,
            ],
            'item_id'       => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
            ],
            'spesifikasi'   => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ],
            'jumlah'        => [
                'type'              => 'DECIMAL',
                'constraint'        => [20, 4],
            ],
            'ada'           => [
                'type'              => 'DECIMAL',
                'constraint'        => [20, 4],
            ],
            'satuan'        => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
            ],
            'konversi'      => [
                'type'              => 'DECIMAL',
                'constraint'        => [20, 4],
            ],
            'level_pos'     => [
                'type'              => 'INT',
                'constraint'        => 2,
            ],
            'is_ada'       => [
                'type'              => 'BOOLEAN',
                'default'           => false,
            ],
            'status'        => [
                'type'              => 'VARCHAR',
                'constraint'        => 10,
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
        $this->forge->createTable('po_anak');
    }

    public function down()
    {
        $this->forge->dropTable('po_anak');
    }
}
