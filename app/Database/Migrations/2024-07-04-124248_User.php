<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
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
                'character set'         => 'utf8',
                'collate'               => 'utf8_bin',
            ],
            'password'              => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'role_id'               => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'atasan_id'             => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'act_setuju'            => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'act_limit'             => [
                'type'                  => 'DECIMAL',
                'constraint'            => [20, 2],
                'default'               => '0',
            ],
            'act_button'            => [ // Create Read Update Delete Confirm Active
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
                'default'               => '000000',
            ],
            'act_akses'             => [ // Perusahaan Wilayah Divisi Jabatan (gaji) Proyek Camp Alat Tanah Supervisor Filter
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
                'default'               => '0000000000',
            ],
            'perusahaan'            => [
                'type'                  => 'TEXT',
            ],
            'wilayah'               => [
                'type'                  => 'TEXT',
            ],
            'divisi'                => [
                'type'                  => 'TEXT',
            ],
            'jabatan'               => [
                'type'                  => 'TEXT',
            ],
            'proyek'                => [
                'type'                  => 'TEXT',
            ],
            'cabang'                => [
                'type'                  => 'TEXT',
            ],
            'alat'                  => [
                'type'                  => 'TEXT',
            ],
            'tanah'                 => [
                'type'                  => 'TEXT',
            ],
            'kasbank'               => [
                'type'                  => 'TEXT',
            ],
            'token_id'              => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'is_reset'              => [
                'type'                  => 'BOOLEAN',
                'default'               => false,
            ],
            'dashboard'             => [ // card dashboard
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
                'default'               => 'user,penjualan,pegawai,sales',
            ],
            'tampilan'              => [ // layout bahasa tema mode : vertical,indonesia,bawaan,terang
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
                'default'               => 'vertical,indonesia,bawaan,terang',
            ],
            'pintasan'              => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'set_default'            => [ // Perusahaan Wilayah Divisi Objek
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
                'default'               => '0,0,0,-',
            ],
            'gambar'                => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
                'default'               => 'photo.png',
            ],
            'gambar_latar'           => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
                'default'               => '01.jpg',
            ],
            'kondisi'               => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
                'default'               => '100',
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
        $this->forge->createTable('m_user');
    }

    public function down()
    {
        $this->forge->dropTable('m_user');
    }
}
