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

}
