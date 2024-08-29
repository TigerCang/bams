<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KasAnak3 extends Migration
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
            'kasanak_id'            => [
                'type'                  => 'BIGINT',
                'constraint'            => 20,
                'unsigned'              => true,
            ],
            'nomor'                 => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'masapajak'             => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'objekpajak_id'         => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'ni_dpp'             => [
                'type'                  => 'DECIMAL',
                'constraint'            => [20, 2],
            ],
            'tarif'                 => [
                'type'                  => 'DECIMAL',
                'constraint'            => [10, 2],
            ],
            'ni_potong'             => [
                'type'                  => 'DECIMAL',
                'constraint'            => [20, 2],
            ],
            'dokumenref_id'             => [
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
        $this->forge->createTable('kas_pajak');
    }

    public function down()
    {
        $this->forge->dropTable('kas_pajak');
    }
}
