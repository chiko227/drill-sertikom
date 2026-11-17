<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registration extends Model
{
    protected $fillable = ['user_id','workshop_id','ticket_code','payment_status','midtrans_order_id','snap_token','paid_at'];
    protected $casts = ['paid_at'=>'datetime'];
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function workshop(): BelongsTo { return $this->belongsTo(Workshop::class); }
}
