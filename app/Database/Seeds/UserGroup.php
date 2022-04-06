<?php

namespace App\Database\Seeds;

use App\Models\UserGroupModel;
use CodeIgniter\Database\Seeder;

class UserGroup extends Seeder
{
	public function run()
	{
		$data = [
			[
				"title" => "Administrator",
			],
			[
				"title" => "Kepala Kantor",
			],
			[
				"title" => "Kepala Seksi",
			],
			[
				"title" => "Operator",
			],
			[
				"title" => "Stakeholder",
			],
		];

		$userGroupModel = new UserGroupModel();

		$userGroupModel->insertBatch($data);
	}
}
