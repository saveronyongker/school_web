@extends('layouts.layout_admin')

@section('content')
<div class="container my-4">
    <h2>Tambah Kelas Baru</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('kelas.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="nama_kelas" class="form-label">Nama Kelas</label>
                    <input type="text" name="nama_kelas" id="nama_kelas" class="form-control" 
                           value="{{ old('nama_kelas') }}" required>
                    <div class="form-text">Contoh: X-A, XI-B, XII-C</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="jumlah_siswa" class="form-label">Jumlah Siswa</label>
                    <input type="number" name="jumlah_siswa" id="jumlah_siswa" class="form-control" 
                           value="{{ old('jumlah_siswa', 30) }}" min="1" max="100" required>
                    <div class="form-text">Maksimal 100 siswa</div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
                    <input type="text" name="tahun_ajaran" id="tahun_ajaran" class="form-control" 
                           value="{{ old('tahun_ajaran', date('Y') . '/' . (date('Y') + 1)) }}" required>
                    <div class="form-text">Contoh: 2025/2026</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="wali_kelas_id" class="form-label">Wali Kelas (Opsional)</label>
                    <select name="wali_kelas_id" id="wali_kelas_id" class="form-control">
                        <option value="">Pilih Wali Kelas</option>
                        @foreach ($guruList as $guru)
                            <option value="{{ $guru->id }}" {{ old('wali_kelas_id') == $guru->id ? 'selected' : '' }}>
                                {{ $guru->name }} ({{ $guru->nip }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-save"></i> Simpan Kelas
            </button>
            <a href="{{ route('kelas.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection