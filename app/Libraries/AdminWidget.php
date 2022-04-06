<?php

namespace App\Libraries;

use App\Helpers\MenuHelper;
use App\Helpers\UserHelper;

class AdminWidget
{

  public function __construct()
  {
    $this->userHelper = new UserHelper();
    $this->menuHelper = new MenuHelper();
  }

  public function menu($params = [])
  {
    $arrUser = $this->userHelper->get_login_info();
    $result = $this->menuHelper->retrieve_menu($arrUser["role"]);

    $data = [
      "arrMenu" => $result,
      "nama" => $arrUser["nama"]
    ];

    return view('admin_widget/adminMenuView', $data);
  }
}
