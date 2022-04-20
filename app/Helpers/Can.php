<?php

namespace App\Helpers;

use App\Models\Eloquent\User;
use App\Policies\Policies;
use Config\Services;

class Can
{
  public static function create(Policies $policies)
  {
    if (!$policies->create()) {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
      return;
    }
  }

  public static function view(Policies $policies, $models)
  {
    if (!$policies->edit($models)) {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
      return;
    }
  }

  public static function edit(Policies $policies, $models)
  {
    if (!$policies->edit($models)) {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
      return;
    }
  }

  public static function delete(Policies $policies, $models)
  {
    if (!$policies->edit($models)) {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
      return;
    }
  }
}
