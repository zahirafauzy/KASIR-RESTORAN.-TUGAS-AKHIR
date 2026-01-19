<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Kategori;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $bulan   = $request->bulan;
        $tanggal = $request->tanggal;

        // =========================
        // QUERY PESANAN
        // =========================
        $pesanansQuery = Pesanan::query();

        if ($bulan) {
            $pesanansQuery->whereMonth('waktu', $bulan);
        }

        if ($tanggal) {
            $pesanansQuery->whereDay('waktu', $tanggal);
        }

        $pesanans = $pesanansQuery
            ->orderBy('waktu', 'desc')
            ->get();

        // =========================
        // REPORT
        // =========================
        $totalOmset = $pesanans->sum('total_bayar');
        $jumlahTransaksi = $pesanans->count();
        $totalItemTerjual = $pesanans->sum('jumlah_item');

        $menuTerlaris = DetailPesanan::select(
                'menus.nama_menu',
                DB::raw('SUM(detail_pesanans.jumlah) as total_terjual')
            )
            ->join('menus', 'menus.id_menu', '=', 'detail_pesanans.id_menu')
            ->join('pesanans', 'pesanans.id_pesanan', '=', 'detail_pesanans.id_pesanan')
            ->when($bulan, fn ($q) => $q->whereMonth('pesanans.waktu', $bulan))
            ->when($tanggal, fn ($q) => $q->whereDay('pesanans.waktu', $tanggal))
            ->groupBy('menus.nama_menu')
            ->orderByDesc('total_terjual')
            ->first();

        $report = [
            'total_omset' => $totalOmset,
            'jumlah_transaksi' => $jumlahTransaksi,
            'total_item' => $totalItemTerjual,
            'menu_terlaris' => $menuTerlaris,
        ];

        return view('admin.pesanan.index', compact('pesanans', 'report'));
    }

    public function detail_pesanan_admin($id_pesanan)
    {
        $pesanan = Pesanan::with([
            'detailPesanans.menu'
        ])->findOrFail($id_pesanan);

        return view('admin.detail-pesanan.index', compact('pesanan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_customer' => 'required|string',
            'no_meja'       => 'required|numeric',
            'uang_bayar'    => 'required|numeric|min:0',
            'catatan'       => 'nullable|string',
        ]);


        $carts = Cart::with('menu')->get();

        if ($carts->isEmpty()) {
            return back()->with('error', 'Cart masih kosong');
        }

        // ⬅️ SIAPKAN VARIABEL DI LUAR
        $pesanan = null;

        DB::transaction(function () use ($request, $carts, &$pesanan) {

            $jumlahItem = $carts->sum('jumlah');

            $totalBayar = $carts->sum(function ($cart) {
                return $cart->menu->harga_menu * $cart->jumlah;
            });

            $uangKembalian = $request->uang_bayar - $totalBayar;

            if ($uangKembalian < 0) {
                throw new \Exception('Uang bayar kurang');
            }

            // ✅ SIMPAN PESANAN
            $pesanan = Pesanan::create([
                'nama_customer'  => $request->nama_customer,
                'catatan'        => $request->catatan,
                'no_meja'        => $request->no_meja,
                'jumlah_item'    => $jumlahItem,
                'total_bayar'    => $totalBayar,
                'uang_bayar'     => $request->uang_bayar,
                'uang_kembalian' => $uangKembalian,
                'waktu'          => now(),
            ]);


            // ✅ SIMPAN DETAIL
            foreach ($carts as $cart) {
                DetailPesanan::create([
                    'id_pesanan' => $pesanan->id_pesanan,
                    'id_menu'    => $cart->menu->id_menu,
                    'jumlah'     => $cart->jumlah,
                ]);
            }

            // ✅ KOSONGKAN CART
            Cart::query()->delete();
        });

        // 🎯 LANGSUNG KE STRUK
        return redirect()
            ->route('transactionhistory.struk', $pesanan->id_pesanan)
            ->with('success', 'Pesanan berhasil dibuat');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit(Pesanan $pesanan)
    {
        return view('admin.pesanan.edit', compact('pesanan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pesanan $pesanan)
    {
        $request->validate([
            'nama_customer' => 'required|string',
            'no_meja'       => 'required|numeric',
        ]);

        $pesanan->update([
            'nama_customer' => $request->nama_customer,
            'no_meja'       => $request->no_meja,
        ]);

        return redirect()
            ->route('pesanan.index')
            ->with('success', 'Pesanan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pesanan $pesanan)
    {
        DB::transaction(function () use ($pesanan) {

            // 🔥 hapus detail pesanan dulu
            $pesanan->detailPesanans()->delete();

            // 🔥 hapus pesanan utama
            $pesanan->delete();
        });

        return redirect()
            ->route('pesanan.index')
            ->with('success', 'Pesanan berhasil dihapus');
    }





    public function editItem($id_detail_pesanan)
    {
        $detail = DetailPesanan::with('menu', 'pesanan')->findOrFail($id_detail_pesanan);
        $menus = Menu::all();

        return view('admin.detail-pesanan.edit', compact('detail', 'menus'));
    }

    public function updateItem(Request $request, $id_detail_pesanan)
    {
        $request->validate([
            'id_menu' => 'required|exists:menus,id_menu',
            'jumlah'  => 'required|integer|min:1',
        ]);

        // 🔥 ambil detail di luar transaction
        $detail = DetailPesanan::with('pesanan')->findOrFail($id_detail_pesanan);
        $pesanan = $detail->pesanan;

        DB::transaction(function () use ($request, $detail, $pesanan) {

            // update detail item
            $detail->update([
                'id_menu' => $request->id_menu,
                'jumlah'  => $request->jumlah,
            ]);

            // hitung ulang jumlah item
            $jumlahItem = $pesanan->detailPesanans()->sum('jumlah');

            // hitung ulang total bayar
            $totalBayar = $pesanan->detailPesanans()
                ->join('menus', 'detail_pesanans.id_menu', '=', 'menus.id_menu')
                ->selectRaw('SUM(detail_pesanans.jumlah * menus.harga_menu) as total')
                ->value('total');

            $pesanan->update([
                'jumlah_item' => $jumlahItem,
                'total_bayar' => $totalBayar,
            ]);
        });

        // ✅ sekarang aman
        return redirect()
            ->route('pesanan.detail_pesanan_admin', $detail->id_pesanan)
            ->with('success', 'Item berhasil diperbarui');
    }

    public function createItem($id_pesanan)
    {
        $pesanan = Pesanan::findOrFail($id_pesanan);
        $menus = Menu::orderBy('nama_menu')->get();

        return view('admin.detail-pesanan.create', compact('pesanan', 'menus'));
    }

    public function storeItem(Request $request, $id_pesanan)
    {
        $request->validate([
            'id_menu' => 'required|exists:menus,id_menu',
            'jumlah'  => 'required|integer|min:1',
        ]);

        $pesanan = Pesanan::findOrFail($id_pesanan);

        DB::transaction(function () use ($request, $pesanan) {

            // 1️⃣ simpan detail item
            DetailPesanan::create([
                'id_pesanan' => $pesanan->id_pesanan,
                'id_menu'    => $request->id_menu,
                'jumlah'     => $request->jumlah,
            ]);

            // 2️⃣ hitung ulang jumlah item
            $jumlahItem = $pesanan->detailPesanans()->sum('jumlah');

            // 3️⃣ hitung ulang total bayar
            $totalBayar = $pesanan->detailPesanans()
                ->join('menus', 'detail_pesanans.id_menu', '=', 'menus.id_menu')
                ->selectRaw('SUM(detail_pesanans.jumlah * menus.harga_menu) as total')
                ->value('total');

            // 4️⃣ update pesanan
            $pesanan->update([
                'jumlah_item' => $jumlahItem,
                'total_bayar' => $totalBayar,
            ]);
        });

        return redirect()
            ->route('pesanan.detail_pesanan_admin', $pesanan->id_pesanan)
            ->with('success', 'Item berhasil ditambahkan');
    }




    public function destroyItem(Pesanan $pesanan, DetailPesanan $detailPesanan)
    {
        DB::transaction(function () use ($pesanan, $detailPesanan) {

            // 🔒 pastikan item milik pesanan ini
            if ($detailPesanan->id_pesanan !== $pesanan->id_pesanan) {
                abort(403);
            }

            // 🔥 hapus 1 baris detail_pesanans
            $detailPesanan->delete();

            // 🔄 hitung ulang JUMLAH BARIS item
            $jumlahItem = $pesanan->detailPesanans()->count();

            // 🔄 hitung ulang TOTAL BAYAR
            $totalBayar = $pesanan->detailPesanans->sum(function ($detail) {
                return $detail->menu->harga_menu * $detail->jumlah;
            });

            // 🔥 JIKA SUDAH TIDAK ADA ITEM → HAPUS PESANAN
            if ($jumlahItem === 0) {
                $pesanan->delete();
            } else {
                // 🔄 update pesanan jika masih ada item
                $pesanan->update([
                    'jumlah_item' => $jumlahItem,
                    'total_bayar' => $totalBayar,
                ]);
            }
        });
        return redirect()->route('pesanan.index')->with('success', 'Item pesanan berhasil dihapus');
    }
}