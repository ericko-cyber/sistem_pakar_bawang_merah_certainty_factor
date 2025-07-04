<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,minimum-scale=1">
	<title>@yield('title', 'Login System')</title>
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

	<!-- Bootstrap core CSS -->
	<base href="{{ url('/') }}/">
	<!-- Bootstrap core CSS -->
	<link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
	<link rel="icon" href="{{ asset('bawang.ico') }}" type="image/x-icon">

	<!-- Additional CSS Files -->
	<link rel="stylesheet" href="{{ asset('assets/css/fontawesome.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/diagnosa.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/animated.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/owl.css') }}">

	<style>
		/* Bungkus semua selector popup profile di dalam .popup-overlay */
		.popup-overlay .overlay-container {
			display: none;
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: rgba(0, 0, 0, 0.6);
			justify-content: center;
			align-items: center;
			z-index: 9999;
		}

		/* Popup aktif */
		.popup-overlay .overlay-container.show {
			display: flex;
		}

		/* Kotak popup */
		.popup-overlay .popup-box {
			background: #fff;
			padding: 20px;
			border-radius: 12px;
			box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
			max-width: 90%;
			position: relative;
			animation: fadeInUp 0.3s ease-out forwards;
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

		.popup-overlay .popup-box h2 {
			margin-bottom: 15px;
			font-weight: 600;
			color: #fe3f40;
			text-align: center;
		}

		/* Tab navigation styles */
		.popup-overlay .tab-navigation {
			display: flex;
			margin-bottom: 15px;
			border-bottom: 1px solid #ddd;
		}

		.popup-overlay .tab-button {
			flex: 1;
			padding: 8px 12px;
			background: #f8f8f8;
			border: none;
			border-radius: 8px 8px 0 0;
			cursor: pointer;
			font-weight: 500;
			transition: all 0.2s ease;
			color: #555;
		}

		.popup-overlay .tab-button:hover {
			background: #f0f0f0;
		}

		.popup-overlay .tab-button.active {
			background: #fe3f40;
			color: white;
		}

		/* Tab content styles */
		.popup-overlay .tab-content {
			display: none;
		}

		.popup-overlay .tab-content.active {
			display: block;
		}

		/* Form container */
		.popup-overlay .form-container {
			display: flex;
			flex-direction: column;
			gap: 12px;
		}

		/* Form layout improvements */
		.popup-overlay .form-row {
			display: flex;
			gap: 10px;
		}

		.popup-overlay .form-group {
			flex: 1;
			display: flex;
			flex-direction: column;
			gap: 5px;
		}

		/* Label and input styling */
		.popup-overlay .form-label {
			font-size: 14px;
			color: #444;
			font-weight: 500;
		}

		.popup-overlay .form-input {
			padding: 8px 10px;
			border: 1px solid #ddd;
			border-radius: 6px;
			font-size: 14px;
			transition: border-color 0.2s;
		}

		.popup-overlay .form-input:focus {
			border-color: #fe3f40;
			outline: none;
			box-shadow: 0 0 0 2px rgba(254, 63, 64, 0.1);
		}

		.popup-overlay textarea.form-input {
			resize: vertical;
			min-height: 60px;
		}

		/* Button styling */
		.popup-overlay .btn-submit,
		.popup-overlay .btn-close-popup {
			padding: 10px;
			border: none;
			border-radius: 6px;
			cursor: pointer;
			font-weight: 500;
			transition: all 0.2s ease;
			margin-top: 5px;
		}

		.popup-overlay .btn-submit {
			background-color: #fe3f40;
			color: white;
		}

		.popup-overlay .btn-submit:hover {
			background-color: #e53638;
		}

		.popup-overlay .btn-close-popup {
			background-color: #f2f2f2;
			color: #333;
			margin-top: 10px;
		}

		.popup-overlay .btn-close-popup:hover {
			background-color: #e8e8e8;
		}

		/* Success notification */
		.popup-overlay .notification {
			position: fixed;
			top: 80px;
			right: 20px;
			background: #4CAF50;
			color: white;
			padding: 12px 20px;
			border-radius: 6px;
			box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
			z-index: 10001;
			animation: slideIn 0.3s ease-out forwards;
		}

		.popup-overlay .popup-box {
			width: 500px;
			max-width: 90%;
			transition: width 0.3s ease, min-height 0.3s ease;
			/* style lain seperti sebelumnya */
		}

		.popup-overlay .popup-box.password-tab {
			width: 400px;
		}


		@keyframes slideIn {
			from {
				opacity: 0;
				transform: translateX(50px);
			}

			to {
				opacity: 1;
				transform: translateX(0);
			}
		}

		/* Responsive adjustments */
		@media (max-width: 480px) {
			.popup-overlay .form-row {
				flex-direction: column;
				gap: 12px;
			}

			.popup-overlay .popup-box {
				width: 85%;
				padding: 15px;
			}
		}
	</style>
</head>


<body>

	<header class="header-area header-sticky wow slideInDown" data-wow-duration="0.75s" data-wow-delay="0s">
		<div class="container ">
			<div class="row">
				<div class="col-12">
					<nav class="main-nav">
						<!-- ***** Logo Start ***** -->
						<a href="index.html" class="logo">
							<a href="" class="logo">
								<h4>Shallot<span>Detect</span></h4>
							</a>
						</a>
						<!-- ***** Logo End ***** -->
						<!-- ***** Menu Start ***** -->
						<ul class="nav">
							<li class=""><a href="{{ route('home') }}">Home</a></li>
							<li class="{{ request()->routeIs('detailpenyakit') ? 'active' : '' }}">
								<a href="{{ route('detailpenyakit') }}">Detail Penyakit</a>
							</li>

							<li class="{{ request()->routeIs('diagnosa') ? 'active' : '' }}">
								<a href="{{ route('diagnosa') }}">Diagnosa</a>
							</li>
							<li class="{{ request()->routeIs('history') ? 'active' : '' }}">
								<a href="{{ route('history') }}">Riwayat</a>
							</li>
							<li class="d-flex align-items-center">
								@if(Auth::check())
								<a href="javascript:void(0);" class="main-red-button" onclick="togglePopup()">Profil</a>
								<a href="#" class="main-red-button" style="margin-left: 10px;"
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
						<!-- ***** Menu End ***** -->
					</nav>
				</div>
			</div>
		</div>
	</header>

	@if(session('success'))
	<div id="flash-success" class="notification">
		{{ session('success') }}
	</div>
	<script>
		setTimeout(() => {
			const flash = document.getElementById('flash-success');
			if (flash) {
				flash.style.opacity = '0';
				flash.style.transform = 'translateX(50px)';
				flash.style.transition = 'all 0.3s ease';
				setTimeout(() => flash.remove(), 300);
			}
		}, 3000);
	</script>
	@endif

	<!-- Popup Profil -->
	<div class="popup-overlay">
		<div id="popupOverlay" class="overlay-container">
			<div class="popup-box">
				<h2>PROFIL</h2>

				<!-- Tab Navigation -->
				<div class="tab-navigation">
					<button class="tab-button active" onclick="openTab('profileTab', this)">Profile</button>
					<button class="tab-button" onclick="openTab('passwordTab', this)">Password</button>
				</div>

				<!-- Profile Tab Content -->
				<div id="profileTab" class="tab-content active">
					<form id="updateProfileForm" class="form-container" method="POST" action="{{ route('user.updateProfile') }}">
						@csrf
						<div class="form-row">
							<div class="form-group">
								<label class="form-label" for="username">Username</label>
								<input class="form-input" type="text" id="username" name="username" value="{{ Auth::user()->username ?? 'Guest' }}" required>
							</div>
							<div class="form-group">
								<label class="form-label" for="email">Email</label>
								<input class="form-input" type="email" id="email" name="email" value="{{ Auth::user()->email ?? 'Guest' }}" required>
							</div>
						</div>

						<div class="form-row">
							<div class="form-group">
								<label class="form-label" for="umur">Tanggal Lahir</label>
								<input class="form-input" type="date" id="umur" name="umur" value="{{ Auth::user()->umur ?? '' }}">
							</div>
							<div class="form-group">
								<label class="form-label" for="telp">Telp</label>
								<input class="form-input" type="text" id="telp" name="telp" value="{{ Auth::user()->telp ?? '' }}" pattern="\d+" title="Hanya angka yang diperbolehkan" required>
							</div>
						</div>

						<div class="form-group">
							<label class="form-label" for="alamat">Alamat</label>
							<textarea class="form-input" id="alamat" name="alamat" rows="2">{{ Auth::user()->alamat ?? '' }}</textarea>
						</div>

						<button class="btn-submit" type="submit">
							Update Profile
						</button>
					</form>
				</div>

				<!-- Password Tab Content -->
				<div id="passwordTab" class="tab-content">
					<form id="updatePasswordForm" class="form-container" method="POST" action="{{ route('user.updatePassword') }}">
						@csrf
						<div class="form-group">
							<label class="form-label" for="passupdate">Password Baru</label>
							<input class="form-input" type="password" id="passupdate" name="passupdate" placeholder="Masukkan Password Baru" required>
						</div>

						<button class="btn-submit" type="submit">
							Update Password
						</button>
					</form>
				</div>

				<button class="btn-close-popup" onclick="togglePopup()">
					Close
				</button>
			</div>
		</div>
	</div>
	<script>
		// Toggle popup visibility
		function togglePopup() {
			const popup = document.getElementById('popupOverlay');
			popup.classList.toggle('show');
		}

		// Tab switching functionality
		function openTab(tabId, btn) {
			// Hide semua tab-content
			document.querySelectorAll('.tab-content').forEach(tc => tc.classList.remove('active'));

			// Hapus active dari semua tombol tab
			document.querySelectorAll('.tab-button').forEach(b => b.classList.remove('active'));

			// Show tab yang diklik
			document.getElementById(tabId).classList.add('active');

			// Tambahkan active pada tombol yang diklik
			btn.classList.add('active');

			// Ambil popup-box
			const popupBox = document.querySelector('.popup-overlay .popup-box');

			if (tabId === 'passwordTab') {
				popupBox.classList.add('password-tab');
			} else {
				popupBox.classList.remove('password-tab');
			}
		}

		function openTab(tabName, buttonElement) {
			// Hide all tab contents
			const tabContents = document.getElementsByClassName("tab-content");
			for (let i = 0; i < tabContents.length; i++) {
				tabContents[i].classList.remove("active");
			}

			// Remove active class from all tab buttons
			const tabButtons = document.getElementsByClassName("tab-button");
			for (let i = 0; i < tabButtons.length; i++) {
				tabButtons[i].classList.remove("active");
			}

			// Show the selected tab content
			document.getElementById(tabName).classList.add("active");

			// Add active class to the clicked button
			buttonElement.classList.add("active");
		}
	</script>

	<div class="content">
		@yield('content')
	</div>
	<footer>
		<div class="container">
			<div class="row">
				<div class="col-lg-12 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.25s">
					<p>© Copyright 2024 by Ihya Ulumuddin
					</p>
				</div>
			</div>
		</div>
	</footer>
	<!-- Scripts -->
	<script src="vendor/jquery/jquery.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="assets/js/owl-carousel.js"></script>
	<script src="assets/js/animation.js"></script>
	<script src="assets/js/imagesloaded.js"></script>
	<script src="assets/js/templatemo-custom.js"></script>

</body>

</html>