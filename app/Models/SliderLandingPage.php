<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SliderLandingPage extends Model
{
    use HasFactory;

    protected $table = 'ms_slider_landing_page';
    protected $guarded = [];

    protected $casts = [
        'id' => 'string',
    ];
}
