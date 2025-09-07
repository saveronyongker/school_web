@extends('layouts.layout_guru')

@section('content')
<div class="container my-4">
    
    <!-- Pilihan Aksi -->
    <div class="row">
        <div class="col-12">
            <h3 class="mb-4">Pilih Tugas Hari Ini</h3>
        </div>

        <!-- Card 1: Isi Absensi -->
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow border-0">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-center"><i class="bi bi-people fs-2"></i> Isi Absensi Siswa</h5>
                    <p class="card-text text-center text-muted">
                        Catat kehadiran siswa di kelas Anda hari ini.
                    </p>
                    <div class="mt-auto text-center">
                        <a href="{{ route('absensi.index') }}" class="btn btn-warning w-100">
                            <i class="bi bi-people me-2"></i>Mulai Absensi
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Isi Laporan KBM -->
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow border-0">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-center"><i class="bi bi-journal-text fs-2"></i> Isi Laporan KBM</h5>
                    <p class="card-text text-center text-muted">
                        Laporkan kegiatan belajar mengajar hari ini.
                    </p>
                    <div class="mt-auto text-center">
                        <a href="{{ route('gurumapel.isi_laporan') }}" class="btn btn-primary w-100">
                            <i class="bi bi-journal-text me-2"></i>Mulai Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Isi Keduanya Sekaligus (Opsional) -->
        <div class="col-md-12 mb-4">
            <div class="card bg-light shadow border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-md bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3">
                            <i class="bi bi-check-all"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="card-title mb-1">✅ Isi Keduanya Sekaligus</h5>
                            <p class="card-text mb-0 text-muted">
                                Absen siswa dan buat laporan KBM dalam satu alur.
                            </p>
                        </div>
                        <div>
                            <div class="btn-group" role="group">
                                <a href="{{ route('absensi.index') }}?next=laporan" class="btn btn-success">
                                    <i class="bi bi-arrow-right-circle me-1"></i>Absen → Laporan
                                </a>
                                <a href="{{ route('laporan.create') }}?next=absen" class="btn btn-success">
                                    <i class="bi bi-arrow-left-circle me-1"></i>Laporan → Absen
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Footer -->
    <div class="row">
        <div class="col-12">
            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>
                <strong>Info:</strong> Pilih salah satu tugas di atas untuk memulai. 
                Anda juga bisa mengisi keduanya secara berurutan.
            </div>
        </div>
    </div>
</div>
@endsection
