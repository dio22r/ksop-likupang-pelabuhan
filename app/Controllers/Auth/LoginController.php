<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Entities\User;
use App\Traits\CaptchaTrait;
use CodeIgniter\API\ResponseTrait;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;

class LoginController extends BaseController
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
		if ($this->userHelper->check_login() !== false) {
			return redirect()->to("/member");
		}

		$phraseBuilder = new PhraseBuilder(4, '0123456789');
		$captchaBuilder = new CaptchaBuilder(null, $phraseBuilder);
		$captchaBuilder->build();

		$captchaPhrase = $this->setCaptcha($captchaBuilder->getPhrase());

		return view("/member/auth/login", [
			"actionUrl" => base_url('/login'),
			"errors" => $this->session->getFlashdata('error'),
			"captcha" => $captchaBuilder
		]);
	}

	public function login()
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
			->where(['status' => User::USER_STATUS_ACTIVE])
			->where(['role' => User::USER_ROLE_MEMBER])
			->first();

		if (!$user) {
			return redirect()->back()->withInput()
				->with("error", ["Username atau Password Tidak Sesuai."]);
		}

		if (password_verify($password, $user->password)) {
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
