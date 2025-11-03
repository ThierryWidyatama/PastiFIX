<?php

namespace App\Models;

use App\Models\TipeDokumen;
use App\Models\JenisDokumen;
use App\Models\ProdukHukumLampiran;
use Illuminate\Database\Eloquent\Model;

class ProdukHukum extends Model
{
    protected $table = 'ms_dokumen';
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

    public function tipeDokumen()
    {
        return $this->hasOne(TipeDokumen::class, 'id', 'tipe_dokumen_id');
    }

    public function jenisDokumen()
    {
        return $this->hasOne(JenisDokumen::class, 'id', 'jenis_dokumen_id');
    }

    public function opd()
    {
        return $this->hasOne(Opd::class, 'id', 'opd_id');
    }

    public function bidangHukum()
    {
        return $this->hasOne(BidangHukum::class, 'id', 'bid_hukum_id');
    }

    public function bahasa()
    {
        return $this->hasOne(Bahasa::class, 'id', 'bahasa_id');
    }

    public function produkHukumTerkait()
    {
        return $this->belongsToMany(ProdukHukum::class, 'ms_dokumen_terkait', 'dokumen_id', 'dokumen_terkait_id');
    }

    public function produkHukumLampiran()
    {
        return $this->hasMany(ProdukHukumLampiran::class, 'dokumen_id', 'id');
    }
}
