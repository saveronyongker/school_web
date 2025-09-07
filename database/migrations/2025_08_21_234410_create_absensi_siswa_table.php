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
        Schema::create('absensi_siswa', function (Blueprint $table) {
            // $table->id();
            // $table->foreignId('laporan_kbm_id')->constrained('laporan_kbm')->onDelete('set null');
            // $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            // $table->enum('status', ['hadir', 'izin', 'sakit', 'alfa']);
            // $table->text('keterangan')->nullable();
            // $table->timestamps();
            // $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

           $table->id();
            
            // ✅ Gunakan unsignedBigInteger untuk cocok dengan laporan_kbm.id
            $table->unsignedBigInteger('laporan_kbm_id')->nullable();
            $table->foreign('laporan_kbm_id')
                ->references('id')
                ->on('laporan_kbm')
                ->onDelete('set null');
            
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->date('tanggal');
            $table->enum('status', ['hadir', 'izin', 'sakit', 'alfa']);
            $table->text('keterangan')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            // Pastikan tidak ada duplikat absensi untuk 1 siswa dalam 1 laporan
            // $table->unique(['laporan_kbm_id', 'siswa_id']);
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi_siswa');
    }
};
