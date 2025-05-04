@extends('layouts.admin.masteradmin')

@section('title', 'Daftar User')

@section('content')
<h1 class="mt-4">Daftar User</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Daftar User</li>
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
<div class="card mb-4" id="" data-wow-duration="1s" data-wow-delay="0.5s">
    <div class="card-body">
        <!-- Tombol Tambah User -->
        <a href="#" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#tambahUserModal">
            <i class="fas fa-plus"></i> Tambah User
        </a>

        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Alamat</th>
                    <th>Telp</th>
                    <th>Umur</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Register</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Username</th>
                    <th>Alamat</th>
                    <th>Telp</th>
                    <th>Umur</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Register</th>
                    <th>Aksi</th>
                </tr>
            </tfoot>
            <tbody>
                @csrf
                @foreach($user_list as $user)
                <tr>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->alamat }}</td>
                    <td>{{ $user->telp }}</td>
                    <td>{{ $user->umur }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->registered }}</td>
                    <td>
                        @if($user->role !== 'admin')
                        <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">
                            Edit
                        </a>
                        <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus user ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                        @endif
                    </td>
                </tr>
                <!-- Modal Edit User -->
                <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="editUserModalLabel{{ $user->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editUserModalLabel{{ $user->id }}">Edit User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                            </div>
                            <form action="{{ route('user.update', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" name="username" value="{{ $user->username }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <input type="text" class="form-control" name="alamat" value="{{ $user->alamat }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Telp</label>
                                        <input type="text" class="form-control" name="telp" value="{{ $user->telp }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Umur</label>
                                        <input type="text" class="form-control" name="umur" value="{{ $user->umur }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password" placeholder="Kosongkan jika tidak ingin mengubah password">
                                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti password</small>
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



<!-- Modal Tambah User -->
<div class="modal fade" id="tambahUserModal" tabindex="-1" aria-labelledby="tambahUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahUserModalLabel">Tambah User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form untuk tambah user -->
                <form action="{{ route('user.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" id="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" name="alamat" id="alamat" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Telp</label>
                        <input type="text" class="form-control" name="telp" id="telp" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Umur</label>
                        <input type="text" class="form-control" name="umur" id="umur" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection