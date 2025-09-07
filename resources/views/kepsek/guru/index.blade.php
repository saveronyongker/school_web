@extends('layouts.layout_kepsek')

@section('content')
<div class="container-fluid py-4">
    <h2>Daftar Guru</h2>

    <!-- Search Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('kepsek.guru.index') }}">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <input type="text" name="search" class="form-control" 
                               placeholder="Cari nama, NIP, mata pelajaran..." 
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <button type="submit" class="btn btn-primary">Cari</button>
                        <a href="{{ route('kepsek.guru.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="card-body">
            @if ($guru->isEmpty())
                <div class="alert alert-info">Tidak ada guru yang ditemukan.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>NIP</th>
                                <th>Mata Pelajaran</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($guru as $g)
                                <tr>
                                    <td>{{ $g->name }}</td>
                                    <td>{{ $g->nip }}</td>
                                    <td>{{ $g->mata_pelajaran }}</td>
                                    <td>
                                        @if ($g->is_confirmed)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Belum Dikonfirmasi</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('kepsek.guru.show', $g->id) }}" class="btn btn-sm btn-info">Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $guru->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection