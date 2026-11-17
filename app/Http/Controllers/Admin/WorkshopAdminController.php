<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Workshop;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WorkshopAdminController extends Controller
{
 public function index(){ $workshops=Workshop::withCount('registrations')->latest()->paginate(12); return view('admin.workshops.index',compact('workshops')); }
 public function create(){ $workshop=new Workshop(); return view('admin.workshops.form',compact('workshop')); }
 public function store(Request $request){
  $data=$this->validated($request); $data['slug']=Str::slug($data['title']).'-'.Str::lower(Str::random(4));
  Workshop::create($data); return redirect()->route('admin.workshops.index')->with('success','Workshop berhasil ditambahkan.');
 }
 public function edit(Workshop $workshop){ return view('admin.workshops.form',compact('workshop')); }
 public function update(Request $request, Workshop $workshop){
  $data=$this->validated($request); if ($workshop->title !== $data['title']) $data['slug']=Str::slug($data['title']).'-'.Str::lower(Str::random(4)); $workshop->update($data); return redirect()->route('admin.workshops.index')->with('success','Workshop berhasil diperbarui.');
 }
 public function destroy(Workshop $workshop){
  if($workshop->registrations()->exists()) return back()->with('error','Workshop tidak dapat dihapus karena sudah memiliki pendaftaran.');
  $workshop->delete(); return back()->with('success','Workshop berhasil dihapus.');
 }
 private function validated(Request $request): array {
  return $request->validate([
   'title'=>'required|string|max:150','description'=>'required|string','date'=>'required|date|after_or_equal:today',
   'start_time'=>'required','end_time'=>'required|after:start_time','location'=>'required|string|max:180',
   'price'=>'required|integer|min:0','quota'=>'required|integer|min:1','is_active'=>'nullable|boolean'
  ]) + ['is_active'=>$request->boolean('is_active')];
 }
}
