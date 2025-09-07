<?php

namespace App\Http\Controllers;

use App\Models\AbsensiSiswa;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AbsenController extends Controller
{
    // public function index(Request $request)
    // {
    //     Log::info('📥 AbsenController@index dipanggil', [
    //         'user_id' => Auth::id(),
    //         'user_name' => Auth::user()?->name,
    //     ]);

    //     $kelasList = Kelas::all();
    //     $siswaList = collect();
    //     $kelasDipilih = null;

    //     if ($request->has('kelas_id') && $request->kelas_id) {
    //         $kelasDipilih = Kelas::with('siswa')->findOrFail($request->kelas_id);
    //         $siswaList = $kelasDipilih->siswa->sortBy('nama');
    //     }

    //     return view('gurumapel.absensi', compact('kelasList', 'siswaList', 'kelasDipilih'));
    // }

    // public function loadSiswa(Request $request)
    // {
    //     $request->validate([
    //         'kelas_id' => 'required|exists:kelas,id',
    //     ]);

    //     $kelasDipilih = Kelas::with('siswa')->findOrFail($request->kelas_id);
    //     $siswaList = $kelasDipilih->siswa->sortBy('nama');
    //     $kelasList = Kelas::all();

    //     return view('gurumapel.absensi', compact('kelasList', 'siswaList', 'kelasDipilih'));
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'kelas_id' => 'required|exists:kelas,id',
    //         'tanggal' => 'required|date',
    //         'absensi' => 'required|array',
    //         'absensi.*' => 'required|in:hadir,izin,sakit,alfa',
    //     ]);

    //     if ($request->has('absensi')) {
    //         foreach ($request->absensi as $siswaId => $status) {
    //             AbsensiSiswa::create([
    //                 'kelas_id' => $request->kelas_id,    // ✅ Harus ada
    //                 'siswa_id' => $siswaId,
    //                 'tanggal' => $request->tanggal,
    //                 'status' => $status,
    //                 'keterangan' => $request->keterangan[$siswaId] ?? null,
    //                 'user_id' => Auth::id(),
    //             ]);
    //         }
    //     }

    //     Log::info('🎉 Absensi berhasil disimpan', [
    //         'jumlah_siswa' => count($request->absensi),
    //         'kelas_id' => $request->kelas_id,
    //         'user_id' => Auth::id(),
    //     ]);

    //     return redirect()->route('absensi.index')->with('success', 'Absensi berhasil disimpan.');
    // }

    // Di AbsenController.php
    public function index(Request $request)
    {
        Log::info('🔍 AbsenController@index dipanggil', [
            'user_id' => Auth::id(),
            'kelas_id' => $request->kelas_id,
        ]);

        $user = Auth::user();
        
        // ✅ Perbaiki: Ambil semua kelas untuk semua guru mapel
        $kelasList = Kelas::all(); // Bukan hanya wali_kelas_id

        $siswaList = collect();
        $kelasDipilih = null;

        if ($request->has('kelas_id') && $request->kelas_id) {
            try {
                $kelasDipilih = Kelas::with('siswa')->findOrFail($request->kelas_id);
                $siswaList = $kelasDipilih->siswa->sortBy('nama');
            } catch (\Exception $e) {
                Log::error('❌ Error load siswa', [
                    'kelas_id' => $request->kelas_id,
                    'error' => $e->getMessage(),
                ]);
                return redirect()->back()->withErrors(['kelas_id' => 'Kelas tidak valid.']);
            }
        }

        return view('gurumapel.absensi', compact('kelasList', 'siswaList', 'kelasDipilih'));
    }

    /**
     * API: Load siswa berdasarkan kelas (untuk AJAX)
     */
    public function getSiswaByKelas($kelasId)
    {
        Log::info('📡 API getSiswaByKelas dipanggil', [
            'kelas_id' => $kelasId,
            'user_id' => Auth::id(),
        ]);

        try {
            $kelas = Kelas::with('siswa:id,nama,nis,kelas_id')->findOrFail($kelasId);

            return response()->json([
                'success' => true,
                'kelas' => $kelas->nama_kelas,
                'siswa' => $kelas->siswa->map(function ($s) {
                    return [
                        'id' => $s->id,
                        'nama' => $s->nama,
                        'nis' => $s->nis,
                    ];
                })
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Error API getSiswaByKelas', [
                'kelas_id' => $kelasId,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data siswa.',
            ], 404);
        }
    }

    /**
     * Simpan absensi siswa
     */
     public function store(Request $request)
    {
        Log::info('💾 AbsenController@store dipanggil', [
            'user_id' => Auth::user()->id,
            'request_data' => $request->except('absensi', 'keterangan'),
        ]);

        // Validasi input
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'tanggal' => 'required|date',
            'absensi' => 'required|array',
            'absensi.*' => 'required|in:hadir,izin,sakit,alfa',
        ], [
            'kelas_id.required' => 'Pilih kelas terlebih dahulu.',
            'kelas_id.exists' => 'Kelas tidak ditemukan.',
            'tanggal.required' => 'Tanggal wajib diisi.',
            'absensi.required' => 'Absensi siswa wajib diisi.',
            'absensi.*.required' => 'Pilih status kehadiran untuk setiap siswa.',
            'absensi.*.in' => 'Status kehadiran tidak valid.',
        ]);

        try {
            // Simpan absensi untuk setiap siswa
            if ($request->has('absensi')) {
                foreach ($request->absensi as $siswaId => $status) {
                    AbsensiSiswa::updateOrCreate(
                        [
                            'kelas_id' => $request->kelas_id,
                            'siswa_id' => $siswaId,
                            'tanggal' => $request->tanggal,
                        ],
                        [
                            'status' => $status,
                            'keterangan' => $request->keterangan[$siswaId] ?? null,
                            'user_id' => Auth::user()->id,
                        ]
                    );
                }
            }

            \Log::info('🎉 Absensi berhasil disimpan', [
                'jumlah_siswa' => count($request->absensi),
                'user_id' => Auth::user()->id,
            ]);

            return redirect()->back()->with('success', 'Absensi berhasil disimpan.');
        } catch (\Exception $e) {
            Log::error('❌ Error simpan absensi', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->withErrors(['error' => 'Gagal menyimpan absensi. Silakan coba lagi.']);
        }
    }

    /**
     * Tampilkan riwayat absensi
     */
    public function riwayat(Request $request)
    {
        Log::info('📖 AbsenController@riwayat dipanggil', [
            'user_id' => Auth::id(),
            'user_name' => Auth::user()?->name,
        ]);

        // Filter berdasarkan tanggal
        $startDate = $request->get('start_date', today()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', today()->endOfMonth()->format('Y-m-d'));

        // Query absensi
        $query = AbsensiSiswa::with(['siswa', 'kelas'])
            ->where('user_id', Auth::user()->id) // Hanya absensi yang diisi oleh guru ini
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('tanggal', 'desc')
            ->orderBy('kelas_id');

        // Filter berdasarkan kelas (opsional)
        if ($request->has('kelas_id') && $request->kelas_id) {
            $query->where('kelas_id', $request->kelas_id);
        }

        $absensi = $query->paginate(20)->appends($request->except('page'));

        // Data tambahan
        $kelasList = Kelas::all();
        $totalHadir = $absensi->where('status', 'hadir')->count();
        $totalIzin = $absensi->where('status', 'izin')->count();
        $totalSakit = $absensi->where('status', 'sakit')->count();
        $totalAlfa = $absensi->where('status', 'alfa')->count();

        return view('gurumapel.absen_riwayat', compact(
            'absensi',
            'kelasList',
            'startDate',
            'endDate',
            'totalHadir',
            'totalIzin',
            'totalSakit',
            'totalAlfa'
        ));
    }

    /**
     * Tampilkan detail absensi
     */
    public function show($id)
    {
        Log::info('🔍 AbsenController@show dipanggil', [
            'absensi_id' => $id,
            'user_id' => Auth::id(),
        ]);

        $absen = AbsensiSiswa::with(['siswa', 'kelas', 'guru'])
            ->where('user_id', Auth::user()->id) // Hanya milik guru ini
            ->findOrFail($id);

        return view('gurumapel.absen_show', compact('absen'));
    }

    /**
     * Hapus absensi (jika diperlukan)
     */
    public function destroy($id)
    {
        Log::info('🗑️ AbsenController@destroy dipanggil', [
            'absensi_id' => $id,
            'user_id' => Auth::id(),
        ]);

        $absen = AbsensiSiswa::where('user_id', Auth::user()->id)->findOrFail($id);
        $absen->delete();

        return redirect()->route('absen.riwayat')->with('success', 'Absensi berhasil dihapus.');
    }

    public function storeDanLaporan(Request $request)
    {
        // Validasi
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'tanggal' => 'required|date',
            'absensi' => 'required|array',
            'absensi.*' => 'required|in:hadir,izin,sakit,alfa',
        ]);

        // Simpan absensi
        if ($request->has('absensi')) {
            foreach ($request->absensi as $siswaId => $status) {
                \App\Models\AbsensiSiswa::updateOrCreate(
                    [
                        'kelas_id' => $request->kelas_id,
                        'siswa_id' => $siswaId,
                        'tanggal' => $request->tanggal,
                    ],
                    [
                        'status' => $status,
                        'keterangan' => $request->keterangan[$siswaId] ?? null,
                        'user_id' => Auth::id(),
                    ]
                );
            }
        }

        // Redirect ke form laporan KBM
        return redirect()->route('laporan.create')->with('success', 'Absensi berhasil disimpan. Silakan isi laporan KBM.');
    }

    public function riwayatHariIni()
    {
        $absenHariIni = AbsensiSiswa::where('user_id', Auth::id())
            ->where('tanggal', today())
            ->with('siswa', 'kelas')
            ->get();

        \Log::info('🔍 Absen hari ini', [
            'user_id' => Auth::id(),
            'jumlah_absen' => $absenHariIni->count(),
            'tanggal' => today()->format('Y-m-d'),
        ]);

        return view('gurumapel.riwayat', compact('absenHariIni'));
    }

    public function loadSiswa(Request $request)
    {
        Log::info('📡 API loadSiswa dipanggil', [
            'kelas_id' => $request->kelas_id,
            'user_id' => Auth::id(),
        ]);

        try {
            $request->validate([
                'kelas_id' => 'required|exists:kelas,id'
            ]);

            $kelas = Kelas::with('siswa:id,nama,nis,kelas_id')
                ->where('wali_kelas_id', Auth::id()) // Pastikan hanya kelas yang dia wali
                ->findOrFail($request->kelas_id);

            return response()->json([
                'success' => true,
                'kelas' => $kelas->nama_kelas,
                'siswa' => $kelas->siswa->map(function ($s) {
                    return [
                        'id' => $s->id,
                        'nama' => $s->nama,
                        'nis' => $s->nis,
                    ];
                })
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Error API loadSiswa', [
                'kelas_id' => $request->kelas_id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data siswa.',
            ], 404);
        }
    }
}
