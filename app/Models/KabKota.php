<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KabKota extends Model
{
    use HasFactory;

    protected $table = "ms_area_kabkota";
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $guarded = [];

}
