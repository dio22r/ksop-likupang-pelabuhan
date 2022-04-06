<?php

namespace App\Database\Seeds;

use App\Models\JenisBarangModel;
use CodeIgniter\Database\Seeder;

class JenisBarang extends Seeder
{
	public function run()
	{
		$data = [
			[
				"uraian" => "General Cargo (brg. Campuran)",
				"satuan" => "T/M3",
				"type" => 1
			],
			[
				"uraian" => "Bag. Cargo (brg. Karungan)",
				"satuan" => "T/M3",
				"type" => 1
			],
			[
				"uraian" => "Bulk Cargo (brg. Curah)",
				"satuan" => "T/M3",
				"type" => 1
			],
			[
				"uraian" => "Liquid Cargo (brg. Cair)",
				"satuan" => "T/M3",
				"type" => 1
			],
			[
				"uraian" => "Barang Berbahaya",
				"satuan" => "T/M3",
				"type" => 1
			],
			[
				"uraian" => "Lain-lain",
				"satuan" => "T/M3",
				"type" => 1
			],
			[
				"uraian" => "Penumpang Naik / Turun",
				"satuan" => "Org",
				"type" => 2
			],
			[
				"uraian" => "Hewan Naik / Turun",
				"satuan" => "Org",
				"type" => 2
			],
			[
				"uraian" => "Container",
				"satuan" => "Box/Teus/Tonase",
				"type" => 2
			]
		];

		$jenisBarang = new JenisBarangModel();

		$jenisBarang->insertBatch($data);
	}
}
