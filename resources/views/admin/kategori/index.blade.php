@extends('admin.layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Daftar Kategori</h1>
        <a href="{{ route('kategori.create') }}" class="bg-green-500 text-white px-4 py-2 text-white rounded-lg">
            + Tambah Kategori
        </a>
    </div>

    <table class="w-full bg-white rounded-lg shadow overflow-hidden">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="p-3 w-12 text-center">#</th>
                <th class="p-3">Nama Kategori</th>
                <th class="p-3 text-center w-40">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($kategoris as $kategori)
                @php
                    // menangkap ID kategori dari kolom apapun
                    $kategoriId = $kategori->id_kategori ?? $kategori->id ?? null;
                @endphp

                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3 text-center">{{ $loop->iteration }}</td>
                    <td class="p-3">{{ $kategori->nama ?? $kategori->nama_kategori }}</td>
                    <td class="p-3 flex items-center justify-center gap-4 text-sm">

                        {{-- EDIT aman: ID selalu ada --}}
                        <a href="{{ route('kategori.edit', $kategoriId) }}" 
                           class="text-blue-600 font-medium hover:text-blue-800">
                            Edit
                        </a>

                        {{-- DELETE aman --}}
                        <form action="{{ route('kategori.destroy', $kategoriId) }}" 
                              method="POST" onsubmit="return confirm('Yakin hapus kategori ini?');">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 font-medium hover:text-red-800">
                                Hapus
                            </button>
                        </form>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="p-6 text-center text-gray-500">
                        Belum ada kategori
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection