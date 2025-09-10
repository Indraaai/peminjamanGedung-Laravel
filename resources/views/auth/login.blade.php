{{--
    File: resources/views/auth/login.blade.php

    Deskripsi:
    Tampilan untuk halaman login pengguna. Didesain ulang dengan gaya modern,
    menggunakan layout dua kolom yang konsisten dengan halaman registrasi.
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex items-center justify-center bg-gray-50 antialiased">
        <div class="w-full max-w-4xl flex flex-row bg-white rounded-2xl shadow-xl overflow-hidden">

            <!-- Kolom Kiri: Branding & Informasi -->
            <div class="w-1/2 bg-green-50 p-8 md:p-12 flex-col justify-center hidden md:flex">
                <h1 class="text-3xl font-bold text-green-800">Selamat Datang</h1>
                <p class="mt-4 text-lg text-green-700 font-medium">Di Sistem Peminjaman Gedung/Ruangan</p>
                <h2 class="text-3xl font-bold text-green-800 mt-2">Universitas Malikussaleh</h2>
                <div class="mt-10 text-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Gedung Kampus"
                        class="w-48 h-auto mx-auto rounded-xl">
                </div>
            </div>

            <!-- Kolom Kanan: Form Login -->
            <div class="w-full md:w-1/2 p-8 md:p-12">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Login ke Akun Anda</h2>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                        <input id="email" type="email" name="email" :value="old('email')" required autofocus
                            autocomplete="username"
                            class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox"
                                class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500"
                                name="remember">
                            <span class="ms-2 text-sm text-gray-600">Ingat saya</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                                href="{{ route('password.request') }}">
                                Lupa password?
                            </a>
                        @endif
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="mt-8">
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Login
                        </button>
                    </div>

                    <div class="mt-6 text-center">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('register') }}">
                            Belum punya akun? Daftar sekarang
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
