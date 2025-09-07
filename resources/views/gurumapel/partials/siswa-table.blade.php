@php
    $siswaList = $siswaList ?? collect();
@endphp

@if($siswaList->count() > 0)
    @foreach($siswaList as $index => $siswa)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $siswa->nama }}</td>
            <td>{{ $siswa->nis }}</td>
            <td>
                <select name="absensi[{{ $siswa->id }}]" class="form-control form-control-sm" required>
                    <option value="">Pilih Status</option>
                    <option value="hadir" {{ old("absensi.{$siswa->id}") == 'hadir' ? 'selected' : '' }}>Hadir</option>
                    <option value="izin" {{ old("absensi.{$siswa->id}") == 'izin' ? 'selected' : '' }}>Izin</option>
                    <option value="sakit" {{ old("absensi.{$siswa->id}") == 'sakit' ? 'selected' : '' }}>Sakit</option>
                    <option value="alfa" {{ old("absensi.{$siswa->id}") == 'alfa' ? 'selected' : '' }}>Alfa</option>
                </select>
            </td>
            <td>
                <input type="text" name="keterangan[{{ $siswa->id }}]" 
                       class="form-control form-control-sm" 
                       value="{{ old("keterangan.{$siswa->id}") }}"
                       placeholder="Keterangan (opsional)">
            </td>
        </tr>
    @endforeach
@elseif(request('kelas_id') || old('kelas_id'))
    <tr>
        <td colspan="5" class="text-center text-warning">
            <i class="fas fa-exclamation-triangle"></i> 
            Tidak ada siswa di kelas ini
        </td>
    </tr>
@else
    <tr>
        <td colspan="5" class="text-center text-info">
            <i class="fas fa-info-circle"></i> 
            Pilih kelas terlebih dahulu dan klik "Refresh Data Siswa"
        </td>
    </tr>
@endif