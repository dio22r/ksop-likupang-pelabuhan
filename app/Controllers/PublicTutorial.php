<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class PublicTutorial extends BaseController
{
	public function index()
	{
		$arrView = [
			'page_title' => "Tutorial",
			"arrJs" => [],
			"arrCss" => []
		];

		return view('tutorial/public_view', $arrView);
	}
}
