<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Option extends Model
{
    use HasFactory;

    protected $table = "ms_option";
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $guarded = [];

}
