<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeatherForecast extends Model
{
    use HasFactory;

    protected $with = ['wxZone'];

    public function wxZone() {
        return $this->hasOne(WeatherZone::class,"wx_id","wx_id");
    }
}
