<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'p5m_mspelanggaran';

    protected $primaryKey = 'plg_id';

    protected $fillable = [
        'plg_jamMinus   ',
        'plg_nama',
        'plg_status',
    ];


}
