@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div>
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-red-100 rounded-lg">
                <i class="fas fa-user-shield text-red-600 text-xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Dashboard Admin</h1>
        </div>
    </div>

    <!-- Admin Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Total User</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2">{{ $totalUser }}</p>
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
                    <p class="text-2xl font-bold text-gray-900 mt-2">{{ $pendampingAktif }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <i class="fas fa-user-friends text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Pendaftaran Baru</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2">{{ $pendaftaranBaru }}</p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-full">
                    <i class="fas fa-file-alt text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Laporan Masuk</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2">{{ $laporanMasuk }}</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-full">
                    <i class="fas fa-clipboard-list text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h2>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('pendamping.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-user-friends mr-2"></i> Kelola Pendamping
                </a>
                <a href="{{ route('pendaftaran.pkh.index') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors">
                    <i class="fas fa-file-alt mr-2"></i> Data Pendaftaran
                </a>
                <a href="#" class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white font-medium rounded-lg hover:bg-yellow-600 transition-colors">
                    <i class="fas fa-chart-bar mr-2"></i> Laporan Statistik
                </a>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Aktivitas Terbaru</h2>
            <ul class="divide-y divide-gray-200">
                <li class="py-2 flex items-center">
                    <i class="fas fa-user-plus text-blue-500 mr-2"></i>
                    <span>Pendaftaran baru oleh <b>Ahmad</b></span>
                </li>
                <li class="py-2 flex items-center">
                    <i class="fas fa-user-friends text-green-500 mr-2"></i>
                    <span>Pendamping <b>Siti</b> menambahkan laporan</span>
                </li>
                <li class="py-2 flex items-center">
                    <i class="fas fa-file-alt text-yellow-500 mr-2"></i>
                    <span>Laporan baru masuk</span>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection