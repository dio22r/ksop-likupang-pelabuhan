<?php

namespace App\Models;

use CodeIgniter\Model;

class OperasiKapalModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'operasi_kapal';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = true;
	protected $protectFields        = true;
	protected $allowedFields        = [
		"created_at", "nama_kapal", "bendera", "gt", "dwt", "jenis_kapal",
		"loa", "pemilik", "nama_agen", "nama_nahkoda", "trayek",
		"jenis_pelayaran", "eta_date", "eta_time", "etd_date",
		"etd_time", "pelabuhan_asal", "pelabuhan_tujuan",
		"labuh_diminta", "tambat_diminta", "dock_diminta", "pbm", "rkbm",
		"rencana_kegiatan", "status"
	];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

	// Validation
	protected $validationRules      = [
		"nama_kapal" => "required",
		"bendera" => "required",
		"gt" => "required",
		"dwt" => "required",
		"jenis_kapal" => "required",
		"loa" => "required",
		"pemilik" => "required",
		"nama_agen" => "required",
		"nama_nahkoda" => "required",
		"trayek" => "required",
		"jenis_pelayaran" => "required",
		"eta_date" => "required|valid_date",
		"eta_time" => "required",
		"etd_date" => "required",
		"etd_time" => "required",
		"pelabuhan_asal" => "required",
		"pelabuhan_tujuan" => "required",
		"labuh_diminta" => "required",
		"rencana_kegiatan" => "required",
		"pbm" => "required",
		"rkbm" => "required"
	];

	protected $validationMessages   = [];
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks       = true;
	protected $beforeInsert         = [];
	protected $afterInsert          = [];
	protected $beforeUpdate         = [];
	protected $afterUpdate          = [];
	protected $beforeFind           = [];
	protected $afterFind            = [];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];
}
