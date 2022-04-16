<?php

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileKet extends Model
{
  use SoftDeletes;

  protected $table = "file_ket";

  public function OperasiKapal()
  {
    return $this->belongsToMany(OperasiKapal::class, "file_lampiran", "id_file_ket", "id_op_kapal")
      ->withPivot("id", "filename", "filehash", "status");
  }
}
