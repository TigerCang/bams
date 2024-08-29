<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PurchaseOrder3 extends Migration
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
            'poorder_id'    => [
                'type'              => 'BIGINT',
                'constraint'        => 15,
                'unsigned'          => true,
            ],
            'poanak_id'     => [
                'type'              => 'BIGINT',
                'constraint'        => 15,
                'unsigned'          => true,
            ],
            'penerima_id'   => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
                'null'              => true,
            ],
            'jumlah'        => [
                'type'              => 'DECIMAL',
                'constraint'        => [20, 4],
            ],
            'harga'         => [
                'type'              => 'DECIMAL',
                'constraint'        => [20, 3],
                'default'           => '0',
            ],
            'diskon'        => [
                'type'              => 'DECIMAL',
                'constraint'        => [20, 3],
                'default'           => '0',
            ],
            'total'         => [
                'type'              => 'DECIMAL',
                'constraint'        => [20, 3],
                'default'           => '0',
            ],
            'st_pajak'      => [
                'type'              => 'BOOLEAN',
                'default'           => false,
            ],
            'st_pilih'      => [  //0 baru 1 pilih 2 order
                'type'              => 'VARCHAR',
                'constraint'        => 10,
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
        $this->forge->createTable('po_tawar');
    }

    public function down()
    {
        $this->forge->dropTable('po_tawar');
    }
}
