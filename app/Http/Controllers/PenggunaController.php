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
    if($role == "KOORDINATOR TINGKAT"){
        $kelas = $request->input("kelas");    
    }else{
        $kelas = "Semua Kelas";
    }

    DB::statement('EXEC sp_insert_pengguna ?, ?, ?, ?', [$username,$nama_pengguna, $role, $kelas]);
    $aktifitas = "Tambah Pengguna " . $nama_pengguna;
    $tanggal =  now()->format('Y-m-d');

    DB::statement('EXEC sp_insert_log ?, ?', [$aktifitas, $tanggal]);


        return redirect('user_lihat')->with('success', 'Data berhasil ditambahkan.');
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
                return redirect('user_lihat');
            }


        
            // Use the API username or adjust this based on the actual API response structure
            $username = $apiUser['username'];
            $role = $request->input("role");
            if($role == "KOORDINATOR TINGKAT"){
                $kelas = $request->input("kelas");    
            }else{
                $kelas = "Semua Kelas";
            }
          
        DB::statement('EXEC sp_update_pengguna ?, ?, ?, ?, ?, 1', [$id, $username,$nama_pengguna, $role, $kelas]);

        $aktifitas = "Ubah Pengguna " . $nama_pengguna;
        $tanggal =  now()->format('Y-m-d');
    
    DB::statement('EXEC sp_insert_log ?, ?', [$aktifitas, $tanggal]);
    
        return redirect('user_lihat')->with('update', 'Data berhasil diubah.');
}


    function delete($id){

        $user = DB::select('SELECT username FROM Pengguna WHERE id = ?', [$id]);

        DB::statement('EXEC sp_delete_pengguna ?', [$id]);

        $username = strval($user[0]->username);   

        $aktifitas = "Hapus Pengguna " . $username;
        $tanggal =  now()->format('Y-m-d');
        
        DB::statement('EXEC sp_insert_log ?, ?', [$aktifitas, $tanggal]);

        return redirect('user_lihat')->with('delete', 'Data berhasil dihapus');
       
    }

    public function checkUserExistence(Request $request)
    {
        $username = $request->input('username');
        $role = $request->input('role');

        $userExists = User::where('nama_pengguna', $username)
            ->where('role', $role)
            ->where('status', 1)
            ->exists();

        return response()->json(['exists' => $userExists]);
    }

    public function checkUserExistenceEdit(Request $request)
    {
        $username = $request->input('username');
        $role = $request->input('role');
        $id = $request->input('id');

        $userExists = User::where('nama_pengguna', $username)
            ->where('role', $role)
            ->where('status', 1)
            ->where('id', '!=', $id)
            ->exists();

        return response()->json(['exists' => $userExists, 'username'=>$username, 'role'=>$role]);
    }


}
