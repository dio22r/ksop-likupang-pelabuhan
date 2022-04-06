<?php

namespace App\Database\Seeds;

use App\Models\MenuModel;
use CodeIgniter\Database\Seeder;

class Menu extends Seeder
{
	public function run()
	{
		$data = [
			[
				"title" => "Home",
				"href" => "/admin",
				"order" => 1,
				"parent_id" => 0
			],
			[
				"title" => "Pengoprasian Kapal",
				"href" => "/admin/pengoprasian-kapal",
				"order" => 2,
				"parent_id" => 0
			],
			[
				"title" => "User",
				"href" => "/admin/user-management",
				"order" => 3,
				"parent_id" => 0
			]
		];

		$menuModel = new MenuModel();

		$menuModel->insertBatch($data);
	}
}
