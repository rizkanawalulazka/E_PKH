@extends('layouts.app')

@section('title', 'Daftar Pendaftaran PKH')
@section('page-title', 'Daftar Pendaftaran PKH')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Pendaftaran PKH</h6>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Tempat, Tanggal Lahir</th>
                            <th>Alamat</th>
                            <th>No. HP</th>
                            <th>Komponen Bantuan</th>
                            <th>Status</th>
                            <th>Tanggal Daftar</th>
                            @if(auth()->user() && auth()->user()->role === 'admin')
                                <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendaftaran as $key => $data)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $data->nik }}</td>
                            <td>{{ $data->nama }}</td>
                            <td>{{ $data->tempat_lahir }}, {{ \Carbon\Carbon::parse($data->tanggal_lahir)->format('d/m/Y') }}</td>
                            <td>{{ $data->alamat }}</td>
                            <td>{{ $data->no_hp }}</td>
                            <td>
                                @foreach($data->komponen as $komponen)
                                    <span class="badge badge-info">
                                        {{ str_replace('_', ' ', ucfirst($komponen)) }}
                                    </span>
                                @endforeach
                            </td>
                            <td>
                                @if($data->status == 'pending')
                                    <span class="badge badge-warning">Diproses</span>
                                @elseif($data->status == 'approved')
                                    <span class="badge badge-success">Disetujui</span>
                                @else
                                    <span class="badge badge-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>{{ $data->created_at->format('d/m/Y H:i') }}</td>
                            @if(auth()->user() && auth()->user()->role === 'admin')
                                <td>
                                    <!-- Dropdown untuk edit status -->
                                    <select class="form-control form-control-sm change-status" data-id="{{ $data->id }}" data-current-status="{{ $data->status }}">
                                        <option value="">-- Ubah Status --</option>
                                        <option value="pending" {{ $data->status == 'pending' ? 'disabled' : '' }}>Diproses</option>
                                        <option value="approved" {{ $data->status == 'approved' ? 'disabled' : '' }}>Setujui</option>
                                        <option value="rejected" {{ $data->status == 'rejected' ? 'disabled' : '' }}>Tolak</option>
                                    </select>
                                    
                                    <!-- Tombol Quick Action untuk status pending -->
                                    @if($data->status == 'pending')
                                        <div class="mt-1">
                                            <button type="button" class="btn btn-success btn-xs quick-approve" data-id="{{ $data->id }}">
                                                <i class="fas fa-check"></i> Setujui
                                            </button>
                                            <button type="button" class="btn btn-danger btn-xs quick-reject" data-id="{{ $data->id }}">
                                                <i class="fas fa-times"></i> Tolak
                                            </button>
                                        </div>
                                    @endif
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

<!-- Modal Konfirmasi -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Perubahan Status</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="confirmMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="confirmAction">Ya, Ubah</button>
            </div>
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
        
        var pendingAction = null;
        
        // Handle dropdown change
        $('.change-status').on('change', function() {
            var id = $(this).data('id');
            var currentStatus = $(this).data('current-status');
            var newStatus = $(this).val();
            var selectElement = $(this);
            
            if (newStatus === '') {
                return;
            }
            
            var statusText = {
                'pending': 'Diproses',
                'approved': 'Disetujui',
                'rejected': 'Ditolak'
            };
            
            pendingAction = {
                id: id,
                currentStatus: currentStatus,
                newStatus: newStatus,
                element: selectElement
            };
            
            $('#confirmMessage').text('Ubah status dari "' + statusText[currentStatus] + '" menjadi "' + statusText[newStatus] + '"?');
            $('#confirmModal').modal('show');
        });
        
        
        // Handle quick approve
        $('.quick-approve').on('click', function() {
            var id = $(this).data('id');
            
            pendingAction = {
                id: id,
                currentStatus: 'pending',
                newStatus: 'approved',
                element: null
            };
            
            $('#confirmMessage').text('Setujui pendaftaran ini?');
            $('#confirmModal').modal('show');
        });
        
        // Handle quick reject
        $('.quick-reject').on('click', function() {
            var id = $(this).data('id');
            
            pendingAction = {
                id: id,
                currentStatus: 'pending',
                newStatus: 'rejected',
                element: null
            };
            
            $('#confirmMessage').text('Tolak pendaftaran ini?');
            $('#confirmModal').modal('show');
        });
        
        // Handle konfirmasi action
        $('#confirmAction').on('click', function() {
            if (pendingAction) {
                updateStatus(pendingAction);
                $('#confirmModal').modal('hide');
            }
        });
        
        // Handle modal close
        $('#confirmModal').on('hidden.bs.modal', function () {
            if (pendingAction && pendingAction.element) {
                pendingAction.element.val('');
            }
            pendingAction = null;
        });
        
        // Fungsi untuk update status
        function updateStatus(actionData) {
            $.ajax({
                url: '/admin/pendaftaran/' + actionData.id + '/update-status',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    status: actionData.newStatus
                },
                beforeSend: function() {
                    if (actionData.element) {
                        actionData.element.prop('disabled', true);
                    }
                },
                success: function(response) {
                    if (response.success) {
                        // Tampilkan pesan sukses
                        $('.card-body').prepend(
                            '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                            'Status berhasil diubah!' +
                            '<button type="button" class="close" data-dismiss="alert">' +
                            '<span>&times;</span></button></div>'
                        );
                        
                        // Refresh halaman setelah 1 detik
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                        
                    } else {
                        alert('Gagal mengubah status: ' + response.message);
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr);
                    alert('Terjadi kesalahan saat mengubah status');
                },
                complete: function() {
                    if (actionData.element) {
                        actionData.element.prop('disabled', false);
                    }
                }
            });
        }
    });
</script>
@endsection

@section('styles')
<!-- Custom styles for this page -->
<link href="{{ asset('sbadmin2/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<style>
    .change-status {
        width: 140px;
        font-size: 12px;
    }
    
    .btn-xs {
        padding: 0.2rem 0.4rem;
        font-size: 0.75rem;
        line-height: 1.2;
    }
    
    .quick-approve, .quick-reject {
        margin-right: 2px;
    }
</style>
@endsection