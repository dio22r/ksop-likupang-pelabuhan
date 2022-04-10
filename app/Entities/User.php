<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class User extends Entity
{
	const USER_ROLE_ADMIN = 1;
	const USER_ROLE_KEP_KANTOR = 2;
	const USER_ROLE_KEP_SEKSI = 3;
	const USER_ROLE_OPERATOR = 4;
	const USER_ROLE_STAKEHOLDER = 5;
	const USER_ROLE_MEMBER = 6;

	const USER_STATUS_ACTIVE = 1;
	const USER_STATUS_NONACTIVE = 0;

	protected $datamap = [];
	protected $dates   = [
		'created_at',
		'updated_at',
		'deleted_at',
	];
	protected $casts   = [];

	public function isMember()
	{
		if ($this->role == User::USER_ROLE_MEMBER) {
			return true;
		}

		return false;
	}
}
