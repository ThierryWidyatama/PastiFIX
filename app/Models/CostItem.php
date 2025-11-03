<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Concerns\HasUuids; // <-- PENTING
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostItem extends Model
{
    use HasFactory, HasUuids; // <-- PENTING
    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}