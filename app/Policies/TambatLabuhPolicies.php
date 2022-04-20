<?php

namespace App\Policies;

use App\Helpers\Auth;
use App\Models\Eloquent\OperasiKapal;

class TambatLabuhPolicies implements Policies
{
    public function __construct()
    {
        $this->User = Auth::User();
    }

    public function create()
    {
        // return $this->User->id == $operasiKapal->created_by;
        return true;
    }

    public function view(OperasiKapal $operasiKapal)
    {
        return $this->User->id == $operasiKapal->created_by;
    }

    public function edit(OperasiKapal $operasiKapal)
    {
        return $this->User->id == $operasiKapal->created_by;
    }

    public function delete(OperasiKapal $operasiKapal)
    {
        return $this->User->id == $operasiKapal->created_by;
    }
}
