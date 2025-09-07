@extends('layouts.layout_kepsek')

@section('content')
<div class="container-fluid py-4">
    <h2>Statistik & Rekap Laporan</h2>

    <div class="row">
        <!-- Rekap Bulanan -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Rekap Laporan Bulanan (6 Bulan Terakhir)</h5>
                </div>
                <div class="card-body">
                    @if ($rekapBulanan->isEmpty())
                        <p class="text-muted">Belum ada data statistik.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Bulan</th>
                                        <th>Total Laporan</th>
                                        <th>Dikonfirmasi</th>
                                        <th>Ditolak</th>
                                        <th>Pending</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rekapBulanan as $rekap)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::create($rekap->tahun, $rekap->bulan, 1)->isoFormat('MMMM Y') }}</td>
                                            <td>{{ $rekap->total_laporan }}</td>
                                            <td>{{ $rekap->dikonfirmasi }}</td>
                                            <td>{{ $rekap->ditolak }}</td>
                                            <td>{{ $rekap->total_laporan - $rekap->dikonfirmasi - $rekap->ditolak }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Top Guru -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Top 10 Guru Aktif</h5>
                </div>
                <div class="card-body">
                    @if ($statistikGuru->isEmpty())
                        <p class="text-muted">Belum ada data.</p>
                    @else
                        <ol>
                            @foreach ($statistikGuru as $g)
                                <li class="mb-2">
                                    <strong>{{ $g->name }}</strong><br>
                                    <small>{{ $g->mata_pelajaran }}</small><br>
                                    <span class="badge bg-primary">{{ $g->total_laporan }} laporan</span>
                                </li>
                            @endforeach
                        </ol>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('kepsek.dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
    </div>
</div>
@endsection