@extends('layouts.layout_admin')

@section('content')
<div class="container my-4">
    <h2>Edit Kelas</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5>{{ $kelas->nama_kelas }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('kelas.update', $kelas->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Nama Kelas -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama_kelas" class="form-label">Nama Kelas</label>
                            <input type="text" name="nama_kelas" id="nama_kelas" class="form-control" 
                                   value="{{ old('nama_kelas', $kelas->nama_kelas) }}" required>
                            <div class="form-text">Contoh: X-A, XI-B, XII-C</div>
                        </div>
                    </div>

                    <!-- Jumlah Siswa -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="jumlah_siswa" class="form-label">Jumlah Siswa</label>
                            <input type="number" name="jumlah_siswa" id="jumlah_siswa" class="form-control" 
                                   value="{{ old('jumlah_siswa', $kelas->jumlah_siswa) }}" 
                                   min="1" max="100" required>
                            <div class="form-text">Maksimal 100 siswa</div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Tahun Ajaran -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
                            <input type="text" name="tahun_ajaran" id="tahun_ajaran" class="form-control" 
                                   value="{{ old('tahun_ajaran', $kelas->tahun_ajaran) }}" required>
                            <div class="form-text">Contoh: 2025/2026</div>
                        </div>
                    </div>

                    <!-- Wali Kelas -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="wali_kelas_id" class="form-label">Wali Kelas (Opsional)</label>
                            <select name="wali_kelas_id" id="wali_kelas_id" class="form-control">
                                <option value="">Pilih Wali Kelas</option>
                                @foreach ($guruList as $guru)
                                    <option value="{{ $guru->id }}" 
                                        {{ old('wali_kelas_id', $kelas->wali_kelas_id) == $guru->id ? 'selected' : '' }}>
                                        {{ $guru->name }} ({{ $guru->nip }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('kelas.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Preview Data Kelas -->
    <div class="card mt-4">
        <div class="card-header">
            <h5>📋 Preview Data Kelas</h5>
        </div>
        <div class="card-body">
            <table class="table table-sm">
                <tr>
                    <th width="20%">Nama Kelas</th>
                    <td>{{ $kelas->nama_kelas }}</td>
                </tr>
                <tr>
                    <th>Jumlah Siswa</th>
                    <td>{{ $kelas->jumlah_siswa }}</td>
                </tr>
                <tr>
                    <th>Tahun Ajaran</th>
                    <td>{{ $kelas->tahun_ajaran }}</td>
                </tr>
                <tr>
                    <th>Wali Kelas</th>
                    <td>{{ $kelas->waliKelas?->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Jumlah Siswa Terdaftar</th>
                    <td>{{ $kelas->siswa->count() }} siswa</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection