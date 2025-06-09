<div class="main-banner wow fadeIn" id="top" data-wow-duration="1s" data-wow-delay="0.5s">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-6 align-self-center">
                        <div class="left-content header-text wow fadeInLeft" data-wow-duration="1s" data-wow-delay="1s">
                            <h6>Selamat Datang di Sistem Diagnosa Penyakit Bawang Merah</h6>
                            <h2>Temukan<em> Gejala</em> &amp; <span>Solusi</span> Yang Tepat </h2>
                            <p>Sistem ini membantu Anda mendiagnosa penyakit bawang merah berdasarkan gejala yang terdeteksi, serta memberikan rekomendasi penanganan yang sesuai.</p>
                            <form id="search" action="#" method="GET">
                                <fieldset style="display: flex; justify-content: space-between; align-items: center; gap: 10px;">
                                    <div class="email">Masalah Pada Tanaman</div>
                                    @if(Auth::check())
                                    @if(Auth::user()->role === 'admin')
                                    <!-- Jika admin klik tombol Konsultasi Sekarang, kita refresh halaman /home -->
                                    <a href="#" class="main-button" onclick="reloadHomePage()">Konsultasi Sekarang</a>
                                    @else
                                    <!-- Jika user klik tombol Konsultasi Sekarang, diarahkan ke halaman diagnosa -->
                                    <a href="{{ route('diagnosa') }}" class="main-button">Konsultasi Sekarang</a>
                                    @endif
                                    @else
                                    <!-- Jika pengguna belum login, tombol Login bisa muncul (sesuai kebutuhan Anda) -->
                                    <a href="{{ route('login') }}" class="main-button">Konsultasi Sekarang</a>
                                    @endif
                                </fieldset>
                            </form>

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="right-image wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.5s">
                            <img src="assets/images/banner-right-Bawang-Merah.jpg" alt="team meeting">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>