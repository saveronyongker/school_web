@extends('layouts.layout_guru')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Absensi Siswa</h2>
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('absensi.store') }}" method="POST">
                @csrf
                
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Kelas *</label>
                                    <select name="kelas_id" id="kelas_id" class="form-control" required>
                                        <option value="">Pilih Kelas</option>
                                        @foreach($kelasList as $kelas)
                                            <option value="{{ $kelas->id }}" {{ old('kelas_id') == $kelas->id ? 'selected' : '' }}>
                                                {{ $kelas->nama_kelas }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tanggal *</label>
                                    <input type="date" name="tanggal" class="form-control" 
                                           value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Siswa</th>
                                        <th>NIS</th>
                                        <th>Status *</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($siswaList as $index => $siswa)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $siswa->nama }}</td>
                                            <td>{{ $siswa->nis }}</td>
                                            <td>
                                                <select name="absensi[{{ $siswa->id }}]" class="form-control" required>
                                                    <option value="">Pilih</option>
                                                    <option value="hadir" {{ old("absensi.{$siswa->id}") == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                                    <option value="izin" {{ old("absensi.{$siswa->id}") == 'izin' ? 'selected' : '' }}>Izin</option>
                                                    <option value="sakit" {{ old("absensi.{$siswa->id}") == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                                    <option value="alfa" {{ old("absensi.{$siswa->id}") == 'alfa' ? 'selected' : '' }}>Alfa</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="keterangan[{{ $siswa->id }}]" 
                                                       class="form-control" 
                                                       value="{{ old("keterangan.{$siswa->id}") }}"
                                                       placeholder="Keterangan">
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                @if($kelasDipilih)
                                                    Tidak ada siswa di kelas ini
                                                @else
                                                    Pilih kelas terlebih dahulu
                                                @endif
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Absensi
                            </button>
                            <a href="{{ route('guru.dashboard') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection