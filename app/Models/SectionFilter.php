<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionFilter extends Model
{
    use HasFactory;

    protected $appends = ['description'];
    public function getDescriptionAttribute() {
        $operator = $this->attributes['operator'];

        if($operator == 'lTime') {
            $operator = 'Less than current time';
        }

        if($operator == 'in') {
            $operator = 'IN';
        }

        if($operator == 'gTime') {
            $operator = 'Greater than current time';
        }

        return $this->attributes['name'] . " " .  $operator . " " . $this->attributes['value'];
    }
}
