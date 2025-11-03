<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Ini adalah foreign key ke tabel 'users'
            // Pastikan tabel 'users' kamu juga pakai 'uuid'
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');

            $table->text('address_line')->nullable()->comment('Alamat Lengap');
            $table->string('rt_rw', 10)->nullable();
            $table->string('postal_code', 10)->nullable()->comment('Kodepos');
            $table->text('landmark_details')->nullable()->comment('Detail Patokan');
            
            // Untuk Google Maps (Titik Rumah)
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            $table->boolean('is_primary')->default(true)->comment('Alamat utama user');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
};
