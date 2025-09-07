<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanKBM; 
use App\Models\User;
use App\Models\Kelas; //bagian kelas
use App\Models\AbsensiSiswa;
use App\Models\Siswa; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon; // Untuk today()


class LaporanKBMController extends Controller
{
    public function create()
    {
        $kelasList = Kelas::all();

        return view('gurumapel.laporan', compact('kelasList'));
    }

    public function store(Request $request)
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil ID sebenarnya dari user
        $userId = $user->id; // <-- ini yang benar: kolom `id` di database

        $request->validate([
            //'tanggal' => 'required|date',
            'kelas' => 'required',
            'mata_pelajaran' => 'required',
            'topik' => 'required',
            'kegiatan' => 'required',
            'jam_mulai' => 'required|integer|between:6,15',     // Jam 6-15
            'jam_selesai' => 'required|integer|between:6,15|gte:jam_mulai', // Jam 6-15 dan >= jam_mulai
            'file_materi' => 'nullable|file|mimes:doc,docx,pdf|max:5120', // 5MB max
        ]);

         // Simpan absensi siswa (jika ada)
        if ($request->has('absensi')) {
            foreach ($request->absensi as $siswaId => $status) {
                AbsensiSiswa::create([
                    'laporan_kbm_id' => $laporan->id, // Terhubung!
                    'siswa_id' => $siswaId,
                    'tanggal' => $request->tanggal,
                    'status' => $status,
                    'keterangan' => $request->keterangan[$siswaId] ?? null,
                    'user_id' => Auth::id(),
                ]);
            }
        }

        $data = $request->except('file_materi');

        //untuk tanggal otomatis
        $data['tanggal'] = today()->format('Y-m-d'); // Tanggal hari ini
        $data['user_id'] = Auth::user()->id; // ID database user

        // Handle upload file materi
        if ($request->hasFile('file_materi')) {
            $file = $request->file('file_materi');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('materi', $filename, 'public');
            
            $data['file_materi'] = $path;
            $data['nama_file'] = $file->getClientOriginalName();
        }

        LaporanKBM::create([
            'user_id' => $userId, // Gunakan $user->id, bukan auth()->id()
            'tanggal' => $request->tanggal,
            'kelas' => $request->kelas,
            'mata_pelajaran' => $request->mata_pelajaran,
            'topik' => $request->topik,
            'kegiatan' => $request->kegiatan,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'status' => 'belum_dikonfirmasi',
            'file_materi' => $data['file_materi'] ?? null,
            'nama_file' => $data['nama_file'] ?? null,
        ]);

        

