<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\DermagaModel;

class Dermaga extends Seeder
{
	public function run()
	{
		$data = [
			[
				"nama_dermaga" => "Kolam Pelabuhan Laut",
				"type" => 1,
				"status" => 1
			],
			[
				"nama_dermaga" => "Area Kapal Mati",
				"type" => 1,
				"status" => 1
			],
			[
				"nama_dermaga" => "Area Labuh Wisata",
				"type" => 1,
				"status" => 1
			],
			[
				"nama_dermaga" => "Dermaga Laut Segment 1",
				"type" => 2,
				"status" => 0
			],
			[
				"nama_dermaga" => "Dermaga Laut Segment 2",
				"type" => 2,
				"status" => 0
			],
			[
				"nama_dermaga" => "Dermaga Laut Segment 3",
				"type" => 2,
				"status" => 0
			],
			[
				"nama_dermaga" => "Dermaga Apung",
				"type" => 2,
				"status" => 0
			],
			[
				"nama_dermaga" => "Dermaga Plengsengan",
				"type" => 2,
				"status" => 0
			],
			[
				"nama_dermaga" => "Dermaga Pelra",
				"type" => 2,
				"status" => 0
			],
			[
				"nama_dermaga" => "Tersus MSM",
				"type" => 2,
				"status" => 0
			],
			[
				"nama_dermaga" => "Tersus Lihaga",
				"type" => 2,
				"status" => 0
			],
			[
				"nama_dermaga" => "Tersus Bangka",
				"type" => 2,
				"status" => 0
			],
			[
				"nama_dermaga" => "Tersus Gangga",
				"type" => 2,
				"status" => 0
			]
		];

		$dermagaModel = new DermagaModel();

		$dermagaModel->insertBatch($data);
	}
}
