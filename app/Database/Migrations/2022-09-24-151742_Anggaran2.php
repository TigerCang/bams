<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Anggaran2 extends Migration
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
            'anggaraninduk_id' => [
                'type'              => 'BIGINT',
                'constraint'        => 15,
                'unsigned'          => true,
            ],
            'biaya_id'      => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
                'default'           => '0',
            ],
            'akun_id'       => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
                'default'           => '0',
            ],
            'bulan'         => [
                'type'              => 'DECIMAL',
                'constraint'        => [10, 2],
                'default'           => '0',
            ],
            'jumlah_kontrak' => [
                'type'              => 'DECIMAL',
                'constraint'        => [20, 4],
                'default'           => '0',
            ],
            'jumlah_cco'    => [
                'type'              => 'DECIMAL',
                'constraint'        => [20, 4],
                'default'           => '0',
            ],
            'harga_kontrak' => [
                'type'              => 'DECIMAL',
                'constraint'        => [20, 2],
                'default'           => '0',
            ],
            'harga_kerja'   => [
                'type'              => 'DECIMAL',
                'constraint'        => [20, 2],
                'default'           => '0',
            ],
            'total_kontrak' => [
                'type'              => 'DECIMAL',
                'constraint'        => [20, 2],
                'default'           => '0',
            ],
            'total_kerja'   => [
                'type'              => 'DECIMAL',
                'constraint'        => [20, 2],
                'default'           => '0',
            ],
            'harga_kontrak_cco' => [
                'type'              => 'DECIMAL',
                'constraint'        => [20, 2],
                'default'           => '0',
            ],
            'harga_kerja_cco' => [
                'type'              => 'DECIMAL',
                'constraint'        => [20, 2],
                'default'           => '0',
            ],
            'total_kontrak_cco' => [
                'type'              => 'DECIMAL',
                'constraint'        => [20, 2],
                'default'           => '0',
            ],
            'total_kerja_cco' => [
                'type'              => 'DECIMAL',
                'constraint'        => [20, 2],
                'default'           => '0',
            ],
            'kelin'         => [
                'type'              => 'VARCHAR', // industri non
                'constraint'        => 100,
                'null'              => true,
            ],
            'catatan'       => [
                'type'              => 'TEXT',
                'null'              => true,
            ],
            'levsatu'       => [
                'type'              => 'VARCHAR',
                'constraint'        => 10,
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
        $this->forge->createTable('anggaran_anak');
    }

    public function down()
    {
        $this->forge->dropTable('anggaran_anak');
    }
}
