@extends('admin.layouts.app')

@section('content')
<div class="bg-white p-6 rounded-xl shadow max-w-xl">
    <form action="{{ route('user.store') }}" method="POST">
        @csrf

        <label class="block mb-2 font-medium">Username</label>
        <input
            type="text"
            name="username"
            class="w-full border px-4 py-2 rounded mb-4"
            required
        >

        <label class="block mb-2 font-medium">Password</label>
        <input
            type="text"
            name="password"
            class="w-full border px-4 py-2 rounded mb-4"
            required
        >

        <label class="block mb-2 font-medium">Role</label>
        <select
            name="role"
            class="w-full border px-4 py-2 rounded mb-4"
            required
        >
            <option value="">-- Pilih Role --</option>
            <option value="admin">Admin</option>
            <option value="user">Kasir</option>
        </select>

        <button class="bg-[#ff2e6f] hover:bg-[#ff6f93] text-white px-6 py-2 rounded-full">
            Simpan
        </button>
    </form>
</div>
@endsection
