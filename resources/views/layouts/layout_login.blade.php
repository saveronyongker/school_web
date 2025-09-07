<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Login Sistem</title>

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
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('css/login.css') }}" rel="stylesheet">
        <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>

        <!-- icon -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

        
</head>
<body>
  
  @if(session('success'))
      <p style="color:green;">{{ session('success') }}</p>
  @endif

  <!-- ALERT ERROR -->
  @if (session('status'))
      <div class="alert alert-danger">
          {{ session('status') }}
      </div>
  @endif
  <div class="hero-section">
    @yield('content')
  </div>
    
 
  <!-- Java Script -->
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <script src="../js/animasi.js"></script>
 
</body>
</html>
    