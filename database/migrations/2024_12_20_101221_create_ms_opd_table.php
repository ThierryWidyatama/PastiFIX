<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ms_opd', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });

        $opd = [
            array('id' => Str::uuid(), 'name' => 'Dinas Pendidikan', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
            array('id' => Str::uuid(), 'name' => 'Dinas Kesehatan', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
        ];

        DB::table('ms_opd')->insert($opd);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_opd');
    }
};
