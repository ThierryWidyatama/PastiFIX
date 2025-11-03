<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipeDokumen extends Model
{
    protected $table = 'ms_dokumen_tipe';
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    public function getCreatedAtHumanAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getUpdatedAtHumanAttribute()
    {
        return $this->updated_at->diffForHumans();
    }
}
