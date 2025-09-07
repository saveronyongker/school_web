@extends('layouts.layout_welcome')

@section('content')

    <!--section 1--> 
    <section class="container-fluid bg-gradasi1 section d-flex align-items-center justify-content-center py-5 min-vh-100 mobile-viewport-fix">
        <div class="container-xl containers">
            <div class="row gy-4 gx-4 justify-content-center align-items-center">

                <!-- Kolom Teks (Kiri) -->
                <div class="col-lg-6 col-md-12 order-lg-1 order-2 text-center text-lg-start animate__fade-in">
                    @isset($profil)
                        <h2 class="display-2 fw-bold text-utama mb-3">{{ $profil->nama }}</h2>
                    @else
                        <h2 class="display-2 fw-bold text-utama mb-3">Nama Sekolah</h2>
                    @endisset
                    <p class="lead text-utama mb-4">Website resmi SD Negeri 1 Rumahtiga</p>
                    <button class="btn btn-1" id="btnProfil">Lebih Lanjut</button>
                </div>

                <!-- Kolom Gambar (Kanan) -->
                <div class="col-lg-6 col-md-12 order-lg-2 order-1 text-center animate__fade-in">
                    <img src="{{ asset('picture/profil1.png') }}"
                        class="img-fluid rounded"
                        style="max-height: 70vh; width: auto; object-fit: contain;">
                </div>

            </div>
        </div>
    </section>

    <!-- <div class="bg-gradasi1 rt" style="width: 100%; height: 10vh;"></div>  -->
    <!--Section 2-->
    <section class="container-fluid d-flex align-items-center justify-content-center mobile-viewport-fix bg-dark">
        <div class="container">
            <div id="profil" class="row gy-4 gx-3 py-5">

                <!-- Kolom Gambar (kiri) -->
                <div class="col-lg-6 col-md-12 block">
                    <img src="{{ asset('picture/foto1.jpg') }}"
                        class="img-fluid rounded-5 shadow-lg border border-5 border-secondary-subtle w-75 mx-auto d-block"
                        alt="Profil Sekolah">
                </div>

                <!-- Kolom Teks (kanan) -->
                <div class="col-lg-6 col-md-12 d-flex flex-column justify-content-center block">
                    <h1 class="d-flex flex-wrap justify-content-center justify-content-lg-start align-items-center gap-1 gap-lg-2 display-4 mb-3 text-center text-lg-start">
                        <span class="fw-bold text-utama">Profil</span>
                        <span class="text-utama">Sekolah</span>
                    </h1>

                    <div class="block">
                        @isset($profil)
                            <!-- <h4 class="fw-bold mb-3 text-keempat text-center text-lg-start">{{ $profil->nama }}</h4> -->
                            <p class="mb-4 text-utama text-center text-lg-start text-justify text-justify-sm">
                                {!! nl2br(e($profil->deskripsi)) !!}
                            </p>
                        @else
                            <p class="mb-4 text-utama text-center text-lg-start">Deskripsi</p>
                        @endisset
                    </div>

                    <div class="text-center text-lg-start text-justify text-justify-sm block">
                        <h5 class="fw-bold mb-2 text-utama"><i class="bi bi-geo-alt-fill text-utama fs-4"></i>Alamat</h5>
                        <p class="mb-0 text-utama">
                            {{ isset($profil) ? $profil->alamat : 'Alamat isi' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container-fluid d-flex align-items-center justify-content-center min-vh-100 mobile-viewport-fix">
        <div class="container my-5 my-lg-7">

            <!-- 01 -->
            <div class="row align-items-center mb-2 block-element">
                <div class="col-12 col-md-6 display-custom text-center fw-bold text-ketiga">01</div>
                    
                <!-- VISI -->
                <div class="col-12 col-md-6">
                    <div class="card-live">
                        <div class="card-live-header display-4 fw-bold text-ketiga">
                            VISI
                        </div>
                        <div class="card-live-body">
                            @isset($profil)
                                <p class="mb-0 text-kelima">{!! nl2br(e($profil->visi)) !!}</p>
                            @else
                                <p class="mb-0 text-kelima">Isi Visi</p>
                            @endisset
                            <div class="divider-glow"></div>
                            <div class="progress-mini"></div>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <!-- 02 -->
            <div class="row align-items-center mb-2 flex-row-reverse block-element">
                <div class="col-12 col-md-6 display-custom text-center fw-bold text-kedua text-end-sm">02</div>
                     
                <!-- MISI -->
                <div class="col-12 col-md-6">
                    <div class="card-live">
                        <div class="card-live-header display-4 fw-bold text-kedua">
                            MISI
                        </div>
                        <div class="card-live-body">
                            <ol class="mb-0 ps-3 text-kelima">
                                @isset($profil)
                                    {!! nl2br(e($profil->misi)) !!}
                                @else
                                    <li>Isi Misi</li>
                                @endisset
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

           <!-- 03 -->
            <div class="row align-items-center block-element">
                <div class="col-12 col-md-6 display-custom text-center fw-bold text-keempat">03</div>

                <!-- TUJUAN -->
                <div class="col-12 col-md-6">
                    <div class="card-live">
                        <div class="card-live-header display-4 fw-bold text-keempat">
                            TUJUAN
                        </div>
                        <div class="card-live-body">
                            <ol class="mb-0 ps-3 text-kelima">
                                @isset($profil)
                                    {!! nl2br(e($profil->misi)) !!}
                                @else
                                    <li>Isi Misi</li>
                                @endisset
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--Section 3-->
    <section class="container-fluid bg-gradasi1 section d-flex align-items-center justify-content-center min-vh-100 mobile-viewport-fix">
        <div class="container">
            <div class="row gy-4 gx-3">

                <div class="row gy-5 gx-md-4">
                    <h1 class="fw-bold display-5 mb-3 text-utama text-center">
                        Penanggung Jawab
                    </h1>
                </div>

                <div class="row gy-3 gx-md-4">
                    <!-- Kepala Sekolah -->
                    <div class="col-12 col-md-4">
                        <div class="actor-card">
                            <div class="card-body text-center p-4">
                                <img src="{{ asset('storage/foto/penanggungjawab/kepsek.jpg') }}"
                                    alt="Kepala Sekolah"
                                    class="rounded-circle actor-img mb-3">

                                <h5 class="fw-bold mb-1 text-utama">Nama Kepala Sekolah</h5>
                                <p class="mb-0 text-utama">Kepala Sekolah</p>
                            </div>
                        </div>
                    </div>

                    <!-- Wakil Kepsek -->
                    <div class="col-12 col-md-4">
                        <div class="actor-card">
                            <div class="card-body text-center p-4">
                                <img src="{{ asset('storage/foto/penanggungjawab/wakil.jpg') }}"
                                    alt="Wakil Kepsek"
                                    class="rounded-circle actor-img mb-3">

                                <h5 class="fw-bold mb-1 text-utama">Nama Wakil Kepsek</h5>
                                <p class="mb-0 text-utama">Wakil Kepala Sekolah</p>
                            </div>
                        </div>
                    </div>

                    <!-- Admin Sekolah -->
                    <div class="col-12 col-md-4">
                        <div class="actor-card">
                            <div class="card-body text-center p-4">
                                <img src="{{ asset('storage/foto/penanggungjawab/admin.jpg') }}"
                                    alt="Admin Sekolah"
                                    class="rounded-circle actor-img mb-3">

                                <h5 class="fw-bold mb-1 text-utama">Nama Admin</h5>
                                <p class="mb-0 text-utama">Admin Sekolah</p>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="mt-5">

                <!-- Kontak -->
                <div class="col-12">
                    <h5 class="fw-bold mb-3 text-utama text-center">KONTAK YANG BISA DI HUBUNGI</h5>
                    <div class="d-flex flex-column flex-sm-row justify-content-center align-items-center gap-3 gap-sm-4">
                        @isset($profil)
                            <p class="mb-0 text-utama">
                                <i class="bi bi-telephone me-2"></i>{{ $profil->telepon }}
                            </p>
                            <p class="mb-0 text-utama">
                                <i class="bi bi-envelope-at-fill me-2"></i>{{ $profil->email }}
                            </p>
                        @else
                            <p class="mb-0 text-utama">Telepon</p>
                            <p class="mb-0 text-utama">Email</p>
                        @endisset
                    </div>
                </div>


                <!-- TUJUAN -->
                <!-- <div class="col-lg-6 col-md-12 block">
                    <div class="card bg-white border-0 shadow-lg rounded-4 p-4 h-100">
                        <h4 class="fw-bold text-center mb-4">TUJUAN</h4>
                        <ol class="mb-0 ps-4">
                            <li>Mengembangkan Nilai-nilai Religius</li>
                            <li>Mengembangkan Kemampuan Literasi Membaca dan Numerasi</li>
                            <li>Mengembangkan Pembelajaran yang Menyenangkan</li>
                            <li>Melaksanakan Budaya Disiplin Positif</li>
                            <li>Membangkitkan Semangat Kompetitif</li>
                            <li>Mengembangkan Budaya Hidup Sehat</li>
                            <li>Menumbuhkan Kesadaran dan Kepedulian Terhadap Lingkungan</li>
                        </ol>
                    </div>
                </div> -->

            </div>
        </div>
    </section>

@endsection