<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
     protected $table = 'siswa'; //nama tabel siswa

    protected $fillable = [
        'nama',
        'nis',
        'nisn',
        'kelas_id',
        'tanggal_lahir',
        'jenis_kelamin',
        'status_aktif',
    ];

    // Relasi dengan Kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    // Relasi dengan AbsensiSiswa
    public function absensi()
    {
        return $this->hasMany(AbsensiSiswa::class);
    }

    // Scope untuk siswa aktif
    public function scopeAktif($query)
    {
        return $query->where('status_aktif', true);
    }
}
