<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Atribut extends Migration
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
			'pilihan'        => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
			],
			'nourut'        => [
				'type'           => 'INT',
				'constraint'     => 5,
			],
			'nilaikonstanta'        => [
				'type'           => 'INT',
				'constraint'     => 10,
				'null'		     => true,
			],
			'satuan'        => [
				'type'           => 'VARCHAR',
				'constraint'     => 255,
				'null'		     => true,
			],
			'nama'        => [
				'type'           => 'VARCHAR',
				'constraint'     => 255,
			],
			'separator'        => [
				'type'           => 'VARCHAR',
				'constraint'     => 2,
				'null'		     => true,
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
		$this->forge->createTable('m_atribut');
	}

	public function down()
	{
		$this->forge->dropTable('m_atribut');
	}
}
