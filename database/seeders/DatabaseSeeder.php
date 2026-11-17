<?php
namespace Database\Seeders;
use App\Models\User;
use App\Models\Workshop;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
 public function run(): void {
  User::firstOrCreate(['email'=>'panitia@workshop.test'],['name'=>'Panitia Sekolah','password'=>Hash::make('password'),'role'=>'panitia']);
  $items=[
   ['title'=>'Web Development dengan Laravel','slug'=>'web-development-laravel','description'=>'Pelajari dasar pengembangan aplikasi web menggunakan Laravel, mulai dari routing, controller, database, hingga autentikasi.','date'=>now()->addDays(10)->toDateString(),'start_time'=>'09:00','end_time'=>'12:00','location'=>'Lab Komputer Sekolah','price'=>50000,'quota'=>30,'is_active'=>true],
   ['title'=>'UI/UX Design Fundamental','slug'=>'ui-ux-design-fundamental','description'=>'Workshop pengenalan proses desain produk digital, wireframe, prototyping, dan prinsip antarmuka yang mudah digunakan.','date'=>now()->addDays(14)->toDateString(),'start_time'=>'13:00','end_time'=>'16:00','location'=>'Ruang Multimedia','price'=>35000,'quota'=>25,'is_active'=>true],
   ['title'=>'Dasar Database MySQL','slug'=>'dasar-database-mysql','description'=>'Mengenal perancangan basis data relasional, query SQL, relasi tabel, dan praktik pengelolaan data.','date'=>now()->addDays(18)->toDateString(),'start_time'=>'09:00','end_time'=>'11:30','location'=>'Lab Komputer Sekolah','price'=>40000,'quota'=>30,'is_active'=>true],
  ];
  foreach($items as $item) Workshop::firstOrCreate(['slug'=>$item['slug']],$item);
 }
}
