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

        <!-- Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Bar Chart -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">Data Bantuan Bulanan ({{ date('Y') }})</h2>
                </div>
                <div class="h-80">
                    <canvas id="bantuanBarChart"></canvas>
                </div>
            </div>

            <!-- Pie Chart -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">Distribusi Komponen PKH</h2>
                </div>
                <div class="h-80">
                    <canvas id="pkhPieChart"></canvas>
                </div>
                <div class="flex items-center justify-center space-x-6 mt-4">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                        <span class="text-sm text-gray-600">Kesehatan ({{ $komponenData['Kesehatan'] ?? 0 }})</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                        <span class="text-sm text-gray-600">Pendidikan ({{ $komponenData['Pendidikan'] ?? 0 }})</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-cyan-500 rounded-full mr-2"></div>
                        <span class="text-sm text-gray-600">Kesejahteraan Sosial ({{ $komponenData['Kesejahteraan Sosial'] ?? 0 }})</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Data dari backend
        const bantuanPerBulan = @json($bantuanPerBulan);
        const komponenData = @json($komponenData);

        // Pie Chart
        var ctx = document.getElementById("pkhPieChart");
        var pkhPieChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ["Kesehatan", "Pendidikan", "Kesejahteraan Sosial"],
                datasets: [{
                    data: [
                        komponenData['Kesehatan'] || 0,
                        komponenData['Pendidikan'] || 0,
                        komponenData['Kesejahteraan Sosial'] || 0
                    ],
                    backgroundColor: ['#3B82F6', '#10B981', '#06B6D4'],
                    hoverBackgroundColor: ['#2563EB', '#059669', '#0891B2'],
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
                                return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                            }
                        }
                    }
                },
                cutout: '60%',
            },
        });

        // Bar Chart
        var ctx2 = document.getElementById("bantuanBarChart");
        var bantuanBarChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Bantuan (Juta Rupiah)',
                    data: bantuanPerBulan,
                    backgroundColor: '#3B82F6',
                    borderColor: '#2563EB',
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
                                return 'Bantuan: Rp ' + (context.parsed.y * 1000000).toLocaleString('id-ID');
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
                            callback: function(value) {
                                return value + 'M';
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
@endsection