<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Module;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $modules = Module::get();
        foreach ($modules as $module) {
            DB::table('ms_module_permission')->insert([
                [
                    'id' => Str::uuid(),
                    'role_id' => DB::table('ms_role')->where('code', 'ADM')->first()->id,
                    'module_id' => $module->id,
                    'action' => 'list,roles,show,create,read,update,delete',
                    'publish' => 1
                ],
                [
                    'id' => Str::uuid(),
                    'role_id' => DB::table('ms_role')->where('code', 'SUPADM')->first()->id,
                    'module_id' => $module->id,
                    'action' => 'list,roles,show,create,read,update,delete',
                    'publish' => 1
                ]
            ]);
        }
        $id_module = Module::where('code', 'HOME')->first()->id;
        $insert_data = create_permission('USR', $id_module, 'list,roles,show,create,read,update,delete');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
