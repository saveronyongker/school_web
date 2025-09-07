<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;

class KelasController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelas = Kelas::withCount('siswa')->orderBy('nama_kelas')->paginate(10);
        return view('admin.page.kelas.index', compact('kelas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $guruList = \App\Models\User::where('role', 'guru_mapel')->get();
        return view('admin.page.kelas.create', compact('guruList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:50|unique:kelas,nama_kelas',
            'jumlah_siswa' => 'required|integer|min:1|max:100',
            'tahun_ajaran' => 'required|string|max:20',
            'wali_kelas_id' => 'nullable|exists:users,id',
        ]);

        Kelas::create($request->all());

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kelas $kelas)
    {
        $kelas->load('siswa', 'waliKelas');
        return view('admin.page.kelas.show', compact('kelas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kelas $kelas)
    {
        $guruList = \App\Models\User::where('role', 'guru_mapel')->get();
        return view('admin.page.kelas.edit', compact('kelas', 'guruList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kelas $kelas)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:50|unique:kelas,nama_kelas,' . $kelas->id,
            'jumlah_siswa' => 'required|integer|min:1|max:100',
            'tahun_ajaran' => 'required|string|max:20',
            'wali_kelas_id' => 'nullable|exists:users,id',
        ]);

        $kelas->update($request->all());

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kelas $kelas)
    {
        // Hapus semua siswa di kelas ini
        $kelas->siswa()->delete();

        // Hapus kelas
        $kelas->delete();

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
