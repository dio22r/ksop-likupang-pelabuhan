<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Helpers\LaporanHelper;
use App\Helpers\MenuHelper;
use App\Helpers\PengoprasianKapalHelper;
use App\Helpers\QrcodeHelper;
use CodeIgniter\API\ResponseTrait;

use App\Models\OperasiKapalModel;

class LaporanController extends BaseController
{
	use ResponseTrait;

	protected $menuId = 1;

	public function __construct()
	{
		$this->LapHelper = new LaporanHelper();
		$this->menuHelper = new MenuHelper();
		$this->opKapalHelper = new PengoprasianKapalHelper();
		$this->qrHelper = new QrcodeHelper;

		$this->opKapalModel = model("OperasiKapalModel");

		if (!$this->menuHelper->is_menu_authorized($this->menuId)) {
			$redir = base_url("/admin/pengoprasian-kapal");
			header("Location: $redir");
			exit;
		}
	}

	public function vw_index()
	{
		$years = $this->LapHelper->retrieve_year();
		$activeTab = $this->request->getGet("activetab");

		$arrView = [
			"page_title" => "Home",
			"ctl_id" => $this->menuId,

			"arrJs" => [
				base_url("/assets/js/bootstrap-datepicker.min.js"),
				base_url("/assets/js/controller-admin/laporan/index.js?v=1"),
			],

			"arrCss" => [
				base_url("/assets/css/bootstrap-datepicker3.min.css")
			],

			"arrYears" => $years,
			"arrBulan" => $this->LapHelper->arrBulan,
			"activeTab" => $activeTab,
			"arrConfig" => [
				"activeTab" => $activeTab
			]
		];

		return view("/admin_view/laporan/vw_index", $arrView);
	}

	public function print_bulanan()
	{
		$year = $this->request->getGet("year");
		$month = $this->request->getGet("month");

		if (!is_numeric($year) || !is_numeric($month)) {
			$year = date("Y");
			$month = date("m");
		}

		$arrData = $this->LapHelper->retrieve_data_laporan_bulanan($year, $month);

		$qrcode = false;
		if ($arrData["data"]) {
			$qrcode = $this->qrHelper->retrieve_qrcode(2, ["year" => $year, "month" => $month]);
		}

		$month = (int) $month;

		$arrView = [
			"title" => "Laporan Bulan " . $this->LapHelper->arrBulan[$month] . " " . $year,
			"arrData" => $arrData["data"],
			"arrStatus" => $this->LapHelper->arrStatus,
			"qrcode" => $qrcode,
			"preview" => true
		];

		return view("/admin_view/laporan/vw_print_bulanan", $arrView);
	}

	public function print_harian()
	{
		$date = $this->request->getGet("date");

		if (!$date) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			return;
		}

		$arrData = $this->LapHelper->retrieve_data_laporan_harian($date);
		$qrcode = false;
		if ($arrData["data"]) {
			$qrcode = $this->qrHelper->retrieve_qrcode(3, ["date" => $date]);
		}

		$arrView = [
			"title" => "Laporan Tanggal " . $date,
			"arrData" => $arrData["data"],
			"arrStatus" => $this->LapHelper->arrStatus,
			"qrcode" => $qrcode,
			"preview" => true
		];

		return view("/admin_view/laporan/vw_print_bulanan", $arrView);
	}

	public function print_apbn()
	{
		$year = $this->request->getGet("year");
		$month = $this->request->getGet("month");

		if (!is_numeric($year) || !is_numeric($month)) {
			$year = date("Y");
			$month = date("m");
		}

		$arrWhere = [
			"operasi_kapal.status" => 1,
			"operasi_kapal.tambat_diminta" => 9
		];

		$arrData = $this->LapHelper->retrieve_data_laporan_bulanan(
			$year,
			$month,
			$arrWhere
		);
		// $arrData = ["data" => []];

		$month = (int) $month;

		$arrView = [
			"title" => "Laporan Dermaaga TPB (APBN) Bulan " . $this->LapHelper->arrBulan[$month] . " " . $year,
			"arrData" => $arrData["data"],
			"arrStatus" => $this->LapHelper->arrStatus,
			"qrcode" => false,
		];

		return view("/admin_view/laporan/vw_print_bulanan", $arrView);
	}

	// API
	public function index_bulan($year)
	{
		$arrData = $this->LapHelper->retrieve_bulan($year);

		$arrRes = [
			"status" => true,
			"data" => $arrData["data"]
		];

		return $this->respond($arrRes, 200);
	}

	public function api_statistik($year)
	{
		$arrStats = $this->LapHelper->retrieve_statistic($year);

		$arrStats["menunggu"] = $arrStats["menunggu"] + $arrStats["perbaikan"];
		$arrRes = [
			"status" => true,
			"arrStats" => $arrStats
		];

		return $this->respond($arrRes, 200);
	}

	public function apbn_data()
	{
		$years = $this->request->getGet("year");
		$month = $this->request->getGet("month");

		$page = $this->request->getGet("page");
		$perpage = $this->request->getGet("limit");

		if (!$perpage) $perpage = 10;
		if (trim($page) == "" || $page < 0) $page = 1;


		if (!$years) {
			$years = date("Y");
		}

		$arrWhere = [
			"status" => 1,
			"tambat_diminta" => 9,
			"YEAR(operasi_kapal.created_at)" => $years
		];

		if ($month) {
			$arrWhere["MONTH(operasi_kapal.created_at)"] = $month;
		}

		$search = $this->request->getGet("search");
		if ($search) {
			$arrWhere = [
				"status" => 1,
				"tambat_diminta" => 9
			];
		}

		$arrData = $this->opKapalHelper->retrieve_json_table(
			$page,
			$perpage,
			$search,
			"operasi_kapal.created_at",
			$arrWhere
		);

		$arrRes = [
			"data" => $arrData["data"],
			"total" => $arrData["total"],
			"totalpage" => ceil($arrData["total"] / $perpage)
		];

		return $this->respond($arrRes, 200);
	}
}
