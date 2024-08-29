<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Konfigurasi extends Migration
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
            'mode'                  => [
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
            'nilai'                 => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'save_by'                => [
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
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('m_konfigurasi');
    }

    public function down()
    {
        $this->forge->dropTable('m_konfigurasi');
    }
}
