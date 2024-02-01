<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Libur extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'p5m_mslibur';

    protected $guarded = ['lbr_id'];
    protected $primaryKey = 'lbr_id';


}
