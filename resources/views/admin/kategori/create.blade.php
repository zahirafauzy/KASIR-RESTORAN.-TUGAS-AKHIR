@extends('admin.layouts.app')

@section('content')
<div class="bg-white p-6 rounded-xl shadow max-w-xl">
    <form action="{{ route('kategori.store') }}" method="POST">
        @csrf
        <label class="block mb-2 font-medium">Nama Kategori</label>
        <input type="text" name="nama_kategori" class="w-full border px-4 py-2 rounded mb-4" required>

        <button class="bg-[#ff2e6f] hover:bg-[#ff6f93] text-white px-6 py-2 rounded-full">Simpan</button>
    </form>
</div>
@endsection
