<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Workshop extends Model
{
    protected $fillable = ['title','slug','description','date','start_time','end_time','location','price','quota','is_active'];
    protected $casts = ['date'=>'date','price'=>'integer','quota'=>'integer','is_active'=>'boolean'];

    public function registrations(): HasMany { return $this->hasMany(Registration::class); }
    public function getAvailableQuotaAttribute(): int {
        return max(0, $this->quota - $this->registrations()->where('payment_status','paid')->count());
    }
}
