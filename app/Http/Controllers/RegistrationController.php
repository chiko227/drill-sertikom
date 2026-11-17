<?php
namespace App\Http\Controllers;
use App\Models\Workshop;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
 public function store(Request $request, Workshop $workshop){
  abort_unless($workshop->is_active,404);
  if($request->user()->registrations()->where('workshop_id',$workshop->id)->exists())
   return back()->with('error','Kamu sudah terdaftar pada workshop ini.');
  $paidCount=$workshop->registrations()->where('payment_status','paid')->count();
  if($paidCount >= $workshop->quota) return back()->with('error','Kuota workshop sudah penuh.');
  $registration=$request->user()->registrations()->create([
   'workshop_id'=>$workshop->id,'ticket_code'=>'WS-'.strtoupper(Str::random(8)),'payment_status'=>'pending'
  ]);
  return redirect()->route('payments.show',$registration)->with('success','Pendaftaran berhasil. Silakan lanjutkan pembayaran.');
 }
 public function myTickets(Request $request){
  $registrations=$request->user()->registrations()->with('workshop')->latest()->paginate(10);
  return view('tickets.index',compact('registrations'));
 }
 public function ticket(Request $request, $registration){
  $registration=$request->user()->registrations()->with('workshop')->findOrFail($registration);
  abort_unless($registration->payment_status==='paid',403);
  return view('tickets.show',compact('registration'));
 }
}
