<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanKBM; 
use App\Models\JadwalPiket;
use App\Models\User;
use App\Models\AbsensiSiswa;
use Illuminate\Support\Facades\Auth;
use App\Models\Kelas; //bagian kelas

class GuruMapelController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        
        // Statistik
        $totalLaporan = LaporanKBM::where('user_id', $user->id)->count();
        $laporanBulanIni = LaporanKBM::where('user_id', $user->id)
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->count();
        
        $laporanDikonfirmasi = LaporanKBM::where('user_id', $user->id)
            ->where('status', 'dikonfirmasi')
            ->count();
        
        // Cek apakah guru piket hari ini
        $isPiketHariIni = JadwalPiket::where('tanggal', today())
            ->where('user_id', $user->id)
            ->exists();
        
        // Laporan terbaru
        $laporanTerbaru = LaporanKBM::where('user_id', $user->id)
            ->orderBy('tanggal', 'desc')
            ->limit(5)
            ->get();
        
        // Cek laporan belum dikonfirmasi hari ini
        $laporanBelum = LaporanKBM::where('user_id', $user->id)
            ->where('tanggal', today())
            ->where('status', 'belum_dikonfirmasi')
            ->first();

        return view('gurumapel.home_gurumapel', compact(
            'totalLaporan',
            'laporanBulanIni',
            'laporanDikonfirmasi',
            'isPiketHariIni',
            'laporanTerbaru',
            'laporanBelum'
        ));
        // Ambil 5 laporan terbaru dengan pagination
        // $laporan = LaporanKBM::where('user_id', auth()->id())
        //     ->orderBy('tanggal', 'desc')
        //     ->paginate(5); // ← paginate, bukan get()

        // return view('gurumapel.home_gurumapel', compact('laporan'));
    }

    public function laporan()
    {
        $user = auth()->user();
        $kelasList = Kelas::all();
        
        \Log::info('🏠 GuruMapelController@laporan dipanggil', [
            'user_id' => $user->id,
            'user_name' => $user->name,
        ]);

        return view('gurumapel.laporan_kbm_dan_absensi', compact('kelasList'));
    }

    public function isiLaporan()
    {
        // Ambil semua kelas
        $kelasList = Kelas::all();

        \Log::info('📥 GuruMapelController@isiLaporan dipanggil', [
            'kelas_count' => $kelasList->count()
        ]);

        return view('gurumapel.isi_laporan', compact('kelasList'));
    }

    public function riwayat()
    {
        $user = Auth::user();

        \Log::info('📖 GuruMapelController@riwayat dipanggil', [
            'user_id' => $user->id,
            'user_name' => $user->name,
        ]);

        // Ambil laporan dengan absensi siswa
        $laporan = LaporanKBM::where('user_id', $user->id)
            ->with(['absensiSiswa.siswa', 'kelas']) // Eager load relasi
            ->orderBy('tanggal', 'desc')
            ->paginate(6);

        \Log::info('📊 Data riwayat', [
            'jumlah_laporan' => $laporan->count(),
            'laporan_ids' => $laporan->pluck('id')->toArray(),
        ]);

        // Gunakan view yang benar (dengan card laporan)
        return view('gurumapel.riwayat', compact('laporan'));
    }
}
