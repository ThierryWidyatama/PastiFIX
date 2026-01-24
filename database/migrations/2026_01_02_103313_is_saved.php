<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // public function up(): void
    // {
    //     Schema::table('user_addresses', function (Blueprint $table) {
    //         //Default 1 (True) artinya tersimpan. Kalau 0 berarti sekali pakai.
    //         $table->boolean('is_saved')->default(true)->after('is_primary');
    //     });
    // }

    // public function down(): void
    // {
    //     Schema::table('user_addresses', function (Blueprint $table) {
    //         $table->dropColumn('is_saved');
    //     });
    // }
};
