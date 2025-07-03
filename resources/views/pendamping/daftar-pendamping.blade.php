
@extends('layouts.app')

@section('title', 'Daftar Pendamping')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Pendamping</h1>
        @if(auth()->user() && auth()->user()->role === 'admin')
            <div class="d-flex">
                <button type="button" class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#addPendampingModal">
                    <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Pendamping
                </button>
            </div>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Pendamping PKH</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>No HP</th>
                            <th>Alamat</th>
                            <th>Wilayah Kerja</th>
                            <th>Status</th>
                            <th>Jumlah Penerima</th>
                            @if(auth()->user() && auth()->user()->role === 'admin')
                                <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendampings as $key => $pendamping)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $pendamping->nik }}</td>
                            <td>{{ $pendamping->name }}</td>
                            <td>{{ $pendamping->pendamping->no_hp ?? '-' }}</td>
                            <td>{{ $pendamping->pendamping->alamat ?? '-' }}</td>
                            <td>{{ $pendamping->pendamping->wilayah_kerja ?? '-' }}</td>
                            <td>
                                @if($pendamping->pendamping && $pendamping->pendamping->status === 'active')
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-secondary">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-info">
                                    {{ $pendamping->pendamping->pendaftaran_count ?? 0 }} Penerima
                                </span>
                            </td>
                            @if(auth()->user() && auth()->user()->role === 'admin')
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-info btn-sm" onclick="editPendamping({{ $pendamping->id }})" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-warning btn-sm" onclick="toggleStatus({{ $pendamping->id }})" title="Toggle Status">
                                            <i class="fas fa-toggle-on"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="deletePendamping({{ $pendamping->id }})" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Pendamping -->
<div class="modal fade" id="addPendampingModal" tabindex="-1" role="dialog" aria-labelledby="addPendampingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPendampingModalLabel">Tambah Pendamping Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addPendampingForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nik">NIK <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nik" name="nik" maxlength="16" required>
                                <small class="form-text text-muted">16 digit angka</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="password" name="password" minlength="6" required>
                        <small class="form-text text-muted">Minimal 6 karakter</small>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="no_hp">No. HP <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="no_hp" name="no_hp" maxlength="15" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="wilayah_kerja">Wilayah Kerja <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="wilayah_kerja" name="wilayah_kerja" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="alamat">Alamat <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Pendamping -->
<div class="modal fade" id="editPendampingModal" tabindex="-1" role="dialog" aria-labelledby="editPendampingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPendampingModalLabel">Edit Pendamping</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editPendampingForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_nik">NIK <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_nik" name="nik" maxlength="16" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_name">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_name" name="name" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_password">Password</label>
                        <input type="password" class="form-control" id="edit_password" name="password" minlength="6">
                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password</small>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_no_hp">No. HP <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_no_hp" name="no_hp" maxlength="15" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_wilayah_kerja">Wilayah Kerja <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_wilayah_kerja" name="wilayah_kerja" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_alamat">Alamat <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="edit_alamat" name="alamat" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Page level plugins -->
<script src="{{ asset('sbadmin2/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('sbadmin2/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "pageLength": 25,
            "order": [[ 0, "asc" ]]
        });
        
        // Handle form tambah pendamping
        $('#addPendampingForm').on('submit', function(e) {
            e.preventDefault();
            
            $.ajax({
                url: '/admin/pendamping/store',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        $('#addPendampingModal').modal('hide');
                        $('#addPendampingForm')[0].reset();
                        
                        // Tampilkan pesan sukses
                        $('.container-fluid').prepend(
                            '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                            '<i class="fas fa-check-circle"></i> ' + response.message +
                            '<button type="button" class="close" data-dismiss="alert">' +
                            '<span>&times;</span></button></div>'
                        );
                        
                        // Reload halaman setelah 1 detik
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(xhr) {
                    var errorMessage = 'Terjadi kesalahan';
                    
                    if (xhr.responseJSON) {
                        if (xhr.responseJSON.errors) {
                            errorMessage = 'Validasi gagal:\n';
                            $.each(xhr.responseJSON.errors, function(field, messages) {
                                errorMessage += '- ' + messages.join('\n- ') + '\n';
                            });
                        } else if (xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                    }
                    
                    alert(errorMessage);
                }
            });
        });
        
        // Handle form edit pendamping
        $('#editPendampingForm').on('submit', function(e) {
            e.preventDefault();
            
            var id = $('#edit_id').val();
            
            $.ajax({
                url: '/admin/pendamping/' + id + '/update',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        $('#editPendampingModal').modal('hide');
                        
                        // Tampilkan pesan sukses
                        $('.container-fluid').prepend(
                            '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                            '<i class="fas fa-check-circle"></i> ' + response.message +
                            '<button type="button" class="close" data-dismiss="alert">' +
                            '<span>&times;</span></button></div>'
                        );
                        
                        // Reload halaman setelah 1 detik
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(xhr) {
                    var errorMessage = 'Terjadi kesalahan';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMessage = Object.values(xhr.responseJSON.errors).join('\n');
                    }
                    alert(errorMessage);
                }
            });
        });
        
        // Reset form saat modal ditutup
        $('#addPendampingModal').on('hidden.bs.modal', function() {
            $('#addPendampingForm')[0].reset();
            $('.form-control').removeClass('is-invalid');
        });
        
        // Validasi input NIK dan No HP (hanya angka)
        $('#nik, #edit_nik').on('input', function() {
            $(this).val($(this).val().replace(/\D/g, ''));
        });
        
        $('#no_hp, #edit_no_hp').on('input', function() {
            $(this).val($(this).val().replace(/\D/g, ''));
        });
    });
    
    // Fungsi untuk edit pendamping
    function editPendamping(id) {
        $.ajax({
            url: '/admin/pendamping/' + id + '/edit',
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    var data = response.data;
                    
                    $('#edit_id').val(data.id);
                    $('#edit_nik').val(data.nik);
                    $('#edit_name').val(data.name);
                    $('#edit_no_hp').val(data.pendamping ? data.pendamping.no_hp : '');
                    $('#edit_wilayah_kerja').val(data.pendamping ? data.pendamping.wilayah_kerja : '');
                    $('#edit_alamat').val(data.pendamping ? data.pendamping.alamat : '');
                    
                    $('#editPendampingModal').modal('show');
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr) {
                alert('Terjadi kesalahan saat mengambil data');
            }
        });
    }
    
    // Fungsi untuk toggle status
    function toggleStatus(id) {
        if (confirm('Apakah Anda yakin ingin mengubah status pendamping ini?')) {
            $.ajax({
                url: '/admin/pendamping/' + id + '/toggle-status',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        location.reload();
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan');
                }
            });
        }
    }
    
    // Fungsi untuk hapus pendamping
    function deletePendamping(id) {
        if (confirm('Apakah Anda yakin ingin menghapus pendamping ini? Tindakan ini tidak dapat dibatalkan.')) {
            $.ajax({
                url: '/admin/pendamping/' + id + '/delete',
                method: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        location.reload();
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan');
                }
            });
        }
    }
</script>
@endsection

@section('styles')
<!-- Custom styles for this page -->
<link href="{{ asset('sbadmin2/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<style>
    .btn-group .btn {
        margin-right: 2px;
    }
    
    .btn-group .btn:last-child {
        margin-right: 0;
    }
    
    .modal-body .form-group {
        margin-bottom: 1rem;
    }
</style>
@endsection