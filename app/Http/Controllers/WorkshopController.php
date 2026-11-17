<?php
namespace App\Http\Controllers;
use App\Models\Workshop;
use Illuminate\Http\Request;

class WorkshopController extends Controller
{
 public function index(Request $request){
  $workshops=Workshop::query()->where('is_active',true)->withCount(['registrations as paid_count'=>fn($q)=>$q->where('payment_status','paid')])
   ->when($request->filled('q'),fn($q)=>$q->where('title','like','%'.$request->q.'%'))
   ->orderBy('date')->paginate(9)->withQueryString();
  return view('workshops.index',compact('workshops'));
 }
 public function show(Workshop $workshop){
  abort_unless($workshop->is_active,404);
  $registration=auth()->user()?->registrations()->where('workshop_id',$workshop->id)->first();
  return view('workshops.show',compact('workshop','registration'));
 }
}
