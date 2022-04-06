<?php

namespace App\Helpers;


class LaporanHelper
{
  public $arrBulan = [
    1 => "Januari",
    2 => "Februari",
    3 => "Maret",
    4 => "April",
    5 => "Mei",
    6 => "Juni",
    7 => "Juli",
    8 => "Agustus",
    9 => "September",
    10 => "Oktober",
    11 => "November",
    12 => "Desember",
  ];

  public $arrStatus = [
    1 => "DISETUJUI",
    -1 => "DITOLAK",
    0 => "MENUNGGU",
    2 => "MENUNGGU PERBAIKAN"
  ];

  public function __construct()
  {
    $this->opKplModel = model("App\Models\OperasiKapalModel");
  }

  public function retrieve_bulan(
    $year,
    $arrWhere = []
  ) {
    // 
    $data = $this->opKplModel->select('month(t1.created_at) as bulan, operasi_kapal.status as status, count(*) as total')
      ->join("validasi_kapal t1", "operasi_kapal.id = t1.op_kapal_id")
      ->where("YEAR(t1.created_at)", $year)
      ->where("operasi_kapal.status <>", 0)
      ->where("operasi_kapal.status <>", 2)
      ->where($arrWhere)
      ->orderBy("month(t1.created_at) ASC")
      ->groupBy(['month(t1.created_at)', 'operasi_kapal.status'])
      ->findAll();

    return [
      "data" => $this->map_view_table_bulan($data)
    ];
  }

  public function map_view_table_bulan($arrData)
  {

    $status = [
      1 => "diterima",
      -1 => "ditolak"
    ];

    $arrRet = [];

    foreach ($arrData as $key => $arrVal) {
      $bulan = $arrVal["bulan"];
      $statusIndex = $arrVal["status"];

      if (!isset($arrRet[$bulan])) {
        $arrRet[$bulan]["diterima"] = 0;
        $arrRet[$bulan]["ditolak"] = 0;
      }

      $arrRet[$bulan]["nama"] = $this->arrBulan[$bulan];
      $arrRet[$bulan]["num"] = $bulan;
      $arrRet[$bulan][$status[$statusIndex]] = $arrVal["total"];
    }

    return array_values($arrRet);
  }

  public function retrieve_statistic($year, $month = "", $arrWhere = [])
  {

    $result = $this->opKplModel->select('status, count(*) as total')
      // ->join("validasi_kapal t1", "operasi_kapal.id = t1.id", "left")
      ->where("YEAR(created_at)", $year)
      ->where($arrWhere);

    if ($month) {
      $result->where("MONTH(created_at)", $month);
    }

    $data = $result->groupBy('operasi_kapal.status')
      ->findAll();

    $arrRet = [
      "diterima" => 0,
      "ditolak" => 0,
      "menunggu" => 0,
      "perbaikan" => 0
    ];

    foreach ($data as $key => $arrVal) {
      if ($arrVal["status"] == 1) {
        $arrRet["diterima"] = $arrVal["total"];
      } elseif ($arrVal["status"] == -1) {
        $arrRet["ditolak"] = $arrVal["total"];
      } elseif ($arrVal["status"] == 2) {
        $arrRet["perbaikan"] = $arrVal["total"];
      } else {
        $arrRet["menunggu"] = $arrVal["total"];
      }
    }

    return $arrRet;
  }

  public function retrieve_year()
  {
    $data = $this->opKplModel->select('YEAR(created_at) as tahun, count(*) as total')
      ->groupBy('YEAR(created_at)')
      ->orderBy('YEAR(created_at) DESC')
      ->findAll();

    $years = [];
    foreach ($data as $key => $arrVal) {
      $years[] = $arrVal["tahun"];
    }

    return $years;
  }


  public function retrieve_days(
    $year,
    $month,
    $arrWhere = []
  ) {
    //

    $year = str_pad($year, 2, "0", STR_PAD_LEFT);
    $month = str_pad($month, 2, "0", STR_PAD_LEFT);

    $totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $startDate = $year . "-" . $month . "-01 00:00:00";
    $endDate = $year . "-" . $month . "-" . $totalDays . " 23:59:59";

    $data = $this->opKplModel->select('day(t1.created_at) as hari, operasi_kapal.status as status, count(*) as total')
      ->join("validasi_kapal t1", "operasi_kapal.id = t1.op_kapal_id")
      ->where("operasi_kapal.status <>", 0)
      ->where("operasi_kapal.status <>", 2)
      ->where("t1.created_at >=", $startDate)
      ->where("t1.created_at <=", $endDate)
      ->where($arrWhere)
      ->orderBy("day(t1.created_at) ASC")
      ->groupBy(['day(t1.created_at)', 'operasi_kapal.status'])
      ->findAll();

    return [
      "data" => $this->map_view_table_hari($data)
    ];
  }


  public function map_view_table_hari($arrData)
  {

    $status = [
      1 => "diterima",
      -1 => "ditolak"
    ];

    $arrRet = [];

    foreach ($arrData as $key => $arrVal) {
      $day = $arrVal["hari"];
      $statusIndex = $arrVal["status"];
      $arrRet[$day]["nama"] = $day;
      $arrRet[$day][$status[$statusIndex]] = $arrVal["total"];
    }

    return array_values($arrRet);
  }

  public function retrieve_data_laporan_bulanan(
    $year,
    $month,
    $arrWhere = ["operasi_kapal.status <>" => 0, "operasi_kapal.status <>" => 2]
  ) {
    $year = str_pad($year, 2, "0", STR_PAD_LEFT);
    $month = str_pad($month, 2, "0", STR_PAD_LEFT);

    $totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $startDate = $year . "-" . $month . "-01 00:00:00";
    $endDate = $year . "-" . $month . "-" . $totalDays . " 23:59:59";

    return [
      "data" => $this->get_record_data($startDate, $endDate, $arrWhere)
    ];
  }

  public function retrieve_data_laporan_harian(
    $date
  ) {

    $startDate = $date . " 00:00:00";
    $endDate = $date . " 23:59:59";

    $arrWhere = [
      "operasi_kapal.status <>" => 0,
      "operasi_kapal.status <>" => 2
    ];
    return [
      "data" => $this->get_record_data($startDate, $endDate, $arrWhere)
    ];
  }

  public function get_record_data($startDate, $endDate, $arrWhere = [])
  {

    $result = $this->opKplModel->select('operasi_kapal.*, t1.created_at as proceed_at, t1.user_id, t2.nama as nama_user, t3.nama_dermaga as labuh, t4.nama_dermaga as tambat, t5.nama_dermaga as dock')
      ->join("validasi_kapal t1", "operasi_kapal.id = t1.op_kapal_id")
      ->join("user t2", "t1.user_id = t2.id")
      ->join("dermaga t3", "operasi_kapal.labuh_diminta = t3.id", "left") // harus dirubah
      ->join("dermaga t4", "operasi_kapal.tambat_diminta = t4.id", "left") // harus dirubah
      ->join("dermaga t5", "operasi_kapal.dock_diminta = t5.id", "left") // harus dirubah
      ->where("t1.created_at >=", $startDate)
      ->where("t1.created_at <=", $endDate);

    if ($arrWhere) {
      $result->where($arrWhere);
    }

    $data = $result->orderBy("t1.created_at ASC")
      ->findAll();

    return $data;
  }

  public function get_apbn_statistik($arrWhere)
  {
  }
}
