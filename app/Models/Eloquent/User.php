<?php

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
  const USER_ROLE_ADMIN = 1;
  const USER_ROLE_KEP_KANTOR = 2;
  const USER_ROLE_KEP_SEKSI = 3;
  const USER_ROLE_OPERATOR = 4;
  const USER_ROLE_STAKEHOLDER = 5;
  const USER_ROLE_MEMBER = 6;

  const USER_STATUS_ACTIVE = 1;
  const USER_STATUS_NONACTIVE = 0;

  protected $table = "user";

  public function setPasswordAttribute($value)
  {
    $this->attributes['password'] = password_hash($value, PASSWORD_DEFAULT);
  }

  public function isMember()
  {
    if ($this->role == User::USER_ROLE_MEMBER) {
      return true;
    }

    return false;
  }
}
