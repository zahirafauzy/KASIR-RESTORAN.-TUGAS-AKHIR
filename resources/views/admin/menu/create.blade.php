@extends('admin.layouts.app')

@section('content')
<div class="bg-white p-6 rounded-xl shadow max-w-xl">
    <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
        <label class="block mb-2 font-medium">Nama Menu</label>
        <input type="text" name="nama_menu" class="w-full border px-4 py-2 rounded mb-4" required>
        <label class="block mb-2 font-medium">Harga Menu (Cth: 20000)</label>
        <input type="text" name="harga_menu" class="w-full border px-4 py-2 rounded mb-4" required>
        <label class="block mb-2 font-medium">Kategori Menu</label>
        <select name="id_kategori" class="w-full border px-4 py-2 rounded mb-4" required>
            <option value="">-- Pilih Kategori --</option>

            @foreach ($kategoris as $kategori)
                <option value="{{ $kategori->id_kategori }}">
                    {{ $kategori->nama_kategori }}
                </option>
            @endforeach
        </select>
        <label class="block mb-2 font-medium">Gambar Menu</label>
        <input
            type="file"
            name="image_menu"
            accept="image/*"
            class="w-full border px-4 py-2 rounded mb-4"
            required
        >
        <label class="block mb-2 font-medium">Stok Menu</label>
        <input type="text" name="stok_menu" class="w-full border px-4 py-2 rounded mb-4" required>

        <button class="bg-[#ff2e6f] hover:bg-[#ff6f93] text-white px-6 py-2 mt-1 rounded-full">Simpan</button>
    </form>
</div>
@endsection
