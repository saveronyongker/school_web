<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $fillable = [
        'nama_kelas',
        'jumlah_siswa',
        'tahun_ajaran',
        'wali_kelas_id',
    ];

    // Relasi dengan Siswa
    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }

    // Relasi dengan LaporanKBM
    public function laporanKbm()
    {
        return $this->hasMany(LaporanKBM::class);
    }

    // Relasi dengan Wali Kelas (User)
    public function waliKelas()
    {
        return $this->belongsTo(User::class, 'wali_kelas_id');
    }
}
