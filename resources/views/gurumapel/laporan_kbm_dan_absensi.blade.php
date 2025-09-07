@extends('layouts.layout_guru')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Laporan KBM & Absensi Siswa</h2>
            
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

            <!-- ✅ Form Utama - Tambahkan id untuk JavaScript -->
            <form action="{{ route('laporan.store.dan.absen') }}" method="POST" enctype="multipart/form-data" id="laporanForm">
                @csrf
                
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
                                                    {{ (old('kelas_id', $formData['kelas_id'] ?? request('kelas_id')) == $kelas->id || (isset($kelasDipilih) && $kelasDipilih && $kelasDipilih->id == $kelas->id)) ? 'selected' : '' }}>
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
                                           value="{{ date('d F Y') }}" readonly>
                                    <!-- Hidden input untuk mengirim tanggal ke controller -->
                                    <input type="hidden" name="tanggal" value="{{ date('Y-m-d') }}">
                                    <small class="form-text text-muted">Tanggal otomatis hari ini</small>
                                </div>
                            </div>
                            
                            <!-- ✅ HAPUS required dari field lain -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="mata_pelajaran">Mata Pelajaran</label>
                                    <input type="text" name="mata_pelajaran" id="mata_pelajaran" class="form-control" 
                                           value="{{ old('mata_pelajaran', $formData['mata_pelajaran'] ?? '') }}" placeholder="Contoh: Matematika">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="jam_mulai">Jam Mulai</label>
                                    <input type="number" name="jam_mulai" id="jam_mulai" class="form-control" 
                                           value="{{ old('jam_mulai', $formData['jam_mulai'] ?? '') }}" min="1" max="12" placeholder="1-12">
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="jam_selesai">Jam Selesai</label>
                                    <input type="number" name="jam_selesai" id="jam_selesai" class="form-control" 
                                           value="{{ old('jam_selesai', $formData['jam_selesai'] ?? '') }}" min="1" max="12" placeholder="1-12">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="topik">Topik</label>
                                    <input type="text" name="topik" id="topik" class="form-control" 
                                           value="{{ old('topik', $formData['topik'] ?? '') }}" placeholder="Topik pembelajaran hari ini">
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label for="kegiatan">Kegiatan Pembelajaran</label>
                            <textarea name="kegiatan" id="kegiatan" class="form-control" rows="4" placeholder="Deskripsikan kegiatan pembelajaran yang dilakukan...">{{ old('kegiatan', $formData['kegiatan'] ?? '') }}</textarea>
                        </div>
                        
                        <div class="form-group mt-3">
                            <label for="file_materi">File Materi (Opsional)</label>
                            <input type="file" name="file_materi" id="file_materi" class="form-control">
                            <small class="form-text text-muted">Format: DOC, DOCX, PDF (max 5MB)</small>
                        </div>
                    </div>   
                </div>

                <!-- Bagian 2: Load Siswa dengan Form Submission -->
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0"><i class="fas fa-users"></i> Absensi Siswa</h4>
                            <!-- Tombol Load Siswa TANPA validasi -->
                            <button type="submit" 
                                    formaction="{{ route('laporan.load.siswa') }}" 
                                    class="btn btn-light btn-sm"
                                    id="loadSiswaBtn">
                                <i class="fas fa-sync-alt"></i> Load Data Siswa
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> 
                            Pilih kelas di atas, lalu klik "Load Data Siswa" untuk menampilkan daftar siswa
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="25%">Nama Siswa</th>
                                        <th width="15%">NIS</th>
                                        <th width="20%">Status</th>
                                        <th width="35%">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($siswaList) && $siswaList->count() > 0)
                                        @foreach($siswaList as $index => $siswa)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $siswa->nama }}</td>
                                                <td>{{ $siswa->nis }}</td>
                                                <td>
                                                    <select name="absensi[{{ $siswa->id }}]" class="form-control form-control-sm">
                                                        <option value="">Pilih Status</option>
                                                        <option value="hadir" {{ old("absensi.{$siswa->id}", "") == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                                        <option value="izin" {{ old("absensi.{$siswa->id}", "") == 'izin' ? 'selected' : '' }}>Izin</option>
                                                        <option value="sakit" {{ old("absensi.{$siswa->id}", "") == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                                        <option value="alfa" {{ old("absensi.{$siswa->id}", "") == 'alfa' ? 'selected' : '' }}>Alfa</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="keterangan[{{ $siswa->id }}]" 
                                                           class="form-control form-control-sm" 
                                                           value="{{ old("keterangan.{$siswa->id}", "") }}"
                                                           placeholder="Keterangan (opsional)">
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                <div class="py-4">
                                                    <i class="fas fa-users fa-2x text-muted mb-2"></i>
                                                    <p class="mb-0">
                                                        @if(request('kelas_id') || old('kelas_id'))
                                                            Tidak ada siswa di kelas ini
                                                        @else
                                                            Pilih kelas dan klik "Load Data Siswa" untuk menampilkan daftar siswa
                                                        @endif
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Tombol Submit dengan Validasi -->
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="{{ route('gurumapel.home_gurumapel') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('laporanForm');
    const loadSiswaBtn = document.getElementById('loadSiswaBtn');
    const submitBtn = document.getElementById('submitBtn');
    
    if (form && loadSiswaBtn) {
        // Tambahkan validasi khusus untuk tombol submit
        form.addEventListener('submit', function(e) {
            const submitter = e.submitter || document.activeElement;
            
            // Jika tombol load siswa, jangan validasi
            if (submitter === loadSiswaBtn) {
                // Hapus atribut required sementara
                const requiredFields = form.querySelectorAll('[required]');
                requiredFields.forEach(field => {
                    field.removeAttribute('required');
                });
                
                // Kembalikan required setelah submit
                setTimeout(() => {
                    requiredFields.forEach(field => {
                        if (field.id !== 'kelas_id') { // Kelas tetap required untuk load
                            field.setAttribute('required', 'required');
                        }
                    });
                }, 100);
                
                return true; // Izinkan submit
            }
            
            // Jika tombol simpan, tambahkan validasi
            if (submitter === submitBtn) {
                // Tambahkan required ke field yang diperlukan
                const mataPelajaran = document.getElementById('mata_pelajaran');
                const topik = document.getElementById('topik');
                const kegiatan = document.getElementById('kegiatan');
                const jamMulai = document.getElementById('jam_mulai');
                const jamSelesai = document.getElementById('jam_selesai');
                
                if (mataPelajaran) mataPelajaran.setAttribute('required', 'required');
                if (topik) topatik.setAttribute('required', 'required');
                if (kegiatan) kegiatan.setAttribute('required', 'required');
                if (jamMulai) jamMulai.setAttribute('required', 'required');
                if (jamSelesai) jamSelesai.setAttribute('required', 'required');
                
                // Tampilkan loading
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
                submitBtn.disabled = true;
            }
        });
    }
});
</script>
@endpush