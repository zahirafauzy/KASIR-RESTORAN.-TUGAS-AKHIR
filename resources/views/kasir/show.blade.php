@extends('layouts.app')
@section('content')
<div class='card'>
<h3>Detail Pesanan #{{ $pesanan->id_pesanan }}</h3>
<ul>
@foreach($pesanan->detail as $d)
<li>{{ $d->menu->nama_menu }} x {{ $d->jumlah }} = Rp {{ number_format($d->harga_satuan * $d->jumlah,0,',','.') }}</li>
@endforeach
</ul>
<p>Total: Rp {{ number_format($pesanan->total_harga,0,',','.') }}</p>
</div>
@endsection