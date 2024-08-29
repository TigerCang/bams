<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class LembarWaktu extends Migration
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
            'sosewa_id'        => [
                'type'           => 'BIGINT',
                'constraint'     => 15,
                'unsigned'       => true,
            ],
            'subruas_id'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'biaya_id'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'alat_id'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'alatperush_id'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'alatdiv_id'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'operator_id'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'operatorperush_id'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'operatorwil_id'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'operatordiv_id'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'tanggal'        => [
                'type'           => 'DATE',
            ],
            'jamkerjaalat'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'default'        => '0',
            ],
            'jamkerjaoperator'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'default'        => '0',
            ],
            'catatan'        => [
                'type'           => 'TEXT',
                'null'             => true,
            ],
            'st_tiket'        => [
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
        $this->forge->createTable('lembar_ts');
    }

    public function down()
    {
        $this->forge->dropTable('lembar_ts');
    }
}
