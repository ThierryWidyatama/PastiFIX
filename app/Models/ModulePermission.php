<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModulePermission extends Model
{
    use HasFactory;

    protected $table = "ms_module_permission";
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = ['role_id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }
}
