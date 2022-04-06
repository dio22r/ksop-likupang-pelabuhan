<?php

namespace App\Helpers;


class HomeHelper
{
  public function __construct()
  {
    $this->opKplModel = model("App\Models\OperasiKapalModel");
    $this->flampModel = model("App\Models\FileLampiranModel");
    $this->dataBrgModel = model("App\Models\DataBarangModel");
    $this->fileLampHelper = new FileLampiranHelper();
  }

  public function retrieve_json_table(
    $page,
    $perpage = 10,
    $searchdata = "",
    $searchfield = "created_at",
    $arrWhere = []
  ) {
    // 
    $mindate = date('Y-m-d', strtotime('-30 day'));
    $start = ($page - 1) * $perpage;

    $data = $this->opKplModel->select("id, created_at, nama_agen, nama_kapal, bendera, status")
      ->where($arrWhere)
      ->where("created_at >=", $mindate . " 00:00:00")
      ->orderBy("created_at DESC")
      ->findAll($perpage, $start);

    $result = $this->opKplModel->select("count(*) as total")
      ->where($arrWhere)
      ->where("created_at >=", $mindate . " 00:00:00")
      ->first();

    $total = $result["total"];

    return [
      "data" => $data,
      "total" => $total
    ];
  }

  public function insert_data($arrPost, $files)
  {
    $this->opKplModel->transStart();

    $arrPost["status"] = 0;
    $status = $this->opKplModel->save($arrPost);
    $arrErr = [];

    if ($status) {
      $id = $this->opKplModel->insertID;

      $arrBarang = [];
      if (isset($arrPost["jenis_barang_id"])) {
        foreach ($arrPost["jenis_barang_id"] as $key => $val) {
          $arrBarang[] = [
            "op_kapal_id" => $id,
            "jenis_barang_id" => $val,
            "bongkar" => $arrPost["bongkar"][$key],
            "muat" => $arrPost["muat"][$key]
          ];
        }

        if ($arrBarang) {
          $status = $this->dataBrgModel->insertBatch($arrBarang);
        }
      }

      $arrData = $this->opKplModel->find($id);
      $created_at = $arrData["created_at"];

      $arrInsert = [];
      foreach ($files["file"] as $key => $file) {
        $filename = $this->fileLampHelper->upload_file($file, $id, $created_at);

        if ($filename) {
          $arrInsert[] = [
            "id_op_kapal" => $id,
            "id_file_ket" => $key,
            "filename" => $filename
          ];
        }
      }
      if ($arrInsert) {
        $status = $this->flampModel->insertBatch($arrInsert);
      } else {
        $status = false;
        $arrErr["file"] = "Lampiran tidak boleh kosong";
      }
    } else {
      $arrErr = $this->opKplModel->errors();
    }

    if ($status && $this->opKplModel->transStatus()) {
      $this->opKplModel->transCommit();
    } else {
      $this->opKplModel->transRollback();
    }

    return ["id" => $id, "status" => $status, "arrErr" => $arrErr];
  }

  public function update_data($arrData, $files)
  {
    $this->flampModel->transStart();

    $id = $arrData["id"];
    $created_at = $arrData["created_at"];

    $arrTemp = $this->flampModel->where("id_op_kapal", $id)->findAll();

    $arrFileLamp = [];
    foreach ($arrTemp as $key => $arrVal) {
      $arrFileLamp[$arrVal["id_file_ket"]] = $arrVal;
    }

    $arrInsert = false;
    foreach ($files["file"] as $key => $file) {
      $isUpdate = false;
      if (isset($arrFileLamp[$key])) {
        if ($arrFileLamp[$key]["status"] == 1) {
          continue;
        }
        $isUpdate = true;
      }

      // check file jika status file sudah 1, tidak boleh diupdate;
      $filename = $this->fileLampHelper->upload_file($file, $id, $created_at);

      if ($filename) {
        $arrInsert = [
          "id_op_kapal" => $id,
          "id_file_ket" => $key,
          "filename" => $filename
        ];

        if ($isUpdate) {
          $arrInsert["id"] = $arrFileLamp[$key]["id"];
        }

        $status = $this->flampModel->save($arrInsert);
        if ($isUpdate && $status) {
          $this->fileLampHelper->delete_file(
            $arrFileLamp[$key]["filename"],
            $id,
            $created_at
          );
        }
      }
    }

    $arrErr = [];
    if ($arrInsert) {
      $this->opKplModel->update($id, ["status" => 0]);
    } else {
      $arrErr = ["file" => "Lampiran Belum Diisi"];
      $status = false;
    }


    if ($status && $this->flampModel->transStatus()) {
      $this->flampModel->transCommit();
    } else {
      $this->flampModel->transRollback();
    }

    return [
      "id" => $id,
      "status" => $status,
      "arrErr" => $arrErr
    ];
  }

  public function get_stat_data($bulan = 1)
  {
    $strBulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
    $datestart = date("Y-m-01 00:00:00", strtotime("- $bulan month"));

    $result = $this->opKplModel->select("YEAR(updated_at), MONTH(updated_at) as bulan, count(*) as total")
      ->where("updated_at >=", $datestart)
      ->where("status", 1)
      ->groupBy("YEAR(updated_at), MONTH(updated_at)")
      ->findAll();

    $arrRet = [
      "label" => [],
      "total" => []
    ];
    foreach ($result as $key => $arrVal) {
      $arrRet["label"][] = $strBulan[$arrVal["bulan"] - 1];
      $arrRet["total"][] = $arrVal["total"];
    }

    return $arrRet;
  }
}
