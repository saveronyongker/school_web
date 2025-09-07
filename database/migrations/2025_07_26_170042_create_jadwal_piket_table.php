<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('jadwal_piket', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');           // tanggal piket
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // guru
            $table->integer('shift')->default(1); // opsional: shift 1,2,3
            $table->timestamps();

            // Pastikan tidak ada duplikat guru di hari yang sama
            $table->unique(['tanggal', 'user_id']);
        });

        // Index untuk pencarian cepat
        Schema::table('jadwal_piket', function (Blueprint $table) {
            $table->index('tanggal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_piket');
    }
};
