<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class QrcodeToken extends Migration
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
			'type' => [ // 1: detail kapal, 2 laporan bulanan, 3 laporan harian
				'type' => 'int',
			],
			'content' => [
				'type' => 'varchar',
				"constraint" => 150
			],
			'token' => [
				'type' => 'varchar',
				'constraint' => 255
			]
		]);

		$this->forge->addKey('id', true);

		$this->forge->createTable('qrcode_token');
	}

	public function down()
	{
		$this->forge->dropTable('qrcode_token');
	}
}
