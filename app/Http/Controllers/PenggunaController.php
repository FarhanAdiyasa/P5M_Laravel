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

        $username = $request->input("username");

        $nama_pengguna = $request->input("nama_pengguna");
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
        $id = $request->input("id");
        $username = $request->input("username");

        $nama_pengguna = $request->input("nama_pengguna");
        $role = $request->input("role");
        $kelas = $request->input("kelas");
    
        DB::statement('EXEC sp_update_pengguna ?, ?, ?, ?, ?, 1', [$id, $username,$nama_pengguna, $role, $kelas]);
    
        return redirect('user_lihat');
    return redirect('user_lihat');
}


    function delete($id){


        DB::statement('EXEC sp_delete_pengguna ?', [$id]);

    
        return redirect('user_lihat');
}


}
