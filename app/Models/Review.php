<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Review extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];

    protected $fillable = [
        'id', 'order_id', 'user_id', 'mandor_id', 
        'rating_mandor',  // <-- Update nama
        'rating_service', // <-- Tambahan
        'comment'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    // Relasi ke mandor (User juga)
    public function mandor() {
        return $this->belongsTo(User::class, 'mandor_id');
    }

    /**
     * Relasi ke Order (Review ini milik order mana?)
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}