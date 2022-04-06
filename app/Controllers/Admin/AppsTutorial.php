<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class AppsTutorial extends BaseController
{
	public function index()
	{

		$arrView = [
			"page_title" => "KSOP Bitung - Tutorial",
			"ctl_id" => "",
		];

		return view('tutorial/admin_view', $arrView);
	}
}
