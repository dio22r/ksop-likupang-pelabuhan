<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class RegisterController extends BaseController
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

		return view("/member/auth/register", [
			"actionUrl" => base_url('/register'),
			"errors" => $this->session->getFlashdata('error')
		]);
	}

	public function doRegister()
	{

		$validation = $this->userHelper->validationRegister();
		if (!$validation->withRequest($this->request)->run()) {
			return redirect()->back()->withInput()
				->with("error", $validation->getErrors());
		}

		$check = $this->userHelper->verify_captcha($this->request);
		// $check["success"] = true;
		if (!$check["success"]) {
			return redirect()->back()->withInput()
				->with("error", ["Centang tombol validasi terlebih dahulu"]);
		}

		$arrRes = $this->userHelper->registerMember($this->request);

		if (!$arrRes["status"]) {
			return redirect()->back()->withInput()
				->with("error", $arrRes["arrError"]);
		}

		return redirect()->to("login")->withInput()
			->with("success", "Pendaftaran Berhasil");
	}
}
