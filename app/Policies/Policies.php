<?php

namespace App\Policies;

use App\Models\Eloquent\OperasiKapal;

interface Policies
{
  public function create();

  public function view(OperasiKapal $operasiKapal);

  public function edit(OperasiKapal $operasiKapal);

  public function delete(OperasiKapal $operasiKapal);
}
