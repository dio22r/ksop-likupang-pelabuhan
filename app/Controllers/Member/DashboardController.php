<?php

namespace App\Controllers\Member;

use App\Controllers\BaseController;
use App\Helpers\UserHelper;
use CodeIgniter\API\ResponseTrait;

class DashboardController extends BaseController
{
	use ResponseTrait;

	public function __construct()
	{
		// $this->userHelper = new UserHelper;
	}

	public function index()
	{
		return redirect()->to('member/tambat-labuh');
	}
}
