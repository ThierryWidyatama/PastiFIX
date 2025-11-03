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
        Schema::create('ms_area_kelurahan', function (Blueprint $table) {
            $table->char('id', 13)->primary();
            $table->char('kecamatan_id', 8)->nullable();
            $table->string('name', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_area_kelurahan');
    }
};
