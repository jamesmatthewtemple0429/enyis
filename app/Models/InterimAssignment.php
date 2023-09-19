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

    protected $with = ['member'];
    protected $appends = ['member_name','pretty_effective','pretty_expires'];

    public $fields = [
        ['key' => 'expires_at','display' => 'Expires At'],
        ['key' => 'effective_at', 'display' => 'Effective At'],
        ['key' => 'pretty_expires', 'display' => 'Expires At'],
        ['key' => 'pretty_effective','display' => 'Effective At'],
        ['key' => 'member_name', 'display' => 'Member Name'],
        ['key' => 'position', 'display' => 'Position'],
    ];
    public function getPrettyEffectiveAttribute() {
        return $this->effective_at->format('M d, Y h:i A');
    }

    public function getPrettyExpiresAttribute() {
        return $this->expires_at->format('M d, Y h:i A');
    }

    public function member() {
        return $this->hasOne(Member::class,"account_id","account_id");
    }

    public function getMemberNameAttribute() {
        return $this->member->name;
    }
}
