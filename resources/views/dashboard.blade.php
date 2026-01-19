@extends('layouts.main')
@section('content')
<h1 style="font-size:26px; margin-bottom:22px; font-weight:600;">Dashboard</h1>

<div class="cards">
    <div class="card">
        <h3>Total Menu</h3>
        <p>{{ $menus }}</p>
    </div>
    <div class="card">
        <h3>Total Pesanan</h3>
        <p>{{ $orders }}</p>
    </div>
    <div class="card">
        <h3>Total Pendapatan</h3>
        <p>Rp {{ number_format($income) }}</p>
    </div>
</div>
@endsection
