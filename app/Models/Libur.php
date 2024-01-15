<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Libur extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'Libur';

    protected $guarded = ['id'];


}
