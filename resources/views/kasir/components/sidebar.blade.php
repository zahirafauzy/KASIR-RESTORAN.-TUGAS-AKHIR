<div style="width:220px;">
<div class="card p-4">
<h5 class="text-lg font-bold text-[var(--accent)]">MAKANAN</h5>
<ul class="mt-3 space-y-2">
@foreach($kategoris as $kat)
<li class="cursor-pointer">{{ $kat->nama_kategori }}</li>
@endforeach
</ul>
<hr class="my-4">
<h5 class="text-lg font-bold">MINUMAN</h5>
<!-- optional list -->
</div>
</div>