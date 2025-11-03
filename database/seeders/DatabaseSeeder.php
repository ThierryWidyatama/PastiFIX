<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\MsRole; // <-- 1. PENTING! Kita butuh ini
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 2. Jalankan seeder role dulu (ini udah bener)
        $this->call([
            MsRoleSeeder::class,
        ]);

        // 3. Ambil ID dari role 'User' (yang kodenya 'USR')
        $userRole = MsRole::where('code', 'USR')->first();

        // 4. Buat 'Test User' dengan data LENGKAP
        User::factory()->create([
            'id' => Str::uuid(),
            'name' => 'Test User',
            'email' => 'test@example.com',
            'username' => 'testuser',    // <-- FIX 1: Error username
            'role_id' => $userRole->id, // <-- FIX 2: Error role_id
            'status' => 1,                // <-- FIX 3: (Asumsi 1 = Aktif)
        ]);
    }
}