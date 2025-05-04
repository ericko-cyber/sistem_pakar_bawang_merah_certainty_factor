@extends('layouts.admin.masteradmin')

@section('title', 'Daftar Gejala')

@section('content')
<h1 class="mt-4">Daftar Gejala</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Daftar Gejala</li>
</ol>

@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card mb-4">
    <div class="card-body">
        <a href="#" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#tambahGejalaModal">
            <i class="fas fa-plus"></i> Tambah Gejala
        </a>
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>Kode Gejala</th>
                    <th>Nama Gejala</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Kode Gejala</th>
                    <th>Nama Gejala</th>
                    <th>Aksi</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach($gejala_list as $gejala)
                <tr>
                    <td>{{ $gejala->kode_gejala }}</td>
                    <td>{{ $gejala->nama_gejala }}</td>
                    <td>
                        <form action="{{ route('gejala.destroy', $gejala->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus gejala ini?')">Hapus</button>
                        </form>
                        <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editGejalaModal{{ $gejala->id }}">
                            Edit
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Edit Gejala -->
@foreach($gejala_list as $gejala)
<div class="modal fade" id="editGejalaModal{{ $gejala->id }}" tabindex="-1" aria-labelledby="editGejalaModalLabel{{ $gejala->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('gejala.update', $gejala->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editGejalaModalLabel{{ $gejala->id }}">Edit Gejala</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="kode_gejala" class="form-label">Kode Gejala</label>
                        <input type="text" name="kode_gejala" class="form-control" value="{{ $gejala->kode_gejala }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama_gejala" class="form-label">Nama Gejala</label>
                        <input type="text" name="nama_gejala" class="form-control" value="{{ $gejala->nama_gejala }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach

<!-- Modal Tambah Gejala -->
<div class="modal fade" id="tambahGejalaModal" tabindex="-1" aria-labelledby="tambahGejalaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('gejala.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahGejalaModalLabel">Tambah Gejala</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="kode_gejala" class="form-label">Kode Gejala</label>
                        <input type="text" name="kode_gejala" class="form-control" id="kode_gejala" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama_gejala" class="form-label">Nama Gejala</label>
                        <input type="text" name="nama_gejala" class="form-control" id="nama_gejala" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
