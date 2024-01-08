<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Login_User; // Assuming LoginUser is your model
use Illuminate\Support\Facades\DB;

class PenggunaController extends Controller
{


    public function index()
    {
        $pengguna = DB::select('EXEC sp_get_all_pengguna');

        

        return view('KoordinatorSOP_dan_TATIB/Pengguna/user_lihat', compact('pengguna'));    
    }

    function pengguna_input(){
        return view('KoordinatorSOP_dan_TATIB/Pengguna/user_input');
    }

    function save (Request $request){

            // Retrieve the API data
    $url = "https://api.polytechnic.astra.ac.id:2906/api_dev/efcc359990d14328fda74beb65088ef9660ca17e/SIA/getListKaryawan";
    $apiData = json_decode(file_get_contents($url), true);

    // Get the username from API based on 'nama_pengguna'
    $nama_pengguna = $request->input("nama_pengguna");
    $apiUser = collect($apiData)->firstWhere('nama', $nama_pengguna);

    if (!$apiUser) {
        // Handle the case where the user is not found in the API data
        return redirect('user_lihat');
    }

    // Use the API username or adjust this based on the actual API response structure
    $username = $apiUser['username'];
    $role = $request->input("role");
    $kelas = $request->input("kelas");

    DB::statement('EXEC sp_insert_pengguna ?, ?, ?, ?', [$username,$nama_pengguna, $role, $kelas]);
        return redirect('user_lihat');
    }

    function pengguna_edit($id){
        $penggunaArray = DB::select('EXEC sp_get_pengguna ?', [$id]);
        $pengguna = (object) $penggunaArray[0];



        return view('KoordinatorSOP_dan_TATIB/Pengguna/user_edit', compact('pengguna'));
    
}

    function update(Request $request){
            // Retrieve the API data
            $id = $request->input("id");
            $url = "https://api.polytechnic.astra.ac.id:2906/api_dev/efcc359990d14328fda74beb65088ef9660ca17e/SIA/getListKaryawan";
            $apiData = json_decode(file_get_contents($url), true);
        
            // Get the username from API based on 'nama_pengguna'
            $nama_pengguna = $request->input("nama_pengguna");
            $apiUser = collect($apiData)->firstWhere('nama', $nama_pengguna);
        
            if (!$apiUser) {
                // Handle the case where the user is not found in the API data
                return redirect('user_lihat');
            }
        
            // Use the API username or adjust this based on the actual API response structure
            $username = $apiUser['username'];
            $role = $request->input("role");
            $kelas = $request->input("kelas");    
        DB::statement('EXEC sp_update_pengguna ?, ?, ?, ?, ?, 1', [$id, $username,$nama_pengguna, $role, $kelas]);
    
        return redirect('user_lihat');
}


    function delete($id){


        DB::statement('EXEC sp_delete_pengguna ?', [$id]);

    
        return redirect('user_lihat');
}


}
