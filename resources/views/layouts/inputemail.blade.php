@extends('layouts.auth')

@section('title', 'Lupa Password')

@section('content')

<style>
    button {
        margin-top: 10px !important;
    }
</style>

<div class="login">

    <h1>Lupa Password</h1>

    <form action="{{ route('otp.send') }}" method="POST" class="form login-form">
        @csrf

        <label class="form-label" for="email">Email</label>
        <div class="form-group">
            <svg class="form-icon-left" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 512 512">
                <path d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z" />
            </svg>
            <input class="form-input" type="email" name="email" placeholder="Email" id="email" value="{{ old('email') }}" required>
        </div>

        @error('email')
        <div class="msg error">
            <p>{{ $message }}</p>
        </div>
        @enderror

        @if (session('status'))
        <div class="msg success">
            <p>{{ session('status') }}</p>
        </div>
        @endif

        <button class="btn blue" type="submit">Kirim</button>
        <p class="register-link">Sudah punya akun? <a href="{{ route('login') }}" class="form-link">Login</a></p>
    </form>

</div>

@endsection
