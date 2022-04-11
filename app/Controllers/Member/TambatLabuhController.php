<?php

namespace App\Controllers\Member;

use App\Controllers\BaseController;
use App\Helpers\MenuHelper;
use App\Helpers\PengoprasianKapalHelper;
use App\Helpers\UserHelper;
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

		$arrWhere = ["operasi_kapal.created_by" => $this->user->id]; // create by who
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

	public function show()
	{
		// 
	}

	public function create()
	{
		// 
	}

	public function store()
	{
		// 
	}

	public function edit()
	{
		// 
	}

	public function update()
	{
		// 
	}

	public function delete()
	{
		// 
	}
}
