@extends('layouts.app')

@section('title', 'Buat Laporan Pendampingan')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center space-x-3">
        <div class="p-2 bg-blue-100 rounded-lg">
            <i class="fas fa-plus text-blue-600 text-xl"></i>
        </div>
        <h1 class="text-2xl font-bold text-gray-900">Buat Laporan Pendampingan</h1>
    </div>

    <!-- Form Buat Laporan -->
    @if(isset($penerima) && $penerima)
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Informasi Penerima</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-blue-600"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-900">{{ $penerima->nama }}</h3>
                        <p class="text-sm text-gray-500">NIK: {{ $penerima->nik }}</p>
                        <p class="text-sm text-gray-500">HP: {{ $penerima->no_hp }}</p>
                    </div>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg">
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Komponen Bantuan</h4>
                    <div class="flex flex-wrap gap-2">
                        @if(is_array($penerima->komponen))
                            @foreach($penerima->komponen as $komponen)
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
                </div>
            </div>

            <!-- Form Laporan -->
            <form action="{{ route('pendamping.laporan.store') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="penerima_id" value="{{ $penerima->id }}">
                
                <div>
                    <label for="tanggal_kunjungan" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Kunjungan <span class="text-red-500">*</span></label>
                    <input type="date" id="tanggal_kunjungan" name="tanggal_kunjungan" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label for="jenis_kegiatan" class="block text-sm font-medium text-gray-700 mb-2">Jenis Kegiatan <span class="text-red-500">*</span></label>
                    <select id="jenis_kegiatan" name="jenis_kegiatan" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Pilih Jenis Kegiatan</option>
                        <option value="kunjungan_rumah">Kunjungan Rumah</option>
                        <option value="konsultasi">Konsultasi</option>
                        <option value="verifikasi_data">Verifikasi Data</option>
                        <option value="sosialisasi">Sosialisasi</option>
                        <option value="monitoring">Monitoring</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>

                <div>
                    <label for="lokasi_kegiatan" class="block text-sm font-medium text-gray-700 mb-2">Lokasi Kegiatan <span class="text-red-500">*</span></label>
                    <input type="text" id="lokasi_kegiatan" name="lokasi_kegiatan" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Masukkan lokasi kegiatan">
                </div>

                <div>
                    <label for="deskripsi_kegiatan" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Kegiatan <span class="text-red-500">*</span></label>
                    <textarea id="deskripsi_kegiatan" name="deskripsi_kegiatan" rows="4" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Deskripsikan kegiatan yang dilakukan..."></textarea>
                </div>

                <div>
                    <label for="hasil_kegiatan" class="block text-sm font-medium text-gray-700 mb-2">Hasil Kegiatan <span class="text-red-500">*</span></label>
                    <textarea id="hasil_kegiatan" name="hasil_kegiatan" rows="4" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Jelaskan hasil dari kegiatan yang dilakukan..."></textarea>
                </div>

                <div>
                    <label for="kendala" class="block text-sm font-medium text-gray-700 mb-2">Kendala (Opsional)</label>
                    <textarea id="kendala" name="kendala" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Jelaskan kendala yang dihadapi (jika ada)..."></textarea>
                </div>

                <div>
                    <label for="tindak_lanjut" class="block text-sm font-medium text-gray-700 mb-2">Tindak Lanjut (Opsional)</label>
                    <textarea id="tindak_lanjut" name="tindak_lanjut" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Jelaskan rencana tindak lanjut (jika ada)..."></textarea>
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Laporan
                    </button>
                    <a href="{{ route('pendamping.index') }}" class="px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
    @else
    <div class="bg-red-50 border border-red-200 rounded-lg p-6">
        <div class="flex">
            <i class="fas fa-exclamation-triangle text-red-600 mr-3 mt-0.5"></i>
            <div>
                <h3 class="text-lg font-medium text-red-900">Data Tidak Ditemukan</h3>
                <p class="text-red-800 mt-1">Data penerima tidak ditemukan atau tidak valid. Silakan kembali dan pilih penerima yang benar.</p>
                <div class="mt-4">
                    <a href="{{ route('pendamping.index') }}" class="inline-flex items-center px-4 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection