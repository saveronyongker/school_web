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
            $table->string('file_materi')->nullable(); // path file
            $table->string('nama_file')->nullable();   // nama asli file
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan_kbm', function (Blueprint $table) {
            //
        });
    }
};
