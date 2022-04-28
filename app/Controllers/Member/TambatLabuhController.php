<?php

namespace App\Controllers\Member;

use App\Controllers\BaseController;
use App\Helpers\Auth;
use App\Helpers\Can;
use App\Helpers\HomeHelper;
use App\Helpers\MenuHelper;
use App\Helpers\PengoprasianKapalHelper;
use App\Helpers\UserHelper;
use App\Models\Eloquent\FileKet;
use App\Models\Eloquent\OperasiKapal;
use App\Policies\TambatLabuhPolicies;
use CodeIgniter\API\ResponseTrait;

class TambatLabuhController extends BaseController
{
	use ResponseTrait;

	public function __construct()
	{
		$this->opKapalHelper = new PengoprasianKapalHelper();

		$this->opKapalModel = model("OperasiKapalModel");
		$this->fileKetModel = model("FileKetModel");
		$this->validKapalModel = model("ValidasiKapalModel");
		$this->userModel = model("UserModel");
		$this->flampModel = model("FileLampiranModel");

		$this->user = (new UserHelper())->getUser();
	}

	public function index()
	{
		return view("/member/tambat-labuh/index", [
			"page_title" => "Member Area",
			"isAllowUpdate" => false
		]);
	}

	public function getList()
	{
		$page = $this->request->getGet("page");
		$perpage = $this->request->getGet("limit");
		// $status = $this->request->getGet("status");

		if (!$perpage) $perpage = 20;
		if (trim($page) == "" || $page < 0) $page = 1;
		// if ($status == "") $status = 0;

		$arrWhere = ["operasi_kapal.created_by" => Auth::User()->id]; // create by who
		$arrData = $this->opKapalHelper->retrieve_json_table(
			$page,
			$perpage,
			$this->request->getGet("search"),
			"operasi_kapal.created_at",
			$arrWhere
		);

		$arrData["data"] = $this->opKapalHelper->add_strtotime($arrData["data"]);

		$arrRes = [
			"data" => $arrData["data"],
			"total" => $arrData["total"],
			"totalpage" => ceil($arrData["total"] / $perpage)
		];

		return $this->respond($arrRes, 200);
	}

	public function getDetail($id)
	{
		Can::view(new TambatLabuhPolicies(), OperasiKapal::find($id));

		$qrcodeHelper = new \App\Helpers\QrcodeHelper();

		$arrData = $this->opKapalModel->select("operasi_kapal.*, t1.created_at as tanggal_diproses, keterangan, user_id, t2.nama as nama_jenis_kapal, t1.id as validate")
			->join("validasi_kapal t1", "operasi_kapal.id = t1.op_kapal_id", "left")
			->join("jenis_kapal t2", "operasi_kapal.jenis_kapal = t2.id")
			->where("operasi_kapal.id", $id)
			->withDeleted()
			->first();

		$status = false;
		if ($arrData) {
			$user = $this->userModel
				->where("id", $arrData["user_id"])
				->first();

			$arrData["user_nama"] = " - ";
			if ($user) {
				$arrData["user_nama"] = $user->nama;
			}

			$qrcode = ["img" => "#", "url" => "#"];
			if (in_array($arrData["status"], [2])) {
				$qrcode = $qrcodeHelper->retrieve_plain_md5_token(4, ["id" => $id]);
			}

			$arrData["qrcodeimg"] = $qrcode["img"];
			$arrData["qrcodeurl"] = $qrcode["url"];

			$status = true;
		}

		$arrRes = [
			"status" => $status,
			"arrData" => $arrData
		];

		return $this->respond($arrRes, 200);
	}

	public function show(int $id)
	{
		$operasiKapal = OperasiKapal::with(
			"Tambat",
			"Labuh",
			"JenisKapal",
			"JenisBarang",
			"ValidasiKapal"
		)
			->find($id);
		if (!$operasiKapal) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			die;
		}

		Can::view(new TambatLabuhPolicies(), $operasiKapal);

		$backUrl = base_url("/member/tambat-labuh");

		$arrFile = FileKet::with(["OperasiKapal" => function ($query) use ($operasiKapal) {
			return $query->where("operasi_kapal.id", "=", $operasiKapal->id);
		}])->get();

