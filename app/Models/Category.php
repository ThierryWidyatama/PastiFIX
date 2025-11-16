<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Concerns\HasUuids; // <-- PENTING
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, HasUuids;

    /**
     * [FIX] Tentukan kolom mana saja yang BOLEH diisi secara massal.
     */
    protected $fillable = [
        'id',
        'name',
        'description',
        'price',        // <-- IZIN DITAMBAHKAN
        'image_url',    // <-- IZIN DITAMBAHKAN
    ];

    /**
     * Relasi ke Order (sudah ada)
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}