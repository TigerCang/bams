<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KasAnak2 extends Migration
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
            'kasinduk_id'           => [
                'type'                  => 'BIGINT',
                'constraint'            => 20,
                'unsigned'              => true,
            ],
            'kasanak_id'            => [
                'type'                  => 'BIGINT',
                'constraint'            => 20,
                'unsigned'              => true,
            ],
            'biaya_id'              => [
                'type'                  => 'BIGINT',
                'constraint'            => 20,
                'unsigned'              => true,
            ],
            'akun_id'               => [
                'type'                  => 'BIGINT',
                'constraint'            => 20,
                'unsigned'              => true,
            ],
            'debit'                 => [
                'type'                  => 'DECIMAL',
                'constraint'            => [20, 2],
            ],
            'kredit'                => [
                'type'                  => 'DECIMAL',
                'constraint'            => [20, 2],
            ],
            'sisa'                  => [
                'type'                  => 'DECIMAL',
                'constraint'            => [20, 2],
            ],
            'catatan'               => [
                'type'                  => 'TEXT',
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
        $this->forge->createTable('kas_detil');
    }

    public function down()
    {
        $this->forge->dropTable('kas_detil');
    }
}
