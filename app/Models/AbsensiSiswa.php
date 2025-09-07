<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiSiswa extends Model
{
    protected $table = 'absensi_siswa'; // Pastikan nama benar

     protected $fillable = [
        'kelas_id',  
        'laporan_kbm_id',
        'siswa_id',
        'status',
        'tanggal', 
        'keterangan',
        'user_id',
    ];

    // Relasi dengan LaporanKBM
    public function laporanKbm()
    {
        return $this->hasMany(AbsensiSiswa::class, 'laporan_kbm_id');
    }

    // Relasi dengan Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id'); // ✅ Pastikan foreign key benar
    }

    // Relasi dengan kelas
     public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    // Relasi dengan Guru (User)
    public function guru()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Scope berdasarkan status
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
