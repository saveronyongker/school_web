@extends('layouts.layout_admin')

@section('title', 'Dashboard')

@section('content')

    <div class="container-fluid my-4 py-4 bg-utama shadow rounded-4">
        <h2 class="mb-4 fw-semibold">Dashboard Admin</h2>

        <!-- Statistik Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5>Total Guru</h5>
                        <h2>{{ $totalGuru }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5>Laporan Hari Ini</h5>
                        <h2>{{ $laporanHariIni }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-warning text-dark">
                    <div class="card-body">
                        <h5>Guru Piket Hari Ini</h5>
                        <h2>{{ $guruPiketHariIni->count() }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5>Informasi Terbaru</h5>
                        <h2>{{ $informasiTerbaru->count() }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Guru Piket Hari Ini -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Guru Piket Hari Ini</h5>
                    </div>
                    <div class="card-body">
                        @if ($guruPiketHariIni->isEmpty())
                            <p class="text-muted">Tidak ada guru piket hari ini.</p>
                        @else
                            <div class="row">
                                @foreach ($guruPiketHariIni as $piket)
                                    <div class="col-md-4 mb-2">
                                        <div class="border rounded p-2">
                                            <strong>{{ $piket->guru->name }}</strong><br>
                                            <small>{{ $piket->guru->mata_pelajaran }}</small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Laporan Terbaru -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Laporan KBM Terbaru</h5>
                    </div>
                    <div class="card-body">
                        @if ($laporanTerbaru->isEmpty())
                            <p class="text-muted">Belum ada laporan.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Guru</th>
                                            <th>Kelas</th>
                                            <th>Mata Pelajaran</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($laporanTerbaru as $l)
                                            <tr>
                                                <td>{{ $l->guru->name }}</td>
                                                <td>{{ $l->kelas }}</td>
                                                <td>{{ $l->mata_pelajaran }}</td>
                                                <td>{{ \Carbon\Carbon::parse($l->tanggal)->format('d M Y') }}</td>
                                                <td>
                                                    @if ($l->status == 'dikonfirmasi')
                                                        <span class="badge bg-success">Dikonfirmasi</span>
                                                    @elseif ($l->status == 'ditolak')
                                                        <span class="badge bg-danger">Ditolak</span>
                                                    @else
                                                        <span class="badge bg-warning">Belum</span>
                                                    @endif
                                                    <button type="button" 
                                                            class="btn btn-primary btn-sm mt-1" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#detailModal{{ $l->id }}">
                                                        <i class="bi bi-eye me-1"></i> Detail
                                                    </button>
                                                    <div class="modal fade" id="detailModal{{ $l->id }}" tabindex="-1" aria-labelledby="detailModal{{ $l->id }}Label" aria-hidden="true">
                                                        <div class="modal-dialog modal-xl">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-gradient-primary text-white">
                                                                    <h5 class="modal-title" id="detailModal{{ $l->id }}Label">
                                                                        <i class="bi bi-journal-text me-2"></i>Detail Laporan KBM
                                                                    </h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <!-- Info Laporan -->
                                                                    <div class="row mb-4">
                                                                        <div class="col-md-6">
                                                                            <table class="table table-sm">
                                                                                <tr>
                                                                                    <th>Tanggal</th>
                                                                                    <td>{{ \Carbon\Carbon::parse($l->tanggal)->format('d M Y') }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th>Kelas</th>
                                                                                    <td>{{ $l->kelas->nama_kelas ?? $l->kelas ?? 'Kelas tidak ditemukan' }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th>Mata Pelajaran</th>
                                                                                    <td>{{ $l->mata_pelajaran ?? '-' }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th>Topik</th>
                                                                                    <td>{{ $l->topik ?? '-' }}</td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <table class="table table-sm">
                                                                                <tr>
                                                                                    <th>Jam Mengajar</th>
                                                                                    <td>{{ $l->jam_mulai ?? '-' }} - {{ $l->jam_selesai ?? '-' }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th>Status</th>
                                                                                    <td>
                                                                                        @switch($l->status ?? 'belum_dikonfirmasi')
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
                                                                                    <th>Dikonfirmasi Oleh</th>
                                                                                    <td>{{ $l->guruPiket?->name ?? '-' }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th>Catatan Piket</th>
                                                                                    <td>{{ $l->catatan_piket ?? '-' }}</td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Kegiatan -->
                                                                    <div class="mb-4">
                                                                        <h6><i class="bi bi-book me-2"></i>Kegiatan Pembelajaran</h6>
                                                                        <div class="border rounded p-3 bg-light">
                                                                            @if($l->kegiatan)
                                                                                {!! nl2br(e($l->kegiatan)) !!}
                                                                            @else
                                                                                <span class="text-muted">Tidak ada kegiatan yang dicatat</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>

                                                                    <!-- File Materi -->
                                                                    @if ($l->file_materi)
                                                                        <div class="mb-4">
                                                                            <h6><i class="bi bi-file-earmark-text me-2"></i>File Materi</h6>
                                                                            <a href="{{ asset('storage/' . $l->file_materi) }}" 
                                                                            class="btn btn-outline-primary btn-sm" 
                                                                            target="_blank">
                                                                                <i class="bi bi-download me-1"></i>
                                                                                {{ $l->nama_file ?? 'Download Materi' }}
                                                                            </a>
                                                                        </div>
                                                                    @endif

                                                                    <!-- Absensi Siswa -->
                                                                    <div class="mb-4">
                                                                        <h6><i class="bi bi-people me-2"></i>Absensi Siswa</h6>
                                                                        
                                                                        @php
                                                                            $absensiList = $l->absensiSiswa ?? collect();
                                                                        @endphp

                                                                        @if ($absensiList->isEmpty())
                                                                            <div class="alert alert-info">
                                                                                <i class="bi bi-info-circle me-2"></i>
                                                                                Tidak ada data absensi untuk laporan ini.
                                                                            </div>
                                                                        @else
                                                                            <div class="table-responsive">
                                                                                <table class="table table-bordered table-sm">
                                                                                    <thead class="table-light">
                                                                                        <tr>
                                                                                            <th width="5%">No</th>
                                                                                            <th width="25%">Nama Siswa</th>
                                                                                            <th width="15%">NIS</th>
                                                                                            <th width="15%" class="text-center">Status</th>
                                                                                            <th width="20%">Keterangan</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        @forelse ($absensiList as $index => $absen)
                                                                                            <tr>
                                                                                                <td>{{ $index + 1 }}</td>
                                                                                                <td>
                                                                                                    {{ $absen->siswa->nama ?? 'Siswa tidak ditemukan' }} 
                                                                                                    @if($absen->siswa)
                                                                                                        <small class="text-muted">({{ $absen->siswa->nis ?? '-' }})</small>
                                                                                                    @endif
                                                                                                </td>
                                                                                                <td>{{ $absen->siswa->nis ?? '-' }}</td>
                                                                                                <td class="text-center">
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
                                                                                        @empty
                                                                                            <tr>
                                                                                                <td colspan="5" class="text-center">Tidak ada data absensi</td>
                                                                                            </tr>
                                                                                        @endforelse
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>

                                                                            @php
                                                                                $totalSiswa = $l->absensiSiswa->count();
                                                                                $hadir = $l->absensiSiswa->where('status', 'hadir')->count();
                                                                                $izin = $l->absensiSiswa->where('status', 'izin')->count();
                                                                                $sakit = $l->absensiSiswa->where('status', 'sakit')->count();
                                                                                $alfa = $l->absensiSiswa->where('status', 'alfa')->count();
                                                                            @endphp

                                                                            <!-- Statistik Absensi -->
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
                                                                <div class="modal-footer">
                                                                    <!-- Perbaiki Logic Edit Button -->
                                                                    @php
                                                                        $isToday = \Carbon\Carbon::parse($l->tanggal)->isToday();
                                                                    @endphp
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                                        <i class="bi bi-x-circle me-1"></i> Tutup
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Informasi Terbaru -->
            <!-- <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Informasi Sekolah Terbaru</h5>
                    </div>
                    <div class="card-body">
                        @if ($informasiTerbaru->isEmpty())
                            <p class="text-muted">Belum ada informasi.</p>
                        @else
                            @foreach ($informasiTerbaru as $info)
                                <div class="mb-3 pb-2 border-bottom">
                                    <h6>{{ $info->judul }}</h6>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($info->tanggal)->format('d M Y') }}</small>
                                    <p class="mb-1">{{ Str::limit($info->isi, 100) }}</p>
                                    <a href="{{ route('kepsek.informasi.show', $info->id) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div> -->
        </div>
    </div>
    
@endsection