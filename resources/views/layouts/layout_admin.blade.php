<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Admin</title>

        <!-- atau PNG -->
        <link rel="icon" href="{{ asset('picture/logo_sd.png') }}" type="image/png">

        <!-- (opsional) untuk iPhone -->
        <link rel="apple-touch-icon" href="{{ asset('picture/logo_sd.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Fira+Mono:wght@400;500;700&family=Outfit:wght@100..900&family=Unbounded:wght@200..900&display=swap" rel="stylesheet">
   
        <!-- Styles -->
         <link href="{{ asset('css/navbar.css') }}" rel="stylesheet">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>

        <!--Icon-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">


</head>
<body>

<!-- Navbar -->


@props(['sticky' => true])

<header id="mainNavbar"
        class="custom-navbar bg-admin {{ $sticky ? 'sticky-top' : '' }}">
  <nav class="navbar-container container-fluid">
    <a class="navbar-brand text-ketiga" href="{{ url('/') }}">
        {{ Auth::user()->name }}
    </a>

    <button id="navbarToggle1" class="navbar-toggle d-lg-none" type="button" 
    aria-controls="navbarMenu1" aria-expanded="false" aria-label="Toggle navigation">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
    </button>

    <ul class="navbar-menu" id="navbarMenu1">
        <li>
            <a href="{{ route('admin.page.dashboard') }}">Dashboard</a>
        </li>
        <li>
            <a href="{{ route('data_pengguna.index') }}">Data Pengguna</a>
        </li>
        <li>
            <a href="{{ route('informasi.index') }}">Informasi</a>
        </li>
        <li>
            <a href="{{ route('profil.index') }}">Profil</a>
        </li>
        <li>
            <a href="{{ route('jadwal.piket.show') }}">Piket</a>
        </li>
        <li>
            <a href="{{ route('siswa.index') }}">Data Siswa</a>
        </li>
        <li>
            <a href="{{ route('kelas.index') }}">Kelas</a>
        </li>
        <li>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-animated nav-link text-ketiga rounded-5 fw-bold">
                    <i class="bi bi-box-arrow-right"></i>
                    <span class="d-inline d-lg-none">Logout</span>
                </button>
            </form>
        </li>
    </ul>
  </nav>
</header>


<!-- <ul class="navbar-menu navbar-center">
                <li><a href="{{ route('admin.page.dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('data_pengguna.index') }}">Data Pengguna</a></li>
                <li><a href="{{ route('informasi.index') }}">Informasi</a></li>
                <li><a href="{{ route('profil.index') }}">Profil</a></li>
                <li><a href="{{ route('jadwal.piket.show') }}">Piket</a></li>
            </ul> -->

<!-- Content -->
<section class="container mt-4">
      @yield('content')
</section>


<!-- Bootstrap JS -->
<script src="../../bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Script Lain -->
<script src="../js/animasi.js"></script>


</body>
</html>