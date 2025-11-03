<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMsDokumenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_dokumen', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tipe_dokumen_id')->nullable();
            $table->uuid('jenis_dokumen_id')->nullable();
            $table->string('bid_hukum_id')->nullable();
            $table->string('judul')->nullable();
            $table->string('tentang')->nullable();
            $table->string('nomor')->nullable();
            $table->string('no_panggil')->nullable();
            $table->string('jenis_peradilan')->nullable();
            $table->uuid('opd_id')->nullable();
            $table->string('pengarang')->nullable();
            $table->string('pemrakarsa')->nullable();
            $table->string('penandatangan')->nullable();
            $table->text('hasil_uji_materi')->nullable();
            $table->string('tajuk_entri_utama')->nullable();
            $table->date('tgl_ditetap')->nullable();
            $table->date('tgl_diundang')->nullable();
            $table->year('tahun_diundang')->nullable();
            $table->text('abstrak')->nullable();
            $table->text('katalog')->nullable();
            $table->string('edisi')->nullable();
            $table->string('tempat_terbit')->nullable();
            $table->string('penerbit')->nullable();
            $table->string('sumber')->nullable();
            $table->string('isbn')->nullable();
            $table->string('bahasa_id')->nullable();
            $table->string('no_induk_buku')->nullable();
            $table->string('lokasi')->nullable();
            $table->text('deskripsi_fisik')->nullable();
            $table->string('status')->nullable();
            $table->string('file')->nullable();
            $table->text('subjek')->nullable();
            $table->date('file_date')->nullable();
            $table->string('file_author')->nullable();
            $table->text('file_custom_status')->nullable();
            $table->string('link')->nullable();
            $table->string('file_cover')->nullable();
            $table->string('keyword')->nullable();
            $table->integer('unduh')->nullable();
            $table->integer('view')->nullable();
            $table->string('publish')->nullable();
            $table->timestamps();
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ms_dokumen');
    }
}
