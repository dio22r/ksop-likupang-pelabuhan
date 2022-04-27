<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Traits\CaptchaTrait;
use CodeIgniter\API\ResponseTrait;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;

class RegisterController extends BaseController
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

		return view("/member/auth/register", [
			"actionUrl" => base_url('/register'),
			"errors" => $this->session->getFlashdata('error'),
			"captcha" => $captchaBuilder
		]);
	}

	public function doRegister()
	{
		$validation = $this->userHelper->validationRegister();
		if (!$validation->withRequest($this->request)->run()) {
			return redirect()->back()->withInput()
				->with("error", $validation->getErrors());
		}

		$captcha = $this->request->getPost("captcha");
		if (!$this->validateCaptcha($captcha)) {
			return redirect()->back()->withInput()
				->with("error", ["Kode keamanan salah."]);
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
