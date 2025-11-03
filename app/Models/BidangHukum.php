<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BidangHukum extends Model
{
    protected $table = 'ms_dokumen_bidang_hukum';
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
