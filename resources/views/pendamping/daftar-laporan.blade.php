@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-clipboard-list mr-2"></i>
            Daftar Laporan Pendampingan
        </h1>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Laporan Pendampingan</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Pendamping</th>
                                    <th>Penerima</th>
                                    <th>Kegiatan</th>
                                    <th>Status</th>
                                    <th>Foto</th>
                                    <th>Verifikasi</th>
                                    @if(auth()->user()->role === 'admin')
                                        <th>Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($laporan as $lap)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($lap->tanggal)->format('d/m/Y') ?? '-' }}</td>
                                    <td>{{ optional($lap->pendamping->user)->name ?? '-' }}</td>
                                    <td>{{ optional($lap->penerima)->name ?? '-' }}</td>
                                    <td>{{ $lap->kegiatan ?? '-' }}</td>
                                    <td>
                                        @if(auth()->user()->role === 'admin')
                                            <select class="form-control form-control-sm update-status-laporan" data-laporan-id="{{ $lap->id }}">
                                                <option value="Proses" {{ ($lap->status ?? '') == 'Proses' ? 'selected' : '' }}>Proses</option>
                                                <option value="Selesai" {{ ($lap->status ?? '') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                            </select>
                                        @else
                                            <span class="badge badge-{{ ($lap->status ?? '') == 'Selesai' ? 'success' : 'warning' }}">{{ $lap->status ?? '-' }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($lap->foto) && $lap->foto)
                                            <a href="{{ asset('storage/'.$lap->foto) }}" target="_blank">
                                                <img src="{{ asset('storage/'.$lap->foto) }}" alt="foto" width="40" class="img-thumbnail">
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if(auth()->user()->role === 'admin')
                                            <select class="form-control form-control-sm update-verifikasi-laporan" data-laporan-id="{{ $lap->id }}">
                                                <option value="pending" {{ ($lap->verifikasi_status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="approved" {{ ($lap->verifikasi_status ?? '') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                                                <option value="rejected" {{ ($lap->verifikasi_status ?? '') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                            </select>
                                        @else
                                            @if(isset($lap->verifikasi_status) && $lap->verifikasi_status == 'pending')
                                                <span class="badge badge-warning">Pending</span>
                                            @elseif(isset($lap->verifikasi_status) && $lap->verifikasi_status == 'approved')
                                                <span class="badge badge-success">Disetujui</span>
                                            @elseif(isset($lap->verifikasi_status) && $lap->verifikasi_status == 'rejected')
                                                <span class="badge badge-danger">Ditolak</span>
                                            @else
                                                <span class="badge badge-secondary">-</span>
                                            @endif
                                        @endif
                                    </td>
                                    @if(auth()->user()->role === 'admin')
                                    <td>
                                        <button class="btn btn-info btn-sm" onclick="viewDetail({{ $lap->id }})">
                                            <i class="fas fa-eye"></i> Detail
                                        </button>
                                    </td>
                                    @endif
                                </tr>
                                @empty
                                <tr>