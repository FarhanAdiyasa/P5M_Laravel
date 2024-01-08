<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Mahasiswa;

class ListController extends Controller
{
    public function prodi()
    {
        return view('KoordinatorSOP_dan_TATIB/prodi/ProdiList');
    }

    public function p4()
    {
        return view('KoordinatorSOP_dan_TATIB/prodi/P4');
    }

    public function tpm()
    {
        return view('KoordinatorSOP_dan_TATIB/prodi/TPM');
    }

    public function mi()
    {
        return view('KoordinatorSOP_dan_TATIB/prodi/MI');
    }

    public function mo()
    {
        return view('KoordinatorSOP_dan_TATIB/prodi/MO');
    }

    public function mk()
    {
        return view('KoordinatorSOP_dan_TATIB/prodi/MK');
    }

    public function tkbg()
    {
        return view('KoordinatorSOP_dan_TATIB/prodi/TKBG');
    }


}
