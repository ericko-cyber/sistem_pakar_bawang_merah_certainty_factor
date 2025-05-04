@extends('layouts.admin.masteradmin')

@section('title', 'Manajemen Rules')

@section('content')

<div class="container mt-5">

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <h1 class="mt-4">Basic Rules</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Basic Rules</li>
    </ol>
    <div class="accordion" id="accordionPenyakit">

        @foreach ($penyakit_list as $penyakit)
        <div class="accordion-item">
            <h2 class="accordion-header" id="heading{{ $penyakit->id }}">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $penyakit->id }}" aria-expanded="false" aria-controls="collapse{{ $penyakit->id }}">
                    {{ $penyakit->nama_penyakit }}
                </button>
            </h2>
            <div id="collapse{{ $penyakit->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $penyakit->id }}" data-bs-parent="#accordionPenyakit">
                <div class="accordion-body">

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Gejala</th>
                                <th>CF Pakar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penyakit->rules as $rule)
                            <tr>
                                <td>{{ $rule->gejala->kode_gejala }} - {{ $rule->gejala->nama_gejala }}</td>
                                <td>{{ $rule->cf_pakar }}</td>
                                <td>
                                    <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditGejala{{ $rule->id }}">
                                        Edit
                                    </a>
                                    <!-- Modal Edit (langsung setelah tombolnya) -->
                                    <div class="modal fade" id="modalEditGejala{{ $rule->id }}" tabindex="-1" aria-labelledby="modalEditGejalaLabel{{ $rule->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('rules.update', $rule->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalEditGejalaLabel{{ $rule->id }}">Edit Gejala</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="mb-3">
                                                            <label for="gejala_id" class="form-label">Pilih Gejala</label>
                                                            <select class="form-select" name="id_gejala" required>
                                                                @foreach ($gejala_list as $gejala)
                                                                <option value="{{ $gejala->id }}" {{ $gejala->id == $rule->id_gejala ? 'selected' : '' }}>
                                                                    {{ $gejala->kode_gejala }} - {{ $gejala->nama_gejala }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="cf_pakar" class="form-label">Certainty Factor</label>
                                                            <select class="form-select" name="cf_pakar" required>
                                                                <option value="1.0" {{ $rule->cf_pakar == '1.0' ? 'selected' : '' }}>Pasti (1.0)</option>
                                                                <option value="0.8" {{ $rule->cf_pakar == '0.8' ? 'selected' : '' }}>Hampir Pasti (0.8)</option>
                                                                <option value="0.6" {{ $rule->cf_pakar == '0.6' ? 'selected' : '' }}>Kemungkinan Besar (0.6)</option>
                                                                <option value="0.4" {{ $rule->cf_pakar == '0.4' ? 'selected' : '' }}>Mungkin (0.4)</option>
                                                                <option value="0.0" {{ $rule->cf_pakar == '0.0' ? 'selected' : '' }}>Tidak Tahu (0.0)</option>
                                                            </select>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <form action="{{ route('rules.destroy', $rule->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau hapus gejala ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Tombol untuk membuka modal tambah gejala -->
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahGejala{{ $penyakit->id }}">
                        Tambah Gejala ke {{ $penyakit->nama_penyakit }}
                    </button>

                </div>
            </div>
        </div>

        <!-- Modal Tambah Gejala -->
        <div class="modal fade" id="modalTambahGejala{{ $penyakit->id }}" tabindex="-1" aria-labelledby="modalTambahGejalaLabel{{ $penyakit->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('rules.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="penyakit_id" value="{{ $penyakit->id }}">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTambahGejalaLabel{{ $penyakit->id }}">Tambah Gejala untuk {{ $penyakit->nama_penyakit }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="gejala_id" class="form-label">Pilih Gejala</label>
                                <select class="form-select" name="gejala_id" required>
                                    @foreach ($gejala_list as $gejala)
                                    <option value="{{ $gejala->id }}">{{ $gejala->kode_gejala }} - {{ $gejala->nama_gejala }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="cf_pakar" class="form-label">Kondisi (Certainty Factor)</label>
                                <select class="form-select" name="cf_pakar" required>
                                    <option value="1.0">Pasti (1.0)</option>
                                    <option value="0.8">Hampir Pasti (0.8)</option>
                                    <option value="0.6">Kemungkinan Besar (0.6)</option>
                                    <option value="0.4">Mungkin (0.4)</option>
                                    <option value="0.0">Tidak Tahu (0.0)</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @endforeach

    </div>
</div>

@endsection