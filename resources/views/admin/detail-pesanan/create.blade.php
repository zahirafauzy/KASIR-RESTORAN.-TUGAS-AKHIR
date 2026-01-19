@extends('admin.layouts.app')

@section('content')
<div class="max-w-xl bg-white p-6 rounded-xl shadow">

    <h2 class="text-2xl font-bold mb-6">Tambah Item</h2>

    <form action="{{ route('pesanan.item.store', $pesanan->id_pesanan) }}" method="POST">
        @csrf

        <label class="block mb-2 font-medium">Menu</label>
        <select
            name="id_menu"
            class="w-full border px-4 py-2 rounded mb-4"
            required
        >
            <option value="">-- Pilih Menu --</option>
            @foreach ($menus as $menu)
                <option value="{{ $menu->id_menu }}">
                    {{ $menu->nama_menu }} - Rp{{ number_format($menu->harga_menu,0,',','.') }}
                </option>
            @endforeach
        </select>

        <label class="block mb-2 font-medium">Jumlah</label>
        <input
            type="number"
            name="jumlah"
            min="1"
            class="w-full border px-4 py-2 rounded mb-4"
            required
        >

        <div class="flex justify-end gap-3">
            <a href="{{ route('pesanan.detail_pesanan_admin', $pesanan->id_pesanan) }}"
                class="px-4 py-2 rounded-full bg-gray-500 text-white">
                Kembali
            </a>

            <button
                type="submit"
                class="px-6 py-2 rounded-full text-white"
                style="background-color:#2563eb;">
                Tambah Item
            </button>
        </div>
    </form>
</div>
@endsection


