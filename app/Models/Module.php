<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Module extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "ms_module";
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function child()
    {
        return $this->hasMany(Module::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->hasOne(Module::class, 'id', 'parent_id');
    }

    public function permission(){
        return $this->hasMany(ModulePermission::class, 'module_id' , 'id');
    }
}
