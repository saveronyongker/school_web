<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InformasiSekolah;
use Illuminate\Support\Facades\Storage;

class InformasiController extends Controller
{
    //informasi Public
    public function InformasiSekolah()
    {
        $informasis = InformasiSekolah::latest()->get();
        return view('informasi_sekolah', compact('informasis'));
    }

    public function detail($id)
    {
        $info = InformasiSekolah::findOrFail($id);
        return view('informasi_detail', compact('info'));
    }

    // Menampilkan semua informasi (admin)
    public function index()
    {
        $informasis = InformasiSekolah::latest()->get(); // ambil semua data
        return view('admin.page.informasi.index', compact('informasis'));
    }

    // Menampilkan form tambah (admin)
    public function create()
    {
        return view('admin.page.informasi.create');
    }

    // Menyimpan data baru (admin)
    public function store(Request $request)
    {
       // Validasi
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // opsional 10 mb = 10240
        ]);

        // Simpan gambar jika ada
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('informasi_gambar', 'public');
            $validated['gambar'] = $path;
        }

        // Simpan ke database
        InformasiSekolah::create($validated);

        return redirect()->route('informasi.index')->with('success', 'Data berhasil disimpan.');
    }

    // Menampilkan detail informasi (opsional)
    public function show(InformasiSekolah $informasi) 
    {
        return view('admin.page.informasi.show', compact('informasi')); 
    }

    // Menampilkan form edit (admin)
    public function edit(InformasiSekolah $informasi)
    {
        return view('admin.page.informasi.edit', compact('informasi'));
    }

    // Mengupdate data (admin)
    public function update(Request $request, InformasiSekolah $informasi)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['judul', 'isi']);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($informasi->gambar) {
                Storage::delete('public/' . $informasi->gambar);
            }

            // Simpan gambar baru
            $data['gambar'] = $request->file('gambar')->store('informasi', 'public');
        }

        $informasi->update($data);

        return redirect()->route('informasi.index')->with('success', 'Informasi berhasil diperbarui.');
    }

    // Menghapus data (admin)
    public function destroy(InformasiSekolah $informasi)
    {
        if ($informasi->gambar) {
            Storage::delete('public/' . $informasi->gambar);
        }

        $informasi->delete();

        return redirect()->route('informasi.index')->with('success', 'Informasi berhasil dihapus.');
    }

    public function dashboard()
    {
        // Ambil semua informasi, urutkan terbaru
        $informasi = InformasiSekolah::orderBy('tanggal', 'desc')->paginate(6);
        return view('informasi.index', compact('informasi'));
    }

}