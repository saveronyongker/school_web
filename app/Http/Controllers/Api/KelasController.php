<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;

class KelasController extends Controller
{
   public function getSiswaByKelas($id)
    {
        \Log::info('📡 API getSiswaByKelas dipanggil', [
            'kelas_id' => $id,
            'auth_check' => Auth::check(),
            'auth_id' => Auth::id(),
            'user_name' => Auth::user()?->name,
        ]);

        // ✅ Cek autentikasi
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        try {
            $kelas = Kelas::with('siswa:id,nama,nis,kelas_id')->findOrFail($id);

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
            \Log::error('❌ Error API getSiswaByKelas', [
                'kelas_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data siswa.',
            ], 404);
        }
    }
}
