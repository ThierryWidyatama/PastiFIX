<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ms_dokumen_tipe', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->nullable();
            $table->integer('order')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });

        DB::table('ms_dokumen_tipe')->insert([
            [
                'id' => Str::uuid(),
                'name' => 'Peraturan Perundangan-undangan',
                'order' => 1,
                'status' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Monografi Hukum',
                'order' => 2,
                'status' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Artikel Hukum',
                'order' => 3,
                'status' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Putusan',
                'order' => 4,
                'status' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_dokumen_tipe');
    }
};
