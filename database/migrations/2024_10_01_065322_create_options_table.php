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
        Schema::create('ms_option', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 100);
            $table->string('address', 100);
            $table->string('phone', 50);
            $table->string('fax', 50);
            $table->string('email', 50);
            $table->string('logo', 255)->nullable();
            $table->string('logo_dark', 255)->nullable();
            $table->string('favicon', 255)->nullable();
            $table->string('description', 255)->nullable();
            $table->time('starthour')->nullable();
            $table->time('endhour')->nullable();
            $table->string('latitude', 100)->nullable();
            $table->string('longitude', 100)->nullable();
            $table->text('announcement')->nullable();
            $table->boolean('is_landing_page')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_option');
    }
};
