<?php

namespace App\Helpers;

use App\Models\OperasiKapalModel;
use App\Models\FileKetModel;
use App\Models\ValidasiKapalModel;
use App\Models\DataBarangModel;

class PengoprasianKapalHelper
{
  public function __construct()
  {
    $this->opKapalModel = model("OperasiKapalModel");
    $this->fileKetModel = model("FileKetModel");
    $this->validKapalModel = model("ValidasiKapalModel");
    $this->dataBrgModel = model("DataBarangModel");
  }

  public function retrieve_json_table(
    $page,
    $perpage = 10,
    $searchdata = "",
    $searchfield = "operasi_kapal.created_at",
    $arrWhere = []
  ) {

    if ($searchdata) {
      $arrWhere["$searchfield >="] = $searchdata . " 00:00:00";
      $arrWhere["$searchfield <="] = $searchdata . " 23:59:59";
    }

    $start = ($page - 1) * $perpage;
    $data = $this->opKapalModel->select("operasi_kapal.id, operasi_kapal.created_at, operasi_kapal.nama_agen, operasi_kapal.nama_kapal, operasi_kapal.bendera, operasi_kapal.status, t1.id as validate")
      ->join("validasi_kapal as t1", "operasi_kapal.id = t1.op_kapal_id", "left")
      ->where($arrWhere)
      ->orderBy("operasi_kapal.created_at DESC")
      ->findAll($perpage, $start);

    $result = $this->opKapalModel->select("count(*) as total")
      ->where($arrWhere)
      ->first();

    $total = $result["total"];

    return [
      "data" => $data,
      "total" => $total
    ];
  }

  public function retrieve_json_table_deleted(
    $page,
    $perpage = 10,
    $searchdata = "",
    $searchfield = "created_at",
    $arrWhere = []
  ) {

    if ($searchdata) {
      $arrWhere["$searchfield >="] = $searchdata . " 00:00:00";
      $arrWhere["$searchfield <="] = $searchdata . " 23:59:59";
    }

    $start = ($page - 1) * $perpage;
    $data = $this->opKapalModel->select("id, created_at, nama_agen, nama_kapal, bendera, status")
      ->where($arrWhere)
      ->onlyDeleted()
      ->orderBy("created_at DESC")
      ->findAll($perpage, $start);

    $result = $this->opKapalModel->select("count(*) as total")
      ->where($arrWhere)
      ->onlyDeleted()
      ->first();

    $total = 0;
    if ($result) $total = $result["total"];

    return [
      "data" => $data,
      "total" => $total
    ];
  }

  public function add_strtotime($arrData)
  {
    foreach ($arrData as $key => $arrVal) {
      $arrData[$key]["created_time"] = strtotime($arrVal["created_at"]) * 1000;
    }
    return $arrData;
  }

  public function addAction($arrData, $baseUrl = '')
  {
    foreach ($arrData as $key => $arrVal) {
      $url = false;
      if ($arrVal["status"] == 2) {
        $url = base_url("member/edit/" . $arrVal["id"]);
      }

      $arrData[$key]["edit_url"] = $url;
    }
    return $arrData;
  }

  public function retrieve_data_form($id)
  {
    $arrRkbm = [
      0 => "Tidak ada",
      1 => "Ada"
    ];

    $arrData = $this->opKapalModel
      ->select("operasi_kapal.*, t1_1.nama_dermaga as labuh,  t1_2.nama_dermaga as tambat,  t1_3.nama_dermaga as dock, t2.nama as nama_jenis_kapal")
      ->join("dermaga t1_1", "operasi_kapal.labuh_diminta = t1_1.id AND t1_1.type = 1", "left") // harus dirubah
      ->join("dermaga t1_2", "operasi_kapal.tambat_diminta = t1_2.id AND t1_2.type = 2", "left") // harus dirubah
      ->join("dermaga t1_3", "operasi_kapal.dock_diminta = t1_3.id AND t1_3.type = 2", "left") // harus dirubah
      ->join("jenis_kapal t2", "operasi_kapal.jenis_kapal = t2.id")
      ->withDeleted()
      ->find($id);

    if (!$arrData)  return false;

    $arrData["rkbm"] = $arrRkbm[$arrData["rkbm"]];
    $arrFile = $this->fileKetModel->select("file_ket.*, t1.id as id_file, t1.filename, t1.status")
      ->join("file_lampiran t1", "file_ket.id = t1.id_file_ket AND t1.id_op_kapal = '$id'", "left")
      ->orderBy("file_ket.id ASC")
      ->withDeleted()
      ->findAll();

    $arrValidasi = $this->validKapalModel
      ->select("validasi_kapal.*, user.nama as user_nama")
      ->join("user", "validasi_kapal.user_id = user.id")
      ->where("op_kapal_id", $id)
      ->first();

    $arrDataBarang = $this->dataBrgModel
      ->select("data_barang.*, t1.uraian, t1.satuan, t1.type")
      ->join("jenis_barang t1", "data_barang.jenis_barang_id = t1.id")
      ->where("op_kapal_id", $id)
      ->orderBy("t1.id ASC")
      ->findAll();

    return [
      "arrData" => $arrData,
      "arrFile" => $arrFile,
      "arrValidasi" => $arrValidasi,
      "arrDataBarang" => $this->split_data_barang($arrDataBarang)
    ];
  }

  protected function split_data_barang($data)
  {
    $arrBarang = [];
    $arrNonBarang = [];
    foreach ($data as $key => $arrVal) {
      if ($arrVal["type"] == 1) {
        $arrBarang[] = $arrVal;
      } else {
        $arrNonBarang[] = $arrVal;
      }
    }

    return [
      "barang" => $arrBarang,
      "nonbarang" => $arrNonBarang
    ];
  }
}
