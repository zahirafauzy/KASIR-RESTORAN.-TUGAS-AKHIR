<?php
namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('kategori')
            ->orderBy('created_at','asc')
            ->get();
        return view('admin.menu.index', compact('menus'));
    }

    // MenuController.php

    public function create()
    {
        $title = "Tambah Menu";
        $kategoris = Kategori::all();
        return view('admin.menu.create', compact('title', 'kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_menu'   => 'required|string',
            'stok_menu'  => 'required|numeric',
            'harga_menu'  => 'required|numeric',
            'id_kategori' => 'required|exists:kategoris,id_kategori',
            'image_menu'      => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // 🔹 normalisasi nama menu → aman untuk nama file
        $file     = $request->file('image_menu');

        // 🔹 ambil ekstensi asli
        $ext = $file->getClientOriginalExtension();

        // 🔹 hasil akhir nama file
        $namaFile = Str::slug($request->nama_menu)
                        . '-' . time()
                        . '.' . $file->getClientOriginalExtension();

        // 🔹 lokasi tujuan
        $folder = public_path('assets/menu');

        if (!file_exists($folder)) {
            mkdir($folder, 0755, true);
        }

        // 🔹 pindahkan file
        $file->move($folder, $namaFile);

        // 🔹 simpan ke database (HANYA nama file)
        Menu::create([
            'nama_menu'   => $request->nama_menu,
            'harga_menu'  => $request->harga_menu,
            'stok_menu'  => $request->stok_menu,
            'id_kategori' => $request->id_kategori,
            'image_menu'      => $namaFile,
        ]);

        return redirect()->route('menu.index')
                        ->with('success', 'Menu berhasil ditambahkan');
    }

    public function edit(Menu $menu)
    {
        $kategoris = Kategori::all();
        return view('admin.menu.edit', compact('menu', 'kategoris'));
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'nama_menu'   => 'required|string',
            'harga_menu'  => 'required|numeric',
            'id_kategori' => 'required|exists:kategoris,id_kategori',
            'stok_menu'   => 'required|numeric',
            'image_menu'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // update field utama
        $menu->update([
            'nama_menu'   => $request->nama_menu,
            'harga_menu'  => $request->harga_menu,
            'id_kategori' => $request->id_kategori,
            'stok_menu'   => $request->stok_menu,
        ]);

        // jika upload image_menu baru
        if ($request->hasFile('image_menu')) {

            // 🔥 HAPUS GAMBAR LAMA (ANTI FILE YATIM)
            if ($menu->image_menu) {
                $oldPath = public_path('assets/menu/' . $menu->image_menu);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            // simpan image_menu baru
            $file = $request->file('image_menu');
            $namaFile = Str::slug($request->nama_menu)
                        . '-' . time()
                        . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('assets/menu'), $namaFile);

            // update DB
            $menu->update([
                'image_menu' => $namaFile
            ]);
        }

        return redirect()->route('menu.index')
                        ->with('success', 'Menu berhasil diperbarui');
    }

    public function destroy(Menu $menu)
    {
        // 1️⃣ Hapus file gambar jika ada
        if ($menu->image_menu) {
            $path = public_path('assets/menu/' . $menu->image_menu);

            if (File::exists($path)) {
                File::delete($path);
            }
        }

        // 2️⃣ Hapus data menu dari database
        $menu->delete();

        return redirect()->route('menu.index')
                        ->with('success', 'Menu berhasil dihapus');
    }
}
