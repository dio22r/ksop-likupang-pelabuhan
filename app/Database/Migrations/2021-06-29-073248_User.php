<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
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
			'nama' => [
				'type' => 'varchar',
				'constraint' => 150
			],
			'username' => [
				'type' => 'varchar',
				'constraint' => 150,
			],
			'password' => [
				'type' => 'varchar',
				'constraint' => 255,
			],
			'role' => [ // 1 = admin, 2 = operator
				'type' => 'int',
			],
			'status' => [
				'type' => 'int',
				'constraint' => 5
			]
		]);
		$this->forge->addKey('id', true);

		$this->forge->createTable('user');
	}

	public function down()
	{
		$this->forge->dropTable('user');
	}
}
