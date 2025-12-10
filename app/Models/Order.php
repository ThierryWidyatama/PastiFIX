<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Concerns\HasUuids; // <-- PENTING
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, HasUuids; // <-- PENTING
    protected $fillable = [
        'id', 
        'user_id', 
        'category_id', 
        'mandor_id', 
        'status', 
        'estimated_cost', 
        'project_address_id',
        'cancellation_reason', // <--- JANGAN LUPA TAMBAHKAN INI!
    ];

    // Relasi ke Pemilik Pesanan (User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Mandor (User)
    public function mandor()
    {
        return $this->belongsTo(User::class, 'mandor_id');
    }

    // Relasi ke Kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke Alamat Proyek
    public function projectAddress()
    {
        return $this->belongsTo(UserAddress::class, 'project_address_id');
    }

    // Relasi ke Rincian Harga
    public function costItems()
    {
        return $this->hasMany(CostItem::class);
    }

    // Relasi ke Timeline Kerja
    public function workTimelines()
    {
        return $this->hasMany(WorkTimeline::class);
    }
    // Relasi ke Review (One to One: Satu order cuma punya satu review dari user)
    public function review()
    {
        return $this->hasOne(Review::class);
    }
}