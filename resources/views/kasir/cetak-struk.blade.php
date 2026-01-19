<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Pesanan</title>

    <style>
        body {
            font-family: monospace;
            margin: 0;
            padding: 0;
        }

        .struk {
            width: 80mm;
            margin: auto;
            padding: 5mm;
        }

        .center {
            text-align: center;
        }

        hr {
            border: none;
            border-top: 1px dashed #000;
            margin: 8px 0;
        }

        table {
            width: 100%;
            font-size: 12px;
        }

        td {
            vertical-align: top;
        }

        .right {
            text-align: right;
        }

        /* 🔥 PENGATURAN KERTAS PRINT */
        @media print {
            @page {
                size: 80mm auto; /* ukuran kertas */
                margin: 0;
            }

            body {
                margin: 0;
            }
            button {
                display: none;
            }
        }
    </style>

</head>
<body>

<div class="struk">
    <div class="center">
        <strong>WARUNG MAKAN</strong><br>
        Jl. Pulorejo No. 123<br>
        -----------------------
    </div>

    <p>
        No Transaksi : {{ $pesanan->id_pesanan }}<br>
        Tanggal      : {{ $pesanan->waktu->format('d-m-Y') }}<br>
        Jam          : {{ $pesanan->waktu->format('H:i:s') }}<br>
        Meja         : {{ $pesanan->no_meja }}<br>
        Customer     : {{ $pesanan->nama_customer }}<br>
        Catatan      : {{ $pesanan->catatan }}
    </p>

    <hr>

    <table>
        @foreach ($pesanan->detailPesanans as $detail)
        <tr>
            <td colspan="2">{{ $detail->menu->nama_menu }}</td>
        </tr>
        <tr>
            <td>{{ $detail->jumlah }} x {{ number_format($detail->menu->harga_menu, 0, ',', '.') }}</td>
            <td class="right">
                {{ number_format($detail->menu->harga_menu * $detail->jumlah, 0, ',', '.') }}
            </td>
        </tr>
        @endforeach
    </table>

    <hr>

    <table>
        <tr>
            <td>Total</td>
            <td class="right">{{ number_format($pesanan->total_bayar, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Bayar</td>
            <td class="right">{{ number_format($pesanan->uang_bayar, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Kembali</td>
            <td class="right">{{ number_format($pesanan->uang_kembalian, 0, ',', '.') }}</td>
        </tr>
    </table>

    <hr>

    <div class="center">
        Terima Kasih 🙏<br>
        Selamat Menikmati
    </div>
</div>


<script>
    window.onload = function () {
        window.print();

        setTimeout(function () {
            window.location.href = "{{ route('kasir.transactionhistory') }}";
        }, 3000); // 3 detik
    };
</script>


</body>
</html>
