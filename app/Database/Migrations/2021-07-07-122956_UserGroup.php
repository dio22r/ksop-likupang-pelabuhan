<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserGroup extends Migration
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
			'title' => [
				'type' => 'varchar',
				'constraint' => 20
			],
			'desc' => [
				'type' => 'text'
			]
		]);

		$this->forge->addKey('id', true);

		$this->forge->createTable('user_group');
	}

	public function down()
	{
		$this->forge->dropTable('user_group');
	}
}
