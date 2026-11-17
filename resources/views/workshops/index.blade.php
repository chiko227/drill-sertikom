@extends('layouts.app')
@section('title','Daftar Workshop')
@section('content')
<section class="hero"><div class="eyebrow">Program workshop sekolah</div><h1>Kembangkan kemampuan digital melalui pengalaman langsung.</h1><p>Pilih workshop teknologi informasi, lakukan pendaftaran, dan dapatkan tiket digital setelah pembayaran berhasil diverifikasi.</p></section>
<div class="sectionhead"><div><div class="eyebrow">Jadwal pilihan</div><h2>Workshop tersedia</h2></div><form method="GET" style="display:flex;gap:8px;width:min(360px,100%)"><input class="search" name="q" value="{{ request('q') }}" placeholder="Cari workshop..."><button class="btn">Cari</button></form></div>
<div class="grid">@forelse($workshops as $workshop)<article class="card"><span class="tag">{{ $workshop->date->translatedFormat('d M Y') }}</span><h3>{{ $workshop->title }}</h3><p>{{ Str::limit($workshop->description,115) }}</p><div class="meta">{{ substr($workshop->start_time,0,5) }}–{{ substr($workshop->end_time,0,5) }} · {{ $workshop->location }}</div><div class="meta">Sisa kuota: {{ max(0,$workshop->quota-$workshop->paid_count) }} peserta</div><div class="sectionhead"><strong class="price">Rp{{ number_format($workshop->price,0,',','.') }}</strong><a class="btn" href="{{ route('workshops.show',$workshop) }}">Lihat detail</a></div></article>@empty<div class="panel">Workshop belum tersedia.</div>@endforelse</div>
<div class="pagination">{{ $workshops->links() }}</div>
@endsection
