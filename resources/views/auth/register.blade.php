{{--
    File: resources/views/auth/register.blade.php

    Deskripsi:
    Tampilan untuk halaman registrasi pengguna baru. Didesain ulang dengan
    gaya modern, menggunakan layout dua kolom. File ini sekarang menjadi
    layout mandiri dan tidak menggunakan x-guest-layout.
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Register</title>

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
            <div class="w-1/2 bg-green-50 p-10 md:p-14 flex-col justify-center hidden md:flex">
                <h1 class="text-4xl font-extrabold text-green-800">Daftarkan Diri anda </h1>
                <p class="mt-4 text-lg text-green-700 font-medium">Di Sistem Peminjaman Gedung/Ruangan</p>
                <h2 class="text-3xl font-bold text-green-800 mt-2">Universitas Malikussaleh</h2>

                <div class="mt-10 text-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Gedung Kampus"
                        class="w-48 h-auto mx-auto rounded-xl">
                </div>

            </div>


            <!-- Kolom Kanan: Form Registrasi -->
            <div class="w-full md:w-1/2 p-8 md:p-12">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Buat Akun Baru</h2>
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input id="name" type="text" name="name" :value="old('name')" required autofocus
                            autocomplete="name"
                            class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="mt-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                        <input id="email" type="email" name="email" :value="old('email')" required
                            autocomplete="username"
                            class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Role -->
                    <div class="mt-4">
                        <label for="role" class="block text-sm font-medium text-gray-700">Saya mendaftar
                            sebagai</label>
                        <select id="role" name="role"
                            class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500">
                            <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa
                            </option>
                            <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                            class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi
                            Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            autocomplete="new-password"
                            class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between mt-8">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                            href="{{ route('login') }}">
                            Sudah punya akun?
                        </a>

                        <button type="submit"
                            class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Daftar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
