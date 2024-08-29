<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SalesOrder2 extends Migration
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
            'soinduk_id'        => [
                'type'           => 'INT',
                'constraint'     => 15,
                'unsigned'       => true,
            ],
            'poinduk_id'        => [
                'type'           => 'INT',
                'constraint'     => 15,
                'unsigned'       => true,
            ],
            'namajasa'        => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
                'null'             => true,
            ],
            'data_id'        => [
                'type'           => 'BIGINT',
                'constraint'     => 15,
                'unsigned'       => true,
                'null'             => true,
            ],
            'noseri_id'        => [
                'type'           => 'BIGINT',
                'constraint'     => 15,
                'unsigned'       => true,
                'null'             => true,
            ],
            'bentuk'        => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
                'null'             => true,
            ],
            'kategori_id'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'             => true,
            ],
            'jumlah'        => [
                'type'           => 'DECIMAL',
                'constraint'     => [20, 4],
            ],
            'satuan'        => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
            ],
            'harga'        => [
                'type'           => 'DECIMAL',
                'constraint'     => [20, 3],
                'default'        => '0',
            ],
            'diskon'        => [
                'type'           => 'DECIMAL',
                'constraint'     => [20, 3],
                'default'        => '0',
            ],
            'total'        => [
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
        $this->forge->createTable('sales_anak');
    }

    public function down()
    {
        $this->forge->dropTable('sales_anak');
    }
}
