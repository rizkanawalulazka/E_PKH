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
    <div class="row mb-4">
        <div class="col-xl-8 col-lg-8">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Laporan Pendampingan</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('pendamping.laporan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="penerima">Penerima</label>
                            <input type="text" name="penerima" class="form-control" required>
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

    <!-- Tabel Laporan -->
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
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Contoh data statis, ganti dengan @foreach jika sudah ada data --}}
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
                            {{-- Jika tidak ada data --}}
                            {{-- <tr>
                                <td colspan="6" class="text-center">Belum ada laporan pendampingan.</td>
                            </tr> --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection