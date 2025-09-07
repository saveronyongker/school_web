@extends('layouts.layout_guru')

@section('content')
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Detail Laporan KBM</h2>
        <a href="{{ route('laporan.riwayat') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-header bg-gradient-primary text-white">
            <h4>{{ $laporan->mata_pelajaran ?? 'Mata Pelajaran' }} - {{ $laporan->kelas->nama_kelas ?? $laporan->kelas ?? 'Kelas' }}</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-sm">
                        <tr>
                            <th>Tanggal:</th>
                            <td>{{ \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <th>Jam Mengajar:</th>
                            <td>{{ $laporan->jam_mulai ?? '-' }} - {{ $laporan->jam_selesai ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Topik:</th>
                            <td>{{ $laporan->topik ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-sm">
                        <tr>
                            <th>Status:</th>
                            <td>
                                @switch($laporan->status ?? 'belum_dikonfirmasi')
                                    @case('dikonfirmasi')
                                        <span class="badge bg-success">Dikonfirmasi</span>
                                        @break
                                    @case('ditolak')
                                        <span class="badge bg-danger">Ditolak</span>
                                        @break
                                    @default
                                        <span class="badge bg-warning text-dark">Belum Dikonfirmasi</span>
                                @endswitch
                            </td>
                        </tr>
                        <tr>
                            <th>Dikonfirmasi Oleh:</th>
                            <td>{{ $laporan->guruPiket?->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Piket:</th>
                            <td>{{ $laporan->catatan_piket ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="mb-4">
                <h5><i class="bi bi-book me-2"></i>Kegiatan Pembelajaran</h5>
                <div class="border rounded p-3 bg-light">
                    @if($laporan->kegiatan)
                        {!! nl2br(e($laporan->kegiatan)) !!}
                    @else
                        <span class="text-muted">Tidak ada kegiatan yang dicatat</span>
                    @endif
                </div>
            </div>

            @if($laporan->file_materi)
                <div class="mb-4">
                    <h5><i class="bi bi-file-earmark-text me-2"></i>File Materi</h5>
                    <a href="{{ asset('storage/' . $laporan->file_materi) }}" 
                       class="btn btn-outline-primary" 
                       target="_blank">
                        <i class="bi bi-download me-1"></i>
                        {{ $laporan->nama_file ?? 'Download Materi' }}
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Absensi Siswa -->
    <div class="card mt-4">
        <div class="card-header bg-gradient-success text-white">
            <h4><i class="bi bi-people me-2"></i>Absensi Siswa</h4>
        </div>
        <div class="card-body">
            @php
                $absensiList = $laporan->absensiSiswa ?? collect();
                $hadir = $absensiList->where('status', 'hadir')->count();
                $izin = $absensiList->where('status', 'izin')->count();
                $sakit = $absensiList->where('status', 'sakit')->count();
                $alfa = $absensiList->where('status', 'alfa')->count();
            @endphp

            @if ($absensiList->isEmpty())
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    Tidak ada data absensi untuk laporan ini.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>NIS</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($absensiList as $index => $absen)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $absen->siswa->nama ?? 'Siswa tidak ditemukan' }}</td>
                                    <td>{{ $absen->siswa->nis ?? '-' }}</td>
                                    <td>
                                        @switch($absen->status ?? 'alfa')
                                            @case('hadir')
                                                <span class="badge bg-success">Hadir</span>
                                                @break
                                            @case('izin')
                                                <span class="badge bg-warning text-dark">Izin</span>
                                                @break
                                            @case('sakit')
                                                <span class="badge bg-info">Sakit</span>
                                                @break
                                            @default
                                                <span class="badge bg-danger">Alfa</span>
                                        @endswitch
                                    </td>
                                    <td>{{ $absen->keterangan ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Statistik -->
                <div class="row mt-3">
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $hadir }}</h5>
                                <p class="card-text small mb-0">Hadir</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-dark">
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $izin }}</h5>
                                <p class="card-text small mb-0">Izin</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-info text-white">
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $sakit }}</h5>
                                <p class="card-text small mb-0">Sakit</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-danger text-white">
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $alfa }}</h5>
                                <p class="card-text small mb-0">Alfa</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="mt-4">
        @php
            $isToday = \Carbon\Carbon::parse($laporan->tanggal)->isToday();
        @endphp
        
        @if ($isToday)
            <a href="{{ route('laporan.edit', $laporan->id) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-1"></i> Edit Laporan
            </a>
        @endif
        
        <a href="{{ route('laporan.riwayat') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Riwayat
        </a>
    </div>
</div>
@endsection