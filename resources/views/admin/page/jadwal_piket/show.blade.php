@extends('layouts.layout_admin')

@section('content')
<div class="container my-4 py-4 bg-utama shadow rounded-4">
    <h2>Jadwal Guru Piket</h2>

    <!-- Tabs untuk pilih minggu -->
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link {{ $minggu === 'ini' ? 'active' : '' }}" 
               href="{{ route('jadwal.piket.show', ['minggu' => 'ini']) }}">
                Minggu Ini <!-- ({{ $start->format('d M') }} - {{ $end->format('d M Y') }}) -->
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $minggu === 'depan' ? 'active' : '' }}" 
               href="{{ route('jadwal.piket.show', ['minggu' => 'depan']) }}">
                Minggu Depan <!-- Mi({{ $start->format('d M') }} - {{ $end->format('d M Y') }}) -->
            </a>
        </li>
    </ul>

    @if ($jadwal->isEmpty())
        <div class="alert alert-info">
            @if ($minggu === 'ini')
                Belum ada jadwal piket untuk minggu ini.
            @else
                Belum ada jadwal piket untuk minggu depan.
            @endif
        </div>
    @else
        <table class="table table-striped">
            <thead class="table-secondary">
                <tr>
                    <th>Hari</th>
                    <th>Tanggal</th>
                    <th>Guru Piket</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jadwal as $tanggal => $piketHarian)
                    @php
                        $date = \Carbon\Carbon::parse($tanggal);
                        $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'][$date->dayOfWeek];
                    @endphp
                    <tr>
                        <td>{{ $hari }}</td>
                        <td>
                            {{ $date->format('d M Y') }}
                            <a href="{{ route('jadwal.piket.edit.harian', $date->format('Y-m-d')) }}" 
                            class="btn btn-sm ms-2">
                                <i class="bi bi-pencil"></i>
                            </a>
                        </td>
                        <td>
                            <ul class="mb-0">
                                @foreach ($piketHarian as $p)
                                    <li>
                                        {{ $p->guru->name }} 
                                        @if ($p->guru->mata_pelajaran)
                                            ({{ $p->guru->mata_pelajaran }})
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <div class="mb-3">
        <a href="{{ route('jadwal.piket.export.pdf', ['minggu' => $minggu]) }}" 
        class="btn btn-outline-danger" target="_blank">
            <i class="bi bi-file-earmark-pdf"></i> Export ke PDF
        </a>
        <a href="{{ route('jadwal.piket.create') }}" class="btn btn-outline-primary">
            <i class="bi bi-calendar-plus"></i> Atur Jadwal Baru
        </a>
    </div>
</div>
@endsection