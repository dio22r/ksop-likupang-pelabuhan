<?php

namespace App\Helpers;

class UserManagementHelper
{
  public function __construct()
  {
    $this->userModel = model("App\Models\UserModel");
  }

  public function retrieve_json_table(
    $page,
    $perpage = 10,
    $searchdata = "",
    $searchfield = "nama",
    $arrWhere = []
  ) {

    $start = ($page - 1) * $perpage;
    $data = $this->userModel->select("user.id, nama, username, t1.title as role_name, status")
      ->join("user_group t1", "role = t1.id")
      ->like($searchfield, $searchdata, "both")
      ->where($arrWhere)
      ->orderBy("nama ASC")
      ->findAll($perpage, $start);

    $result = $this->userModel->select("count(*) as total")
      ->join("user_group t1", "role = t1.id")
      ->like($searchfield, $searchdata, "both")
      ->where($arrWhere)
      ->first();

    $total = $result->total;

    return [
      "data" => $data,
      "total" => $total
    ];
  }
}
