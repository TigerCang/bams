<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Perusahaan3 extends Migration
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
            'perusahaan_id'         => [
                'type'                  => 'BIGINT',
                'constraint'            => 20,
                'unsigned'              => true,
            ],
            'judul'                 => [ // jika terjadi perubahan ...
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'pilih'                 => [ // pengurus, saham
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'nomor'                 => [
                'type'                  => 'BIGINT',
                'constraint'            => 20,
                'unsigned'              => true,
            ],
            'nama'                  => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'identitas'             => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'jabatan'               => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'alamat'                => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'jumlah'                => [
                'type'                  => 'DECIMAL',
                'constraint'            => [20, 4],
            ],
            'harga'                 => [
                'type'                  => 'DECIMAL',
                'constraint'            => [20, 2],
            ],
            'total'                 => [
                'type'                  => 'DECIMAL',
                'constraint'            => [20, 2],
            ],
            'is_use'             => [
                'type'                  => 'BOOLEAN',
                'default'               => false,
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
        $this->forge->createTable('perusahaan_person');
    }

    public function down()
    {
        $this->forge->dropTable('perusahaan_person');
    }
}
