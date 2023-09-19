<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeatherAlert extends Model
{
    use HasFactory;

    protected $with = ['alertZones'];

    protected $appends = ['zones','zones.wxZone'];

    protected $casts =[
        'expires_at' => 'datetime',
        'effective_at' => 'datetime'
    ];

    public function getZonesAttribute() {
        return $this->alertZones->map(function($zone) {
            return $zone->wxZone->name;
        })->unique()->implode(", ");
    }
    public function alertZones() {
        return $this->hasMany(WeatherAlertZone::class, "wx_id","wx_id");
    }
}
