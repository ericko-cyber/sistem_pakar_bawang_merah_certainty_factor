@extends('layouts.admin.masteradmin')

@section('title', 'Dashboard')

@section('content')

<h1 class="mt-4">Dashboard</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Dashboard</li>
</ol>

<div class="row">
    <!-- Card Primary -->
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body" style="font-size: 18px;">Total User: {{ $totalUser }}</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="{{ route('daftaruser') }}">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <!-- Card Warning -->
    <div class="col-xl-3 col-md-6">
        <div class="card bg-warning text-white mb-4">
            <div class="card-body" style="font-size: 18px;">Total Diagnosa: {{ $totalDiagnosa }}</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link scroll-to-section" href="#history">View Details</a>
                <div class="small text-white "><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <!-- Card Success -->
    <div class="col-xl-3 col-md-6">
        <div class="card bg-success text-white mb-4">
            <div class="card-body" style="font-size: 18px;">Total Penyakit: {{ $totalPenyakit }}</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="{{ route('daftarpenyakit') }}">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <!-- Card Danger -->
    <div class="col-xl-3 col-md-6">
        <div class="card bg-danger text-white mb-4">
            <div class="card-body" style="font-size: 18px;">Total Gejala: {{ $totalGejala }}</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="{{ route('daftargejala') }}">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Area Chart -->
    <div class="col-xl-6">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-chart-area me-1"></i>
                Activity Diagnosa
            </div>
            <div class="card-body">
                <canvas id="myAreaChart" data-labels='@json($labelsDiagnosa)'
                    data-values='@json($dataDiagnosa)' width="100%" height="40"></canvas>
            </div>
        </div>
    </div>
    <!-- Bar Chart -->
    <div class="col-xl-6">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-chart-bar me-1"></i>
                Activity Register
            </div>
            <div class="card-body">
                <canvas id="myBarChart" data-labels='@json($labels)' data-values='@json($dataRegister)' width="100%" height="40"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- DataTable -->
<div class="card mb-4" id="history" data-wow-duration="1s" data-wow-delay="0.5s">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        History Diagnosa
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Penyakit</th>
                    <th>nilai</th>
                    <th>Tanggal Diagnosa</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Nama</th>
                    <th>Penyakit</th>
                    <th>nilai</th>
                    <th>Tanggal Diagnosa</th>
                    <th>Aksi</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($riwayatDiagnosa as $riwayat)
                <tr>
                    <td>{{ $riwayat->user->username }}</td>
                    <td>{{ $riwayat->penyakit->nama_penyakit }}</td>
                    <td>{{ $riwayat->nilai }}</td>
                    <td>{{ \Carbon\Carbon::parse($riwayat->tanggal)->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('history.print', $riwayat->id_riwayat) }}" class="btn btn-sm btn-primary">
                            Detail
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>
@endsection