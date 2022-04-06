<?php

namespace App\Controllers;

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

	public function index()
	{
		//
	}

	public function view_login()
	{
		if ($this->userHelper->check_login() !== false) {
			$redir = base_url("/admin");
			header("Location: $redir");
			exit;
		}

		return view("/admin_view/login_view");
	}

	public function api_check_login()
	{
		$status = false;
		$msg = "Harap centang kode keamanan";

		$check = $this->userHelper->verify_captcha($this->request);
		// $check["success"] = true;
		if ($check["success"]) {
			$username = $this->request->getPost("username");
			$password = $this->request->getPost("password");

			$arrData = $this->userModel
				->where(['username' => $username])
				->where(['status' => 1])
				->first();

			$msg = "Username Tidak Ditemukan";
			if ($arrData) {
				$msg = "Password Salah";
				if (password_verify($password, $arrData["password"])) {
					$this->userHelper->set_login_info($arrData);
					$status = true;
					$msg = "Login Berhasil";
				}
			}
		}

		$arrRes = [
			"status" => $status,
			"msg" => $msg
		];

		return $this->respond($arrRes, 200);
	}

	public function view_change_password()
	{
		$arrView = [
			"ctl_id" => 0,
			"page_title" => "KSOP Bitung - Ganti Password",

			"arrJs" => [
				base_url("/assets/js/controller-admin/ganti_password.js")
			]
		];

		return view("/admin_view/ganti_password_view", $arrView);
	}

	public function api_change_password()
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
