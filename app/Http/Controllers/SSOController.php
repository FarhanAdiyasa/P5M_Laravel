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
        $roles = User::where("username", $usn)->pluck("role")->toArray();
    
        return view('sso', ['roles' => $roles]);
    }
    
    public function ssoLog($role)
    {
        $check2 = User::where(["username"=>Auth::user()->username, "role"=>$role])->firstOrFail();
        Auth::logout();
        session()->flush();

        Auth::login($check2);
        session(['role' =>$check2->role]);
        return redirect()->route('idx');
    }

}
