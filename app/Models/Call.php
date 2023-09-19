<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'address' => 'encrypted',
        'city' => 'encrypted',
        'happened_at'       => 'datetime',
        'acknowledged_at'       => 'datetime',
        'assigned_at'       => 'datetime',
        'on_scene_at'       => 'datetime',
        'off_scene_at'       => 'datetime',
    ];

    public $fields = [
        ['key' => 'do_name','display' => 'Duty Officer'],
        ['key' => 'do_phone','display' => 'Duty Officer Phone'],
        ['key' => 'call_id','display' => 'Call ID'],
        ['key' => 'pretty_acknowledged','display' => 'Acknowledged At'],
        ['key' => 'acknowledged_at','display' => 'Acknowledged At'],
        ['key' => 'status','display' => 'Request Status'],
        ['key' => 'event_type','display' => 'Event Type'],
        ['key' => 'disaster_address','display' => 'Address'],
        ['key' => 'time','display' => 'Time'],
    ];

    protected $appends = ['time','do_name','do_phone','pretty_acknowledged'];

    public function getTimeAttribute() {
        return $this->acknowledged_at->format('h:i A');
    }

    protected $with = ['duty_officer'];
    public function getDoNameAttribute()
    {
        return optional($this->duty_officer)->name;
    }
    public function getPrettyAcknowledgedAttribute() {
        return $this->acknowledged_at->format('M d, Y h:i A');
    }
    public function getDoPhoneAttribute()
    {
        return optional($this->duty_officer)->cell_phone;
    }

    public function duty_officer()
    {
        return $this->hasOne(Member::class, "account_name","do");
    }

}
