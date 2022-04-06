<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\OperasiKapalModel;
use CodeIgniter\Test\Fabricator;




class DummyOperasiKapal extends Seeder
{
	public $arrDate = [];

	public function __construct()
	{
		$formater = [
			"nama_kapal" => "name",
			"bendera" => "country",
			"gt" => "randomDigit",
			"dwt" => "randomDigit",
			"loa" => "randomDigit",
			"pemilik" => "name",
			"nama_agen" => "company",
			"nama_nahkoda" => "name",
			"trayek" => "city",
			"jenis_pelayaran" => "city",
			"pelabuhan_asal" => "city",
			"pelabuhan_tujuan" => "city"
		];
		$this->fabricator = new Fabricator(OperasiKapalModel::class, $formater);
	}

	public function generate_date()
	{
		$start = new \DateTime("2021-04-01");
		$end = new \DateTime("2021-07-12");
		$interval = new \DateInterval("P1D");
		$range = new \DatePeriod($start, $interval, $end);
		foreach ($range as $date) {
			$this->arrDate[] = $date->format("Y-m-d");
		}
	}

	public function run()
	{
		$this->generate_date();

		foreach ($this->arrDate as $key => $val) {
			$test = $this->fabricator->make(5);

			$OperasiKapalModel = new OperasiKapalModel();
			foreach ($test as $key2 => $arrVal) {
				$arrVal["created_at"] = $val . " " . str_pad($key2, 2, "0", STR_PAD_LEFT) . ":00:00";
				$arrVal["eta_date"] = $val;
				$arrVal["eta_time"] = date("H:i:s");
				$arrVal["etd_date"] = $val;
				$arrVal["etd_time"] = date("H:i:s");
				$arrVal["pbm"] = "test pbm";
				$arrVal["rkbm"] = "1";
				$arrVal["jenis_kapal"] = ($key2 % 11) + 1;

				$arrLabuh = [12, 13, 14, 15];
				$arrVal["labuh_diminta"] = $arrLabuh[($key2 % 4)];

				$arrTambat = [
					1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11,
					16, 17, 18, 19, 20, 22, 23, 24, 25, 26,
					27, 28, 29, 30, 31, 32, 33, 34, 35, 36,
					37, 38, 39, 40, 41, 42, 43, 44, 45, 46
				];
				$arrVal["tambat_diminta"] = $arrTambat[($key2 % 40)];

				$arrDock = [22, 24, 25, 26, 27, 28, 45];
				$arrVal["dock_diminta"] = $arrDock[($key2 % 7)];

				$arrVal["rencana_kegiatan"] = $key % 2;

				$mod = $key2 % 3;

				if ($mod == 2) {
					$arrVal["status"] = 1;
				} elseif ($mod == 1) {
					$arrVal["status"] = -1;
				} else {
					$arrVal["status"] = 1;
				}

				$status = $OperasiKapalModel->insert($arrVal);
				if ($status) {
					echo  "Oke\n";
				} else {
					echo  "NO\n";
				}
			}
		}




		// $fileModel->insertBatch($data);
	}
}
