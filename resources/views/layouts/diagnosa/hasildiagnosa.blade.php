@extends('layouts.diagnosa.masterdiagnosa')

@section('title', 'Hasil Diagnosa')

@section('content')

<div class="main-banner wow fadeIn" id="diagnosa" data-wow-duration="1s" data-wow-delay="0.5s">
    <div class="banner-top"></div>
    <div class="banner-bottom"></div>
    <div class="container d-flex justify-content-center" style="max-width: 900px;">
        <div class="w-100 border rounded p-3">
            @php
            // Bersihkan nilai agar hanya angka
            $nilai_angka = isset($riwayat->nilai) ? preg_replace('/[^0-9.]/', '', $riwayat->nilai) : null;
            @endphp
            <table class="table table-bordered">
                <tbody>
                    <!-- Informasi Petani -->
                    <tr>
                        <th>Nama Petani</th>
                        <td>{{ $riwayat->user->username ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Umur</th>
                        <td>{{ $riwayat->user->umur ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Telp</th>
                        <td>{{ $riwayat->user->telp ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $riwayat->user->alamat ?? '-' }}</td>
                    </tr>

                    <!-- Informasi Penyakit -->
                    <tr>
                        <th>Nama Penyakit</th>
                        <td>{{ $riwayat->penyakit->nama_penyakit ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Deskripsi Penyakit</th>
                        <td>{{ $riwayat->penyakit->deskripsi ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Gambar Penyakit</th>
                        <td>
                            <img src="{{ asset('assets/images/' . $riwayat->penyakit->gambar) }}" alt="Gambar Penyakit" style="width: 200px; height: auto;" />
                        </td>
                    </tr>

                    <!-- Presentase Diagnosa -->
                    <tr>
                        <th>Persentase</th>
                        <td>{{ $nilai_angka !== null ? $nilai_angka . '%' : '-' }}</td>
                    </tr>

                    <!-- Penanganan -->
                    <tr>
                        <th>Penanganan</th>
                        <td>
                            @if(!empty($riwayat->penyakit->penanganan))
                            @php
                            // Pisah penanganan berdasarkan baris baru (newline)
                            $list_penanganan = preg_split('/\r\n|\r|\n/', $riwayat->penyakit->penanganan);
                            @endphp
                            <ul>
                                @foreach($list_penanganan as $item)
                                <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                            @else
                            -
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="text-center mt-3">
                <a href="{{ route('history') }}" class="btn btn-secondary">Kembali ke Riwayat</a>
                <a href="{{ route('history.print', $riwayat->id_riwayat) }}" target="_blank" class="btn btn-primary">Cetak</a>
            </div>

            {{-- Kemungkinan Penyakit Lainnya --}}
            @if(!empty($alternativeDiagnoses))
            <div class="container mt-5" style="max-width: 900px;">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        Kemungkinan Penyakit Lainnya
                    </div>
                    <div class="card-body">
                        @foreach($alternativeDiagnoses as $diagnosa)
                        <div class="border-bottom py-2 d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $diagnosa['penyakit']['nama_penyakit'] }}</strong>
                                <div class="text-muted">Kemungkinan: {{ number_format($diagnosa['nilai'] * 100, 2) }}%</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    @endsection