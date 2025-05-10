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

<style>
    ul {
        list-style-type: none;
        /* Menghapus bullet points */
        padding-left: 0;
        /* Menghilangkan indentasi default */
    }
</style>

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
                        <ul>
                            @foreach(explode("\n", $penyakit->penanganan) as $item)
                            <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </td>

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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection