<?php

namespace App\Helpers;

use App\Models\FileLampiranModel;

class FileLampiranHelper
{
  public function __construct()
  {
    $this->fileModel = model("FileLampiranModel");
  }

  public function upload_file($file, $id, $created_at)
  {
    if ($file->isValid() && !$file->hasMoved()) {

      $path1 = $id % 10;
      $path2 = strtotime($created_at) % 15;

      // Generate a new secure name
      $name = $file->getRandomName();
      // Move the file to it's new home
      $result = $file->move(F_PATH_LAMPIRAN . "/" . $path1 . "/" . $path2, $name);
      if ($result) {
        // insert file and id
        return $name;
      }
    }

    return false;
  }

  public function get_file($idFile, $arrWhere = [], $whereIn = false)
  {
    $query = $this->fileModel->select("t1.created_at as created_at_op_kapal, file_lampiran.*, t2.keterangan")
      ->join("operasi_kapal t1", "file_lampiran.id_op_kapal = t1.id")
      ->join("file_ket t2", "file_lampiran.id_file_ket = t2.id")
      ->where("file_lampiran.id", $idFile)
      ->where($arrWhere);

    if ($whereIn) {
      $query->whereIn($whereIn["field"], $whereIn["value"]);
    }

    $arrData = $query->first();
    if (!$arrData) {
      return false;
    }

    $idOrder = $arrData["id_op_kapal"];
    $filename = $arrData["filename"];
    $created_at = $arrData["created_at_op_kapal"];

    $path1 = $idOrder % 10;
    $path2 = strtotime($created_at) % 15;
    $filepath = F_PATH_LAMPIRAN . "/" . $path1 . "/" . $path2 . "/" . $filename;

    return [
      "filepath" => $filepath,
      "arrData" => $arrData
    ];
  }

  public function delete_file($file, $id, $created_at)
  {
    $path1 = $id % 10;
    $path2 = strtotime($created_at) % 15;
    $filepath = realpath(F_PATH_LAMPIRAN) . "/" . $path1 . "/" . $path2 . "/" . $file;

    $result = true;
    if (file_exists($filepath)) {
      $result = unlink($filepath);
    }

    return $result;
  }
}
