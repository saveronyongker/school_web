<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    
    // public function showRegistrationForm()
    // {
    //     return view('auth.register');
    // }

    // public function register(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:users',
    //         'password' => 'required|string|min:6|confirmed',
    //         'role' => 'nullable|in:admin,guru_piket,guru_mapel,kepala_sekolah,siswa',
    //     ]);

    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //         'role' => $request->role ?? 'siswa',
    //         'is_confirmed' => false,
    //     ]);

    //     Auth::login($user);

    //     return match($user->role) {
    //         'admin' => redirect()->route('admin.page.dashboard'),
    //         'guru_piket' => redirect()->route('gurupkt.home_gurupkt'),
    //         'guru_mapel' => redirect()->route('gurumapel.page.home_gurumapel'),
    //         'kepala_sekolah' => redirect()->route('kepsek.home_kepsek'),
    //         default => redirect('/'),
    //     };
    // }

    // Tampilkan form
    public function showGuruMapelForm()
    {
        return view('auth.register.guru_mapel');
    }

    public function registerGuruMapel(Request $request)
    {
         Log::info('🚀 [RegisterController] Fungsi dimulai');

        try {
            Log::info('🔍 Data input sebelum validasi', $request->all());

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'nip' => 'required|string|unique:users,nip',
                'mata_pelajaran' => 'required|string|max:100',
                'password' => 'required|string|min:8|confirmed',
            ]);

            Log::info('Validasi berhasil', $validated);

            $userData = [
                'name' => $validated['name'],
                'nip' => $validated['nip'],
                'mata_pelajaran' => $validated['mata_pelajaran'],
                'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
                'role' => 'guru_mapel',
                'is_confirmed' => false,
            ];

            Log::info('🔧 Siap membuat user...', [
                'name' => $userData['name'],
                'nip' => $userData['nip'],
                // password tidak dicatat untuk keamanan
            ]);

            $user = \App\Models\User::create($userData);

            Log::info('🎉 User berhasil dibuat', [
                'id' => $user->id,
                'nip' => $user->nip,
                'name' => $user->name
            ]);

            return redirect()->route('login')->with('success', 'Registrasi berhasil. Tunggu konfirmasi admin.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('❌ Validasi gagal', [
                'errors' => $e->errors(),
                'nip' => $request->nip,
            ]);
            throw $e; // lempar ulang agar muncul di form
        } catch (\Exception $e) {
            Log::error('💥 Error tak terduga', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->withErrors(['error' => 'Terjadi kesalahan saat registrasi.']);
        }
    }
}