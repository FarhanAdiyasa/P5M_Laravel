<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'pelanggaran';

    protected $primaryKey = 'id_pelanggaran';

    protected $fillable = [
        'id_pelanggaran',
        'nama_pelanggaran',
        'jam_minus',
    ];


}
