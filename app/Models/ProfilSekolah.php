<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilSekolah extends Model
{
    use HasFactory;

    // Pastikan tabelnya sesuai
    protected $table = 'profil_sekolahs';

    // Field yang bisa diisi
    protected $fillable = [
        'nama', 'deskripsi', 'alamat', 'telepon', 'email', 'logo', 'visi', 'misi', 'tujuan',
    ];
    
}