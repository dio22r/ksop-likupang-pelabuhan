<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Helpers\HomeHelper;

class FileDiscoveryController extends BaseController
{
	public function index()
	{
		//
	}

	protected function show_file($arrFile)
	{
		$file = $arrFile["filepath"];
		$title = $arrFile["arrData"]["keterangan"];

		$arrTemp = explode(".", $arrFile["arrData"]["filename"]);

		$mime = "application/pdf";
		if ($arrTemp) {
			$extension = $arrTemp[count($arrTemp) - 1];
			if ($extension != "pdf") {
				$mime = "image/jpg";
			}
		}

		header('Title: "' . basename($title) . '"');
		header('Content-Description: File Transfer');
		header('Content-Type: ' . $mime);
		header('Content-Disposition: filename="' . basename($title) . '"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		readfile($file);
		exit;
	}
	public function file_lampiran($idFile)
	{
		$filLampHelper = new \App\Helpers\FileLampiranHelper();

		$arrFile = $filLampHelper->get_file($idFile);
		if (!$arrFile) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			return;
		}

		$file = $arrFile["filepath"];
		if (!file_exists($file)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			return;
		}

		$this->show_file($arrFile);
	}

	public function file_lampiran_public($idFile, $token)
	{
		$qrcodeModel = model("QrcodeTokenModel");
		$filLampHelper = new \App\Helpers\FileLampiranHelper();

		$arrToken = $qrcodeModel
			->where("token", $token)
			->where("type", 4)
			->first();

		if (!$arrToken) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			return;
		}

		$content = json_decode($arrToken["content"]);
		$arrWhere = [
			"t1.id" => $content->id,
			"t1.updated_at >" => date("Y-m-d", strtotime("- 7 days"))
		];

		$arrWhereIn = [
			"field" => "t1.status",
			"value" => [0, 1, 2],
		];

		$arrFile = $filLampHelper->get_file($idFile, $arrWhere, $arrWhereIn);

		if (!$arrFile) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			return;
		}

		$file = $arrFile["filepath"];
		if (!file_exists($file)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			return;
		}



		$this->show_file($arrFile);
	}
}
