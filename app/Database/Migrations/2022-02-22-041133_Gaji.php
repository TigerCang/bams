<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Gaji extends Migration
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
			'id_unik'     => [
				'type'           => 'VARCHAR',
				'constraint'     => 50,
			],
			'kode'        => [
				'type'           => 'VARCHAR',
				'constraint'     => 50,
			],
			'nama'        => [
				'type'           => 'VARCHAR',
				'constraint'     => 255,
			],
			'nilai'        => [
				'type'           => 'DECIMAL',
				'constraint'     => [20, 3],
				'default'        => '0',
			],
			'created_at'  => [
				'type'           => 'DATETIME',
				'null'		     => true,
			],
			'updated_at'  => [
				'type'           => 'DATETIME',
				'null'		     => true,
			],
			'deleted_at'  => [
				'type'           => 'DATETIME',
				'null'		     => true,
			],
		]);
		$this->forge->addKey('id', true); //primary key
		$this->forge->createTable('m_gajipeg');
	}

	public function down()
	{
		$this->forge->dropTable('m_gajipeg');
	}
}
