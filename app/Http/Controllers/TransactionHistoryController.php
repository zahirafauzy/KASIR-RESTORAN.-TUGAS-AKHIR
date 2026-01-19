<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;

class TransactionHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id_pesanan)
    {
        $pesanan = Pesanan::with([
            'detailPesanans.menu'
        ])->findOrFail($id_pesanan);

        return view('kasir.detail-pesanan', compact('pesanan'));
    }

    public function struk($id)
    {
        $pesanan = Pesanan::with('detailPesanans.menu')->findOrFail($id);
        return view('kasir.cetak-struk', compact('pesanan'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
