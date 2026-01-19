<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Kasir</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">

    {{-- NAVBAR --}}
    <nav class="bg-white shadow p-4 mb-6">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="font-bold text-xl text-pink-600">Kasir App</h1>
            <div class="flex gap-4">
                <a href="{{ route('kasir.index') }} class="hover:text-pink-600">Dashboard</a>
                <a href="/kategori" class="hover:text-pink-600">Kategori</a>
                <a href="/produk" class="hover:text-pink-600">Produk</a>
                <form action="/logout" method="POST">
                    @csrf
                    <button class="text-red-500 hover:text-red-700">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    {{-- PAGE CONTENT --}}
    <div class="container mx-auto">
        {{ $slot }}
    </div>

</body>
</html>
