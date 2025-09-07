<?php

namespace App\Http\Controllers;

use App\Models\ProfilSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function index()
    {
        $profil = ProfilSekolah::first(); // hanya satu data profil
        return view('admin.page.profil.index', compact('profil'));
    }

    public function create()
    {
        return view('admin.page.profil.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
            'email' => 'nullable|email',
            'logo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'visi' => 'required',
            'misi' => 'required',
            'tujuan' => 'required',
        ]);

        $data = $request->only(['nama', 'deskripsi', 'alamat', 'telepon', 'email', 'visi', 'misi']);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('profil_logo', 'public');
        }

        ProfilSekolah::create($data);

        return redirect()->route('profil.index')->with('success', 'Profil berhasil ditambahkan.');
    }

    public function edit()
    {
        $profil = ProfilSekolah::first(); // hanya satu data profil
        return view('admin.page.profil.edit', compact('profil'));
    }

    public function update(Request $request)
    {
        $profil = ProfilSekolah::firstOrFail(); // hanya satu data profil

        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'alamat' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'email' => 'nullable|email|max:100',
            'visi' => 'required|string',
            'misi' => 'required|string',
            'tujuan' => 'required|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            if ($profil->logo) {
                \Storage::disk('public')->delete($profil->logo);
            }

            $file = $request->file('logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $data['logo'] = $file->storeAs('profil_logo', $filename, 'public');
        }

        $profil->update($data);

        return redirect()->route('profil.index')->with('success', 'Profil berhasil diperbarui.');
    }

    public function destroy(ProfilSekolah $profilSekolah)
    {
        if ($profilSekolah->logo) {
            Storage::delete('public/'.$profilSekolah->logo);
        }

        $profilSekolah->delete();

        return redirect()->route('profil.index')->with('success', 'Profil berhasil dihapus.');
    }
}