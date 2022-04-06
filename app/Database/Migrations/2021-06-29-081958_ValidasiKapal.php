<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ValidasiKapal extends Migration
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
			'op_kapal_id' => [
				'type' => 'bigint',
				'unique' => TRUE
			],
			'user_id' => [
				'type' => 'int',
			],
			'keterangan' => [
				'type' => 'text'
			],
			'is_deleted' => [
				'type' => 'int',
				'constraint' => 2
			]
		]);

		$this->forge->addKey('id', true);
		$this->forge->addKey('user_id');

		$this->forge->createTable('validasi_kapal');
	}

	public function down()
	{
		$this->forge->dropTable('validasi_kapal');
	}
}
