<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ms_dokumen_jenis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tipedokumen_id')->nullable();
            $table->string('name')->nullable();
            $table->text('link')->nullable();
            $table->string('singkatan')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });


        $dokumenJenis = [
            [
                'id' => Str::uuid(),
                'name' => "Peraturan Daerah Provinsi Jawa Tengah",
                'link' => "peraturan-daerah-provinsi-jawa-tengah",
                'created_at' => date('Y-m-d H:i:s'),
                'status' => '1',
                'singkatan' => "perda",
                'tipedokumen_id' => "1",
                'description' => null
            ],
            [
                'id' => Str::uuid(),
                'name' => "Peraturan Gubernur Jawa Tengah",
                'link' => "peraturan-gubernur-jawa-tengah",
                'created_at' => date('Y-m-d H:i:s'),
                'status' => '1',
                'singkatan' => "pergub",
                'tipedokumen_id' => "1",
                'description' => null
            ],
            [
                'id' => Str::uuid(),
                'name' => "Katalog Produk Hukum",
                'link' => "katalog-produk-hukum",
                'created_at' => date('Y-m-d H:i:s'),
                'status' => '1',
                'singkatan' => "katalog",
                'tipedokumen_id' => "2",
                'description' => null
            ],
            [
                'id' => Str::uuid(),
                'name' => "Naskah Akademik",
                'link' => "naskah-akademik",
                'created_at' => date('Y-m-d H:i:s'),
                'status' => '1',
                'singkatan' => "naskah",
                'tipedokumen_id' => "2",
                'description' => "Naskah hasil penelitian atau pengkajian hukum dan hasil penelitian lainnya terhadap suatu masalah tertentu yang dapat dipertanggungjawabkan secara ilmiah mengenai pengaturan masalah tersebut dalam suatu Rancangan Peraturan Perundang Undangan"
            ],
            [
                'id' => Str::uuid(),
                'name' => "Analisis Dan Evaluasi Hukum",
                'link' => "rekomendasi-kajian",
                'created_at' => date('Y-m-d H:i:s'),
                'status' => '1',
                'singkatan' => "rekom",
                'tipedokumen_id' => "2",
                'description' => "Hasil  Analisis dan Evaluasi terhadap Produk Hukum Daerah yang telah berlaku dalam rangka upaya Penataan Produk Hukum Daerah Provinsi Jawa Tengah"
            ],
            [
                'id' => Str::uuid(),
                'name' => "Keputusan Gubernur Jawa Tengah",
                'link' => "kegubernur-jawa-tengah",
                'created_at' => date('Y-m-d H:i:s'),
                'status' => '1',
                'singkatan' => "kepgub",
                'tipedokumen_id' => "1",
                'description' => null
            ],
            [
                'id' => Str::uuid(),
                'name' => "Artikel Bidang Hukum",
                'link' => "artikel-bidang-hukum",
                'created_at' => date('Y-m-d H:i:s'),
                'status' => '1',
                'singkatan' => "artikelhukum",
                'tipedokumen_id' => "2",
                'description' => null
            ],
            [
                'id' => Str::uuid(),
                'name' => "Instruksi Gubernur Jawa Tengah",
                'link' => "instruksi-gubernur-jawa-tengah",
                'created_at' => date('Y-m-d H:i:s'),
                'status' => '1',
                'singkatan' => "ingub",
                'tipedokumen_id' => "2",
                'description' => null
            ],
            [
                'id' => Str::uuid(),
                'name' => "Surat Edaran",
                'link' => "surat-edaran",
                'created_at' => date('Y-m-d H:i:s'),
                'status' => '1',
                'singkatan' => "suratedaran",
                'tipedokumen_id' => "2",
                'description' => null
            ],
            [
                'id' => Str::uuid(),
                'name' => "Raperda",
                'link' => "raperda",
                'created_at' => date('Y-m-d H:i:s'),
                'status' => '1',
                'singkatan' => "raperda",
                'tipedokumen_id' => "2",
                'description' => "Rancangan Peraturan Daerah Provinsi Jawa Tengah"
            ],
            [
                'id' => Str::uuid(),
                'name' => "Peraturan Kepala OPD",
                'link' => "peraturan-kepala-opd",
                'created_at' => date('Y-m-d H:i:s'),
                'status' => '1',
                'singkatan' => "peraturanopd",
                'tipedokumen_id' => "1",
                'description' => null
            ],
            [
                'id' => Str::uuid(),
                'name' => "Keputusan Kepala OPD",
                'link' => "kekepala-opd",
                'created_at' => date('Y-m-d H:i:s'),
                'status' => '1',
                'singkatan' => "keputusanopd",
                'tipedokumen_id' => "1",
                'description' => null
            ],
            [
                'id' => Str::uuid(),
                'name' => "Rencana Aksi Nasional Hak Asasi Manusia",
                'link' => "ranham",
                'created_at' => date('Y-m-d H:i:s'),
                'status' => '1',
                'singkatan' => "ranham",
                'tipedokumen_id' => "2",
                'description' => "Dokumen yang memuat sasaran strategis yang digunakan sebagai acuan kementerian"
            ],
            [
                'id' => Str::uuid(),
                'name' => "Surat Edaran Gubernur / Wakil Gubernur",
                'link' => "surat-edaran-gubernur",
                'created_at' => date('Y-m-d H:i:s'),
                'status' => '1',
                'singkatan' => "suratedarangubernur",
                'tipedokumen_id' => "2",
                'description' => null
            ],
            [
                'id' => Str::uuid(),
                'name' => "Surat Edaran Sekretaris Daerah",
                'link' => "surat-edaran-sekretaris",
                'created_at' => date('Y-m-d H:i:s'),
                'status' => '1',
                'singkatan' => "suratedaransekretaris",
                'tipedokumen_id' => "2",
                'description' => null
            ],
            [
                'id' => Str::uuid(),
                'name' => "Surat Edaran Kepala OPD",
                'link' => "surat-edaran-kepala-opd",
                'created_at' => date('Y-m-d H:i:s'),
                'status' => '1',
                'singkatan' => "suratedarankepalaopd",
                'tipedokumen_id' => "2",
                'description' => null
            ],
            [
                'id' => Str::uuid(),
                'name' => "Dokumen Hukum Langka",
                'link' => "dokumen-hukum-langka",
                'created_at' => date('Y-m-d H:i:s'),
                'status' => '1',
                'singkatan' => "dokumenhukumlangka",
                'tipedokumen_id' => "2",
                'description' => null
            ],
            [
                'id' => Str::uuid(),
                'name' => "Keputusan Sekretaris Daerah Provinsi Jawa Tengah",
                'link' => "kesekretaris-daerah-provinsi-jawa-tengah",
                'created_at' => date('Y-m-d H:i:s'),
                'status' => '1',
                'singkatan' => "kepsekda",
                'tipedokumen_id' => "2",
                'description' => null
            ],
            [
                'id' => Str::uuid(),
                'name' => "Propemperda ",
                'link' => "propemperda",
                'created_at' => date('Y-m-d H:i:s'),
                'status' => '1',
                'singkatan' => "propemperda ",
                'tipedokumen_id' => "2",
                'description' => null
            ],
            [
                'id' => Str::uuid(),
                'name' => "Keputusan Dewan Perwakilan Rakyat Daerah",
                'link' => "kedewan-perwakilan-rakyat-daerah",
                'created_at' => date('Y-m-d H:i:s'),
                'status' => '1',
                'singkatan' => "kepdprd",
                'tipedokumen_id' => null,
                'description' => null
            ],
            [
                'id' => Str::uuid(),
                'name' => "Memorandum of Understanding",
                'link' => "memorandum-of-understanding",
                'created_at' => date('Y-m-d H:i:s'),
                'status' => '1',
                'singkatan' => "MoU",
                'tipedokumen_id' => null,
                'description' => null
            ],
            [
                'id' => Str::uuid(),
                'name' => "Perjanjian Kerja Sama",
                'link' => "perjanjian-kerja-sama",
                'created_at' => date('Y-m-d H:i:s'),
                'status' => '1',
                'singkatan' => "PKS",
                'tipedokumen_id' => null,
                'description' => null
            ],
            [
                'id' => Str::uuid(),
                'name' => "Putusan",
                'link' => "putusan",
                'created_at' => date('Y-m-d H:i:s'),
                'status' => '1',
                'singkatan' => "putusan",
                'tipedokumen_id' => null,
                'description' => null
            ],
            [
                'id' => Str::uuid(),
                'name' => "Nota Kesepakatan",
                'link' => "nota-kesepakatan",
                'created_at' => date('Y-m-d H:i:s'),
                'status' => '1',
                'singkatan' => "NK",
                'tipedokumen_id' => null,
                'description' => null
            ],
            [
                'id' => Str::uuid(),
                'name' => "Kesepakatan Bersama",
                'link' => "kesepakatan-bersama",
                'created_at' => date('Y-m-d H:i:s'),
                'status' => '1',
                'singkatan' => "kesber",
                'tipedokumen_id' => null,
                'description' => null
            ],
            [
                'id' => Str::uuid(),
                'name' => "Letter of Intent",
                'link' => "letter-of-intent",
                'created_at' => date('Y-m-d H:i:s'),
                'status' => '1',
                'singkatan' => "LoI",
                'tipedokumen_id' => null,
                'description' => null
            ],
            [
                'id' => Str::uuid(),
                'name' => "Hasil Fasilitasi Raperda Kabupaten/Kota",
                'link' => "hasil-fasilitasi-raperda-kabko",
                'created_at' => date('Y-m-d H:i:s'),
                'status' => '1',
                'singkatan' => "FasKabKota",
                'tipedokumen_id' => null,
                'description' => null
            ],
            [
                'id' => Str::uuid(),
                'name' => "Hasil Fasilitasi Raperda Provinsi",
                'link' => "hasil-fasilitasi-raperda-provinsi",
                'created_at' => date('Y-m-d H:i:s'),
                'status' => '1',
                'singkatan' => "FasProvinsi",
                'tipedokumen_id' => null,
                'description' => null
            ],
            [
                'id' => Str::uuid(),
                'name' => "Buku Hukum",
                'link' => "buku-hukum",
                'created_at' => date('Y-m-d H:i:s'),
                'status' => '1',
                'singkatan' => "bukuhukum",
                'tipedokumen_id' => null,
                'description' => "Buku Hukum"
            ],
            [
                'id' => Str::uuid(),
                'name' => "Rapergub",
                'link' => "rapergub",
                'created_at' => date('Y-m-d H:i:s'),
                'status' => '1',
                'singkatan' => "rapergub",
                'tipedokumen_id' => null,
                'description' => "Rancangan Peraturan Gubernur Provinsi Jawa Tengah"
            ],
            [
                'id' => Str::uuid(),
                'name' => "Hasil Harmonisasi",
                'link' => "hasil-harmonisasi",
                'created_at' => date('Y-m-d H:i:s'),
                'status' => '1',
                'singkatan' => "hasilharmonisasi",
                'tipedokumen_id' => null,
                'description' => null
            ],
            [
                'id' => Str::uuid(),
                'name' => "Propempergub",
                'link' => "propempergub",
                'created_at' => date('Y-m-d H:i:s'),
                'status' => '1',
                'singkatan' => "Propempergub",
                'tipedokumen_id' => null,
                'description' => null
            ],
            [
                'id' => Str::uuid(),
                'name' => "Dokumen Hukum Terjemahan",
                'link' => "dokumen-hukum-terjemahan",
                'created_at' => date('Y-m-d H:i:s'),
                'status' => '1',
                'singkatan' => "Dokumen Hukum Terjemahan",
                'tipedokumen_id' => null,
                'description' => null
            ],
            [
                'id' => Str::uuid(),
                'name' => "PN",
                'link' => "pn",
                'created_at' => date('Y-m-d H:i:s'),
                'status' => '1',
                'singkatan' => "PN",
                'tipedokumen_id' => "4",
                'description' => null
            ],
            [
                'id' => Str::uuid(),
                'name' => "PT",
                'link' => "pt",
                'created_at' => date('Y-m-d H:i:s'),
                'status' => '1',
                'singkatan' => "PT",
                'tipedokumen_id' => "4",
                'description' => null
            ],
            [
                'id' => Str::uuid(),
                'name' => "PTUN",
                'link' => "ptun",
                'created_at' => date('Y-m-d H:i:s'),
                'status' => '1',
                'singkatan' => "PTUN",
                'tipedokumen_id' => "4",
                'description' => null
            ],
            [
                'id' => Str::uuid(),
                'name' => "PT TUN",
                'link' => "pt-tun",
                'created_at' => date('Y-m-d H:i:s'),
                'status' => '1',
                'singkatan' => "PT TUN",
                'tipedokumen_id' => "4",
                'description' => null
            ],
            [
                'id' => Str::uuid(),
                'name' => "MA",
                'link' => "ma",
                'created_at' => date('Y-m-d H:i:s'),
                'status' => '1',
                'singkatan' => "MA",
                'tipedokumen_id' => "4",
                'description' => null
            ],
            [
                'id' => Str::uuid(),
                'name' => "KIP",
                'link' => "kip",
                'created_at' => date('Y-m-d H:i:s'),
                'status' => '1',
                'singkatan' => "KIP",
                'tipedokumen_id' => "4",
                'description' => null
            ]
        ];
        foreach ($dokumenJenis as $key => &$value) {
            $value['tipedokumen_id'] = DB::table('ms_dokumen_tipe')
                ->where('order', $value['tipedokumen_id'])
                ->value('id') ?? null;
        }

        DB::table('ms_dokumen_jenis')->insert($dokumenJenis);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_dokumen_jenis');
    }
};
