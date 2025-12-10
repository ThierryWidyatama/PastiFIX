<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
{
    // Kita ubah kolom status agar menerima 'CANCEL_REQUESTED'
    DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM(
        'PENDING',
        'PENDING_ADMIN_REVIEW',
        'PENDING_MANDOR_QUOTE',
        'APPROVED_IN_PROGRESS',
        'COMPLETED_PENDING_PAYMENT',
        'FINISHED',
        'REJECTED_BY_ADMIN',
        'REJECTED_BY_MANDOR',
        'CANCELLED',
        'CANCEL_REQUESTED'  -- <--- INI PENGHUNI BARUNYA
    ) NOT NULL DEFAULT 'PENDING_ADMIN_REVIEW'");
}
};
