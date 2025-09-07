@extends('layouts.layout_login')

@section('content')
<div class="glass">
    <div class="container-fluid px-3 px-sm-4">
        <div class="row section d-flex align-items-center justify-content-center">
            <div class="col-md-6">
                <div class="glass-dark rounded-5 py-4 px-5 card-login shadow-lg">
                    <div class="card-header">
                        <h4 class="text-center mb-4">LOGIN sistem</h4>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-4">
                                <!-- <label for="nip" class="form-label">NIP</label> -->
                                <input type="text" name="nip" id="nip" class="form-control rounded-4 input-costum glass-dark" placeholder="NIP" required autofocus>
                            </div>
            
                            <div class="mb-3">
                                <!-- <label for="password" class="form-label">Password</label> -->
                                <input type="password" name="password" id="password" class="form-control rounded-4 input-costum glass-dark" placeholder="Password" required>
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" name="remember" id="remember" class="form-check-input rounded-5 glass-dark">
                                <label for="remember" class="form-check-label">Ingat saya</label>
                            </div>

                            <button type="submit" class="btn btn-utama rounded-4 w-100">Login</button>
                        </form>

                        <a href="{{ route('welcome') }}" class="nav-link text-center mt-3">Kembali</a>

                        <div class="mt-3 justify-content-center d-flex">
                            <p class="me-2">Belum daftar?</p>
                            <a href="{{ route('register.guru_mapel') }}" class="fw-bold nav-link">Klik di sini</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection