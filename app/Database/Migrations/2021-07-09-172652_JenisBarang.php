<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class JenisBarang extends Migration
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
			'uraian' => [
				'type' => 'varchar',
				'constraint' => 150
			],
			'satuan' => [
				'type' => 'varchar',
				'constraint' => 15
			],
			'type' => [  // 1 : barang, 2 orang/hewan, 3 box
				'type' => 'int',
				'constraint' => 4
			],
		]);

		$this->forge->addKey('id', true);

		$this->forge->createTable('jenis_barang');
	}

	public function down()
	{
		$this->forge->dropTable('jenis_barang');
	}
}
