@extends('layouts.layout_guru')

@section('content')
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Riwayat Laporan KBM</h2>
        <a href="{{ route('laporan.create.gabungan') }}" class="btn btn-primary">
            <i class="bi bi-journal-plus me-1"></i>Buat Laporan Baru
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($laporan->isEmpty())
        <div class="alert alert-info text-center">
            <i class="bi bi-info-circle me-2"></i>
            Belum ada laporan KBM yang dibuat.
        </div>
        
        <!-- <div class="text-center mt-4">
            <a href="{{ route('laporan.create.gabungan') }}" class="btn btn-primary">
                <i class="bi bi-journal-plus me-1"></i>Buat Laporan Pertama
            </a>
        </div> -->
    @else
        <!-- Grid Card Laporan -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($laporan as $l)
                <div class="col">
                    <div class="card h-100 shadow-sm border-0">
                        <!-- Header Card -->
                        <div class="card-header bg-gradient-primary text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    {{ $l->kelas->nama_kelas ?? $l->kelas ?? 'Kelas tidak ditemukan' }}
                                </h5>
                                <span class="badge bg-light text-dark">
                                    {{ \Carbon\Carbon::parse($l->tanggal)->format('d M Y') }}
                                </span>
                            </div>
                        </div>

                        <!-- Body Card -->
                        <div class="card-body">
                            <h6 class="card-title">{{ $l->mata_pelajaran ?? 'Mata pelajaran tidak tersedia' }}</h6>
                            <p class="card-text">
                                <strong>Topik:</strong> {{ Str::limit($l->topik ?? '-', 50) }}<br>
                                <strong>Kegiatan:</strong> {{ Str::limit($l->kegiatan ?? '-', 80) }}
                            </p>

                            <!-- Info Absensi -->
                            @php
                                $absensiCollection = $l->absensiSiswa ?? collect();
                                $totalSiswa = $absensiCollection->count();
                                $hadir = $absensiCollection->where('status', 'hadir')->count();
                                $izin = $absensiCollection->where('status', 'izin')->count();
                                $sakit = $absensiCollection->where('status', 'sakit')->count();
                                $alfa = $absensiCollection->where('status', 'alfa')->count();
                            @endphp

                            <div class="d-flex justify-content-between small text-muted">
                                <span>
                                    <i class="bi bi-people me-1"></i>
                                    {{ $totalSiswa }} siswa
                                </span>
                                <span>
                                    <i class="bi bi-check-circle me-1 text-success"></i>
                                    {{ $hadir }} hadir
                                </span>
                                <span>
                                    <i class="bi bi-x-circle me-1 text-danger"></i>
                                    {{ $alfa }} alfa
                                </span>
                            </div>

                            <!-- Status Laporan -->
                            <div class="mt-3">
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
                            </div>
                        </div>

                        <!-- Footer Card -->
                        <div class="card-footer bg-white">
                            <div class="d-grid gap-2">
                                <button type="button" 
                                        class="btn btn-primary btn-sm" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#detailModal{{ $l->id }}">
                                    <i class="bi bi-eye me-1"></i> Detail Laporan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Detail Laporan -->
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
                                        // ✅ Validasi absensi dengan aman
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

                                @if ($isToday)
                                    <a href="{{ route('laporan.edit', $l->id) }}" class="btn btn-warning">
                                        <i class="bi bi-pencil me-1"></i> Edit
                                    </a>
                                @else
                                    <span class="text-muted small">Hanya bisa edit laporan hari ini</span>
                                @endif

                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="bi bi-x-circle me-1"></i> Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $laporan->links() }}
        </div>
    @endif
</div>
@endsection