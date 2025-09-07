@extends('layouts.layout_welcome')

@section('content')

    <header class="header">
        <div style="height: 20vh;"></div>
    </header>
    <section class="container-fluid bg-gradasi1 min-vh-100" >
        <div class="container">
            <div class="row g-3">
                @foreach ($informasis as $info)
                    <div class="col-12 col-md-6 col-lg-4 p-2 p-md-3 d-flex align-items-stretch">
                        <div class="card-new mx-auto  w-100 h-100" style="max-width: 100%;">
                            <div class="card-image">
                               @if ($info->gambar)
                                    <img src="{{ asset('storage/'.$info->gambar) }}" class="card-img-top card-img-fixed" alt="{{ $info->judul }}">
                                @else
                                    <img src="{{ asset('images/no-image.png') }}" class="card-img-top card-img-fixed" alt="No Image">
                                @endif
                            </div>
                            <p class="card-title-new">{{ $info->judul }}</p>
                            <p class="card-body-new d-flex flex-column pb-3">
                                {!! \Illuminate\Support\Str::limit($info->isi, 150) !!}
                            </p>
                            <!-- <a href="#" class="btn btn-primary">Selengkapnya</a> -->
                            <a href="{{ route('informasi.detail', $info->id) }}" 
                                class="btn btn-primary">Selengkapnya
                            </a>
                            <p class="footer">Written on <span class="date">{{ $info->created_at->format('d M Y') }}</span></p>
                        </div>
                    </div>
                @endforeach
            </div>    
        </div>
    </section>
        
@endsection