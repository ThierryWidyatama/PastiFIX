<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provinsi extends Model
{
    use HasFactory;
    
    protected $table = "ms_area_provinsi";
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $guarded = [];
}