        return redirect()->route('laporan.riwayat')->with('success', 'Laporan KBM  dan Absensi berhasil disimpan.');
    }

    public function edit($id)
    {
         \Log::info('🔍 Edit laporan dipanggil dengan NIP', [
            'requested_id' => $id,
            'auth_check' => Auth::check(),
            'auth_user' => Auth::user() ? [
                'nip' => Auth::user()->nip,
                'name' => Auth::user()->name,
            ] : null,
        ]);

        // ✅ Validasi user login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $loggedInUser = Auth::user();
        $loggedInNip = $loggedInUser->nip;

        try {
            // ✅ Cari laporan berdasarkan NIP user yang login
            $laporan = LaporanKBM::where('id', $id)
                ->whereHas('guru', function ($query) use ($loggedInNip) {
                    $query->where('nip', $loggedInNip); // ✅ Gunakan NIP, bukan ID
                })
                ->with(['absensiSiswa.siswa', 'kelas', 'guru'])
                ->first();

            if (!$laporan) {
                \Log::warning('❌ Laporan tidak ditemukan atau bukan milik Anda', [
                    'requested_id' => $id,
                    'logged_in_nip' => $loggedInNip,
                ]);
                
                return redirect()->route('laporan.riwayat')->with('error', 
                    'Laporan tidak ditemukan atau bukan milik Anda (NIP: ' . $loggedInNip . ')'
                );
            }

            \Log::info('📊 Laporan ditemukan', [
                'id' => $laporan->id,
                'guru_nip' => $laporan->guru->nip,
                'logged_in_nip' => $loggedInNip,
                'tanggal' => $laporan->tanggal,
            ]);

            // ✅ Cek apakah masih hari ini
            $isToday = \Carbon\Carbon::parse($laporan->tanggal)->isToday();
            if (!$isToday) {
                return redirect()->route('laporan.riwayat')->with('error', 'Hanya bisa edit laporan hari ini.');
            }

            // ✅ Load data untuk form
            $kelasList = Kelas::all();
            $formData = [
                'kelas_id' => $laporan->kelas_id,
                'mata_pelajaran' => $laporan->mata_pelajaran,
                'topik' => $laporan->topik,
                'kegiatan' => $laporan->kegiatan,
                'jam_mulai' => $laporan->jam_mulai,
                'jam_selesai' => $laporan->jam_selesai,
            ];

            \Log::info('✅ Laporan edit berhasil dimuat', [
                'laporan_id' => $laporan->id,
                'kelas_id' => $laporan->kelas_id,
            ]);

            return view('gurumapel.edit_laporan', compact('laporan', 'kelasList', 'formData'));

        } catch (\Exception $e) {
            \Log::error('❌ Error edit laporan: ' . $e->getMessage());
            return redirect()->route('laporan.riwayat')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        \Log::info('💾 Update laporan dipanggil dengan NIP', [
            'laporan_id' => $id,
            'auth_user' => Auth::user() ? Auth::user()->nip : null,
        ]);

        // ✅ Validasi user login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $loggedInNip = Auth::user()->nip;

        try {
            // ✅ Cari laporan berdasarkan NIP
            $laporan = LaporanKBM::where('id', $id)
                ->whereHas('guru', function ($query) use ($loggedInNip) {
                    $query->where('nip', $loggedInNip); // ✅ Gunakan NIP
                })
                ->first();

            if (!$laporan) {
                return redirect()->route('laporan.riwayat')->with('error', 'Laporan tidak ditemukan atau bukan milik Anda.');
            }

            // ✅ Cek apakah masih hari ini
            if (!\Carbon\Carbon::parse($laporan->tanggal)->isToday()) {
                return redirect()->back()->with('error', 'Hanya bisa edit laporan hari ini.');
            }

            // ✅ Validasi
            $validated = $request->validate([
                'kelas_id' => 'required|exists:kelas,id',
                'mata_pelajaran' => 'required|string|max:100',
                'topik' => 'required|string|max:200',
                'kegiatan' => 'required|string',
                'jam_mulai' => 'required|integer|between:1,12',
                'jam_selesai' => 'required|integer|between:1,12|gte:jam_mulai',
                'absensi' => 'required|array',
                'absensi.*' => 'required|in:hadir,izin,sakit,alfa',
                'file_materi' => 'nullable|file|mimes:doc,docx,pdf|max:5120',
            ]);

            // ✅ Update laporan
            $laporan->update($validated);

            // ✅ Update absensi
            foreach ($request->absensi as $siswaId => $status) {
                \App\Models\AbsensiSiswa::updateOrCreate(
                    [
                        'laporan_kbm_id' => $laporan->id,
                        'siswa_id' => $siswaId,
                    ],
                    [
                        'kelas_id' => $request->kelas_id,
                        'tanggal' => $laporan->tanggal,
                        'status' => $status,
                        'keterangan' => $request->keterangan[$siswaId] ?? null,
                        'user_id' => $laporan->user_id, // ✅ Gunakan user_id asli dari laporan
                    ]
                );
            }

            \Log::info('✅ Laporan berhasil diupdate', [
                'laporan_id' => $laporan->id,
                'jumlah_absensi' => count($request->absensi),
            ]);

            return redirect()->route('laporan.riwayat')->with('success', 'Laporan & absensi berhasil diperbarui.');

        } catch (\Exception $e) {
            \Log::error('❌ Error update laporan: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal update: ' . $e->getMessage()]);
        }
    }

    public function dashboardPiket(Request $request)
    {   
        $tanggalHariIni = today()->format('Y-m-d');
        $statusFilter = $request->get('status', 'semua'); // semua, belum_dikonfirmasi, dikonfirmasi, ditolak

        // Query dasar
        $query = LaporanKBM::where('tanggal', $tanggalHariIni)
            ->with('guru');

        // Filter berdasarkan status
        if ($statusFilter !== 'semua') {
            $query->where('status', $statusFilter);
        }

        $laporanHariIni = $query->orderBy('created_at', 'desc')->get();

        // Statistik
        $totalLaporan = LaporanKBM::where('tanggal', $tanggalHariIni)->count();
        $belumDikonfirmasi = LaporanKBM::where('tanggal', $tanggalHariIni)
            ->where('status', 'belum_dikonfirmasi')->count();
        $dikonfirmasi = LaporanKBM::where('tanggal', $tanggalHariIni)
            ->where('status', 'dikonfirmasi')->count();
        $ditolak = LaporanKBM::where('tanggal', $tanggalHariIni)
            ->where('status', 'ditolak')->count();

        return view('gurupkt.home_gurupkt', compact(
            'laporanHariIni',
            'tanggalHariIni',
            'statusFilter',
            'totalLaporan',
            'belumDikonfirmasi',
            'dikonfirmasi',
            'ditolak'
        ));
    }

    public function konfirmasi($id)
    {
        // Cek apakah user login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Sesi habis. Silakan login ulang.');
        }

        // Ambil user yang login
        $user = Auth::user();
        \Log::info('User login saat konfirmasi', [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'nip' => $user->nip,
        ]);

        $laporan = LaporanKBM::findOrFail($id);

        $guruPiketId = auth()->user()->id; // Gunakan ID database

        $laporan->update([
            'status' => 'dikonfirmasi',
            'dikonfirmasi_oleh' => Auth::user()->id, //$guruPiketId,
            'catatan_piket' => request('catatan_piket'),
        ]);

        return back()->with('success', 'Laporan berhasil dikonfirmasi.');
    }

     public function tolak($id)
    {
            if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login ulang.');
        }

        $laporan = LaporanKBM::findOrFail($id);

        $guruPiketId = Auth::user()->id; // Harusnya benar

        \Log::info('Tolak laporan', [
            'auth_user_id' => Auth::id(),
            'user_db_id' => $guruPiketId,
            'target_laporan_id' => $id,
            'user_exists' => \App\Models\User::where('id', $guruPiketId)->exists(),
        ]);

        $laporan->update([
            'status' => 'ditolak',
            'dikonfirmasi_oleh' =>  Auth::user()->id, //$guruPiketId,
            'catatan_piket' => request('catatan_piket'),
        ]);

        return back()->with('success', 'Laporan berhasil ditolak.');
    }

    public function createGabungan(Request $request)
    {
        \Log::info('📥 LaporanKBMController@createGabungan', [
            'user_id' => Auth::id(),
            'kelas_id' => $request->kelas_id,
        ]);

        $user = Auth::user();
        $kelasList = Kelas::all();
        
        $siswaList = collect();
        $kelasDipilih = null;
        
        // Load siswa jika ada kelas_id
        if ($request->has('kelas_id') && $request->kelas_id) {
            try {
                $kelasDipilih = Kelas::with('siswa')->find($request->kelas_id);
                if ($kelasDipilih) {
                    $siswaList = $kelasDipilih->siswa->sortBy('nama');
                }
            } catch (\Exception $e) {
                \Log::error('❌ Error load siswa: ' . $e->getMessage());
            }
        }

        // ✅ Perbaiki: Ambil data form dari session (jika ada) - JANGAN hapus session di sini
        $formData = session()->get('laporan_form_data', []);
        
        // Jangan forget session di sini, karena data masih dibutuhkan

        return view('gurumapel.laporan_kbm_dan_absensi', compact(
            'kelasList', 
            'siswaList', 
            'kelasDipilih',
            'formData'
        ));
    }

    public function loadSiswaNoApi(Request $request)
    {
        \Log::info('📥 LoadSiswaNoApi dipanggil', [
            'kelas_id' => $request->kelas_id,
        ]);

        // Validasi hanya kelas_id
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id'
        ], [
            'kelas_id.required' => 'Pilih kelas terlebih dahulu',
            'kelas_id.exists' => 'Kelas tidak ditemukan'
        ]);

        // ✅ Perbaiki: Simpan data form yang sudah diisi ke session
        $formData = $request->only([
            'mata_pelajaran', 
            'topik',
            'kegiatan',
            'jam_mulai',
            'jam_selesai'
            // Jangan simpan file_materi karena tidak bisa diserialisasi
        ]);
        
        // Simpan ke session
        session()->put('laporan_form_data', $formData);
        
        // Redirect kembali ke form dengan parameter kelas
        return redirect()->route('laporan.create.gabungan', [
            'kelas_id' => $request->kelas_id
        ]);
    }

    public function storeGabungan(Request $request)
    {
        $user = Auth::user();
        
        \Log::info('💾 StoreGabungan dipanggil', [
            'auth_user_id' => $user->id ?? null,
            'auth_user_nip' => $user->nip ?? null,
        ]);

        // Validasi user
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login kembali.');
        }

        // ✅ Validasi lengkap saat menyimpan
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'tanggal' => 'required|date',
            'mata_pelajaran' => 'required|string|max:100',
            'topik' => 'required|string|max:200',
            'kegiatan' => 'required|string',
            'jam_mulai' => 'required|integer|between:1,12',
            'jam_selesai' => 'required|integer|between:1,12|gte:jam_mulai',
            'file_materi' => 'nullable|file|mimes:doc,docx,pdf|max:5120',
        ], [
            'mata_pelajaran.required' => 'Mata pelajaran wajib diisi',
            'topik.required' => 'Topik wajib diisi',
            'kegiatan.required' => 'Kegiatan wajib diisi',
            'jam_mulai.required' => 'Jam mulai wajib diisi',
            'jam_selesai.required' => 'Jam selesai wajib diisi',
        ]);

        // Validasi absensi jika ada
        if ($request->has('absensi')) {
            $request->validate([
                'absensi' => 'required|array',
                'absensi.*' => 'required|in:hadir,izin,sakit,alfa',
            ], [
                'absensi.required' => 'Absensi siswa wajib diisi',
                'absensi.*.required' => 'Pilih status kehadiran untuk setiap siswa',
                'absensi.*.in' => 'Status kehadiran tidak valid',
            ]);
        } else {
            return redirect()->back()->withInput()->withErrors(['absensi' => 'Absensi siswa wajib diisi']);
        }

        try {
            $laporanData = [
                'user_id' => $user->id,
                'kelas_id' => $request->kelas_id,
                'tanggal' => $request->tanggal,
                'mata_pelajaran' => $request->mata_pelajaran,
                'topik' => $request->topik,
                'kegiatan' => $request->kegiatan,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'status' => 'belum_dikonfirmasi',
                'kelas' => \App\Models\Kelas::find($request->kelas_id)->nama_kelas,
            ];

            // Handle file upload
            if ($request->hasFile('file_materi')) {
                $file = $request->file('file_materi');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('materi', $filename, 'public');
                
                $laporanData['file_materi'] = $path;
                $laporanData['nama_file'] = $file->getClientOriginalName();
            }

            $laporan = LaporanKBM::create($laporanData);

            \Log::info('✅ Laporan KBM berhasil disimpan', [
                'laporan_id' => $laporan->id
            ]);

            // Simpan Absensi
            foreach ($request->absensi as $siswaId => $status) {
                \App\Models\AbsensiSiswa::create([
                    'laporan_kbm_id' => $laporan->id,
                    'kelas_id' => $request->kelas_id,
                    'siswa_id' => $siswaId,
                    'tanggal' => $request->tanggal,
                    'status' => $status,
                    'keterangan' => $request->keterangan[$siswaId] ?? null,
                    'user_id' => $user->id,
                ]);
            }

            \Log::info('✅ Absensi berhasil disimpan', [
                'jumlah_absensi' => count($request->absensi)
            ]);
            
            // ✅ Bersihkan session setelah berhasil
            session()->forget('laporan_form_data');

            return redirect()->route('laporan.riwayat')->with('success', 'Laporan KBM & absensi berhasil disimpan.');

        } catch (\Exception $e) {
            \Log::error('❌ Error simpan: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal menyimpan: ' . $e->getMessage()]);
        }
    }

    public function riwayat(Request $request)
    {
        \Log::info('📖 GuruMapelController@riwayat dipanggil', [
            'user_id' => Auth::id(),
            'user_name' => Auth::user()?->name,
        ]);

        try {
            // ✅ Eager loading dengan relasi yang benar dan lengkap
            $laporan = LaporanKBM::where('user_id', Auth::id())
                ->with([
                    'kelas',
                    'guruPiket',
                    'absensiSiswa.siswa', // ✅ Ini yang penting!
                    'absensiSiswa.kelas'
                ])
                ->orderBy('tanggal', 'desc')
                ->orderBy('created_at', 'desc')
                ->paginate(9);

            \Log::info('📊 Data riwayat berhasil dimuat', [
                'jumlah_laporan' => $laporan->count(),
                'laporan_ids' => $laporan->pluck('id')->toArray(),
            ]);

            return view('gurumapel.riwayat', compact('laporan'));

        } catch (\Exception $e) {
            \Log::error('❌ Error riwayat: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $laporan = LaporanKBM::where('id', $id)
                ->where('user_id', Auth::user()->id)
                ->with(['kelas', 'absensiSiswa.siswa'])
                ->firstOrFail();

            return view('gurumapel.detail', compact('laporan'));
        } catch (\Exception $e) {
            \Log::error('Error menampilkan detail laporan: ' . $e->getMessage());
            return redirect()->route('laporan.riwayat')->with('error', 'Laporan tidak ditemukan.');
        }
    }

     public function getFileMateriUrlAttribute()
    {
        return $this->file_materi ? asset('storage/' . $this->file_materi) : null;
    }

    // Accessor untuk cek apakah ada file
    public function getHasFileAttribute()
    {
        return !empty($this->file_materi);
    }
   
}
