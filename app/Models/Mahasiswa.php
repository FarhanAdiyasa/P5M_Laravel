<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'mahasiswa';

    protected $fillable = [
        'nim',
        'nama',
        'mhs_angkatan',
        'kelas',
        'prodi',
        'email',
        'dosen_wali',
    ];

}
