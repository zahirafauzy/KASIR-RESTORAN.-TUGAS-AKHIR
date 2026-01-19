@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Kategori</h2>

        <form action="{{ route('kategori.update', $kategori->id_kategori) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Nama Kategori</label>
                <input 
                    type="text" 
                    name="nama_kategori" 
                    value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    required>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('kategori.index') }}" 
                    class="px-4 py-2 rounded-lg bg-gray-500 hover:bg-gray-600 text-white">
                    Kembali
                </a>

                <button type="submit" 
                    class="bg-green-500 text-white ms-3 px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white font-semibold">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
