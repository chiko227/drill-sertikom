<?php
namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
 public function show(Request $request, Registration $registration){
  abort_unless($registration->user_id===$request->user()->id || $request->user()->isPanitia(),403);
  $registration->load('workshop','user');
  return view('payments.show',compact('registration'));
 }
 public function createSnapToken(Request $request, Registration $registration){
  abort_unless($registration->user_id===$request->user()->id,403);
  abort_if($registration->payment_status==='paid',409,'Pembayaran sudah lunas.');
  $serverKey=config('services.midtrans.server_key');
  if(!$serverKey) return back()->with('error','MIDTRANS_SERVER_KEY belum diatur pada file .env.');
  $orderId=$registration->midtrans_order_id ?: 'WORKSHOP-'.$registration->id.'-'.Str::upper(Str::random(6));
  $response=Http::withBasicAuth($serverKey,'')->acceptJson()->post(config('services.midtrans.snap_url'),[
   'transaction_details'=>['order_id'=>$orderId,'gross_amount'=>$registration->workshop->price],
   'customer_details'=>['first_name'=>$request->user()->name,'email'=>$request->user()->email],
   'item_details'=>[['id'=>(string)$registration->workshop_id,'price'=>$registration->workshop->price,'quantity'=>1,'name'=>$registration->workshop->title]],
  ]);
  if(!$response->successful()) return back()->with('error','Midtrans tidak dapat membuat transaksi. Periksa konfigurasi Sandbox.');
  $registration->update(['midtrans_order_id'=>$orderId,'snap_token'=>$response->json('token')]);
  return view('payments.checkout', ['registration'=>$registration->load('workshop'),'snapToken'=>$response->json('token'),'clientKey'=>config('services.midtrans.client_key')]);
 }
 public function notification(Request $request){
  $payload=$request->all(); $serverKey=config('services.midtrans.server_key');
  $expected=hash('sha512',($payload['order_id']??'').($payload['status_code']??'').($payload['gross_amount']??'').$serverKey);
  if(!hash_equals($expected,(string)($payload['signature_key']??''))) return response()->json(['message'=>'Invalid signature'],403);
  $registration=Registration::where('midtrans_order_id',$payload['order_id']??'')->first();
  if(!$registration) return response()->json(['message'=>'Order not found'],404);
  $status=$payload['transaction_status']??'';
  if(in_array($status,['settlement','capture'],true) && ($payload['fraud_status']??'accept')==='accept'){
   $registration->update(['payment_status'=>'paid','paid_at'=>now()]);
  } elseif(in_array($status,['expire','cancel','deny'],true)){
   $registration->update(['payment_status'=>'failed']);
  }
  return response()->json(['message'=>'Notification processed']);
 }
 public function simulate(Request $request, Registration $registration){
  abort_unless(app()->environment('local') && $registration->user_id===$request->user()->id,404);
  $registration->update(['payment_status'=>'paid','paid_at'=>now()]);
  return redirect()->route('tickets.show',$registration)->with('success','Pembayaran simulasi berhasil diverifikasi (mode lokal).');
 }
}
