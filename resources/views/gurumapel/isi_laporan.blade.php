@extends('layouts.layout_guru')

@section('content')
<div class="container my-4 p-4 bg-utama rounded-4 shadow-costum border border-secondary-subtle">
    <h2>Isi Laporan KBM</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal Laporan</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" 
                value="{{ today()->format('Y-m-d') }}" readonly>
            <div class="form-text">Tanggal otomatis sesuai hari ini</div>
        </div>

        <div class="mb-3">
            <label>Kelas</label>
            <input type="text" name="kelas" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Mata Pelajaran</label>
            <input type="text" name="mata_pelajaran" class="form-control" value="{{ auth()->user()->mata_pelajaran }}" readonly>
        </div>

        <div class="mb-3">
            <label>Topik</label>
            <input type="text" name="topik" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Kegiatan</label>
            <textarea name="kegiatan" class="form-control" rows="4" required></textarea>
        </div>


        <div class="mb-3">
            <label for="file_materi" class="form-label">File Materi (Opsional)</label>
            <input type="file" name="file_materi" id="file_materi" class="form-control" 
                accept=".doc,.docx,.pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
            <div class="form-text">Format: DOC, DOCX, PDF (Max: 5MB)</div>
        </div>

        <!-- Jam Mulai -->
        <div class="col-md-6">
            <div class="mb-3">
                <label for="jam_mulai" class="form-label">Jam Mulai</label>
                <select name="jam_mulai" id="jam_mulai" class="form-control" required>
                    <option value="">Pilih Jam</option>
                    @for ($i = 6; $i <= 15; $i++) <!-- Jam 6 pagi sampai 3 sore -->
                        <option value="{{ $i }}">Jam {{ $i }}:00</option>
                    @endfor
                </select>
            </div>
        </div>

        <!-- Jam Selesai -->
        <div class="col-md-6">
            <div class="mb-3">
                <label for="jam_selesai" class="form-label">Jam Selesai</label>
                <select name="jam_selesai" id="jam_selesai" class="form-control" required>
                    <option value="">Pilih Jam</option>
                    @for ($i = 6; $i <= 15; $i++) <!-- Jam 6 pagi sampai 3 sore -->
                        <option value="{{ $i }}">Jam {{ $i }}:00</option>
                    @endfor
                </select>
            </div>
        </div>

        <!-- Pilih Kelas -->
        <!-- <div class="mb-3">
            <label for="kelas_id" class="form-label">Kelas</label>
            <select name="kelas_id" id="kelas_id" class="form-control" required onchange="loadSiswa(this.value)">
                <option value="">Pilih Kelas</option>
                @foreach ($kelasList as $kelas)
                    <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                @endforeach
            </select>
        </div> -->

        <!-- Tempat Daftar Siswa untuk Absensi -->
        <!-- <div id="daftar-siswa" style="display:none;">
            <h5 class="mt-4 mb-3">Absensi Siswa</h5>
            <table class="table table-bordered table-sm">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="30%">Nama Siswa</th>
                        <th width="15%" class="text-center">Hadir</th>
                        <th width="15%" class="text-center">Izin</th>
                        <th width="15%" class="text-center">Sakit</th>
                        <th width="15%" class="text-center">Alfa</th>
                        <th width="25%">Keterangan</th>
                    </tr>
                </thead>
                <tbody id="tbody-siswa"> -->
                    <!-- Diisi dengan AJAX -->
                <!-- </tbody>
            </table>
        </div> -->

        <button type="submit" class="btn btn-primary">Simpan Laporan</button>
    </form>
</div>
@endsection

