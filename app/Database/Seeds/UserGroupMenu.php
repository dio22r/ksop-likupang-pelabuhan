<?php

namespace App\Database\Seeds;

use App\Models\UserGroupMenuModel;
use CodeIgniter\Database\Seeder;

class UserGroupMenu extends Seeder
{
	public function run()
	{
		$data = [
			[
				"user_group_id" => 1,
				"menu_id" => 1
			],
			[
				"user_group_id" => 1,
				"menu_id" => 2
			],
			[
				"user_group_id" => 1,
				"menu_id" => 3
			],
			[
				"user_group_id" => 2,
				"menu_id" => 1
			],
			[
				"user_group_id" => 2,
				"menu_id" => 2
			],
			[
				"user_group_id" => 3,
				"menu_id" => 1
			],
			[
				"user_group_id" => 3,
				"menu_id" => 2
			],
			[
				"user_group_id" => 4,
				"menu_id" => 1
			],
			[
				"user_group_id" => 4,
				"menu_id" => 2
			],
			[
				"user_group_id" => 5,
				"menu_id" => 2
			],
		];

		$ugMenuModel = new UserGroupMenuModel();

		$ugMenuModel->insertBatch($data);
	}
}
