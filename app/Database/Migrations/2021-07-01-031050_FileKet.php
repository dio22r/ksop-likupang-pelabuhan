<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FileKet extends Migration
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
			'keterangan' => [
				'type' => 'varchar',
				'constraint' => 255
			],
			'is_deleted' => [
				'type' => 'int',
				'constraint' => 2
			]
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('file_ket');
	}

	public function down()
	{
		$this->forge->dropTable('file_ket');
	}
}
