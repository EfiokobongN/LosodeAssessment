<?php

namespace App\Utility;

use Illuminate\Support\Facades\Auth;

class Util
{
    public static function Auth(){
        $user = Auth::guard('sanctum')->user();
        return $user;
    }
}