<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Login_User; // Assuming LoginUser is your model

class SSOController extends Controller
{


    public function index()
    {
        $usn = Auth::user()->username;
        $roles = User::where("png_username", $usn)->where("png_status", 1)->pluck("png_role")->toArray();
    
        return view('sso', ['roles' => $roles]);
    }
    
    public function ssoLog($role)
    {
        $check2 = User::where(["png_username"=>Auth::user()->png_username, "png_role"=>$role])->firstOrFail();
        Auth::logout();
        session()->flush();

        Auth::login($check2);
        session(['role' =>$check2->role]);
        return redirect()->route('idx');
    }

}
