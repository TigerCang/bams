<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KonfigurasiTrip extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'idunik'     => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
            ],
            'param'     => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
            ],
            'tanggal'        => [
                'type'           => 'DATE',
            ],
            'wilayah_id'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'nama'     => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
            ],
            'nilai'        => [
                'type'           => 'DECIMAL',
                'constraint'     => [20, 2],
                'default'        => '0',
            ],
            'tripke'        => [
                'type'           => 'INT',
                'constraint'     => 2,
            ],
            'tripx'        => [
                'type'           => 'INT',
                'constraint'     => 2,
            ],
            'persenx'        => [
                'type'           => 'INT',
                'constraint'     => 2,
            ],
            'is_confirm'  => [
                'type'           => 'INT',
                'constraint'     => 1,
                'default'        => '0',
            ],
            'is_aktif'    => [
                'type'           => 'INT',
                'constraint'     => 1,
                'default'        => '1',
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
        $this->forge->createTable('m_trip');
    }

    public function down()
    {
        $this->forge->dropTable('m_trip');
    }
}
