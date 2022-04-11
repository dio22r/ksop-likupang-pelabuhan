<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Helpers\MenuHelper;
use App\Helpers\PengoprasianKapalHelper;
use CodeIgniter\API\ResponseTrait;
use App\Models\OperasiKapalModel;
use App\Models\FileKetModel;
use App\Models\ValidasiKapalModel;
use App\Models\UserModel;
use App\Models\FileLampiranModel;

class PengoprasianKapalController extends BaseController
{
	use ResponseTrait;

	protected $menuId = 2;
	protected $arrAllowOp = [1, 4];

	public function __construct()
	{
		$this->session = \Config\Services::session();

		$this->idUser = $this->session->get("id");
		$this->role = $this->session->get("role");

		$this->menuHelper = new MenuHelper();
		if (!$this->menuHelper->is_menu_authorized($this->menuId)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			return;
		}

		$this->opKapalHelper = new PengoprasianKapalHelper();

		$this->opKapalModel = model("OperasiKapalModel");
		$this->fileKetModel = model("FileKetModel");
		$this->validKapalModel = model("ValidasiKapalModel");
		$this->userModel = model("UserModel");
		$this->flampModel = model("FileLampiranModel");
	}

	public function view_index()
	{
		$isAllowUpdate = false;
		if (in_array($this->role, $this->arrAllowOp)) {
			$isAllowUpdate = true;
		}

		$arrView = [
			"page_title" => "Admin",
			"ctl_id" => $this->menuId,

			"arrJs" => [
				base_url("/assets/js/bootstrap-datepicker.min.js"),
				base_url("/assets/js/controller-admin/pengoprasian-kapal/index.js?v=1")
			],

			"arrCss" => [
				base_url("/assets/css/bootstrap-datepicker3.min.css")
			],
			"isAllowUpdate" => $isAllowUpdate
		];

		return view("/admin_view/pengoprasian-kapal/vw_index", $arrView);
	}

	public function view_form($id)
	{
		if (!in_array($this->role, $this->arrAllowOp)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			die;
		}

		$arrData = $this->opKapalHelper->retrieve_data_form($id);

		if (!$arrData) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			die;
		}

		$arrView = [
			"page_title" => "Form Verifikasi",
			"ctl_id" => $this->menuId,
			"arrJs" => [
				base_url("/assets/js/controller-admin/pengoprasian-kapal/form.js?v=1")
			],
			"arrData" => $arrData["arrData"],
			"arrFile" => $arrData["arrFile"],
			"arrValidasi" => $arrData["arrValidasi"],
			"arrDataBarang" => $arrData["arrDataBarang"]
		];

		return view("/admin_view/pengoprasian-kapal/vw_form", $arrView);
	}

	public function view_detail($id)
	{
		$arrData = $this->opKapalHelper->retrieve_data_form($id);

		if (!$arrData) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			die;
		}

		$backUrl = base_url("/admin/pengoprasian-kapal");
		$getbackurl = $this->request->getGet(("backurl"));
		if ($getbackurl == "laporan") {
			$backUrl = base_url("/admin?activetab=apbn");
		}
		$arrView = [
			"page_title" => "Detail",
			"ctl_id" => $this->menuId,
			"arrJs" => [
				base_url("/assets/js/controller-admin/pengoprasian-kapal/detail.js?v=1")
			],

			"arrData" => $arrData["arrData"],
			"arrFile" => $arrData["arrFile"],
			"arrValidasi" => $arrData["arrValidasi"],
			"arrDataBarang" => $arrData["arrDataBarang"],
			"backUrl" => $backUrl
		];

		return view("/admin_view/pengoprasian-kapal/vw_detail", $arrView);
	}

	public function view_print($id)
	{
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


		$arrView = [
			"title" => "Data Tambat",
			"ctl_id" => $this->menuId,

			"arrData" => $arrData["arrData"],
			"arrFile" => $arrData["arrFile"],
			"arrValidasi" => $arrData["arrValidasi"],
			"arrDataBarang" => $arrData["arrDataBarang"],
			"qrcode" => $qrcode
		];

		return view("/admin_view/pengoprasian-kapal/vw_print_laporan", $arrView);
	}

	// API
	public function index()
	{
		$page = $this->request->getGet("page");
		$perpage = $this->request->getGet("limit");
		$status = $this->request->getGet("status");

		if (!$perpage) $perpage = 20;
		if (trim($page) == "" || $page < 0) $page = 1;
		if ($status == "") $status = 0;

		if ($status == "deleted") {
			$arrData = $this->opKapalHelper->retrieve_json_table_deleted(
				$page,
				$perpage,
				$this->request->getGet("search"),
				"operasi_kapal.created_at"
			);
		} else {
			$arrWhere = ["operasi_kapal.status" => $status];
			$arrData = $this->opKapalHelper->retrieve_json_table(
				$page,
				$perpage,
				$this->request->getGet("search"),
				"operasi_kapal.created_at",
				$arrWhere
			);
		}

		$arrData["data"] = $this->opKapalHelper->add_strtotime($arrData["data"]);

		$arrRes = [
			"data" => $arrData["data"],
			"total" => $arrData["total"],
			"totalpage" => ceil($arrData["total"] / $perpage)
		];

		return $this->respond($arrRes, 200);
	}

	public function show($id)
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

	public function update($id)
	{
		if (!in_array($this->role, $this->arrAllowOp)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			die;
		}

		$arrJson = $this->request->getJSON();

		$arrInsert = [
			"op_kapal_id" => $id,
			"user_id" => $this->idUser,
			"keterangan" => $arrJson->keterangan
		];

		$this->opKapalModel->transStart();

		try {
			$arrValidate = $this->validKapalModel->where("op_kapal_id", $id)->first();
			if ($arrValidate) {
				$arrInsert["id"] = $arrValidate["id"];
			}

			$status = $this->validKapalModel->save($arrInsert);

			foreach ($arrJson->files as $key => $objVal) {
				$this->flampModel
					->where([
						"id_op_kapal" => $id,
						"id_file_ket" => $objVal->id
					])
					->set(["status" => $objVal->val])
					->update();
			}
		} catch (\Exception $e) {
			return $this->respond(["status" => false], 401);
		}

		$arrUpdate = ["status" => $arrJson->status];

		$status = $this->opKapalModel->update($id, $arrUpdate);
		$this->opKapalModel->transComplete();
		$status = $this->opKapalModel->transStatus();

		$arrRes = [
			"status" => $status
		];

		return $this->respond($arrRes, 200);
	}

	public function delete($id)
	{
		if (!in_array($this->role, $this->arrAllowOp)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			die;
		}

		$arrData = $this->opKapalModel->find($id);
		if (!$arrData) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			die;
		}

		$arrSave = [
			"op_kapal_id" => $id,
			"user_id" => $this->session->get("id"), // get id in session
			"keterangan" => "Data dihapus oleh operator"
		];

		$arrSearch = $this->validKapalModel->where("op_kapal_id", $id)->first();

		$status = false;
		if ($arrData["status"] == 0 && !$arrSearch) {
			$this->opKapalModel->transStart();
			$status = $this->opKapalModel->delete($id);
			$this->validKapalModel->save($arrSave);
			$this->opKapalModel->transComplete();
			$status = $this->opKapalModel->transStatus();
		}


		$arrRes = [
			"status" => $status
		];

		return $this->respond($arrRes, 200);
	}
}
