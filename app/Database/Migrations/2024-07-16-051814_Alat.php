<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Alat extends Migration
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
            'rekan_id'              => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'kode'                  => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'nomor'                 => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'nama'                  => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'model'                => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'merk'                  => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'kategori'              => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'jenis'                 => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'pegawai_id'            => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'sumberdaya_id'        => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'kbli_id'               => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'kakun_id'              => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'bukti'                 => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'ibbm'                  => [
                'type'                  => 'DECIMAL',
                'constraint'            => [12, 2],
                'default'               => '1',
            ],
            'berat'                 => [
                'type'                  => 'DECIMAL',
                'constraint'            => [12, 2],
                'default'               => '1',
            ],
            'tgl_beli'              => [
                'type'                  => 'DATE',
            ],
            'tgl_produksi'          => [
                'type'                  => 'DATE',
            ],
            'tgl_stnk'              => [
                'type'                  => 'DATE',
            ],
            'tgl_keur'              => [
                'type'                  => 'DATE',
            ],
            'mode_susut'            => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'umur'                  => [
                'type'                  => 'BIGINT',
                'constraint'            => 20,
                'unsigned'              => true,
                'default'               => '0',
            ],
            'sisa'                  => [
                'type'                  => 'BIGINT',
                'constraint'            => 20,
                'unsigned'              => true,
                'default'               => '0',
            ],
            'ni_beli'               => [
                'type'                  => 'DECIMAL',
                'constraint'            => [20, 2],
                'default'               => '0',
            ],
            'ni_residu'             => [
                'type'                  => 'DECIMAL',
                'constraint'            => [20, 2],
                'default'               => '0',
            ],
            'ni_sewa'               => [
                'type'                  => 'DECIMAL',
                'constraint'            => [20, 2],
                'default'               => '0',
            ],
            'ni_susut'              => [
                'type'                  => 'DECIMAL',
                'constraint'            => [20, 2],
                'default'               => '0',
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
            'perusahaanin_id'       => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'gambar'                => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
                'default'               => 'default.png',
            ],
            'dokumen'               => [
                'type'                  => 'TEXT',
            ],
            'mesin'                 => [
                'type'                  => 'TEXT',
            ],
            'transmisi'             => [
                'type'                  => 'TEXT',
            ],
            'catatan'               => [
                'type'                  => 'TEXT',
            ],
            'is_jual'               => [
                'type'                  => 'BOOLEAN',
                'default'               => false,
            ],
            'kondisi'               => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'nolink'                => [
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
        $this->forge->addKey('id', true); //primary key
        $this->forge->createTable('m_alat');
    }

    public function down()
    {
        $this->forge->dropTable('m_alat');
    }
}
