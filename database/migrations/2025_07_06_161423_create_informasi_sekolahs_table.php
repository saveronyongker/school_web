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
        Schema::create('informasi_sekolahs', function (Blueprint $table) {
            $table->id();
            $table->string('judul');          // Ganti varchar -> string
            $table->text('isi');              // text() tetap benar
            $table->string('gambar')->nullable(); // string(), bukan varchar()
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi_sekolahs');
    }
};
