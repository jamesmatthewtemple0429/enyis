<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $appends = ['pretty_expires'];
    protected $casts = ['expires_at' => 'datetime'];
    public function getPrettyExpiresAttribute() {
        return $this->expires_at->format('M d, Y h:i A');
    }

    public $fields = [
        ['key' => 'audience','display' => 'Audience'],
        ['key' => 'message', 'display' => 'Message'],
        ['key' => 'pretty_expires', 'display' => 'Expires At'],
        ['key' => 'expires_at', 'display' => 'Expires At'],
    ];

}
