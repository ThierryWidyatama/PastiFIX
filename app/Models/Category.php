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
        'parent_id',
        'name',
        'description',
        'price',        // <-- IZIN DITAMBAHKAN
        'image_url',    // <-- IZIN DITAMBAHKAN
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Relasi ke Anak (Sub Categories / Services)
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Relasi ke Order (sudah ada)
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}