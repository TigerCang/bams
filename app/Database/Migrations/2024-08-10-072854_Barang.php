<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Barang extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                    => [
                'type'                  => 'BIGINT',
                'constraint'            => 20,
                'unsigned'              => true,
                'auto_increment'        => true,
            ],
            'idunik'                => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'param'                 => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'kode'                  => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'partnumber'            => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'sumberdaya_id'         => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'nama'                  => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'kategori'              => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'merk'                  => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'satuan'                => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'kakun_id'              => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'stokmin'               => [
                'type'                  => 'BIGINT',
                'constraint'            => 20,
                'default'               => '0',
            ],
            'harga'                 => [
                'type'                  => 'DECIMAL',
                'constraint'            => [20, 2],
                'default'               => '0',
            ],
            'sebes'                 => [ //serial bekas stok
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'gambar'                => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
                'default'               => 'default.png',
            ],
            'catatan'               => [
                'type'                  => 'TEXT',
            ],
            'kondisi'               => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'save_by'               => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'conf_by'               => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'aktif_by'              => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'created_at'            => [
                'type'                  => 'DATETIME',
                'null'                  => true,
            ],
            'updated_at'            => [
                'type'                  => 'DATETIME',
                'null'                  => true,
            ],
            'deleted_at'            => [
                'type'                  => 'DATETIME',
                'null'                  => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('m_barang');
    }

    public function down()
    {
        $this->forge->dropTable('m_barang');
    }
}
