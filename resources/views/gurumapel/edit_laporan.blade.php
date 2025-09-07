@extends('layouts.layout_guru')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Edit Laporan KBM & Absensi</h2>
            <p class="text-muted">Hanya bisa edit laporan hari ini ({{ date('d F Y') }})</p>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Edit -->
            <form action="{{ route('laporan.update', $laporan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Bagian 1: Informasi Laporan KBM -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-info-circle"></i> Informasi Laporan KBM</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="kelas_id">Kelas <span class="text-danger">*</span></label>
                                    <select name="kelas_id" id="kelas_id" class="form-control" required>
                                        <option value="">Pilih Kelas</option>
                                        @foreach($kelasList as $kelas)
                                            <option value="{{ $kelas->id }}" 
                                                    {{ (old('kelas_id', $formData['kelas_id'] ?? $laporan->kelas_id) == $kelas->id) ? 'selected' : '' }}>
                                                {{ $kelas->nama_kelas }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="text" class="form-control" 
                                           value="{{ \Carbon\Carbon::parse($laporan->tanggal)->format('d F Y') }}" readonly>
                                    <input type="hidden" name="tanggal" value="{{ $laporan->tanggal }}">
                                    <small class="form-text text-muted">Tanggal tidak bisa diubah</small>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="mata_pelajaran">Mata Pelajaran <span class="text-danger">*</span></label>
                                    <input type="text" name="mata_pelajaran" id="mata_pelajaran" class="form-control" 
                                           value="{{ old('mata_pelajaran', $formData['mata_pelajaran'] ?? $laporan->mata_pelajaran) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="jam_mulai">Jam Mulai <span class="text-danger">*</span></label>
                                    <input type="number" name="jam_mulai" id="jam_mulai" class="form-control" 
                                           value="{{ old('jam_mulai', $formData['jam_mulai'] ?? $laporan->jam_mulai) }}" 
                                           min="1" max="12" required>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="jam_selesai">Jam Selesai <span class="text-danger">*</span></label>
                                    <input type="number" name="jam_selesai" id="jam_selesai" class="form-control" 
                                           value="{{ old('jam_selesai', $formData['jam_selesai'] ?? $laporan->jam_selesai) }}" 
                                           min="1" max="12" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="topik">Topik <span class="text-danger">*</span></label>
                                    <input type="text" name="topik" id="topik" class="form-control" 
                                           value="{{ old('topik', $formData['topik'] ?? $laporan->topik) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label for="kegiatan">Kegiatan Pembelajaran <span class="text-danger">*</span></label>
                            <textarea name="kegiatan" id="kegiatan" class="form-control" rows="4" required>{{ old('kegiatan', $formData['kegiatan'] ?? $laporan->kegiatan) }}</textarea>
                        </div>
                        
                        <div class="form-group mt-3">
                            <label for="file_materi">File Materi (Opsional)</label>
                            <input type="file" name="file_materi" id="file_materi" class="form-control">
                            <small class="form-text text-muted">Format: DOC, DOCX, PDF (max 5MB)</small>
                            
                            @if($laporan->file_materi)
                                <div class="mt-2">
                                    <a href="{{ asset('storage/' . $laporan->file_materi) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-download"></i> {{ $laporan->nama_file ?? 'Download Materi' }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Bagian 2: Absensi Siswa - PERBAIKAN DISINI -->
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0"><i class="fas fa-users"></i> Absensi Siswa</h4>
                    </div>
                    <div class="card-body">
                        @php
                            // ✅ Perbaiki: Dapatkan siswa dari kelas yang dipilih, bukan dari $laporan->kelas
                            $kelasId = old('kelas_id', $formData['kelas_id'] ?? $laporan->kelas_id);
                            $siswaList = collect();
                            
                            if ($kelasId) {
                                try {
                                    $kelas = \App\Models\Kelas::with('siswa')->find($kelasId);
                                    if ($kelas && $kelas->siswa) {
                                        $siswaList = $kelas->siswa->sortBy('nama');
                                    }
                                } catch (\Exception $e) {
                                    \Log::error('❌ Error loading siswa: ' . $e->getMessage());
                                }
                            }
                            
                            // ✅ Buat array untuk absensi yang sudah ada
                            $absensiExisting = [];
                            foreach($laporan->absensiSiswa as $absen) {
                                $absensiExisting[$absen->siswa_id] = [
                                    'status' => $absen->status,
                                    'keterangan' => $absen->keterangan
                                ];
                            }
                        @endphp
                        
                        @if($siswaList->isEmpty())
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> 
                                Pilih kelas terlebih dahulu untuk menampilkan daftar siswa
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="25%">Nama Siswa</th>
                                            <th width="15%">NIS</th>
                                            <th width="20%">Status <span class="text-danger">*</span></th>
                                            <th width="35%">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($siswaList as $index => $siswa)
                                            @php
                                                $existingData = $absensiExisting[$siswa->id] ?? null;
                                            @endphp
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $siswa->nama }}</td>
                                                <td>{{ $siswa->nis }}</td>
                                                <td>
                                                    <select name="absensi[{{ $siswa->id }}]" class="form-control form-control-sm" required>
                                                        <option value="">Pilih Status</option>
                                                        <option value="hadir" {{ (old("absensi.{$siswa->id}", $existingData['status'] ?? '') == 'hadir') ? 'selected' : '' }}>Hadir</option>
                                                        <option value="izin" {{ (old("absensi.{$siswa->id}", $existingData['status'] ?? '') == 'izin') ? 'selected' : '' }}>Izin</option>
                                                        <option value="sakit" {{ (old("absensi.{$siswa->id}", $existingData['status'] ?? '') == 'sakit') ? 'selected' : '' }}>Sakit</option>
                                                        <option value="alfa" {{ (old("absensi.{$siswa->id}", $existingData['status'] ?? '') == 'alfa') ? 'selected' : '' }}>Alfa</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="keterangan[{{ $siswa->id }}]" 
                                                           class="form-control form-control-sm" 
                                                           value="{{ old("keterangan.{$siswa->id}", $existingData['keterangan'] ?? '') }}"
                                                           placeholder="Keterangan (opsional)">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save"></i> Update Laporan KBM & Absensi
                    </button>
                    <a href="{{ route('laporan.riwayat') }}" class="btn btn-secondary btn-lg">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection