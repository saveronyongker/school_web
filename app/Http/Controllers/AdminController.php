<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LaporanKBM;
use App\Models\JadwalPiket;
use App\Models\InformasiSekolah;

class AdminController extends Controller
{
     public function index()
    {
        
        return view('admin.layout.dashboard');
    }
    public function dashboard()
    {
        // Statistik hari ini
        $totalGuru = User::where('role', 'guru_mapel')->count();
        $laporanHariIni = LaporanKBM::whereDate('created_at', today())->count();
        $guruPiketHariIni = JadwalPiket::where('tanggal', today())
            ->with('guru')
            ->get();
        
        // Laporan terbaru
        $laporanTerbaru = LaporanKBM::with('guru')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Informasi terbaru
        $informasiTerbaru = InformasiSekolah::orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return view('admin.page.dashboard', compact(
            'totalGuru',
            'laporanHariIni',
            'guruPiketHariIni',
            'laporanTerbaru',
            'informasiTerbaru'
        ));
        // return view('admin.page.dashboard');
    }

    public function dataPengguna()
    {
        return view('admin.page.data_pengguna');
    }

    public function informasiSekolah()
    {
        return view('admin.page.informasi_sekolah');
    }

    public function profilSekolah()
    {
        return view('admin.page.profil_sekolah');
    }

    public function getAllUsers()
    {
        $users = User::select('id', 'name', 'email', 'role')->get();

        return response()->json([
            'success' => true,
            'users' => $users
        ]);
    }
}
