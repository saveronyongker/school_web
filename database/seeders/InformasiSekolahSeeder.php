<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class InformasiSekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data lama (opsional)
        // DB::table('informasi_sekolah')->truncate();

        $faker = \Faker\Factory::create('id_ID');

        // Gambar dummy (simpan di public/images/ atau sesuaikan)
        $gambarDummy = [
            'images/informasi/kegiatan-1.jpg',
            'images/informasi/kegiatan-2.jpg',
            'images/informasi/kegiatan-3.jpg',
            'images/informasi/kegiatan-4.jpg',
            'images/informasi/kegiatan-5.jpg',
        ];

        for ($i = 1; $i <= 20; $i++) {
            DB::table('informasi_sekolahs')->insert([
                'judul' => $this->generateJudul($i),
                'isi' => $this->generateIsi($i),
                'gambar' => $faker->randomElement($gambarDummy),
                'created_at' => now()->subDays(rand(0, 365))->subHours(rand(0, 24)),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('✅ 20 data dummy untuk informasi_sekolah berhasil diisi.');
    }

    private function generateJudul($nomor)
    {
        $judul = [
            "Pentas Seni Meriahkan Hari Guru",
            "Siswa SMK Juara Lomba Robotik Nasional",
            "Pelatihan Guru Berbasis Digital",
            "Studi Tour ke Industri Teknologi",
            "Peringatan Hari Pendidikan Nasional",
            "Donor Darah oleh PMR Sekolah",
            "Kegiatan Bakti Sosial di Desa Mekar Jaya",
            "Penghargaan Siswa Berprestasi 2024",
            "Workshop Kewirausahaan untuk Siswa",
            "Sosialisasi Anti-Bullying di Lingkungan Sekolah",
            "Ujian Praktik Kejuruan Dimulai",
            "Pembekalan PKL Siswa Kelas XII",
            "Pentas Musik Akustik oleh Siswa",
            "Kegiatan Literasi Setiap Pagi",
            "Pameran Karya Siswa Jurusan RPL",
            "Upacara Bendera HUT RI ke-78",
            "Penandatanganan MOU dengan Perusahaan IT",
            "Pelatihan Soft Skill untuk Siswa",
            "Kegiatan Pramuka Penggalang",
            "Sosialisasi Kesehatan Mental",
        ];

        return $judul[$nomor - 1] ?? "Informasi Sekolah #" . $nomor;
    }

    private function generateIsi($nomor)
    {
        $isi = [
            "Pentas seni diikuti oleh ratusan siswa dari berbagai kelas. Acara berlangsung meriah dan penuh semangat.",
            "Tim robotik SMK berhasil meraih juara 1 dalam lomba tingkat nasional di Jakarta. Selamat!",
            "Pelatihan diikuti oleh 50 guru untuk meningkatkan kompetensi di bidang pembelajaran digital.",
            "Siswa berkunjung ke perusahaan teknologi untuk melihat langsung dunia kerja di bidang IT.",
            "Peringatan Hari Pendidikan Nasional dilakukan dengan upacara dan pentas seni.",
            "Kegiatan donor darah berhasil mengumpulkan 100 kantong darah untuk PMI setempat.",
            "Bakti sosial berupa pembagian sembako dan renovasi rumah warga kurang mampu.",
            "Siswa berprestasi menerima penghargaan dari kepala sekolah dan pemerintah daerah.",
            "Workshop kewirausahaan mengajarkan siswa cara memulai usaha kecil-kecilan.",
            "Sosialisasi membahas pentingnya lingkungan sekolah yang aman dari perundungan.",
            "Ujian praktik dilakukan selama satu minggu untuk siswa jurusan teknik dan bisnis.",
            "Siswa diberi pembekalan tentang etika kerja dan kesiapan di dunia kerja sebelum PKL.",
            "Pentas musik diadakan di halaman sekolah dengan penonton seluruh warga sekolah.",
            "Setiap pagi sebelum pelajaran dimulai, siswa membaca buku selama 15 menit.",
            "Pameran menampilkan aplikasi, desain, dan produk inovatif dari siswa RPL.",
            "Upacara diikuti dengan khidmat oleh seluruh warga sekolah di lapangan.",
            "MOU membuka peluang magang dan penyerapan tenaga kerja bagi lulusan.",
            "Pelatihan mencakup komunikasi, kerja tim, dan manajemen waktu.",
            "Kegiatan pramuka diikuti oleh siswa kelas X dan XI secara rutin setiap Sabtu.",
            "Psikolog sekolah memberikan edukasi tentang kesehatan mental dan stres.",
        ];

        return $isi[$nomor - 1] ?? "Isi informasi sekolah ke-" . $nomor . ". " . Str::random(100);
    }
}