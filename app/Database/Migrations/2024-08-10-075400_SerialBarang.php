<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SerialBarang extends Migration
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
            'idunik'                 => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'barang_id'             => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'noseri'                => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'harga'                 => [
                'type'                  => 'DECIMAL',
                'constraint'            => [20, 2],
                'default'               => '0',
            ],
            'alat_id'               => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'reparasi'              => [
                'type'                  => 'BIGINT',
                'constraint'            => 20,
                'default'               => '0',
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
        $this->forge->createTable('m_serial');
    }

    public function down()
    {
        $this->forge->dropTable('m_serial');
    }
}
