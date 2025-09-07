@extends('layouts.layout_admin')

@section('content')
<div class="container my-4">
    <h2>Edit Data Siswa</h2>

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
            <h5>{{ $siswa->nama }} <small class="text-muted">({{ $siswa->nis }})</small></h5>
        </div>
        <div class="card-body">
            <form action="{{ route('siswa.update', $siswa->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Nama Siswa -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" id="nama" class="form-control" 
                                   value="{{ old('nama', $siswa->nama) }}" required>
                        </div>
                    </div>

                    <!-- NIS -->
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="nis" class="form-label">NIS</label>
                            <input type="text" name="nis" id="nis" class="form-control" 
                                   value="{{ old('nis', $siswa->nis) }}" required>
                        </div>
                    </div>

                    <!-- NISN -->
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="nisn" class="form-label">NISN (Opsional)</label>
                            <input type="text" name="nisn" id="nisn" class="form-control" 
                                   value="{{ old('nisn', $siswa->nisn) }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Kelas -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="kelas_id" class="form-label">Kelas</label>
                            <select name="kelas_id" id="kelas_id" class="form-control" required>
                                <option value="">Pilih Kelas</option>
                                @foreach ($kelasList as $kelas)
                                    <option value="{{ $kelas->id }}" 
                                        {{ old('kelas_id', $siswa->kelas_id) == $kelas->id ? 'selected' : '' }}>
                                        {{ $kelas->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Tanggal Lahir -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" 
                                   value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}" required>
                        </div>
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'L' ? 'selected' : '' }}>
                                    Laki-laki
                                </option>
                                <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'P' ? 'selected' : '' }}>
                                    Perempuan
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Status Aktif -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status_aktif" class="form-label">Status</label>
                            <select name="status_aktif" id="status_aktif" class="form-control" required>
                                <option value="1" {{ old('status_aktif', $siswa->status_aktif) ? 'selected' : '' }}>
                                    Aktif
                                </option>
                                <option value="0" {{ old('status_aktif', $siswa->status_aktif) ? '' : 'selected' }}>
                                    Nonaktif
                                </option>
                            </select>
                        </div>
                    </div>

                    <!-- Foto Profil (Opsional) -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto Profil (Opsional)</label>
                            <input type="file" name="foto" id="foto" class="form-control" 
                                   accept="image/*">
                            @if ($siswa->foto)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $siswa->foto) }}" 
                                         alt="Foto {{ $siswa->nama }}" 
                                         class="img-thumbnail" width="100">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('siswa.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection