@extends('admin.layouts.app')

@section('content')
<form action="{{ route('admin.pesanan.index') }}" method="GET">
    <table class="w-full bg-white rounded-lg shadow overflow-hidden mb-6">
        <tbody>
            <tr class="border-b">
                <td style="padding-left:30px">
                    <div class="font-bold mt-2 mb-1">Bulan</div>
                    <select name="bulan" class="w-full border px-4 py-2 rounded mb-4">
                        <option value="">-- Semua Bulan --</option>
                        @foreach ([
                            1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
                            5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
                            9=>'September',10=>'Oktober',11=>'November',12=>'Desember'
                        ] as $key => $bulan)
                            <option value="{{ $key }}"
                                {{ request('bulan') == $key ? 'selected' : '' }}>
                                {{ $bulan }}
                            </option>
                        @endforeach
                    </select>
                </td>

                <td style="padding-left:15px">
                    <div class="font-bold mt-2 mb-1">Tanggal</div>
                    <input
                        type="number"
                        name="tanggal"
                        min="1"
                        max="31"
                        value="{{ request('tanggal') }}"
                        class="w-full border px-4 py-2 rounded mb-4"
                        placeholder="1 - 31"
                    >
                </td>

                <td style="width:200px">
                    <div class="flex flex-col items-center gap-2 mt-8">
                        <a href="{{ route('admin.pesanan.index') }}"
                            class="text-white bg-[#1A2238] hover:bg-[#ff6f93] px-6 py-2 rounded-full">
                            Reset Filter
                        </a>

                        <button
                            type="submit"
                            class="bg-[#ff2e6f] hover:bg-[#ff6f93] text-white px-6 py-2 rounded-full">
                            Apply Filter
                        </button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</form>

<h1 class="text-2xl font-bold" style="margin-top: 30px; margin-bottom: 15px">Report</h1>
<table class="w-full bg-white rounded-lg shadow overflow-hidden">
    <thead>
        <tr class="bg-gray-100 text-left">
            <th class="p-3 w-12 text-center">Total Omset</th>
            <th class="p-3 w-12 text-center">Jumlah Transaksi</th>
            <th class="p-3 w-12 text-center">Menu Terlaris</th>
            <th class="p-3 w-12 text-center">Total Item Terjual</th>
        </tr>
    </thead>
    <tbody>
        <tr class="border-b hover:bg-gray-50">
            <td class="p-3 text-center">
                Rp{{ number_format($report['total_omset'], 0, ',', '.') }}
            </td>
            <td class="p-3 text-center">
                {{ $report['jumlah_transaksi'] }}
            </td>
            <td class="p-3 text-center">
                {{ $report['menu_terlaris']->nama_menu ?? '-' }}
            </td>
            <td class="p-3 text-center">
                {{ $report['total_item'] }}
            </td>
        </tr>
    </tbody>

</table>
<h1 class="text-2xl font-bold mt-4" style="margin-bottom: 15px">Daftar Pesanan</h1>
<table class="w-full bg-white rounded-lg shadow overflow-hidden">
    <thead>
        <tr class="bg-gray-100 text-left">
            <th class="p-3 w-12 text-center">
                No.
                <br>
                Transaksi
            </th>
            <th class="p-3 w-12 text-center">
                Identitas
                <br>
                Customer
            </th>
            <th class="p-3 w-12 text-center">
                Jumlah
                <br>
                Item
            </th>
            <th class="p-3 w-12 text-center">Transaksi Keuangan</th>
            <th class="p-3 w-12 text-center">Waktu</th>
            <th class="p-3 w-12 text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($pesanans as $index => $pesanan)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3 text-center">{{ $pesanan->id_pesanan }}</td>
                <td class="p-3 text-center">
                    Nama : {{ $pesanan->nama_customer }}
                    <br>
                    No. Meja : {{ $pesanan->no_meja }}
                </td>
                <td class="p-3 text-center">{{ $pesanan->jumlah_item }}</td>
                <td class="p-3 text-center">
                    Total: Rp{{ number_format($pesanan->total_bayar, 0, ',', '.') }}
                    <br>
                    Uang Bayar: Rp{{ number_format($pesanan->uang_bayar, 0, ',', '.') }}
                    <br>
                    Kembalian: Rp{{ number_format($pesanan->uang_kembalian, 0, ',', '.') }}
                </td>
                <td class="p-3 text-center">
                    {{ $pesanan->waktu->format('H : i : s') }}
                    <br>
                    {{ $pesanan->waktu->format('d-m-Y') }}
                </td>
                <td class="p-3 flex flex-col items-center justify-center gap-2 text-sm">
                    <a href="{{ route('pesanan.detail_pesanan_admin', $pesanan->id_pesanan) }}"
                        class="text-white flex items-center justify-center bg-[#1A2238] rounded-full"
                        style="width: 180px; height: 40px;">
                        Cek Detail Pesanan
                    </a>
                    <a href="{{ route('pesanan.edit', $pesanan->id_pesanan) }}"
                        class="text-white flex items-center justify-center rounded-full"
                        style="width:180px;height:40px;background-color:#2563eb;">
                        Edit Pesanan
                    </a>
                    <form action="{{ route('pesanan.destroy', $pesanan->id_pesanan) }}"
                        method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus pesanan ini?')">
                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="text-white flex items-center justify-center bg-red-600 hover:bg-red-900 rounded-full"
                            style="width: 180px; height: 40px;">
                            Hapus Pesanan
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="border p-4 text-center text-gray-500">
                    Belum ada transaksi
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
