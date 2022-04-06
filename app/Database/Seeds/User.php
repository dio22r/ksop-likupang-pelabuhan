<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use \App\Helpers\UserHelper;

class User extends Seeder
{
	public function run()
	{
		$userHelper = new UserHelper();

		$data = [
			[
				"nama" => "Administrator",
				"username" => "admin",
				"password" => "12345",
				"role" => 1,
				'status' => 1
			],
			[
				"nama" => "Operator 1",
				"username" => "operator1",
				"password" => "12345",
				"role" => 4,
				'status' => 1
			],
		];

		foreach ($data as $key => $arrVal) {
			$userHelper->insert_data($arrVal);
		}
	}
}
