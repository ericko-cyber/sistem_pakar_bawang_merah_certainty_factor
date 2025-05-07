@extends('layouts.diagnosa.masterdiagnosa')

@section('title', 'diagnosa')

@section('content')
@php
$penyakit = DB::table('penyakit')->get();
$gejala = DB::table('gejala')->get();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/detailpenyakit.css') }}">


</head>

<body>
    <div class="main-banner  wow fadeIn" id="diagnosa" data-wow-duration="1s" data-wow-delay="0.5s">
        <div class="banner-top"></div>
        <div class="banner-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class=" align-self-center">
                            <div class="left-content header-text wow fadeInLeft" data-wow-duration="1s" data-wow-delay="1s">
                                <h2><span>Kenali</span> <em> Penyakit</em> <span></span> Sekarang Juga</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container detailpenyakit">
            @foreach ($penyakit as $p)
            <a href="{{ route('rinciandetailpenyakit', ['id' => $p->id]) }}" class="card-link">
                <div class="card">
                    <div class="card__header">
                        <img src="{{ asset('assets/images/' . $p->gambar) }}" alt="card__image" class="card__image" width="600">
                    </div>
                    <div class="card__body">
                        <h4 class="judul-penyakit">
                            {{ $p->subjudul }}
                        </h4>
                        <div class="flex-container">
                            <div class="label-box">Penyakit</div>
                            <div class="rekaman-button">Akses Rincian Penyakit</div>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class=" align-self-center">
                            <div class="left-content header-text wow fadeInLeft" data-wow-duration="1s" data-wow-delay="1s">
                                <h2><em>Kenali</em> <span>Gejala</span> Sekarang Juga</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container detailpenyakit">
            @foreach ($gejala as $g)
            <a href="{{ route('rinciandetailpenyakit', ['id' => $g->id]) }}" class="card-link">
                <div class="card">
                    <div class="card__header">
                        <img src="{{ asset('assets/images/' . $g->gambar) }}" alt="card__image" class="card__image" width="600">
                    </div>
                    <div class="card__body">
                        <h4 class="judul-penyakit">
                            {{ $g->nama_gejala }}
                        </h4>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</body>

</html>

@endsection