@extends('layouts.layout_admin')

@section('title', 'Edit Data Pengguna')

@section('content')
<div class="container my-4 p-4 bg-utama shadow rounded-4">
    <h2>Edit Pengguna</h2>

    <form action="{{ route('data_pengguna.update', $user->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>
        <div class="mb-3">
            <label>NIP</label>
            <input type="text" name="nip" class="form-control" value="{{ old('nip', $user->nip) }}" required>
        </div>
        <div class="mb-3">
            <label>Mata Pelajaran</label>
            <input type="text" name="mata_pelajaran" class="form-control" value="{{ old('mata_pelajaran', $user->mata_pelajaran) }}" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="text" name="password" class="form-control" value="{{ old('password', $user->password) }}" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection