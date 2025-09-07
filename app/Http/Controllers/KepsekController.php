<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LaporanKBM;
use App\Models\JadwalPiket;
use App\Models\InformasiSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class KepsekController extends Controller
{
    // Dashboard Kepala Sekolah
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

        return view('kepsek.dashboard', compact(
            'totalGuru',
            'laporanHariIni',
            'guruPiketHariIni',
            'laporanTerbaru',
            'informasiTerbaru'
        ));
    }

    // Laporan KBM Semua Guru
    public function laporanIndex(Request $request)
    {
        $query = LaporanKBM::with('guru');

        // Filter berdasarkan pencarian
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('topik', 'LIKE', "%{$search}%")
                  ->orWhere('mata_pelajaran', 'LIKE', "%{$search}%")
                  ->orWhere('kelas', 'LIKE', "%{$search}%")
                  ->orWhereHas('guru', function($q2) use ($search) {
                      $q2->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Filter berdasarkan tanggal
        if ($request->has('tanggal_dari') && $request->tanggal_dari) {
            $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        }
        if ($request->has('tanggal_sampai') && $request->tanggal_sampai) {
            $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }

        // Filter berdasarkan status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $laporan = $query->orderBy('tanggal', 'desc')
                         ->paginate(15)
                         ->appends($request->except('page'));

        return view('kepsek.laporan.index', compact('laporan'));
    }

    // Detail Laporan
    public function laporanShow($id)
    {
        $laporan = LaporanKBM::with('guru')->findOrFail($id);
        return view('kepsek.laporan.show', compact('laporan'));
    }

    // Daftar Guru
    public function guruIndex(Request $request)
    {
        $query = User::where('role', 'guru_mapel');

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('nip', 'LIKE', "%{$search}%")
                  ->orWhere('mata_pelajaran', 'LIKE', "%{$search}%");
            });
        }

        $guru = $query->orderBy('name')
                      ->paginate(15)
                      ->appends($request->except('page'));

        return view('kepsek.guru.index', compact('guru'));
    }

    // Detail Guru
    public function guruShow($id)
    {
        $guru = User::where('role', 'guru_mapel')->findOrFail($id);
        
        // Riwayat laporan
        $laporan = LaporanKBM::where('user_id', $guru->id)
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('kepsek.guru.show', compact('guru', 'laporan'));
    }

    // Konfirmasi Guru Baru
    public function konfirmasiGuru($id)
    {
        $guru = User::where('role', 'guru_mapel')
            ->where('is_confirmed', 0)
            ->findOrFail($id);

        $guru->update(['is_confirmed' => 1]);

        return redirect()->back()->with('success', 'Guru berhasil dikonfirmasi.');
    }

    // Jadwal Piket
    public function jadwalPiket()
    {
        // Minggu ini
        $startMingguIni = now()->startOfWeek();
        $endMingguIni = $startMingguIni->copy()->endOfWeek();
        
        $jadwalMingguIni = JadwalPiket::mingguIni($startMingguIni, $endMingguIni)
            ->get()
            ->groupBy('tanggal');

        // Minggu depan
        $startMingguDepan = now()->addWeek()->startOfWeek();
        $endMingguDepan = $startMingguDepan->copy()->endOfWeek();
        
        $jadwalMingguDepan = JadwalPiket::mingguIni($startMingguDepan, $endMingguDepan)
            ->get()
            ->groupBy('tanggal');

        return view('kepsek.jadwal_piket.index', compact(
            'jadwalMingguIni',
            'jadwalMingguDepan',
            'startMingguIni',
            'endMingguIni',
            'startMingguDepan',
            'endMingguDepan'
        ));
    }

    // Laporan Statistik
    public function statistik()
    {
        // Rekap bulanan
        $rekapBulanan = LaporanKBM::select(
            DB::raw('MONTH(tanggal) as bulan'),
            DB::raw('YEAR(tanggal) as tahun'),
            DB::raw('COUNT(*) as total_laporan'),
            DB::raw('SUM(CASE WHEN status = "dikonfirmasi" THEN 1 ELSE 0 END) as dikonfirmasi'),
            DB::raw('SUM(CASE WHEN status = "ditolak" THEN 1 ELSE 0 END) as ditolak')
        )
        ->where('tanggal', '>=', now()->subMonths(6))
        ->groupBy(DB::raw('YEAR(tanggal)'), DB::raw('MONTH(tanggal)'))
        ->orderBy('tahun', 'desc')
        ->orderBy('bulan', 'desc')
        ->get();

        // Statistik guru
        $statistikGuru = User::where('role', 'guru_mapel')
            ->withCount('laporanKBM as total_laporan')
            ->orderBy('total_laporan', 'desc')
            ->limit(10)
            ->get();

        return view('kepsek.statistik.index', compact('rekapBulanan', 'statistikGuru'));
    }

    // Informasi Sekolah
    public function informasiIndex()
    {
        $informasi = InformasiSekolah::orderBy('tanggal', 'desc')->paginate(10);
        return view('kepsek.informasi.index', compact('informasi'));
    }

    // Detail Informasi
    public function informasiShow($id)
    {
        $info = InformasiSekolah::findOrFail($id);
        return view('kepsek.informasi.show', compact('info'));
    }
}