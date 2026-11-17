@extends('layouts.app') @section('title','Daftar Akun') @section('content')
<div class="panel form"><div class="eyebrow">Mulai belajar</div><h2 style="color:var(--navy)">Buat akun peserta</h2><form method="POST" action="{{ route('register.store') }}">@csrf
<div class="field"><label>Nama lengkap</label><input name="name" value="{{ old('name') }}" required maxlength="100"></div>
<div class="field"><label>Email</label><input type="email" name="email" value="{{ old('email') }}" required></div>
<div class="field"><label>Kata sandi</label><input type="password" name="password" required></div>
<div class="field"><label>Ulangi kata sandi</label><input type="password" name="password_confirmation" required></div><button class="btn" style="width:100%">Buat akun</button></form><p class="muted">Sudah punya akun? <a style="color:var(--teal);font-weight:700" href="{{ route('login') }}">Masuk</a></p></div>
@endsection
