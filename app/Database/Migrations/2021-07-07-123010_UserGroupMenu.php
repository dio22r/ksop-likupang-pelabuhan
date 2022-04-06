<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserGroupMenu extends Migration
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
			'user_group_id' => [
				'type' => 'int',
			],
			'menu_id' => [
				'type' => 'int'
			]
		]);

		$this->forge->addKey('id', true);
		$this->forge->addKey('user_group_id');
		$this->forge->addKey('menu_id');

		$this->forge->createTable('user_group_menu');
	}

	public function down()
	{
		$this->forge->dropTable('user_group_menu');
	}
}
