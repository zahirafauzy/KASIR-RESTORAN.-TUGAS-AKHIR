<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Menu;
use App\Models\Cart;
use App\Models\Payment;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller
{
    public function index(Request $request)
    {
        $kategoris = Kategori::all();

        $menus = Menu::with('kategori')
        ->when($request->kategori, function ($query) use ($request) {
            $query->where('id_kategori', $request->kategori);
        })->get();

        $carts = Cart::with('menu')->get();
        $totalInCart = $carts->sum(function ($cart) {
            return $cart->menu->harga_menu * $cart->jumlah;
        });


        return view('kasir.index', [
            'menus' => $menus,
            'kategoris' => $kategoris,
            'carts' => $carts,
            'totalInCart' => $totalInCart,
        ]);
    }


    public function transactionhistory(Request $request)
    {
        $bulan   = $request->bulan;
        $tanggal = $request->tanggal;

        // =========================
        // QUERY PESANAN (HISTORY)
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
        // DATA REPORT
        // =========================
        $totalOmset = $pesanans->sum('total_bayar');
        $jumlahTransaksi = $pesanans->count();
        $totalItemTerjual = $pesanans->sum('jumlah_item');

        // =========================
        // MENU TERLARIS
        // =========================
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

        return view('kasir.transaction-history', [
            'pesanans' => $pesanans,
            'report' => [
                'total_omset' => $totalOmset,
                'jumlah_transaksi' => $jumlahTransaksi,
                'total_item' => $totalItemTerjual,
                'menu_terlaris' => $menuTerlaris,
            ]
        ]);
    }


    
    public function store(Request $request)
    {
        $request->validate([
            'id_menu' => 'required|exists:menus,id_menu',
        ]);

        DB::transaction(function () use ($request) {

            $menu = Menu::where('id_menu', $request->id_menu)
                        ->lockForUpdate()
                        ->firstOrFail();

            if ($menu->stok_menu <= 0) {
                abort(400, 'Stok menu habis');
            }

            $cart = Cart::where('id_menu', $menu->id_menu)->first();

            if ($cart) {
                $cart->increment('jumlah');
            } else {
                Cart::create([
                    'id_menu' => $menu->id_menu,
                    'jumlah' => 1,
                ]);
            }

            $menu->decrement('stok_menu');
        });
        return redirect()->back()->with('success', 'Menu ditambahkan ke cart');
    }

    public function kurangiItem($id_menu)
    {
        DB::transaction(function () use ($id_menu) {

            $cart = Cart::where('id_menu', $id_menu)->firstOrFail();

            $menu = Menu::where('id_menu', $id_menu)
                        ->lockForUpdate()
                        ->firstOrFail();

            if ($cart->jumlah > 1) {
                $cart->decrement('jumlah');
            } else {
                $cart->delete();
            }

            $menu->increment('stok_menu');
        });

        return redirect()->back()->with('success', 'Item dikurangi dari cart');
    }

    private function hitungTotal($keranjang) {
        $total = 0;
        foreach ($keranjang as $item) {
            $total += $item['harga'] * $item['qty'];
        }
        return $total;
    }

}