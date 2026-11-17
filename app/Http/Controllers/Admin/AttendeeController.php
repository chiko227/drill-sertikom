<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;

class AttendeeController extends Controller
{
 public function index(Request $request){
  $registrations=Registration::query()->with(['user','workshop'])
   ->when($request->filled('q'),fn($q)=>$q->whereHas('user',fn($u)=>$u->where('name','like','%'.$request->q.'%')->orWhere('email','like','%'.$request->q.'%')))
   ->when($request->filled('status'),fn($q)=>$q->where('payment_status',$request->status))
   ->latest()->paginate(15)->withQueryString();
  return view('admin.attendees.index',compact('registrations'));
 }
}
