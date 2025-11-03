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
        $created_now = [
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $modules = [
            [
                'id' => Str::uuid(),
                'parent_id' => null,
                'code' => 'HOME',
                'name' => 'Dashboard',
                'link' => 'dashboard',
                'description' => '',
                'icon' => generate_duotone_icon('ki-home fs-2', 0),
                'action' => 'list,show,create,read,update,delete',
                'order' => 1,
                ...$created_now
            ],
            [
                'id' => Str::uuid(),
                'parent_id' => null,
                'code' => 'MSD',
                'name' => 'Master Data',
                'link' => 'master-data',
                'description' => '',
                'icon' => generate_duotone_icon('ki-element-1 fs-2', 4),
                'action' => 'list,show,create,read,update,delete',
                'order' => 4,
                ...$created_now
            ],
            [
                'id' => Str::uuid(),
                'parent_id' => null,
                'code' => 'USM',
                'name' => 'User Management',
                'link' => 'user-management',
                'description' => 'User Management',
                'icon' => generate_duotone_icon('ki-people fs-2', 5),
                'action' => 'list,roles,show,create,read,update,delete',
                'order' => 5,
                ...$created_now
            ],
            [
                'id' => Str::uuid(),
                'parent_id' => null,
                'code' => 'MOD',
                'name' => 'Data Module',
                'link' => 'modules',
                'description' => 'Data modules sistem',
                'icon' => generate_duotone_icon('ki-text-circle fs-2', 6),
                'action' => 'list,roles,show,create,read,update,delete',
                'order' => 6,
                ...$created_now
            ],
            [
                'id' => Str::uuid(),
                'parent_id' => null,
                'code' => 'LOG',
                'name' => 'Log History',
                'link' => 'logs',
                'description' => 'Log History aktivitas sistem',
                'icon' => generate_duotone_icon('ki-time fs-2', 2),
                'action' => 'list,roles,show,create,read,update,delete',
                'order' => 7,
                ...$created_now
            ],
        ];

        // Insert modules into the database
        DB::table('ms_module')->insert($modules);
        $user_management_module = DB::table('ms_module')->where('code', 'USM')->first();
        $usm_sub_modules = [
            [
                'id' => Str::uuid(),
                'parent_id' => $user_management_module->id,
                'code' => 'MDP',
                'name' => 'Hak Akses',
                'link' => 'module-permission',
                'description' => 'Module Permission',
                'icon' => generate_duotone_icon('ki-duotone ki-lock-3 fs-2', 3),
                'action' => 'list,roles,show,create,read,update,delete',
                'order' => 1,
                ...$created_now
            ],
            [
                'id' => Str::uuid(),
                'parent_id' => $user_management_module->id,
                'code' => 'USR',
                'name' => 'Data Pengguna',
                'link' => 'user',
                'description' => '',
                'icon' => generate_duotone_icon('ki-user fs-2', 2),
                'action' => 'list,show,create,read,update,delete',
                'order' => 1,
                ...$created_now
            ],
        ];
        $order = 0;
        foreach ($usm_sub_modules as &$sub_module) {
            $sub_module['order'] = $order++;
        }
        DB::table('ms_module')->insert($usm_sub_modules);

        $master_data_module = DB::table('ms_module')->where('code', 'MSD')->first();
        $msd_sub_modules = [
            [
                'id' => Str::uuid(),
                'parent_id' => $master_data_module->id,
                'code' => 'STW',
                'name' => 'Setting Informasi Website',
                'link' => 'option',
                'description' => '',
                'icon' => generate_duotone_icon('ki-gear fs-2', 2),
                'action' => 'list,show,create,read,update,delete',
                ...$created_now
            ],
        ];
        $order = 0;
        foreach ($msd_sub_modules as &$sub_module) {
            $sub_module['order'] = $order++;
        }
        DB::table('ms_module')->insert($msd_sub_modules);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
