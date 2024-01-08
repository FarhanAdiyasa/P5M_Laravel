<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Login_User extends Model
{
    protected $connection = 'sqlsrv2';
    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';
    public $timestamps = false; // Assuming the table doesn't have created_at and updated_at columns.
    protected $fillable = ['nama_pengguna', 'role', 'kelas'];

}

