<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Anggaran extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                    => [
                'type'                  => 'BIGINT',
                'constraint'            => 20,
                'unsigned'              => true, //nilai positif saja
                'auto_increment'        => true,
            ],
            'idunik'                => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'judul'                  => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'pilih'                 => [ // pendapatan pengeluaran
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'beban'                 => [ // proyek cabang alat tanah
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'jenis'                 => [ //btl bn dll
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'biaya_id'              => [
                'type'                  => 'BIGINT',
                'constraint'            => 20,
                'unsigned'              => true,
            ],
            'akun_id'               => [
                'type'                  => 'BIGINT',
                'constraint'            => 20,
                'unsigned'              => true,
            ],
            'bulan'                 => [
                'type'                  => 'DECIMAL',
                'constraint'            => [20, 2],
                'default'               => '0',
            ],
            'jumlah'                => [
                'type'                  => 'DECIMAL',
                'constraint'            => [20, 4],
                'default'               => '0',
            ],
            'harga'                 => [
                'type'                  => 'DECIMAL',
                'constraint'            => [20, 2],
                'default'               => '0',
            ],
            'total'                 => [
                'type'                  => 'DECIMAL',
                'constraint'            => [20, 2],
                'default'               => '0',
            ],
            'catatan'               => [
                'type'                  => 'TEXT',
            ],
            'levsatu'               => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'kondisi'               => [ // Readonly Confirm Active
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
        $this->forge->createTable('m_anggaran');
    }

    public function down()
    {
        $this->forge->dropTable('m_anggaran');
    }
}
