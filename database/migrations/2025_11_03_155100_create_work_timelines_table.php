<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
        public function up(): void
    {
        Schema::create('work_timelines', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('order_id')->constrained('orders')->onDelete('cascade');
            $table->date('work_date');
            $table->string('description')->nullable()->comment('Contoh: Pengerjaan hari ke-1');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_timelines');
    }
};
