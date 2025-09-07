<?php

namespace App\Models;

//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'nip',           // login
        'password',
        'role',
        'is_confirmed',
        'mata_pelajaran', // hanya untuk guru mapel
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
        protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    public function getAuthIdentifierName()
    {
        return 'nip'; // Gunakan NIP sebagai identifier
    }

    public function getAuthIdentifier()
    {
        return $this->nip;
    }

    public function isGuruPiketHariIni()
    {
        return \App\Models\JadwalPiket::where('tanggal', today())
            ->where('user_id', $this->id)
            ->exists();
    }

    // Relasi ke laporan KBM
    public function laporanKBM()
    {
        return $this->hasMany(LaporanKBM::class, 'user_id');
    }

    // Relasi dengan Kelas yang diwali (jika user adalah wali kelas)
    public function kelasYangDiwali()
    {
        return $this->hasMany(Kelas::class, 'wali_kelas_id');
    }

    // Scope berdasarkan role
    public function scopeRole($query, $role)
    {
        return $query->where('role', $role);
    }
}