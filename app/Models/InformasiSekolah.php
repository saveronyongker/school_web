<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformasiSekolah extends Model
{
    use HasFactory;

    // Jika nama tabel tidak otomatis cocok
    protected $table = 'informasi_sekolahs'; // atau 'informasis' jika migrasimu begitu

    // Kolom yang bisa diisi
    protected $fillable = ['judul', 'isi', 'gambar'];
}
