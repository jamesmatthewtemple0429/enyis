<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemIssue extends Model
{
    use HasFactory;

    protected $appends = ['pretty_date'];

    public function getPrettyDateAttribute() {
        return $this->created_at->format('M d, Y h:i A');
    }
}
