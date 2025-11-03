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
        Schema::table('ms_area_provinsi', function (Blueprint $table) {
            $url = "https://api-v2.smt.web.id/provinsi_dagri";
            $client = new \GuzzleHttp\Client();
            $response = $client->get($url);
            $json = json_decode($response->getBody()->getContents(), true);
            $data = $json['content'];
            //add one data to the array
            $data[] = [
                'id' => '-',
                'name' => 'PAPUA BARAT DAYA',
            ];
            DB::table('ms_area_provinsi')->insert($data);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
