<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class LliburController extends Controller
{


    public function index()
    {
        $llibur = DB::select('EXEC sp_get_all_libur');

        return view('KoordinatorSOP_dan_TATIB/libur/libur_lihat', compact('libur'));
    }

    public function llibur_input()
    {
        return view('KoordinatorSOP_dan_TATIB/libur/libur_input');
    }

    public function save(Request $request)
    {
        $tanggal = $request->input('tanggal');
        $deskripsi = $request->input('deskripsi');
        $kategori = $request->input('kategori');
        $status = $request->input('status');

        // Assuming sp_insert_libur takes four parameters, adjust this accordingly
        DB::statement('EXEC sp_insert_libur ?, ?, ?, ?', [$tanggal, $deskripsi, $kategori, $status]);

        return redirect('libur');
    }
    public function libur_edit($id)
    {
        $liburArray = DB::select('EXEC sp_get_libur ?', [$id]);

        // Convert the array to an object
    $libur = (object) $liburArray[0];

        return view('KoordinatorSOP_dan_TATIB/libur/libur_edit', compact('libur'));
    }


    public function update(Request $request)
    {
        $id = $request->input('id');
        $tanggal = $request->input('tanggal');
        $deskripsi = $request->input('deskripsi');
        $kategori = $request->input('kategori');
        $status = $request->input('status');
    
        // Assuming sp_update_libur takes five parameters, adjust this accordingly
        DB::statement('EXEC sp_update_libur ?, ?, ?, ?, ?', [$id, $tanggal, $deskripsi, $kategori, $status]);
    
        return redirect('libur');
    }


    public function delete($id)
    {
        DB::statement('EXEC sp_delete_libur ?', [$id]);

        return redirect('libur');
    }

}
