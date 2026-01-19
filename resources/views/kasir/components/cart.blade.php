<div class="bg-white rounded-lg shadow p-4">
  <div class="flex">
    <img src="{{ asset('/assets/flaticon/cart.png') }}" style="width: 20px; height: 20px; margin-top: 5px; margin-right: 5px">
    <h3 class="text-lg mt-1 font-bold text-[#ff2e6f]">Cart</h3>
  </div>
  <div class="mt-1 border-t pt-0"></div>

    @forelse ($carts as $cart)
    <p class="mt-2 mb-0 font-bold">{{ $cart->menu->nama_menu }}</p>
    <div class="flex justify-between mt-0 mb-4">
      <p class="mt-2">Jumlah:</p>
      <p class="mt-2">{{ $cart->jumlah }}</p>
      <div class="flex">
        <form action="{{ route('kasir.kurangiItem', $cart->menu->id_menu) }}" method="POST">
          @csrf
          <button type="submit">
              <img src="{{ asset('/assets/flaticon/minus.png') }}" style="width: 16px; margin-top: 12px; margin-left: 7px;">
          </button>
        </form>

        
        <form action="{{ route('kasir.store') }}" method="POST">
            @csrf
            <input type="hidden" name="id_menu" value="{{ $cart->menu->id_menu }}">
            <button type="submit">
                <img src="{{ asset('/assets/flaticon/plus.png') }}" style="width: 16px; margin-top: 12px; margin-left: 7px;">
            </button>
        </form>
        
      </div>
    </div>
    @empty
      <p class="mt-2 mb-6 text-gray-500">Cart kosong</p>
    @endforelse

  <div class="mt-0 border-t pt-3">

    <div class="flex justify-between">
      <span style="color: rgb(208, 0, 0) !important">Total:</span>
      <strong>Rp {{ number_format($totalInCart, 0, ',', '.') }}</strong>
    </div>
    <div class="mt-3 mb-3 border-t pt-0"></div>

    
        
        
            <!-- Tombol buka modal -->
            <button
              onclick="document.getElementById('modal').style.display='flex'"
              class="btn-accent block text-center mt-2" style="width: 100% !important; cursor:pointer">Pesan
            </button>

            <!-- Modal -->
            <div id="modal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.8); justify-content:center; align-items:center; z-index:999;">
                <!-- Box Modal -->
                <div style="background:white; padding:24px; border-radius:10px; width:60%; position:relative;">
                    <!-- Tombol close -->
                    <button
                        onclick="document.getElementById('modal').style.display='none'"
                        style="position:absolute; top:10px; right:12px; background:none; border:none; font-size:20px; cursor:pointer;">
                        &times;
                    </button>
                    
                    <h1 class="text-xl font-semibold text-gray-800 mb-2">Konfirmasi Pesanan</h1>
                    <div class="mt-1 mb-3 border-t pt-0"></div>
                    <form action="{{ route('pesanan.store') }}" method="POST">
                    @csrf
                      <div class="flex">
                          <div class="w-1/2 bg-slate-200 p-4">
                              <p class="font-semibold mt-2 mb-1">Item Pesanan:</p>
                              @foreach ($carts as $cart)
                              <p>{{ $cart->jumlah }} {{ $cart->menu->nama_menu }}</p>
                              @endforeach
                              <p class="font-semibold mt-2 mb-1">Total Harga: Rp {{ number_format($totalInCart, 0, ',', '.') }}</p>
                          </div>
                          <div class="w-1/4 bg-slate-300 p-4">
                                <div style="margin-top: 0px !important; font-weight: 600;">Nomor Meja:</div>
                                <input type="text" placeholder="" name="no_meja" class="w-full border px-1 py-1 rounded mb-2 placeholder-gray-400" required>

                                <div style="font-weight: 600;">Nama Customer:</div>
                                <input type="text" placeholder="" name="nama_customer" class="w-full border px-1 py-1 rounded mb-2 placeholder-gray-400" required>

                                <div style="font-weight: 600;">Uang Bayar:</div>
                                <input type="number" placeholder="" id="uangBayar" name="uang_bayar" required class="w-full border px-1 py-1 rounded mb-4 placeholder-gray-400" required>
                          </div>
                          <div class="w-1/4 bg-slate-300 p-4">
                                <div style="font-weight: 600;">Catatan:</div>
                                <input type="text" name="catatan" class="w-full border px-1 py-1 rounded mb-2 placeholder-gray-400">
                          </div>
                        </div>
                      <div class="mb-3 border-t pt-0"></div>
                      <p class="font-semibold mt-2 mb-1">Uang Kembalian: <span id="uangKembalian">Rp 0</span></p>
                        <script>
                          const total = {{ $totalInCart }};
                          document.getElementById('uangBayar').addEventListener('input', e => {
                              const bayar = parseInt(e.target.value || 0);
                              const kembali = bayar - total;
                              document.getElementById('uangKembalian').innerText =
                                  'Rp ' + new Intl.NumberFormat('id-ID').format(kembali > 0 ? kembali : 0);
                          });
                        </script>
                      <button class="btn-accent block text-center mt-2" style="width: 100% !important">Buat Pesanan</button>
                    </form>

                    

                    
                </div>
            </div>


     
  </div>
</div>
