@extends('layouts.auth')

@section('title', 'Reset Sandi')

@section('content')

<style>
    button {
        margin-top: 10px !important;
    }
</style>

<div class="login">
    <h1>Masukkan Sandi Baru</h1>

    <form action="{{ route('reset.password') }}" method="POST" class="form login-form">
        @csrf

        <input type="hidden" name="email" value="{{ session('email') }}">

        <label class="form-label" for="new_password">Sandi Baru</label>
        <div class="form-group">
            <svg class="form-icon-left" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 512 512">
                <path d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z" />
            </svg>
            <input class="form-input" type="password" name="password" placeholder="Sandi Baru" id="new_password" required minlength="8">
        </div>

        @error('password')
        <div class="msg error">
            <p>{{ $message }}</p>
        </div>
        @enderror

        <label class="form-label" for="new_password_confirmation">Konfirmasi Sandi Baru</label>
        <div class="form-group">
            <svg class="form-icon-left" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 512 512">
                <path d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z" />
            </svg>
            <input class="form-input" type="password" name="password_confirmation" placeholder="Konfirmasi Sandi Baru" id="new_password_confirmation" required>
        </div>

        @error('password_confirmation')
        <div class="msg error">
            <p>{{ $message }}</p>
        </div>
        @enderror

        @if (session('status'))
        <div class="msg success">
            <p>{{ session('status') }}</p>
        </div>
        @endif

        <button class="btn blue" type="submit">Reset Sandi</button>
    </form>
</div>

@endsection
