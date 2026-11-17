<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
 public function showLogin(){ return view('auth.login'); }
 public function login(Request $request){
  $credentials=$request->validate(['email'=>'required|email','password'=>'required|string']);
  if(!Auth::attempt($credentials,$request->boolean('remember'))) return back()->withErrors(['email'=>'Email atau kata sandi tidak sesuai.'])->onlyInput('email');
  $request->session()->regenerate(); return redirect()->intended(route('workshops.index'));
 }
 public function showRegister(){ return view('auth.register'); }
public function register(Request $request)
{
    $data = $request->validate([
        'name' => 'required|string|max:100',
        'email' => 'required|email|max:255|unique:users,email',
        'password' => 'required|confirmed|min:8',
    ], [
        'name.required' => 'Nama lengkap wajib diisi.',
        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.unique' => 'Email sudah terdaftar.',
        'password.required' => 'Password wajib diisi.',
        'password.min' => 'Password minimal 8 karakter.',
        'password.confirmed' => 'Konfirmasi password tidak cocok.',
    ]);

    $user = User::create([
        ...$data,
        'role' => 'peserta'
    ]);

    Auth::login($user);
    $request->session()->regenerate();

    return redirect()->route('workshops.index')
        ->with('success', 'Akun berhasil dibuat.');
}
 public function logout(Request $request){ Auth::logout(); $request->session()->invalidate(); $request->session()->regenerateToken(); return redirect()->route('login'); }
}
