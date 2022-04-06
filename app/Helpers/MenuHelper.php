<?php

namespace App\Helpers;


class MenuHelper
{

  public function __construct()
  {
    $this->menuModel = model("App\Models\MenuModel");
    $this->session = \Config\Services::session();
  }

  public function retrieve_menu($role = "")
  {
    $result = $this->menuModel->select("menu.*")
      ->join("user_group_menu as t1", "menu.id = t1.menu_id")
      ->where("t1.user_group_id", $role)
      ->orderBy("parent_id ASC, 'order' ASC")
      ->findAll();

    return $result;
  }


  public function is_menu_authorized($idMenu)
  {
    $result = $this->menuModel->select("menu.*")
      ->join("user_group_menu as t1", "menu.id = t1.menu_id")
      ->where("t1.menu_id", $idMenu)
      ->where("t1.user_group_id", $this->session->get("role"))
      ->find();

    if ($result) {
      return true;
    }
    return false;
  }
}
