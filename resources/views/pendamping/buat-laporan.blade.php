@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-clipboard-list mr-2"></i>
            Buat Laporan Pendampingan
        </h1>
        <a href="{{ route('pendamping.laporan') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left fa-sm mr-1"></i> Kembali
        </a>
    </div>
    <div class="alert alert-warning">Fitur laporan pendampingan tidak tersedia karena tabel tidak ada.</div>
</div>
@endsection 