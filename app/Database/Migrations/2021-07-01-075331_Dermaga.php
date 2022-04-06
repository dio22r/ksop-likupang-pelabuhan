<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Dermaga extends Migration
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
			'nama_dermaga' => [
				'type' => 'varchar',
				'constraint' => 150
			],
			'type' => [ // 1: Labuh, 2: Tambat, 3: Docking
				'type' => 'int',
				'constraint' => 4
			],
			'status' => [
				'type' => 'int',
				'constraint' => 4
			],
		]);

		$this->forge->addKey('id', true);

		$this->forge->createTable('dermaga');
	}

	public function down()
	{
		$this->forge->dropTable('dermaga');
	}
}
