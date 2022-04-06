<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Perusahaan extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'int',
				'unsigned' => true,
				'auto_increment' => true,
			],
			'created_at' => [
				'type' => 'timestamp',
				'null' => true
			],
			'updated_at' => [
				'type' => 'timestamp',
				'null' => true
			],
			'deleted_at' => [
				'type' => 'timestamp',
				'null' => true
			],
			'nama' => [
				'type' => 'varchar',
				'constraint' => 125
			],
			'keterangan' => [
				'type' => 'varchar',
				'constraint' => 255
			]
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('perusahaan');
	}

	public function down()
	{
		$this->forge->dropTable('perusahaan');
	}
}
