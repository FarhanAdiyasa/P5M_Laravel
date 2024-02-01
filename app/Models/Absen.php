<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'p5m_msabsen';
    protected $primaryKey = 'abs_id';

    protected $fillable = [
        'abs_nim',
        'abs_waktu',
    ];


}
