<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Perusahaan2 extends Migration
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
            'pusat'             => [
                'type'                  => 'BOOLEAN',
                'default'               => false,
            ],
            'alamat'                => [
                'type'                  => 'TEXT',
            ],
            'kota'                  => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'telepon'               => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'faximili'              => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'email'                 => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'nopajak'               => [
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
        $this->forge->createTable('perusahaan_data');
    }

    public function down()
    {
        $this->forge->dropTable('perusahaan_data');
    }
}
