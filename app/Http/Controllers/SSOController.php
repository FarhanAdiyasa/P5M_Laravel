<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Login_User; // Assuming LoginUser is your model

class SSOController extends Controller
{


    public function index()
    {
        return view('sso');    }

}
