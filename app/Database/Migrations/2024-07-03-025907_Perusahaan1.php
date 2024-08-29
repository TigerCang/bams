<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Perusahaan1 extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                    => [
                'type'                  => 'BIGINT',
                'constraint'            => 20,
                'unsigned'              => true, //nilai positif saja
                'auto_increment'        => true,
            ],
            'idunik'                => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'kode'                  => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'inisial'               => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'nama'                  => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'hukum1'                => [
                'type'                  => 'TEXT',
            ],
            'hukum2'                => [
                'type'                  => 'TEXT',
            ],
            'penerima_id'           => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'gambar'                => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
                'default'               => 'default.png',
            ],
            'kondisi'               => [ // Readonly Confirm Active
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
        $this->forge->addKey('id', true); //primary key
        $this->forge->createTable('m_perusahaan');
    }

    public function down()
    {
        $this->forge->dropTable('m_perusahaan');
    }
}
