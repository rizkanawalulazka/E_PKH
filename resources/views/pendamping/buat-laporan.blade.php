@extends('layouts.app')

@section('title', 'Buat Laporan Pendampingan')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-plus mr-2"></i>
            Buat Laporan Pendampingan
        </h1>
    </div>

    <!-- Form Buat Laporan -->
    @if(isset($penerima) && $penerima)
    <div class="row mb-4">
        <div class="col-xl-8 col-lg-8">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Laporan Pendampingan</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('pendamping.laporan.simpan') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="penerima">Penerima</label>
                            <input type="text" name="penerima_nama" class="form-control" value="{{ $penerima->name }}" readonly>
                            <input type="hidden" name="penerima_id" value="{{ $penerima->id }}">
                        </div>
                        <div class="form-group">
                            <label for="kegiatan">Kegiatan</label>
                            <textarea name="kegiatan" class="form-control" rows="2" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="Selesai">Selesai</option>
                                <option value="Proses">Proses</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="foto">Foto</label>
                            <input type="file" name="foto" class="form-control-file" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Laporan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="alert alert-danger">Data penerima tidak ditemukan atau tidak valid. Silakan kembali dan pilih penerima yang benar.</div>
    @endif

    {{-- Tabel Laporan --}}
    {{-- Bagian ini dipindahkan ke daftar-laporan.blade.php --}}
    {{-- <div class="row">
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
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2025-06-21</td>
                                <td>Nama Penerima</td>
                                <td>Penyuluhan Kesehatan</td>
                                <td><span class="badge badge-success">Selesai</span></td>
                                <td>
                                    <img src="{{ asset('sbadmin2/img/undraw_profile.svg') }}" alt="foto" width="40">
                                </td>
                                <td>
                                    <a href="#" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Buat Laporan</a>
                                </td>
                            </tr>
                            <tr>
                                <td>2025-06-20</td>
                                <td>Nama Penerima 2</td>
                                <td>Pemberian Bantuan</td>
                                <td><span class="badge badge-warning">Proses</span></td>
                                <td>
                                    <img src="{{ asset('sbadmin2/img/undraw_profile.svg') }}" alt="foto" width="40">
                                </td>
                                <td>
                                    <a href="#" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Buat Laporan</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> --}}
</div>
@endsection