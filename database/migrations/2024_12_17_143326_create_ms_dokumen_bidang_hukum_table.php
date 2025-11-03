<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ms_dokumen_bidang_hukum', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });

        $bidangHukum =
            [
                array('id' => Str::uuid(), 'name' => 'Hukum Pidana', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Hukum Perdata', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Pajak', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Hukum Acara', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Hukum Adat', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Hukum Administrasi Negara', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Hukum Agraria', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Hukum Dagang', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Hukum Internasional', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Hukum Islam', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Sumber Daya Alam', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Transportasi', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Hukum Lingkungan', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Kesehatan', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Hukum Lingkungan', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Keuangan Daerah', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Pemerintahan Daerah', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Kepegawaian', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Pertanahan', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Partai Politik', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Anggaran Pendapatan dan Belanja Daerah', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Administrasi Kewilayahan', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Tata Kelola Wilayah', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Dana Bagi Hasil', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Standarisasi Biaya', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Dewan Perwakilan Rakyat Daerah (DPRD)', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Perseroan Daerah', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Rencana Aksi Daerah', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Bencana Alam', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'perhubungan', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Peternakan', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Pertanian', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Perindustrian', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Ketenagakerjaan', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Pendidikan', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Perikanan', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Pertambangan', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Pelayanan Publik', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Retribusi', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Perikanan', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'DESA', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'JASA USAHA', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Barang Milik Daerah', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Pariwisata', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Partai Politik', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Hak Asasi Manusia', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Koperasi', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Kesehatan Hewan', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'PERDAGANGAN ', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Penyiaran', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Perkebunan ', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'USAHA MIKRO, KECIL, DAN MENENGAH ', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Kependudukan', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Pengadaan Barang dan Jasa', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL),
                array('id' => Str::uuid(), 'name' => 'Kearsipan', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL)
            ];

        DB::table('ms_dokumen_bidang_hukum')->insert($bidangHukum);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_dokumen_bidang_hukum');
    }
};
