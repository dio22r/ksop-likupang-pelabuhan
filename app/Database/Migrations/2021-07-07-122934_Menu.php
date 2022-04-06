<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Menu extends Migration
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
			],
			'icon' => [
				'type' => 'varchar',
				'constraint' => 30
			],
			'href' => [
				'type' => 'varchar',
				'constraint' => 100
			],
			'order' => [
				'type' => 'int',
			],
			'parent_id' => [
				'type' => 'int',
			],
		]);

		$this->forge->addKey('id', true);

		$this->forge->createTable('menu');
	}

	public function down()
	{
		$this->forge->dropTable('menu');
	}
}
