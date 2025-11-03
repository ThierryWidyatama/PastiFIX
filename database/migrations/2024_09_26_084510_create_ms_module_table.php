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
        Schema::create('ms_module', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('parent_id')->nullable();
            $table->string('code', 15)->nullable();
            $table->string('name', 100)->nullable();
            $table->string('link')->nullable();
            $table->mediumText('description')->nullable();
            $table->text('icon')->nullable();
            $table->mediumText('action')->nullable();
            $table->integer('order')->nullable();
            $table->string('is_category')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_module');
    }
};
