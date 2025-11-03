<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    use HasFactory;
    protected $table = 'ms_social_media';

    protected $guarded = [];
    protected $casts = [
        'id' => 'string',
    ];
}
