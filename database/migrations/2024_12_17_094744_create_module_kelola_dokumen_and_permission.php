<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

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

        $parent_module = [
            'id' => Str::uuid(),
            'parent_id' => null,
            'code' => 'KELOLADOK',
            'name' => 'Kelola Dokumen',
            'link' => 'kelola-dokumen',
            'description' => '',
            'icon' => generate_duotone_icon('ki-duotone ki-some-files fs-2', 2),
            'action' => 'list,show,create,read,update,delete',
            'order' => 2,
            ...$created_now
        ];

        DB::table('ms_module')->insert($parent_module);

        // Insert Permission
        $modul_kelola_dokumen = DB::table('ms_module')->where('code', 'KELOLADOK')->first();
        create_permission('SUPADM', $modul_kelola_dokumen->id, 'list,show,create,read,update,delete');
        create_permission('ADM', $modul_kelola_dokumen->id, 'list,show,create,read,update,delete');

        $kelola_dokumen_sub_module = [
            [
                'id' => Str::uuid(),
                'parent_id' => $modul_kelola_dokumen->id,
                'code' => 'PH',
                'name' => 'Produk Hukum',
                'link' => 'master-produk-hukum',
                'description' => 'Produk Hukum',
                'icon' => generate_duotone_icon('ki-duotone ki-document fs-2', 2),
                'action' => 'list,show,create,read,update,delete',
                'order' => 1,
                ...$created_now
            ],
            [
                'id' => Str::uuid(),
                'parent_id' => $modul_kelola_dokumen->id,
                'code' => 'TIPEDOK',
                'name' => 'Tipe Dokumen',
                'link' => 'master-tipe-dokumen',
                'description' => 'Tipe Dokumen',
                'icon' => generate_duotone_icon('ki-duotone ki-element-plus fs-2', 5),
                'action' => 'list,show,create,read,update,delete',
                'order' => 1,
                ...$created_now
            ],
            [
                'id' => Str::uuid(),
                'parent_id' => $modul_kelola_dokumen->id,
                'code' => 'JENISDOK',
                'name' => 'Jenis Dokumen',
                'link' => 'master-jenis-dokumen',
                'description' => 'Jenis Dokumen',
                'icon' => generate_duotone_icon('ki-duotone ki-element-plus fs-2', 5),
                'action' => 'list,show,create,read,update,delete',
                'order' => 1,
                ...$created_now
            ],
            [
                'id' => Str::uuid(),
                'parent_id' => $modul_kelola_dokumen->id,
                'code' => 'BIDHUK',
                'name' => 'Bidang Hukum',
                'link' => 'master-bidang-hukum',
                'description' => 'Bidang Hukum',
                'icon' => generate_duotone_icon('ki-duotone ki-element-plus fs-2', 5),
                'action' => 'list,show,create,read,update,delete',
                'order' => 1,
                ...$created_now
            ],
            [
                'id' => Str::uuid(),
                'parent_id' => $modul_kelola_dokumen->id,
                'code' => 'BAHASA',
                'name' => 'Bahasa',
                'link' => 'master-bahasa',
                'description' => 'Bahasa',
                'icon' => generate_duotone_icon('ki-duotone ki-message-text-2 fs-2', 3),
                'action' => 'list,show,create,read,update,delete',
                'order' => 1,
                ...$created_now
            ],
        ];
        $order = 0;
        foreach ($kelola_dokumen_sub_module as &$sub_module) {
            $sub_module['order'] = $order++;
        }
        DB::table('ms_module')->insert($kelola_dokumen_sub_module);

        foreach ($kelola_dokumen_sub_module as $sub_modul_kelola_dokumen) {
            create_permission('SUPADM', $sub_modul_kelola_dokumen['id'], 'list,show,create,read,update,delete');
            create_permission('ADM', $sub_modul_kelola_dokumen['id'], 'list,show,create,read,update,delete');
        }

        $opd_module = [
            'id' => Str::uuid(),
            'parent_id' => null,
            'code' => 'OPD',
            'name' => 'OPD',
            'link' => 'master-opd',
            'description' => 'OPD',
            'icon' => generate_duotone_icon('ki-duotone ki-security-user fs-2', 2),
            'action' => 'list,show,create,read,update,delete',
            'order' => 4,
            ...$created_now
        ];

        DB::table('ms_module')->insert($opd_module);
        $modul_opd = DB::table('ms_module')->where('code', 'OPD')->first();
        create_permission('SUPADM', $modul_opd->id, 'list,show,create,read,update,delete');
        create_permission('ADM', $modul_opd->id, 'list,show,create,read,update,delete');

        $berita_module = [
            'id' => Str::uuid(),
            'parent_id' => null,
            'code' => 'BERITA',
            'name' => 'Berita',
            'link' => 'master-berita',
            'description' => 'Berita',
            'icon' => generate_duotone_icon('ki-duotone ki-directbox-default fs-2', 4),
            'action' => 'list,show,create,read,update,delete',
            'order' => 5,
            ...$created_now
        ];

        DB::table('ms_module')->insert($berita_module);
        $modul_berita = DB::table('ms_module')->where('code', 'BERITA')->first();
        create_permission('SUPADM', $modul_berita->id, 'list,show,create,read,update,delete');
        create_permission('ADM', $modul_berita->id, 'list,show,create,read,update,delete');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $modul_kelola_dokumen = DB::table('ms_module')->where('code', 'KELOLADOK')->first();
        if ($modul_kelola_dokumen) {
            DB::table('ms_module_permission')->where('module_id', $modul_kelola_dokumen->id)->delete();
            DB::table('ms_module')->where('id', $modul_kelola_dokumen->id)->delete();
        }

        foreach (['PH', 'TIPEDOK', 'JENISDOK', 'BIDHUK', 'BAHASA'] as $sub_module_code) {
            $sub_module = DB::table('ms_module')->where('code', $sub_module_code)->first();
            if ($sub_module) {
                DB::table('ms_module_permission')->where('module_id', $sub_module->id)->delete();
                DB::table('ms_module')->where('id', $sub_module->id)->delete();
            }
        }

        $modul_opd = DB::table('ms_module')->where('code', 'OPD')->first();
        if ($modul_opd) {
            DB::table('ms_module_permission')->where('module_id', $modul_opd->id)->delete();
            DB::table('ms_module')->where('id', $modul_opd->id)->delete();
        }

        $modul_berita = DB::table('ms_module')->where('code', 'BERITA')->first();
        if ($modul_berita) {
            DB::table('ms_module_permission')->where('module_id', $modul_berita->id)->delete();
            DB::table('ms_module')->where('id', $modul_berita->id)->delete();
        }
    }
};
