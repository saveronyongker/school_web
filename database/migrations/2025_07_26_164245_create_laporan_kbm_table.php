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
        Schema::create('laporan_kbm', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // guru mapel
            $table->date('tanggal'); // tanggal mengajar
            $table->string('kelas'); // contoh: X-A, XI-B
            $table->string('mata_pelajaran');
            $table->string('topik');
            $table->text('kegiatan'); // apa yang diajarkan
            $table->integer('jam_mulai'); // 1-8
            $table->integer('jam_selesai');
            $table->enum('status', ['belum_dikonfirmasi', 'dikonfirmasi', 'ditolak'])->default('belum_dikonfirmasi');
            $table->text('catatan_piket')->nullable(); // dari guru piket
            $table->foreignId('dikonfirmasi_oleh')->nullable()->constrained('users'); // guru piket
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_kbm');
    }
};
