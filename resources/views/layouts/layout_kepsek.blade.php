<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kepala Sekolah</title>

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

    <nav id="mainNavbar"    
        class="navbar navbar-expand-lg navbar-dark bg-navbar-kepsek costum-navbar stiky-top {{ $sticky ? 'sticky-top' : '' }}">
        <div class="container">

            {{-- Nama Auth (kiri) --}}
            <a class="navbar-brand fw-semibold" href="{{ url('/') }}">
                <i class="bi bi-person-circle me-1"></i>
                {{ Auth::user()->name ?? 'Guest' }}
            </a>

            {{-- Hamburger --}}
            <button class="navbar-toggler" type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarMenu1"
                    aria-controls="navbarMenu1"
                    aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- Menu (tengah) & Logout (kanan) --}}
            <div class="collapse navbar-collapse" id="navbarMenu1">
                {{-- Menu di tengah --}}
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('kepsek.dashboard') ? 'active' : '' }}" 
                            href="{{ route('kepsek.dashboard') }}">
                            <i class="bi bi-house-door me-1 d-inline d-lg-none"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('kepsek.laporan.*') ? 'active' : '' }}" 
                            href="{{ route('kepsek.laporan.index') }}">
                            <i class="bi bi-journal-text d-inline d-lg-none"></i> Laporan KBM
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('kepsek.guru.*') ? 'active' : '' }}" 
                            href="{{ route('kepsek.guru.index') }}">
                            <i class="bi bi-people d-inline d-lg-none"></i> Data Guru
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('kepsek.jadwal_piket.*') ? 'active' : '' }}" 
                            href="{{ route('kepsek.jadwal_piket.index') }}">
                            <i class="bi bi-calendar-check d-inline d-lg-none"></i> Jadwal Piket
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('kepsek.statistik.*') ? 'active' : '' }}" 
                            href="{{ route('kepsek.statistik.index') }}">
                            <i class="bi bi-graph-up d-inline d-lg-none"></i> Statistik
                        </a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('kepsek.informasi.*') ? 'active' : '' }}" 
                            href="{{ route('kepsek.informasi.index') }}">
                            <i class="bi bi-newspaper d-inline d-lg-none"></i> Informasi Sekolah
                        </a>
                    </li> -->
                </ul>

                {{-- Logout di kanan --}}
                <form action="{{ route('logout') }}" method="POST" class="d-flex">
                    @csrf
                    <button type="submit" class="btn btn-link nav-link text-light p-0">
                        <i class="bi bi-box-arrow-right me-1"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>
    
    <!-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('kepsek.dashboard') }}">
                Kepala Sekolah
            </a>
            
            <div class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </div>
        </div>
    </nav> -->

    <!-- Sidebar -->
    <div class="container">
        <div class="">
            <!-- <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('kepsek.dashboard') ? 'active' : '' }}" 
                               href="{{ route('kepsek.dashboard') }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('kepsek.laporan.*') ? 'active' : '' }}" 
                               href="{{ route('kepsek.laporan.index') }}">
                                <i class="bi bi-journal-text"></i> Laporan KBM
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('kepsek.guru.*') ? 'active' : '' }}" 
                               href="{{ route('kepsek.guru.index') }}">
                                <i class="bi bi-people"></i> Data Guru
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('kepsek.jadwal_piket.*') ? 'active' : '' }}" 
                               href="{{ route('kepsek.jadwal_piket.index') }}">
                                <i class="bi bi-calendar-check"></i> Jadwal Piket
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('kepsek.statistik.*') ? 'active' : '' }}" 
                               href="{{ route('kepsek.statistik.index') }}">
                                <i class="bi bi-graph-up"></i> Statistik
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('kepsek.informasi.*') ? 'active' : '' }}" 
                               href="{{ route('kepsek.informasi.index') }}">
                                <i class="bi bi-newspaper"></i> Informasi Sekolah
                            </a>
                        </li>
                    </ul>
                </div>
            </nav> -->

            <main class="col-md-12 ms-sm-auto col-lg-12 px-md-4">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Script Lain -->
    <script src="js/animasi.js"></script>

</body>
</html>