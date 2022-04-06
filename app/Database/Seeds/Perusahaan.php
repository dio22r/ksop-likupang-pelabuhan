<?php

namespace App\Database\Seeds;

use App\Models\PerusahaanModel;
use CodeIgniter\Database\Seeder;

class Perusahaan extends Seeder
{
	public function run()
	{
		$data = [
			[
				"nama" => "PT. DJAKARTA LLOYD",
				"keterangan" => "",
			],
			[
				"nama" => "PT. GARUTAMA PUTRA MALUKU",
				"keterangan" => "",
			],
			[
				"nama" => "PT. CAHAYA ANAK KASISI",
				"keterangan" => "",
			],
			[
				"nama" => "PT. LAUTAN RIZKY SEMESTA",
				"keterangan" => "",
			],
			[
				"nama" => "PT. BINTANG BAHARI MANDIRI",
				"keterangan" => "",
			],
			[
				"nama" => "PT. USDA SEROJA JAYA",
				"keterangan" => "",
			],
			[
				"nama" => "PT SAMUDERA INDAH NUSANTARA",
				"keterangan" => "",
			],
		];

		$perusahaanModel = new PerusahaanModel();

		$perusahaanModel->insertBatch($data);
	}
}
