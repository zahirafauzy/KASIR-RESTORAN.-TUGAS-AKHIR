<nav class="bg-white shadow p-3 mb-4">
  <div class="container mx-auto flex items-center justify-between">
    <a href="{{ route('kasir.index') }} class="text-2xl font-bold text-[#ff2e6f]">KasirApp</a>
    <div class="flex items-center gap-4">
      <a href="{{ route('menu.index') }}" class="text-sm">Menu</a>
      <a href="{{ route('kategori.index') }}" class="text-sm">Kategori</a>
      @auth
        <form method="POST" action="{{ route('logout') }}">@csrf<button class="ml-4 text-sm text-gray-600">Logout</button></form>
      @else
        <a href="{{ route('login') }}" class="text-sm">Login</a>
      @endauth
    </div>
  </div>
</nav>
