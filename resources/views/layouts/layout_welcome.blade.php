<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SDN 1 RUMAHTIGA</title>

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

        <!--Icon-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    </head>
    <body> 

    <div style="width: 100vw;">
        <nav class="navbar navbar-expand-lg costum-navbar1 navbar-dark fixed-top rounded-5">
            <div class="container">
                <a class="navbar-brand fw-bold" href="{{ route('welcome') }}">SDN 1 RUMAHTIGA</a>
            
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('welcome') }}">Profil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('informasi.sekolah') }}">Informasi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-animated rounded-5" href="{{ route('login') }}">Login</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    

    <div>
        @yield('content')
    </div>

    <footer class="container-fluid bg-biru">
        <div class="text-center p-4">
            <p class="text-white">website resmi sd negeri 1 rumahtiga</p>
        </div>
    </footer>

        <!---batas script--->
        <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('js/animasi.js') }}"></script>
        
    
    </body>
</html>
