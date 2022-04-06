<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FileLampiran extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'bigint',
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
			'id_op_kapal' => [
				'type' => 'bigint'
			],
			'id_file_ket' => [
				'type' => 'int'
			],
			'filename' => [
				'type' => 'varchar',
				'constraint' => 150
			],
			'filehash' => [
				'type' => 'varchar',
				'constraint' => 150
			],
			'status' => [
				'type' => 'int',
				'constraint' => 4
			]
		]);
		$this->forge->addKey('id', true);
		$this->forge->addKey('id_op_kapal');
		$this->forge->addKey('id_file_ket');

		$this->forge->createTable('file_lampiran');
	}

	public function down()
	{
		$this->forge->dropTable('file_lampiran');
	}
}
