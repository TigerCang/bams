<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KasInduk extends Migration
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
                'type'                  => 'VARCHAR', //dari menu kaslangsung dll
                'constraint'            => 255,
            ],
            'beban'                 => [ //proyek cabang alat
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'nodokumen'             => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'tgl_minta'             => [
                'type'                  => 'DATE',
            ],
            'tgl_beban'             => [
                'type'                  => 'DATE',
            ],
            'beban_id'              => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'penerima_id'           => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'kbli_id'               => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'revisi'                => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'jenis'                 => [
                'type'                  => 'VARCHAR', //ju - ajp
                'constraint'            => 255,
                'default'               => 'ju',
            ],
            'level'                 => [
                'type'                  => 'VARCHAR', //lev awal, posisi, next 1;2;3
                'constraint'            => 255,
            ],
            'setuju'                => [
                'type'                  => 'VARCHAR', //000 1. level 2. accounting 3. setelah kas
                'constraint'            => 255,
            ],
            'periode'               => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'is_masuk'              => [ //0 keluar 1 masuk
                'type'                  => 'BOOLEAN',
                'default'               => false,
            ],
            'is_pajak'              => [
                'type'                  => 'BOOLEAN',
                'default'               => false,
            ],
            'status'                => [
                'type'                  => 'VARCHAR', //01 pertama 0=sama 1=beda yang kedua status new pending dan konfirm
                'constraint'            => 255,
            ],
            'lampiran'              => [
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
            'usernama'              => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'peminta'               => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'last_id'               => [
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
        $this->forge->createTable('kas_induk');
    }

    public function down()
    {
        $this->forge->dropTable('kas_induk');
    }
}
