<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SelectOption extends Migration
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
            'nomor'                 => [
                'type'                  => 'BIGINT',
                'constraint'            => 20,
                'unsigned'              => true,
            ],
            'param'                 => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'kelompok'              => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'nama'                  => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('m_select');
    }

    public function down()
    {
        $this->forge->dropTable('m_select');
    }
}