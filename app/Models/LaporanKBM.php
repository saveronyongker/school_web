<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanKBM extends Model
 { 
    
    protected $table = 'laporan_kbm';

    protected $fillable = [   
        'user_id',
        'kelas_id',
        'tanggal',
        'kelas',
        'mata_pelajaran',
        'topik',
        'kegiatan',
        'jam_mulai',
        'jam_selesai',
        'status',
        'catatan_piket',
        'dikonfirmasi_oleh',
        'file_materi',
        'nama_file',
    ];

    protected $dates = ['tanggal']; // ✅ Ini akan otomatis cast ke Carbon

    // ✅ Atau gunakan casts explicit
    protected $casts = [
        'tanggal' => 'date', // atau 'datetime'
        'jam_mulai' => 'integer',
        'jam_selesai' => 'integer',
    ];

    // Relasi ke guru
    public function guru()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // TAMBAHKAN INI: Relasi dengan Kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id'); // ✅ Gunakan kelas_id
    }

    // Relasi ke guru piket (yang konfirmasi)
    public function guruPiket()
    {
        return $this->belongsTo(User::class, 'dikonfirmasi_oleh');
    }

    // Accessor untuk URL download
    public function getFileMateriUrlAttribute()
    {
        return $this->file_materi ? asset('storage/' . $this->file_materi) : null;
    }

    // Tambahkan relasi absensi
    public function absensiSiswa()
    {
        return $this->hasMany(AbsensiSiswa::class, 'laporan_kbm_id');
    }

    // Scope untuk status
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope untuk tanggal
    public function scopeTanggal($query, $tanggal)
    {
        return $query->where('tanggal', $tanggal);
    }

}
