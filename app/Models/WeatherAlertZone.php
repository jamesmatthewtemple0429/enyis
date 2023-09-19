<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeatherAlertZone extends Model
{
    use HasFactory;

    public function wxZone() {
        return $this->hasOne(WeatherZone::class,"wx_id","zone");
    }
}
