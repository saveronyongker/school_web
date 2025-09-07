<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DataPenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('admin.page.data_pengguna.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'nip' => 'required|unique:users,nip',
            'mata_pelajaran' => 'required_if:role,guru_mapel',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,kepala_sekolah,guru_mapel,guru_piket',
        ]);

        $user = User::create([
            'name' => $request->name,
            'nip' => $request->nip,
            'mata_pelajaran' => $request->mata_pelajaran,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_confirmed' => true,
        ]);

        return redirect()->route('admin.page.data_pengguna.index')->with('success', 'Akun berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.page.data_pengguna.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $user->update($request->only(['name', 'email']));
        return redirect()->route('data_pengguna.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('data_pengguna.index')->with('success', 'Pengguna berhasil dihapus.');
    }

    // Konfirmasi registrasi pengguna
    public function confirm(User $user)
    {
        $user->update(['is_confirmed' => true]);
        return redirect()->route('data_pengguna.index')->with('success', 'Pengguna berhasil dikonfirmasi.');
    }

    // Reset Password
    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|confirmed|min:6',
        ]);

        $user->update(['password' => Hash::make($request->password)]);

        return redirect()->route('admin.page.data_pengguna.index')->with('success', "Password {$user->name} berhasil direset.");
    }
}
