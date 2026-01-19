@extends('admin.layouts.app')

@section('content')
<div class="bg-white p-6 rounded-xl shadow max-w-xl">

    <form action="{{ route('user.update', $user->id_user) }}" method="POST">
        @csrf
        @method('PUT')

        <label class="block mb-2 font-medium">Username</label>
        <input
            type="text"
            name="username"
            value="{{ old('username', $user->username) }}"
            class="w-full border px-4 py-2 rounded mb-4"
            required
        >

        <label class="block mb-2 font-medium">
            Password
            <span class="text-sm text-gray-500">(Kosongkan jika tidak diubah)</span>
        </label>
        <input
            type="text"
            name="password"
            class="w-full border px-4 py-2 rounded mb-4"
        >

        <label class="block mb-2 font-medium">Role</label>
        <select
            name="role"
            class="w-full border px-4 py-2 rounded mb-4"
            required
        >
            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>
                Admin
            </option>
            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>
                User
            </option>
        </select>

        <button class="bg-[#ff2e6f] hover:bg-[#ff6f93] text-white px-6 py-2 rounded-full">
            Update
        </button>
    </form>

</div>
@endsection
