<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('users')->insert([
            [
                'id' => Str::uuid(),
                'name' => 'Super Administrator',
                'email' => 'superadmin@smt.com',
                'username' => 'suparman',
                'password' => Hash::make('!suparman123!@#'),
                'email_verified_at' => now(),
                'role_id' => DB::table('ms_role')->where('code', 'SUPADM')->first()->id,
                'status' => '1',
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Administrator',
                'email' => 'admin@smt.com',
                'username' => 'minstra',
                'password' => Hash::make('!minstra123!@#'),
                'email_verified_at' => now(),
                'role_id' => DB::table('ms_role')->where('code', 'ADM')->first()->id,
                'status' => '1',
            ],
            [
                'id' => Str::uuid(),
                'name' => 'User',
                'email' => 'user@smt.com',
                'username' => 'user',
                'password' => Hash::make('!user123!@#'),
                'email_verified_at' => now(),
                'role_id' => DB::table('ms_role')->where('code', 'USR')->first()->id,
                'status' => '1',
            ],
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
