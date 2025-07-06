@extends('layouts.app')

@section('title', 'Daftar Pendamping')

@section('content')
    <div class="mx-auto">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Header -->

        <div class="space-y-6">
            <!-- Page Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <i class="fas fa-user-friends text-blue-600 text-xl"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900">Daftar Pendamping</h1>
                </div>
                @if(auth()->user()->role === 'admin')
                    <button onclick="openAddModal()"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Pendamping
                    </button>
                @endif
            </div>



            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Total Pendamping</p>
                            <p class="text-2xl font-bold text-gray-900 mt-2">{{ $pendampings->count() }}</p>
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
                                <p class="text-2xl font-bold text-gray-900 mt-2">
                                    {{ $pendampings->where('status', 'aktif')->count() }}
                                </p>
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
                                <p class="text-2xl font-bold text-gray-900 mt-2">
                                    {{ $pendampings->pluck('wilayah_kerja')->unique()->count() }}
                                </p>
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
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama
                                        Lengkap</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        NIK
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No HP
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Wilayah Kerja</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    @if(auth()->user()->role === 'admin')
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($pendampings as $i => $p)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $i + 1 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div
                                                        class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                        <i class="fas fa-user text-blue-600"></i>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $p->nama_lengkap }}</div>
                                                    <div class="text-sm text-gray-500">{{ $p->user->email ?? 'Tidak ada email' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $p->nip ?? 'Tidak ada NIP' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $p->no_hp }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                {{ $p->wilayah_kerja }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($p->status == 'aktif')
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <i class="fas fa-check-circle mr-1"></i>
                                                    Aktif
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    <i class="fas fa-times-circle mr-1"></i>
                                                    Tidak Aktif
                                                </span>
                                            @endif
                                        </td>
                                        @if(auth()->user()->role === 'admin')
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <button onclick="editPendamping({{ $p->id }})"
                                                        class="inline-flex items-center px-3 py-1 bg-yellow-600 text-white text-xs font-medium rounded-md hover:bg-yellow-700 transition-colors">
                                                        <i class="fas fa-edit mr-1"></i>
                                                        Edit
                                                    </button>
                                                    <button onclick="deletePendamping({{ $p->id }})"
                                                        class="inline-flex items-center px-3 py-1 bg-red-600 text-white text-xs font-medium rounded-md hover:bg-red-700 transition-colors">
                                                        <i class="fas fa-trash mr-1"></i>
                                                        Hapus
                                                    </button>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ auth()->user()->role === 'admin' ? '7' : '6' }}"
                                            class="px-6 py-8 text-center text-sm text-gray-500">
                                            <div class="flex flex-col items-center">
                                                <i class="fas fa-user-friends text-gray-300 text-4xl mb-3"></i>
                                                <p>Belum ada data pendamping</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @if(auth()->user()->role === 'admin')
                <!-- Modal Tambah Pendamping -->
                <div id="addPendampingModal"
                    class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white rounded-xl max-w-lg w-full mx-4 max-h-[90vh] overflow-y-auto">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Tambah Pendamping Baru</h3>
                        </div>
                        <!-- UBAH: Hapus id untuk AJAX, gunakan form submit biasa -->
                        <form action="{{ route('pendamping.store') }}" method="POST">
                            @csrf
                            <div class="p-6 space-y-4">
                                <div>
                                    <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-2">Nama
                                        Lengkap</label>
                                    <input type="text" id="nama_lengkap" name="nama_lengkap" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label for="nip" class="block text-sm font-medium text-gray-700 mb-2">NIP</label>
                                    <input type="text" id="nik" name="nip" maxlength="16" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>

                                <div>
                                    <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-2">No HP</label>
                                    <input type="text" id="no_hp" name="no_hp" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                                    <textarea id="alamat" name="alamat" rows="3" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                                </div>
                                <div>
                                    <label for="wilayah_kerja" class="block text-sm font-medium text-gray-700 mb-2">Wilayah
                                        Kerja</label>
                                    <input type="text" id="wilayah_kerja" name="wilayah_kerja" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                                    <input type="password" id="password" name="password" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                            <div class="px-6 py-4 border-t border-gray-200">
                                <div class="flex space-x-3">
                                    <button type="button" onclick="closeAddModal()"
                                        class="flex-1 bg-gray-200 text-gray-800 py-2 px-4 rounded-lg hover:bg-gray-300 transition-colors">
                                        Batal
                                    </button>
                                    <button type="submit"
                                        class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                                        Simpan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal Edit Pendamping -->
                <div id="editPendampingModal"
                    class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white rounded-xl max-w-lg w-full mx-4 max-h-[90vh] overflow-y-auto">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Edit Pendamping</h3>
                        </div>
                        <form id="editPendampingForm" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="p-6 space-y-4">
                                <div>
                                    <label for="edit_nama_lengkap" class="block text-sm font-medium text-gray-700 mb-2">Nama
                                        Lengkap</label>
                                    <input type="text" id="edit_nama_lengkap" name="nama_lengkap" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label for="edit_nik" class="block text-sm font-medium text-gray-700 mb-2">NIK</label>
                                    <input type="text" id="edit_nik" name="nik" maxlength="16" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label for="edit_email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                    <input type="email" id="edit_email" name="email" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label for="edit_no_hp" class="block text-sm font-medium text-gray-700 mb-2">No HP</label>
                                    <input type="text" id="edit_no_hp" name="no_hp" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label for="edit_wilayah_kerja" class="block text-sm font-medium text-gray-700 mb-2">Wilayah
                                        Kerja</label>
                                    <input type="text" id="edit_wilayah_kerja" name="wilayah_kerja" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label for="edit_alamat" class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                                    <textarea id="edit_alamat" name="alamat" rows="3" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                                </div>
                                <div>
                                    <label for="edit_status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                    <select id="edit_status" name="status" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="aktif">Aktif</option>
                                        <option value="tidak_aktif">Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                            <div class="px-6 py-4 border-t border-gray-200">
                                <div class="flex space-x-3">
                                    <button type="button" onclick="closeEditModal()"
                                        class="flex-1 bg-gray-200 text-gray-800 py-2 px-4 rounded-lg hover:bg-gray-300 transition-colors">
                                        Batal
                                    </button>
                                    <button type="submit"
                                        class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                                        Update
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
@endsection

    @section('scripts')
        <script>
            $(document).ready(function () {
                $('#pendampingTable').DataTable({
                    responsive: true,
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
                        }
                    }
                });
            });

            @if(auth()->user()->role === 'admin')
                // Fungsi untuk membuka modal
                function openAddModal() {
                    document.getElementById('addPendampingModal').classList.remove('hidden');
                }

                // Fungsi untuk menutup modal
                function closeAddModal() {
                    document.getElementById('addPendampingModal').classList.add('hidden');
                    // Reset form
                    document.querySelector('#addPendampingModal form').reset();
                }

                function closeEditModal() {
                    document.getElementById('editPendampingModal').classList.add('hidden');
                }

                function editPendamping(id) {
                    $.ajax({
                        url: '/pendamping/' + id + '/edit',
                        method: 'GET',
                        success: function (response) {
                            $('#edit_nama_lengkap').val(response.nama_lengkap);
                            $('#edit_nik').val(response.user ? response.user.nik : '');
                            $('#edit_email').val(response.user ? response.user.email : '');
                            $('#edit_no_hp').val(response.no_hp);
                            $('#edit_wilayah_kerja').val(response.wilayah_kerja);
                            $('#edit_alamat').val(response.alamat);
                            $('#edit_status').val(response.status);

                            $('#editPendampingForm').attr('action', '/pendamping/' + id);
                            document.getElementById('editPendampingModal').classList.remove('hidden');
                        },
                        error: function () {
                            alert('Gagal memuat data pendamping');
                        }
                    });
                }

                function deletePendamping(id) {
                    if (confirm('Apakah Anda yakin ingin menghapus pendamping ini?')) {
                        $.ajax({
                            url: '/pendamping/' + id,
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response) {
                                if (response.success) {
                                    alert('Pendamping berhasil dihapus');
                                    location.reload();
                                } else {
                                    alert(response.message || 'Gagal menghapus pendamping');
                                }
                            },
                            error: function () {
                                alert('Terjadi kesalahan sistem');
                            }
                        });
                    }
                }

                // Function untuk membuat toast notification
                function showToast(message, type = 'success') {
                    // Buat element toast
                    const toast = document.createElement('div');
                    toast.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg text-white transform transition-all duration-300 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'
                        }`;
                    toast.innerHTML = `
                                    <div class="flex items-center">
                                        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} mr-2"></i>
                                        <span>${message}</span>
                                    </div>
                                `;

                    // Tambahkan ke body
                    document.body.appendChild(toast);

                    // Animasi masuk
                    setTimeout(() => {
                        toast.style.transform = 'translateX(0)';
                        toast.style.opacity = '1';
                    }, 100);

                    // Hapus setelah 3 detik
                    setTimeout(() => {
                        toast.style.transform = 'translateX(100%)';
                        toast.style.opacity = '0';
                        setTimeout(() => {
                            document.body.removeChild(toast);
                        }, 300);
                    }, 3000);
                }

                // Handle form submit dengan alert success
                $('#addPendampingForm').on('submit', function (e) {
                    e.preventDefault();

                    var formData = new FormData(this);
                    var submitBtn = $(this).find('button[type="submit"]');
                    var btnText = submitBtn.find('.btn-text');
                    var btnLoading = submitBtn.find('.btn-loading');

                    // Show loading state
                    submitBtn.prop('disabled', true);
                    btnText.text('Menyimpan...');
                    btnLoading.removeClass('hidden');

                    $.ajax({
                        url: $(this).attr('action'),
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            if (response.success) {
                                // Success notification
                                if (typeof Swal !== 'undefined') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil!',
                                        text: response.message,
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                } else {
                                    alert('✅ ' + response.message);
                                }

                                closeAddModal();
                                setTimeout(() => location.reload(), 1500);
                            }
                        },
                        error: function (xhr) {
                            var errorMessage = 'Terjadi kesalahan sistem';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }

                            if (typeof Swal !== 'undefined') {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: errorMessage
                                });
                            } else {
                                alert('❌ ' + errorMessage);
                            }
                        },
                        complete: function () {
                            // Reset loading state
                            submitBtn.prop('disabled', false);
                            btnText.text('Simpan');
                            btnLoading.addClass('hidden');
                        }
                    });
                });
            @endif

            // Auto-hide flash messages setelah 5 detik
            document.addEventListener('DOMContentLoaded', function () {
                const successAlert = document.querySelector('.bg-green-100');
                const errorAlert = document.querySelector('.bg-red-100');

                if (successAlert) {
                    setTimeout(() => {
                        successAlert.style.transition = 'opacity 0.5s ease-out';
                        successAlert.style.opacity = '0';
                        setTimeout(() => {
                            successAlert.remove();
                        }, 500);
                    }, 5000);
                }

                if (errorAlert) {
                    setTimeout(() => {
                        errorAlert.style.transition = 'opacity 0.5s ease-out';
                        errorAlert.style.opacity = '0';
                        setTimeout(() => {
                            errorAlert.remove();
                        }, 500);
                    }, 5000);
                }
            });
        </script>
    @endsection