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
                            <p class="text-sm text-gray-600"><i class="fas fa-phone mr-2"></i>{{ $pendampingProfile->no_hp }}
                            </p>
                            <p class="text-sm text-gray-600"><i
                                    class="fas fa-map-marker-alt mr-2"></i>{{ $pendampingProfile->wilayah_kerja }}</p>
                            <p class="text-sm text-gray-600"><i class="fas fa-home mr-2"></i>{{ $pendampingProfile->alamat }}
                            </p>
                        </div>
                    </div>
                    <div class="flex-shrink-0">
                        @if($pendampingProfile->status == 'aktif')
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i>
                                Aktif
                            </span>
                        @else
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
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

    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('.update-status-select').on('change', function () {
                var penerimaId = $(this).data('penerima-id');
                var newStatus = $(this).val();

                $.ajax({
                    url: '/pendamping/update-status/' + penerimaId,
                    method: 'POST',
                    data: {
                        status: newStatus,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.success) {
                            // Show success notification
                            showNotification('success', 'Status berhasil diperbarui');
                        } else {
                            showNotification('error', response.message || 'Terjadi kesalahan');
                        }
                    },
                    error: function () {
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