<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pelanggaran;

class P5M extends Model
{
    use HasFactory;

    protected $table = 'p5m_trp5m';


    protected $fillable = [
        'p5m_id',
        'p5m_nim',
        'p5m_tanggal',
    ];


}
