<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Login_User; // Assuming LoginUser is your model

class DashboardController extends Controller
{


    public function sop()
    {
        return view('KoordinatorSOP_dan_TATIB/dashboard_lihat');    
    }

    public function tingkat()
    {
        return view('KoordinatorTingkat/dashboard_lihat');    
    }

}
