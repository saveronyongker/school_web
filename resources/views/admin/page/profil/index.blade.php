@extends('layouts.layout_admin')

@section('content')
<div class="container my-4 py-4 bg-utama shadow rounded-4">
    <h2>Profil Sekolah</h2>

    @if ($profil)
        <p><strong>Nama:</strong> {{ $profil->nama }}</p>
        <p><strong>Alamat:</strong> {{ $profil->alamat }}</p>
        <p><strong>Telepon:</strong> {{ $profil->telepon }}</p>
        <p><strong>Email:</strong> {{ $profil->email }}</p>
        <p><strong>Deskripsi:</strong> {!! nl2br(e($profil->deskripsi)) !!}</p>
        <p><strong>Visi:</strong> {!! nl2br(e($profil->visi)) !!}</p>
        <p><strong>Misi:</strong> {!! nl2br(e($profil->misi)) !!}</p>
        <p><strong>Tujuan:</strong> {!! nl2br(e($profil->tujuan)) !!}</p>

       <!-- Debug info -->
   
        @if ($profil->logo)
            <img src="{{ asset('storage/' . $profil->logo) }}" alt="Logo Sekolah" class="img-fluid" style="max-width: 100px;">
        @else
            <p class="text-muted">Logo belum diupload</p>
        @endif

        <!-- @if ($profil->logo)
             <img src="{{ asset('storage/' . $profil->logo) }}" alt="Logo Sekolah" class="img-fluid" style="max-width: 100px;">
        @endif -->

        <a href="{{ route('profil.edit', $profil->id) }}" class="btn mt-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi-pencil" viewBox="0 0 16 16">
            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
            </svg>
        </a>
        
        @else
            <p>Belum ada data profil.</p>
            <a href="{{ route('profil.create') }}" class="btn btn-primary">Tambah Profil</a>
        @endif
</div>
@endsection