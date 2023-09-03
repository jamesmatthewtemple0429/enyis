<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StateOfEmergency extends Model
{
    use HasFactory;

    protected $casts = ['effective_at' => 'datetime'];
    protected $appends = ['pretty_effective'];

    public function getPrettyEffectiveAttribute() {
        if(is_null($this->effective_at)) return "";
        return $this->effective_at->format('M d, Y h:i A');
    }

    public function counties() {
        return $this->BelongsToMany(County::Class);
    }
}
