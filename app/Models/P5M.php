<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pelanggaran;

class P5M extends Model
{
    use HasFactory;

    protected $table = 'p5m';


    protected $fillable = [
        'id_p5m',
        'nim_mahasiswa',
        'tgl_transaksi',
        'kelas',
        'total_jam_minus',
    ];


}
