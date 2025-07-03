@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center space-x-3">
        <div class="p-2 bg-blue-100 rounded-lg">
            <i class="fas fa-user-friends text-blue-600 text-xl"></i>
        </div>
        <h1 class="text-2xl font-bold text-gray-900">Dashboard Pendamping</h1>
    </div>

    @if(auth()->user()->role === 'pendamping' && $pendampingProfile)
    <!-- Info Pendamping Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center space-x-4">
            <div class="flex-shrink-0">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-blue-600 text-2xl"></i>
                </div>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-gray-900">{{ $pendampingProfile->nama_lengkap }}</h3>
                <div class="mt-2 space-y-1">
                    <p class="text-sm text-gray-600"><i class="fas fa-phone mr-2"></i>{{ $pendampingProfile->no_hp }}</p>
                    <p class="text-sm text-gray-600"><i class="fas fa-map-marker-alt mr-2"></i>{{ $pendampingProfile->wilayah_kerja }}</p>
                    <p class="text-sm text-gray-600"><i class="fas fa-home mr-2"></i>{{ $pendampingProfile->alamat }}</p>
                </div>
            </div>
            <div class="flex-shrink-0">
                @if($pendampingProfile->status == 'aktif')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        <i class="fas fa-check-circle mr-1"></i>
                        Aktif
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                        <i class="fas fa-times-circle mr-1"></i>
                        Tidak Aktif
                    </span>
                @endif
            </div>
        </div>
    </div>
    @endif

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Penerima Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Total Penerima</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2">{{ $totalPenerima ?? 0 }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-full">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Penerima Selesai Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Penerima Selesai</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2">{{ $penerimaSelesai ?? 0 }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Penerima Proses Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Penerima Proses</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2">{{ $penerimaProses ?? 0 }}</p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-full">
                    <i class="fas fa-hourglass-half text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Belum Didampingi Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Belum Didampingi</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2">{{ $belumDidampingi ?? 0 }}</p>
                </div>
                <div class="p-3 bg-red-100 rounded-full">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Penerima -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Daftar Penerima</h2>
                <a href="{{ route('pendamping.laporan.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Buat Laporan
                </a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Penerima</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIK</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No HP</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Komponen</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($penerima as $i => $p)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $i+1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                        <i class="fas fa-user text-blue-600"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $p->nama }}</div>
                                    <div class="text-sm text-gray-500">{{ $p->tempat_lahir }}, {{ \Carbon\Carbon::parse($p->tanggal_lahir)->format('d M Y') }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $p->nik }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <div class="max-w-xs truncate">{{ $p->alamat }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $p->no_hp }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-wrap gap-1">
                                @if(is_array($p->komponen))
                                    @foreach($p->komponen as $komponen)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($komponen == 'kesehatan') bg-red-100 text-red-800
                                            @elseif($komponen == 'pendidikan') bg-blue-100 text-blue-800
                                            @else bg-green-100 text-green-800
                                            @endif">
                                            {{ ucfirst(str_replace('_', ' ', $komponen)) }}
                                        </span>
                                    @endforeach
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <select class="update-status-select px-3 py-1 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" data-penerima-id="{{ $p->id }}">
                                <option value="belum_didampingi" {{ $p->status_pendampingan == 'belum_didampingi' ? 'selected' : '' }}>Belum Didampingi</option>
                                <option value="dalam_proses" {{ $p->status_pendampingan == 'dalam_proses' ? 'selected' : '' }}>Dalam Proses</option>
                                <option value="selesai" {{ $p->status_pendampingan == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('pendamping.laporan.create', ['penerima_id' => $p->id]) }}" class="inline-flex items-center px-3 py-1 bg-blue-600 text-white text-xs font-medium rounded-md hover:bg-blue-700 transition-colors">
                                <i class="fas fa-plus mr-1"></i>
                                Buat Laporan
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-sm text-gray-500">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-users text-gray-300 text-4xl mb-3"></i>
                                <p>Belum ada data penerima</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
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
        
        $.ajax({
            url: '/pendamping/update-status/' + penerimaId,
            method: 'POST',
            data: {
                status: newStatus,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.success) {
                    // Show success notification
                    showNotification('success', 'Status berhasil diperbarui');
                } else {
                    showNotification('error', response.message || 'Terjadi kesalahan');
                }
            },
            error: function() {
                showNotification('error', 'Terjadi kesalahan sistem');
            }
        });
    });
});

function showNotification(type, message) {
    // Simple notification implementation
    alert(message);
}
</script>
@endsection