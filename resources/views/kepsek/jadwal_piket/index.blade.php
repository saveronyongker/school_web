@extends('layouts.layout_kepsek')

@section('content')
<div class="container-fluid py-4">
    <h2>Jadwal Guru Piket</h2>

    <div class="row">
        <!-- Minggu Ini -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Minggu Ini 
                        ({{ $startMingguIni->format('d M') }} - {{ $endMingguIni->format('d M Y') }})
                    </h5>
                </div>
                <div class="card-body">
                    @if ($jadwalMingguIni->isEmpty())
                        <p class="text-muted">Belum ada jadwal piket minggu ini.</p>
                    @else
                        @foreach ($jadwalMingguIni as $tanggal => $piketHarian)
                            <div class="mb-3 pb-2 border-bottom">
                                <strong>{{ \Carbon\Carbon::parse($tanggal)->isoFormat('dddd, D MMMM Y') }}</strong>
                                <ul class="list-unstyled mt-2">
                                    @foreach ($piketHarian as $p)
                                        <li>
                                            <i class="bi bi-person"></i> 
                                            {{ $p->guru->name }} 
                                            ({{ $p->guru->mata_pelajaran }})
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <!-- Minggu Depan -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Minggu Depan 
                        ({{ $startMingguDepan->format('d M') }} - {{ $endMingguDepan->format('d M Y') }})
                    </h5>
                </div>
                <div class="card-body">
                    @if ($jadwalMingguDepan->isEmpty())
                        <p class="text-muted">Belum ada jadwal piket minggu depan.</p>
                    @else
                        @foreach ($jadwalMingguDepan as $tanggal => $piketHarian)
                            <div class="mb-3 pb-2 border-bottom">
                                <strong>{{ \Carbon\Carbon::parse($tanggal)->isoFormat('dddd, D MMMM Y') }}</strong>
                                <ul class="list-unstyled mt-2">
                                    @foreach ($piketHarian as $p)
                                        <li>
                                            <i class="bi bi-person"></i> 
                                            {{ $p->guru->name }} 
                                            ({{ $p->guru->mata_pelajaran }})
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
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