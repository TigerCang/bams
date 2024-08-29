<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Proyek extends Migration
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
            'kode'                  => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'nama'                  => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'paket'                 => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'atasnama'              => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'lokasi'                => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'propinsi'              => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'kabupaten'             => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'pemilik'               => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'lingkup'               => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'carabayar'             => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'kate_id'               => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'kbli_id'               => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'tgl_kontrak'           => [
                'type'                  => 'DATE',
            ],
            'tgl_pho'               => [
                'type'                  => 'DATE',
            ],
            'tgl_fho'               => [
                'type'                  => 'DATE',
            ],
            'ppn'                   => [
                'type'                  => 'DECIMAL',
                'constraint'            => [10, 2],
                'default'               => '0',
            ],
            'pph'                   => [
                'type'                  => 'DECIMAL',
                'constraint'            => [10, 2],
                'default'               => '0',
            ],
            'ni_kontrak'            => [
                'type'                  => 'DECIMAL',
                'constraint'            => [20, 2],
                'default'               => '0',
            ],
            'ni_tambah'             => [
                'type'                  => 'DECIMAL',
                'constraint'            => [20, 2],
            ],
            'ni_lain'               => [
                'type'                  => 'DECIMAL',
                'constraint'            => [20, 2],
            ],
            'ni_bruto'              => [
                'type'                  => 'DECIMAL',
                'constraint'            => [20, 2],
                'default'               => '0',
            ],
            'ni_ppn'                => [
                'type'                  => 'DECIMAL',
                'constraint'            => [20, 2],
                'default'               => '0',
            ],
            'ni_pph'                => [
                'type'                  => 'DECIMAL',
                'constraint'            => [20, 2],
                'default'               => '0',
            ],
            'ni_netto'              => [
                'type'                  => 'DECIMAL',
                'constraint'            => [20, 2],
                'default'               => '0',
            ],
            'periode1'              => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
                'default'               => '2025',
            ],
            'periode2'              => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
                'default'               => '2025',
            ],
            'modeyear'              => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'perusahaan_id'         => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'wilayah_id'            => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'divisi_id'             => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'konsultan'             => [
                'type'                  => 'TEXT',
            ],
            'asuransi'              => [
                'type'                  => 'TEXT',
            ],
            'keuangan'              => [
                'type'                  => 'TEXT',
            ],
            'pelaksanaan'           => [
                'type'                  => 'TEXT',
            ],
            'catatan'               => [
                'type'                  => 'TEXT',
            ],
            'is_pajak'              => [
                'type'                  => 'BOOLEAN',
                'default'               => true,
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
        $this->forge->createTable('m_proyek');
    }

    public function down()
    {
        $this->forge->dropTable('m_proyek');
    }
}
