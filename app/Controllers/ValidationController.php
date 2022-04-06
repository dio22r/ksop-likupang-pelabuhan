<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Helpers\LaporanHelper;
use App\Helpers\PengoprasianKapalHelper;
use App\Helpers\QrcodeHelper;
use CodeIgniter\API\ResponseTrait;
use App\Models\QrcodeTokenModel;


class ValidationController extends BaseController
{
	use ResponseTrait;

	public function __construct()
	{
		$this->opKapalHelper = new PengoprasianKapalHelper();
		$this->lapHelper = new LaporanHelper();
		$this->qrHelper = new QrcodeHelper();
	}

	public function index()
	{
	}

	public function qrcode($token)
	{
		$arrData = $this->qrHelper->encode_qrcode_token($token);
		if (!$arrData) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			die();
		}

		if ($arrData["type"] != 1) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			die();
		}
		// 
		$id = $arrData["arrContent"]->id;
		$arrData = $this->opKapalHelper->retrieve_data_form($id);

		if (!$arrData) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			die;
		}

		$qrcode = $this->qrHelper->retrieve_qrcode(1, ["id" => $id]);

		$arrView = [
			"title" => "Data Tambat",

			"arrData" => $arrData["arrData"],
			"arrFile" => $arrData["arrFile"],
			"arrValidasi" => $arrData["arrValidasi"],
			"arrDataBarang" => $arrData["arrDataBarang"],
			"qrcode" => false,
			"preview" => true
		];

		return view("/admin_view/pengoprasian-kapal/vw_print_laporan", $arrView);
	}

	public function qrcodeLaporanBulanan($token)
	{
		$arrData = $this->qrHelper->encode_qrcode_token($token);
		if (!$arrData) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			die();
		}

		if ($arrData["type"] != 2) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			die();
		}

		$year = $arrData["arrContent"]->year;
		$month = $arrData["arrContent"]->month;
		$arrData = $this->lapHelper->retrieve_data_laporan_bulanan($year, $month);

		$qrcode = false;
		if ($arrData["data"]) {
			$qrcode = $this->qrHelper->retrieve_qrcode(2, ["year" => $year, "month" => $month]);
		}

		$month = (int) $month;

		$arrView = [
			"title" => "Laporan Bulan " . $this->lapHelper->arrBulan[$month] . " " . $year,
			"arrData" => $arrData["data"],
			"arrStatus" => $this->lapHelper->arrStatus,
			"qrcode" => $qrcode,
			"preview" => true
		];

		return view("/admin_view/laporan/vw_print_bulanan", $arrView);
	}

	public function qrcodeLaporanHarian($token)
	{
		$arrData = $this->qrHelper->encode_qrcode_token($token);
		if (!$arrData) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			die();
		}

		if ($arrData["type"] != 3) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			die();
		}

		$date = $arrData["arrContent"]->date;

		if (!$date) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			return;
		}

		$arrData = $this->lapHelper->retrieve_data_laporan_harian($date);
		$qrcode = false;
		if ($arrData["data"]) {
			$qrcode = $this->qrHelper->retrieve_qrcode(3, ["date" => $date]);
		}

		$arrView = [
			"title" => "Laporan Tanggal " . $date,
			"arrData" => $arrData["data"],
			"arrStatus" => $this->lapHelper->arrStatus,
			"qrcode" => $qrcode,
			"preview" => true
		];

		return view("/admin_view/laporan/vw_print_bulanan", $arrView);
	}
}
