<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,minimum-scale=1">
	<title>@yield('title', 'Login System')</title>

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

	<!-- Bootstrap core CSS -->
	<link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
	<link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">


	<!-- Additional CSS Files -->
	<link rel="stylesheet" href="{{ asset('assets/css/fontawesome.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/templatemo-space-dynamic.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/animated.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/owl.css') }}">

	<style>
		.popup-box h2 {
			margin-bottom: 20px !important;
			font-weight: 600 !important;
		}

		.popup-box p{
			font-size: 17px !important;
			font-weight: 400 !important;
			margin-bottom: 5px;
		}


		/* Tombol untuk membuka popup */
		.btn-open-popup {
			padding: 12px 24px;
			font-size: 18px;
			background-color: green;
			color: #fff;
			border: none;
			border-radius: 8px;
			cursor: pointer;
			transition: background-color 0.3s ease;
			position: fixed;
			top: 20px;
			right: 20px;
		}

		.btn-open-popup:hover {
			background-color: #4caf50;
		}

		/* Overlay untuk popup */
		.overlay-container {
			display: none;
			/* Awalnya tersembunyi */
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: rgba(0, 0, 0, 0.6);
			justify-content: center;
			align-items: center;
			opacity: 0;
			transition: opacity 0.3s ease;
			z-index: 9999;
			/* Pastikan di atas elemen lain */
		}

		/* Kotak popup */
		.popup-box {
			background: #fff;
			padding: 24px;
			border-radius: 12px;
			box-shadow: 0 0 20px rgba(0, 0, 0, 0.4);
			width: 320px;
			text-align: center;
			opacity: 0;
			transform: scale(0.8);
			animation: fadeInUp 0.5s ease-out forwards;
			z-index: 10000;
			position: relative;
		}

		/* Form di dalam popup */
		.form-container {
			display: flex;
			flex-direction: column;
			gap: 10px;
		}

		/* Label input */
		.form-label {
			font-size: 16px;
			color: #444;
			text-align: left;
		}

		/* Input field */
		.form-input {
			padding: 10px;
			border: 1px solid #ccc;
			border-radius: 8px;
			font-size: 16px;
			width: 100%;
			box-sizing: border-box;
		}

		/* Tombol Submit dan Close */
		.btn-submit,
		.btn-close-popup {
			padding: 12px 24px;
			border: none;
			border-radius: 8px;
			cursor: pointer;
			transition: background-color 0.3s ease;
			width: 100%;
		}

		.btn-submit {
			background-color: green;
			color: #fff;
		}

		.btn-submit:hover {
			background-color: #4caf50;
		}

		.btn-close-popup {
			margin-top: 12px;
			background-color: #e74c3c;
			color: #fff;
		}

		.btn-close-popup:hover {
			background-color: #c0392b;
		}

		/* Animasi untuk fade-in popup */
		@keyframes fadeInUp {
			from {
				opacity: 0;
				transform: translateY(20px);
			}

			to {
				opacity: 1;
				transform: translateY(0);
			}
		}

		/* Overlay aktif */
		.overlay-container.show {
			display: flex;
			opacity: 1;
		}
	</style>

</head>

<body>

	<header class="header-area header-sticky wow slideInDown" data-wow-duration="0.75s" data-wow-delay="0s">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<nav class="main-nav">
						<!-- ***** Logo Start ***** -->
						<a href="index.html" class="logo">
							<h4>Sistem<span>Pakar</span></h4>
						</a>
						<!-- ***** Logo End ***** -->
						<!-- ***** Menu Start ***** -->
						<ul class="nav">
							<li class="scroll-to-section"><a href="#top" class="active">Home</a></li>
							<li class="scroll-to-section"><a href="#about">Basic Pengetahuan</a></li>
							<li class="scroll-to-section"><a href="#PP">Panduan Penggunaan</a></li>
							<li><a href="{{ route('diagnosa') }}">Diagnosa</a></li>
							<li class="d-flex align-items-center">
								@if(Auth::check())
								<a href="#" class="main-red-button" onclick="togglePopup()">Profil</a>
								<a href="#" class="main-red-button"
									onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
									Logout
								</a>
								<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
									@csrf
								</form>
								@else
								<a href="{{ route('login') }}" class="main-red-button">Login</a>
								@endif
							</li>
						</ul>
						<a class='menu-trigger'>
							<span>Menu</span>
						</a>
					</nav>
				</div>
			</div>
		</div>
	</header>

	<!-- Popup Profil -->
	<div id="popupOverlay"
		class="overlay-container">
		<div class="popup-box">
			<h2 style="color: #fe3f40;">PROFIL</h2>
			<form class="form-container">
				<label class="form-label"
					for="name">
					Username:
				</label>
				<p>{{ Auth::user()->username ?? 'Guest' }}</p>
				<label class="form-label"
					for="name">
					Umur:
				</label>
				<p>{{ Auth::user()->umur ?? 'Guest' }}</p>
				<label class="form-label"
					for="name">
					Telp:
				</label>
				<p>{{ Auth::user()->telp ?? 'Guest' }}</p>
				<label class="form-label"
					for="name">
					Email:
				</label>
				<p>{{ Auth::user()->email ?? 'Guest' }}</p>
				<label class="form-label"
					for="name">
					Alamat:
				</label>
				<p>{{ Auth::user()->alamat ?? 'Guest' }}</p>
				<label class="form-label" for="passupdate">Update Password:</label>
				<input class="form-input"
					type="password"
					placeholder="Masukkan Password Baru"
					id="passupdate"
					name="passupdate" required>
				<button class="btn-submit"
					type="submit">
					Submit
				</button>
			</form>

			<button class="btn-close-popup"
				onclick="togglePopup()">
				Close
			</button>
		</div>
	</div>

		<!-- Scripts -->
		<script>
		function togglePopup() {
			const overlay = document.getElementById('popupOverlay');
			overlay.classList.toggle('show');
		}
	</script>

	<div class="content">
		@yield('content')
	</div>

	<footer>
		<div class="container">
			<div class="row">
				<div class="col-lg-12 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.25s">
					<p>© Copyright 2024 by Ihya Ulumuddin</p>
				</div>
			</div>
		</div>
	</footer>



	<script src="vendor/jquery/jquery.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="assets/js/owl-carousel.js"></script>
	<script src="assets/js/animation.js"></script>
	<script src="assets/js/imagesloaded.js"></script>
	<script src="assets/js/templatemo-custom.js"></script>

</body>

</html>