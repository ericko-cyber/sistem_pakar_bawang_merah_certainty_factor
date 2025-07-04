<?php

use Illuminate\Support\Facades\Route;

// Import the controllers
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LupaPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\DiagnosaController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GejalaController;
use App\Http\Controllers\PenyakitController;
use App\Http\Controllers\AdminHomeController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\DaftarUserController;
use App\Http\Controllers\admin\DaftarPenyakitController;
use App\Http\Controllers\admin\DaftarGejalaController;
use App\Http\Controllers\admin\RulesController;
use Psy\Command\HistoryCommand;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/vendor/{path}', function ($path) {
    return response()->file(public_path("vendor/$path"));
})->where('path', '.*');

// Default Route
Route::get('/', function () {
    return redirect('/home');
});

// Admin Routes
Route::middleware('admin')->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/admin/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');


    // Daftar User
    Route::get('/daftaruser', [DaftarUserController::class, 'index'])->name('daftaruser');
    Route::delete('/user/{id}', [DaftarUserController::class, 'destroy'])->name('user.destroy');
    Route::post('/user', [DaftarUserController::class, 'store'])->name('user.store');
    Route::get('/user/edit/{id}', [DaftarUserController::class, 'edit'])->name('user.edit');
    Route::put('/user/update/{id}', [DaftarUserController::class, 'update'])->name('user.update');

    // Rules
    Route::get('/rules', [RulesController::class, 'index'])->name('rules');
    Route::post('/rules', [RulesController::class, 'store'])->name('rules.store');
    Route::put('/rules/{id}', [RulesController::class, 'update'])->name('rules.update');
    Route::delete('/rules/{id}', [RulesController::class, 'destroy'])->name('rules.destroy');


    // Daftar Penyakit
    Route::get('/daftarpenyakit', [DaftarPenyakitController::class, 'index'])->name('daftarpenyakit')->middleware('auth');
    Route::delete('/penyakit/{id}', [DaftarPenyakitController::class, 'destroy'])->name('penyakit.destroy');
    Route::post('/penyakit', [DaftarPenyakitController::class, 'store'])->name('penyakit.store');
    Route::put('/penyakit/{id}', [DaftarPenyakitController::class, 'update'])->name('penyakit.update');

    // Daftar Gejala
    Route::get('/daftargejala', [DaftarGejalaController::class, 'index'])->name('daftargejala')->middleware('auth');
    Route::post('/gejala', [DaftarGejalaController::class, 'store'])->name('gejala.store');
    Route::put('/gejala/{id}', [DaftarGejalaController::class, 'update'])->name('gejala.update');
    Route::delete('/gejala/{id}', [DaftarGejalaController::class, 'destroy'])->name('gejala.destroy');
});

Route::middleware('user')->group(function () {

    // Update pass Profile
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('user.updatePassword');

    // Diagnosa Routes
    Route::get('diagnosa', [DiagnosaController::class, 'index'])->name('diagnosa');
    Route::post('/diagnosa/process', [DiagnosaController::class, 'process'])->name('diagnosa.process');
    Route::get('/diagnosa/hasil/{id}', [DiagnosaController::class, 'hasil'])->name('diagnosa.hasil');

    // Profile Route
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('user.updateProfile');


    // Route detail penyakit
    Route::get('/detailpenyakit', function () {
        return view('layouts.diagnosa.detailpenyakit');
    })->name('detailpenyakit');

    Route::get('/history', [HistoryController::class, 'index'])->name('history');

    // Route ke halaman detail riwayat
    Route::get('/history/{id}/detail', [HistoryController::class, 'detail'])->name('history.detail');
    Route::get('/history/{id}/print', [HistoryController::class, 'print'])->name('history.print');

    // Rincian detail penyakit
    Route::get('/penyakit/{id}', [PenyakitController::class, 'show'])->name('rinciandetailpenyakit');
});

Route::middleware('guest')->group(function () {

    // Route untuk menampilkan form input email
    Route::get('lupa-kata-sandi', [LupaPasswordController::class, 'showInputEmail'])->name('lupa.kata.sandi');

    // Route untuk mengirimkan OTP ke email
    Route::post('kirim-otp', [LupaPasswordController::class, 'sendOtp'])->name('otp.send');

    // Route untuk menampilkan form OTP
    Route::get('otp', [LupaPasswordController::class, 'showOtpForm'])->name('otp.form');

    // Route untuk memverifikasi OTP
    Route::post('verifikasi-otp', [LupaPasswordController::class, 'verifyOtp'])->name('otp.verify');

    // Route untuk menampilkan form reset password
    Route::get('reset-password', [LupaPasswordController::class, 'showResetPass'])->name('reset.password.form');

    // Route untuk melakukan reset password
    Route::post('reset-password', [LupaPasswordController::class, 'resetPassword'])->name('reset.password');

    // Registration Routes
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);

    // Lupa Pass
    Route::get('/lupapass', function () {
        return view('layouts.inputemail');
    })->name('lupapass');

    // Login Routes
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});

// Login Admin 
Route::get('/homeadmin', [AdminHomeController::class, 'index'])->middleware('auth');

Route::post('logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

// Home Route
Route::get('home', [HomeController::class, 'index'])->name('home');

Route::post('/gejala/fetch', [GejalaController::class, 'fetch'])->name('gejala.fetch');

Route::middleware('auth')->group(function () {
    // Route ke halaman history via controller

});
