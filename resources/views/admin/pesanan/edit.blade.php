@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow rounded-lg p-6 max-w-xl">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">
            Edit Pesanan
        </h2>

        <form action="{{ route('pesanan.update', $pesanan->id_pesanan) }}"
              method="POST"
              class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-gray-700 font-semibold mb-2">
                    Nama Customer
                </label>
                <input 
                    type="text"
                    name="nama_customer"
                    value="{{ old('nama_customer', $pesanan->nama_customer) }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    required>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">
                    Nomor Meja
                </label>
                <input 
                    type="number"
                    name="no_meja"
                    value="{{ old('no_meja', $pesanan->no_meja) }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    required>
            </div>

            <label class="block text-gray-700 font-semibold mb-2">
                *Jumlah Item, Total, dan Waktu tidak bisa diubah karena berkaitan dengan item pesanan dan ketentuan sistem kami.
            </label>
            <div class="flex justify-end space-x-3">
                <a href="{{ route('pesanan.index') }}"
                   class="px-4 py-2 rounded-lg bg-gray-500 hover:bg-gray-600 text-white">
                    Kembali
                </a>

                <button type="submit"
                    class="px-4 py-2 rounded-lg text-white font-semibold"
                    style="background-color:#2563eb; margin-left: 5px !important;">

                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
