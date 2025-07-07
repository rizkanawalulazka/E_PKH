@extends('layouts.app')

@section('title', 'Pemantauan PKH')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-green-100 rounded-lg">
                <i class="fas fa-clipboard-check text-green-600 text-xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Pemantauan PKH</h1>
        </div>
        <div class="flex items-center space-x-4">
            <!-- Filter Tahun -->
            <div class="flex items-center space-x-2">
                <label for="yearFilter" class="text-sm font-medium text-gray-700">Tahun:</label>
                <select id="yearFilter" class="px-3 py-1 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach($availableYears as $year)
                        <option value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="text-sm text-gray-600">
                Total Penerima: {{ $penerima->count() }} orang
            </div>
        </div>
    </div>

    <!-- Daftar Penerima -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($penerima as $person)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-blue-100 rounded-full">
                        <i class="fas fa-user text-blue-600"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">{{ $person->name }}</h3>
                    </div>
                </div>
                @php
                    $statusPendaftaran = $person->pendaftaran->first()->status ?? 'unknown';
                @endphp
                <span class="px-2 py-1 {{ $statusPendaftaran == 'approved' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }} text-xs font-medium rounded-full">
                    {{ $statusPendaftaran == 'approved' ? 'Aktif' : ucfirst($statusPendaftaran) }}
                </span>
            </div>

            <div class="space-y-3">
                <!-- Pencairan Dinamis -->
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Pencairan <span class="year-display">{{ $currentYear }}</span>:</span>
                    @php
                        $pencairanCount = $person->pencairanDana->where('tahun', $currentYear)->where('status', 'dicairkan')->count();
                        $totalPencairan = $person->pencairanDana->where('tahun', $currentYear)->count();
                    @endphp
                    <span class="text-sm font-medium pencairan-count" data-person-id="{{ $person->id }}">
                        {{ $pencairanCount }}/{{ $totalPencairan > 0 ? $totalPencairan : 4 }}
                    </span>
                </div>

                <!-- Kehadiran Bulan Ini -->
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Kehadiran {{ \Carbon\Carbon::now()->format('F Y') }}:</span>
                    @php
                        $absenBulanIni = $person->absensiPertemuan
                            ->where('bulan', $currentMonth)
                            ->where('tahun', $currentYear)
                            ->first();
                    @endphp
                    <span class="text-sm font-medium">
                        @if($absenBulanIni)
                            @if($absenBulanIni->status == 'hadir')
                                <span class="text-green-600">✓ Hadir</span>
                            @elseif($absenBulanIni->status == 'tidak_hadir')
                                <span class="text-red-600">✗ Tidak Hadir</span>
                            @elseif($absenBulanIni->status == 'sakit')
                                <span class="text-yellow-600">⚕ Sakit</span>
                            @elseif($absenBulanIni->status == 'izin')
                                <span class="text-blue-600">📋 Izin</span>
                            @else
                                <span class="text-gray-600">{{ ucfirst($absenBulanIni->status) }}</span>
                            @endif
                        @else
                            <span class="text-gray-500">Belum dicatat</span>
                        @endif
                    </span>
                </div>

                <!-- Status Terakhir -->
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Status Terakhir:</span>
                    @php
                        $laporanTerakhir = $person->laporanBulanan
                            ->where('tahun', $currentYear)
                            ->sortByDesc('bulan')
                            ->first();
                    @endphp
                    <span class="text-sm font-medium">
                        @if($laporanTerakhir)
                            <span class="text-green-600">{{ \Carbon\Carbon::create($laporanTerakhir->tahun, $laporanTerakhir->bulan)->format('M Y') }}</span>
                        @else
                            <span class="text-gray-500">Belum ada laporan</span>
                        @endif
                    </span>
                </div>

                <!-- Total Pencairan -->
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Total Pencairan:</span>
                    @php
                        $totalDana = $person->pencairanDana
                            ->where('tahun', $currentYear)
                            ->where('status', 'dicairkan')
                            ->sum('jumlah');
                    @endphp
                    <span class="text-sm font-medium text-green-600">
                        Rp {{ number_format($totalDana, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            <div class="mt-4 pt-4 border-t border-gray-200">
                <a href="{{ route('pemantauan.show', $person->id) }}" 
                   class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-eye mr-2"></i>
                    Detail Pemantauan
                </a>
            </div>
        </div>
        @endforeach
    </div>

    @if($penerima->isEmpty())
    <div class="text-center py-12">
        <div class="p-4 bg-gray-100 rounded-full w-16 h-16 mx-auto mb-4">
            <i class="fas fa-users text-gray-400 text-2xl"></i>
        </div>
        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Penerima</h3>
        <p class="text-gray-600">Belum ada penerima PKH yang ditugaskan kepada Anda.</p>
    </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const yearFilter = document.getElementById('yearFilter');
    
    yearFilter.addEventListener('change', function() {
        const selectedYear = this.value;
        
        // Update tampilan tahun
        document.querySelectorAll('.year-display').forEach(function(element) {
            element.textContent = selectedYear;
        });
        
        // Update data pencairan via AJAX
        updatePencairanData(selectedYear);
    });
    
    function updatePencairanData(year) {
        fetch(`{{ route('pemantauan.update-year') }}?year=${year}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update data pencairan untuk setiap penerima
                data.pencairanData.forEach(function(item) {
                    const countElement = document.querySelector(`[data-person-id="${item.person_id}"]`);
                    if (countElement) {
                        countElement.textContent = `${item.pencairan_count}/${item.total_pencairan > 0 ? item.total_pencairan : 4}`;
                    }
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
});
</script>
@endsection