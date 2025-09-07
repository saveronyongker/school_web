<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPiket extends Model
   
{
    protected $table = 'jadwal_piket';

    protected $fillable = [
        'tanggal',
        'user_id',
        'shift',
    ];

    protected $dates = ['tanggal'];

    public function guru()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    // Scope: Ambil jadwal per minggu
    public function scopeMingguIni($query, $tanggalAwal, $tanggalAkhir)
    {
        return $query->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
                     ->with('guru')
                     ->orderBy('tanggal')
                     ->orderBy('shift');
    }
}
