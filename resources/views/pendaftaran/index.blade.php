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
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Pendaftaran -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="p-3 bg-blue-100 rounded-lg">
                            <i class="fas fa-users text-blue-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-500">Total Pendaftaran</div>
                        <div class="text-2xl font-bold text-gray-900">{{ $pendaftaran->count() }}</div>
                    </div>
                </div>
            </div>

            <!-- Pending -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="p-3 bg-yellow-100 rounded-lg">
                            <i class="fas fa-clock text-yellow-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-500">Pending</div>
                        <div class="text-2xl font-bold text-gray-900">
                            {{ $pendaftaran->where('status', 'pending')->count() }}
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <div class="text-xs text-gray-500">
                        {{ $pendaftaran->count() > 0 ? round(($pendaftaran->where('status', 'pending')->count() / $pendaftaran->count()) * 100, 1) : 0 }}%
                        dari total
                    </div>
                </div>
            </div>

            <!-- Disetujui -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="p-3 bg-green-100 rounded-lg">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-500">Disetujui</div>
                        <div class="text-2xl font-bold text-gray-900">
                            {{ $pendaftaran->where('status', 'approved')->count() }}
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <div class="text-xs text-gray-500">
                        {{ $pendaftaran->count() > 0 ? round(($pendaftaran->where('status', 'approved')->count() / $pendaftaran->count()) * 100, 1) : 0 }}%
                        dari total
                    </div>
                </div>
            </div>

            <!-- Ditolak -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="p-3 bg-red-100 rounded-lg">
                            <i class="fas fa-times-circle text-red-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-500">Ditolak</div>
                        <div class="text-2xl font-bold text-gray-900">
                            {{ $pendaftaran->where('status', 'rejected')->count() }}
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <div class="text-xs text-gray-500">
                        {{ $pendaftaran->count() > 0 ? round(($pendaftaran->where('status', 'rejected')->count() / $pendaftaran->count()) * 100, 1) : 0 }}%
                        dari total
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Stats Cards (khusus untuk admin) -->
        @if(auth()->user()->role == 'admin')
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Sudah Ada Pendamping -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="p-3 bg-indigo-100 rounded-lg">
                                <i class="fas fa-user-tie text-indigo-600 text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-500">Sudah Ada Pendamping</div>
                            <div class="text-2xl font-bold text-gray-900">
                                {{ $pendaftaran->whereNotNull('pendamping_id')->count() }}
                            </div>
                        </div>
                    </div>
                    <div class="mt-2">
                        <div class="text-xs text-gray-500">
                            Dari {{ $pendaftaran->where('status', 'approved')->count() }} yang disetujui
                        </div>
                    </div>
                </div>

                <!-- Menunggu Pendamping -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="p-3 bg-purple-100 rounded-lg">
                                <i class="fas fa-user-clock text-purple-600 text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-500">Menunggu Pendamping</div>
                            <div class="text-2xl font-bold text-gray-900">
                                {{ $pendaftaran->where('status', 'approved')->whereNull('pendamping_id')->count() }}
                            </div>
                        </div>
                    </div>
                    <div class="mt-2">
                        <div class="text-xs text-gray-500">
                            Perlu segera ditugaskan
                        </div>
                    </div>
                </div>

                <!-- Pendaftaran Bulan Ini -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="p-3 bg-teal-100 rounded-lg">
                                <i class="fas fa-calendar-alt text-teal-600 text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-500">Bulan Ini</div>
                            <div class="text-2xl font-bold text-gray-900">
                                {{ $pendaftaran->filter(function ($item) {
                return $item->created_at->month == now()->month && $item->created_at->year == now()->year;
            })->count() }}
                            </div>
                        </div>
                    </div>
                    <div class="mt-2">
                        <div class="text-xs text-gray-500">
                            {{ \Carbon\Carbon::now()->format('M Y') }}
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Filters -->
        @if(auth()->user()->role == 'admin')
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <div class="flex flex-wrap items-center gap-4">
                    <div class="flex items-center space-x-2">
                        <label class="text-sm font-medium text-gray-700">Filter Status:</label>
                        <select id="statusFilter"
                            class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Status</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Disetujui</option>
                            <option value="rejected">Ditolak</option>
                        </select>
                    </div>
                    <div class="flex items-center space-x-2">
                        <label class="text-sm font-medium text-gray-700">Filter Komponen:</label>
                        <select id="komponenFilter"
                            class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Komponen</option>
                            <option value="ibu_hamil">Ibu Hamil</option>
                            <option value="balita">Balita</option>
                            <option value="lansia">Lansia</option>
                            <option value="anak_sd">Anak SD</option>
                            <option value="anak_smp">Anak SMP</option>
                            <option value="anak_sma">Anak SMA</option>
                            <option value="disabilitas_berat">Disabilitas Berat</option>
                            <option value="lanjut_usia">Lanjut Usia</option>
                        </select>
                    </div>
                    <div class="flex items-center space-x-2">
                        <label class="text-sm font-medium text-gray-700">Filter Pendamping:</label>
                        <select id="pendampingFilter"
                            class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua</option>
                            <option value="assigned">Sudah Ada Pendamping</option>
                            <option value="unassigned">Belum Ada Pendamping</option>
                        </select>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button onclick="resetFilters()"
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm hover:bg-gray-200 transition-colors">
                            <i class="fas fa-redo mr-1"></i>
                            Reset Filter
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex">
                    <i class="fas fa-check-circle text-green-600 mr-3 mt-0.5"></i>
                    <div class="text-green-800">{{ session('success') }}</div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex">
                    <i class="fas fa-exclamation-circle text-red-600 mr-3 mt-0.5"></i>
                    <div class="text-red-800">{{ session('error') }}</div>
                </div>
            </div>
        @endif

        <!-- Data Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900">Data Pendaftaran</h2>
                    <div class="text-sm text-gray-500">
                        Total: <span class="font-medium">{{ $pendaftaran->count() }}</span> data
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full" id="dataTable">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIK
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Alamat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No HP
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Komponen</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pendamping</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal Daftar</th>
                          
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($pendaftaran as $index => $p)
                            <tr class="hover:bg-gray-50" id="row-{{ $p->id }}">
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
                                            <div class="text-sm text-gray-500">{{ $p->tempat_lahir }},
                                                {{ \Carbon\Carbon::parse($p->tanggal_lahir)->format('d M Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    <div class="max-w-xs truncate">{{ $p->alamat }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $p->no_hp }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-wrap gap-1">
                                        @if($p->komponen)
                                            @php
                                                if (is_array($p->komponen)) {
                                                    $komponenArray = $p->komponen;
                                                } elseif (is_string($p->komponen)) {
                                                    $decoded = json_decode($p->komponen, true);
                                                    if (json_last_error() === JSON_ERROR_NONE) {
                                                        $komponenArray = $decoded;
                                                    } else {
                                                        $komponenArray = explode(', ', $p->komponen);
                                                    }
                                                } else {
                                                    $komponenArray = [];
                                                }

                                                $komponenLabels = [
                                                    'ibu_hamil' => ['label' => 'Ibu Hamil', 'color' => 'red'],
                                                    'balita' => ['label' => 'Balita', 'color' => 'pink'],
                                                    'lansia' => ['label' => 'Lansia', 'color' => 'gray'],
                                                    'anak_sd' => ['label' => 'Anak SD', 'color' => 'blue'],
                                                    'anak_smp' => ['label' => 'Anak SMP', 'color' => 'indigo'],
                                                    'anak_sma' => ['label' => 'Anak SMA', 'color' => 'purple'],
                                                    'disabilitas_berat' => ['label' => 'Disabilitas Berat', 'color' => 'green'],
                                                    'lanjut_usia' => ['label' => 'Lanjut Usia', 'color' => 'yellow'],
                                                ];
                                            @endphp
                                            @foreach($komponenArray as $komponen)
                                                @if(isset($komponenLabels[$komponen]))
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-{{ $komponenLabels[$komponen]['color'] }}-100 text-{{ $komponenLabels[$komponen]['color'] }}-800">
                                                        {{ $komponenLabels[$komponen]['label'] }}
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        {{ ucfirst(str_replace('_', ' ', $komponen)) }}
                                                    </span>
                                                @endif
                                            @endforeach
                                        @else
                                            <span class="text-gray-400 text-xs">-</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap" id="status-{{ $p->id }}">
                                    @if(auth()->user()->role == 'admin')
                                        <!-- Dropdown Status dengan Warna -->
                                        <select onchange="updateStatus({{ $p->id }}, this.value)" class="px-3 py-1 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 status-dropdown font-medium
                                                                @if($p->status == 'pending') 
                                                                    border-yellow-300 bg-yellow-50 text-yellow-800
                                                                @elseif($p->status == 'approved') 
                                                                    border-green-300 bg-green-50 text-green-800
                                                                @elseif($p->status == 'rejected') 
                                                                    border-red-300 bg-red-50 text-red-800
                                                                @else 
                                                                    border-gray-300 bg-gray-50 text-gray-800
                                                                @endif">
                                            <option value="pending" {{ $p->status == 'pending' ? 'selected' : '' }}>
                                                📋 Pending
                                            </option>
                                            <option value="approved" {{ $p->status == 'approved' ? 'selected' : '' }}>
                                                ✅ Disetujui
                                            </option>
                                            <option value="rejected" {{ $p->status == 'rejected' ? 'selected' : '' }}>
                                                ❌ Ditolak
                                            </option>
                                        </select>
                                    @else
                                        <!-- Display Status untuk Non-Admin -->
                                        @if($p->status == 'pending')
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-clock mr-1"></i>
                                                Pending
                                            </span>
                                        @elseif($p->status == 'approved')
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check mr-1"></i>
                                                Disetujui
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <i class="fas fa-times mr-1"></i>
                                                Ditolak
                                            </span>
                                        @endif
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap" id="pendamping-{{ $p->id }}">
                                    @if($p->pendamping_id)
                                        @php
                                            // Ambil data pendamping berdasarkan pendamping_id
                                            $pendamping = \App\Models\Pendamping::with('user')->find($p->pendamping_id);
                                        @endphp

                                        @if($pendamping)
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8">
                                                    <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                                                        <i class="fas fa-user-tie text-green-600 text-sm"></i>
                                                    </div>
                                                </div>
                                                <div class="ml-3">
                                                    <div class="text-sm font-medium text-gray-900">{{ $pendamping->user->name }}</div>
                                                    <div class="text-sm text-gray-500">{{ $pendamping->wilayah_kerja }}</div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-gray-400 text-sm">Pendamping tidak ditemukan</span>
                                        @endif
                                    @else
                                        <span class="text-gray-400 text-sm">Belum ada pendamping</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($p->created_at)->format('d M Y') }}
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ auth()->user()->role == 'admin' ? '10' : '9' }}"
                                    class="px-6 py-8 text-center text-sm text-gray-500">
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

    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 flex items-center space-x-4">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
            <span class="text-gray-700">Memproses...</span>
        </div>
    </div>

    <!-- Notification Toast -->
    <div id="toast" class="hidden fixed top-4 right-4 z-50 max-w-sm">
        <div class="bg-white border border-gray-200 rounded-lg shadow-lg p-4">
            <div class="flex items-center">
                <div id="toastIcon" class="flex-shrink-0 mr-3">
                    <!-- Icon will be inserted here -->
                </div>
                <div class="flex-1">
                    <p id="toastMessage" class="text-sm font-medium text-gray-900"></p>
                </div>
                <button onclick="hideToast()" class="ml-3 text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTable
    var table = $('#dataTable').DataTable({
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
    $('#statusFilter').on('change', function() {
        table.columns(6).search(this.value).draw();
    });

    $('#komponenFilter').on('change', function() {
        table.columns(5).search(this.value).draw();
    });

    $('#pendampingFilter').on('change', function() {
        var value = this.value;
        if (value === 'assigned') {
            table.columns(7).search('(?!.*Belum ada pendamping)(?!.*Pendamping tidak ditemukan).*', true, false).draw();
        } else if (value === 'unassigned') {
            table.columns(7).search('Belum ada pendamping|Pendamping tidak ditemukan', true, false).draw();
        } else {
            table.columns(7).search('').draw();
        }
    });

    // Initialize dropdown colors on page load
    $('.status-dropdown').each(function() {
        var dropdown = $(this);
        var status = dropdown.val();
        applyDropdownColor(dropdown, status);
    });
});

