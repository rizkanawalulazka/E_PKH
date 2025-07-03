@extends('layouts.app')

@section('title', 'Daftar PKH')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center space-x-3">
        <div class="p-2 bg-blue-100 rounded-lg">
            <i class="fas fa-user-plus text-blue-600 text-xl"></i>
        </div>
        <h1 class="text-2xl font-bold text-gray-900">Form Pendaftaran PKH</h1>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6">
            <div id="alert-container"></div>

            <form id="formPendaftaran" action="{{ route('pendaftaran.pkh.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <!-- Data Identitas -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nik" class="block text-sm font-medium text-gray-700 mb-2">NIK <span class="text-red-500">*</span></label>
                        <input type="text" id="nik" name="nik" maxlength="16" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Masukkan NIK 16 digit">
                    </div>
                    <div>
                        <label for="no_kk" class="block text-sm font-medium text-gray-700 mb-2">No. Kartu Keluarga <span class="text-red-500">*</span></label>
                        <input type="text" id="no_kk" name="no_kk" maxlength="16" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Masukkan No. KK 16 digit">
                    </div>
                </div>

                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" id="nama" name="nama" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Masukkan nama lengkap">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="tempat_lahir" class="block text-sm font-medium text-gray-700 mb-2">Tempat Lahir <span class="text-red-500">*</span></label>
                        <input type="text" id="tempat_lahir" name="tempat_lahir" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Masukkan tempat lahir">
                    </div>
                    <div>
                        <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir <span class="text-red-500">*</span></label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>

                <div>
                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap <span class="text-red-500">*</span></label>
                    <textarea id="alamat" name="alamat" rows="3" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Masukkan alamat lengkap"></textarea>
                </div>

                <div>
                    <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-2">Nomor HP <span class="text-red-500">*</span></label>
                    <input type="text" id="no_hp" name="no_hp" maxlength="15" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Masukkan nomor HP">
                </div>

                <!-- Komponen Bantuan -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-4">Komponen Bantuan <span class="text-red-500">*</span></label>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <input type="checkbox" id="komponen_kesehatan" name="komponen[]" value="kesehatan"
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="komponen_kesehatan" class="ml-2 block text-sm text-gray-700">
                                Kesehatan (Ibu Hamil/Balita/Lansia)
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="komponen_pendidikan" name="komponen[]" value="pendidikan"
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="komponen_pendidikan" class="ml-2 block text-sm text-gray-700">
                                Pendidikan (Anak Usia Sekolah)
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="komponen_kesejahteraan" name="komponen[]" value="kesejahteraan_sosial"
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="komponen_kesejahteraan" class="ml-2 block text-sm text-gray-700">
                                Kesejahteraan Sosial (Disabilitas Berat)
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Upload Files -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="kartu_keluarga" class="block text-sm font-medium text-gray-700 mb-2">Kartu Keluarga <span class="text-red-500">*</span></label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-gray-400 transition-colors">
                            <input type="file" id="kartu_keluarga" name="kartu_keluarga" accept="image/*" required class="hidden">
                            <i class="fas fa-upload text-gray-400 text-2xl mb-2"></i>
                            <p class="text-gray-600">Klik untuk upload Kartu Keluarga</p>
                            <p class="text-xs text-gray-500 mt-1">JPG, JPEG, PNG. Max 2MB</p>
                        </div>
                    </div>
                    <div>
                        <label for="foto_rumah" class="block text-sm font-medium text-gray-700 mb-2">Foto Rumah <span class="text-red-500">*</span></label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-gray-400 transition-colors">
                            <input type="file" id="foto_rumah" name="foto_rumah" accept="image/*" required class="hidden">
                            <i class="fas fa-upload text-gray-400 text-2xl mb-2"></i>
                            <p class="text-gray-600">Klik untuk upload Foto Rumah</p>
                            <p class="text-xs text-gray-500 mt-1">JPG, JPEG, PNG. Max 2MB</p>
                        </div>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div id="loadingProgress" class="hidden">
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div id="progressBar" class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                    </div>
                    <p class="text-sm text-gray-600 mt-2">Sedang mengunggah dan memproses data...</p>
                </div>

                <!-- Submit Button -->
                <div class="flex space-x-4">
                    <button type="submit" id="btnSubmit" class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                        <span id="btnText">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Kirim Pendaftaran
                        </span>
                        <span id="btnLoader" class="hidden">
                            <i class="fas fa-spinner fa-spin mr-2"></i>
                            Mengirim Data...
                        </span>
                    </button>
                    <a href="{{ route('dashboard') }}" class="px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div id="successModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4">
        <div class="text-center">
            <div class="p-4 bg-green-100 rounded-full w-16 h-16 mx-auto mb-4">
                <i class="fas fa-check-circle text-green-600 text-2xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Pendaftaran Berhasil</h3>
            <p id="successMessage" class="text-gray-600 mb-6"></p>
            <div class="flex space-x-3">
                <a href="{{ route('dashboard') }}" class="flex-1 bg-gray-200 text-gray-800 py-2 px-4 rounded-lg hover:bg-gray-300 transition-colors text-center">
                    Kembali
                </a>
                <a href="{{ route('pendaftaran.pkh.index') }}" class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors text-center">
                    Lihat Data
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Setup CSRF token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // File upload handlers
    $('input[type="file"]').on('change', function() {
        const file = this.files[0];
        const parent = $(this).parent();
        
        if (file) {
            parent.find('p').first().text(file.name);
            parent.removeClass('border-gray-300').addClass('border-blue-500 bg-blue-50');
        }
    });

    // Click handlers for upload areas
    $('.border-dashed').on('click', function() {
        $(this).find('input[type="file"]').click();
    });

    // Form validation and submission
    $('#formPendaftaran').on('submit', function(e) {
        e.preventDefault();
        
        if (!validateForm()) {
            return false;
        }

        const formData = new FormData(this);
        showLoading();

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            timeout: 30000,
            xhr: function() {
                const xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        const percentComplete = parseInt((evt.loaded / evt.total) * 100);
                        updateProgress(percentComplete);
                    }
                }, false);
                return xhr;
            },
            success: function(response) {
                updateProgress(100);
                setTimeout(function() {
                    hideLoading();
                    if (response.success) {
                        $('#successMessage').text(response.message);
                        $('#successModal').removeClass('hidden');
                        $('#formPendaftaran')[0].reset();
                        resetFileUploads();
                    } else {
                        showAlert('error', response.message || 'Pendaftaran gagal diproses.');
                    }
                }, 500);
            },
            error: function(xhr, status, error) {
                hideLoading();
                if (xhr.status === 422) {
                    const response = xhr.responseJSON;
                    if (response.errors) {
                        let errorMessage = '<strong>Data tidak valid:</strong><ul class="mt-2 ml-4 list-disc">';
                        $.each(response.errors, function(key, value) {
                            errorMessage += '<li>' + value[0] + '</li>';
                        });
                        errorMessage += '</ul>';
                        showAlert('error', errorMessage);
                    }
                } else {
                    showAlert('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
                }
            }
        });
    });

    function validateForm() {
        let isValid = true;
        let errorMessage = '';

        // Reset previous states
        $('.border-red-500').removeClass('border-red-500');
        $('#alert-container').empty();

        // Validate NIK
        const nik = $('#nik').val().trim();
        if (!nik || nik.length !== 16 || !/^\d+$/.test(nik)) {
            $('#nik').addClass('border-red-500');
            errorMessage += 'NIK harus 16 digit angka.<br>';
            isValid = false;
        }

        // Validate No. KK
        const noKk = $('#no_kk').val().trim();
        if (!noKk || noKk.length !== 16 || !/^\d+$/.test(noKk)) {
            $('#no_kk').addClass('border-red-500');
            errorMessage += 'No. Kartu Keluarga harus 16 digit angka.<br>';
            isValid = false;
        }

        // Validate required fields
        const requiredFields = ['nama', 'tempat_lahir', 'tanggal_lahir', 'alamat', 'no_hp'];
        requiredFields.forEach(field => {
            if (!$('#' + field).val().trim()) {
                $('#' + field).addClass('border-red-500');
                isValid = false;
            }
        });

        // Validate components
        if ($('input[name="komponen[]"]:checked').length === 0) {
            errorMessage += 'Pilih minimal satu komponen bantuan.<br>';
            isValid = false;
        }

        // Validate files
        if (!$('#kartu_keluarga')[0].files.length) {
            errorMessage += 'Kartu keluarga wajib diunggah.<br>';
            isValid = false;
        }

        if (!$('#foto_rumah')[0].files.length) {
            errorMessage += 'Foto rumah wajib diunggah.<br>';
            isValid = false;
        }

        if (!isValid) {
            showAlert('error', errorMessage);
        }

        return isValid;
    }

    function showAlert(type, message) {
        const alertColor = type === 'error' ? 'red' : 'green';
        const alertIcon = type === 'error' ? 'exclamation-triangle' : 'check-circle';
        
        $('#alert-container').html(`
            <div class="bg-${alertColor}-50 border border-${alertColor}-200 rounded-lg p-4 mb-6">
                <div class="flex">
                    <i class="fas fa-${alertIcon} text-${alertColor}-600 mr-3 mt-0.5"></i>
                    <div class="text-${alertColor}-800">${message}</div>
                </div>
            </div>
        `);
        
        $('html, body').animate({scrollTop: 0}, 500);
    }

    function showLoading() {
        $('#btnSubmit').prop('disabled', true);
        $('#btnText').addClass('hidden');
        $('#btnLoader').removeClass('hidden');
        $('#loadingProgress').removeClass('hidden');
    }

    function hideLoading() {
        $('#btnSubmit').prop('disabled', false);
        $('#btnText').removeClass('hidden');
        $('#btnLoader').addClass('hidden');
        $('#loadingProgress').addClass('hidden');
    }

    function updateProgress(percent) {
        $('#progressBar').css('width', percent + '%');
    }

    function resetFileUploads() {
        $('.border-dashed').removeClass('border-blue-500 bg-blue-50').addClass('border-gray-300');
        $('.border-dashed p').first().text('Klik untuk upload');
    }

    // Input formatting
    $('#nik, #no_kk, #no_hp').on('input', function() {
        $(this).val($(this).val().replace(/\D/g, ''));
    });
});
</script>
@endsection