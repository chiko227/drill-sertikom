<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void { Schema::create('registrations', function(Blueprint $table){
  $table->id(); $table->foreignId('user_id')->constrained()->cascadeOnDelete();
  $table->foreignId('workshop_id')->constrained()->cascadeOnDelete();
  $table->string('ticket_code')->unique(); $table->string('payment_status')->default('pending');
  $table->string('midtrans_order_id')->nullable()->unique(); $table->string('snap_token')->nullable();
  $table->timestamp('paid_at')->nullable(); $table->timestamps();
  $table->unique(['user_id','workshop_id']);
 }); }
 public function down(): void { Schema::dropIfExists('registrations'); }
};
