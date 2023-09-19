<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RccEvent extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'address' => 'encrypted',
        'city'  => 'encrypted',
        'entered_at' => 'datetime',
        'location_name' => 'encrypted'
     ];

    public $fields = [
        ['key' => 'location_name','display' => 'Location'],
        ['key' => 'county','display' => 'County'],
        ['key' => 'type','display' => 'Event Type'],
        ['key' => 'total_cases','display' => 'Case Count'],
        ['key' => 'happened_at','display' => 'Happened At'],
        ['key' => 'entered_at','display' => 'Created At'],
        ['key' => 'total_disbursed','display' => 'Amount Disbursed'],
    ];

 //   protected $appends = ['total_cases','total_clients','total_disbursed'];

    public function getTotalCasesAttribute() {
        return $this->cases->count();
    }
    public function assignedCounty() {
        return $this->hasOne(County::class, "name", "county");
    }

    public function cases() {
        return $this->hasMany(RccCase::class, "event","name");
    }
}
