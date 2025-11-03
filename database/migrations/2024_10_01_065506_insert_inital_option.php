<?php

use App\Models\Option;
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
        Schema::table('ms_option', function (Blueprint $table) {
            Option::create([
                'id' => Str::uuid(),
                'name' => 'Company Name',
                'description' => 'Company Description',
                'address' => 'St. Company, City',
                'phone' => '000-0000-0000',
                'fax' => '000-0000-0000',
                'email' => 'email@company',
                'logo' => 'default-dark.svg',
                'favicon' => 'default-favicon.ico',
                'announcement' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
                'starthour' => '08:00:00',
                'endhour' => '18:00:00',
                'latitude' => '-6.175110',
                'longitude' => '106.865036',
                'created_at' => now(),
            ]);
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