// Reset Filters Function
function resetFilters() {
    $('#statusFilter').val('');
    $('#komponenFilter').val('');
    $('#pendampingFilter').val('');

    var table = $('#dataTable').DataTable();
    table.columns().search('').draw();
}

// Update Status Function - Otomatis assign pendamping saat disetujui
function updateStatus(id, newStatus) {
    var dropdown = $('#status-' + id + ' select');
    var originalStatus = dropdown.data('original-status') || dropdown.val();

    dropdown.data('original-status', originalStatus);

    showLoading();

    $.ajax({
        url: '/pendaftaran/' + id + '/update-status',
        method: 'POST',
        data: {
            status: newStatus
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            hideLoading();
            if (response.success) {
                showToast('success', 'Status berhasil diperbarui');
                applyDropdownColor(dropdown, newStatus);
                dropdown.data('original-status', newStatus);

                // Update pendamping column otomatis saat disetujui
                if (response.data.pendamping_id && newStatus === 'approved') {
                    updatePendampingDisplay(id, response.data.pendamping_name, response.data.pendamping_wilayah);
                } else if (newStatus !== 'approved') {
                    clearPendampingDisplay(id);
                }

                // Update card counts
                setTimeout(function() {
                    location.reload();
                }, 1500);
            } else {
                showToast('error', response.message || 'Terjadi kesalahan');
                revertStatusDropdown(id, originalStatus);
            }
        },
        error: function(xhr) {
            hideLoading();
            var errorMessage = 'Terjadi kesalahan sistem';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            showToast('error', errorMessage);
            revertStatusDropdown(id, originalStatus);
        }
    });
}

// Update Pendamping Display
function updatePendampingDisplay(id, pendampingName, pendampingWilayah) {
    var pendampingCell = $('#pendamping-' + id);
    var html = `
        <div class="flex items-center">
            <div class="flex-shrink-0 h-8 w-8">
                <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                    <i class="fas fa-user-tie text-green-600 text-sm"></i>
                </div>
            </div>
            <div class="ml-3">
                <div class="text-sm font-medium text-gray-900">${pendampingName}</div>
                <div class="text-sm text-gray-500">${pendampingWilayah}</div>
            </div>
        </div>
    `;
    pendampingCell.html(html);
}

// Clear Pendamping Display
function clearPendampingDisplay(id) {
    var pendampingCell = $('#pendamping-' + id);
    var html = `
        <span class="text-gray-400 text-sm">Belum ada pendamping</span>
    `;
    pendampingCell.html(html);
}

// Apply Color to Dropdown Based on Status
function applyDropdownColor(dropdown, status) {
    dropdown.removeClass('border-yellow-300 bg-yellow-50 text-yellow-800');
    dropdown.removeClass('border-green-300 bg-green-50 text-green-800');
    dropdown.removeClass('border-red-300 bg-red-50 text-red-800');
    dropdown.removeClass('border-gray-300 bg-gray-50 text-gray-800');

    switch(status) {
        case 'pending':
            dropdown.addClass('border-yellow-300 bg-yellow-50 text-yellow-800');
            break;
        case 'approved':
            dropdown.addClass('border-green-300 bg-green-50 text-green-800');
            break;
        case 'rejected':
            dropdown.addClass('border-red-300 bg-red-50 text-red-800');
            break;
        default:
            dropdown.addClass('border-gray-300 bg-gray-50 text-gray-800');
    }
}

// Revert Status Dropdown
function revertStatusDropdown(id, originalStatus) {
    var dropdown = $('#status-' + id + ' select');
    dropdown.val(originalStatus);
    applyDropdownColor(dropdown, originalStatus);
}

// View Detail Function
function viewDetail(id) {
    showLoading();

    $.ajax({
        url: '/pendaftaran/' + id + '/detail',
        method: 'GET',
        success: function(response) {
            hideLoading();
            // You can implement modal to show details
            alert('Detail: ' + JSON.stringify(response.data));
        },
        error: function() {
            hideLoading();
            showToast('error', 'Gagal memuat detail');
        }
    });
}

// Loading Functions
function showLoading() {
    $('#loadingOverlay').removeClass('hidden');
}

function hideLoading() {
    $('#loadingOverlay').addClass('hidden');
}

// Toast Functions
function showToast(type, message) {
    var iconClass = type === 'success' ? 'fas fa-check-circle text-green-500' : 'fas fa-exclamation-circle text-red-500';
    var bgColor = type === 'success' ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200';

    $('#toastIcon').html('<i class="' + iconClass + '"></i>');
    $('#toastMessage').text(message);
    $('#toast .bg-white').removeClass('bg-white bg-green-50 bg-red-50 border-gray-200 border-green-200 border-red-200').addClass(bgColor);
    $('#toast').removeClass('hidden');

    setTimeout(function() {
        hideToast();
    }, 3000);
}

function hideToast() {
    $('#toast').addClass('hidden');
}
</script>
@endsection