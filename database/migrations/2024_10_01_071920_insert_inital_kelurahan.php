<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ms_area_kelurahan', function (Blueprint $table) {
            $client = new \GuzzleHttp\Client();
            $url = "https://api-v2.smt.web.id/kelurahan_dagri";
            $response = $client->get($url);
            $json = json_decode($response->getBody(), true);
            $data = $json['content'];

            $modifiedData = array_map(function ($item) {
            return [
                'id' => $item['id'],
                'kecamatan_id' => $item['district_id'], // Mapping province_id to provinsi_id
                'name' => $item['name'],
            ];
            }, $data);

            $chunks = array_chunk($modifiedData, 1000);

            foreach ($chunks as $chunk) {
            DB::table('ms_area_kelurahan')->insert($chunk);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ms_area_kelurahan', function (Blueprint $table) {
            DB::table('ms_area_kelurahan')->truncate();
        });
    }
};
