<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Login_User; // Assuming LoginUser is your model
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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

    // Get the username from API based on 'png_nama'
    $png_nama = $request->input("png_nama");
    $apiUser = collect($apiData)->firstWhere('nama', $png_nama);

    if (!$apiUser) {
        // Handle the case where the user is not found in the API data
        return redirect()->route('p.index')->with('success', 'Pengguna Berhasil Ditambahkan');
    }


    // Use the API username or adjust this based on the actual API response structure
    $png_username = $apiUser['png_username'];
    $png_role = $request->input("png_role");
    if($png_role == "KOORDINATOR TINGKAT"){
        $png_kelas = $request->input("png_kelas");    
    }else{
        $png_kelas = "Semua Kelas";
    }

    DB::statement('EXEC sp_insert_pengguna ?, ?, ?, ?', [$png_username,$png_nama, $png_role, $png_kelas]);
    $log_aktifitas = "Tambah Pengguna " . $png_nama;
    $log_tanggal =  now()->format('Y-m-d');

    DB::statement('EXEC sp_insert_log ?, ?', [$log_aktifitas, $log_tanggal]);


        return redirect()->route('p.index')->with('success', 'Data berhasil ditambahkan.');
    }

    function pengguna_edit($id){
        $penggunaArray = DB::select('EXEC sp_get_pengguna ?', [$id]);
        $pengguna = (object) $penggunaArray[0];



        return view('KoordinatorSOP_dan_TATIB/Pengguna/user_edit', compact('pengguna'));
    
}

    function update(Request $request){
            // Retrieve the API data
            $id = $request->input("png_id");
            $url = "https://api.polytechnic.astra.ac.id:2906/api_dev/efcc359990d14328fda74beb65088ef9660ca17e/SIA/getListKaryawan";
            $apiData = json_decode(file_get_contents($url), true);
        
            // Get the username from API based on 'png_nama'
            $png_nama = $request->input("png_nama");
            $apiUser = collect($apiData)->firstWhere('nama', $png_nama);
        
            if (!$apiUser) {
                return redirect()->route('p.index');
            }


        
            // Use the API username or adjust this based on the actual API response structure
            $png_username = $apiUser['png_username'];
            $png_role = $request->input("png_role");
            if($png_role == "KOORDINATOR TINGKAT"){
                $png_kelas = $request->input("png_kelas");    
            }else{
                $png_kelas = "Semua Kelas";
            }
          
        DB::statement('EXEC sp_update_pengguna ?, ?, ?, ?, ?, 1', [$id, $png_username,$png_nama, $png_role, $png_kelas]);

        $log_aktifitas = "Ubah Pengguna " . $png_nama;
        $log_tanggal =  now()->format('Y-m-d');
    
    DB::statement('EXEC sp_insert_log ?, ?', [$log_aktifitas, $log_tanggal]);
    
        return redirect()->route('p.index')->with('update', 'Data berhasil diubah.');
}


    function delete($id){

        $user = DB::select('SELECT png_username FROM p5m_mspengguna WHERE png_id = ?', [$id]);

        DB::statement('EXEC sp_delete_pengguna ?', [$id]);

        $png_username = strval($user[0]->png_username);   

        $log_aktifitas = "Hapus Pengguna " . $png_username;
        $log_tanggal =  now()->format('Y-m-d');
        
        DB::statement('EXEC sp_insert_log ?, ?', [$log_aktifitas, $log_tanggal]);

        return redirect()->route('p.index')->with('delete', 'Data berhasil dihapus');
       
    }

    public function checkUserExistence(Request $request)
    {
        $png_username = $request->input('png_username');
        $png_role = $request->input('png_role');

        $userExists = User::where('png_nama', $png_username)
            ->where('png_role', $png_role)
            ->where('png_status', 1)
            ->exists();

        return response()->json(['exists' => $userExists]);
    }

    public function checkUserExistenceEdit(Request $request)
    {
        $png_username = $request->input('png_username');
        $png_role = $request->input('png_role');
        $id = $request->input('png_id');

        $userExists = User::where('png_nama', $png_username)
            ->where('png_role', $png_role)
            ->where('status', 1)
            ->where('png_id', '!=', $id)
            ->exists();

        return response()->json(['exists' => $userExists, 'png_username'=>$png_username, 'png_role'=>$png_role]);
    }


}
