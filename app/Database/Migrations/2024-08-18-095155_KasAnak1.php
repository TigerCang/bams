<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KasAnak1 extends Migration
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
            'kasdetil_id'           => [
                'type'                  => 'BIGINT',
                'constraint'            => 20,
                'unsigned'              => true,
            ],
            'ruas_id'               => [
                'type'                  => 'BIGINT',
                'constraint'            => 20,
                'unsigned'              => true,
            ],
            'anggaran_id'           => [
                'type'                  => 'BIGINT',
                'constraint'            => 20,
                'unsigned'              => true,
            ],
            'biaya_id'              => [
                'type'                  => 'BIGINT',
                'constraint'            => 20,
                'unsigned'              => true,
            ],
            'sumberdaya_id'         => [
                'type'                  => 'BIGINT',
                'constraint'            => 20,
                'unsigned'              => true,
            ],
            'akun_id'               => [
                'type'                  => 'BIGINT',
                'constraint'            => 20,
                'unsigned'              => true,
            ],
            'osm_id'                => [
                'type'                  => 'BIGINT',
                'constraint'            => 20,
                'unsigned'              => true,
            ],
            'item_id'               => [
                'type'                  => 'BIGINT',
                'constraint'            => 20,
                'unsigned'              => true,
            ],
            'jumlah'                => [
                'type'                  => 'DECIMAL',
                'constraint'            => [20, 4],
            ],
            'harga'                 => [
                'type'                  => 'DECIMAL',
                'constraint'            => [20, 2],
            ],
            'debit'                 => [
                'type'                  => 'DECIMAL',
                'constraint'            => [20, 2],
                'default'               => '0',
            ],
            'kredit'                => [
                'type'                  => 'DECIMAL',
                'constraint'            => [20, 2],
                'default'               => '0',
            ],
            'catatan'               => [
                'type'                  => 'TEXT',
            ],
            'anak_id'               => [
                'type'                  => 'BIGINT',
                'constraint'            => 20,
                'unsigned'              => true,
            ],
            'mode'                  => [
                'type'                  => 'VARCHAR', //a inputan b1 ubah jumlah, b2 ubah harga c pph
                'constraint'            => 255,
                'default'               => 'a',
            ],
            'asal'                  => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'in_pph'                => [
                'type'                  => 'BOOLEAN',
                'default'               => false,
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
        $this->forge->createTable('kas_anak');
    }

    public function down()
    {
        $this->forge->dropTable('kas_anak');
    }
}
