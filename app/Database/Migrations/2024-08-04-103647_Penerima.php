<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Penerima extends Migration
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
            'nip'                   => [
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
            'cabang_id'             => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'lokasi'                => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'kelamin'               => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'darah'                 => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            't4lahir'               => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'tgl_lahir'             => [
                'type'                  => 'DATE',
            ],
            'alamat'                => [
                'type'                  => 'TEXT',
            ],
            'kontak'                => [
                'type'                  => 'TEXT',
            ],
            'email'                 => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'ijasah'                => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'jurusan'               => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'st_ijasah'             => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'tgl_ijasah'            => [
                'type'                  => 'DATE',
            ],
            'jenis_sim'             => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'nosim'                 => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'tgl_sim'               => [
                'type'                  => 'DATE',
            ],
            'st_ptkp'               => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'tgl_join'              => [
                'type'                  => 'DATE',
            ],
            'st_pegawai'            => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'tgl_kontrakaw'         => [
                'type'                  => 'DATE',
            ],
            'tgl_kontrakak'         => [
                'type'                  => 'DATE',
            ],
            'pilih_keluar'          => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'tgl_keluar'            => [
                'type'                  => 'DATE',
            ],
            'alasan_keluar'         => [
                'type'                  => 'TEXT',
            ],
            'jabatan_id'            => [
                'type'                  => 'VARCHAR',
                'constraint'             => 255,
            ],
            'golongan_id'           => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'user_id'               => [
                'type'                   => 'VARCHAR',
                'constraint'             => 255,
            ],
            'atasan_id'             => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'asuransi'              => [
                'type'                  => 'TEXT',
            ],
            'is_alias'              => [ // Pelanggan Suplier Lain Pegawai OSM (operator, supir, mekanik)
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
                'default'               => '00000',
            ],
            'kakun_pelanggan'       => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'kakun_suplier'         => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'kakun_lain'            => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'kakun_pegawai'         => [
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
        $this->forge->createTable('m_penerima');
    }

    public function down()
    {
        $this->forge->dropTable('m_penerima');
    }
}
