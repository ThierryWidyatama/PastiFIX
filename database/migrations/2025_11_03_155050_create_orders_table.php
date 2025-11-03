<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
        public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignUuid('category_id')->constrained('categories')->onDelete('restrict');
            
            // Relasi ke mandor (tabel 'users' juga)
            $table->foreignUuid('mandor_id')->nullable()->constrained('users')->onDelete('set null');
            
            // Relasi ke alamat (tabel 'user_addresses')
            $table->foreignUuid('project_address_id')->constrained('user_addresses')->onDelete('restrict');

            $table->text('description')->comment('Deskripsi kerusakan dari user');
            
            // Enum untuk status (sesuai dbdiagram kita)
            $table->enum('status', [
                'PENDING_ADMIN_REVIEW',
                'REJECTED_BY_ADMIN',
                'PENDING_MANDOR_QUOTE',
                'REJECTED_BY_MANDOR',
                'PENDING_USER_APPROVAL',
                'APPROVED_IN_PROGRESS',
                'COMPLETED_PENDING_PAYMENT',
                'FINISHED',
                'CANCELLED'
            ])->default('PENDING_ADMIN_REVIEW');

            $table->decimal('estimated_cost', 15, 2)->nullable()->comment('Total harga');
            $table->date('estimated_start_date')->nullable();
            $table->text('rejection_reason')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
