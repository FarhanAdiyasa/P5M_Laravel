<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pelanggaran;

class Detail_P5M extends Model
{
    use HasFactory;

    protected $table = 'detail_p5m';


    protected $fillable = [
        'id_p5m',
        'id_pelanggaran',

    ];


}
