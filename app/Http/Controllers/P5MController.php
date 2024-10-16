<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\P5M; // Assuming LoginUser is your model
use App\Models\Pelanggaran;
use App\Models\Detail_P5M;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;



class P5MController extends Controller
{
    public function p5msop()
    {
        $url = file_get_contents('https://api.polytechnic.astra.ac.id:2906/api_dev/efcc359990d14328fda74beb65088ef9660ca17e/SIA/getListMahasiswa?id_konsentrasi=3');
        $dataMahasiswa = json_decode($url, true);

        // Assuming you have a P5M model
        $KelasMahasiswa = collect($dataMahasiswa)->pluck('kelas')->unique()->values()->all();
        $pelanggaran = DB::select('EXEC sp_get_all_pelanggaran');
        $p5m = DB::select('EXEC sp_get_all_p5m');

        return view('KoordinatorSOP_dan_TATIB/P5M/P5M_Input', compact('dataMahasiswa', 'pelanggaran', 'p5m', 'KelasMahasiswa'));
    }

    public function p5msophistory()
    {
        $p5m = DB::select('EXEC sp_get_all_p5m');
            return view('KoordinatorSOP_dan_TATIB/History/history_lihat', compact('p5m'));
        
     }

     public function p5mtingkat()
    {
        /*$dataMahasiswa   = DB::connection('sqlsrv')->table('sia_msmahasiswa')
        ->select('*')->where('sia_msmahasiswa.kon_id', '=', 3)
        ->get();*/
        
        $url = file_get_contents('https://api.polytechnic.astra.ac.id:2906/api_dev/efcc359990d14328fda74beb65088ef9660ca17e/SIA/getListMahasiswa?id_konsentrasi=3');
		$dataMahasiswa = json_decode($url, true);


        // Assuming you have a P5M model
        $pelanggaran = DB::select('EXEC sp_get_all_pelanggaran');

        // Assuming you have a get3tabel relationship in your P5M model
        //$p5m = P5M::with('p5m')->get(); // Adjust this based on your actual 
        $p5m = DB::select('EXEC sp_get_all_p5m');

        return view('KoordinatorTingkat/P5M/P5M_Input', compact('dataMahasiswa', 'pelanggaran', 'p5m'));
    }

    public function p5mtingkathistory()
    {
        $p5m = DB::select('EXEC sp_get_all_p5m');
            return view('KoordinatorTingkat/History/history_lihat', compact('p5m'));
        
    }

    public function laporanp5m()
    {
        $apiUrl = "https://api.polytechnic.astra.ac.id:2906/api_dev/efcc359990d14328fda74beb65088ef9660ca17e/SIA/getListMahasiswa?id_konsentrasi=3";

        $response = Http::get($apiUrl);

        if ($response->successful()) {
            $dataMahasiswa = $response->json();

            $kelasMahasiswa = collect($dataMahasiswa)->pluck('kelas')->unique()->values()->all();

            return view('KoordinatorSOP_dan_TATIB/Laporan/laporan_jam_minus', ['KelasMahasiswa' => $kelasMahasiswa]);
        }
        
     }

     function tambah()
     {
         date_default_timezone_set('Asia/Jakarta');
     
         $url = file_get_contents('https://api.polytechnic.astra.ac.id:2906/api_dev/efcc359990d14328fda74beb65088ef9660ca17e/SIA/getListMahasiswa?id_konsentrasi=3');
         $dataMahasiswa = json_decode($url, true);
     
         $pelanggaran = DB::select('EXEC sp_get_all_pelanggaran');

         $p5m = DB::select('EXEC sp_get_all_p5m');
 
         $status = 0;
         $total_jam_minus = 0;
         $nim_lama = 0;
         $id_P5M = 0;

     
         foreach ($dataMahasiswa as $dm) {
             foreach ($pelanggaran as $m) {
                 if (request()->input('CB_' . $dm['nim'] . '_' . $m->plg_id)) {
                     if ($nim_lama != $dm['nim']) {
                         $total_jam_minus = 0;
                     }
     
                     $total_jam_minus += request()->input('CB_' . $dm['nim'] . '_' . $m->plg_id);
                     $nim_lama = $dm['nim'];
                 }
             }
     
             if ($nim_lama == $dm['nim']) {
                 $kirimP5M = [
                     'p5m_nim' => $dm['nim'],
                     'p5m_tanggal' => now(),
                     //'kelas' => $dm['kelas'],
                     //'total_jam_minus' => $total_jam_minus,
                 ];
     
                 DB::table('p5m_trp5m')->insert($kirimP5M);
     
                 $status = 0;
                 $total_jam_minus = 0;
                 $nim_lama = 0;
                 $id_P5M = 0;
     
                 foreach ($pelanggaran as $m) {
                     if (request()->input('CB_' . $dm['nim'] . '_' . $m->plg_id)) {
                         if ($nim_lama != $dm['nim']) {
                             $total_jam_minus = 0;
                         }
     
                         $total_jam_minus += request()->input('CB_' . $dm['nim'] . '_' . $m->plg_id);
                         $nim_lama = $dm['nim'];
     
                         $p5mModels = DB::select('EXEC sp_get_all_p5m');
     
                         foreach ($p5mModels as $tr) {
                             $p5m_id = $tr->p5m_id;
                         }
     
                         DB::table('p5m_dtlp5m')->insert([
                             'p5m_id' => $p5m_id,
                             'plg_id' => $m->plg_id,
                         ]);
                     }
                 }
             }
         }
         $log_aktifitas = "Melakukan P5M";
         $log_tanggal =  now()->format('Y-m-d');
     
        DB::statement('EXEC sp_insert_log ?, ?', [$log_aktifitas, $log_tanggal]);
     
     
         return redirect()->route('p5m')->with('success', 'Pelanggaran P5M Berhasil Ditambahkan');
     }

     public function p5mlihat()
     {
        $url = file_get_contents('https://api.polytechnic.astra.ac.id:2906/api_dev/efcc359990d14328fda74beb65088ef9660ca17e/SIA/getListMahasiswa?id_konsentrasi=3');
        $dataMahasiswa = json_decode($url, true);
        
        /*$dataMahasiswa   = DB::connection('sqlsrv2')->table('mahasiswa')
        ->select('*')
        ->get();*/  

        // Assuming you have a P5M model
        $pelanggaran = DB::select('EXEC sp_get_all_pelanggaran');

        $p5m = DB::select('EXEC sp_get_all_p5m');

        $get3tabel = DB::select('EXEC sp_get_pelanggaran_p5m');




        return view('KoordinatorSOP_dan_TATIB/P5M/P5M_Lihat', compact('dataMahasiswa', 'pelanggaran', 'p5m', 'get3tabel'));
         
      }


public function pilih_kelas(Request $request)
{
    // Logika untuk menangani pemilihan kelas

    // Mendapatkan data tanggal yang ingin ditampilkan
    $tanggalData = []; // Gantilah ini dengan logika untuk mendapatkan data tanggal sesuai kelas

    // Mendapatkan data mahasiswa dari API
    $url = file_get_contents('https://api.polytechnic.astra.ac.id:2906/api_dev/efcc359990d14328fda74beb65088ef9660ca17e/SIA/getListMahasiswa?id_konsentrasi=3');
    $dataMahasiswa = json_decode($url, true);

    // Mengirim data mahasiswa dan tanggal ke halaman "pilih_kelas"
    return view('KoordinatorSOP_dan_TATIB/History/pilih_kelas', compact('dataMahasiswa', 'tanggalData'));
}


       public function pilih_tanggal($kelas)
       {
            $url = file_get_contents('https://api.polytechnic.astra.ac.id:2906/api_dev/efcc359990d14328fda74beb65088ef9660ca17e/SIA/getListMahasiswa?id_konsentrasi=3');
            $dataMahasiswa = json_decode($url, true);

            $pelanggaran = DB::select('EXEC sp_get_all_pelanggaran');

            $p5m = DB::select('EXEC sp_get_all_p5m');

            $get3tabel = DB::select('EXEC sp_get_pelanggaran_p5m');

        

            return view('KoordinatorSOP_dan_TATIB/P5M/P5M_Lihat', compact('dataMahasiswa', 'pelanggaran', 'p5m', 'get3tabel', 'kelas'));
    
           
        }
 
     
}