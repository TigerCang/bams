<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class IDUnik extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'usernama'                  => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
            'idunik'                => [
                'type'                  => 'VARCHAR',
                'constraint'            => 255,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('id_unik');
    }

    public function down()
    {
        $this->forge->dropTable('id_unik');
    }
}
