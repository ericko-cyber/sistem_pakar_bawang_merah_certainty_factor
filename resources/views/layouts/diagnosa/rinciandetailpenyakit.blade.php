@extends('layouts.diagnosa.masterdiagnosa')

@section('title', 'DetailPenyakit')

@section('content')

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>Detail Penyakit</title>
    <link rel="stylesheet" href="{{ asset('assets/css/rinciandetailpenyakit.css') }}">

</head>

<body>
    <div class="container rincian">

        <div class="detail-container">
            <!-- Tombol Kembali di Sebelah Kiri -->
            <div class="back-button">
                <a href="javascript:history.back()" class="btn-kembali">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali
                </a>
            </div>

            <!-- Bagian Teks dan Gambar -->
            <div class="text-image-wrapper">
                <!-- Bagian Teks -->
                <div class="text-container">
                    <h1 class="ml-5">{{ $penyakit->subjudul }}</h1>
                    <p class="pjudul">
                        Pelajari lebih lanjut tentang berbagai penyakit yang dapat menyerang bawang merah, termasuk gejala yang muncul serta langkah-langkah penanggulangannya.
                    </p>
                    <div class="label">Penyakit</div>
                    <section class="section-container">
                        <h2 class="section-title">Deskripsi Penyakit</h2>
                        <p class="section-text">
                            {{$penyakit->deskripsi}}
                        </p>
                    </section>

                    <section class="section-container">
                        <h2 class="section-title">Gejala</h2>
                        <ol class="section-text" style="font-weight: 600; font-size: 15px;">
                            @foreach($penyakit->gejala as $gejala)
                            <li>{{ $gejala->nama_gejala }}</li>
                            @endforeach
                        </ol>
                    </section>


                    <section class="section-container">
                        <h2 class="section-title">Penanganan</h2>
                        <ol class="section-text" style="font-weight: 600; font-size: 15px;">
                            @foreach(explode("\n", $penyakit->penanganan) as $item)
                            <li>{{ $item }}</li>
                            @endforeach
                        </ol>
                    </section>

                </div>

                <!-- Bagian Gambar -->
                <div class="image-container">
                    <img src="{{ asset('assets/images/' . $penyakit->gambar) }}" alt="Gambar Penyakit">
                    <div class="banner-top"></div>
                    <div class="banner-bottom"></div>
                </div>
            </div>
        </div>
    </div>


</body>

</html>

@endsection