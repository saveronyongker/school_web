@extends('layouts.layout_guru')

@section('content')
   
<div class="container my-4 p-4 bg-utama rounded-4 shadow-costum border border-secondary-subtle">
    <!-- Header Welcome -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-guru text-white shadow-lg border-0 rounded-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1 class="display-5 fw-bold mb-2">Selamat Datang, {{ Auth::user()->name }}!</h1>
                            <p class="lead mb-0">
                                <i class="bi bi-calendar-event me-2"></i>
                                {{ now()->format('l, d F Y') }}
                            </p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="d-flex justify-content-md-end">
                                <div class="avatar avatar-xl rounded-circle text-light d-flex align-items-center justify-content-center">
                                    <i class="bi bi-person-fill fs-1"></i>
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
            <div class="card actor-card border-left-primary h-100 py-2">
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
            <div class="card actor-card border-left-success h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Bulan Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $laporanBulanIni }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-calendar-month fs-2 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card actor-card border-left-info h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Dikonfirmasi
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $laporanDikonfirmasi }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-check-circle fs-2 text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            @if ($isPiketHariIni)
                <div class="card actor-card border-left-warning h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Tugas Piket
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <i class="bi bi-shield-check"></i> Hari Ini
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-shield-lock fs-2 text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="card border-left-secondary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                    Tidak Piket
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Hari Ini</div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-calendar-x fs-2 text-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Action Cards -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-lightning me-2"></i>Aksi Cepat
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('laporan.create.gabungan') }}" class="btn btn-primary btn-lg w-100">
                                <i class="bi bi-journal-plus fs-4 d-block mb-2"></i>
                                <span>Buat Laporan KBM</span>
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('laporan.riwayat') }}" class="btn btn-info btn-lg w-100">
                                <i class="bi bi-journal-text fs-4 d-block mb-2"></i>
                                <span>Riwayat Laporan</span>
                            </a>
                        </div>
                        @if ($isPiketHariIni)
                            <div class="col-md-6 mb-3">
                                <a href="{{ route('piket.dashboard') }}" class="btn btn-warning btn-lg w-100">
                                    <i class="bi bi-shield-check fs-4 d-block mb-2"></i>
                                    <span>Dashboard Piket</span>
                                </a>
                            </div>
                        @endif
                        <div class="col-md-6 mb-3">
                            <a href="#" class="btn btn-success btn-lg w-100">
                                <i class="bi bi-calendar fs-4 d-block mb-2"></i>
                                <span>Jadwal Mengajar</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-clock-history me-2"></i>Aktivitas Terbaru
                    </h6>
                </div>
                <div class="card-body">
                    @if ($laporanTerbaru->count() > 0)
                        <div class="list-group">
                            @foreach ($laporanTerbaru as $l)
                                <div class="list-group-item list-group-item-action">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <i class="bi bi-journal-text text-primary"></i>
                                        </div>
                                        <div class="col">
                                            <div class="text-sm font-weight-bold">
                                                {{ $l->kelas }} - {{ $l->mata_pelajaran }}
                                            </div>
                                            <div class="small text-gray-500">
                                                {{ \Carbon\Carbon::parse($l->tanggal)->format('d M Y') }}
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            @if ($l->status == 'dikonfirmasi')
                                                <span class="badge bg-success">Dikonfirmasi</span>
                                            @elseif ($l->status == 'ditolak')
                                                <span class="badge bg-danger">Ditolak</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Belum</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-journal-x fs-1 text-muted mb-3"></i>
                            <p class="text-muted">Belum ada aktivitas</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Today's Task -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-calendar-day me-2"></i>Tugas Hari Ini
                    </h6>
                </div>
                <div class="card-body">
                    @if ($laporanBelum)
                        <div class="alert alert-warning">
                            <h5 class="alert-heading">
                                <i class="bi bi-exclamation-triangle me-2"></i>Perhatian!
                            </h5>
                            <p>Anda belum mengisi laporan KBM hari ini.</p>
                            <a href="{{ route('laporan.create.gabungan') }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-journal-plus me-1"></i>Isi Sekarang
                            </a>
                        </div>
                    @else
                        <div class="text-center">
                            <i class="bi bi-check-circle-fill text-success fs-1 mb-3"></i>
                            <h5 class="text-success">Tugas Selesai!</h5>
                            <p class="text-muted">Anda sudah mengisi laporan KBM hari ini.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Links -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-link-45deg me-2"></i>Tautan Cepat
                    </h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="bi bi-mortarboard me-2"></i>Materi Pembelajaran
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="bi bi-people me-2"></i>Kelas Virtual
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="bi bi-file-earmark-text me-2"></i>Silabus
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="bi bi-question-circle me-2"></i>Bantuan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
   
@endsection