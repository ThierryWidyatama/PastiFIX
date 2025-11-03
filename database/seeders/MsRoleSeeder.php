<?php

namespace Database\Seeders;

use App\Models\MsRole; // <-- Pastikan ini di-import
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MsRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Jaga 3 role bawaan (sesuai gambar)
        MsRole::updateOrCreate(
            ['code' => 'USR'],      // <-- Sesuai gambar
            ['name' => 'User']       // <-- Sesuai gambar
        );
        
        MsRole::updateOrCreate(
            ['code' => 'ADM'],      // <-- Sesuai gambar
            ['name' => 'Admin']      // <-- Sesuai gambar
        );

        MsRole::updateOrCreate(
            ['code' => 'SUPADM'],   // <-- Sesuai gambar
            ['name' => 'Super Admin']// <-- Sesuai gambar
        );

        // !! INI TAMBAHAN KITA !!
        MsRole::updateOrCreate(
            ['code' => 'MDR'],      // <-- Kita buat kode baru 'MDR'
            ['name' => 'Mandor']     // <-- Role baru kita
        );
    }
}