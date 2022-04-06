<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class JenisKapal extends Migration
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
				'constraint' => 150
			],
		]);

		$this->forge->addKey('id', true);

		$this->forge->createTable('jenis_kapal');
	}

	public function down()
	{
		$this->forge->dropTable('jenis_kapal');
	}
}
