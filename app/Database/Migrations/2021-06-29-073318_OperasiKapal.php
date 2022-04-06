<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use PHPUnit\Framework\Constraint\Constraint;

class OperasiKapal extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'bigint',
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
			'nama_kapal' => [
				'type' => 'varchar',
				'constraint' => 150
			],
			'bendera' => [
				'type' => 'varchar',
				'constraint' => 10
			],
			'gt' => [ // Tonase Kotor
				'type' => 'decimal',
				'constraint' => '10,2'
			],
			'dwt' => [ // DWT 
				'type' => 'decimal',
				'constraint' => '10,2'
			],
			'jenis_kapal' => [ // 
				'type' => 'int',
			],
			'loa' => [ // Length of All (L.O.A)
				'type' => 'varchar',
				'constraint' => 50,
			],
			'pemilik' => [
				'type' => 'varchar',
				'constraint' => 50,
			],
			'nama_agen' => [
				'type' => 'varchar',
				'constraint' => 50,
			],
			'nama_nahkoda' => [
				'type' => 'varchar',
				'constraint' => 50,
			],
			'trayek' => [
				'type' => 'varchar',
				'constraint' => 150,
			],
			'jenis_pelayaran' => [
				'type' => 'varchar',
				'constraint' => 30
			],
			'eta_date' => [
				'type' => 'date',
			],
			'eta_time' => [
				'type' => 'time',
			],
			'etd_date' => [
				'type' => 'date',
			],
			'etd_time' => [
				'type' => 'time',
			],

			'pelabuhan_asal' => [
				'type' => 'varchar',
				'constraint' => 150
			],
			'pelabuhan_tujuan' => [
				'type' => 'varchar',
				'constraint' => 150
			],
			'labuh_diminta' => [
				'type' => 'int',
			],
			'tambat_diminta' => [
				'type' => 'int',
			],
			'dock_diminta' => [
				'type' => 'int',
			],
			'pbm' => [
				'type' => 'varchar',
				'constraint' => 150
			],
			'rkbm' => [
				'type' => 'varchar',
				'constraint' => 150
			],
			'rencana_kegiatan' => [ // 0: Non Niaga, 1: Niaga
				'type' => 'int',
				'constraint' => 4
			],
			'status' => [
				'type' => 'int',
				'constraint' => 5
			],
			'is_deleted' => [
				'type' => 'int',
				'constraint' => 2
			]
		]);
		$this->forge->addKey('id', true);
		$this->forge->addKey('dermaga');

		$this->forge->createTable('operasi_kapal');
	}

	public function down()
	{
		$this->forge->dropTable('operasi_kapal');
	}
}
