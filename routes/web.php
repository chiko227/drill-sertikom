<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WorkshopController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\WorkshopAdminController;
use App\Http\Controllers\Admin\AttendeeController;

Route::get('/', fn()=>redirect()->route('workshops.index'));
Route::middleware('guest')->group(function(){
 Route::get('/login',[AuthController::class,'showLogin'])->name('login');
 Route::post('/login',[AuthController::class,'login'])->name('login.store');
 Route::get('/register',[AuthController::class,'showRegister'])->name('register');
 Route::post('/register',[AuthController::class,'register'])->name('register.store');
});
Route::post('/logout',[AuthController::class,'logout'])->middleware('auth')->name('logout');
Route::get('/workshops',[WorkshopController::class,'index'])->name('workshops.index');
Route::get('/workshops/{workshop:slug}',[WorkshopController::class,'show'])->name('workshops.show');
Route::middleware('auth')->group(function(){
 Route::post('/workshops/{workshop}/register',[RegistrationController::class,'store'])->name('registrations.store');
 Route::get('/my-tickets',[RegistrationController::class,'myTickets'])->name('tickets.index');
 Route::get('/my-tickets/{registration}',[RegistrationController::class,'ticket'])->name('tickets.show');
 Route::get('/payments/{registration}',[PaymentController::class,'show'])->name('payments.show');
 Route::post('/payments/{registration}/checkout',[PaymentController::class,'createSnapToken'])->name('payments.checkout');
 Route::post('/payments/{registration}/simulate',[PaymentController::class,'simulate'])->name('payments.simulate');
});
Route::post('/payments/midtrans/notification',[PaymentController::class,'notification'])->name('payments.notification');
Route::prefix('panitia')->name('admin.')->middleware(['auth','panitia'])->group(function(){
 Route::get('/workshops',[WorkshopAdminController::class,'index'])->name('workshops.index');
 Route::get('/workshops/create',[WorkshopAdminController::class,'create'])->name('workshops.create');
 Route::post('/workshops',[WorkshopAdminController::class,'store'])->name('workshops.store');
 Route::get('/workshops/{workshop}/edit',[WorkshopAdminController::class,'edit'])->name('workshops.edit');
 Route::put('/workshops/{workshop}',[WorkshopAdminController::class,'update'])->name('workshops.update');
 Route::delete('/workshops/{workshop}',[WorkshopAdminController::class,'destroy'])->name('workshops.destroy');
 Route::get('/peserta',[AttendeeController::class,'index'])->name('attendees.index');
});
