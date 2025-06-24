@extends('layouts.app')

@section('title', 'Info Pendamping')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Info Pendamping</h1>
    @if($pendaftaran && $pendaftaran->status === 'approved')
        <div class="alert alert-info">
            <strong>Pendamping Anda:</strong>
            @if($pendamping)
                {{ $pendamping->user->name ?? $pendamping->nama_lengkap }}<br>
                <small>No HP: {{ $pendamping->no_hp }}</small><br>
                <small>Wilayah Kerja: {{ $pendamping->wilayah_kerja }}</small>
            @else
                Belum ada pendamping
            @endif
        </div>
    @elseif($pendaftaran && $pendaftaran->status === 'ditolak')
        <div class="alert alert-danger">
            Pendaftaran Anda ditolak. Pendamping tidak tersedia.
        </div>
    @else
        <div class="alert alert-warning">
            Pendamping belum tersedia. Menunggu persetujuan admin.
        </div>
    @endif
</div>
@endsection