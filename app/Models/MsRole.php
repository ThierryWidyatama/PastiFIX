<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids; // <-- 1. TAMBAHKAN INI

class MsRole extends Model
{
    use HasFactory;
    use HasUuids; // <-- 2. TAMBAHKAN INI

    /**
     * Nama tabel yang benar di database.
     */
    protected $table = 'ms_role';

    /**
     * Izinkan Mass Assignment (agar seeder bisa jalan).
     */
    protected $guarded = [];
}