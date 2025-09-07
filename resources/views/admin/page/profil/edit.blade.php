@extends('layouts.layout_admin')


@section('content')
<div class="container my-4 py-4 bg-utama shadow rounded-4">
    <h2>Edit Profil Sekolah</h2>

    <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama" class="form-label">Nama Sekolah</label>
            <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $profil->nama) }}" required>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control" required>{{ old('deskripsi', $profil->deskripsi) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" name="alamat" id="alamat" class="form-control" value="{{ old('alamat', $profil->alamat) }}" required>
        </div>

        <div class="mb-3">
            <label for="telepon" class="form-label">Telepon</label>
            <input type="text" name="telepon" id="telepon" class="form-control" value="{{ old('telepon', $profil->telepon) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $profil->email) }}">
        </div>

        <div class="mb-3">
            <label for="visi" class="form-label">Visi</label>
            <textarea name="visi" id="visi" class="form-control" required>{{ old('visi', $profil->visi) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="misi" class="form-label">Misi</label>
            <textarea name="misi" id="misi" class="form-control" required>{{ old('misi', $profil->misi) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="tujuan" class="form-label">Tujuan Sekolah</label>
            <textarea name="tujuan" id="tujuan" class="form-control" rows="4" 
                    placeholder="Tuliskan tujuan sekolah...">{{ old('tujuan', $profilSekolah->tujuan ?? '') }}</textarea>
            <div class="form-text">Tujuan jangka panjang sekolah</div>
        </div>

        <div class="mb-3">
            <label for="logo" class="form-label">Logo</label>
            <input type="file" name="logo" id="logo" class="form-control">
            @if($profil->logo)
                <div class="mt-2">
                    <img src="{{ asset('storage/'.$profil->logo) }}" alt="Logo" width="100">
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('profil.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection