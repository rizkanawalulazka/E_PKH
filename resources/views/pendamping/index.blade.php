@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-friends mr-2"></i>
            Dashboard Pendamping
        </h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Total Penerima Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Penerima</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $penerima->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Laporan Card -->
        <!-- <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Laporan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{-- {{ $pendamping->laporanPendampingan->count() }} --}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Daftar Penerima -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Penerima Bantuan</h6>
                    <a href="{{ route('pendamping.penerima') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-users fa-sm mr-1"></i> Lihat Semua
                    </a>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($penerima->take(5) as $p)
                                <tr>
                                    <td>{{ $p->nik }}</td>
                                    <td>{{ $p->name }}</td>
                                    <td>
                                        <a href="{{ route('pendamping.laporan.buat', $p->id) }}" 
                                           class="btn btn-primary btn-sm">
                                            <i class="fas fa-plus fa-sm"></i> Buat Laporan
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">Tidak ada data penerima</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 