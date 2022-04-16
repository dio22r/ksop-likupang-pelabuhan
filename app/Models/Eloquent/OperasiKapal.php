<?php

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OperasiKapal extends Model
{
  use SoftDeletes;

  protected $table = "operasi_kapal";

  public function JenisKapal()
  {
    return $this->belongsTo(JenisKapal::class, "jenis_kapal", "id");
  }

  public function JenisBarang()
  {
    return $this->belongsToMany(JenisBarang::class, "data_barang", "op_kapal_id", "jenis_barang_id")
      ->withPivot("bongkar", "muat");
  }

  public function ValidasiKapal()
  {
    return $this->hasOne(ValidasiKapal::class, "op_kapal_id", "id");
  }

  public function FileKet()
  {
    return $this->belongsToMany(FileKet::class, "file_lampiran", "id_op_kapal", "id_file_ket")
      ->withPivot("filename", "filehash", "status");
  }

  public function Labuh()
  {
    return $this->belongsTo(Dermaga::class, "labuh_diminta");
  }

  public function Tambat()
  {
    return $this->belongsTo(Dermaga::class, "tambat_diminta");
  }

  public function Owner()
  {
    return $this->belongsTo(User::class, "created_by");
  }
}
