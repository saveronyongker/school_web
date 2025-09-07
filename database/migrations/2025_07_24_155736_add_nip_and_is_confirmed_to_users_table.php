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
        Schema::table('users', function (Blueprint $table) {
            // ✅ Cek dulu apakah kolom sudah ada
            if (!Schema::hasColumn('users', 'nip')) {
                $table->string('nip')->unique();
            }
            
            if (!Schema::hasColumn('users', 'is_confirmed')) {
                $table->boolean('is_confirmed')->default(false);
            }
            
            if (!Schema::hasColumn('users', 'mata_pelajaran')) {
                $table->string('mata_pelajaran')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // ✅ Cek dulu apakah kolom ada
            if (Schema::hasColumn('users', 'nip')) {
                $table->dropColumn('nip');
            }
            
            if (Schema::hasColumn('users', 'is_confirmed')) {
                $table->dropColumn('is_confirmed');
            }
            
            if (Schema::hasColumn('users', 'mata_pelajaran')) {
                $table->dropColumn('mata_pelajaran');
            }
        });
    }
};
