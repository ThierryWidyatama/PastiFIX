<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukHukumLampiran extends Model
{
    protected $table = 'ms_dokumen_lampiran';
    protected $guarded = [];
    protected $casts = [
        'id' => 'string',
    ];

    public function produkHukum()
    {
        return $this->belongsTo(ProdukHukum::class, 'dokumen_id', 'id');
    }
}
