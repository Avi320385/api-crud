<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OtpController extends Controller

    //
    {
        public function index()
        {
            $digits = 5;
            return ("your otp is".":". rand(pow(10, $digits-1), pow(10, $digits)-1));
        }
}
