@extends('layouts.layout_admin')

@section('content')
<!-- Debug -->
<h1>Ini adalah view informasi_sekolah.blade.php</h1>
<pre>{{ now() }}</pre>
<!-- End Debug -->

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Daftar Informasi Sekolah</h2>
        <a href="{{ route('informasi.create') }}" class="btn btn-success">Tambah Informasi Baru</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Isi</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($informasis as $key => $informasi)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ Str::limit($informasi->judul, 30) }}</td>
                        <td>{!! Str::limit(strip_tags($informasi->isi), 100) !!}</td>
                        <td>
                            @if($informasi->gambar)
                                <img src="{{ asset('storage/' . $informasi->gambar) }}" width="100" alt="Gambar">
                            @else
                                <span class="text-muted">Tidak ada gambar</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('informasi.edit', $informasi->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                
                                <form action="{{ route('informasi.destroy', $informasi->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus informasi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada informasi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('content')
<div class="container mt-4">
    <h2>Daftar Informasi</h2>
    <a href="{{ route('informasi.create') }}" class="btn btn-success mb-3">Tambah Informasi</a>

    @if ($informasis->isEmpty())
        <div class="alert alert-warning">Belum ada informasi tersedia.</div>
    @else
        <div class="row">
            @foreach ($informasis as $info)
                <div class="col-md-6 mb-4">
                    <div class="card">
                        @if ($info->gambar)
                            <img src="{{ asset('storage/'.$info->gambar) }}" class="card-img-top" alt="{{ $info->judul }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $info->judul }}</h5>
                            <p class="card-text">{!! Str::limit($info->isi, 100) !!}</p>
                            <a href="#" class="btn btn-primary">Lihat Selengkapnya</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection