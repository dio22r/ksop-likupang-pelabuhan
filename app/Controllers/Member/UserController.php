<?php

namespace App\Controllers\Member;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class UserController extends BaseController
{
	use ResponseTrait;

	public function __construct()
	{
		$this->userHelper = new \App\Helpers\UserHelper();
		$this->userModel = model('App\Models\UserModel');

		$this->session = \Config\Services::session();
	}

	public function change_password()
	{
		return view("/member/user/ganti_password", [
			"page_title" => "Ganti Password",
		]);
	}

	public function do_change_password()
	{
		$arrDet = $this->userHelper->change_password(
			$this->request->getPost("password_old"),
			$this->request->getPost("password"),
			$this->request->getPost("re_password")
		);

		$arrRes = [
			"status" => $arrDet["status"],
			"arrErr" => $arrDet["arrErr"]
		];

		return $this->respond($arrRes, 200);
	}

	public function logout()
	{
		$this->session->destroy();
		return redirect('/');
	}
}
