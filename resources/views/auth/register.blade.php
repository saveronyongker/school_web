


    <form method="POST" action="{{ route('register.guru_mapel') }}">
        @csrf

        <div class="mb-3">
            <label for="name">Nama Lengkap</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="nip">NIP</label>
            <input type="text" name="nip" id="nip" class="form-control" value="{{ old('nip') }}" required>
        </div>

        <div class="mb-3">
            <label for="mata_pelajaran">Mata Pelajaran</label>
            <input type="text" name="mata_pelajaran" id="mata_pelajaran" class="form-control" value="{{ old('mata_pelajaran') }}" required>
        </div>

        <div class="mb-3">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Daftar</button>
        <a href="{{ route('login') }}" class="btn btn-secondary">Kembali</a>
    </form>
