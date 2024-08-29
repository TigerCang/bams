<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PurchaseAmbil extends Migration
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
            'idunik'        => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
            ],
            'nodoc'         => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
            ],
            'tanggal'       => [
                'type'              => 'DATE',
            ],
            'perusahaan_id' => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
            ],
            'wilayah_id'    => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
            ],
            'divisi_id'     => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
            ],
            'user_id'       => [
                'type'               => 'INT',
                'constraint'         => 11,
                'unsigned'           => true,
            ],
            'penerima_id'    => [
                'type'               => 'INT',
                'constraint'         => 11,
                'unsigned'           => true,
            ],
            'atk_id'       => [
                'type'               => 'INT',
                'constraint'         => 11,
                'unsigned'           => true,
            ],
            'jumlah'        => [
                'type'              => 'INT',
                'constraint'        => 11,
                'default'           => '0',
            ],
            'catatan'       => [
                'type'              => 'TEXT',
                'null'              => true,
            ],
            'status'        => [
                'type'              => 'VARCHAR',
                'constraint'        => 10,
                'default'           => '0',
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
        $this->forge->createTable('po_ambil');
    }

    public function down()
    {
        $this->forge->dropTable('po_ambil');
    }
}
