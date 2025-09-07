<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Guru Mata Pelajaran</title>

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

@props(['sticky' => true])

<header id="mainNavbar"
        class="custom-navbar bg-navbar-guru {{ $sticky ? 'sticky-top' : '' }}">
  <nav class="navbar-container container-fluid">
    <a class="navbar-brand" href="{{ url('/') }}">
        <i class="bi bi-person-circle"></i>
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
            <a href="{{ route('gurumapel.home_gurumapel') }}">
                <i class="bi bi-house-door d-none d-lg-inline me-1"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('laporan.create.gabungan') }}">
                <i class="bi bi-file-earmark-text d-none d-lg-inline me-1"></i> Laporan
            </a>
        </li>
        <li>
            <a href="{{ route('laporan.riwayat') }}">
                <i class="bi bi-clock-history d-none d-lg-inline me-1"></i> Riwayat
            </a>
        </li>
        <li>
             <!-- Button khusus Guru Piket -->
            @if (auth()->user()->isGuruPiketHariIni())
                <a href="{{ route('piket.dashboard') }}" class="text-warning">
                    <i class="bi bi-shield-check d-none d-lg-inline me-1 text-warning"></i>Piket Hari Ini 
                </a>
            @endif
        </li>
        <li>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-animated text-ketiga fw-bold rounded-5">
                    <i class="bi bi-box-arrow-right me-1"></i>
                    <span class="d-inline d-lg-none">Logout</span>
                </button>
            </form>
        </li>
    </ul>
  </nav>
</header>



<!-- Main Content -->
<section class="container mt-4">
    @yield('content')
</section>

<!-- Bootstrap JS -->
<script src="../../bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Script Lain -->
<script src="../js/animasi.js"></script>

@yield('scripts')
 
</body>
</html>