<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RccCase extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'address' => 'encrypted',
        'unit'  => 'encrypted',
        'disaster_address' => 'encrypted',
        'city' => 'encrypted',
        'entered_at' => 'datetime'
    ];

    public $fields = [
        ['key' => 'entered_at','display' => 'Entered At'],
        ['key' => 'time','display' => 'Time'],
        ['key' => 'case_number','display' => 'Case Number'],

        ['key' => 'event_type','display' => 'Event Type'],
        ['key' => 'total_clients','display' => 'Total Clients'],
        ['key' => 'disaster_address','display' => 'Address'],
        ['key' => 'amount_disbursed','display' => 'Amount Disbursed'],

    ];

    public function getTimeAttribute() {
        return $this->entered_at->format('h:i A');
    }

    public function getEventTypeAttribute() {
        return optional($this->rccEvent)->type;
    }

    protected $appends = ['time','event_type'];

    protected $with = ['assignedCounty','rccEvent'];

    public function assignedCounty() {
        return $this->hasOne(County::class, "name", "county");
    }

    public function rccEvent() {
        return $this->hasOne(RccEvent::class, "name","event");
    }
}
