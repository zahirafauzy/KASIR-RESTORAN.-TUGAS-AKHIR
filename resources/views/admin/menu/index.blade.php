@extends('admin.layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Daftar Menu</h1>
        <a href="{{ route('menu.create') }}" class="bg-green-500 text-white px-4 py-2 text-white rounded-lg">
            + Tambah Menu
        </a>
    </div>

    <table class="w-full bg-white rounded-lg shadow overflow-hidden">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="p-3">#</th>
                <th class="p-3">Foto</th>
                <th class="p-3">Nama Menu</th>
                <th class="p-3">Stok</th>
                <th class="p-3">Kategori</th>
                <th class="p-3">Harga</th>
                <th class="p-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            {{-- PERBAIKAN UTAMA: Ganti $produks menjadi $menus --}}
            @forelse ($menus as $item) 
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">{{ $loop->iteration }}</td>
                    {{-- Di sini, kita menggunakan $item (sesuai perulangan) --}}
                    <td class="p-3 font-semibold">
                        <img src="{{ asset('/assets/menu/' . $item->image_menu) }}" 
                        class="object-cover rounded-lg border border-gray-100" 
                        style="height: 100px; width: 120px;"
                        alt="{{ $item->nama_menu }}">
                        <p style="font-size: 10px">
                            {{ $item->image_menu }}
                        </p>
                    </td> 
                    <td class="p-3 font-semibold">{{ $item->nama_menu }}</td> 
                    <td class="p-3 font-semibold">{{ $item->stok_menu }}</td> 
                    <td class="p-3">{{ $item->kategori->nama_kategori ?? '-' }}</td>
                    <td class="p-3">Rp {{ number_format($item->harga_menu, 0, ',', '.') }}</td>
                    <td class="p-3">
                        {{-- Tambahkan div dengan kelas flex dan space-x-2 --}}
                        <div class="flex gap-2 justify-center items-center">

                            {{-- BUTTON EDIT --}}
                            <a href="{{ route('menu.edit', $item->id_menu) }}" 
                            class="text-blue-600 hover:text-blue-800 text-xs font-medium mt-1">
                                Edit
                            </a>

                            {{-- BUTTON DELETE --}}
                            <form action="{{ route('menu.destroy', $item->id_menu) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-medium">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-3 text-center text-gray-500">Belum ada produk</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection