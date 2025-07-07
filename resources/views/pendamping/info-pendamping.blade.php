
@extends('layouts.app')

@section('title', 'Info Pendamping')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center space-x-3">
        <div class="p-2 bg-blue-100 rounded-lg">
            <i class="fas fa-user-friends text-blue-600 text-xl"></i>
        </div>
        <h1 class="text-2xl font-bold text-gray-900">Info Pendamping</h1>
    </div>

    <!-- Content -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6">
            @if($pendaftaran && $pendaftaran->status === 'approved')
                @if($pendamping)
                    <!-- Pendamping Found -->
                    <div class="flex items-center space-x-4 p-6 bg-green-50 rounded-lg border border-green-200">
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user-check text-green-600 text-2xl"></i>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-green-900 mb-2">Pendamping Anda</h3>
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <i class="fas fa-user text-green-600 w-5 mr-3"></i>
                                    <span class="text-sm text-green-800">
                                        <strong>Nama:</strong> {{$pendamping->nama_lengkap }}
                                    </span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-phone text-green-600 w-5 mr-3"></i>
                                    <span class="text-sm text-green-800">
                                        <strong>No HP:</strong> {{ $pendamping->no_hp }}
                                    </span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-map-marker-alt text-green-600 w-5 mr-3"></i>
                                    <span class="text-sm text-green-800">
                                        <strong>Wilayah Kerja:</strong> {{ $pendamping->wilayah_kerja }}
                                    </span>
                                </div>
                                @if($pendamping->alamat)
                                <div class="flex items-center">
                                    <i class="fas fa-home text-green-600 w-5 mr-3"></i>
                                    <span class="text-sm text-green-800">
                                        <strong>Alamat:</strong> {{ $pendamping->alamat }}
                                    </span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Contact Actions -->
                    <div class="mt-6 flex space-x-4">
                        <a href="tel:{{ $pendamping->no_hp }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-phone mr-2"></i>
                            Hubungi via Telepon
                        </a>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pendamping->no_hp) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors">
                            <i class="fab fa-whatsapp mr-2"></i>
                            Chat WhatsApp
                        </a>
                    </div>

                    <!-- Additional Info -->
                    <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="flex items-center">
                            <i class="fas fa-info-circle text-blue-600 mr-3"></i>
                            <div>
                                <h4 class="font-medium text-blue-900">Informasi Penting</h4>
                                <p class="text-sm text-blue-800 mt-1">
                                    Pendamping Anda siap membantu dalam proses administrasi dan pemantauan program PKH. 
                                    Jangan ragu untuk menghubungi jika memerlukan bantuan.
                                </p>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- No Pendamping Assigned -->
                    <div class="flex items-center space-x-4 p-6 bg-yellow-50 rounded-lg border border-yellow-200">
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user-clock text-yellow-600 text-2xl"></i>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-yellow-900 mb-2">Pendamping Belum Ditugaskan</h3>
                            <p class="text-sm text-yellow-800">
                                Meskipun pendaftaran Anda telah disetujui, pendamping belum ditugaskan. 
                                Silakan hubungi admin untuk informasi lebih lanjut.
                            </p>
                        </div>
                    </div>
                @endif
            @elseif($pendaftaran && $pendaftaran->status === 'rejected')
                <!-- Registration Rejected -->
                <div class="flex items-center space-x-4 p-6 bg-red-50 rounded-lg border border-red-200">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-times text-red-600 text-2xl"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-red-900 mb-2">Pendaftaran Ditolak</h3>
                        <p class="text-sm text-red-800">
                            Pendaftaran Anda telah ditolak. Pendamping tidak tersedia untuk saat ini.
                        </p>
                        <div class="mt-4">
                            <a href="/pendaftaran/create" class="inline-flex items-center px-4 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors">
                                <i class="fas fa-redo mr-2"></i>
                                Daftar Ulang
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <!-- Waiting for Approval -->
                <div class="flex items-center space-x-4 p-6 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-hourglass-half text-gray-600 text-2xl"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Menunggu Persetujuan</h3>
                        <p class="text-sm text-gray-700">
                            Pendamping belum tersedia. Menunggu persetujuan admin untuk pendaftaran Anda.
                        </p>
                        <div class="mt-4 flex space-x-4">
                            <a href="{{ route('pendaftaran.pkh.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                <i class="fas fa-eye mr-2"></i>
                                Lihat Status Pendaftaran
                            </a>
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white font-medium rounded-lg hover:bg-gray-700 transition-colors">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Kembali ke Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Help Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Butuh Bantuan?</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-start space-x-3 p-4 bg-blue-50 rounded-lg">
                    <div class="flex-shrink-0">
                        <i class="fas fa-phone text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-blue-900">Hubungi Admin</h4>
                        <p class="text-sm text-blue-800 mt-1">
                            Telepon: (021) 123-4567<br>
                            Email: admin@pkh.go.id
                        </p>
                    </div>
                </div>
                <div class="flex items-start space-x-3 p-4 bg-green-50 rounded-lg">
                    <div class="flex-shrink-0">
                        <i class="fas fa-question-circle text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-green-900">FAQ</h4>
                        <p class="text-sm text-green-800 mt-1">
                            Lihat pertanyaan yang sering diajukan
                        </p>
                        <a href="#" class="text-sm text-green-600 hover:text-green-800 font-medium mt-2 inline-block">
                            Baca FAQ →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection