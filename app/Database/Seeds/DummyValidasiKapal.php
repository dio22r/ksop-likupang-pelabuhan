<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

use App\Models\OperasiKapalModel;
use App\Models\ValidasiKapalModel;

class DummyValidasiKapal extends Seeder
{
	public function run()
	{
		$opKapalModel = new OperasiKapalModel();
		$validasiKapalModel = new ValidasiKapalModel();

		$arrData = $opKapalModel->select("operasi_kapal.created_at, operasi_kapal.id")
			->join("validasi_kapal t1", "operasi_kapal.id = t1.op_kapal_id", "left")
			->where("operasi_kapal.status !=", 0)
			->where("t1.id", null)
			->findAll(50, 0);

		$arrInsert = [];
		foreach ($arrData as $key => $val) {
			$arrInsert[] = [
				"created_at" => $val["created_at"],
				"op_kapal_id" => $val["id"],
				"user_id" => 1,
				"keterangan" => "Keterangan id:" . $val["id"]
			];
		}

		if ($arrInsert)
			$validasiKapalModel->insertBatch($arrInsert);
		else
			echo "done";
	}
}
