<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class JualBarang3 extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'BIGINT',
                'constraint'     => 15,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'tiketinduk_id'        => [
                'type'           => 'INT',
                'constraint'     => 15,
                'unsigned'       => true,
            ],
            'notiket'        => [
                'type'           => 'VARCHAR',
                'constraint'     => 10,
                'null'             => true,
            ],
            'ruas_id'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'jarak_id'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'perusalat_id'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'wilalat_id'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'divalat_id'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'alat_id'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'supir_id'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'tanggal'        => [
                'type'           => 'DATETIME',
            ],
            'trip'        => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
            ],
            'biaya_id'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'berat'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'default'        => '1',
            ],
            'jarak'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'default'        => '1',
            ],
            'patching'        => [
                'type'           => 'VARCHAR',
                'constraint'     => 10,
                'null'             => true,
            ],
            'ubbm'        => [
                'type'           => 'DECIMAL',
                'constraint'     => [20, 2],
                'default'        => '0',
            ],
            'uhonor'        => [
                'type'           => 'DECIMAL',
                'constraint'     => [20, 2],
                'default'        => '0',
            ],
            'utrip'        => [
                'type'           => 'DECIMAL',
                'constraint'     => [20, 2],
                'default'        => '0',
            ],
            'utambah'        => [
                'type'           => 'DECIMAL',
                'constraint'     => [20, 2],
                'default'        => '0',
            ],

            'aksi'        => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
                'null'             => true,
            ],
            'status'        => [
                'type'           => 'VARCHAR',
                'constraint'     => 10,
            ],
            'created_at'  => [
                'type'           => 'DATETIME',
                'null'             => true,
            ],
            'updated_at'  => [
                'type'           => 'DATETIME',
                'null'             => true,
            ],
            'deleted_at'  => [
                'type'           => 'DATETIME',
                'null'             => true,
            ],
        ]);
        $this->forge->addKey('id', true); //primary key
        $this->forge->createTable('jual_detil');
    }

    public function down()
    {
        $this->forge->dropTable('jual_detil');
    }
}
