<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Ubah default 'status' jadi 0 (Tidak Aktif)
            $table->tinyInteger('status')->default(0)->change();
            
            // Kolom baru untuk kode
            $table->string('verification_code')->nullable()->after('remember_token');
            $table->timestamp('verification_expires_at')->nullable()->after('verification_code');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['verification_code', 'verification_expires_at']);
            $table->tinyInteger('status')->default(1)->change(); // Kembalikan default
        });
    }
};
