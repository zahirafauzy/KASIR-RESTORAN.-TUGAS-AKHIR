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
<body class="bg-[#F5F6FA] font-poppins">

    <div class="flex">

        <!-- Sidebar -->
        <aside class="w-64 h-screen bg-[#1A2238] text-white px-6 py-8 fixed">
            <div class="flex">
                <img src="{{ asset('/assets/flaticon/kasir-white.png') }}" style="height: 50px; margin-right: 15px; margin-top: 6px;">
                <div class="">
                    <h2 class="text-2xl font-bold mb-0 mt-0">Admin</h2>
                    <h2 class="text-2xl font-bold mb-6 mt-0">Kasir App</h2>
                </div>
            </div>

            <ul class="space-y-4">
                <li>
                    <a href="{{ route('menu.index') }}" class="block hover:text-[#ff2e6f] {{ request()->is('admin/menu*') ? 'text-[#ff2e6f]' : '' }}">
                        Menu
                    </a>
                </li>
                <li>
                    <a href="{{ route('kategori.index') }}" class="block hover:text-[#ff2e6f] {{ request()->is('admin/kategori*') ? 'text-[#ff2e6f]' : '' }}">
                        Kategori
                    </a>
                </li>
                <li>
                    <a href="{{ route('pesanan.index') }}" class="block hover:text-[#ff2e6f] {{ request()->is('admin/pesanan*') ? 'text-[#ff2e6f]' : '' }}">
                        Pesanan
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.index') }}" class="block hover:text-[#ff2e6f] {{ request()->is('admin/user*') ? 'text-[#ff2e6f]' : '' }}">
                        User
                    </a>
                </li>
            </ul>

            <form method="POST" action="{{ route('logout') }}" class="absolute bottom-6 left-6 right-6">
                @csrf
                <button type="submit" class="w-full bg-[#ff2e6f] hover:bg-[#ff6f93] py-2 rounded-full">
                    Logout
                </button>
            </form>

        </aside>
        <!-- End Sidebar -->

        <!-- Content -->
        <main class="ml-64 w-full pt-10 min-h-screen" style="padding-top: 5px !important">
            <h1 class="text-3xl font-semibold text-gray-800 mb-4 mt-4">{{ $title ?? '' }}</h1>

            @if (session('success'))
                <div class="bg-green-500 text-white px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>

    </div>
</body>
</html>
