<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('reviews', function (Blueprint $table) {
        $table->uuid('id')->primary();

        // Relasi penting
        $table->foreignUuid('order_id')->constrained('orders')->onDelete('cascade');
        $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');   // Yang mereview
        $table->foreignUuid('mandor_id')->constrained('users')->onDelete('cascade'); // Yang direview

        $table->integer('rating'); // 1 sampai 5
        $table->text('comment')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
