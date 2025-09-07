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
     
        <div class="container section py-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('informasi.sekolah') }}">Informasi</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                </ol>
            </nav>

            <div class="card">
                @if ($info->gambar)
                    <img src="{{ asset('storage/' . $info->gambar) }}" 
                        class="card-img-sm img-fluid mx-auto d-block mt-3" 
                        alt="{{ $info->judul }}">
                @endif
                
                <div class="card-body">
                    <h1 class="card-title">{{ $info->judul }}</h1>
                    
                    <div class="d-flex align-items-center text-muted mb-3">
                        <i class="bi bi-calendar me-2"></i>
                        <span>{{ \Carbon\Carbon::parse($info->tanggal)->format('d F Y') }}</span>
                        
                        @if ($info->kategori)
                            <span class="mx-3">•</span>
                            <i class="bi bi-tag me-2"></i>
                            <span>{{ $info->kategori }}</span>
                        @endif
                    </div>

                    <div class="card-text">
                        {!! nl2br(e($info->isi)) !!}
                    </div>

                    @if ($info->sumber)
                        <hr>
                        <p class="text-muted">
                            <i class="bi bi-person me-2"></i>
                            <strong>Sumber:</strong> {{ $info->sumber }}
                        </p>
                    @endif
                </div>
                
                <div class="card-footer">
                    <a href="{{ route('informasi.sekolah') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </body>
</html>