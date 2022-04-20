<?php

namespace App\Helpers;

use App\Models\Eloquent\User;
use Config\Services;

class Auth
{
    public static function isLogin()
    {
        return self::id() ? true : false;
    }

    public static function User()
    {
        $session = Services::session();
        return User::find($session->get("id"));
    }

    public static function id()
    {
        $session = Services::session();
        return $session->get("id");
    }
}
