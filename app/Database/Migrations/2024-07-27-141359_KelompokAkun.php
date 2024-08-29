<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KelompokAkun extends Migration
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
            'asal'                  => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'param'                 => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'sub_param'             => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'nama'                  => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'nilai'                 => [
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
            'akun1_id'              => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'akun2_id'              => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'akun3_id'              => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'akun4_id'              => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'akun5_id'              => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'catatan'               => [
                'type'                  => 'TEXT',
            ],
            'set_default'           => [
                'type'                  => 'BOOLEAN',
                'default'               => false,
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
        $this->forge->createTable('m_kelakun');
    }

    public function down()
    {
        $this->forge->dropTable('m_kelakun');
    }
}
