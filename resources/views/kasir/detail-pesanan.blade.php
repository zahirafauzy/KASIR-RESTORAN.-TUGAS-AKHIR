@extends('layouts.app')

@section('content')
<div class="flex justify-center mb-4">
    <h1 class="text-2xl font-bold  text-center" style="margin-bottom: 15px;">Detail Transaksi</h1>
</div>

<table class="w-full bg-white rounded-lg shadow overflow-hidden">
    <thead>
        <tr class="bg-gray-100 text-left">
            <th class="p-3 w-12 text-center">
                No.
                <br>
                Transaksi
            </th>
            <th class="p-3 w-12 text-center">
                Nama
                <br>
                Customer
            </th>
            <th class="p-3 w-12 text-center">
                No.
                <br>
                Meja
            </th>
            <th class="p-3 w-12 text-center">
                Jumlah
                <br>
                Item
            </th>
            <th class="p-3 w-12 text-center">Catatan</th>
            <th class="p-3 w-12 text-center">Total</th>
            <th class="p-3 w-12 text-center">Uang Bayar</th>
            <th class="p-3 w-12 text-center">Uang Kembalian</th>
            <th class="p-3 w-12 text-center">Waktu</th>
        </tr>
    </thead>
    <tbody>
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3 text-center">{{ $pesanan->id_pesanan }}</td>
                <td class="p-3 text-center">
                    {{ $pesanan->nama_customer }}
                </td>
                <td class="p-3 text-center">
                    {{ $pesanan->no_meja }}
                </td>
                <td class="p-3 text-center">{{ $pesanan->jumlah_item }}</td>
                <td class="p-3 text-center">
                    {{ $pesanan->catatan ?? '-' }}
                </td>
                <td class="p-3 text-center">
                    Rp{{ number_format($pesanan->total_bayar, 0, ',', '.') }}
                </td>
                <td class="p-3 text-center">
                    Rp{{ number_format($pesanan->uang_bayar, 0, ',', '.') }}
                </td>
                <td class="p-3 text-center">
                    Rp{{ number_format($pesanan->uang_kembalian, 0, ',', '.') }}
                </td>
                <td class="p-3 text-center">
                    {{ $pesanan->waktu->format('H : i : s') }}
                    <br>
                    {{ $pesanan->waktu->format('d - m - Y') }}
                </td>
            </tr>
    </tbody>
</table>

<h1 class="text-xl font-bold mb-4" style="margin-top: 40px">Detail Item:</h1>
<table class="w-full bg-white rounded shadow">
    <thead>
        <tr class="bg-gray-100">
            <th class="p-3 text-center">No. Item</th>
            <th class="p-3 text-center">Menu</th>
            <th class="p-3 text-center">Harga</th>
            <th class="p-3 text-center">Jumlah</th>
            <th class="p-3 text-center">Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pesanan->detailPesanans as $index => $detail)
            <tr class="border-b text-center">
                <td class="p-3">{{ $index + 1 }}</td>
                <td class="p-3">{{ $detail->menu->nama_menu }}</td>
                <td class="p-3">
                    Rp{{ number_format($detail->menu->harga_menu, 0, ',', '.') }}
                </td>
                <td class="p-3">{{ $detail->jumlah }}</td>
                <td class="p-3">
                    Rp{{ number_format(
                        $detail->menu->harga_menu * $detail->jumlah,
                        0, ',', '.'
                    ) }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<a href="{{ route('transactionhistory.struk', $pesanan->id_pesanan) }}"
    target="_blank"
    class="text-white flex items-center justify-center bg-[#1A2238] hover:bg-[#ff6f93] rounded-full"
    style="width: 200px; height: 40px; margin-top: 20px !important;">
    Cetak Struk
</a>

@endsection
