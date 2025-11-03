<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;

    protected $table = "ms_area_kecamatan";
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $guarded = [];
}
