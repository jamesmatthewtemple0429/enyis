<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class County extends Model
{
    use HasFactory;

    protected $with = ['wxZones'];
    public $fields = [
        ['key' => 'name','display' => 'Name'],
        ['key' => 'territory', 'display' => 'Territory'],
        ['key' => 'chapter', 'display' => 'Chapter'],
    ];

    public function wxZones() {
        return $this->hasMany(WeatherZone::class, "county","name");
    }
}
