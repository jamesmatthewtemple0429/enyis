<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StateOfEmergency extends Model
{
    use HasFactory;

    protected $casts = ['effective_at' => 'datetime'];
    protected $appends = ['pretty_effective','county_list'];

    protected $with = ['counties'];

    public function getCountyListAttribute() {
        if($this->type == 1) return "STATE-WIDE";

        return $this->counties->pluck('name')->implode(", ");
    }

    public $fields = [
        ['key' => 'name','display' => 'Name'],
        ['key' => 'description','display' => 'Description'],
        ['key' => 'type', 'display' => 'Type'],
        ['key' => 'county_list','display' => 'Jurisdiction(s)'],
        ['key' => 'expires_at','display' => 'Expires At'],
        ['key' => 'effective_at','display' => 'Effective At'],
        ['key' => 'pretty_expires','display' => 'Expires At'],
        ['key' => 'pretty_effective','display' => 'Effective At'],

    ];

    public function getPrettyEffectiveAttribute() {
        if(is_null($this->effective_at)) return "";
        return $this->effective_at->format('M d, Y h:i A');
    }

    public function counties() {
        return $this->BelongsToMany(County::Class);
    }
}
