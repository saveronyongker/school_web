@extends('layouts.layout_admin')

@section('content')
<div class="container my-4 py-4 bg-utama shadow rounded-4">
    <h2>Atur Jadwal Guru Piket Minggu Depan</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Info jadwal minggu ini -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Jadwal Minggu Ini</h5>
        </div>
        <div class="card-body">
            @php
                $startCurrent = now()->startOfWeek();
                $endCurrent = $startCurrent->copy()->endOfWeek();
                $jadwalIni = \App\Models\JadwalPiket::mingguIni($startCurrent, $endCurrent)->get()->groupBy('tanggal');
            @endphp

            @if ($jadwalIni->isEmpty())
                <p class="text-muted">Belum ada jadwal untuk minggu ini.</p>
            @else
                <table class="table table-sm">
                    <tbody>
                        @foreach ($jadwalIni as $tanggal => $piketHarian)
                            @php
                                $date = \Carbon\Carbon::parse($tanggal);
                                $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'][$date->dayOfWeek];
                            @endphp
                            <tr>
                                <td><strong>{{ $hari }}</strong> ({{ $date->format('d M') }})</td>
                                <td>
                                    @foreach ($piketHarian as $p)
                                        {{ $p->guru->name }}@if (!$loop->last), @endif
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <a href="{{ route('jadwal.piket.show', ['minggu' => 'ini']) }}" class="btn btn-sm btn-outline-primary">
                Lihat Detail Minggu Ini
            </a>
        </div>
    </div>
     <!-- Form atur jadwal minggu ini -->
    <form method="POST" action="{{ route('jadwal.piket.store.minggu.ini') }}">
        @csrf

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5><i class="fas fa-calendar-week"></i> Jadwal Minggu Ini ({{ now()->startOfWeek()->format('d M') }} - {{ now()->endOfWeek()->format('d M Y') }})</h5>
            </div>
            <div class="card-body">
                @if($jadwalIniAda)
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> 
                        Jadwal minggu ini sudah ada. Mengisi form ini akan <strong>mengganti</strong> jadwal yang sudah ada.
                    </div>
                @endif

                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Hari/Tanggal</th>
                            <th>Guru Piket 1</th>
                            <th>Guru Piket 2</th>
                            <th>Guru Piket 3</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tanggalMingguIni as $tgl)
                            @php
                                $date = \Carbon\Carbon::parse($tgl);
                                $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'][$date->dayOfWeek];
                            @endphp
                            <tr>
                                <td><strong>{{ $hari }}</strong>, {{ $date->format('d M Y') }}</td>
                                @for ($i = 0; $i < 3; $i++)
                                    <td>
                                        <select name="jadwal_ini[{{ $tgl }}][]" class="form-control" required>
                                            <option value="">Pilih Guru</option>
                                            @foreach ($guruMapel as $guru)
                                                <option value="{{ $guru->id }}" 
                                                        {{ old("jadwal_ini.{$tgl}.{$i}") == $guru->id ? 'selected' : '' }}>
                                                    {{ $guru->name }} ({{ $guru->nip }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                @endfor
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save"></i> Simpan Jadwal Minggu Ini
                </button>
            </div>
        </div>
    </form>

    <!-- Form atur jadwal minggu depan -->
    <form method="POST" action="{{ route('jadwal.piket.store') }}">
        @csrf

        <div class="card">
            <div class="card-header">
                <h5>Jadwal Minggu Depan ({{ now()->addWeek()->startOfWeek()->format('d M') }} - {{ now()->addWeek()->endOfWeek()->format('d M Y') }})</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Hari/Tanggal</th>
                            <th>Guru Piket 1</th>
                            <th>Guru Piket 2</th>
                            <th>Guru Piket 3</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tanggalMingguDepan as $tgl)
                            @php
                                $date = \Carbon\Carbon::parse($tgl);
                                $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'][$date->dayOfWeek];
                            @endphp
                            <tr>
                                <td>{{ $hari }}, {{ $date->format('d M Y') }}</td>
                                @for ($i = 0; $i < 3; $i++)
                                    <td>
                                        <select name="jadwal[{{ $tgl }}][]" class="form-control" required>
                                            <option value="">Pilih Guru</option>
                                            @foreach ($guruMapel as $guru)
                                                <option value="{{ $guru->id }}">{{ $guru->name }} ({{ $guru->nip }})</option>
                                            @endforeach
                                        </select>
                                    </td>
                                @endfor
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <button type="submit" class="btn btn-primary">Simpan Jadwal Minggu Depan</button>
            </div>
        </div>
    </form>

    <div class="mt-4">
        <a href="{{ route('jadwal.piket.show', ['minggu' => 'depan']) }}" class="btn btn-info">Lihat Jadwal Minggu Depan</a>
    </div>
</div>
@endsection