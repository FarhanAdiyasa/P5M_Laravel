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
            'nama_pelanggaran' => [
                'required',
                'max:255',
                
                Rule::unique('pelanggaran', 'nama_pelanggaran')
                ->where(function ($query) {
                    return $query->where('status', '1');
                })
                ->ignore($request->id)            ],
            'jam_minus' => 'required|numeric',
        ]);
        
        $nama_pelanggaran = $request->input('nama_pelanggaran');
        $jam_minus = $request->input('jam_minus');
    
        // Assuming sp_insert_pelanggaran takes only two parameters, adjust this accordingly
        DB::statement('EXEC sp_insert_pelanggaran ?, ?', [$nama_pelanggaran, $jam_minus]);

        $aktifitas = "Tambah Pelanggaran " . $nama_pelanggaran;
        $tanggal =  now()->format('Y-m-d');
    
        DB::statement('EXEC sp_insert_log ?, ?', [$aktifitas, $tanggal]);
    
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
        $id = $request->input('id');
    
        $request->validate([
            'nama_pelanggaran' => [
                'required',
                'max:255',
                Rule::unique('pelanggaran', 'nama_pelanggaran')
                    ->where(function ($query) {
                        return $query->where('status', 1);
                    })
                    ->ignore($id)
            ],
            'jam_minus' => 'required|numeric',
        ]);
    
        $nama_pelanggaran = $request->input('nama_pelanggaran');
        $jam_minus = $request->input('jam_minus');
    
        DB::statement('EXEC sp_update_pelanggaran ?, ?, ?', [$id, $nama_pelanggaran, $jam_minus]);
    
        $aktifitas = "Ubah Pelanggaran " . $nama_pelanggaran;
        $tanggal = now()->format('Y-m-d');
    
        DB::statement('EXEC sp_insert_log ?, ?', [$aktifitas, $tanggal]);
    
        return redirect('pelanggaran')->with('update', 'Data berhasil diubah.');
    }
    
    public function delete($id)
    {
        $user = DB::select('SELECT nama_pelanggaran FROM pelanggaran WHERE id = ?', [$id]);

        $nama_pelanggaran = strval($user[0]->nama_pelanggaran);

        DB::statement('EXEC sp_delete_pelanggaran ?', [$id]);

        $aktifitas = "Hapus Pelanggaran " . $nama_pelanggaran;
        $tanggal =  now()->format('Y-m-d');
    
        DB::statement('EXEC sp_insert_log ?, ?', [$aktifitas, $tanggal]);

        return redirect('pelanggaran')->with('delete', 'Data berhasil dihapus');
    }

}
