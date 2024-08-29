<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MintaBarang6 extends Migration
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
            'idunik_po'        => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
            ],
            'nobukti'        => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
            ],
            'poanak_id'          => [
                'type'           => 'BIGINT',
                'constraint'     => 15,
                'unsigned'       => true,
            ],
            'akun_id'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'jumah'        => [
                'type'           => 'DECIMAL',
                'constraint'     => [20, 4],
            ],
            'biaya'        => [
                'type'           => 'DECIMAL',
                'constraint'     => [20, 3],
                'default'        => '0',
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
        $this->forge->createTable('po_biayaplus');
    }

    public function down()
    {
        $this->forge->dropTable('po_biayaplus');
    }
}
