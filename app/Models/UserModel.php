<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'user';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = ['nama', 'username', 'password', 'role', 'status'];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

	// Validation
	protected $validationRules      = [
		"nama" => "required|min_length[3]",
		'username' => 'required|is_unique[user.username,id,{id}]|alpha_numeric|min_length[3]',
		"password" => "min_length[5]",
		"role" => "required",
	];

	protected $validationMessages   = [
		"nama" => [
			"required" => "Nama Harus di isi",
			"min_length" => "Nama harus lebih dari 3 huruf",
		],
		"username" => [
			"required" => "Username harus di isi",
			"min_length" => "Username harus lebih dari 3 huruf",
			"alpha_numeric" => "Username hanya",
			"is_unique" => "Username sudah ada"
		],
		"password" => [
			"min_length" => "password harus lebih dari 5 karakter"
		],
		"role" => [
			"required" => "User Role harus diisi"
		]
	];
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks       = true;
	protected $beforeInsert         = ['hashPassword'];
	protected $afterInsert          = [];
	protected $beforeUpdate         = ['hashPassword'];
	protected $afterUpdate          = [];
	protected $beforeFind           = [];
	protected $afterFind            = [];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];

	protected function hashPassword(array $data)
	{
		if (!isset($data['data']['password'])) return $data;

		$data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);

		return $data;
	}
}
