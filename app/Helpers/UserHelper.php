<?php

namespace App\Helpers;

use App\Models\Eloquent\User;

class UserHelper
{
  public function __construct()
  {
    $this->session = \Config\Services::session();
    $this->userModel =  model("\App\Models\UserModel");
  }

  public function verify_captcha($request)
  {
    $config = config('App');
    // Access settings as object properties
    $secret = $config->recaptchaSecret;

    $credential = array(
      'secret' => $secret,
      'response' => $request->getVar('g-recaptcha-response')
    );

    $verify = curl_init();
    curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
    curl_setopt($verify, CURLOPT_POST, true);
    curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($credential));
    curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($verify);

    $status = json_decode($response, true);

    return $status;
  }

  public function insert_data($user)
  {
    try {

      $status = $this->userModel->save($user);
      $regId = $this->userModel->getInsertID();

      if ($status) {
        $arrJson = [
          'status' => true,
          'msg' => 'Data telah tersimpan',
        ];
      } else {
        $arrJson = [
          'status' => false,
          'msg' => 'Periksa kembali data anda',
        ];
      }
    } catch (\Exception $e) {
      $arrJson = [
        'status' => false,
        'msg' => $e->getMessage(),
      ];
    }

    return $arrJson;
  }

  public function change_password($old, $new, $retype)
  {
    $id = $this->session->get('id');
    $user = $this->userModel
      ->where("id", $id)
      ->first();

    $status = false;
    $arrErr = [];
    // password olld
    if (!password_verify($old, $user->password)) {
      $arrErr["password_old"] = "Password Lama Tidak Sesuai";
    }

    if ($new != $retype) {
      $arrErr["password"] = "Password Baru dan Ulangi Password harus sama dan harus diisi";
    }

    if (!$arrErr) {
      $user->password = $new;
      $status = $this->userModel->update($id, $user);
      if (!$status) {
        $arrErr = $this->userModel->errors();
      }
    }

    return [
      "status" => $status,
      "arrErr" => $arrErr
    ];
  }

  public function set_login_info($user)
  {
    $this->session->set("user", $user);

    $this->session->set("id", $user->id);
    $this->session->set("nama", $user->nama);
    $this->session->set("role", $user->role);

    return TRUE;
  }

  public function check_login()
  {
    if (empty($this->session->get('id'))) {
      return false;
    } else {
      return $this->session->get('id');
    }
  }

  public function getUser()
  {
    return $this->session->get("user");
  }

  public function getId()
  {
    return $this->session->get("id");
  }

  public function get_login_info()
  {
    $arrData = [
      'id' => $this->session->get("id"),
      'nama' => $this->session->get("nama"),
      'role' => $this->session->get("role"),
    ];

    return $arrData;
  }

  public function validationRegister()
  {
    $validation = \Config\Services::validation();

    $rules = [
      'nama' => [
        'label'  => 'Nama',
        'rules'  => 'required|min_length[3]',
        'errors' => [
          'required' => 'Nama wajib diisi',
          "min_length" => "Nama Minimum 3 karakter"
        ],
      ],
      'username' => [
        'label'  => 'Username',
        'rules'  => 'required|is_unique[user.username,id,{id}]|alpha_numeric|min_length[3]',
        'errors' => [
          'required' => 'Username wajib diisi',
          'is_unique' => 'Username tidak tersedia, silahkan ganti dengan username yang lain',
          'alpha_numeric' => 'Username hanya dapat berupa huruf dan angka',
          "min_length" => "Nama Minimum 3 karakter"
        ],
      ],
      'password' => [
        'label'  => 'Password',
        'rules'  => 'required|min_length[5]|matches[confirm_password]',
        'errors' => [
          'required' => "Password Wajib diisi",
          'min_length' => 'Password Minimum 5 karakter',
          'matches' => 'Password dan konfirmasi password tidak sama'
        ],
      ]
    ];
    $validation->setRules($rules);

    return $validation;
  }

  public function registerMember($request)
  {
    $user = new User();

    $user->nama = $request->getPost("nama");
    $user->username = $request->getPost("username");
    $user->password = $request->getPost("password");
    $user->role = User::USER_ROLE_MEMBER;
    $user->status = User::USER_STATUS_ACTIVE;

    $status = $user->save();
    $arrErr = [];
    if (!$status) {
      $arrErr = ["terjadi kesalahan pada sistem kami."];
    }

    $arrRes = [
      "status" => $status,
      "arrError" => $arrErr,
      "arrData" => $user
    ];

    return $arrRes;
  }
}
