@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-blue-100 rounded-lg">
                <i class="fas fa-clipboard-list text-blue-600 text-xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Daftar Laporan Pendampingan</h1>
        </div>
        <a href="{{ route('pendamping.laporan.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
            <i class="fas fa-plus mr-2"></i>
            Buat Laporan Baru
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
        <div class="flex">
            <i class="fas fa-check-circle text-green-600 mr-3 mt-0.5"></i>
            <div class="text-green-800">{{ session('success') }}</div>
        </div>
    </div>
    @endif

    <!-- Data Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Laporan Pendampingan</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full" id="laporanTable">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penerima</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Kegiatan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Verifikasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($laporans as $i => $laporan)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $i+1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ \Carbon\Carbon::parse($laporan->tanggal_kunjungan)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8">
                                    <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                        <i class="fas fa-user text-blue-600 text-xs"></i>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">{{ $laporan->penerima->nama }}</div>
                                    <div class="text-sm text-gray-500">{{ $laporan->penerima->nik }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ ucfirst(str_replace('_', ' ', $laporan->jenis_kegiatan)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <div class="max-w-xs truncate">{{ $laporan->lokasi_kegiatan }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <select class="update-status-laporan px-3 py-1 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" data-laporan-id="{{ $laporan->id }}">
                                <option value="draft" {{ $laporan->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="submitted" {{ $laporan->status == 'submitted' ? 'selected' : '' }}>Submitted</option>
                                <option value="approved" {{ $laporan->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ $laporan->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <select class="update-verifikasi-laporan px-3 py-1 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" data-laporan-id="{{ $laporan->id }}">
                                <option value="pending" {{ $laporan->verifikasi == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="verified" {{ $laporan->verifikasi == 'verified' ? 'selected' : '' }}>Verified</option>
                                <option value="rejected" {{ $laporan->verifikasi == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <button onclick="viewDetail({{ $laporan->id }})" class="inline-flex items-center px-3 py-1 bg-blue-600 text-white text-xs font-medium rounded-md hover:bg-blue-700 transition-colors">
                                    <i class="fas fa-eye mr-1"></i>
                                    Detail
                                </button>
                                <button onclick="editLaporan({{ $laporan->id }})" class="inline-flex items-center px-3 py-1 bg-yellow-600 text-white text-xs font-medium rounded-md hover:bg-yellow-700 transition-colors">
                                    <i class="fas fa-edit mr-1"></i>
                                    Edit
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-sm text-gray-500">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-clipboard-list text-gray-300 text-4xl mb-3"></i>
                                <p>Belum ada laporan pendampingan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Detail Laporan -->
<div id="detailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Detail Laporan Pendampingan</h3>
        </div>
        <div class="p-6" id="detailContent">
            <!-- Content will be loaded here -->
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            <div class="flex justify-end">
                <button onclick="closeModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#laporanTable').DataTable({
        responsive: true,
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        }
    });

    // Update status laporan
    $('.update-status-laporan').on('change', function() {
        var laporanId = $(this).data('laporan-id');
        var newStatus = $(this).val();
        
        $.ajax({
            url: '/pendamping/laporan/update-status/' + laporanId,
            method: 'POST',
            data: {
                status: newStatus,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.success) {
                    showNotification('success', 'Status laporan berhasil diperbarui');
                } else {
                    showNotification('error', response.message || 'Terjadi kesalahan');
                }
            },
            error: function() {
                showNotification('error', 'Terjadi kesalahan sistem');
            }
        });
    });
    
    // Update verifikasi laporan
    $('.update-verifikasi-laporan').on('change', function() {
        var laporanId = $(this).data('laporan-id');
        var newVerifikasi = $(this).val();
        
        $.ajax({
            url: '/pendamping/laporan/update-verifikasi/' + laporanId,
            method: 'POST',
            data: {
                verifikasi: newVerifikasi,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.success) {
                    showNotification('success', 'Status verifikasi berhasil diperbarui');
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

// Function untuk view detail
function viewDetail(laporanId) {
    $.ajax({
        url: '/pendamping/laporan/detail/' + laporanId,
        method: 'GET',
        success: function(response) {
            $('#detailContent').html(response.html);
            $('#detailModal').removeClass('hidden');
        },
        error: function() {
            showNotification('error', 'Gagal memuat detail laporan');
        }
    });
}

function editLaporan(laporanId) {
    window.location.href = '/pendamping/laporan/edit/' + laporanId;
}

function closeModal() {
    $('#detailModal').addClass('hidden');
}

function showNotification(type, message) {
    alert(message);
}
</script>
@endsection