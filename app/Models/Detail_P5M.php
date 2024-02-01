<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pelanggaran;

class Detail_P5M extends Model
{
    use HasFactory;

    protected $table = 'p5m_dtlp5m';
    protected $primaryKey = 'dp5m_id';


    protected $fillable = [
        'p5m_id',
        'plg_id',
        'dp5m_createdBy',
        'dp5m_jamMinus',

    ];


}
