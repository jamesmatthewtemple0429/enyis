<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterimAssignment extends Model
{
    use HasFactory;

    protected $casts = [
        'effective_at' => 'datetime',
        'expires_at' => 'datetime'
    ];

    protected $appends = ['pretty_effective','pretty_expires'];

    public function getPrettyEffectiveAttribute() {
        return $this->effective_at->format('M d, Y h:i A');
    }

    public function getPrettyExpiresAttribute() {
        return $this->expires_at->format('M d, Y h:i A');
    }

    public function member() {
        return $this->hasOne(Member::class,"account_id","account_id");
    }
}
