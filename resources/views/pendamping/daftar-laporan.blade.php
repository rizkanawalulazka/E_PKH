<?php
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
                                    <td>{{ $lap->tanggal ? \Carbon\Carbon::parse($lap->tanggal)->format('d/m/Y') : '-' }}</td>
                                    <td>
                                        @if($lap->pendamping && $lap->pendamping->user)
                                            {{ $lap->pendamping->user->name }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($lap->penerima)
                                            {{ $lap->penerima->name }}
                                        @else
                                            -
                                        @endif
                                    </td>
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
                                        @if($lap->foto)
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
                                            @php
                                                $verifikasi = $lap->verifikasi_status ?? 'pending';
                                            @endphp
                                            @if($verifikasi == 'pending')
                                                <span class="badge badge-warning">Pending</span>
                                            @elseif($verifikasi == 'approved')
                                                <span class="badge badge-success">Disetujui</span>
                                            @elseif($verifikasi == 'rejected')
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
                                    <td colspan="{{ auth()->user()->role === 'admin' ? '8' : '7' }}" class="text-center">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Belum ada laporan pendampingan</p>
                                    </td>
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

<!-- Modal Detail Laporan -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Laporan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="detailContent">
                <!-- Content will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Update status laporan
    $('.update-status-laporan').on('change', function() {
        var laporanId = $(this).data('laporan-id');
        var newStatus = $(this).val();
        
        $.ajax({
            url: '/pendamping/laporan/' + laporanId + '/update-status',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                status: newStatus
            },
            success: function(response) {
                if (response.success) {
                    alert('Status berhasil diperbarui');
                    location.reload();
                } else {
                    alert('Gagal memperbarui status');
                }
            },
            error: function() {
                alert('Terjadi kesalahan');
            }
        });
    });
    
    // Update verifikasi laporan
    $('.update-verifikasi-laporan').on('change', function() {
        var laporanId = $(this).data('laporan-id');
        var newVerifikasi = $(this).val();
        
        $.ajax({
            url: '/pendamping/laporan/' + laporanId + '/update-verifikasi',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                verifikasi_status: newVerifikasi
            },
            success: function(response) {
                if (response.success) {
                    alert('Verifikasi berhasil diperbarui');
                    location.reload();
                } else {
                    alert('Gagal memperbarui verifikasi');
                }
            },
            error: function() {
                alert('Terjadi kesalahan');
            }
        });
    });
});

// Function untuk view detail
function viewDetail(laporanId) {
    $.ajax({
        url: '/pendamping/laporan/' + laporanId + '/detail',
        method: 'GET',
        success: function(response) {
            if (response.success) {
                var laporan = response.data;
                var pendampingName = '-';
                var penerimaName = '-';
                
                // Safe check untuk pendamping
                if (laporan.pendamping && laporan.pendamping.user) {
                    pendampingName = laporan.pendamping.user.name;
                }
                
                // Safe check untuk penerima
                if (laporan.penerima) {
                    penerimaName = laporan.penerima.name;
                }
                
                var content = `
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Informasi Laporan</h6>
                            <table class="table table-bordered">
                                <tr>
                                    <td><strong>Tanggal:</strong></td>
                                    <td>${laporan.tanggal || '-'}</td>
                                </tr>
                                <tr>
                                    <td><strong>Pendamping:</strong></td>
                                    <td>${pendampingName}</td>
                                </tr>
                                <tr>
                                    <td><strong>Penerima:</strong></td>
                                    <td>${penerimaName}</td>
                                </tr>
                                <tr>
                                    <td><strong>Kegiatan:</strong></td>
                                    <td>${laporan.kegiatan || '-'}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td><span class="badge badge-${laporan.status == 'Selesai' ? 'success' : 'warning'}">${laporan.status || '-'}</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Verifikasi:</strong></td>
                                    <td><span class="badge badge-${laporan.verifikasi_status == 'approved' ? 'success' : (laporan.verifikasi_status == 'rejected' ? 'danger' : 'warning')}">${laporan.verifikasi_status || 'pending'}</span></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6>Foto Kegiatan</h6>
                            ${laporan.foto ? `<img src="/storage/${laporan.foto}" class="img-fluid" alt="Foto Kegiatan">` : '<p class="text-muted">Tidak ada foto</p>'}
                        </div>
                    </div>
                    ${laporan.catatan ? `
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6>Catatan:</h6>
                            <p>${laporan.catatan}</p>
                        </div>
                    </div>
                    ` : ''}
                `;
                
                $('#detailContent').html(content);
                $('#detailModal').modal('show');
            } else {
                alert('Gagal memuat detail laporan');
            }
        },
        error: function() {
            alert('Terjadi kesalahan');
        }
    });
}
</script>
@endsection