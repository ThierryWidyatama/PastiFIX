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
        Schema::table('ms_area_kabkota', function (Blueprint $table) {
            $client = new \GuzzleHttp\Client();
            $url = "https://api-v2.smt.web.id/kota_dagri";
            $response = $client->get($url);
            $json = json_decode($response->getBody()->getContents(), true);
            $data = $json['content'];

            $modifiedData = array_map(function ($item) {
            return [
                'id' => $item['id'],
                'provinsi_id' => $item['province_id'], // Mapping province_id to provinsi_id
                'name' => $item['name'],
            ];
            }, $data);

            DB::table('ms_area_kabkota')->insert($modifiedData);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ms_area_kabkota', function (Blueprint $table) {
            DB::table('ms_area_kabkota')->truncate();
        });
    }
};
