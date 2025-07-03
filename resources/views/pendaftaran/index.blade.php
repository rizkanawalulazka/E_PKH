@extends('layouts.app')

@section('title', 'Daftar Pendaftaran PKH')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-blue-100 rounded-lg">
                <i class="fas fa-table text-blue-600 text-xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Daftar Pendaftaran PKH</h1>
        </div>
        @if(auth()->user()->role == 'penerima')
        <a href="/pendaftaran/create" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
            <i class="fas fa-plus mr-2"></i>
            Daftar Baru
        </a>
        @endif
    </div>

    <!-- Filters -->
    @if(auth()->user()->role == 'admin')
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <div class="flex flex-wrap items-center gap-4">
            <div class="flex items-center space-x-2">
                <label class="text-sm font-medium text-gray-700">Filter Status:</label>
                <select id="statusFilter" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Disetujui</option>
                    <option value="rejected">Ditolak</option>
                </select>
            </div>
            <div class="flex items-center space-x-2">
                <label class="text-sm font-medium text-gray-700">Filter Komponen:</label>
                <select id="komponenFilter" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Komponen</option>
                    <option value="kesehatan">Kesehatan</option>
                    <option value="pendidikan">Pendidikan</option>
                    <option value="kesejahteraan_sosial">Kesejahteraan Sosial</option>
                </select>
            </div>
        </div>
    </div>
    @endif

    <!-- Data Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Data Pendaftaran</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full" id="dataTable">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIK</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No HP</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Komponen</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Daftar</th>
                        @if(auth()->user()->role == 'admin')
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pendaftaran as $index => $p)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $p->nik }}</td>
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
                            @if($p->status == 'pending')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1"></i>
                                    Pending
                                </span>
                            @elseif($p->status == 'approved')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check mr-1"></i>
                                    Disetujui
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-times mr-1"></i>
                                    Ditolak
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($p->created_at)->format('d M Y') }}
                        </td>
                        @if(auth()->user()->role == 'admin')
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            @if($p->status == 'pending')
                                <div class="flex space-x-2">
                                    <button onclick="approveRegistration({{ $p->id }})" 
                                            class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        <i class="fas fa-check mr-1"></i>
                                        Setujui
                                    </button>
                                    <button onclick="rejectRegistration({{ $p->id }})" 
                                            class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        <i class="fas fa-times mr-1"></i>
                                        Tolak
                                    </button>
                                </div>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-8 text-center text-sm text-gray-500">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-inbox text-gray-300 text-4xl mb-3"></i>
                                <p>Belum ada data pendaftaran</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi -->
<div id="confirmModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4">
        <div class="text-center">
            <div id="modalIcon" class="p-4 rounded-full w-16 h-16 mx-auto mb-4">
                <i id="modalIconClass" class="text-2xl"></i>
            </div>
            <h3 id="modalTitle" class="text-lg font-semibold text-gray-900 mb-2"></h3>
            <p id="modalMessage" class="text-gray-600 mb-6"></p>
            <div class="flex space-x-3">
                <button id="cancelBtn" class="flex-1 bg-gray-200 text-gray-800 py-2 px-4 rounded-lg hover:bg-gray-300 transition-colors">
                    Batal
                </button>
                <button id="confirmBtn" class="flex-1 py-2 px-4 rounded-lg transition-colors font-medium">
                    Konfirmasi
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
    $('#dataTable').DataTable({
        "responsive": true,
        "order": [[ 0, "asc" ]],
        "pageLength": 10,
        "language": {
            "search": "Cari:",
            "lengthMenu": "Tampilkan _MENU_ data per halaman",
            "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            "infoEmpty": "Tidak ada data yang ditampilkan",
            "infoFiltered": "(difilter dari _MAX_ total data)",
            "paginate": {
                "first": "Pertama",
                "last": "Terakhir",
                "next": "Selanjutnya",
                "previous": "Sebelumnya"
            }
        }
    });

    // Filter functionality
    $('#statusFilter, #komponenFilter').on('change', function() {
        var table = $('#dataTable').DataTable();
        var statusFilter = $('#statusFilter').val();
        var komponenFilter = $('#komponenFilter').val();
        
        table.columns(6).search(statusFilter).draw();
        table.columns(5).search(komponenFilter).draw();
    });

    // Modal controls
    $('#cancelBtn').on('click', function() {
        $('#confirmModal').addClass('hidden');
    });
});

function approveRegistration(id) {
    showConfirmModal(
        'Setujui Pendaftaran',
        'Apakah Anda yakin ingin menyetujui pendaftaran ini?',
        'approve',
        function() {
            $.ajax({
                url: '/pendaftaran/' + id + '/approve',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        showNotification('success', 'Pendaftaran berhasil disetujui');
                        location.reload();
                    } else {
                        showNotification('error', response.message || 'Terjadi kesalahan');
                    }
                },
                error: function() {
                    showNotification('error', 'Terjadi kesalahan sistem');
                }
            });
        }
    );
}

function rejectRegistration(id) {
    showConfirmModal(
        'Tolak Pendaftaran',
        'Apakah Anda yakin ingin menolak pendaftaran ini?',
        'reject',
        function() {
            $.ajax({
                url: '/pendaftaran/' + id + '/reject',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        showNotification('success', 'Pendaftaran berhasil ditolak');
                        location.reload();
                    } else {
                        showNotification('error', response.message || 'Terjadi kesalahan');
                    }
                },
                error: function() {
                    showNotification('error', 'Terjadi kesalahan sistem');
                }
            });
        }
    );
}

function showConfirmModal(title, message, type, callback) {
    $('#modalTitle').text(title);
    $('#modalMessage').text(message);
    
    if (type === 'approve') {
        $('#modalIcon').removeClass().addClass('p-4 bg-green-100 rounded-full w-16 h-16 mx-auto mb-4');
        $('#modalIconClass').removeClass().addClass('fas fa-check text-green-600 text-2xl');
        $('#confirmBtn').removeClass().addClass('flex-1 bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition-colors font-medium');
    } else {
        $('#modalIcon').removeClass().addClass('p-4 bg-red-100 rounded-full w-16 h-16 mx-auto mb-4');
        $('#modalIconClass').removeClass().addClass('fas fa-times text-red-600 text-2xl');
        $('#confirmBtn').removeClass().addClass('flex-1 bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition-colors font-medium');
    }
    
    $('#confirmBtn').off('click').on('click', function() {
        $('#confirmModal').addClass('hidden');
        callback();
    });
    
    $('#confirmModal').removeClass('hidden');
}

function showNotification(type, message) {
    // You can implement toast notifications here
    alert(message);
}
</script>
@endsection