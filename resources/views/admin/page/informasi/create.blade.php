@extends('layouts.layout_admin')

@section('title', 'Tambah Informasi Baru')

@section('content')
<div class="container my-4 py-4 bg-utama shadow rounded-4">
    <h2>Tambah Informasi</h2>
    <form action="{{ route('informasi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="judul" class="form-label">Judul Informasi</label>
            <input type="text" name="judul" id="judul" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="isi" class="form-label">Isi Informasi</label>
            <textarea name="isi" id="isi" rows="5" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label for="gambar" class="form-label">Gambar</label>
            <input type="file" name="gambar" id="gambar" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection