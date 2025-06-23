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
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Laporan Pendampingan</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
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
                                <td>{{ $lap->tanggal ?? '-' }}</td>
                                <td>{{ optional($lap->penerima)->name ?? '-' }}</td>
                                <td>{{ $lap->kegiatan ?? '-' }}</td>
                                <td><span class="badge badge-{{ ($lap->status ?? '') == 'Selesai' ? 'success' : 'warning' }}">{{ $lap->status ?? '-' }}</span></td>
                                <td>
                                    @if(isset($lap->foto) && $lap->foto)
                                        <img src="{{ asset('storage/'.$lap->foto) }}" alt="foto" width="40">
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if(isset($lap->verifikasi_status) && $lap->verifikasi_status == 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @elseif(isset($lap->verifikasi_status) && $lap->verifikasi_status == 'approved')
                                        <span class="badge badge-success">Disetujui</span>
                                    @elseif(isset($lap->verifikasi_status) && $lap->verifikasi_status == 'rejected')
                                        <span class="badge badge-danger">Ditolak</span>
                                    @else
                                        <span class="badge badge-secondary">-</span>
                                    @endif
                                </td>
                                @if(auth()->user()->role === 'admin')
                                <td>
                                    @if(isset($lap->verifikasi_status) && $lap->verifikasi_status == 'pending')
                                    <form action="{{ route('pendamping.laporan.approve', $lap->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Setujui laporan ini?')">Setujui</button>
                                    </form>
                                    <form action="{{ route('pendamping.laporan.reject', $lap->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tolak laporan ini?')">Tolak</button>
                                    </form>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                @endif
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada laporan pendampingan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection