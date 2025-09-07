@extends('layouts.layout_kepsek')

@section('content')
<div class="container-fluid py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('kepsek.laporan.index') }}">Laporan KBM</a></li>
            <li class="breadcrumb-item active">Detail</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header">
            <h3>Detail Laporan KBM</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th>Guru:</th>
                            <td>{{ $laporan->guru->name }}</td>
                        </tr>
                        <tr>
                            <th>NIP:</th>
                            <td>{{ $laporan->guru->nip }}</td>
                        </tr>
                        <tr>
                            <th>Mata Pelajaran:</th>
                            <td>{{ $laporan->mata_pelajaran }}</td>
                        </tr>
                        <tr>
                            <th>Kelas:</th>
                            <td>{{ $laporan->kelas }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal:</th>
                            <td>{{ \Carbon\Carbon::parse($laporan->tanggal)->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <th>Jam:</th>
                            <td>{{ $laporan->jam_mulai }} - {{ $laporan->jam_selesai }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th>Topik:</th>
                            <td>{{ $laporan->topik }}</td>
                        </tr>
                        <tr>
                            <th>Kegiatan:</th>
                            <td>{{ $laporan->kegiatan }}</td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                @if ($laporan->status == 'dikonfirmasi')
                                    <span class="badge bg-success">Dikonfirmasi</span>
                                @elseif ($laporan->status == 'ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                @else
                                    <span class="badge bg-warning text-dark">Belum</span>
                                @endif
                            </td>
                        </tr>
                        @if ($laporan->dikonfirmasi_oleh)
                            <tr>
                                <th>Dikonfirmasi Oleh:</th>
                                <td>{{ $laporan->guruPiket->name }}</td>
                            </tr>
                        @endif
                        @if ($laporan->catatan_piket)
                            <tr>
                                <th>Catatan Piket:</th>
                                <td>{{ $laporan->catatan_piket }}</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>

            @if ($laporan->file_materi)
                <hr>
                <h5>Materi Pembelajaran</h5>
                <a href="{{ asset('storage/' . $laporan->file_materi) }}" 
                   target="_blank" class="btn btn-primary">
                    <i class="bi bi-file-earmark-text"></i> Lihat Materi
                </a>
            @endif
        </div>
        <div class="card-footer">
            <a href="{{ route('kepsek.laporan.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection