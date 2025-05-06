@extends('layouts.admin.masteradmin')

@section('title', 'Daftar Penyakit')

@section('content')
<h1 class="mt-4">Daftar Penyakit</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Daftar Penyakit</li>
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

<!-- DataTable -->
<div class="card mb-4" id="history" data-wow-duration="1s" data-wow-delay="0.5s">
    <div class="card-body">
        <a href="#" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#tambahUserModal">
            <i class="fas fa-plus"></i> Tambah Penyakit
        </a>
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>Kode Penyakit</th>
                    <th>Nama Penyakit</th>
                    <th>Sub Judul</th>
                    <th>Deskripsi</th>
                    <th>Gejala</th>
                    <th>Penanganan</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Kode Penyakit</th>
                    <th>Nama Penyakit</th>
                    <th>Sub Judul</th>
                    <th>Deskripsi</th>
                    <th>Gejala</th>
                    <th>Penanganan</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </tfoot>
            <tbody>
                @csrf
                @foreach($penyakit_list as $penyakit)
                <tr>
                    <td>{{ $penyakit->kode_penyakit }}</td>
                    <td>{{ $penyakit->nama_penyakit }}</td>
                    <td>{{ $penyakit->subjudul }}</td>
                    <td>{{ $penyakit->deskripsi }}</td>
                    <td>
                        @php
                        $id_gejala = explode(',', $penyakit->gejala);
                        $nama_gejala = collect($id_gejala)->map(function ($id) use ($gejala) {
                        $gejala = $gejala->firstWhere('id', (int)$id);
                        return $gejala ? $gejala->nama_gejala : null;
                        })->filter();
                        @endphp
                        <ul>
                            @foreach ($nama_gejala as $nama)
                            <li>{{ $nama }}</li>
                            @endforeach
                        </ul>
                    </td>

                    <td>{{ $penyakit->penanganan }}</td>
                    <td>
                        <img src="{{ asset('assets/images/' . $penyakit->gambar) }}" width="100" alt="Gambar Penyakit">
                    </td>
                    <td>
                        <!-- Tombol untuk memunculkan modal edit -->
                        <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $penyakit->id }}">
                            Edit
                        </a>

                        <form action="{{ route('penyakit.destroy', $penyakit->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE') <!-- Menandakan bahwa ini adalah request DELETE -->
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus penyakit ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>

                <!-- Modal Edit -->
                <div class="modal fade" id="editModal{{ $penyakit->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $penyakit->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $penyakit->id }}">Edit Penyakit</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                            </div>
                            <form action="{{ route('penyakit.update', $penyakit->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT') <!-- method PUT untuk update -->
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="kode_penyakit" class="form-label">Kode Penyakit</label>
                                        <input type="text" class="form-control" name="kode_penyakit" value="{{ $penyakit->kode_penyakit }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nama_penyakit" class="form-label">Nama Penyakit</label>
                                        <input type="text" class="form-control" name="nama_penyakit" value="{{ $penyakit->nama_penyakit }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="subjudul" class="form-label">Sub Judul</label>
                                        <input type="text" class="form-control" name="subjudul" value="{{ $penyakit->subjudul }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="deskripsi" class="form-label">Deskripsi</label>
                                        <textarea class="form-control" name="deskripsi" rows="3" required>{{ $penyakit->deskripsi }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="penanganan" class="form-label">Penanganan</label>
                                        <textarea class="form-control" name="penanganan" rows="3" required>{{ $penyakit->penanganan }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="gambar" class="form-label">Gambar (Kosongkan jika tidak ingin mengganti)</label>
                                        <input type="file" class="form-control" name="gambar" accept="image/*">
                                        <small class="form-text text-muted">Gambar saat ini: <br><img src="{{ asset('assets/images/' . $penyakit->gambar) }}" width="100"></small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Gejala</label>
                                        <div class="gejala-select-container">
                                            @php
                                            $selected_gejala = explode(',', $penyakit->gejala); // Ambil gejala yang sudah ada
                                            @endphp
                                            
                                            <div class="mb-2">
                                                <button type="button" class="btn btn-sm btn-info pilih-semua-gejala" data-penyakit-id="{{ $penyakit->id }}">Pilih Semua</button>
                                                <button type="button" class="btn btn-sm btn-warning hapus-semua-gejala" data-penyakit-id="{{ $penyakit->id }}">Hapus Semua</button>
                                            </div>
                                            
                                            <div class="row">
                                                @foreach($gejala as $item)
                                                <div class="col-md-6 mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input gejala-checkbox" type="checkbox" 
                                                               name="gejala[]" value="{{ $item->id }}" 
                                                               id="gejala{{ $penyakit->id }}_{{ $item->id }}"
                                                               data-penyakit-id="{{ $penyakit->id }}"
                                                               {{ in_array($item->id, $selected_gejala) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="gejala{{ $penyakit->id }}_{{ $item->id }}">
                                                            {{ $item->nama_gejala }}
                                                        </label>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah Penyakit -->
<!-- Form Tambah Penyakit -->
<div class="modal fade" id="tambahUserModal" tabindex="-1" aria-labelledby="tambahUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahUserModalLabel">Tambah Penyakit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('penyakit.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <!-- Form Input Penyakit -->
                    <div class="mb-3">
                        <label for="kode_penyakit" class="form-label">Kode Penyakit</label>
                        <input type="text" class="form-control" id="kode_penyakit" name="kode_penyakit" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama_penyakit" class="form-label">Nama Penyakit</label>
                        <input type="text" class="form-control" id="nama_penyakit" name="nama_penyakit" required>
                    </div>
                    <div class="mb-3">
                        <label for="subjudul" class="form-label">Sub Judul</label>
                        <input type="text" class="form-control" id="subjudul" name="subjudul" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="penanganan" class="form-label">Penanganan</label>
                        <textarea class="form-control" id="penanganan" name="penanganan" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar</label>
                        <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" required>
                    </div>

                    <!-- Form Input Gejala sebagai Checkbox -->
                    <div class="mb-3">
                        <label class="form-label">Gejala</label>
                        <div class="gejala-select-container">
                            <div class="mb-2">
                                <button type="button" class="btn btn-sm btn-info pilih-semua-gejala" data-penyakit-id="tambah">Pilih Semua</button>
                                <button type="button" class="btn btn-sm btn-warning hapus-semua-gejala" data-penyakit-id="tambah">Hapus Semua</button>
                            </div>
                            
                            <div class="row">
                                @foreach($gejala as $item)
                                <div class="col-md-6 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input gejala-checkbox" type="checkbox" 
                                               name="gejala[]" value="{{ $item->id }}" 
                                               id="gejalaTambah_{{ $item->id }}"
                                               data-penyakit-id="tambah">
                                        <label class="form-check-label" for="gejalaTambah_{{ $item->id }}">
                                            {{ $item->nama_gejala }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .custom-select-box {
        width: 100%;
        height: auto;
        padding: 10px;
        border: 2px solid #ccc;
        border-radius: 10px;
        background-color: #fff;
        font-size: 14px;
        font-family: Arial, sans-serif;
        box-sizing: border-box;
        resize: none;
        transition: all 0.3s ease;
        overflow-y: auto;
    }

    .custom-select-box:focus {
        border-color: #4caf50;
        outline: none;
        box-shadow: 0 0 5px rgba(76, 175, 80, 0.6);
    }

    .custom-select-box option {
        padding: 10px;
    }

    .custom-select-box option:checked {
        background-color: #4caf50;
        color: white;
    }
    
    .gejala-select-container {
        max-height: 400px;
        overflow-y: auto;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handler untuk tombol "Pilih Semua"
        document.querySelectorAll('.pilih-semua-gejala').forEach(function(button) {
            button.addEventListener('click', function() {
                const penyakitId = this.getAttribute('data-penyakit-id');
                document.querySelectorAll(`.gejala-checkbox[data-penyakit-id="${penyakitId}"]`).forEach(function(checkbox) {
                    checkbox.checked = true;
                });
            });
        });
        
        // Handler untuk tombol "Hapus Semua"
        document.querySelectorAll('.hapus-semua-gejala').forEach(function(button) {
            button.addEventListener('click', function() {
                const penyakitId = this.getAttribute('data-penyakit-id');
                document.querySelectorAll(`.gejala-checkbox[data-penyakit-id="${penyakitId}"]`).forEach(function(checkbox) {
                    checkbox.checked = false;
                });
            });
        });
    });
</script>
@endsection