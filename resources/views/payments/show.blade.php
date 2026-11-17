@extends('layouts.app') @section('title','Pembayaran') @section('content')
<div class="panel" style="max-width:700px;margin:20px auto"><div class="eyebrow">Ringkasan transaksi</div><h2 style="color:var(--navy)">Pembayaran workshop</h2><h3>{{ $registration->workshop->title }}</h3><p class="muted">Peserta: {{ $registration->user->name }}</p><p class="muted">Kode pendaftaran: {{ $registration->ticket_code }}</p><h2 class="price">Rp{{ number_format($registration->workshop->price,0,',','.') }}</h2><p>Status: <span class="tag pending">{{ ucfirst($registration->payment_status) }}</span></p>
<p class="muted">Pembayaran dilakukan melalui Midtrans Sandbox. Tiket digital akan tersedia setelah status pembayaran terverifikasi.</p>
<form method="POST" action="{{ route('payments.checkout',$registration) }}">@csrf<button class="btn teal">Bayar melalui Midtrans Sandbox</button></form>
@if(app()->environment('local'))<hr style="border:0;border-top:1px solid var(--line);margin:22px 0"><p class="muted">Mode pengembangan lokal: gunakan simulasi ini untuk menguji alur tiket tanpa transaksi sungguhan.</p><form method="POST" action="{{ route('payments.simulate',$registration) }}">@csrf<button class="btn secondary">Simulasikan pembayaran berhasil</button></form>@endif
</div>
@endsection
