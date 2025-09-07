<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProfilSekolah;

class ProfilSekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek apakah sudah ada data
        if (ProfilSekolah::count() === 0) {
            ProfilSekolah::create([
                'nama' => 'SMK Negeri 1 Contoh',
                'deskripsi' => 'Sekolah Menengah Kejuruan Negeri',
                'alamat' => 'Jl. Pendidikan No. 123',
                'telepon' => '(021) 123456',
                'email' => 'info@smkn1contoh.sch.id',
                'visi' => 'Menjadi sekolah unggulan',
                'misi' => 'Mendidik generasi berkualitas',
                'tujuan' => 'Mewujudkan lulusan yang beriman, berilmu, dan berbudi luhur',
                'logo' => null,
            ]);
        }
    }
}
