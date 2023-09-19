<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemIssue extends Model
{
    use HasFactory;

    protected $appends = ['pretty_date'];

    public $fields = [
        ['key' => 'reported_at','display' => 'Reported At'],
        ['key' => 'pretty_date','display' => 'Reported At'],
        ['key' => 'application','display' => 'Application'],
        ['key' => 'description','display' => 'Description'],
    ];
    public function getPrettyDateAttribute() {
        return $this->created_at->format('M d, Y h:i A');
    }
}
