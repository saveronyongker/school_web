<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfilSekolah;
use App\Models\InformasiSekolah as Informasi;

class DashboardController extends Controller
{
        // Homepage
    public function index()
    {
        // Ambil data profil
        $profil = ProfilSekolah::first();
        
        return view('welcome', compact('profil'));
    }

    // Halaman informasi sekolah untuk publik
    public function informasi()
    {
        $informasi_sekolahs = Informasi::latest()->get();
        return view('informasi_sekolah', compact('informasi_sekolahs'));
    }
}
