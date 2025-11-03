<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $created_now = [
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $master_data_module = DB::table('ms_module')->where('code', 'MSD')->first();
        $id_module = Str::uuid();
        DB::table('ms_module')->insert([
            'id' => $id_module,
            'parent_id' => $master_data_module->id,
            'code' => 'SLDP',
            'name' => 'Setting Landing Page',
            'link' => 'setting-landing-page',
            'description' => '',
            'icon' => generate_duotone_icon('ki-duotone ki-abstract-16 fs-2', 2),
            'action' => 'list,show,create,read,update,delete',
            ...$created_now
        ]);

        create_permission('SUPADM', $id_module, 'list,roles,show,create,read,update,delete');
        create_permission('ADM', $id_module, 'list,roles,show,create,read,update,delete');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('ms_module')->where('code', 'SLDP')->delete();
    }
};
