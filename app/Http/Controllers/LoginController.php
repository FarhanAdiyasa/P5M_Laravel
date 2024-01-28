<?php

namespace App\Http\Controllers;

use App\Models\User;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PDO;

class LoginController extends Controller
{

     
    public function login()
    {
        if (Auth::check()) {
            return redirect('sso');
        }else{
            return view('login');
        }
    }
    public function actionlogin(Request $request)
    {
        $apiUrl = "https://api.polytechnic.astra.ac.id:2906/api_dev/efcc359990d14328fda74beb65088ef9660ca17e/SIA/getListKaryawan";
    
        $response = Http::get($apiUrl);
        if ($response->successful()) {
            $dataKaryawan = $response->json();
        }
    
        $check2 = User::where("username", $request->input('username'))->first();
    
        if ($check2) {
            foreach ($dataKaryawan as $kry) {
                $usn = $kry['username'];
    
                if ($usn != "" && $usn == $check2->username) {
                    if (!isset($kry['password']) || $kry['password'] == $request->input('password')) {
                        Auth::login($check2);
    
                        // Return JSON response
                        return response()->json(['success' => true, 'redirect_url' => url('sso'), "message" => "Login Berhasil!"]);
                    }
                }
            }
        }
        return response()->json(['success' => false, 'message' => 'Invalid username or password']);
    }
    

    public function actionlogout()
    {
        session()->flush();
        Auth::logout();
        return redirect('/');
    }
    
}