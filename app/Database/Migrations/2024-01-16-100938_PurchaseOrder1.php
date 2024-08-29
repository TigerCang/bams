<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PurchaseOrder1 extends Migration
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
            'user_id'       => [
                'type'               => 'INT',
                'constraint'         => 11,
                'unsigned'           => true,
            ],
            'peminta_id'    => [
                'type'               => 'INT',
                'constraint'         => 11,
                'unsigned'           => true,
            ],
            'last_id'       => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
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
            'nodoc'         => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
            ],
            'tanggal'       => [
                'type'              => 'DATE',
            ],
            'revisi'        => [
                'type'              => 'INT',
                'constraint'        => 2,
                'default'           => '0',
            ],
            'level_aw'      => [
                'type'              => 'INT',
                'constraint'        => 2,
            ],
            'level_pos'     => [
                'type'              => 'INT',
                'constraint'        => 2,
            ],
            'is_sama'       => [
                'type'               => 'BOOLEAN',
                'default'            => false,
            ],
            'st_seru'       => [
                'type'               => 'BOOLEAN',
                'default'            => false,
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
        $this->forge->createTable('po_minta');
    }

    public function down()
    {
        $this->forge->dropTable('po_minta');
    }
}
