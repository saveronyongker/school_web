@extends('layouts.layout_login')

@section('title', 'Register Guru')

@section('content')
<div class="glass min-vh-100">
<div class="container-fluid">
    <div class="row section d-flex align-items-center justify-content-center">
        <div class="col-md-6">
            <div class="glass-dark rounded-5 p-4 card-login shadow-lg">
                <div class="card-header text-center mb-4">
                    <h4>Daftar Guru Mata Pelajaran</h4>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register.guru_mapel.store') }}">
                        @csrf

                        <div class="mb-3">
                            <!-- <label for="name" class="form-label">Nama Lengkap</label> -->
                            <input type="text" name="name" id="name" class="form-control rounded-5 glass-dark input-costum" placeholder="Nama Lengkap" required>
                        </div>

                        <div class="mb-3">
                            <!-- <label for="nip" class="form-label">NIP</label> -->
                            <input type="text" name="nip" id="nip" class="form-control rounded-5 glass-dark input-costum" placeholder="NIP" required>
                        </div>

                        <div class="mb-3">
                            <!-- <label for="mata_pelajaran" class="form-label">Mata Pelajaran</label> -->
                            <input type="text" name="mata_pelajaran" id="mata_pelajaran" class="form-control rounded-5 glass-dark input-costum" placeholder="Mata Pelajaran" required>
                        </div>

                        <div class="mb-3">
                            <!-- <label for="password" class="form-label">Password</label> -->
                            <input type="password" name="password" id="password" class="form-control rounded-5 glass-dark input-costum" placeholder="Password" required>
                        </div>

                        <div class="mb-3">
                            <!-- <label for="password_confirmation" class="form-label">Konfirmasi Password</label> -->
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control rounded-5 glass-dark input-costum" placeholder="Konfirmasi Password" required>
                        </div>

                        <button type="submit" class="btn btn-utama w-100 rounded-5">Daftar</button>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li><strong>{{ $error }}</strong></li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </form>
                    
                    <div class="mt-3 justify-content-center d-flex">
                            <p>Sudah punya akun?</p><a class="fw-bold nav-link" href="{{ route('login') }}">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@endsection