<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ms_landing_page', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->nullable();
            $table->string('full_name')->nullable();
            $table->text('about')->nullable();
            $table->timestamps();
        });

        // Insert Initial Data
        DB::table('ms_landing_page')->insert([
            'id' => Str::uuid(),
            'name' => 'Landing Page',
            'full_name' => 'Full Name Landing Page',
            'about' => 'About Landing Page',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_landing_page');
    }
};
