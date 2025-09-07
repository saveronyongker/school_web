<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('laporan_kbm', function (Blueprint $table) {
           // Cek apakah kolom sudah ada
             if (!Schema::hasColumn('laporan_kbm', 'kelas_id')) {
                // ✅ Tambahkan kolom tanpa foreign key constraint dulu
                $table->unsignedBigInteger('kelas_id')->nullable()->after('user_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan_kbm', function (Blueprint $table) {
            if (Schema::hasColumn('laporan_kbm', 'kelas_id')) {
                $table->dropColumn('kelas_id');
            }
        });
    }
};
