<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;


class MahasiswaController extends Controller
{


    public function index()
    {
        /*$mahasiswa   = DB::connection('sqlsrv')->table('sia_msmahasiswa as m')
    ->select('m.mhs_id', 'm.mhs_nama', 'm.mhs_angkatan', 'm.kel_id', 'p.pro_nama')
    ->join('sia_msprodi as p', 'm.kon_id', '=', 'p.pro_id')
    ->where('m.kon_id', '=', 3)
    ->get();*/
    
    /*$mahasiswa   = DB::connection('sqlsrv2')->table('mahasiswa')
    ->select('*')
    ->get();*/

    $url = file_get_contents('https://api.polytechnic.astra.ac.id:2906/api_dev/efcc359990d14328fda74beb65088ef9660ca17e/SIA/getListMahasiswa?id_konsentrasi=3');
        $mahasiswa = json_decode($url, true);


        return view('KoordinatorSOP_dan_TATIB/Mahasiswa/daftarMahasiswa', compact('mahasiswa'));    
    }

    function mahasiswa_input(){
        return view('KoordinatorSOP_dan_TATIB/Mahasiswa/mahasiswa_input');
    }

    function save (Request $request){

        //$result = Mahasiswa::create($request->all());

        $data = $request->except('_token');
        //DB::connection('sqlsrv')->table('sia_msmahasiswa')->insert($data); 
        DB::table('mahasiswa')->insert($data); 

        return redirect('mahasiswa');
    }

    function mahasiswa_edit($id){
        //$data['mahasiswa'] = DB::connection('sqlsrv')->table('sia_msmahasiswa')->where('mhs_id', $id)->first();
        $data['mahasiswa'] = DB::table('mahasiswa')->where('nim', $id)->first();

        //$data['mahasiswa'] =  Mahasiswa::where([
         //   ['nim', '=', $id]
        //])->first();
        return view('KoordinatorSOP_dan_TATIB/Mahasiswa/mahasiswa_edit', $data);
    
}

public function update(Request $request)
{
    $data = [
        'nim' => $request->input("nim"),
        'nama' => $request->input("nama"),
        'mhs_angkatan' => $request->input("mhs_angkatan"),
        'kelas' => $request->input("kelas"),
        'prodi' => $request->input("prodi"),
        'email' => $request->input("email"),
        'dosen_wali' => $request->input("dosen_wali"),
    ];

    $id = $request->input("nim");
    //$result = Mahasiswa::where('nim', $id)->update($data);

    $result = DB::table('mahasiswa')
    ->where('nim', $id)
    ->update($data);

    return redirect('mahasiswa');
}


    function delete($id){

        //Mahasiswa::where('nim', $id)->delete();
        //DB::connection('sqlsrv')->table('sia_msmahasiswa')->where('mhs_id', $id)->delete();
        DB::table('mahasiswa')->where('nim', $id)->delete();

        return redirect('mahasiswa');
    }


}
