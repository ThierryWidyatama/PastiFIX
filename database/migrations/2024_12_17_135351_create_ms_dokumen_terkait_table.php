<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMsDokumenTerkaitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_dokumen_terkait', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('dokumen_id')->nullable();
            $table->uuid('dokumen_terkait_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ms_dokumen_terkait');
    }
}
