<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DataBarang extends Migration
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
			],
			'jenis_barang_id' => [
				'type' => 'int',
			],
			'bongkar' => [
				'type' => 'decimal',
				'constraint' => '10,4'
			],
			'muat' => [
				'type' => 'decimal',
				'constraint' => '10,4'
			]
		]);

		$this->forge->addKey('id', true);

		$this->forge->addKey('op_kapal_id');
		$this->forge->addKey('jenis_barang_id');

		$this->forge->createTable('data_barang');
	}

	public function down()
	{
		$this->forge->dropTable('data_barang');
	}
}
