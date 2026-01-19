@extends('layouts.app')

@section('content')
<div class="flex gap-6">

  <aside class="w-1/5 bg-[#ff557c] text-white rounded-lg p-4 h-[80vh] overflow-y-auto shadow-lg">
    <h3 class="text-xl font-bold mb-4 border-b border-white/50 pb-2">Kategori Menu</h3>
    <ul>
      {{-- Link "Semua Kategori" --}}
      <li class="mb-2">
          <a href="{{ route('kasir.index') }}"
             class="block btn-accent text-left  px-3 py-1 rounded transition
                    {{ !request('kategori') ? 'bg-white text-[#ff557c]' : '' }}">
             Semua
          </a>
      </li>

      @forelse($kategoris as $kategori)
        <li class="mb-2">
          {{-- Pastikan Primary Key Kategori adalah 'id_kategori' atau 'id' --}}
          <a href="{{ route('kasir.index', ['kategori' => $kategori->id_kategori ?? $kategori->id]) }}"
             class="block btn-accent text-left  px-3 py-1 rounded transition
             {{ request('kategori') == ($kategori->id_kategori ?? $kategori->id) ? 'bg-white text-[#ff557c] font-semibold' : '' }}">
             {{ $kategori->nama_kategori }}
          </a>
        </li>
      @empty
        <li class="text-sm text-white/80">Tidak ada kategori.</li>
      @endforelse
    </ul>
  </aside>

  <section class="w-3/5">
    <div class="grid grid-cols-3 gap-4">
      @forelse($menus as $menu)
        <div class="bg-white rounded-xl shadow-lg p-3 hover:shadow-xl transition duration-300">
          <img src="{{ asset('/assets/menu/' . $menu->image_menu) }}" 
              class="h-36 w-full object-cover rounded-lg border border-gray-100" 
              alt="{{ $menu->nama_menu }}">
              
          <h4 class="font-bold text-lg mt-3 text-gray-900 truncate">{{ $menu->nama_menu }}</h4>
          <p class="text-base text-[#ff557c] font-semibold mt-1">
            Stok: {{ number_format($menu->stok_menu, 0, ',', '.') }}
          </p>
          <p class="text-base text-[#ff557c] font-semibold mt-1">
            Rp {{ number_format($menu->harga_menu, 0, ',', '.') }}
          </p>
          

          {{-- FORM ADD TO CART --}}
          <form action="{{ route('kasir.store') }}" method="POST">
              @csrf
              <input type="hidden" name="id_menu" value="{{ $menu->id_menu }}">

              <button type="submit"
                  class="mt-3 text-white px-4 py-2 rounded-lg"
                  style="background-color: #ff2e6f">
                  Tambahkan ke cart
              </button>
          </form>

        </div>
      @empty
        <div class="mt-3 text-center text-gray-500" style="width: 320%;">Tidak ada menu ditemukan di kategori ini.</div>
      @endforelse
    </div>
  </section>

  <aside class="w-1/5">
    @include('kasir.components.cart')
  </aside>

</div>
@endsection