		$arrView = [
			"page_title" => "Detail",
			"operasiKapal" => $operasiKapal,
			"arrFile" => $arrFile,
			"validasi" => $operasiKapal->ValidasiKapal,
			"arrBarang" => $operasiKapal->JenisBarang->where("type", "=", 1),
			"arrNonBarang" => $operasiKapal->JenisBarang->where("type", "!=", 1),
			"backUrl" => $backUrl
		];

		return view("/member/tambat-labuh/detail", $arrView);
	}

	public function print(int $id)
	{
		Can::view(new TambatLabuhPolicies(), OperasiKapal::find($id));

		$arrData = $this->opKapalHelper->retrieve_data_form($id);
		if (!$arrData) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			die;
		}

		$qrcode = false;
		if ($arrData["arrData"]["status"] != 0) {
			$qrHelper = new \App\Helpers\QrcodeHelper();
			$qrcode = $qrHelper->retrieve_qrcode(1, ["id" => $id]);
		}

		return view("/admin_view/pengoprasian-kapal/vw_print_laporan", [
			"title" => "Data Tambat",
			"arrData" => $arrData["arrData"],
			"arrFile" => $arrData["arrFile"],
			"arrValidasi" => $arrData["arrValidasi"],
			"arrDataBarang" => $arrData["arrDataBarang"],
			"qrcode" => $qrcode,
			"preview" => true
		]);
	}

	public function create()
	{
		Can::create(new TambatLabuhPolicies());

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

		return view('member/tambat-labuh/form', $arrView);
	}

	public function store()
	{
		Can::create(new TambatLabuhPolicies());

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
			// $id = $arrRet["id"];
			$status = $arrRet["status"];
			$arrErr = $arrRet["arrErr"];

			// $qrcode = $qrcodeHelper->retrieve_plain_md5_token(4, ["id" => $id]);
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

	public function edit(int $id)
	{
		Can::edit(new TambatLabuhPolicies(), OperasiKapal::find($id));

		$fileKetModel = model("FileKetModel");
		$dermagaModel = model("DermagaModel");
		$jenisKapalModel = model("JenisKapalModel");
		$jenisBarangModel = model("JenisBarangModel");

		$opKplModel = model("App\Models\OperasiKapalModel");
		$opKapalHelper = new PengoprasianKapalHelper();

		$arrData = $opKplModel->find($id);
		if (!$arrData) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			return;
		}

		$arrData = $opKapalHelper->retrieve_data_form($id);

		$arrFileKet = $fileKetModel->find();
		$arrLabuh = $dermagaModel->where("type", 1)->where("status", 1)->find();
		$arrTambat = $dermagaModel->where("type", 2)->find();
		$arrDock = $dermagaModel->where("type", 2)->where("status", 1)->find();
		$arrJenisKapal = $jenisKapalModel->find();
		$arrJenisBarang = $jenisBarangModel->find();

		$arrView = [
			"page_title" => "Form Edit",

			'arrFileKet' => $arrFileKet,
			'arrLabuh' => $arrLabuh,
			'arrTambat' => $arrTambat,
			'arrDock' => $arrDock,
			'arrJenisKapal' => $arrJenisKapal,
			"arrJenisBarang" => $arrJenisBarang,

			"arrConfig" => [
				"arrJenisBarang" => $arrJenisBarang,
				"arrDataBarang" => $arrData["arrDataBarang"]
			],

			"arrData" => $arrData["arrData"],
			"arrFile" => $arrData["arrFile"],
			"arrValidasi" => $arrData["arrValidasi"],
			"arrDataBarang" => $arrData["arrDataBarang"]
		];

		return view('member/tambat-labuh/edit', $arrView);
	}

	public function update(int $id)
	{
		Can::edit(new TambatLabuhPolicies(), OperasiKapal::find($id));

		$opKplModel = model("App\Models\OperasiKapalModel");
		$arrData = $opKplModel->find($id);
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
		if ($files) {
			foreach ($files["file"] as $key => $file) {
				$arrRules["file.$key"] = "max_size[file.$key, $sizeLimit]|mime_in[file.$key,application/pdf,image/jpg,image/jpeg]";
			}
		}

		$homeHelper = new HomeHelper();
		$arrData = $homeHelper->populateOpKapal($arrData, $this->request);
		$status = $this->validate($arrRules);

		$arrErr = [];
		if ($status || !$files) {
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

	public function delete(int $id)
	{
		Can::delete(new TambatLabuhPolicies(), OperasiKapal::find($id));
	}
}
