<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    public $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime'
    ];

    protected $appends = ['date','starts','ends'];

    public $fields = [
        ['key' => 'account_id','display' => 'Account ID'],
        ['key' => 'date','display' => 'Date'],
        ['key' => 'starts','display' => 'Starts At'],
        ['key' => 'type','display' => 'Type'],

        ['key' => 'ends','display' => 'Ends At'],
    ];

    public function getDateAttribute() {
        return $this->starts_at->format('M d, Y');
    }

    public function getStartsAttribute() {
        return $this->starts_at->format('h:i A');
    }

    public function getEndsAttribute() {
        return $this->ends_at->format('h:i A');
    }


    public function member() {
        return $this->hasOne(Member::class, "account_id","account_id");
    }
}
