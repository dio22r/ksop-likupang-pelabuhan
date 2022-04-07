<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\FileKetModel;

class FileKet extends Seeder
{
	public function run()
	{
		$data = [
			[
				"keterangan" => "Surat permohonan Tambat / Labuh",
			],
			[
				"keterangan" => "Hasil pemeriksaaan karantina pelabuhan dan 10 last port",
			],
			[
				"keterangan" => "Laporan kedatangan dan keberangkatan kapal (LK3) Pelabuhan Asal",
			],
			[
				"keterangan" => "Daftar muatan / cargo manifest",
			],
			[
				"keterangan" => "Rencana penempatan kapal/pola trayek (RPT)",
			],
			[
				"keterangan" => "Pemberitahuan pengoperasian kapal nasional untuk angkutan laut luar negeri",
			],
			[
				"keterangan" => "Pemberitahuan keagenan kapal asing (PKKA)",
			],
			[
				"keterangan" => "Pemberitahuan pengoperasian kapal asing (PPKA)",
			],
			[
				"keterangan" => "Penunjukan keagenan umum / Agrency Agrement/ letter of Appointment (LA)",
			],
			[
				"keterangan" => "Laporan Rencana Pelaksanaan Bongkar Muat (RKBM) & Lampiran-lampirannya",
			],
			[
				"keterangan" => "Laporan Angkutan Barang (LAB) atau Penumpang (LAP)",
			],
			[
				"keterangan" => "Dokumen Lain dari Instansi terkait (untuk muatan tertentu)",
			],
		];

		$fileModel = new FileKetModel();

		$fileModel->insertBatch($data);
	}
}
