<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelEdict extends Model
{
    use HasFactory;

    protected $casts = ['effective_at' => 'datetime','expires_at' => 'datetime'];
    protected $appends = ['pretty_effective','county_list','type_text'];

    protected $with = ['counties'];

    public function getPrettyEffectiveAttribute() {
        if(is_null($this->effective_at)) return "";
        return $this->effective_at->format('M d, Y h:i A');
    }

    public function getPrettyExpiresAttribute() {
        if(is_null($this->expires_at)) return "";
        return $this->expires_at->format('M d, Y h:i A');
    }

    public function getCountyListAttribute() {
        if($this->sub_type == 1) return "STATE-WIDE";

        return $this->counties->pluck('name')->implode(", ");
    }

    public function getTypeTextAttribute() {
        switch($this->type) {
            case 1:
                return "Warning";
            case 2:
                return "Ban";
        }
    }

    public $fields = [
        ['key' => 'description','display' => 'Description'],
        ['key' => 'pretty_effective','display' => 'Effective At'],
        ['key' => 'effective_at', 'display' => 'Effective At'],
        ['key' => 'pretty_expires','display' => 'Expires At'],
        ['key' => 'expires_at', 'display' => 'Expires At'],
        ['key' => 'county_list','display' => 'Jurisdiction(s)'],
        ['key' => 'type_text','display' => 'Type'],

    ];

    public function counties() {
        return $this->BelongsToMany(County::Class);
    }
}
