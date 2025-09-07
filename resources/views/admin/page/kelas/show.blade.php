@extends('layouts.layout_admin')

@section('content')
<div class="container my-4">
    <h2>📚 Detail Kelas: {{ $kelas->nama_kelas }}</h2>

    <div class="card mb-4">
        <div class="card-body">
            <h5>Informasi Kelas</h5>
            <table class="table table-sm">
                <tr>
                    <th width="20%">Nama Kelas</th>
                    <td>{{ $kelas->nama_kelas }}</td>
                </tr>
                <tr>
                    <th>Jumlah Siswa</th>
                    <td>{{ $kelas->jumlah_siswa }}</td>
                </tr>
                <tr>
                    <th>Tahun Ajaran</th>
                    <td>{{ $kelas->tahun_ajaran }}</td>
                </tr>
                <tr>
                    <th>Wali Kelas</th>
                    <td>{{ $kelas->waliKelas?->name ?? '-' }}</td>
                </tr>
            </table>
        </div>
    </div>

    <h4>👥 Daftar Siswa</h4>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th width="5%">No</th>
                    <th>Nama</th>
                    <th>NIS</th>
                    <th>Tanggal Lahir</th>
                    <th>Jenis Kelamin</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kelas->siswa as $index => $s)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $s->nama }}</td>
                        <td>{{ $s->nis }}</td>
                        <td>{{ \Carbon\Carbon::parse($s->tanggal_lahir)->format('d M Y') }}</td>
                        <td>{{ $s->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td>
                            @if ($s->status_aktif)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-danger">Nonaktif</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada siswa di kelas ini</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        <a href="{{ route('kelas.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>
@endsection