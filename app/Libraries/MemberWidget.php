<?php

namespace App\Libraries;

use App\Helpers\MenuHelper;
use App\Helpers\UserHelper;

class MemberWidget
{

  public function __construct()
  {
    $this->userHelper = new UserHelper();
    $this->menuHelper = new MenuHelper();
  }

  public function menu($params = [])
  {
    $user = $this->userHelper->getUser();

    $data = [
      "nama" => $user->nama
    ];

    return view('admin_widget/memberMenuView', $data);
  }
}
