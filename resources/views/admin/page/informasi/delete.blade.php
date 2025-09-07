@extends('layouts.layout_admin')

@section('content')
<div class="container my-4">
    <h2>Hapus Informasi Sekolah</h2>

    <p>Apakah kamu yakin ingin menghapus informasi ini?</p>

    <form action="{{ route('admin.page.informasi.destroy', $informasi->id) }}" method="POST">
        @csrf
        @method('DELETE')

        <button type="submit" class="btn btn-danger">Hapus</button>
        <a href="{{ route('admin.page.informasi.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection