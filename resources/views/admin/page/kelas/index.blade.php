@extends('layouts.layout_admin')

@section('content')
<div class="container my-4">
    <h2>📚 Kelola Kelas</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('kelas.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Kelas
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th width="5%">No</th>
                    <th>Nama Kelas</th>
                    <th>Jumlah Siswa</th>
                    <th>Tahun Ajaran</th>
                    <th>Wali Kelas</th>
                    <th width="20%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kelas as $index => $k)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $k->nama_kelas }}</td>
                        <td>{{ $k->siswa_count }}</td>
                        <td>{{ $k->tahun_ajaran }}</td>
                        <td>{{ $k->waliKelas?->name ?? '-' }}</td>
                        <td>
                            <a href="{{ route('kelas.show', $k->id) }}" class="btn btn-md">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('kelas.edit', $k->id) }}" class="btn btn-md">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('kelas.destroy', $k->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-md" 
                                        onclick="return confirm('Yakin hapus kelas {{ $k->nama_kelas }}?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada kelas</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $kelas->links() }}
    </div>
</div>
@endsection