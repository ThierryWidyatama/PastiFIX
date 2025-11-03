<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    /**
     * Get the user that owns the address.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'project_address_id');
    }
    protected $guarded = [];
}
