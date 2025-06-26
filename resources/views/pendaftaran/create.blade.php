@extends('layouts.app')

@section('title', 'Daftar PKH')
@section('page-title', 'Daftar PKH')

@section('content')
<style>
    #formPendaftaran > .form-group > label,
    #formPendaftaran .row .form-group > label,
    #formPendaftaran .form-group.mt-4 > label {
        color: #000 !important;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Pendaftaran PKH</h6>
                </div>
                <div class="card-body">
                    <div id="alert-container"></div>

                    <form id="formPendaftaran" action="{{ route('pendaftaran.pkh.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nik" class="text-dark">NIK <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nik') is-invalid @enderror" 
                                           id="nik" name="nik" value="{{ old('nik') }}" 
                                           placeholder="Masukkan NIK 16 digit" maxlength="16" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama" class="text-dark">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                           id="nama" name="nama" value="{{ old('nama') }}" 
                                           placeholder="Masukkan nama lengkap" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tempat_lahir" class="text-dark">Tempat Lahir <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" 
                                           id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}" 
                                           placeholder="Masukkan tempat lahir" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_lahir" class="text-dark">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                           id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="alamat" class="text-dark">Alamat Lengkap <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                      id="alamat" name="alamat" rows="3" 
                                      placeholder="Masukkan alamat lengkap" required>{{ old('alamat') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="no_hp" class="text-dark">Nomor HP <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('no_hp') is-invalid @enderror" 
                                   id="no_hp" name="no_hp" value="{{ old('no_hp') }}" 
                                   placeholder="Masukkan nomor HP" maxlength="13" required>
                        </div>

                        <div class="form-group">
                            <label class="text-dark">Komponen Bantuan <span class="text-danger">*</span></label>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" 
                                       id="komponen_kesehatan" name="komponen[]" 
                                       value="kesehatan" {{ in_array('kesehatan', old('komponen', [])) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="komponen_kesehatan">
                                    Kesehatan (Ibu Hamil/Balita/Lansia)
                                </label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" 
                                       id="komponen_pendidikan" name="komponen[]" 
                                       value="pendidikan" {{ in_array('pendidikan', old('komponen', [])) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="komponen_pendidikan">
                                    Pendidikan (Anak Usia Sekolah)
                                </label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" 
                                       id="komponen_kesejahteraan" name="komponen[]" 
                                       value="kesejahteraan_sosial" {{ in_array('kesejahteraan_sosial', old('komponen', [])) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="komponen_kesejahteraan">
                                    Kesejahteraan Sosial (Disabilitas Berat)
                                </label>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <label for="kartu_keluarga" class="text-dark">Unggah Gambar Kartu Keluarga <span class="text-danger">*</span></label>
                            <input type="file" class="form-control-file @error('kartu_keluarga') is-invalid @enderror" id="kartu_keluarga" name="kartu_keluarga" accept="image/*" required>
                            <small class="form-text text-muted">Format gambar: JPG, JPEG, PNG. Maksimal 2MB.</small>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary" id="btnSubmit">
                                <span id="btnText">
                                    <i class="fas fa-paper-plane mr-2"></i>Kirim Pendaftaran
                                </span>
                                <span id="btnLoader" style="display: none;">
                                    <i class="fas fa-spinner fa-spin mr-2"></i>Mengirim Data...
                                </span>
                            </button>
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary" id="btnKembali">
                                <i class="fas fa-arrow-left mr-2"></i>Kembali
                            </a>
                        </div>

                        <!-- Loading Progress Bar -->
                        <div id="loadingProgress" class="mt-3" style="display: none;">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" 
                                     role="progressbar" style="width: 0%" id="progressBar">
                                    <span id="progressText">0%</span>
                                </div>
                            </div>
                            <small class="text-muted">Sedang mengunggah dan memproses data...</small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Pendaftaran Berhasil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <i class="fas fa-check-circle text-success fa-4x mb-3"></i>
                    <p id="successMessage"></p>
                </div>
            </div>
            <div class="modal-footer">
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
                <a href="{{ route('pendaftaran.pkh.index') }}" class="btn btn-primary">Lihat Data Pendaftaran</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('#formPendaftaran').on('submit', function(e) {
        e.preventDefault();
        
        // Show loading state
        showLoading();
        
        var form = $(this)[0];
        var formData = new FormData(form);
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                
                // Upload progress
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100);
                        updateProgress(percentComplete);
                    }
                }, false);
                
                return xhr;
            },
            success: function(response) {
                console.log('Response:', response); // Debug
                
                // Complete progress
                updateProgress(100);
                
                setTimeout(function() {
                    hideLoading();
                    
                    if (response.success) {
                        $('#successMessage').text(response.message);
                        $('#successModal').modal('show');
                        $('#formPendaftaran')[0].reset();
                    }
                }, 500);
            },
            error: function(xhr) {
                console.log('Error:', xhr); // Debug
                
                hideLoading();
                
                if (xhr.status === 422) {
                    // Validation errors
                    var errors = xhr.responseJSON.errors;
                    var errorMessage = '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                        '<ul class="mb-0">';
                    
                    $.each(errors, function(key, value) {
                        errorMessage += '<li>' + value[0] + '</li>';
                    });
                    
                    errorMessage += '</ul><button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                        '<span aria-hidden="true">&times;</span></button></div>';
                    
                    $('#alert-container').html(errorMessage);
                } else {
                    // General error
                    $('#alert-container').html(
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                        'Terjadi kesalahan saat memproses pendaftaran. Silakan coba lagi.' +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                        '<span aria-hidden="true">&times;</span></button></div>'
                    );
                }
            }
        });
    });
    
    // Reset form on modal close
    $('#successModal').on('hidden.bs.modal', function() {
        hideLoading();
    });
    
    // Loading functions
    function showLoading() {
        // Disable form elements
        $('#btnSubmit').prop('disabled', true);
        $('#btnKembali').prop('disabled', true);
        $('#formPendaftaran input, #formPendaftaran select, #formPendaftaran textarea').prop('disabled', true);
        
        // Change button appearance
        $('#btnText').hide();
        $('#btnLoader').show();
        
        // Show progress bar
        $('#loadingProgress').show();
        updateProgress(0);
        
        // Scroll to top to show progress
        $('html, body').animate({scrollTop: 0}, 500);
    }
    
    function hideLoading() {
        // Enable form elements
        $('#btnSubmit').prop('disabled', false);
        $('#btnKembali').prop('disabled', false);
        $('#formPendaftaran input, #formPendaftaran select, #formPendaftaran textarea').prop('disabled', false);
        
        // Reset button appearance
        $('#btnText').show();
        $('#btnLoader').hide();
        
        // Hide progress bar
        $('#loadingProgress').hide();
    }
    
    function updateProgress(percent) {
        $('#progressBar').css('width', percent + '%');
        $('#progressText').text(percent + '%');
        
        if (percent >= 100) {
            $('#progressBar').removeClass('progress-bar-striped progress-bar-animated');
            $('#progressBar').addClass('bg-success');
        }
    }
});
</script>
@endsection