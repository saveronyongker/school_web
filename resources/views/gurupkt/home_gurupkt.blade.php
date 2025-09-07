@extends('layouts.layout_guru')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-piket text-white rounded-4 shadow-lg border-0">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1 class="display-5 fw-bold mb-2 text-utama">
                                <i class="bi bi-shield-check me-3"></i>Dashboard Guru Piket
                            </h1>
                            <p class="lead mb-0 text-utama">
                                <i class="bi bi-calendar-event me-2"></i>
                                Monitoring Laporan KBM - {{ today()->format('l, d F Y') }}
                            </p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="d-flex justify-content-md-end">
                                <div class="avatar avatar-xl text-utama d-flex align-items-center justify-content-center">
                                    <i class="bi bi-person-badge fs-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card actor-card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Laporan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalLaporan }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-journal fs-2 text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card actor-card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Belum Dikonfirmasi
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $belumDikonfirmasi }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-clock-history fs-2 text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card actor-card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Dikonfirmasi
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $dikonfirmasi }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-check-circle fs-2 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card actor-card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Ditolak
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $ditolak }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-x-circle fs-2 text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter dan Tabel -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-table me-2"></i>Monitoring Laporan KBM Hari Ini
                    </h6>
                    
                    <!-- Filter Status -->
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle btn-sm" 
                                type="button" 
                                id="filterDropdown" 
                                data-bs-toggle="dropdown">
                            <i class="bi bi-funnel me-1"></i>
                            Filter: {{ ucfirst(str_replace('_', ' ', $statusFilter)) }}
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('piket.dashboard', ['status' => 'semua']) }}">
                                Semua Laporan
                            </a>
                            <a class="dropdown-item" href="{{ route('piket.dashboard', ['status' => 'belum_dikonfirmasi']) }}">
                                Belum Dikonfirmasi
                            </a>
                            <a class="dropdown-item" href="{{ route('piket.dashboard', ['status' => 'dikonfirmasi']) }}">
                                Dikonfirmasi
                            </a>
                            <a class="dropdown-item" href="{{ route('piket.dashboard', ['status' => 'ditolak']) }}">
                                Ditolak
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    @if ($laporanHariIni->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-journal-x fs-1 text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada laporan KBM hari ini</h5>
                            <p class="text-muted">Silakan tunggu guru mengisi laporan.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Guru</th>
                                        <th>Kelas</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Topik</th>
                                        <th>Jam</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($laporanHariIni as $index => $l)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="me-2 text-primary d-flex align-items-center justify-content-center">
                                                        <i class="bi bi-person"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold">{{ $l->guru->name }}</div>
                                                        <small class="text-muted">{{ $l->guru->nip }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $l->kelas }}</td>
                                            <td>{{ $l->mata_pelajaran }}</td>
                                            <td>{{ Str::limit($l->topik, 30) }}</td>
                                            <td>{{ $l->jam_mulai }} - {{ $l->jam_selesai }}</td>
                                            <td>
                                                @if ($l->status == 'dikonfirmasi')
                                                    <span class="badge text-success">
                                                        <i class="bi bi-check-circle me-1"></i>Dikonfirmasi
                                                    </span>
                                                @elseif ($l->status == 'ditolak')
                                                    <span class="badge text-danger">
                                                        <i class="bi bi-x-circle me-1"></i>Ditolak
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning text-dark">
                                                        <i class="bi bi-clock-history me-1"></i>Belum
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($l->status == 'belum_dikonfirmasi')
                                                    <!-- Form Konfirmasi -->
                                                    <form action="{{ route('piket.konfirmasi', $l->id) }}" 
                                                          method="POST" 
                                                          class="d-inline mb-1">
                                                        @csrf
                                                        <textarea name="catatan_piket" 
                                                                  class="form-control form-control-sm mb-1" 
                                                                  placeholder="Catatan (opsional)"
                                                                  style="width: 150px;"></textarea>
                                                        <button type="submit" 
                                                                class="btn btn-success btn-sm "
                                                                onclick="return confirm('✅ Yakin ingin KONFIRMASI laporan ini?')">
                                                            <i class="bi bi-check-circle"></i> Konfirmasi
                                                        </button>
                                                    </form>

                                                    <!-- Form Tolak -->
                                                    <button type="button" 
                                                            class="btn btn-danger btn-sm mt-1"
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#tolakModal{{ $l->id }}">
                                                        <i class="bi bi-x-circle"></i> Tolak
                                                    </button>

                                           
                                                    <button type="button" 
                                                            class="btn btn-primary btn-sm mt-1" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#detailModal{{ $l->id }}">
                                                        <i class="bi bi-eye me-1"></i> Detail Laporan
                                                    </button>
                                                       

                                                    <!-- Modal Tolak -->
                                                    <div class="modal fade" id="tolakModal{{ $l->id }}" tabindex="-1">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-danger text-white">
                                                                    <h5 class="modal-title">Konfirmasi Penolakan</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                </div>
                                                                <form action="{{ route('piket.tolak', $l->id) }}" method="POST">
                                                                    @csrf
                                                                    <div class="modal-body">
                                                                        <p>⚠️ Yakin ingin MENOLAK laporan ini?</p>
                                                                        <p><strong>{{ $l->guru->name }}</strong> - {{ $l->kelas }}</p>
                                                                        
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Catatan Penolakan</label>
                                                                            <textarea name="catatan_piket" 
                                                                                      class="form-control" 
                                                                                      rows="3" 
                                                                                      placeholder="Berikan alasan penolakan..."></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                        <button type="submit" class="btn btn-danger">
                                                                            <i class="bi bi-x-circle"></i> Ya, Tolak
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Modal detail Laporan -->
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
                                                @else
                                                    <span class="text-muted">Sudah diproses</span>
                                                @endif
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
    </div>

    <!-- Info Footer -->
    <div class="row">
        <div class="col-12">
            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>
                <strong>Info:</strong> Laporan hanya tersedia untuk hari ini ({{ today()->format('d F Y') }}). 
                Setelah pukul 24:00, laporan akan hilang dari tampilan ini secara otomatis.
            </div>
        </div>
    </div>
</div>
@endsection