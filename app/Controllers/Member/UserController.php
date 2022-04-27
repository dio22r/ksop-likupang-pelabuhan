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
		$arrView = [
			"ctl_id" => 0,
			"page_title" => "Ganti Password",
			"errors" => $this->session->getFlashdata('error'),
			"success" => $this->session->getFlashdata('success'),
			"actionUrl" => base_url('/member/ganti-password')
		];

		return view("/member/user/ganti_password", $arrView);
	}

	public function do_change_password()
	{
		$arrDet = $this->userHelper->change_password(
			$this->request->getPost("password_old"),
			$this->request->getPost("password"),
			$this->request->getPost("re_password")
		);

		if (!$arrDet["status"]) {
			return redirect()->back()
				->with("error", $arrDet["arrErr"]);
		}

		return redirect()->back()
			->with("success", ["Password berhasil di ganti"]);
	}

	public function logout()
	{
		$this->session->destroy();
		return redirect('/');
	}
}
