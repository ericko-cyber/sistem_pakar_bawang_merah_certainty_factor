@extends('layouts.auth')

@section('title', 'Login')

@section('content')

<div class="login">

    <h1>Login Dulu </h1>

    <form action="{{ route('login') }}" method="post" class="form login-form">

        @csrf

        <label class="form-label" for="username">Username</label>
        <div class="form-group">
            <svg class="form-icon-left" width="14" height="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                <path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z" />
            </svg>
            <input class="form-input" type="text" name="username" placeholder="Username" id="username" value="{{ old('username') }}" required>
        </div>

        <label class="form-label" for="password">Password</label>
        <div class="form-group mar-bot-5" style="position: relative;">
            <svg class="form-icon-left" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 448 512">
                <path d="M144 144v48H304V144c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192V144C80 64.5 144.5 0 224 0s144 64.5 144 144v48h16c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64H80z" />
            </svg>

            <input class="form-input" type="password" name="password" placeholder="Password" id="password" required>

            <button type="button" onclick="togglePassword()" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: transparent; border: none;">
                <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray" viewBox="0 0 576 512">
                    <path d="M572.52 241.4C518.36 135.45 407.34 64 288 64S57.64 135.45 3.48 241.4a48.14 48.14 0 0 0 0 29.2C57.64 376.55 168.66 448 288 448s230.36-71.45 284.52-177.4a48.14 48.14 0 0 0 0-29.2zM288 400c-97 0-189.09-57.82-238.3-144C98.91 169.82 191 112 288 112s189.09 57.82 238.3 144C477.09 342.18 385 400 288 400zm0-272a128 128 0 1 0 128 128 128.14 128.14 0 0 0-128-128zm0 208a80 80 0 1 1 80-80 80.09 80.09 0 0 1-80 80z" />
                </svg>
            </button>
        </div>


        @if ($errors->any())
        <div class="msg error">
            @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
            @endforeach
        </div>
        @endif

        <button class="btn blue" type="submit">Login</button>
        <p class="register-link">Lupa kata sandi? <a href="{{ route('lupa.kata.sandi') }}" class="form-link">Lupa Password</a></p>
        <p class="register-link">Tidak mempunyai akun? <a href="{{ route('register') }}" class="form-link">Register</a></p>

    </form>

</div>
<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.innerHTML = '<path d="M320 320c-17.67 0-32-14.33-32-32s14.33-32 32-32 32 14.33 32 32-14.33 32-32 32zM288 400c-97 0-189.1-57.82-238.3-144C98.9 169.8 191 112 288 112c44.2 0 86.1 13.3 120.4 36.1l46.4-35.4c4.5-3.5 11.1-2.7 14.6 1.8s2.7 11.1-1.8 14.6L421.2 164.4c28.2 23.5 51.5 53.9 67.8 89.6-49.2 86.2-141.3 144-238.3 144zm288-144c0 8.2-2.6 16.2-7.5 23.1C518.4 376.6 407.3 448 288 448S57.6 376.6 3.5 279.1a47.91 47.91 0 0 1 0-46.2C57.6 135.4 168.7 64 288 64c65.6 0 127 23.6 176.1 66.5l46.4-35.4c4.5-3.5 11.1-2.7 14.6 1.8s2.7 11.1-1.8 14.6l-46.4 35.4c20.2 21.6 37.6 46.3 51.3 73.7 5 6.9 7.8 15 7.8 23.2z"/>';
        } else {
            passwordInput.type = 'password';
            eyeIcon.innerHTML = '<path d="M572.52 241.4C518.36 135.45 407.34 64 288 64S57.64 135.45 3.48 241.4a48.14 48.14 0 0 0 0 29.2C57.64 376.55 168.66 448 288 448s230.36-71.45 284.52-177.4a48.14 48.14 0 0 0 0-29.2zM288 400c-97 0-189.09-57.82-238.3-144C98.91 169.82 191 112 288 112s189.09 57.82 238.3 144C477.09 342.18 385 400 288 400zm0-272a128 128 0 1 0 128 128 128.14 128.14 0 0 0-128-128zm0 208a80 80 0 1 1 80-80 80.09 80.09 0 0 1-80 80z"/>';
        }
    }
</script>

@endsection