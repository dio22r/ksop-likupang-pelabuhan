<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

use App\Models\JenisKapalModel;

class JenisKapal extends Seeder
{
	public function run()
	{
		$data = [
			[
				"nama" => "Kontainer Ship",
			],
			[
				"nama" => "Tugboat Tongkang",
			],
			[
				"nama" => "Kargo ship",
			],
			[
				"nama" => "Tanker",
			],
			[
				"nama" => "SPOB",
			],
			[
				"nama" => "LCT",
			],
			[
				"nama" => "Kapal Negara",
			],
			[
				"nama" => "Kapal Wisata / Yacht",
			],
			[
				"nama" => "Kapal Pelayaran Rakyat",
			],
			[
				"nama" => "Passenger Ship",
			],
			[
				"nama" => "Kapal Lainnya",
			],
		];

		$jenisKapal = new JenisKapalModel();

		$jenisKapal->insertBatch($data);
	}
}
