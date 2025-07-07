@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center space-x-3">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <i class="fas fa-tachometer-alt text-blue-600 text-xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
            </div>
         
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Bantuan -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">
                            Total Bantuan ({{ date('Y') }})
                        </p>
                        <p class="text-2xl font-bold text-gray-900 mt-2">
                            Rp {{ number_format($totalBantuanTahunIni, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-full">
                        <i class="fas fa-calendar text-blue-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-sm text-gray-500">
                        <i class="fas fa-info-circle mr-1"></i>
                        Total pencairan tahun ini
                    </div>
                </div>
            </div>

            <!-- Rata-rata Bantuan -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">
                            Rata-rata Bantuan (Bulanan)
                        </p>
                        <p class="text-2xl font-bold text-gray-900 mt-2">
                            Rp {{ number_format($rataBantuanBulanan, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-full">
                        <i class="fas fa-dollar-sign text-green-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-sm text-gray-500">
                        <i class="fas fa-chart-line mr-1"></i>
                        Per bulan di {{ date('Y') }}
                    </div>
                </div>
            </div>

            <!-- Jumlah Penerima -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Jumlah Penerima</p>
                        <p class="text-2xl font-bold text-gray-900 mt-2">{{ $totalPenerima }}</p>
                    </div>
                    <div class="p-3 bg-cyan-100 rounded-full">
                        <i class="fas fa-users text-cyan-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-sm text-gray-500">
                        <i class="fas fa-check-circle mr-1"></i>
                        Penerima aktif
                    </div>
                </div>
            </div>

            <!-- Pengajuan Pending -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Pengajuan Pending</p>
                        <p class="text-2xl font-bold text-gray-900 mt-2">{{ $pendingPengajuan }}</p>
                    </div>
                    <div class="p-3 bg-yellow-100 rounded-full">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-sm text-gray-500">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        Menunggu persetujuan
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Cards untuk Penerima -->
        @if(auth()->user()->role === 'penerima' && isset($additionalData['total_diterima']))
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center mb-4">
                    <div class="p-2 bg-green-100 rounded-lg mr-3">
                        <i class="fas fa-wallet text-green-600 text-xl"></i>
                    </div>
                    <h2 class="text-lg font-semibold text-gray-900">Status Bantuan Anda</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-green-50 rounded-lg p-4">
                        <div class="text-sm text-gray-600">Total Bantuan Diterima</div>
                        <div class="text-2xl font-bold text-green-600">
                            Rp {{ number_format($additionalData['total_diterima'], 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="bg-blue-50 rounded-lg p-4">
                        <div class="text-sm text-gray-600">Status Pendaftaran</div>
                        <div class="text-lg font-semibold text-blue-600">
                            @if($additionalData['pendaftaran']->isNotEmpty())
                                {{ ucfirst($additionalData['pendaftaran']->first()->status) }}
                            @else
                                Belum Daftar
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Additional Cards untuk Pendamping -->
        @if(auth()->user()->role === 'pendamping')
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center mb-4">
                    <div class="p-2 bg-purple-100 rounded-lg mr-3">
                        <i class="fas fa-user-tie text-purple-600 text-xl"></i>
                    </div>
                    <h2 class="text-lg font-semibold text-gray-900">Ringkasan Pendampingan</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-purple-50 rounded-lg p-4">
                        <div class="text-sm text-gray-600">Jumlah Penerima</div>
                        <div class="text-2xl font-bold text-purple-600">
                            {{ $additionalData['jumlah_penerima'] ?? 0 }}
                        </div>
                    </div>
                    <div class="bg-indigo-50 rounded-lg p-4">
                        <div class="text-sm text-gray-600">Pencairan Bulan Ini</div>
                        <div class="text-lg font-semibold text-indigo-600">
                            Rp {{ number_format($additionalData['pencairan_bulan_ini'] ?? 0, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Besaran Bantuan PKH -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center mb-6">
                <div class="p-2 bg-green-100 rounded-lg mr-3">
                    <i class="fas fa-money-bill-wave text-green-600 text-xl"></i>
                </div>
                <h2 class="text-lg font-semibold text-gray-900">Besaran Bantuan PKH per Tahun</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <div class="flex items-center">
                        <i class="fas fa-baby text-blue-600 mr-3"></i>
                        <span class="text-sm font-medium text-gray-800">Ibu Hamil / Nifas</span>
                    </div>
                    <span class="text-sm font-bold text-blue-700">Rp 3.000.000</span>
                </div>

                <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg border border-green-200">
                    <div class="flex items-center">
                        <i class="fas fa-child text-green-600 mr-3"></i>
                        <span class="text-sm font-medium text-gray-800">Anak Usia Dini (0-6 Tahun)</span>
                    </div>
                    <span class="text-sm font-bold text-green-700">Rp 3.000.000</span>
                </div>

                <div class="flex items-center justify-between p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                    <div class="flex items-center">
                        <i class="fas fa-school text-yellow-600 mr-3"></i>
                        <span class="text-sm font-medium text-gray-800">Anak SD / Sederajat</span>
                    </div>
                    <span class="text-sm font-bold text-yellow-700">Rp 900.000</span>
                </div>

                <div class="flex items-center justify-between p-4 bg-purple-50 rounded-lg border border-purple-200">
                    <div class="flex items-center">
                        <i class="fas fa-graduation-cap text-purple-600 mr-3"></i>
                        <span class="text-sm font-medium text-gray-800">Anak SMP / Sederajat</span>
                    </div>
                    <span class="text-sm font-bold text-purple-700">Rp 1.500.000</span>
                </div>

                <div class="flex items-center justify-between p-4 bg-red-50 rounded-lg border border-red-200">
                    <div class="flex items-center">
                        <i class="fas fa-user-graduate text-red-600 mr-3"></i>
                        <span class="text-sm font-medium text-gray-800">Anak SMA / Sederajat</span>
                    </div>
                    <span class="text-sm font-bold text-red-700">Rp 2.000.000</span>
                </div>

                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="flex items-center">
                        <i class="fas fa-user-clock text-gray-600 mr-3"></i>
                        <span class="text-sm font-medium text-gray-800">Lansia (70+ tahun)</span>
                    </div>
                    <span class="text-sm font-bold text-gray-700">Rp 2.400.000</span>
                </div>

                <div class="flex items-center justify-between p-4 bg-indigo-50 rounded-lg border border-indigo-200 md:col-span-2 lg:col-span-1">
                    <div class="flex items-center">
                        <i class="fas fa-wheelchair text-indigo-600 mr-3"></i>
                        <span class="text-sm font-medium text-gray-800">Penyandang Disabilitas Berat</span>
                    </div>
                    <span class="text-sm font-bold text-indigo-700">Rp 2.400.000</span>
                </div>
            </div>
        </div>

        
        <!-- Tabel Detail Komponen -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center mb-6">
                <div class="p-2 bg-purple-100 rounded-lg mr-3">
                    <i class="fas fa-list text-purple-600 text-xl"></i>
                </div>
                <h2 class="text-lg font-semibold text-gray-900">Rincian Komponen PKH</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Kesehatan -->
                <div class="bg-red-50 rounded-lg p-4 border border-red-200">
                    <h3 class="font-semibold text-red-800 mb-4 flex items-center">
                        <i class="fas fa-heartbeat mr-2"></i>
                        Kesehatan
                    </h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-700">Ibu Hamil</span>
                            <span class="font-semibold text-red-600">{{ $komponenData['Ibu Hamil'] ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-700">Balita (0-5 tahun)</span>
                            <span class="font-semibold text-red-600">{{ $komponenData['Balita (0-5 tahun)'] ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-700">Lansia (60+ tahun)</span>
                            <span class="font-semibold text-red-600">{{ $komponenData['Lansia (60+ tahun)'] ?? 0 }}</span>
                        </div>
                        <div class="border-t border-red-300 pt-2">
                            <div class="flex justify-between items-center font-semibold">
                                <span class="text-red-800">Total</span>
                                <span class="text-red-800">{{ $komponenKategori['Kesehatan'] ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pendidikan -->
                <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                    <h3 class="font-semibold text-blue-800 mb-4 flex items-center">
                        <i class="fas fa-graduation-cap mr-2"></i>
                        Pendidikan
                    </h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-700">Anak SD/MI</span>
                            <span class="font-semibold text-blue-600">{{ $komponenData['Anak SD/MI'] ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-700">Anak SMP/MTs</span>
                            <span class="font-semibold text-blue-600">{{ $komponenData['Anak SMP/MTs'] ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-700">Anak SMA/MA</span>
                            <span class="font-semibold text-blue-600">{{ $komponenData['Anak SMA/MA'] ?? 0 }}</span>
                        </div>
                        <div class="border-t border-blue-300 pt-2">
                            <div class="flex justify-between items-center font-semibold">
                                <span class="text-blue-800">Total</span>
                                <span class="text-blue-800">{{ $komponenKategori['Pendidikan'] ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kesejahteraan Sosial -->
                <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                    <h3 class="font-semibold text-green-800 mb-4 flex items-center">
                        <i class="fas fa-hands-helping mr-2"></i>
                        Kesejahteraan Sosial
                    </h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-700">Disabilitas Berat</span>
                            <span class="font-semibold text-green-600">{{ $komponenData['Disabilitas Berat'] ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-700">Lanjut Usia (70+ tahun)</span>
                            <span class="font-semibold text-green-600">{{ $komponenData['Lanjut Usia (70+ tahun)'] ?? 0 }}</span>
                        </div>
                        <div class="border-t border-green-300 pt-2 mt-3">
                            <div class="flex justify-between items-center font-semibold">
                                <span class="text-green-800">Total</span>
                                <span class="text-green-800">{{ $komponenKategori['Kesejahteraan Sosial'] ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Pie Chart - Kategori Komponen -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">Distribusi Kategori PKH</h2>
                </div>
                <div class="h-80">
                    <canvas id="pkhPieChart"></canvas>
                </div>
                <div class="flex items-center justify-center space-x-6 mt-4">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-red-500 rounded-full mr-2"></div>
                        <span class="text-sm text-gray-600">Kesehatan ({{ $komponenKategori['Kesehatan'] ?? 0 }})</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                        <span class="text-sm text-gray-600">Pendidikan ({{ $komponenKategori['Pendidikan'] ?? 0 }})</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                        <span class="text-sm text-gray-600">Kesejahteraan Sosial ({{ $komponenKategori['Kesejahteraan Sosial'] ?? 0 }})</span>
                    </div>
                </div>
            </div>

            <!-- Bar Chart - Detail Komponen -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">Detail Komponen PKH</h2>
                </div>
                <div class="h-80">
                    <canvas id="komponenBarChart"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Data dari backend
        const bantuanPerBulan = @json($bantuanPerBulan);
        const komponenKategori = @json($komponenKategori);
        const komponenData = @json($komponenData);

        // Pie Chart - Kategori Komponen
        var ctx = document.getElementById("pkhPieChart");
        var pkhPieChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ["Kesehatan", "Pendidikan", "Kesejahteraan Sosial"],
                datasets: [{
                    data: [
                        komponenKategori['Kesehatan'] || 0,
                        komponenKategori['Pendidikan'] || 0,
                        komponenKategori['Kesejahteraan Sosial'] || 0
                    ],
                    backgroundColor: ['#EF4444', '#3B82F6', '#10B981'],
                    hoverBackgroundColor: ['#DC2626', '#2563EB', '#059669'],
                    borderWidth: 0,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = total > 0 ? Math.round((context.parsed / total) * 100) : 0;
                                return context.label + ': ' + context.parsed + ' penerima (' + percentage + '%)';
                            }
                        }
                    }
                },
                cutout: '60%',
            },
        });

        // Bar Chart - Detail Komponen
        var ctx2 = document.getElementById("komponenBarChart");
        var komponenBarChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: [
                    'Ibu Hamil', 
                    'Balita', 
                    'Lansia', 
                    'SD/MI', 
                    'SMP/MTs', 
                    'SMA/MA', 
                    'Disabilitas', 
                    'Lanjut Usia'
                ],
                datasets: [{
                    label: 'Jumlah Penerima',
                    data: [
                        komponenData['Ibu Hamil'] || 0,
                        komponenData['Balita (0-5 tahun)'] || 0,
                        komponenData['Lansia (60+ tahun)'] || 0,
                        komponenData['Anak SD/MI'] || 0,
                        komponenData['Anak SMP/MTs'] || 0,
                        komponenData['Anak SMA/MA'] || 0,
                        komponenData['Disabilitas Berat'] || 0,
                        komponenData['Lanjut Usia (70+ tahun)'] || 0
                    ],
                    backgroundColor: [
                        '#EF4444', '#EF4444', '#EF4444', // Kesehatan (Merah)
                        '#3B82F6', '#3B82F6', '#3B82F6', // Pendidikan (Biru)
                        '#10B981', '#10B981'              // Kesejahteraan Sosial (Hijau)
                    ],
                    borderColor: [
                        '#DC2626', '#DC2626', '#DC2626',
                        '#2563EB', '#2563EB', '#2563EB',
                        '#059669', '#059669'
                    ],
                    borderWidth: 1,
                    borderRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Penerima: ' + context.parsed.y + ' orang';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#F3F4F6'
                        },
                        ticks: {
                            stepSize: 1,
                            callback: function(value) {
                                return value + ' org';
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            maxRotation: 45,
                            minRotation: 45
                        }
                    }
                }
            }
        });
    </script>
@endsection