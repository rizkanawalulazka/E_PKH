@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-friends mr-2"></i>
            Daftar Pendamping
        </h1>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Pendamping</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama Lengkap</th>
                            <th>No HP</th>
                            <th>Alamat</th>
                            <th>Wilayah Kerja</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendampings as $i => $p)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ $p->user ? $p->user->nik : '-' }}</td>
                            <td>{{ $p->nama_lengkap }}</td>
                            <td>{{ $p->no_hp }}</td>
                            <td>{{ $p->alamat }}</td>
                            <td>{{ $p->wilayah_kerja }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data pendamping</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 