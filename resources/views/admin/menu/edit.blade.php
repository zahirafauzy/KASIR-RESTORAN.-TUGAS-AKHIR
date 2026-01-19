@extends('admin.layouts.app')

@section('content')
<div class="bg-white p-6 rounded-xl shadow max-w-xl">

    <form action="{{ route('menu.update', $menu->id_menu) }}" 
          method="POST" 
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label class="block mb-2 font-medium">Nama Menu</label>
        <input type="text"
               name="nama_menu"
               value="{{ old('nama_menu', $menu->nama_menu) }}"
               class="w-full border px-4 py-2 rounded mb-4"
               required>

        <label class="block mb-2 font-medium">Harga Menu</label>
        <input type="number"
               name="harga_menu"
               value="{{ old('harga_menu', $menu->harga_menu) }}"
               class="w-full border px-4 py-2 rounded mb-4"
               required>

        <label class="block mb-2 font-medium">Kategori Menu</label>
        <select name="id_kategori"
                class="w-full border px-4 py-2 rounded mb-4"
                required>
            @foreach ($kategoris as $kategori)
                <option value="{{ $kategori->id_kategori }}"
                    {{ $menu->id_kategori == $kategori->id_kategori ? 'selected' : '' }}>
                    {{ $kategori->nama_kategori }}
                </option>
            @endforeach
        </select>

        <label class="block mb-2 font-medium">Gambar Menu (Opsional)</label>

        {{-- preview image_menu lama --}}
        @if ($menu->image_menu)
            <img src="{{ asset('assets/menu/'.$menu->image_menu) }}"
                 class="object-cover rounded mb-3"
                 style="width: 100px !important; height: 100px !important;">
        @endif

        <input type="file"
               name="image_menu"
               accept="image/*"
               class="w-full border px-4 py-2 rounded mb-4">

        <label class="block mb-2 font-medium">Stok Menu</label>
        <input type="number"
               name="stok_menu"
               value="{{ old('stok_menu', $menu->stok_menu) }}"
               class="w-full border px-4 py-2 rounded mb-4"
               required>

        <button class="bg-[#ff2e6f] hover:bg-[#ff6f93] text-white px-6 py-2 rounded-full">
            Update
        </button>
    </form>

</div>
@endsection
