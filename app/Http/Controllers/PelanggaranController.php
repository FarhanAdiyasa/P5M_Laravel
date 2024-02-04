<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggaran;
use Illuminate\Support\Facades\DB;
use App\Models\Detail_P5M;
use Illuminate\Validation\Rule;

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
        $request->validate([
            'plg_nama' => [
                'required',
                'max:255',
                
                Rule::unique('p5m_mspelanggaran', 'plg_nama')
                ->where(function ($query) {
                    return $query->where('plg_status', '1');
                })
                ->ignore($request->id)            ],
            'plg_jamMinus' => 'required|numeric',
        ]);
        
        $plg_nama = $request->input('plg_nama');
        $plg_jamMinus = $request->input('plg_jamMinus');
    
        // Assuming sp_insert_pelanggaran takes only two parameters, adjust this accordingly
        DB::statement('EXEC sp_insert_pelanggaran ?, ?', [$plg_nama, $plg_jamMinus]);

        $log_aktifitas = "Tambah Pelanggaran " . $plg_nama;
        $log_tanggal =  now()->format('Y-m-d');
    
        DB::statement('EXEC sp_insert_log ?, ?', [$log_aktifitas, $log_tanggal]);
    
        return redirect('pelanggaran')->with('success', 'Data berhasil ditambahkan.');
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
        $id = $request->input('plg_id');
    
        $request->validate([
            'plg_nama' => [
                'required',
                'max:255',
                Rule::unique('p5m_mspelanggaran', 'plg_nama')
                    ->where(function ($query) {
                        return $query->where('plg_status', 1);
                    })
                    ->ignore($id, 'plg_id')
            ],
            'plg_jamMinus' => 'required|numeric',
        ]);
    
        $plg_nama = $request->input('plg_nama');
        $plg_jamMinus = $request->input('plg_jamMinus');
    
        DB::statement('EXEC sp_update_pelanggaran ?, ?, ?', [$id, $plg_nama, $plg_jamMinus]);
    
        $log_aktifitas = "Ubah Pelanggaran " . $plg_nama;
        $log_tanggal = now()->format('Y-m-d');
    
        DB::statement('EXEC sp_insert_log ?, ?', [$log_aktifitas, $log_tanggal]);
    
        return redirect('pelanggaran')->with('update', 'Data berhasil diubah.');
    }
    
    public function delete($id)
    {
        $user = DB::select('SELECT plg_nama FROM p5m_mspelanggaran WHERE plg_id = ?', [$id]);

        $plg_nama = strval($user[0]->plg_nama);

        DB::statement('EXEC sp_delete_pelanggaran ?', [$id]);

        $log_aktifitas = "Hapus Pelanggaran " . $plg_nama;
        $log_tanggal =  now()->format('Y-m-d');
    
        DB::statement('EXEC sp_insert_log ?, ?', [$log_aktifitas, $log_tanggal]);

        return redirect('pelanggaran')->with('delete', 'Data berhasil dihapus');
    }

}
