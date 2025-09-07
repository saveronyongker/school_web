@extends('layouts.layout_admin')

@section('content')
<div class="container my-4 py-4 bg-utama shadow rounded-4">
    <h2>Edit Informasi Sekolah</h2>

    <form action="{{ route('informasi.update', $informasi->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Judul -->
        <div class="mb-3">
            <label for="judul">Judul</label>
            <input type="text" name="judul" id="judul" class="form-control" value="{{ old('judul', $informasi->judul) }}" required>
        </div>

        <!-- Isi -->
        <div class="mb-3">
            <label for="isi">Isi Informasi</label>
            <textarea name="isi" id="isi" class="form-control" rows="5" required>{{ old('isi', $informasi->isi) }}</textarea>
        </div>

        <!-- Gambar -->
        <div class="mb-3">
            <label for="gambar">Gambar</label>
            <input type="file" name="gambar" id="gambar" class="form-control">
            @if ($informasi->gambar)
                <img src="{{ asset('storage/' . $informasi->gambar) }}" alt="Gambar Sekolah" width="200">
            @endif
        </div>

        <!-- Tombol Submit -->
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('informasi.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection