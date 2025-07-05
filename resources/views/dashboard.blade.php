@extends('layouts.app', ['pendampingRandom' => $pendampingRandom ?? null])

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
            @if(auth()->user()->role === 'penerima')
                <a href="/pendaftaran/create"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Daftar PKH Baru
                </a>
            @endif
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Bantuan -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Total Bantuan (2024)</p>
                        <p class="text-2xl font-bold text-gray-900 mt-2">Rp306.500.000</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-full">
                        <i class="fas fa-calendar text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Rata-rata Bantuan -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Rata-rata Bantuan (Bulanan)
                        </p>
                        <p class="text-2xl font-bold text-gray-900 mt-2">Rp25.541.667</p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-full">
                        <i class="fas fa-dollar-sign text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Jumlah Penerima -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Jumlah Penerima</p>
                        <p class="text-2xl font-bold text-gray-900 mt-2">150</p>
                    </div>
                    <div class="p-3 bg-cyan-100 rounded-full">
                        <i class="fas fa-users text-cyan-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Pengajuan Pending -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Pengajuan Pending</p>
                        <p class="text-2xl font-bold text-gray-900 mt-2">18</p>
                    </div>
                    <div class="p-3 bg-yellow-100 rounded-full">
                        <i class="fas fa-comments text-yellow-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

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

                <div
                    class="flex items-center justify-between p-4 bg-indigo-50 rounded-lg border border-indigo-200 md:col-span-2 lg:col-span-1">
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
                    <h2 class="text-lg font-semibold text-gray-900">Data Bantuan Bulanan (2024)</h2>
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
                        <span class="text-sm text-gray-600">Kesehatan</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                        <span class="text-sm text-gray-600">Pendidikan</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-cyan-500 rounded-full mr-2"></div>
                        <span class="text-sm text-gray-600">Kesejahteraan Sosial</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Pie Chart
        var ctx = document.getElementById("pkhPieChart");
        var pkhPieChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ["Kesehatan", "Pendidikan", "Kesejahteraan Sosial"],
                datasets: [{
                    data: [35, 45, 20],
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
                                return context.label + ': ' + context.parsed + '%';
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
                    data: [25, 30, 22, 28, 35, 20, 40, 32, 28, 25, 30, 35],
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
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#F3F4F6'
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