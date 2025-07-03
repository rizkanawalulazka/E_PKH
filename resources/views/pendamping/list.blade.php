@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center space-x-3">
        <div class="p-2 bg-blue-100 rounded-lg">
            <i class="fas fa-user-friends text-blue-600 text-xl"></i>
        </div>
        <h1 class="text-2xl font-bold text-gray-900">Daftar Pendamping</h1>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Total Pendamping</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2">{{ isset($pendampings) ? $pendampings->count() : 0 }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-full">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Pendamping Aktif</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2">{{ isset($pendampings) ? $pendampings->where('status', 'aktif')->count() : 0 }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <i class="fas fa-user-check text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Wilayah Kerja</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2">{{ isset($pendampings) ? $pendampings->pluck('wilayah_kerja')->unique()->count() : 0 }}</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-full">
                    <i class="fas fa-map-marked-alt text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Data Pendamping</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full" id="pendampingTable">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pendamping</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIK</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kontak</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Wilayah Kerja</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @if(isset($pendampings) && $pendampings->count() > 0)
                        @foreach($pendampings as $i => $p)
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
                                        <div class="text-sm font-medium text-gray-900">{{ $p->nama_lengkap ?? 'Tidak ada nama' }}</div>
                                        <div class="text-sm text-gray-500">{{ $p->user ? $p->user->email : 'Tidak ada email' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $p->user ? $p->user->nik : 'Tidak ada NIK' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $p->no_hp ?? 'Tidak ada no HP' }}</div>
                                @if($p->no_hp)
                                <div class="flex space-x-2 mt-1">
                                    <a href="tel:{{ $p->no_hp }}" class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-phone text-xs"></i>
                                    </a>
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $p->no_hp) }}" target="_blank" class="text-green-600 hover:text-green-800">
                                        <i class="fab fa-whatsapp text-xs"></i>
                                    </a>
                                </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    {{ $p->wilayah_kerja ?? 'Tidak ada wilayah' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <div class="max-w-xs truncate">{{ $p->alamat ?? 'Tidak ada alamat' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($p->status == 'aktif')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i>
                                        Tidak Aktif
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-sm text-gray-500">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-user-friends text-gray-300 text-4xl mb-3"></i>
                                    <p>Belum ada data pendamping</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('#pendampingTable').DataTable({
        responsive: true,
        processing: true,
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Tidak ada data yang ditampilkan",
            infoFiltered: "(difilter dari _MAX_ total data)",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Selanjutnya",
                previous: "Sebelumnya"
            },
            emptyTable: "Tidak ada data tersedia",
            zeroRecords: "Tidak ditemukan data yang sesuai"
        }
    });
});
</script>
@endsection