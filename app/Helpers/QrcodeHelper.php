<?php

namespace App\Helpers;

use App\Models\QrcodeTokenModel;

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;


class QrcodeHelper
{
  public function __construct()
  {
    $this->qrcodeModel = model("QrcodeTokenModel");
  }

  public function retrieve_qrcode($type, $arrData)
  {
    $token = $this->get_token($type, $arrData);
    if (!$token) return false;

    $options = new QROptions([
      'version'    => 6,
      'outputType' => QRCode::OUTPUT_IMAGE_PNG,
    ]);

    $arrData = [
      "owner" => "ksopbitung",
      "key" => $token
    ];
    // invoke a fresh QRCode instance
    $qrcode = new QRCode($options);

    $amplopUrl = base_url("/validation");
    if ($type == 2) {
      $amplopUrl = base_url("/validation-lap-bulan");
    } elseif ($type == 3) {
      $amplopUrl = base_url("/validation-lap-hari");
    }

    $data = $amplopUrl . "/" . base64_encode(json_encode($arrData));

    return $qrcode->render($data);
  }

  public function get_token($type, $arrData)
  {
    $content = json_encode($arrData);
    $arrData = $this->qrcodeModel->where("type", $type)
      ->where("content", $content)
      ->first();

    if (!$arrData) {
      $arrInsert = [
        "type" => $type,
        "content" => $content,
        "token" => uniqid(rand())
      ];

      $status = $this->qrcodeModel->insert($arrInsert);
      if ($status) {
        $id = $this->qrcodeModel->insertID;
        $arrData = $this->qrcodeModel->find($id);
      } else {
        return false;
      }
    }

    return $arrData["token"];
  }

  public function encode_qrcode_token($token)
  {
    $arrData = json_decode(base64_decode($token));

    if (!isset($arrData->key)) {
      return false;
    }

    $arrData = $this->qrcodeModel->where("token", $arrData->key)
      ->first();

    if (!$arrData) {
      return false;
    }

    $arrContent = json_decode($arrData["content"]);
    return [
      "type" => $arrData["type"],
      "arrContent" => $arrContent,
    ];
  }

  public function retrieve_plain_md5_token($type, $arrData)
  {
    $token = $this->get_md5_token($type, $arrData);
    if (!$token) return false;

    $options = new QROptions([
      'version'    => 6,
      'outputType' => QRCode::OUTPUT_IMAGE_PNG,
    ]);

    // invoke a fresh QRCode instance
    $qrcode = new QRCode($options);

    $data = base_url("/perbaikan-data/" . $token);

    return [
      "img" => $qrcode->render($data),
      "url" => $data
    ];
  }

  public function get_md5_token($type, $arrData)
  {
    $content = json_encode($arrData);
    $arrData = $this->qrcodeModel->where("type", $type)
      ->where("content", $content)
      ->first();

    if (!$arrData) {
      $arrInsert = [
        "type" => $type,
        "content" => $content,
        "token" => md5(uniqid(rand()))
      ];

      $status = $this->qrcodeModel->insert($arrInsert);
      if ($status) {
        $id = $this->qrcodeModel->insertID;
        $arrData = $this->qrcodeModel->find($id);
      } else {
        return false;
      }
    }

    return $arrData["token"];
  }
}
