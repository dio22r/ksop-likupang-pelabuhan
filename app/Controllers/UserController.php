<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Traits\CaptchaTrait;
use CodeIgniter\API\ResponseTrait;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;

class UserController extends BaseController
{
	use ResponseTrait, CaptchaTrait;

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

		$captchaBuilder = $this->setCaptcha();

		return view("/admin_view/login_view", [
			"actionUrl" => base_url('/form-login-admin'),
			"errors" => $this->session->getFlashdata('error'),
			"captcha" => $captchaBuilder
		]);
	}

	public function do_login()
	{

		$validation = $this->userHelper->validationLogin();
		if (!$validation->withRequest($this->request)->run()) {
			return redirect()->back()->withInput()
				->with("error", $validation->getErrors());
		}

		$captcha = $this->request->getPost("captcha");
		if (!$this->validateCaptcha($captcha)) {
			return redirect()->back()->withInput()
				->with("error", ["Kode keamanan salah."]);
		}

		$username = $this->request->getPost("username");
		$password = $this->request->getPost("password");

		$user = $this->userModel
			->where(['username' => $username])
			->where(['status' => 1])
			->where(['role !=' => 6])
			->first();

		if (!$user) {
			return redirect()->back()->withInput()
				->with("error", ["Username atau Password Tidak Sesuai."]);
		}

		if (!password_verify($password, $user->password)) {
			return redirect()->back()->withInput()
				->with("error", ["Username atau Password Tidak Sesuai."]);
		}

		$this->userHelper->set_login_info($user);
		return redirect()->to("/member");
	}

	public function view_change_password()
	{
		$arrView = [
			"ctl_id" => 0,
			"page_title" => "Ganti Password",
			"errors" => $this->session->getFlashdata('error'),
			"success" => $this->session->getFlashdata('success'),
			"actionUrl" => base_url('/admin/ganti-password')
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
