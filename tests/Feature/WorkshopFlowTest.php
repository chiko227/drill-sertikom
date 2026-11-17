<?php
use App\Models\Registration;
use App\Models\User;
use App\Models\Workshop;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

uses(RefreshDatabase::class);

function makeWorkshopForTest(): Workshop {
 return Workshop::create([
  'title'=>'Workshop Laravel','slug'=>'workshop-laravel-'.Str::lower(Str::random(5)),
  'description'=>'Belajar Laravel','date'=>now()->addDays(5)->toDateString(),
  'start_time'=>'09:00','end_time'=>'12:00','location'=>'Lab Sekolah',
  'price'=>50000,'quota'=>10,'is_active'=>true,
 ]);
}

it('allows a participant to register once for a workshop', function () {
 $user=User::factory()->create(['role'=>'peserta']);
 $workshop=makeWorkshopForTest();
 $this->actingAs($user)->post(route('registrations.store',$workshop))->assertRedirect();
 expect(Registration::where('user_id',$user->id)->where('workshop_id',$workshop->id)->count())->toBe(1);
 $this->actingAs($user)->post(route('registrations.store',$workshop))->assertRedirect();
 expect(Registration::where('user_id',$user->id)->where('workshop_id',$workshop->id)->count())->toBe(1);
});

it('does not allow a participant to open an unpaid ticket', function () {
 $user=User::factory()->create(['role'=>'peserta']);
 $workshop=makeWorkshopForTest();
 $registration=Registration::create(['user_id'=>$user->id,'workshop_id'=>$workshop->id,'ticket_code'=>'WS-TEST1234','payment_status'=>'pending']);
 $this->actingAs($user)->get(route('tickets.show',$registration))->assertForbidden();
});

it('allows a participant to view a ticket after payment is verified', function () {
 $user=User::factory()->create(['role'=>'peserta']);
 $workshop=makeWorkshopForTest();
 $registration=Registration::create(['user_id'=>$user->id,'workshop_id'=>$workshop->id,'ticket_code'=>'WS-PAID1234','payment_status'=>'paid','paid_at'=>now()]);
 $this->actingAs($user)->get(route('tickets.show',$registration))->assertOk()->assertSee('WS-PAID1234');
});

it('restricts panitia pages to panitia accounts', function () {
 $user=User::factory()->create(['role'=>'peserta']);
 $this->actingAs($user)->get(route('admin.workshops.index'))->assertForbidden();
});
