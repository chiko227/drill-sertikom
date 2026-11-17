<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void { Schema::create('workshops', function(Blueprint $table){
  $table->id(); $table->string('title'); $table->string('slug')->unique(); $table->text('description');
  $table->date('date'); $table->time('start_time'); $table->time('end_time'); $table->string('location');
  $table->unsignedInteger('price'); $table->unsignedInteger('quota')->default(30); $table->boolean('is_active')->default(true);
  $table->timestamps();
 }); }
 public function down(): void { Schema::dropIfExists('workshops'); }
};
