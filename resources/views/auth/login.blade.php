@extends('layouts.app') @section('title','Masuk') @section('content')
<div class="panel form"><div class="eyebrow">Akun peserta</div><h2 style="color:var(--navy)">Masuk ke WorkshopIT</h2><form method="POST" action="{{ route('login.store') }}">@csrf
<div class="field"><label>Email</label><input type="email" name="email" value="{{ old('email') }}" required autofocus></div>
<div class="field"><label>Kata sandi</label><input type="password" name="password" required></div>
<div class="field"><label><input type="checkbox" name="remember" value="1" style="width:auto"> Ingat saya</label></div><button class="btn" style="width:100%">Masuk</button></form><p class="muted">Belum punya akun? <a style="color:var(--teal);font-weight:700" href="{{ route('register') }}">Daftar sekarang</a></p></div>
@endsection
