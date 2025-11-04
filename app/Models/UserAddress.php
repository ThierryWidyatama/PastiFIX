<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids; // <-- 1. TAMBAHKAN INI

class UserAddress extends Model
{
    use HasFactory;
    use HasUuids; // <-- 2. TAMBAHKAN INI

    // 3. Pastikan $guarded = [] (atau $fillable) sudah ada
    protected $guarded = [];

    /**
     * Get the user that owns the address.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the orders for the address.
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'project_address_id');
    }
}