<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Entities\User;
use CodeIgniter\API\ResponseTrait;

class LoginController extends BaseController
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
		if ($this->userHelper->check_login() !== false) {
			return redirect()->to("/member");
		}

		return view("/member/auth/login", [
			"actionUrl" => base_url('/login')
		]);
	}

	public function login()
	{
		$status = false;
		$msg = "Harap centang kode keamanan";

		// $check = $this->userHelper->verify_captcha($this->request);
		$check["success"] = true;
		if ($check["success"]) {
			$username = $this->request->getPost("username");
			$password = $this->request->getPost("password");

			$user = $this->userModel
				->where(['username' => $username])
				->where(['status' => User::USER_STATUS_ACTIVE])
				->where(['role' => User::USER_ROLE_MEMBER])
				->first();

			$msg = "Username Tidak Ditemukan";
			if ($user) {
				$msg = "Password Salah";
				if (password_verify($password, $user->password)) {
					$this->userHelper->set_login_info($user);
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
			"page_title" => "Ganti Password",

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
