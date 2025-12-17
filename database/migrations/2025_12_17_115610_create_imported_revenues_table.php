<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('imported_revenues', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->date('revenue_date'); // Tanggal pemasukan
        $table->decimal('amount', 15, 2); // Jumlah uang
        $table->string('description')->nullable(); // Keterangan (misal: "Semen sisa")
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('imported_revenues');
}
};
