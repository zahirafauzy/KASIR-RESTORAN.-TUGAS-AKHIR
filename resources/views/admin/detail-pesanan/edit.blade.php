@extends('admin.layouts.app')

@section('content')
<div class="max-w-xl bg-white p-6 rounded-xl shadow">

    <h2 class="text-2xl font-bold mb-6">Edit Item Pesanan</h2>

    <form action="{{ route('pesanan.detail.update', $detail->id_detail_pesanan) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Menu --}}
        <label class="block mb-2 font-medium">Menu</label>
        <select name="id_menu" class="w-full border px-4 py-2 rounded mb-4" required>
            @foreach ($menus as $menu)
                <option value="{{ $menu->id_menu }}"
                    {{ $detail->id_menu == $menu->id_menu ? 'selected' : '' }}>
                    {{ $menu->nama_menu }} — Rp{{ number_format($menu->harga_menu, 0, ',', '.') }}
                </option>
            @endforeach
        </select>

        {{-- Jumlah --}}
        <label class="block mb-2 font-medium">Jumlah</label>
        <input
            type="number"
            name="jumlah"
            min="1"
            value="{{ old('jumlah', $detail->jumlah) }}"
            class="w-full border px-4 py-2 rounded mb-6"
            required
        >

        <div class="flex justify-end gap-3">
            <a href="{{ route('pesanan.detail_pesanan_admin', $detail->id_pesanan) }}"
                class="px-4 py-2 rounded-full bg-gray-500 text-white">
                Batal
            </a>

            <button
                type="submit"
                class="px-6 py-2 rounded-full text-white"
                style="background-color:#2563eb;">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection