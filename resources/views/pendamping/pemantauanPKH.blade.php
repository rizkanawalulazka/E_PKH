
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
        <div class="text-sm text-gray-600">
            Total Penerima: {{ $penerima->count() }} orang
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
                        <p class="text-sm text-gray-600">{{ $person->email }}</p>
                    </div>
                </div>
                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                    Aktif
                </span>
            </div>

            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Pencairan 2024:</span>
                    <span class="text-sm font-medium">
                        {{ $person->pencairanDana->where('tahun', 2024)->where('status', 'dicairkan')->count() }}/4
                    </span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Kehadiran Bulan Ini:</span>
                    @php
                        $absenBulanIni = $person->absensiPertemuan->where('bulan', date('n'))->where('tahun', date('Y'))->first();
                    @endphp
                    <span class="text-sm font-medium">
                        @if($absenBulanIni)
                            @if($absenBulanIni->status == 'hadir')
                                <span class="text-green-600">✓ Hadir</span>
                            @else
                                <span class="text-red-600">✗ {{ ucfirst($absenBulanIni->status) }}</span>
                            @endif
                        @else
                            <span class="text-gray-500">Belum dicatat</span>
                        @endif
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
@endsection