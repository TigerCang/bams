<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ATK extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'idunik'        => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
            ],
            'nama'          => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ],
            'satuan'        => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
                'null'              => true,
            ],
            'updated_by'    => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
                'default'           => '0',
            ],
            'created_at'    => [
                'type'              => 'DATETIME',
                'null'              => true,
            ],
            'updated_at'    => [
                'type'              => 'DATETIME',
                'null'              => true,
            ],
            'deleted_at'    => [
                'type'              => 'DATETIME',
                'null'              => true,
            ],
        ]);
        $this->forge->addKey('id', true); //primary key
        $this->forge->createTable('m_atk');
    }

    public function down()
    {
        $this->forge->dropTable('m_atk');
    }
}
