@extends('layouts.app')

@section('title', 'Detail Pemantauan - ' . $penerima->name)

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <a href="{{ route('pemantauan.index') }}" class="p-2 hover:bg-gray-100 rounded-lg">
                    <i class="fas fa-arrow-left text-gray-600"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $penerima->name }}</h1>
                    <p class="text-gray-600">{{ $penerima->email }}</p>
                </div>
            </div>
            <span class="px-3 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full">
                PKH Aktif
            </span>
        </div>

        <!-- Informasi Besaran Bantuan PKH -->


        <!-- Tabs -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="border-b border-gray-200">
                <nav class="flex space-x-8 px-6">
                    <button class="tab-button py-4 text-sm font-medium border-b-2 border-blue-500 text-blue-600"
                        data-tab="pencairan">
                        Pencairan Dana
                    </button>
                    <button
                        class="tab-button py-4 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700"
                        data-tab="absensi">
                        Absensi Pertemuan
                    </button>
                    <button
                        class="tab-button py-4 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700"
                        data-tab="laporan">
                        Laporan Bulanan
                    </button>
                </nav>
            </div>

            <!-- Tab Content: Pencairan Dana -->
            <div id="pencairan" class="tab-content p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Pencairan Dana {{ $tahunSekarang }}</h3>
                    <button class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700"
                        onclick="openPencairanModal()">
                        <i class="fas fa-plus mr-2"></i>
                        Update Pencairan
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @for($periode = 1; $periode <= 4; $periode++)
                        @php
                            $pencairan = $penerima->pencairanDana->where('periode', $periode)->where('tahun', $tahunSekarang)->first();
                        @endphp
                        <div
                            class="border rounded-lg p-4 {{ $pencairan && $pencairan->status == 'dicairkan' ? 'bg-green-50 border-green-200' : 'bg-gray-50 border-gray-200' }}">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="font-medium text-gray-900">Periode {{ $periode }}</h4>
                                @if($pencairan)
                                                <span
                                                    class="px-2 py-1 text-xs font-medium rounded-full
                                                            {{ $pencairan->status == 'dicairkan' ? 'bg-green-100 text-green-800' :
                                    ($pencairan->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                    {{ ucfirst($pencairan->status) }}
                                                </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">
                                        Belum Dicatat
                                    </span>
                                @endif
                            </div>
                            @if($pencairan)
                                <p class="text-sm text-gray-600 mb-1">Jumlah: Rp {{ number_format($pencairan->jumlah) }}</p>
                                <p class="text-sm text-gray-600">Tanggal: {{ $pencairan->tanggal_cair->format('d/m/Y') }}</p>
                            @else
                                <p class="text-sm text-gray-500">Belum ada pencairan</p>
                            @endif
                        </div>
                    @endfor
                </div>
            </div>

            <!-- Tab Content: Absensi Pertemuan -->
            <div id="absensi" class="tab-content p-6 hidden">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Absensi Pertemuan {{ $tahunSekarang }}</h3>
                    <button class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700"
                        onclick="openAbsensiModal()">
                        <i class="fas fa-plus mr-2"></i>
                        Update Absensi
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @php
                        $bulanNames = [
                            1 => 'Januari',
                            2 => 'Februari',
                            3 => 'Maret',
                            4 => 'April',
                            5 => 'Mei',
                            6 => 'Juni',
                            7 => 'Juli',
                            8 => 'Agustus',
                            9 => 'September',
                            10 => 'Oktober',
                            11 => 'November',
                            12 => 'Desember'
                        ];
                    @endphp
                    @for($bulan = 1; $bulan <= 12; $bulan++)
                        @php
                            $absensi = $penerima->absensiPertemuan->where('bulan', $bulan)->where('tahun', $tahunSekarang)->first();
                        @endphp
                        <div
                            class="border rounded-lg p-4 {{ $absensi && $absensi->status == 'hadir' ? 'bg-green-50 border-green-200' : 'bg-gray-50 border-gray-200' }}">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="font-medium text-gray-900">{{ $bulanNames[$bulan] }}</h4>
                                @if($absensi)
                                                <span
                                                    class="px-2 py-1 text-xs font-medium rounded-full
                                                            {{ $absensi->status == 'hadir' ? 'bg-green-100 text-green-800' :
                                    ($absensi->status == 'sakit' ? 'bg-yellow-100 text-yellow-800' :
                                        ($absensi->status == 'izin' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                                                    {{ ucfirst(str_replace('_', ' ', $absensi->status)) }}
                                                </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">
                                        Belum Dicatat
                                    </span>
                                @endif
                            </div>
                            @if($absensi && $absensi->tanggal_pertemuan)
                                <p class="text-sm text-gray-600">{{ $absensi->tanggal_pertemuan->format('d/m/Y') }}</p>
                            @endif
                            @if($absensi && $absensi->keterangan)
                                <p class="text-sm text-gray-600 mt-1">{{ $absensi->keterangan }}</p>
                            @endif
                        </div>
                    @endfor
                </div>
            </div>

            <!-- Tab Content: Laporan Bulanan -->
            <div id="laporan" class="tab-content p-6 hidden">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Laporan Bulanan {{ $tahunSekarang }}</h3>
                    <button class="px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700"
                        onclick="openLaporanModal()">
                        <i class="fas fa-plus mr-2"></i>
                        Buat Laporan
                    </button>
                </div>

                <div class="space-y-4">
                    @for($bulan = 1; $bulan <= 12; $bulan++)
                        @php
                            $laporan = $penerima->laporanBulanan->where('bulan', $bulan)->where('tahun', $tahunSekarang)->first();
                        @endphp
                        <div
                            class="border rounded-lg p-4 {{ $laporan ? 'bg-blue-50 border-blue-200' : 'bg-gray-50 border-gray-200' }}">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="font-medium text-gray-900">{{ $bulanNames[$bulan] }} {{ $tahunSekarang }}</h4>
                                @if($laporan)
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                                        Sudah Dilaporkan
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">
                                        Belum Dilaporkan
                                    </span>
                                @endif
                            </div>
                            @if($laporan)
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <p class="font-medium text-gray-700">Kondisi Keluarga:</p>
                                        <p class="text-gray-600">{{ $laporan->kondisi_keluarga }}</p>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-700">Pencapaian Komitmen:</p>
                                        <p class="text-gray-600">{{ $laporan->pencapaian_komitmen }}</p>
                                    </div>
                                    @if($laporan->kendala)
                                        <div>
                                            <p class="font-medium text-gray-700">Kendala:</p>
                                            <p class="text-gray-600">{{ $laporan->kendala }}</p>
                                        </div>
                                    @endif
                                    @if($laporan->rekomendasi)
                                        <div>
                                            <p class="font-medium text-gray-700">Rekomendasi:</p>
                                            <p class="text-gray-600">{{ $laporan->rekomendasi }}</p>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pencairan -->
    <div id="pencairanModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Update Pencairan Dana</h3>
                <form action="{{ route('pemantauan.update-pencairan', $penerima->id) }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Periode</label>
                            <select name="periode"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="1">Periode 1</option>
                                <option value="2">Periode 2</option>
                                <option value="3">Periode 3</option>
                                <option value="4">Periode 4</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tahun</label>
                            <input type="number" name="tahun" value="{{ $tahunSekarang }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jumlah</label>
                            <input type="number" name="jumlah" step="0.01"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Cair</label>
                            <input type="date" name="tanggal_cair"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="pending">Pending</option>
                                <option value="dicairkan">Dicairkan</option>
                                <option value="ditunda">Ditunda</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Keterangan</label>
                            <textarea name="keterangan" rows="3"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closePencairanModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Absensi -->
    <div id="absensiModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Update Absensi Pertemuan</h3>
                <form action="{{ route('pemantauan.update-absensi', $penerima->id) }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Bulan</label>
                            <select name="bulan"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ $i == $bulanSekarang ? 'selected' : '' }}>
                                        {{ $bulanNames[$i] }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tahun</label>
                            <input type="number" name="tahun" value="{{ $tahunSekarang }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status Kehadiran</label>
                            <select name="status"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="hadir">Hadir</option>
                                <option value="tidak_hadir">Tidak Hadir</option>
                                <option value="sakit">Sakit</option>
                                <option value="izin">Izin</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Pertemuan</label>
                            <input type="date" name="tanggal_pertemuan"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Keterangan</label>
                            <textarea name="keterangan" rows="3"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeAbsensiModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Laporan -->
    <div id="laporanModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Buat Laporan Bulanan</h3>
                <form action="{{ route('pemantauan.update-laporan', $penerima->id) }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Bulan</label>
                            <select name="bulan"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ $i == $bulanSekarang ? 'selected' : '' }}>
                                        {{ $bulanNames[$i] }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tahun</label>
                            <input type="number" name="tahun" value="{{ $tahunSekarang }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kondisi Keluarga</label>
                            <textarea name="kondisi_keluarga" rows="3"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Pencapaian Komitmen</label>
                            <textarea name="pencapaian_komitmen" rows="3"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kendala</label>
                            <textarea name="kendala" rows="3"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Rekomendasi</label>
                            <textarea name="rekomendasi" rows="3"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeLaporanModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-md hover:bg-purple-700">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Tab functionality
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', () => {
                const tabId = button.dataset.tab;

                // Hide all tab contents
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.add('hidden');
                });

                // Remove active class from all buttons
                document.querySelectorAll('.tab-button').forEach(btn => {
                    btn.classList.remove('border-blue-500', 'text-blue-600');
                    btn.classList.add('border-transparent', 'text-gray-500');
                });

                // Show selected tab content
                document.getElementById(tabId).classList.remove('hidden');

                // Add active class to clicked button
                button.classList.add('border-blue-500', 'text-blue-600');
                button.classList.remove('border-transparent', 'text-gray-500');
            });
        });

        // Modal functions
        function openPencairanModal() {
            document.getElementById('pencairanModal').classList.remove('hidden');
        }

        function closePencairanModal() {
            document.getElementById('pencairanModal').classList.add('hidden');
        }

        function openAbsensiModal() {
            document.getElementById('absensiModal').classList.remove('hidden');
        }

        function closeAbsensiModal() {
            document.getElementById('absensiModal').classList.add('hidden');
        }

        function openLaporanModal() {
            document.getElementById('laporanModal').classList.remove('hidden');
        }

        function closeLaporanModal() {
            document.getElementById('laporanModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        window.onclick = function (event) {
            const pencairanModal = document.getElementById('pencairanModal');
            const absensiModal = document.getElementById('absensiModal');
            const laporanModal = document.getElementById('laporanModal');

            if (event.target === pencairanModal) {
                closePencairanModal();
            }
            if (event.target === absensiModal) {
                closeAbsensiModal();
            }
            if (event.target === laporanModal) {
                closeLaporanModal();
            }
        }
    </script>
@endsection