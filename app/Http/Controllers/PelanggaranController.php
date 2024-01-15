<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggaran;
use Illuminate\Support\Facades\DB;
use App\Models\Detail_P5M;

class PelanggaranController extends Controller
{


    public function index()
    {
        $pelanggaran = DB::select('EXEC sp_get_all_pelanggaran');

        return view('KoordinatorSOP_dan_TATIB/Pelanggaran/pelanggaran_lihat', compact('pelanggaran'));
    }

    public function pelanggaran_input()
    {
        return view('KoordinatorSOP_dan_TATIB/Pelanggaran/pelanggaran_input');
    }

    public function save(Request $request)
    {
        $nama_pelanggaran = $request->input('nama_pelanggaran');
        $jam_minus = $request->input('jam_minus');
    
        // Assuming sp_insert_pelanggaran takes only two parameters, adjust this accordingly
        DB::statement('EXEC sp_insert_pelanggaran ?, ?', [$nama_pelanggaran, $jam_minus]);

        $aktifitas = "Tambah Pelanggaran " . $nama_pelanggaran;
        $tanggal =  now()->format('Y-m-d');
    
    DB::statement('EXEC sp_insert_log ?, ?', [$aktifitas, $tanggal]);
    
        return redirect('pelanggaran');
    }
    public function pelanggaran_edit($id)
    {
        $pelanggaranArray = DB::select('EXEC sp_get_pelanggaran ?', [$id]);

        // Convert the array to an object
    $pelanggaran = (object) $pelanggaranArray[0];

        return view('KoordinatorSOP_dan_TATIB/Pelanggaran/pelanggaran_edit', compact('pelanggaran'));
    }


public function update(Request $request)
{

        $nama_pelanggaran = $request->input('nama_pelanggaran');
        $jam_minus = $request->input('jam_minus');
    $id = $request->input('id');

    DB::statement ('EXEC sp_update_pelanggaran ?, ?, ?', [$id, $nama_pelanggaran, $jam_minus]);

    $aktifitas = "Ubah Pelanggaran " . $nama_pelanggaran;
    $tanggal =  now()->format('Y-m-d');

DB::statement('EXEC sp_insert_log ?, ?', [$aktifitas, $tanggal]);

    return redirect('pelanggaran');
}


    public function delete($id)
    {
        DB::statement('EXEC sp_delete_pelanggaran ?', [$id]);

        $aktifitas = "Hapus Pelanggaran " . $nama_pelanggaran;
        $tanggal =  now()->format('Y-m-d');
    
    DB::statement('EXEC sp_insert_log ?, ?', [$aktifitas, $tanggal]);

        return redirect('pelanggaran');
    }

}
