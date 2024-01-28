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
        /*$dataMahasiswa   = DB::connection('sqlsrv')->table('sia_msmahasiswa')
        ->select('*')->where('sia_msmahasiswa.kon_id', '=', 3)
        ->get(); */
        $url = file_get_contents('https://api.polytechnic.astra.ac.id:2906/api_dev/efcc359990d14328fda74beb65088ef9660ca17e/SIA/getListMahasiswa?id_konsentrasi=3');
        $dataMahasiswa = json_decode($url, true);

        
        /*$dataMahasiswa   = DB::connection('sqlsrv2')->table('mahasiswa')
        ->select('*')
        ->get();*/  

        // Assuming you have a P5M model
        $pelanggaran = DB::select('EXEC sp_get_all_pelanggaran');
        $p5m = DB::select('EXEC sp_get_all_p5m');

        // Assuming you have a get3tabel relationship in your P5M model
        //$p5m = P5M::with('p5m')->get(); // Adjust this based on your actual 

        return view('KoordinatorSOP_dan_TATIB/P5M/P5M_Input', compact('dataMahasiswa', 'pelanggaran', 'p5m'));
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
                 if (request()->input('CB_' . $dm['nim'] . '_' . $m->id)) {
                     if ($nim_lama != $dm['nim']) {
                         $total_jam_minus = 0;
                     }
     
                     $total_jam_minus += request()->input('CB_' . $dm['nim'] . '_' . $m->id);
                     $nim_lama = $dm['nim'];
                 }
             }
     
             if ($nim_lama == $dm['nim']) {
                 $kirimP5M = [
                     'nim_mahasiswa' => $dm['nim'],
                     'tgl_transaksi' => now(),
                     //'kelas' => $dm['kelas'],
                     //'total_jam_minus' => $total_jam_minus,
                 ];
     
                 DB::table('p5m')->insert($kirimP5M);
     
                 $status = 0;
                 $total_jam_minus = 0;
                 $nim_lama = 0;
                 $id_P5M = 0;
     
                 foreach ($pelanggaran as $m) {
                     if (request()->input('CB_' . $dm['nim'] . '_' . $m->id)) {
                         if ($nim_lama != $dm['nim']) {
                             $total_jam_minus = 0;
                         }
     
                         $total_jam_minus += request()->input('CB_' . $dm['nim'] . '_' . $m->id);
                         $nim_lama = $dm['nim'];
     
                         $p5mModels = DB::select('EXEC sp_get_all_p5m');
     
                         foreach ($p5mModels as $tr) {
                             $id_P5M = $tr->id_p5m;
                         }
     
                         DB::table('detail_p5m')->insert([
                             'id_p5M' => $id_P5M,
                             'id_pelanggaran' => $m->id,
                         ]);
                     }
                 }
             }
         }
         $aktifitas = "Melakukan P5M";
         $tanggal =  now()->format('Y-m-d');
     
        DB::statement('EXEC sp_insert_log ?, ?', [$aktifitas, $tanggal]);
     
     
         return redirect('p5msop')->with('success', 'Pelanggaran P5M Berhasil Ditambahkan');
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