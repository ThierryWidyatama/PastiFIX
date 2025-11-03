<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisDokumen extends Model
{
    protected $table = "ms_dokumen_jenis";
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $keyType = 'string';


    public function tipeDokumen()
    {
        return $this->hasOne(TipeDokumen::class, 'id', 'tipedokumen_id');
    }
}
