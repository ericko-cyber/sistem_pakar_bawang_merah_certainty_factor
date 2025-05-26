@extends('layouts.diagnosa.masterdiagnosa')

@section('title', 'history')

@section('content')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="{{ asset('assets/css/history.css') }}">


<div class="main-banner  wow fadeIn " id="diagnosa" data-wow-duration="1s" data-wow-delay="0.5s">
    <div class="banner-top"></div>
    <div class="banner-bottom"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class=" align-self-center">
                        <div class="left-content header-text wow fadeInLeft" data-wow-duration="1s" data-wow-delay="1s">
                            <h2><em> Riwayat </em> Diagnosa <span>Penyakit</span> </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container d-flex justify-content-center" style="max-width: 900px;">
        <div class="w-100 border rounded p-3">
            <div class="table-responsive">
                <table id="datatablesSimple" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Diagnosa</th>
                            <th>Penyakit</th>
                            <th>Presentase</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($history_list as $index => $history)
                        <tr>
                            <td>{{ $loop->iteration }}</td> <!-- Nomor urut mulai dari 1 -->
                            <td>{{ $history->tanggal }}</td>
                            <td>{{ $penyakit_list[$history->id_penyakit] ?? '-' }}</td>
                            <td>{{ $history->nilai }}</td>
                            <td>
                                <!-- Tombol Detail yang mengarah ke route history.detail -->
                                <a href="{{ route('history.detail', $history->id_riwayat) }}" class="btn btn-sm btn-primary">Detail</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@5.0.0/dist/umd/simple-datatables.min.js"></script>
<script src="{{ asset('assets/js/scripts.js') }}"></script>
<script src="{{ asset('assets/js/datatables-simple-demo.js') }}"></script>
@stack('scripts')
@push('scripts')
<script>
    window.addEventListener('DOMContentLoaded', event => {
        const datatablesSimple = document.getElementById('datatablesSimple');
        if (datatablesSimple) {
            new simpleDatatables.DataTable(datatablesSimple, {
                columns: [{
                    select: 0,
                    sort: "asc"
                }]
            });
        }
    });
</script>
@endpush
@endsection