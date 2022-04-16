<?php

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;

class ValidasiKapal extends Model
{
  protected $table = "validasi_kapal";

  public function User()
  {
    return $this->belongsTo(User::class, "user_id", "id");
  }
}
