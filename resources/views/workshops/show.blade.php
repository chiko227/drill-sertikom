@extends('layouts.app')
@section('title',$workshop->title)
@section('content')
<a class="muted" href="{{ route('workshops.index') }}">← Kembali ke daftar</a>
<div class="panel" style="margin-top:15px"><span class="tag">{{ $workshop->date->translatedFormat('l, d F Y') }}</span><h1 style="color:var(--navy);font-size:32px;line-height:1.2">{{ $workshop->title }}</h1><p class="muted">{{ $workshop->description }}</p><hr style="border:0;border-top:1px solid var(--line);margin:22px 0"><div class="two"><div><div class="muted">Waktu</div><strong>{{ substr($workshop->start_time,0,5) }}–{{ substr($workshop->end_time,0,5) }} WIB</strong></div><div><div class="muted">Lokasi</div><strong>{{ $workshop->location }}</strong></div><div><div class="muted">Biaya pendaftaran</div><strong class="price">Rp{{ number_format($workshop->price,0,',','.') }}</strong></div><div><div class="muted">Kuota</div><strong>{{ max(0,$workshop->available_quota) }} tempat tersedia</strong></div></div><hr style="border:0;border-top:1px solid var(--line);margin:22px 0">
@auth @if($registration)<p>Status pendaftaran: <span class="tag {{ $registration->payment_status==='paid'?'':'pending' }}">{{ ucfirst($registration->payment_status) }}</span></p>@if($registration->payment_status==='paid')<a class="btn teal" href="{{ route('tickets.show',$registration) }}">Lihat tiket</a>@else<a class="btn" href="{{ route('payments.show',$registration) }}">Lanjutkan pembayaran</a>@endif
@else<form method="POST" action="{{ route('registrations.store',$workshop) }}">@csrf<button class="btn teal" {{ $workshop->available_quota<1?'disabled':'' }}>Daftar workshop</button></form>@endif
@else<a class="btn" href="{{ route('login') }}">Masuk untuk mendaftar</a>@endauth
</div>
@endsection
