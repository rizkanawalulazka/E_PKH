@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-friends mr-2"></i>
            Dashboard Pendamping
            @if(auth()->user()->role === 'pendamping' && $pendampingProfile)
                <small class="text-muted">- {{ $pendampingProfile->user->name }}</small>
            @endif
        </h1>
    </div>

    @if(auth()->user()->role === 'pendamping' && $pendampingProfile)
    <!-- Info Pendamping Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-left-info shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="card-title text-info">
                                <i class="fas fa-user-tie mr-2"></i>Informasi Pendamping
                            </h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Nama:</strong> {{ $pendampingProfile->user->name }}</p>
                                    <p class="mb-1"><strong>Email:</strong> {{ $pendampingProfile->user->email }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>No. HP:</strong> {{ $pendampingProfile->no_hp ?? '-' }}</p>
                                    <p class="mb-1"><strong>Alamat:</strong> {{ $pendampingProfile->alamat ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-right">
                            <div class="text-info">
                                <i class="fas fa-users fa-3x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Content Row - Statistics -->
    <div class="row">
        <!-- Total Penerima Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Penerima Didampingi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPenerima }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Penerima Selesai Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Selesai Didampingi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $penerimaSelesai }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Penerima Proses Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Dalam Proses</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $penerimaProses }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Belum Didampingi Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                Belum Didampingi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $penerimaBelumDidampingi }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Daftar Penerima -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        @if(auth()->user()->role === 'pendamping')
                            Daftar Penerima yang Saya Dampingi
                        @else
                            Daftar Penerima Bantuan
                        @endif
                    </h6>
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
                                    <th>Status Pendampingan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($penerima->take(5) as $p)
                                <tr>
                                    <td>{{ $p->nik }}</td>
                                    <td>{{ $p->name }}</td>
                                    <td>
                                        @php
                                            $statusClass = '';
                                            $statusText = 'Belum Didampingi';
                                            if ($p->report_status) {
                                                $statusText = $p->report_status;
                                                $statusClass = (
                                                    $p->report_status === 'Selesai' ? 'badge-success' :
                                                    ($p->report_status === 'Proses' ? 'badge-warning' : 'badge-secondary')
                                                );
                                            } else {
                                                $statusClass = 'badge-secondary';
                                            }
                                        @endphp
                                        @if($p->report_status && auth()->user()->role === 'pendamping')
                                            <select class="form-control form-control-sm update-status-select" data-penerima-id="{{ $p->id }}">
                                                <option value="Proses" {{ $p->report_status === 'Proses' ? 'selected' : '' }}>Proses</option>
                                                <option value="Selesai" {{ $p->report_status === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                            </select>
                                        @else
                                            <span class="badge {{ $statusClass }} status-display-{{ $p->id }}">{{ $statusText }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(auth()->user()->role === 'pendamping')
                                            <a href="{{ route('pendamping.laporan.buat', $p->id) }}" 
                                               class="btn btn-primary btn-sm">
                                                <i class="fas fa-plus fa-sm"></i> Buat Laporan
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">
                                        @if(auth()->user()->role === 'pendamping')
                                            Belum ada penerima yang didampingi
                                        @else
                                            Tidak ada data penerima
                                        @endif
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
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('.update-status-select').on('change', function() {
        var penerimaId = $(this).data('penerima-id');
        var newStatus = $(this).val();
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var statusSpan = $('.status-display-' + penerimaId);

        $.ajax({
            url: '/pendamping/penerima/' + penerimaId + '/update-status',
            method: 'POST',
            data: {
                _token: csrfToken,
                status: newStatus
            },
            success: function(response) {
                if (response.success) {
                    // Update tampilan badge jika ada
                    if (statusSpan.length > 0) {
                        statusSpan.text(response.new_status);
                        statusSpan.removeClass('badge-success badge-warning badge-secondary');
                        if (response.new_status === 'Selesai') {
                            statusSpan.addClass('badge-success');
                        } else if (response.new_status === 'Proses') {
                            statusSpan.addClass('badge-warning');
                        } else {
                            statusSpan.addClass('badge-secondary');
                        }
                    }
                    
                    // Refresh halaman untuk update statistik
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                    
                    alert(response.message);
                } else {
                    alert('Gagal memperbarui status: ' + response.message);
                }
            },
            error: function(xhr) {
                var errorMessage = 'Terjadi kesalahan.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.responseText) {
                    errorMessage = xhr.responseText;
                }
                alert('Error: ' + errorMessage);
            }
        });
    });
});
</script>
@endsection