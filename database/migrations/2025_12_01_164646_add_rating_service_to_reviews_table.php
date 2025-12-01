<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // 1. Rename dulu
            $table->renameColumn('rating', 'rating_mandor');
            
            // 2. Tambah kolom baru SETELAH 'rating_mandor' (Nama Baru)
            // JANGAN pakai 'rating' lagi di sini
            $table->integer('rating_service')->after('rating_mandor')->default(5); 
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // Urutan reverse: Hapus kolom dulu
            $table->dropColumn('rating_service');
            
            // Baru kembalikan nama lama
            $table->renameColumn('rating_mandor', 'rating');
        });
    }
};
