<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Pelanggaran;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use App\Imports\AbsenImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AbsensiController extends Controller
{
    public function index()
    {
        $absen = DB::select('EXEC sp_get_all_absen');
     

        return view('KoordinatorSOP_dan_TATIB/Daftar/daftarAbsensi', compact('absen'));    

    }

    public function soplapabsensi()
    {
        $url = 'https://api.polytechnic.astra.ac.id:2906/api_dev/efcc359990d14328fda74beb65088ef9660ca17e/SIA/getListMahasiswa?id_konsentrasi=3';
        $dataMahasiswa = Http::get($url)->json();

        $pelanggaran = DB::select('EXEC sp_get_all_pelanggaran');

        $p5m = DB::select('EXEC sp_get_all_p5m');

        $absen = DB::select('EXEC sp_get_all_absen');
        $get3tabel = DB::select('EXEC sp_get_pelanggaran_p5m');


        /*$pelanggaran = DB::table('pelanggaran')
        ->select('*')
        ->get();        // Adjust this based on your actual model

        // Assuming you have a get3tabel relationship in your P5M model
        //$p5m = P5M::with('p5m')->get(); // Adjust this based on your actual 
        $p5m = DB::table('p5m')
        ->select('*')
        ->get();      
        
        $absen = DB::table('absen')
        ->select('*')
        ->get();     // Adjust this based on your actual model

        $get3tabel= DB::table('pelanggaran')
        ->join('detail_p5m', 'pelanggaran.id_pelanggaran', '=', 'detail_p5m.id_pelanggaran')
    ->join('p5m', 'p5m.id_p5m', '=', 'detail_p5m.id_p5m')
    ->select('detail_p5m.id_pelanggaran', 'detail_p5m.id_p5m', 'p5m.tgl_transaksi', 'p5m.nim_mahasiswa')
        ->get(); */



            return view('KoordinatorSOP_dan_TATIB/Laporan/laporan_Absensi', compact('absen','dataMahasiswa', 'pelanggaran', 'p5m', 'get3tabel'));


        
     }

     public function soplapmnsabsen()
    {
        $url = 'https://api.polytechnic.astra.ac.id:2906/api_dev/efcc359990d14328fda74beb65088ef9660ca17e/SIA/getListMahasiswa?id_konsentrasi=3';
        $dataMahasiswa = Http::get($url)->json();

        $url = 'https://api.polytechnic.astra.ac.id:2906/api_dev/efcc359990d14328fda74beb65088ef9660ca17e/SIA/getListMahasiswa?id_konsentrasi=3';
        $dataMahasiswa = Http::get($url)->json();

        $pelanggaran = DB::select('EXEC sp_get_all_pelanggaran');

        $p5m = DB::select('EXEC sp_get_all_p5m');

        $absen = DB::select('EXEC sp_get_all_absen');
        $get3tabel = DB::select('EXEC sp_get_pelanggaran_p5m');




            return view('KoordinatorSOP_dan_TATIB/Laporan/laporan_jam_minus_Absensi', compact('absen','dataMahasiswa', 'pelanggaran', 'p5m', 'get3tabel'));
        
     }

     public function tingkatlapabsensi()
     {
         return view('KoordinatorTingkat/Laporan/laporan_Absensi');
         
      }
 
      public function tingkatlapmnsabsen()
     {
         return view('KoordinatorTingkat/Laporan/laporan_jam_minus_Absensi');
         
      }

      public function import_excel(Request $request) 
{
	// validasi
	//$this->validate($request, [
		//'file' => 'required|mimes:csv,xls,xlsx'
	//]);
 
	// menangkap file excel
	$file = $request->file('file');
 
	// membuat nama file unik
	$nama_file = rand().$file->getClientOriginalName();
 
	// upload ke folder file_siswa di dalam folder public
	$file->move('file_absen',$nama_file);
 
	// import data
	Excel::import(new AbsenImport, public_path('/file_absen/'.$nama_file));
 
	// notifikasi dengan session
	Session::flash('sukses','Data Absen Berhasil Diimport!');
 
	// alihkan halaman kembali
	return redirect('daftarAbsensi');
}

     

}
