@extends('layouts.layout_kepsek')

@section('content')
<div class="container-fluid py-4">
    <h2>Laporan KBM Semua Guru</h2>

    <!-- Search Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('kepsek.laporan.index') }}">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <input type="text" name="search" class="form-control" 
                               placeholder="Cari guru, mata pelajaran, kelas..." 
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2 mb-3">
                        <input type="date" name="tanggal_dari" class="form-control" 
                               value="{{ request('tanggal_dari') }}">
                    </div>
                    <div class="col-md-2 mb-3">
                        <input type="date" name="tanggal_sampai" class="form-control" 
                               value="{{ request('tanggal_sampai') }}">
                    </div>
                    <div class="col-md-2 mb-3">
                        <select name="status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="dikonfirmasi" {{ request('status') == 'dikonfirmasi' ? 'selected' : '' }}>Dikonfirmasi</option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            <option value="belum_dikonfirmasi" {{ request('status') == 'belum_dikonfirmasi' ? 'selected' : '' }}>Belum</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <button type="submit" class="btn btn-primary">Cari</button>
                        <a href="{{ route('kepsek.laporan.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="card-body">
            @if ($laporan->isEmpty())
                <div class="alert alert-info">Tidak ada laporan yang ditemukan.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Guru</th>
                                <th>Kelas</th>
                                <th>Mata Pelajaran</th>
                                <th>Topik</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($laporan as $l)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($l->tanggal)->format('d/m/Y') }}</td>
                                    <td>{{ $l->guru->name }}</td>
                                    <td>{{ $l->kelas }}</td>
                                    <td>{{ $l->mata_pelajaran }}</td>
                                    <td>{{ Str::limit($l->topik, 30) }}</td>
                                    <td>
                                        @if ($l->status == 'dikonfirmasi')
                                            <span class="badge bg-success">Dikonfirmasi</span>
                                        @elseif ($l->status == 'ditolak')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Belum</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('kepsek.laporan.show', $l->id) }}" class="btn btn-sm btn-info">Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $laporan->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection