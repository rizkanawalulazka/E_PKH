@extends('layouts.app')

@section('title', 'Daftar Pendamping')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Daftar Pendamping</h1>
    <div class="card shadow mb-4">
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
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection