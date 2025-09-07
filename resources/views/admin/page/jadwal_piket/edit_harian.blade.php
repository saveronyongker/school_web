@extends('layouts.layout_admin')

@section('content')
<div class="container my-4 py-4 bg-utama shadow rounded-4">
    <h2>Edit Jadwal Guru Piket</h2>
    <h4>{{ $tanggal->format('l, d F Y') }}</h4>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('jadwal.piket.update.harian', $tanggal->format('Y-m-d')) }}">
        @csrf
        @method('PUT')

        <div class="card">
            <div class="card-body">
                @for ($i = 1; $i <= 3; $i++)
                    @php
                        $piket = $jadwalHarian->where('shift', $i)->first();
                        $userId = $piket ? $piket->user_id : '';
                    @endphp
                    <div class="mb-3">
                        <label class="form-label">Guru Piket Shift {{ $i }}</label>
                        <select name="guru_piket[]" class="form-control" required>
                            <option value="">Pilih Guru</option>
                            @foreach ($guruMapel as $guru)
                                <option value="{{ $guru->id }}" {{ $userId == $guru->id ? 'selected' : '' }}>
                                    {{ $guru->name }} ({{ $guru->nip }}) - {{ $guru->mata_pelajaran }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endfor

                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                <a href="{{ route('jadwal.piket.show', ['minggu' => 'depan']) }}" class="btn btn-secondary">Batal</a>
            </div>
        </div>
    </form>
</div>
@endsection