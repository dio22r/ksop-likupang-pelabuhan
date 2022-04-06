<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\FileKetModel;
use App\Models\DermagaModel;
use App\Models\JenisKapalModel;

use App\Helpers\FileLampiranHelper;
use App\Helpers\HomeHelper;
use App\Models\JenisBarangModel;
use App\Models\QrcodeTokenModel;

use function PHPSTORM_META\map;

class Home extends BaseController
{
	use ResponseTrait;

	public function vw_index()
	{

		$homeHelper = new HomeHelper();
		$arrrData = $homeHelper->get_stat_data(2);

		$arrView = [
			'page_title' => "Selamat Datang",
			"arrJs" => [
				"https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js",
				base_url("/assets/js/bootstrap-datepicker.min.js"),
				base_url("/assets/js/controller/index.js?v=1"),
			],

			"arrCss" => [
				base_url("/assets/css/bootstrap-datepicker3.min.css")
			],

			"arrConfig" => [
				"data_stats" => [
					"label" => $arrrData["label"],
					"total" => $arrrData["total"]
				]
			]
		];

		return view('public_view/vw_index', $arrView);
	}

	public function view_daftar()
	{
		$fileKetModel = model("FileKetModel");
		$dermagaModel = model("DermagaModel");
		$jenisKapalModel = model("JenisKapalModel");
		$jenisBarangModel = model("JenisBarangModel");

		$arrFileKet = $fileKetModel->find();
		$arrLabuh = $dermagaModel->where("type", 1)->where("status", 1)->find();
		$arrTambat = $dermagaModel->where("type", 2)->find();
		$arrDock = $dermagaModel->where("type", 2)->where("status", 1)->find();
		$arrJenisKapal = $jenisKapalModel->find();
		$arrJenisBarang = $jenisBarangModel->find();

		$arrView = [
			'page_title' => "Form Pendaftaran",
			"arrJs" => [
				base_url("/assets/js/bootstrap-datepicker.min.js"),
				base_url("/assets/js/controller/daftar.js?v=1.1")
			],
			"arrCss" => [base_url("/assets/css/bootstrap-datepicker3.min.css")],

			'arrFileKet' => $arrFileKet,
			'arrLabuh' => $arrLabuh,
			'arrTambat' => $arrTambat,
			'arrDock' => $arrDock,
			'arrJenisKapal' => $arrJenisKapal,
			"arrJenisBarang" => $arrJenisBarang,

			"arrConfig" => [
				"arrJenisBarang" => $arrJenisBarang
			]

		];

		return view('public_view/vw_form', $arrView);
	}

	public function vw_edit($token)
	{
		$qrcodeModel = model("QrcodeTokenModel");
		$opKplModel = model("App\Models\OperasiKapalModel");
		$opKapalHelper = new \App\Helpers\PengoprasianKapalHelper();

		$arrToken = $qrcodeModel->where("token", $token)->first();
		if (!$arrToken) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			return;
		}

		$content = json_decode($arrToken["content"]);
		$arrData = $opKplModel->find($content->id);
		if (!$arrData) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			return;
		}

		$interval = "7 days";
		$active_date = date("Y-m-d", strtotime($arrData["updated_at"] . " + " . $interval));
		if (date("Y-m-d") > $active_date) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			return;
		}

		// if (!in_array($arrData["status"], [0, 2])) {
		// 	throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		// 	return;
		// }

		$arrData = $opKapalHelper->retrieve_data_form($content->id);

		$arrView = [
			"page_title" => "Form Edit",
			"arrJs" => [
				base_url("/assets/js/controller/edit.js?v=1")
			],
			"token" => $token,
			"arrData" => $arrData["arrData"],
			"arrFile" => $arrData["arrFile"],
			"arrValidasi" => $arrData["arrValidasi"],
			"arrDataBarang" => $arrData["arrDataBarang"]
		];

		return view('public_view/vw_edit', $arrView);
	}

	// API
	public function index()
	{
		$homeHelper = new HomeHelper();

		$page = $this->request->getGet("page");
		$perpage = $this->request->getGet("limit");

		if (!$perpage) $perpage = 20;

		if (trim($page) == "" || $page < 0) {
			$page = 1;
		}

		$arrWhere = [];

		$search = $this->request->getGet("search");
		if ($search) {
			if ($search > date('Y-m-d', strtotime('-30 day'))) {
				$arrWhere = [
					"created_at >=" => $search . " 00:00:00",
					"created_at <=" => $search . " 23:59:59"
				];
			} else {
				$arrWhere = [
					"created_at <" => "0000-00-00 00:00:00"
				];
			}
		} else {
			$search = date('Y-m-d', strtotime('-30 day'));
			$arrWhere = [
				"created_at >=" => $search . " 00:00:00",
			];
		}


		$arrData = $homeHelper->retrieve_json_table(
			$page,
			$perpage,
			$search,
			"created_at",
			$arrWhere
		);

		$arrRes = [
			"data" => $arrData["data"],
			"total" => $arrData["total"],
			"totalpage" => ceil($arrData["total"] / $perpage)
		];

		return $this->respond($arrRes, 200);
	}

	public function show($id)
	{
		$opKplModel = model("App\Models\OperasiKapalModel");

		$arrData = $opKplModel->select("operasi_kapal.created_at as created_at, nama_kapal, nama_agen, bendera, status, t1.created_at as proceed_at, keterangan")
			->join("validasi_kapal t1", "operasi_kapal.id = t1.op_kapal_id", "left")
			->where("operasi_kapal.id", $id)
			->first();

		$status = false;
		if ($arrData) {
			$arrData["keterangan"] = nl2br($arrData["keterangan"]);
			$status = true;
		}

		$arrRes = [
			"status" => $status,
			"arrData" => $arrData
		];

		return $this->respond($arrRes, 200);
	}

	public function create()
	{
		$qrcodeHelper = new \App\Helpers\QrcodeHelper();
		$homeHelper = new HomeHelper();

		$arrPost = $this->request->getPost();
		$files = $this->request->getFiles("file");

		$sizeLimit = 5 * 1024;
		$arrRules = [];
		foreach ($files["file"] as $key => $file) {
			$arrRules["file.$key"] = "max_size[file.$key, $sizeLimit ]|mime_in[file.$key,application/pdf,image/jpg,image/jpeg]";
		}

		$status = $this->validate($arrRules);

		$qrcode = ["img" => false, "url" => false];
		if ($status) {
			$arrRet = $homeHelper->insert_data($arrPost, $files);
			$id = $arrRet["id"];
			$status = $arrRet["status"];
			$arrErr = $arrRet["arrErr"];

			$qrcode = $qrcodeHelper->retrieve_plain_md5_token(4, ["id" => $id]);
		} else {
			$arrErr["file"] = "File tidak boleh lebih dari 5 MB dan harus PDF atau jpg";
		}

		$arrRes = [
			"status" => $status,
			"arrErr" => $arrErr,
			"qrcodeimg" => $qrcode["img"],
			"qrcodeurl" => $qrcode["url"]
		];

		return $this->respond($arrRes, 200);
	}

	public function update($token)
	{
		$qrcodeModel = model("QrcodeTokenModel");
		$opKplModel = model("App\Models\OperasiKapalModel");

		$homeHelper = new HomeHelper();

		$arrToken = $qrcodeModel->where("token", $token)->first();
		if (!$arrToken) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			return;
		}

		$content = json_decode($arrToken["content"]);
		$arrData = $opKplModel->find($content->id);
		if (!$arrData) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			return;
		}

		if (!in_array($arrData["status"], [2])) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			return;
		}

		$files = $this->request->getFiles("file");

		$sizeLimit = 5 * 1024;
		$arrRules = [];
		foreach ($files["file"] as $key => $file) {
			$arrRules["file.$key"] = "max_size[file.$key, $sizeLimit]|mime_in[file.$key,application/pdf,image/jpg,image/jpeg]";
		}

		$status = $this->validate($arrRules);

		$arrErr = [];
		if ($status) {
			$arrRet = $homeHelper->update_data($arrData, $files);
			$id = $arrRet["id"];
			$status = $arrRet["status"];
			$arrErr = $arrRet["arrErr"];
		} else {
			$arrErr["file"] = "File tidak boleh lebih dari 5 MB dan harus PDF atau jpg";
		}

		$arrRes = [
			"status" => $status,
			"arrErr" => $arrErr,
		];

		return $this->respond($arrRes, 200);
	}
}
