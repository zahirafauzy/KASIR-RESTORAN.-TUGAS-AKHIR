<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>{{ $title ?? 'Kasir App' }}</title>
    <link rel="icon" href="{{ asset('/assets/flaticon/kasir-icon.png') }}" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body
  class="font-poppins min-h-screen bg-cover bg-center bg-no-repeat"
  style="background-image: url('{{ asset('assets/bg-login.png') }}');">
  <div class="min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md">
      <div class="bg-white p-8 rounded-xl shadow">
        <h2 class="text-2xl font-bold text-[#ff2e6f] mb-4">Masuk Kasir</h2> 
        <form method="POST" action="{{ route('login') }}">
          @csrf
          <div class="mb-3">
              <label class="block text-sm">Username</label>
              <input type="text" name="username" class="border p-2 w-full" required autofocus autocomplete="username">

              @error('username')
                  <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
          </div>

          <div class="mb-3">
              <label class="block text-sm">Password</label>
              <input type="password" name="password" class="border p-2 w-full" required autocomplete="current-password">

              @error('password')
                  <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
          </div>

          <div class="flex items-center justify-between">
              <button type="submit" class="btn-accent">Login</button>

              <a href="/" class="text-sm text-gray-400">
                  Lupa password?
              </a>
          </div>
      </form>

      </div>
    </div>
  </div>
</body>
</html>