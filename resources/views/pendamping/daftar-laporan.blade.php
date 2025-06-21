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
    <div class="alert alert-warning">Fitur laporan pendampingan tidak tersedia karena tabel tidak ada.</div>
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
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="5" class="text-center">Fitur laporan pendampingan tidak tersedia.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 